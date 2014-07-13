<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends GEH_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array(
            'user_account_model'
        ));

        // Prevent user access into user management
        $user_info = $this->get_user_logged_in_info();
        if($user_info != NULL and $user_info['user_group'] != USER_GROUP_ROOT_ADMIN and
            $this->router->method != 'logout' and $this->router->method != 'login') {
            redirect(home_url());
        }
    }

    public $user_view = 'user/';

    public function index()
    {
        $user_list = $this->user_account_model->get_list();
        $data['user_list'] = $this->prepare_user_data($user_list);

        $extend_data['content_view'] = $this->load->view($this->user_view . 'index', $data, TRUE);
        $this->load_frontend_template($extend_data, 'USER ACCOUNT MANAGEMENT');
    }

    public function prepare_user_data($data)
    {
        foreach($data as &$item) {
            if($item['is_active'] == USER_STATUS_ACTIVE)
                $item['is_active'] = 'Active';
            else if($item['is_active'] == USER_STATUS_INACTIVE)
                $item['is_active'] = 'Inactive';

            $item['created_date'] = date("Y-m-d H:i:s", $item['created_date']);
        }

        return $data;
    }

    public function modify()
    {
        $data['user_group_list'] = array(
            0 => array(
                'group_name' => 'Buildings owner',
                'group_id' => USER_GROUP_BUILDINGS_OWNER
            ),
            1 => array(
                'group_name' => 'Rooms admin',
                'group_id' => USER_GROUP_ROOMS_ADMIN
            ),
        );

        // Case: edit user
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];

            // Have post to update to database
            if ($this->input->post()) {
                // Check username exist or not
                $username = trim($this->input->post('geh_login_name'));
                $this->check_username($username, $user_id);

                // Check email exist or not
                $email = trim($this->input->post('geh_message'));
                $this->check_email($email, $user_id);

                $edited_user_info = $this->user_account_model->get_by_id($user_id);

                if($edited_user_info['user_group'] != USER_GROUP_ROOT_ADMIN) {
                    $user_group = $this->input->post('user_group');

                    // Delete all related user privileges before change user's group
                    if($edited_user_info['user_group'] != $user_group) {
                        $this->load->model('user_privileges_model');
                        $privileges = $this->user_privileges_model->get_by_account($edited_user_info['user_group'], $user_id);

                        if(count($privileges) > 0) {
                            foreach($privileges as $item) {
                                $this->user_privileges_model->delete($item['privilege_id']);
                            }
                        }
                    }

                    $update_data = array(
                        'username' => $username,
                        'email' => $email,
                        'user_group' => $user_group,
                        'is_active' => $this->input->post('user_status')
                    );
                }
                else {
                    $update_data = array(
                        'username' => $username,
                        'email' => $email
                    );
                }

                if($this->input->post('password') != "") {
                    $update_data = $update_data + array('password' => md5(trim($this->input->post('password'))));
                }

                if($this->user_account_model->update($user_id, $update_data)) {
                    $this->session->set_flashdata($this->flash_success_session, 'Edit user information successful!');
                    redirect(user_account_controller_url());
                }
            }

            $data['user_info'] = $this->user_account_model->get_by_id($user_id);
            $extend_data['content_view'] = $this->load->view($this->user_view . 'edit_user', $data, TRUE);
            $this->load_frontend_template($extend_data, 'EDIT USER INFORMATION');
        }

        // Case: add new user
        else {
            if($this->input->post()) {
                // Check username exist or not
                $username = trim($this->input->post('geh_login_name'));
                $this->check_username($username);

                // Check email exist or not
                $email = trim($this->input->post('geh_message'));
                $this->check_email($email);

                $insert_data = array(
                    'username' => $username,
                    'email' => $email,
                    'user_group' => $this->input->post('user_group'),
                    'is_active' => $this->input->post('user_status'),
                    'password' => md5(trim($this->input->post('password'))),
                    'created_date' => time()
                );

                if($this->user_account_model->insert($insert_data)) {
                    $this->session->set_flashdata($this->flash_success_session, 'Add new user successful!');
                    redirect(user_account_controller_url());
                }
            }

            $extend_data['content_view'] = $this->load->view($this->user_view . 'add_user', $data, TRUE);
            $this->load_frontend_template($extend_data, 'ADD NEW USER');
        }
    }

    private function check_username($username, $user_id = NULL)
    {
        $result = $this->user_account_model->get_by_username($username);
        $err_message = 'Username already exist.';

        if($user_id != NULL) {
            if(count($result) > 0 and $result['id'] != $user_id) {
                $this->session->set_flashdata($this->flash_warning_session, $err_message);
                redirect(edit_user_url($user_id));
            }
        }
        else {
            if(count($result) > 0) {
                $this->session->set_flashdata($this->flash_warning_session, $err_message);
                redirect(add_new_user_url());
            }
        }
    }

    private function check_email($email, $user_id = NULL)
    {
        $result = $this->user_account_model->get_by_email($email);
        $err_message = 'Email address already exist.';

        if($user_id != NULL) {
            if(count($result) > 0 and $result['id'] != $user_id) {
                $this->session->set_flashdata($this->flash_warning_session, $err_message);
                redirect(edit_user_url($user_id));
            }
        }
        else {
            if(count($result) > 0) {
                $this->session->set_flashdata($this->flash_warning_session, $err_message);
                redirect(add_new_user_url());
            }
        }

    }

    public function privileges()
    {
        if(isset($_GET['id']) or isset($_GET['floor'])) {
            $this->load->model(array(
                'user_privileges_model',
                'building_model'
            ));
            $user_id = $_GET['id'];
            $user_info = $this->user_account_model->get_by_id($user_id);
            $data['buildings_list'] = $this->building_model->get_list();

            if($user_info['user_group'] == USER_GROUP_BUILDINGS_OWNER) {
                $privileges = $this->user_privileges_model->get_by_account(USER_GROUP_BUILDINGS_OWNER, $user_id);
                $data['privileges'] = $privileges;

                if($this->input->post()) {
                    $checked_buildings = $this->input->post('arr_building');

                    if(count($checked_buildings) == count($privileges)) {
                        $count = 0;
                        foreach($privileges as $privilege) {
                            $update_data = array(
                                'building_id' => $checked_buildings[$count]
                            );
                            $this->user_privileges_model->update($privilege['privilege_id'], $update_data);
                            $count++;
                        }
                    }
                    // Delete all record and insert new ones
                    else {
                        // Delete all record
                        foreach($privileges as $privilege) {
                            $this->user_privileges_model->delete($privilege['privilege_id']);
                        }

                        // Insert new privileges
                        foreach($checked_buildings as $checked) {
                            $insert_data = array(
                                'user_account' => $user_info['id'],
                                'building_id' => $checked
                            );
                            $this->user_privileges_model->insert($insert_data);
                        }
                    }

                    $this->session->set_flashdata($this->flash_success_session, 'Edit user privileges successful!');
                    redirect(user_account_controller_url());
                }

                $extend_data['content_view'] = $this->load->view(
                    $this->user_view . 'edit_privileges_buildings_owner', $data, TRUE
                );
            }
            else if($user_info['user_group'] == USER_GROUP_ROOMS_ADMIN) {
                $privileges = $this->user_privileges_model->get_by_account(USER_GROUP_ROOMS_ADMIN, $user_id);
                $data['privileges'] = $privileges;

                // When filter button submitted
                if(isset($_GET['building'])) {
                    $building_id = $_GET['building'];
                    $this->load->model(array(
                        'floor_model',
                        'zone_model',
                        'room_model'
                    ));

                    $floors_list = $this->floor_model->get_by_building_id($building_id);
                    $zones_array = array();
                    $rooms_array = array();

                    foreach($floors_list as $floor) {
                        $zones_list = $this->zone_model->get_by_floor_id($floor['floor_id']);
                        foreach($zones_list as $zone) {
                            array_push($zones_array, array(
                                'floor_id' => $floor['floor_id'],
                                'zone_id' => $zone['zone_id'],
                                'zone_name' => $zone['zone_name']
                            ));
                        }

                        foreach($zones_list as $item) {
                            $rooms_list = $this->room_model->get_by_zone_id($item['zone_id']);
                            foreach($rooms_list as $room) {
                                array_push($rooms_array, array(
                                    'zone_id' => $item['zone_id'],
                                    'room_id' => $room['room_id'],
                                    'room_name' => $room['room_name']
                                ));
                            }
                        }
                    }

                    $data['floors_list'] = $floors_list;
                    $data['zones_list'] = $zones_array;
                    $data['rooms_list'] = $rooms_array;

                    // When save changes button submitted
                    if($this->input->post()) {
                        $checked_rooms = $this->input->post('arr_room');

                        if(count($checked_rooms) == count($privileges)) {
                            $count = 0;
                            foreach($privileges as $privilege) {
                                $update_data = array(
                                    'room_id' => $checked_rooms[$count]
                                );
                                $this->user_privileges_model->update($privilege['privilege_id'], $update_data);
                                $count++;
                            }
                        }
                        // Delete all record and insert new ones
                        else {
                            // Delete all record
                            foreach($privileges as $privilege) {
                                $this->user_privileges_model->delete($privilege['privilege_id']);
                            }

                            // Insert new privileges
                            foreach($checked_rooms as $checked) {
                                $insert_data = array(
                                    'user_account' => $user_info['id'],
                                    'room_id' => $checked
                                );
                                $this->user_privileges_model->insert($insert_data);
                            }
                        }

                        $this->session->set_flashdata($this->flash_success_session, 'Edit user privileges successful!');
                        redirect(user_account_controller_url());
                    }
                }

                $extend_data['content_view'] = $this->load->view(
                    $this->user_view . 'edit_privileges_rooms_admin', $data, TRUE
                );
            }

            $this->load_frontend_template($extend_data, 'MANAGE USER PRIVILEGES');
        }
        else {
            redirect(user_account_controller_url());
        }
    }

    public function delete()
    {
        if ($this->input->get('id')) {
            $user_id = $this->input->get('id');
            $update_data = array(
                'is_delete' => USER_IS_DELETE_TRUE
            );

            // Delete action after delete all its condition
            if ($this->user_account_model->update($user_id, $update_data)) {
                $this->session->set_flashdata($this->flash_success_session, 'User has been delete successful!');
                redirect(user_account_controller_url());
            }
        }
    }

    public function login()
    {
        $err_flag = FALSE;

        if($this->input->post()) {
            $username = trim($this->input->post('username'));
            $password = md5(trim($this->input->post('password')));
            $account = $this->user_account_model->get_by_account($username, $password);

            if($account) {
                if($account['is_active'] == USER_STATUS_INACTIVE) {
                    $err_flag = TRUE;
                    $data['err_message'] = 'Your account is not active yet.';
                }
                else {
                    $this->load->model(array(
                        'user_privileges_model',
                        'building_model'
                    ));
                    $buildings_list = array();

                    $privileges = $this->user_privileges_model->get_by_account($account['user_group'], $account['id']);
                    foreach($privileges as $privilege) {
                        $result = $this->building_model->get_by_id($privilege['building_id']);
                        array_push($buildings_list, $result);
                    }

                    // If user own 1 building, set it to user session, redirect to home
                    // If user own more than 1 building, redirect to select building page
                    if(count($buildings_list) == 1 and $account['user_group'] == USER_GROUP_BUILDINGS_OWNER){
                        $account['working_building'] = $buildings_list[0]['id'];
                        $url = home_url();
                    }
                    else if(count($buildings_list) > 1 and $account['user_group'] == USER_GROUP_BUILDINGS_OWNER) {
                        $account['working_building'] = $buildings_list[0]['id'];
                        $url = select_building_url();
                    }
                    else {
                        $url = home_url();
                    }

                    $this->set_user_session($account);
                    redirect($url);
                }
            }
            else {
                $err_flag = TRUE;
                $data['err_message'] = 'Username or password is not valid.';
            }
        }

        if(!$err_flag) {
            $this->load->view($this->user_view . 'login');
        }
        else {
            $this->load->view($this->user_view . 'login', $data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(user_login_url());
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
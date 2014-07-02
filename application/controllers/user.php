<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends GEH_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array(
            'user_account_model'
        ));
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
                $item['is_active'] = 'Acitve';
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
                $update_data = array(
                    'username' => trim($this->input->post('username')),
                    'email' => trim($this->input->post('email')),
                    'user_group' => $this->input->post('user_group'),
                    'is_active' => $this->input->post('user_status'),
                );
                if($this->input->post('password') != "") {
                    $update_data = $update_data + array('password' => md5(trim($this->input->post('password'))));
                }

                if($this->user_account_model->update($user_id, $update_data)) {
                    // Update new user info to user session
                    $user_info = $this->user_account_model->get_by_id($user_id);
                    $this->set_user_session($user_info);

                    $this->session->set_flashdata('flash_success', 'Edit user information successful!');
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
                $insert_data = array(

                );

                if($this->device_model->insert($insert_data)) {
                    $this->session->set_flashdata('flash_success', 'Add new user successful!');
                    redirect(user_account_controller_url());
                }
            }

            $extend_data['content_view'] = $this->load->view($this->user_view . 'add_user', $data, TRUE);
            $this->load_frontend_template($extend_data, 'ADD NEW USER');
        }
    }

    public function privileges()
    {
        if(isset($_GET['id'])) {
            $this->load->model(array(
                'user_privileges_model'
            ));
            $user_id = $_GET['id'];
            $user_info = $this->user_account_model->get_by_id($user_id);

            if($user_info['user_group'] == USER_GROUP_BUILDINGS_OWNER) {
                $data['privileges'] = $this->user_privileges_model->get_by_account(USER_GROUP_BUILDINGS_OWNER, $user_id);
                var_dump($data['privileges']); die();

                $extend_data['content_view'] = $this->load->view(
                    $this->user_view . 'edit_privileges_buildings_owner', $data, TRUE
                );
            }
            else if($user_info['user_group'] == USER_GROUP_ROOMS_ADMIN) {
                $data['privileges'] = $this->user_privileges_model->get_by_account(USER_GROUP_ROOMS_ADMIN, $user_id);
                var_dump($data['privileges']); die();

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
                    $this->set_user_session($account);
                    redirect(home_url());
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
        $this->session->unset_userdata(USER_SESSION_NAME);
        redirect(user_login_url());
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
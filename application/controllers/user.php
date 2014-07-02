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
        $data = array();
        $extend_data['content_view'] = $this->load->view($this->user_view . 'index', $data, TRUE);
        $this->load_frontend_template($extend_data, 'USER ACCOUNT MANAGEMENT');
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
                    $user_data = array(
                        'user_id' => $account['id'],
                        'user_email' => $account['email'],
                        'user_group' => $account['user_group'],
                        'username' => $account['username']
                    );

                    $this->session->set_userdata(USER_SESSION_NAME, $user_data);
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
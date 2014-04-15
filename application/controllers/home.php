<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $this->load->model('floor_model');
        $data['floor_list'] = $this->floor_model->get_list();
        $extend_data['content_view'] = $this->load->view('home', $data, TRUE);

        $this->load_frontend_template($extend_data, 'HOMEPAGE');
	}

    public function test()
    {
        print_r('?12345678&123456?87654321&654321');

    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
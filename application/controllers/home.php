<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view('home', $data, TRUE);

        $this->load_frontend_template($extend_data, 'HOMEPAGE');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
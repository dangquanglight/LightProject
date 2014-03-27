<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Static_page extends GEH_Controller {

    function __construct() {
        parent::__construct();
    }

    public $static_page_view = 'static_page/';

    public function document_viewer()
    {
        $data = new ArrayObject();
        $extend_data['content_view'] = $this->load->view($this->static_page_view . 'document_viewer', $data, TRUE);

        $this->load_frontend_template($extend_data, 'DOCUMENT VIEWER');
    }
}

/* End of file static_page.php */
/* Location: ./application/controllers/static_page.php */
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

    public function select_building()
    {
        $buildings_list = $this->get_buildings_list_by_privileges();

        if(count($buildings_list) > 1) {
            if($this->input->post()) { //var_dump($this->input->post()); die();
                $user_info = $this->get_user_logged_in_info();
                $user_info['working_building'] = $this->input->post('building_id');

                $this->update_user_session($user_info);

                $data['message'] = 'You are working with ' . $this->input->post('selected_building_name') . ' now.';
            }

            $data['buildings_list'] = $buildings_list;
            $data['user_info'] = $this->get_user_logged_in_info();
        }
        else {
            $data['message'] = 'You just own 1 building. So you do not need to choose a building to working with.';
        }

        $extend_data['content_view'] = $this->load->view($this->static_page_view . 'select_building', $data, TRUE);
        $this->load_frontend_template($extend_data, 'SELECT BUILDING WORKING WITH');
    }

}

/* End of file static_page.php */
/* Location: ./application/controllers/static_page.php */
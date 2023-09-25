<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['comp_css'] = load_comp_css([
            base_url('assets/back/vendor/css/daterangepicker.css'), 
            
        ]);
        $data['vendor_js'] = load_comp_js([
            base_url('assets/back/vendor/js/moment.min.js'),
            base_url('assets/back/vendor/js/daterangepicker.js'),
            
        ]);
        $data['identity'] = $this->identity->getIdentity();
        $this->template->set('title', 'Dashboard - ' . $data['identity']['company']);
        $this->template->load('back/template', 'back/dashboard', $data);
    }
}

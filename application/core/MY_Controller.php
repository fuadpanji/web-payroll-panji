<?php
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        auth_check();

        // Is Admin
        if (in_array($this->uri->segment(2), ['employee', 'attendance', 'settings']) && !is_admin()) {
            $this->forbidden_access();
        }

        $this->general_settings = $this->identity->getIdentity();
        date_default_timezone_set('Asia/Jakarta'); // Timezone
    }

    public function forbidden_access()
    {
        $this->session->set_flashdata('dashboard', get_alert('warning', "Halaman yang Anda tuju tidak dapat diakses dengan role Anda!"));
        redirect('/back/dashboard');
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
    }

    public function index()
    {
        if(!is_admin()) redirect('/back/dashboard');
        $css_files = [
            base_url("assets/back/vendor/libs/select2/select2.css"),
            base_url("assets/back/vendor/libs/dropzone/dropzone.css"),
        ];

        $js_files_vendor = [
            base_url("assets/back/vendor/libs/select2/select2.js"),
            base_url("assets/back/vendor/libs/dropzone/dropzone.js"),
        ];

        $js_files_page = [
            base_url('assets/back/js/pages/settings.js'),
        ];

        $data['comp_css'] = load_comp_css($css_files);
        $data['vendor_js'] = load_comp_js($js_files_vendor);
        $data['page_js'] = load_comp_js($js_files_page);

        $data['identity'] = $this->identity->getIdentity();
        $this->template->set('title', 'Pengaturan Sistem - ' . $data['identity']['company']);
        $this->template->load('back/template', 'back/settings/form_update', $data);
    }

    public function update_settings()
    {
        if ($this->input->is_ajax_request()) {
            $token = $this->security->get_csrf_hash();

            $id = $this->input->post('id', true);
            $setting = $this->identity->getIdentity();

            $this->form_validation->set_rules('company', 'Nama Instansi', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('signin_time', 'Jam Masuk Kerja', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('signout_time', 'Jam Pulang Kerja', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('fixed_incentives', 'Insentif', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('additional_incetives', 'Penambah Insentif', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('annual_working_hours', 'Pembagi Upah Lembur', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('NWNP_deduction', 'Pembagi NWNP', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('BPJS_deduction', 'Pembagi BPJS', 'trim|min_length[1]|max_length[255]|xss_clean');

            if ($this->form_validation->run()) {
                $uploadFavicon = $_FILES['favicon']['name']; // Upload Favicon
                $path = 'data/logo/';
                $attachment = array();
                if ($uploadFavicon) {
                    array_push($attachment, uploadAssetData('favicon', 'favicon', $path)); //param = form input name, path to upload
                    if (!$attachment[0]['status']) { //failed upload
                        $res = [
                            'status' => false,
                            'message' => ['title' => "Gagal upload favicon!", 'text' => $attachment[0]['data']],
                            'token' => $token,
                            'attachment' => '<small class="text-danger ps-2" style="font-size: 13px">' . $attachment[0]['data'] . '</small>',
                        ];
                        echo json_encode($res);
                        exit();
                        // if file uploaded
                    } else { //update to db
                        $oldImage = $setting['favicon'];
                        if ($oldImage != "") {
                            deleteAssetData($oldImage, $path);
                        }
                        $this->db->update('settings', ['favicon' => $attachment[0]['data']], ['id' => $id]);
                    }
                }

                $uploadLogo1 = $_FILES['logo1']['name']; // Upload Logo 1
                $attachment = array();
                if ($uploadLogo1) {
                    // }
                    array_push($attachment, uploadAssetData('logo1', 'sidebar', $path)); // param = form input name, path to upload
                    if (!$attachment[0]['status']) { //failed upload
                        $res = [
                            'status' => false,
                            'message' => ['title' => "Gagal upload logo!", 'text' => $attachment[0]['data']],
                            'token' => $token,
                            'attachment' => '<small class="text-danger ps-2" style="font-size: 13px">' . $attachment[0]['data'] . '</small>',
                        ];
                        echo json_encode($res);
                        exit();
                    } else { //update to db
                        // if file uploaded
                        $oldImage = $setting['sidebar'];
                        if ($oldImage != "") deleteAssetData($oldImage, $path);
                        $this->db->update('settings', ['sidebar' => $attachment[0]['data']], ['id' => $id]);
                    }
                }

                $insert = $this->identity->updateSettings($id); // Update data to database
                echo json_encode(["status" => true, 'message' => ['title' => 'Ubah Data Berhasil!', 'text' => 'Pengaturan telah berhasil diubah!'], 'token' => $token]);
            } else {
                $res = [
                    'status' => false,
                    'message' => ['title' => "Ubah Pengaturan Gagal!", 'text' => validation_errors()],
                    'token' => $token,
                    'company' => form_error('company', form_err_style()[0], form_err_style()[1]),
                    'signin_time' => form_error('signin_time', form_err_style()[0], form_err_style()[1]),
                    'signout_time' => form_error('signout_time', form_err_style()[0], form_err_style()[1]),
                    'fixed_incentives' => form_error('fixed_incentives', form_err_style()[0], form_err_style()[1]),
                    'additional_incetives' => form_error('additional_incetives', form_err_style()[0], form_err_style()[1]),
                    'annual_working_hours' => form_error('annual_working_hours', form_err_style()[0], form_err_style()[1]),
                    'NWNP_deduction' => form_error('NWNP_deduction', form_err_style()[0], form_err_style()[1]),
                    'BPJS_deduction' => form_error('BPJS_deduction', form_err_style()[0], form_err_style()[1]),
                ];
                echo json_encode($res);
            }
        } else {
            redirect(base_url('back/settings'));
        }
    }
}

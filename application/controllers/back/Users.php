<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
{
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->load->model('Users_model', 'users');
    }

    // ----------------------------
    // -- Start - Users --
    // ----------------------------
    public function index()
    {
        if(!is_admin()) redirect('/back/dashboard');
        $data['comp_css'] = get_datatable()['css'] . load_comp_css([base_url("assets/back/vendor/libs/select2/select2.css"), base_url("assets/back/vendor/libs/dropzone/dropzone.css")]);
        $data['vendor_js'] = get_datatable()['js'] . get_datatable()['vendor'] . load_comp_js([base_url("assets/back/vendor/libs/select2/select2.js"), base_url("assets/back/vendor/libs/dropzone/dropzone.js")]);
        $data['page_js'] = load_comp_js([base_url('assets/back/js/pages/users.js')]);
        $data['role'] = ['staff', 'supervisor', 'admin'];
        $data['identity'] = $this->identity->getIdentity();
        $this->template->set('title', 'Data Pengguna - ' . $data['identity']['company']);
        $this->template->load('back/template', 'back/users/data_table', $data);
    }

    public function datatable_users()
    {
        if ($this->input->is_ajax_request()) {
            $list = $this->users->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $x) {
                $no++;
                $row = array();
                $row[] = $x->id_user;
                $row[] = $no;
                $name = $x->username;
                $stateNum = rand(0, 5);
                $states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
                $state = $states[$stateNum];
                $initials = get_initials($name);
                $result = '<span class="avatar-initial rounded-circle bg-label-' . $state . '">' . $initials . '</span>';
                    // $row[] = $result;
                $row_output =
                    "<div class='d-flex justify-content-start align-items-center user-name'>
                    <div class='avatar-wrapper'>
                        <div class='avatar me-2'>
                            <a href='javascript:void(0)'>{$result}</a>
                        </div>
                    </div>
                  <div class='d-flex flex-column'>
                    <span class='emp_name text-truncate'>
                        <a href='javascript:void(0)'>{$name}</a>
                    </span>
                  </div>
                 </div>";
                $row[] = $row_output;
                $row[] = $x->email;
                $row[] = strtoupper($x->role_user);
                $row[] = "";
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->users->count_all(),
                "recordsFiltered" => $this->users->count_filtered(),
                "data" => $data
            );
            echo json_encode($output);
        } else {
            redirect(base_url('back/users'));
        }
    }

    public function create_users()
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]|max_length[255]|xss_clean|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|min_length[1]|max_length[255]|xss_clean|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('confirmPassword', 'Konfirmasi Password', 'trim|required|min_length[5]|max_length[255]|xss_clean|matches[password]');

            if ($this->form_validation->run()) {
                $insert = $this->users->post_dataUsers(); // Insert data to database
                echo json_encode(["status" => true, 'message' => ['title' => 'Tambah Data Berhasil!', 'text' => 'User baru telah berhasil ditambahkan!']]);
            } else {
                $res = [
                    'status' => false,
                    'message' => ['title' => "Tambah User Gagal!", 'text' => validation_errors()],
                    'role' => form_error('role', form_err_style()[0], form_err_style()[1]),
                    'username' => form_error('username', form_err_style()[0], form_err_style()[1]),
                    'email' => form_error('email', form_err_style()[0], form_err_style()[1]),
                    'password' => form_error('password', form_err_style()[0], form_err_style()[1]),
                    'confirmPassword' => form_error('confirmPassword', form_err_style()[0], form_err_style()[1]),
                ];
                echo json_encode($res);
            }
        } else {
            redirect(base_url('back/users'));
        }
    }

    public function update_users_form()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $data['roles'] = ['staff', 'supervisor', 'admin'];
            $data['id'] = $id;
            $data['user'] = $this->users->get_dataUsers_byId($id);
            $this->load->view('back/users/form_update', $data);
        } else {
            redirect(base_url('back/users'));
        }
    }

    public function update_users()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);
            $user = $this->users->get_dataUsers_byId($id);

            $this->form_validation->set_rules('role', 'Role', 'trim|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('confirmPassword', 'Konfirmasi Password', 'trim|min_length[5]|max_length[255]|xss_clean|matches[password]');
            $this->form_validation->set_rules('ibm_origin', 'Asal IBM', 'trim|min_length[1]|max_length[255]|xss_clean');

            if ($user['username'] == $this->input->post('username')) {
                $this->form_validation->set_rules('username', 'Username', 'trim|min_length[1]|max_length[255]|xss_clean|regex_match[/^(?=[a-zA-Z0-9._-]{5,30}$)(?!.*[-_.]{2})[^_.].*[^-.]$/i]', ['regex_match' => 'username hanya menerima alfa numerik, titik(.), tanda hubung (-) dan garis bawah (_) dengan minimal 5 karakter']);
            } else {
                $this->form_validation->set_rules('username', 'Username', 'trim|min_length[1]|max_length[255]|xss_clean|is_unique[users.username]|regex_match[/^(?=[a-zA-Z0-9._-]{5,30}$)(?!.*[-_.]{2})[^_.].*[^-.]$/i]', ['regex_match' => 'username hanya menerima alfa numerik, titik(.), tanda hubung (-) dan garis bawah (_) dengan minimal 5 karakter']);
            }
            if ($user['email'] == $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|min_length[1]|max_length[255]|xss_clean');
            } else {
                $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|min_length[1]|max_length[255]|xss_clean|is_unique[users.email]');
            }

            if ($this->form_validation->run()) {

                $insert = $this->users->update_dataUser($id); // Update data to database
                echo json_encode(["status" => true, 'message' => ['title' => 'Ubah Data Berhasil!', 'text' => 'User telah berhasil diubah!']]);
            } else {
                $res = [
                    'status' => false,
                    'message' => ['title' => "Ubah User Gagal!", 'text' => validation_errors()],
                    'username' => form_error('username', form_err_style()[0], form_err_style()[1]),
                    'email' => form_error('email', form_err_style()[0], form_err_style()[1]),
                    'role' => form_error('role', form_err_style()[0], form_err_style()[1]),
                    'password' => form_error('password', form_err_style()[0], form_err_style()[1]),
                    'confirmPassword' => form_error('confirmPassword', form_err_style()[0], form_err_style()[1]),
                ];
                echo json_encode($res);
            }
        } else {
            redirect(base_url('back/users'));
        }
    }

    public function delete_users()
    {
        if ($this->input->is_ajax_request()) {
            $id_user = $this->input->post('id');
            $delete = $this->users->delete_dataUser($id_user);
            echo json_encode(array("status" => $delete));
        } else {
            redirect(base_url('back/users'));
        }
    }

    // ----------------------------
    // -- End - Users --
    // ----------------------------
    // ----------------------------
    // -- Start - Profile Users --
    // ----------------------------

    public function profile() // general
    {
        $data['comp_css'] = get_datatable()['css'] . load_comp_css([base_url("assets/back/vendor/libs/select2/select2.css")]);
        $data['vendor_js'] = get_datatable()['js'] . get_datatable()['vendor'] . load_comp_js([base_url("assets/back/vendor/libs/select2/select2.js")]);
        $data['page_js'] = load_comp_js([base_url('assets/back/js/pages/users_profile.js')]);
        $data['user'] = $this->users->get_dataUsers_byId(get_sess_data('id_user'));
        $data['identity'] = $this->identity->getIdentity();
        $this->template->set('title', 'Profil Pengguna - ' . $data['identity']['company']);
        $this->template->load('back/template', 'back/users_profile/form_update', $data);
    }

    public function update_password() // general
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);
            $user = $this->users->get_dataUsers_byId($id);

            $this->form_validation->set_rules('currentPassword', 'Password sekarang', 'trim|required|min_length[1]|max_length[255]|xss_clean');
            $this->form_validation->set_rules('newPassword', 'Password baru', 'trim|required|xss_clean');
            $this->form_validation->set_rules('confirmPassword', 'Konfirmasi Password', 'trim|xss_clean|matches[newPassword]');


            if ($this->form_validation->run()) {

                if (password_verify($this->input->post('currentPassword', true), $user['password'])) { //password sekarang sesuai
                    $insert = $this->users->update_passwordUser($id); // Update data to database
                    echo json_encode(["status" => true, 'message' => ['title' => 'Ubah Password Berhasil!', 'text' => 'Password telah berhasil diubah!']]);
                } else {
                    echo json_encode(["status" => false, 'message' => ['title' => 'Ubah Password Gagal!', 'text' => 'Password sekarang tidak sesuai!']]);
                }
            } else {
                $res = [
                    'status' => false,
                    'message' => ['title' => "Ubah Password Gagal!", 'text' => validation_errors()],
                    'currentPassword' => form_error('currentPassword', form_err_style()[0], form_err_style()[1]),
                    'newPassword' => form_error('newPassword', form_err_style()[0], form_err_style()[1]),
                    'confirmPassword' => form_error('confirmPassword', form_err_style()[0], form_err_style()[1]),
                ];
                echo json_encode($res);
            }
        } else {
            redirect($this->controller);
        }
    }
}

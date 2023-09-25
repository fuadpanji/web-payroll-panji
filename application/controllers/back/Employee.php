<?php defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends MY_Controller
{
    var $employee_page = "back/employee";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model', 'employee');
    }

    // ----------------------------
    // -- Start - Employee --
    // ----------------------------
    public function index()
    {
        if (!is_admin()) redirect('/back/dashboard');
        $data = [
            'comp_css' => get_datatable()['css'],
            'vendor_js' => get_datatable()['js'] . get_datatable()['vendor'],
            'page_js' => load_comp_js([base_url('assets/back/js/pages/employee.js')]),
            'identity' => $this->identity->getIdentity(),
        ];

        $data['title'] = 'Data Karyawan - ' . $data['identity']['company'];

        $this->template->load('back/template', 'back/employee/data_table', $data);
    }

    public function datatable_employee()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }
        $list = $this->employee->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $x) {
            $no++;
            $row = array();
            $row[] = $x->employee_id;
            $row[] = $no;
            $row[] = $x->name;
            $row[] = $x->birth_place;
            $row[] = dateIndo($x->birth_date);
            $row[] = $x->gender;
            $row[] = $x->job_designation;
            if ($x->status == "Tetap") {
                $status = "<span class='badge bg-label-info'>Tetap</span>";
            } elseif($x->status == "Kontrak") {
                $status = "<span class='badge bg-label-info'>Kontrak</span>";
            } elseif($x->status == "HL") {
                $status = "<span class='badge bg-label-info'>Harian Lepas</span>";
            }
            $row[] = $status;
            $row[] = 'Rp.&nbsp;' . number_format($x->basic_salary, 0, ",", ".");
            $row[] = 'Rp.&nbsp;' . number_format($x->allowance, 0, ",", ".");
            $row[] = dateIndo($x->date_of_join);
            if ($x->has_BPJS == 1) {
                $bpjs = "<span class='badge bg-label-success'>Ya</span>";
            } else {
                $bpjs = "<span class='badge bg-label-secondary'>Tidak</span>";
            }
            $row[] = $bpjs;
            $action = "";
            $row[] = $action;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function create_employee()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }

        $this->form_validation->set_rules('name', 'Nama Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('birth_place', 'Tempat Lahir Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('birth_date', 'Tanggal Lahir Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('job_designation', 'Jabatan Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('status', 'Status Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('basic_salary', 'Gaji Pokok', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('allowance', 'Tunjangan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('date_of_join', 'Tanggal Masuk', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('has_BPJS', 'Ikut BPJS', 'trim|min_length[1]|max_length[255]|xss_clean');

        $validation_result = $this->form_validation->run();
        if ($validation_result) {
            $insert = $this->employee->post_dataEmployee(); // Insert data to database
            $res = ["status" => true, 'message' => ['title' => 'Tambah Data Berhasil!', 'text' => 'Data Karyawan telah berhasil ditambah!']];
        } else {
            $res = [
                'status' => false,
                'message' => ['title' => "Tambah Data Gagal!", 'text' => validation_errors()],
                'name' => form_error('name', form_err_style()[0], form_err_style()[1]),
                'birth_place' => form_error('birth_place', form_err_style()[0], form_err_style()[1]),
                'birth_date' => form_error('birth_date', form_err_style()[0], form_err_style()[1]),
                'gender' => form_error('gender', form_err_style()[0], form_err_style()[1]),
                'job_designation' => form_error('job_designation', form_err_style()[0], form_err_style()[1]),
                'status' => form_error('status', form_err_style()[0], form_err_style()[1]),
                'basic_salary' => form_error('basic_salary', form_err_style()[0], form_err_style()[1]),
                'allowance' => form_error('allowance', form_err_style()[0], form_err_style()[1]),
                'date_of_join' => form_error('date_of_join', form_err_style()[0], form_err_style()[1]),
                'has_BPJS' => form_error('has_BPJS', form_err_style()[0], form_err_style()[1]),
            ];
        }
        echo json_encode($res);
    }

    public function update_employee_form()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }
        $id = $this->input->post('id');
        $data = [
            'id' => $id,
            'employee' => $this->employee->get_dataEmployee_byId($id)
        ];
        $this->load->view('back/employee/form_update', $data);
    }

    public function update_employee()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }
        $id = $this->input->post('id', true);

        $this->form_validation->set_rules('name', 'Nama Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('birth_place', 'Tempat Lahir Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('birth_date', 'Tanggal Lahir Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('job_designation', 'Jabatan Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('status', 'Status Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('basic_salary', 'Gaji Pokok', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('allowance', 'Tunjangan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('date_of_join', 'Tanggal Masuk', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('has_BPJS', 'Ikut BPJS', 'trim|min_length[1]|max_length[255]|xss_clean');

        if ($this->form_validation->run()) {
            $update = $this->employee->update_dataEmployee($id); // Update data to the database
            $res = ["status" => true, 'message' => ['title' => 'Ubah Data Berhasil!', 'text' => 'Data Karyawan berhasil diubah!']];
        } else {
            $res = [
                'status' => false,
                'message' => ['title' => "Ubah Data Gagal!", 'text' => validation_errors()],
                'name' => form_error('name', form_err_style()[0], form_err_style()[1]),
                'birth_place' => form_error('birth_place', form_err_style()[0], form_err_style()[1]),
                'birth_date' => form_error('birth_date', form_err_style()[0], form_err_style()[1]),
                'gender' => form_error('gender', form_err_style()[0], form_err_style()[1]),
                'job_designation' => form_error('job_designation', form_err_style()[0], form_err_style()[1]),
                'status' => form_error('status', form_err_style()[0], form_err_style()[1]),
                'basic_salary' => form_error('basic_salary', form_err_style()[0], form_err_style()[1]),
                'allowance' => form_error('allowance', form_err_style()[0], form_err_style()[1]),
                'date_of_join' => form_error('date_of_join', form_err_style()[0], form_err_style()[1]),
                'has_BPJS' => form_error('has_BPJS', form_err_style()[0], form_err_style()[1]),
            ];
        }
        echo json_encode($res);
    }

    public function delete_employee()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }
        $id = $this->input->post('id');
        $delete = $this->employee->delete_dataEmployee($id);
        echo json_encode(["status" => $delete]);
    }
    // ----------------------------
    // -- End - Employee --
    // ----------------------------
}

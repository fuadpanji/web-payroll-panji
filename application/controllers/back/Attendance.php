<?php defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends MY_Controller
{
    var $attendance_page = "back/attendance";

    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->load->model('Attendance_model', 'attendance');
        $this->load->model('Employee_model', 'employee');
    }

    // ----------------------------
    // -- Start - Attendance --
    // ----------------------------
    public function index()
    {
        $empId = $this->input->post('employee');
        $data['month'] = date("m");
        $data['year'] = date("Y");
        $data['my'] = $data['year'] . "-" . $data['month'];
        $data['empId'] = "semua";

        if (isset($empId)) {
            $data['empId'] = $empId;
            $my = $this->input->post('monthYear');
            if ($my) {
                list($year, $month) = explode('-', $my ?? '');
                $data['my'] = $my;
                $data['year'] = $year;
                $data['month'] = $month;
            }
        }
        
        $data['comp_css'] = get_datatable()['css'] . load_comp_css([base_url('assets/back/vendor/css/daterangepicker.css'), base_url("assets/back/vendor/libs/select2/select2.css")]);
        $data['vendor_js'] = get_datatable()['js'] . get_datatable()['vendor'] . load_comp_js([
            base_url('assets/back/vendor/js/moment.min.js'),
            base_url('assets/back/vendor/js/daterangepicker.js'),
            base_url("assets/back/vendor/libs/select2/select2.js")
        ]);
        $data['page_js'] = load_comp_js([base_url('assets/back/js/pages/attendance.js')]);

        $data['employees'] = $this->employee->get_dataEmployee();
        $data['identity'] = $this->identity->getIdentity();
        $data['title'] = 'Data Presensi Karyawan - ' . $data['identity']['company'];

        $this->template->load('back/template', 'back/attendance/data_table', $data);
    }

    public function datatable_attendance()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->attendance_page));
        }
        $search = $_POST['search']['value'];
        if (isset($_POST['order'])) {
            $orderIndex = $_POST['order'][0]['column'];
            $orderSort = $_POST['order'][0]['dir'];
        } else {
            $orderIndex = "";
            $orderSort = "";
        }
        $empId = $this->input->post('empId');
        $monthYear = $this->input->post('monthYear');
        $length = $_POST['length'];
        $start = $_POST['start'];
        $params = [
            'search' => $search,    
            'orderIndex' => $orderIndex,    
            'orderSort' => $orderSort,    
            'length' => $length,    
            'start' => $start,
            'empId' => $empId,
            'monthYear' => $monthYear
        ];
        $list = $this->attendance->get_attendance_datatables($params);
        
        // $list = $this->attendance->get_attendanceMonth(date('m-Y'));
        $data = array();
        $no = $start;
        foreach ($list['attendances'] as $x) {
            $no++;
            $row = array();
            $row[] = $x['id_attendance'];
            $row[] = $no;
            $row[] = dateIndo($x['attendance_date']);
            $row[] = $x['name'];
            $row[] = $x['signin_time'];
            $row[] = ($x['signout_time'] == NULL) ? "-" : $x['signout_time'];
            $action = "";
            $row[] = $action;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $list['count_all'],
            "recordsFiltered" => $list['count_filtered'],
            "data" => $data
        );
        echo json_encode($output);
    }

    public function create_attendance()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->attendance_page));
        }

        $this->form_validation->set_rules('employee_id', 'Nama Karyawan', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('attendance_date', 'Tanggal Masuk', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('signin_time', 'Waktu Masuk', 'trim|required|min_length[1]|max_length[255]|xss_clean');

        $validation_result = $this->form_validation->run();
        if ($validation_result) {
            $data = [
                "empId" => $this->input->post('employee_id', true),
                "attendance_date" => $this->input->post('attendance_date', true),
                "signin_time" => $this->input->post('signin_time', true)
            ];
            $insert = $this->attendance->postAttendance($data); // Insert data to database
            if($insert['status']) {
                $res = ["status" => true, 'message' => ['title' => 'Tambah Data Berhasil!', 'text' => 'Data Presensi Masuk telah berhasil ditambah!']];
            }else {
                $res = ["status" => $insert['status'], 'message' => ['title' => 'Tambah Data Gagal!', 'text' => $insert['message']]];
            }
            
        } else {
            $res = [
                'status' => false,
                'message' => ['title' => "Tambah Data Gagal!", 'text' => validation_errors()],
                'employee_id' => form_error('employee_id', form_err_style()[0], form_err_style()[1]),
                'attendance_date' => form_error('attendance_date', form_err_style()[0], form_err_style()[1]),
                'signin_time' => form_error('signin_time', form_err_style()[0], form_err_style()[1]),
            ];
        }
        echo json_encode($res);
    }

    public function update_attendance_form()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->attendance_page));
        }
        $id = $this->input->post('id');
        $data = [
            'id' => $id,
            'attendance' => $this->attendance->get_dataAttendance_byId($id)
        ];
        $this->load->view('back/attendance/form_update', $data);
    }
    
    public function update_attendance()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->attendance_page));
        }
        $id = $this->input->post('id', true);
        
        $this->form_validation->set_rules('signout_time', 'Waktu Keluar', 'trim|required|min_length[1]|max_length[255]|xss_clean');

        if ($this->form_validation->run()) {
            $data = [
                "id_attendance" => $id,
                "signout_time" => $this->input->post('signout_time', true)
            ];

            $update = $this->attendance->putAttendance($data); // Insert data to database
            if($update['status']) {
                $res = ["status" => true, 'message' => ['title' => 'Ubah Data Berhasil!', 'text' => 'Data Presensi Keluar telah berhasil ditambah!']];
            }else {
                $res = ["status" => $update['status'], 'message' => ['title' => 'Ubah Data Gagal!', 'text' => $update['message']]];
            }
        } else {
            $res = [
                'status' => false,
                'message' => ['title' => "Ubah Data Gagal!", 'text' => validation_errors()],
                'signout_time' => form_error('signout_time', form_err_style()[0], form_err_style()[1]),
            ];
        }
        echo json_encode($res);
    }
    
    
    public function tes($month, $year) {
        $workdays = array();
        $day_count = days_in_month($month,$year); // Get the amount of days
        
        //loop through all days
        for ($i = 1; $i <= $day_count; $i++) {
        
                $date = $year.'/'.$month.'/'.$i; //format date
                $get_name = date('l', strtotime($date)); //get week day
                $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
        
                //if not a weekend add day to array
                if($day_name != 'Sun' && $day_name != 'Sat'){
                    $workdays[] = $i;
                }
        
        }
        
        $employees = $this->db->get('employees')->result_array();
        $i = 0;
        foreach ($employees as $employee) {
            $jatah = 1;
            $nwNum = 0;
            $total = 0;
            foreach ($workdays as $wd) {
                $nw = rand(1,$workdays[count($workdays)-1]);
                echo $nw."-".$wd."<br>";
                if($nw == $wd) {
                    $nwNum++;
                }else {
                    if($nwNum < 8) {
                        $total++;
                       $data = [
                           'id_attendance' => uuidv4(),
                           'employee_id' => $employee['employee_id'],
                           'attendance_date' => "$year-0$month-$wd",
                           'signin_time' => '08:00',
                        ];
                        
                        $insert = $this->db->insert('attendances',$data);
                    }
                    
                }
            }
            $total = $total-$nwNum;
            echo $data['employee_id']." done ".$total."<br>";
            $i += $total;
        }
        echo "done: ".$i;
        

    }
    
    public function tes2($month, $year) {
        $this->db->where("DATE_FORMAT(attendance_date, '%m-%Y') =", "$month-$year");
        $attendance = $this->db->get_where('attendances',["signout_time" => NULL])->result_array();
            $jatah = 1;
        foreach ($attendance as $a) {
            
            $so = rand(16,21);
            if($so > 16) {
                $jatah++;
            }
            if($jatah > 50) $so = 16;
            
           $data = [
               'id_attendance' => $a['id_attendance'],
               'signout_time' => "$so:00",
            ];
            $update = $this->attendance->putAttendance($data);
            var_dump($update);
        }
        echo "done";
    }
    // ----------------------------
    // -- End - Attendance --
    // ----------------------------
}

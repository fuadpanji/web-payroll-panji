<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payroll extends MY_Controller
{
    var $payroll_page = "back/payroll";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model', 'employee');
        $this->load->model('Attendance_model', 'attendance');
        $this->load->model('Payroll_model', 'payroll');
    }

    public function index()
    {
        $empId = $this->input->post('empId');
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

        $data['employees'] = $this->employee->get_dataEmployee();

        $data['rows'] = count($this->payroll->getRows($data['month'] . "-" . $data['year']));

        $data['comp_css'] = get_datatable()['css'] . load_comp_css([
            base_url("assets/back/vendor/libs/select2/select2.css")
        ]);
        $data['vendor_js'] = get_datatable()['js'] . get_datatable()['vendor'] . load_comp_js([
            base_url("assets/back/vendor/libs/select2/select2.js")
        ]);
        $data['page_js'] = load_comp_js([base_url('assets/back/js/pages/payroll.js')]);

        $data['employees'] = $this->employee->get_dataEmployee();
        $data['identity'] = $this->identity->getIdentity();
        $data['title'] = 'Data Payroll Karyawan ' . $data['month'] . "-" . $data['year'] . ' - ' . $data['identity']['company'];
        $this->template->load('back/template', 'back/payroll/data_table', $data);
    }

    public function datatable_payroll()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->payroll_page));
        }
        $list = $this->payroll->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $x) {
            $no++;
            $row = array();
            $row[] = $x->id_payroll;
            $row[] = $no;
            $row[] = monthIndo($x->month_year);
            $row[] = $x->name;
            $row[] = 'Rp.&nbsp;' . number_format($x->total_salary, 0, ",", ".");
            $row[] = $x->is_verified;
            $action = "";
            if (get_sess_data('role_user') == "staff" || get_sess_data('role_user') == "admin") {
                $action .= '<button href="javascript:;" onclick="detail_payroll(\'' . $x->id_payroll . '\',\'' . $x->month_year . '\')" class="btn btn-md btn-icon item-detail" title="Detail"><i class="text-primary ti ti-eye fs-4"></i></i></button>';
                if ($x->is_verified) {
                    $action .= '<button href="javascript:;" onclick="print_payroll(\'' . $x->id_payroll . '\',\'' . $x->month_year . '\' , \'' . $x->name . '\')" class="btn btn-md btn-icon item-print" title="Cetak Struk"><i class="text-secondary ti ti-printer fs-4"></i></button>';
                }
            } else if (get_sess_data('role_user') == "supervisor" || get_sess_data('role_user') == "admin") {
                $icon = 'clipboard-check';
                $title = 'Sahkan Gaji';
                if ($x->is_verified) {
                    $icon = 'eye';
                    $title = 'Lihat Data';
                }
                $action .= '<button href="javascript:;" onclick="detail_payroll(\'' . $x->id_payroll . '\',\'' . $x->month_year . '\')" class="btn btn-md btn-icon item-verify" title="' . $title . '"><i class="text-success ti ti-' . $icon . ' fs-4"></i></button>';
            }
            $row[] = $action;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->payroll->count_all(),
            "recordsFiltered" => $this->payroll->count_filtered(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function generate_payroll()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $monthYear = $month . "-" . $year;

        $employees = $this->employee->get_dataEmployee();
        $setting = $this->identity->getIdentity();
        $generateHolidays = workingDays($month, $year);
        foreach ($employees as $employee) {
            
            // Calc. Insentif
            $currentDate = new DateTime();
            $dateOfJoin = new DateTime($employee['date_of_join']);
            $workingYears = $currentDate->diff($dateOfJoin)->y;

            $incentive = 0;
            if ($employee['status'] == 'Tetap') {
                if ($workingYears < 1) {
                    $incentive = 1000000;
                } else {
                    $incentive = 1000000 + ($workingYears * 100000);
                }
            }

            // Get API From Attendance System
            $attendanceData = $this->attendance->getAttendance($employee['employee_id'], $monthYear);
            if ($attendanceData['id_attendance'] == NULL) {
                $this->db->delete('payrolls', ['month_year' => $monthYear]);
                echo json_encode(array("status" => false, 'msg' => "Karyawan " . $employee['name'] . " belum ada presensi di bulan ini"));
                die;
            }

            // Calc. Overtime
            $overtimeIncentive = $attendanceData['overtime_pay'];

            // Calc. NWNP
            $NWNPdeduction = ($attendanceData['nwnp'] * $employee['basic_salary']) / $setting['NWNP_deduction'];

            // Calc. BPJS
            if ($employee['has_BPJS'] == 1) {
                $BPJSdeduction = ($employee['basic_salary'] + $employee['allowance']) * $setting['BPJS_deduction'];
            } else {
                $BPJSdeduction = 0;
            }

            // Calc. Salary Total
            $totalSalary = $employee['basic_salary'] + $employee['allowance'] + $incentive + $overtimeIncentive - $NWNPdeduction - $BPJSdeduction;

            // Insert db to Tb payrolls
            $data = [
                'id_payroll' => uuidv4(),
                'employee_id' => $employee['employee_id'],
                'month_year' => $monthYear,
                'incentive' => $incentive,
                'overtime_pay' => $overtimeIncentive,
                'NWNP_pay' => $NWNPdeduction,
                'BPJS_pay' => $BPJSdeduction,
                'total_salary' => $totalSalary,
                'is_verified' => 0
            ];
            $insert = $this->payroll->postPayroll($data);
        }
        echo json_encode(array("status" => true));
    }

    public function detail_payroll()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->payroll_page));
        }
        $id = $this->input->post('id');
        $data['identity'] = $this->identity->getIdentity();
        $payroll = $this->payroll->get_dataPayroll_byId($id);
        $attendance = $this->attendance->getAttendance($payroll['employee_id'], $payroll['month_year']);
        $data['payroll'] = array_merge($payroll, $attendance);

        $empId = $data['payroll']['employee_id'];
        $data['employee'] = $this->employee->get_dataEmployee_byId($empId);

        $id = $this->input->post('id');
        $data['id'] = $id;
        $this->load->view('back/payroll/detail_payroll', $data);
    }

    public function verify_payroll()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url($this->employee_page));
        }
        $id = $this->input->post('id', true);
        $data['identity'] = $this->identity->getIdentity();
        $payroll = $this->payroll->get_dataPayroll_byId($id);
        $attendance = $this->attendance->getAttendance($payroll['employee_id'], $payroll['month_year']);
        $data['payroll'] = array_merge($payroll, $attendance);
        $empId = $payroll['employee_id'];
        $data['employee'] = $this->employee->get_dataEmployee_byId($empId);
        $empName = $data['employee']['name'];
        $monthYear = $payroll['month_year'];
        $put['is_verified'] = 1;

        $data['title'] = "SlipGaji-" . str_replace(" ", "-", $empName) . "-" . $monthYear . ".pdf";

        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($this->load->view('back/payroll/export_payroll', $data, true));
        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . "/assets/data/payroll/SlipGaji-" . str_replace(" ", "-", $empName) . "-" . $monthYear . ".pdf", 'F');

        $update = $this->payroll->putPayroll($put, $id);
        echo json_encode(array("status" => $update));
    }

    public function print_payroll($id, $monthYear)
    {
        $data['identity'] = $this->identity->getIdentity();
        $data['title'] = "Cetak Slip Gaji";
        $payroll = $this->payroll->get_dataPayroll_byId($id);
        $attendance = $this->attendance->getAttendance($payroll['employee_id'], $payroll['month_year']);
        $data['payroll'] = array_merge($payroll, $attendance);

        $empId = $data['payroll']['employee_id'];
        $data['employee'] = $this->employee->get_dataEmployee_byId($empId);
        $empName = $data['employee']['name'];

        // $this->load->view('back/payroll/export_payroll', $data);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $mpdf->AddPageByArray([
            'margin-left' => '15',
            'margin-right' => '15',
            'margin-top' => '15',
            'margin-bottom' => '15',
        ]);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($this->load->view('back/payroll/export_payroll', $data, true));
        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . "/assets/data/payroll/SlipGaji-" . str_replace(" ", "-", $empName) . "-" . $monthYear . ".pdf", 'I');
    }

    public function export_payroll_monthly()
    {
        $empId = $this->input->post('empId');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $monthYear = $month . "-" . $year;

        if ($empId === 'semua') {
            $this->db->where('month_year', $monthYear);
        } else {
            $this->db->where([
                'payrolls.employee_id' => $empId,
                'month_year' => $monthYear,
            ]);
        }

        $this->db->join("employees as e", 'payrolls.employee_id = e.employee_id', 'left');
        $this->db->order_by("e.name", "asc");
        $payrolls = $this->db->get('payrolls')->result_array();

        if (empty($payrolls)) {
            echo '<script>alert("Data payroll tidak ada atau belum di Generate");</script>';
            header('Location: ' . base_url($this->payroll_page));
            exit; 
        }

        foreach ($payrolls as $i => $payroll) {
            $attendance = $this->attendance->getAttendance($payroll['employee_id'], $payroll['month_year']);
            $payrolls[$i] += $attendance;
        }

        $data['payrolls'] = $payrolls;
        $data['identity'] = $this->identity->getIdentity();
        $data['title'] = "Cetak Slip Gaji Periode " . $monthYear;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
        ini_set("pcre.backtrack_limit", "5000000");
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $mpdf->AddPageByArray([
            'margin-left' => '15',
            'margin-right' => '15',
            'margin-top' => '15',
            'margin-bottom' => '15',
        ]);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($this->load->view('back/payroll/export_payroll_monthly', $data, true));
        $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . "/assets/data/payroll/SlipGaji-" . $monthYear . ".pdf", 'F');
    }

    public function downloadPdf($month, $year)
    {
        $monthYear = $month . "-" . $year;
        $this->load->helper('download');
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/assets/data/payroll/SlipGaji-" . $monthYear . ".pdf")) {
            force_download($_SERVER['DOCUMENT_ROOT'] . "/assets/data/payroll/SlipGaji-" . $monthYear . ".pdf", NULL);
        } else {
            redirect(base_url());
        }
    }
}

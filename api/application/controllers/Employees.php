<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Employees extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('EmployeesModel', 'employees');
    }

    public function attendances_get()
    {
        $empId = $this->get('empId');
        $monthYear = $this->get('monthYear');
        
        if($empId && $monthYear) {
            $res = $this->employees->getAttendance($empId, $monthYear);
            if ($res) {
                $this->response([
                    'status' => TRUE,
                    'data' => $res
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Attendance data Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Employee ID and Month Year cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function attendanceId_get()
    {
        $id = $this->get('id');
        
        if($id) {
            $res = $this->employees->getAttendancebyId($id);
            if ($res) {
                $this->response([
                    'status' => TRUE,
                    'data' => $res
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Attendance data Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Attendance ID cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function attendanceDatatables_get()
    {
        $search = $this->get('search');
        $orderIndex = $this->get('orderIndex');
        $orderSort = $this->get('orderSort');
        $length = $this->get('length');
        $start = $this->get('start');
        $empId = $this->get('empId');
        $monthYear = $this->get('monthYear');

        $data = [
            'count_filtered' => $this->employees->count_filtered($search, $orderIndex, $orderSort, $empId, $monthYear),
            'count_all' => $this->employees->count_all($empId, $monthYear),
            'attendances' => $this->employees->get_attendance_datatables($search, $orderIndex, $orderSort, $length, $start, $empId, $monthYear)
        ];

        $this->response([
            'status' => TRUE,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }
    
    public function attendanceMonth_get()
    {
        $monthYear = $this->get('monthYear');
        
        if($monthYear) {
            $res = $this->employees->getAttendancePerMonth($monthYear);
            if ($res) {
                $this->response([
                    'status' => TRUE,
                    'data' => $res
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Attendance data Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Month Year cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function attendanceEmployee_get()
    {
        $empId = $this->get('empId');
        
        if($empId) {
            $res = $this->employees->getAttendancePerEmployee($empId);
            if ($res) {
                $this->response([
                    'status' => TRUE,
                    'data' => $res
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Attendance data Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Employee ID cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function attendances_post()
    {
        $empId = $this->post('empId');
        $attendance_date = $this->post('attendance_date');
        $signin_time = $this->post('signin_time');
        
        if($empId && $attendance_date && $signin_time){
            $data = [
                'id_attendance' => time(),
                'employee_id' => $empId,
                'attendance_date' => $attendance_date,
                'signin_time' => $signin_time,
            ];
            
            $checkAttendance = $this->employees->getAttendancebyDate($empId, $attendance_date);
            if($checkAttendance) { //data already exist
                $this->response([
                    'status' => FALSE,
                    'message' => 'Data attendance already exist!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }else {
                $res = $this->employees->postAttendance($data);
        
                if ($res) {
                    $this->response([
                        'status' => TRUE,
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Failed insert data attendance'
                    ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
    
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Employee ID and attendance date and sign in time cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }
    
    public function attendances_patch()
    {
        $id_attendance = $this->patch('id_attendance');
        $signout_time = $this->patch('signout_time');
        
        if($id_attendance && $signout_time) {
            $attendance = $this->employees->getAttendancebyId($id_attendance);
            if($attendance) {
                $setting = $this->db->get('settings')->row_array();
                if(strtotime($signout_time) >= strtotime($setting['end_work_time'])) {
                    
                    $working_hour = floor((strtotime($signout_time) - strtotime($attendance['signin_time'])) / 3600);
        
                    $employee = $this->employees->getEmployeebyId($attendance['employee_id']);
                    $overtime = floor((strtotime($signout_time) - strtotime($setting['end_work_time'])) / 3600);
                    if($employee['status'] == 'HL') {
                        $overtime_rate_perhour = $employee['basic_salary'] / $setting['annual_working_hours'];
                    }else {
                        $overtime_rate_perhour = ($employee['basic_salary'] + $employee['allowance']) / $setting['annual_working_hours'];
                    }
            
                    $overtime_pay = 0;
                    if($overtime > 4) {
                        $first_4_hours = 4; //first4hour
                        $remaining_after_4_hours = $overtime - $first_4_hours; //after4hour
                        $overtime_pay = ($overtime_rate_perhour * (1 * $first_4_hours)) + ($overtime_rate_perhour * (2 * $remaining_after_4_hours));
                    }else if($overtime > 0) {
                        $first_4_hours = $overtime;
                        $overtime_pay = ($overtime_rate_perhour * (1 * $first_4_hours));
                    }
            
                    $data = [
                        'signout_time' => $signout_time,
                        'working_hour' => $working_hour,
                        'overtime' => $overtime,
                        'overtime_pay' => $overtime_pay,
                    ];
            
                    $res = $this->employees->putAttendance($data, $attendance['id_attendance']);
            
                    if ($res) {
                        $data = $this->employees->getAttendancebyId($attendance['id_attendance']);
                        $this->response([
                            'status' => TRUE,
                            'data' => $data
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Failed update data attendance or data already updated'
                        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }    
                }else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Sign out time cannot less than end work time'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Attendance data Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
            
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Sign out time cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}

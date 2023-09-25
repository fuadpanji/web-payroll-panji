<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmployeesModel extends CI_Model
{
    
    var $table = 'attendances';
    var $column_order = array('','id_attendance','attendance_date', 'employees.name', 'signin_time', 'signout_time');
    var $column_search = array('id_attendance','attendance_date', 'employees.name', 'signin_time', 'signout_time');
    var $order = array('attendance_date' => 'desc');
    
    private function _get_datatables_query($search,$orderIndex, $orderSort, $empId, $monthYear)
    {
       $i = 0;
       $this->db->join('employees', 'attendances.employee_id=employees.employee_id');
        foreach ($this->column_search as $item) // loop column
        {
            if ($search) {
                if ($i === 0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like('UPPER(' . $item . ')', strtoupper($search));
                } else {
                    $this->db->or_like('UPPER(' . $item . ')', strtoupper($search));
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if($empId != "semua")
            $this->db->where("attendances.employee_id", $empId);
        $this->db->where("DATE_FORMAT(attendance_date, '%m-%Y') =", $monthYear);

        if ($orderIndex != "") // here order processing
        {
            $this->db->order_by($this->column_order[$orderIndex], $orderSort);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_attendance_datatables($search, $orderIndex, $orderSort, $length, $start, $empId, $monthYear)
    {
        $this->_get_datatables_query($search, $orderIndex, $orderSort, $empId, $monthYear);
        if($length != -1)
            $this->db->limit($length, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
 
    function count_filtered($search, $orderIndex, $orderSort, $empId, $monthYear)
    {
        $this->_get_datatables_query($search, $orderIndex, $orderSort, $empId, $monthYear);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }
 
    public function count_all($empId, $monthYear)
    {
        $this->db->from($this->table);
        if($empId != "semua")
            $this->db->where("attendances.employee_id", $empId);
        $this->db->where("DATE_FORMAT(attendance_date, '%m-%Y') =", $monthYear);
        return $this->db->count_all_results();
    }
    
    public function getAttendance($empId, $monthYear)
    {
        $query = $this->db->query("
            SELECT a.id_attendance,a.employee_id,
            (SELECT work_days FROM holidays WHERE month_year = '$monthYear') - IF((SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance) < 0, 0, (SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance)) as workdays,
            IF((SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance) < 0, 0, (SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance)) as nwnp, 
            SUM(overtime) as overtime, 
            SUM(overtime_pay) as overtime_pay 
            FROM `attendances` a JOIN employees e 
            ON a.employee_id = e.employee_id 
            WHERE a.employee_id = '$empId' AND DATE_FORMAT(a.attendance_date, '%m-%Y') = '$monthYear'");
        return $query->row_array();
    }
    
    public function getAttendancePerMonth($monthYear)
    {
        $query = $this->db->query("
        SELECT a.id_attendance,e.*,
        (SELECT work_days FROM holidays WHERE month_year = '$monthYear') - IF((SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance) < 0, 0, (SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance)) as workdays, 
        DATE_FORMAT(a.attendance_date,'%b-%Y') as month_year, 
        IF((SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance) < 0, 0, (SELECT work_days FROM holidays WHERE month_year = '$monthYear') - COUNT(id_attendance)) as nwnp, 
        SUM(overtime) as overtime, 
        SUM(overtime_pay) as overtime_pay 
        FROM `attendances` a JOIN employees e 
        ON a.employee_id = e.employee_id 
        WHERE DATE_FORMAT(a.attendance_date, '%m-%Y') = '$monthYear' 
        GROUP BY a.employee_id;");
        return $query->result_array();
    }
    
    public function getAttendancePerEmployee($empId)
    {
        $query = $this->db->query("
        SELECT a.id_attendance,e.*, 
        (SELECT work_days FROM holidays WHERE month_year = DATE_FORMAT(a.attendance_date,'%m-%Y')) - IF((SELECT work_days FROM holidays WHERE month_year = DATE_FORMAT(a.attendance_date,'%m-%Y')) - COUNT(id_attendance) < 0, 0, (SELECT work_days FROM holidays WHERE month_year = DATE_FORMAT(a.attendance_date,'%m-%Y')) - COUNT(id_attendance)) as workdays, 
        DATE_FORMAT(a.attendance_date,'%b-%Y') as month_year, 
        IF((SELECT work_days FROM holidays WHERE month_year = DATE_FORMAT(a.attendance_date,'%m-%Y')) - COUNT(id_attendance) < 0, 0, (SELECT work_days FROM holidays WHERE month_year = DATE_FORMAT(a.attendance_date,'%m-%Y')) - COUNT(id_attendance)) as nwnp,
        SUM(overtime) as overtime, 
        SUM(overtime_pay) as overtime_pay 
        FROM `attendances` a JOIN employees e 
        ON a.employee_id = e.employee_id 
        WHERE a.employee_id = '$empId' 
        GROUP BY DATE_FORMAT(a.attendance_date,'%m-%Y');");
        return $query->result_array();
    }
    
    public function getAttendancebyId($id)
    {
        return $this->db->get_where('attendances', ['id_attendance' => $id])->row_array();
    }
    
    public function getAttendancebyDate($empId, $date)
    {
        return $this->db->get_where('attendances', ['employee_id' => $empId, 'attendance_date' => $date])->row_array();
    }

    public function postAttendance($data)
    {
        $this->db->insert('attendances', $data);
        return $this->db->affected_rows();
    }
    
    public function putAttendance($data, $id)
    {
        $this->db->update('attendances', $data, ['id_attendance' => $id]);
        return $this->db->affected_rows();
    }
    
    public function getEmployeebyId($id)
    {
        return $this->db->get_where('employees', ['employee_id' => $id])->row_array();
    }
}

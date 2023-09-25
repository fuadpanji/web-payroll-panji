<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ----------------------------
    // -- Start Employee --
    // ----------------------------
    private $payroll = 'payrolls';
    private $column_order = ['', 'id_payroll', 'month_year', 'name', 'total_salary', 'is_verified'];
    private $column_search = ['name', 'total_salary', 'is_verified'];
    private $order = ['is_verified' => 'desc', 'name' => 'asc'];

    // Datatable
    public function _get_datatables_query()
    {
        $i = 0;
        $this->db->join("employees as e", 'payrolls.employee_id = e.employee_id', 'left');
        $search = strtoupper($_POST['search']['value']);

        foreach ($this->column_search as $item) {
            if ($search) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like('UPPER(' . $item . ')', $search);
                } else {
                    $this->db->or_like('UPPER(' . $item . ')', $search);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if ($this->input->post('empId')) {
            if ($this->input->post('empId') != 'semua') {
                $this->db->where(['payrolls.employee_id' => $this->input->post('empId')]);
            }
        }

        if ($this->input->post('monthYear')) {
            if ($this->input->post('monthYear') != date("m-Y")) {
                list($year, $month) = explode('-', $this->input->post('monthYear') ?? '');
                $this->db->where(['month_year' => $month . "-" . $year]);
            } else {
                $this->db->where(['month_year' => date("m-Y")]);
            }
        }

        if (isset($_POST['order'])) {
            $orderColumn = $_POST['order']['0']['column'];
            $orderDir = $_POST['order']['0']['dir'];
            $orderBy = $this->column_order[$orderColumn];

            if ($orderBy !== '') {
                $this->db->order_by($orderBy, $orderDir);
            }
        } else if (isset($this->order)) {
            $order = $this->order;
            $orderBy = '';

            foreach ($order as $key => $val) {
                $orderBy .= "{$key} {$val}, ";
            }

            $this->db->order_by(rtrim($orderBy, ', '));
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->select('*');
        
        return $this->db->get($this->payroll)->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->get($this->payroll)->num_rows();
    }

    public function count_all()
    {
        if ($this->input->post('empId')) {
            if ($this->input->post('empId') != 'semua')
                $this->db->where(['payrolls.employee_id' => $this->input->post('empId')]);
        }

        if ($this->input->post('monthYear')) {
            if ($this->input->post('monthYear') != date("m-Y") ) {
                list($year, $month) = explode('-', $this->input->post('monthYear') ?? '');
                $this->db->where(['month_year' => $month . "-" . $year]);
            } else {
                $this->db->where(['month_year' => date("m-Y")]);
            }
        }
        return $this->db->count_all($this->payroll);
    }
    // End Datatable

    // Post Data Payroll
    public function postPayroll($data)
    {
        $this->db->insert('payrolls', $data);
        return $this->db->affected_rows();
    }

    public function putPayroll($data, $id)
    {
        $this->db->update('payrolls', $data, ['id_payroll' => $id]);
        return $this->db->affected_rows();
    }

    public function getRows($monthYear)
    {
        return $this->db->get_where('payrolls', ['month_year' => $monthYear])->result_array();
    }

    public function get_dataPayroll_byId($id) // by Id
    {
        $query = $this->db->get_where($this->payroll, array('id_payroll' => $id));
        return $query->row_array();
    }
}

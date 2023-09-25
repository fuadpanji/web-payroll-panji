<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ----------------------------
    // -- Start Employee --
    // ----------------------------
    private $employee = 'employees';
    private $column_order = ['', 'name', 'birth_place', 'birth_date', 'gender', 'job_designation', 'status'];
    private $column_search = ['name', 'birth_place', 'birth_date', 'gender', 'job_designation', 'status'];
    private $order = ['employee_id' => 'desc'];

    // Datatable
    public function _get_datatables_query()
    {
        $i = 0;
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
        return $this->db->get($this->employee)->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->get($this->employee)->num_rows();
    }

    public function count_all()
    {
        return $this->db->count_all($this->employee);
    }
    // End Datatable

    // GET
    public function get_dataEmployee() // All Data
    {
        return $this->db->get($this->employee)->result_array();
    }

    public function get_dataEmployee_byId($id) // by Id
    {
        $query = $this->db->get_where($this->employee, array('employee_id' => $id));
        return $query->row_array();
    }

    // POST
    public function post_dataEmployee()
    {
        $data = [
            'employee_id' => time(),
            'name' => $this->input->post('name', true),
            'birth_place' => $this->input->post('birth_place', true),
            'birth_date' => $this->input->post('birth_date', true),
            'gender' => $this->input->post('gender', true),
            'job_designation' => $this->input->post('job_designation', true),
            'status' => $this->input->post('status', true),
            'basic_salary' => (int)str_replace(['Rp. ', '.', ','], '', $this->input->post('basic_salary', true)),
            'allowance' => (int)str_replace(['Rp. ', '.', ','], '', $this->input->post('allowance', true)),
            'date_of_join' => $this->input->post('date_of_join', true),
            'has_BPJS' => get_checkbox_value($this->input->post('has_BPJS', true)),
        ];

        $this->db->insert($this->employee, $data);
        return $this->db->affected_rows();
    }

    // PUT
    public function update_dataEmployee($id)
    {
        $data = [
            'name' => $this->input->post('name', true),
            'birth_place' => $this->input->post('birth_place', true),
            'birth_date' => $this->input->post('birth_date', true),
            'gender' => $this->input->post('gender', true),
            'job_designation' => $this->input->post('job_designation', true),
            'status' => $this->input->post('status', true),
            'basic_salary' => (int)str_replace(['Rp. ', '.', ','], '', $this->input->post('basic_salary', true)),
            'allowance' => (int)str_replace(['Rp. ', '.', ','], '', $this->input->post('allowance', true)),
            'date_of_join' => $this->input->post('date_of_join', true),
            'has_BPJS' => get_checkbox_value($this->input->post('has_BPJS', true)),
        ];

        $this->db->update($this->employee, $data, ['employee_id' => $id]);
        return $this->db->affected_rows();
    }

    // DELETE
    public function delete_dataEmployee($id)
    {
        $this->db->delete($this->employee, ['employee_id' => $id]);
        return $this->db->affected_rows();
    }
    // ----------------------------
    // -- End Employee --
    // ----------------------------
}
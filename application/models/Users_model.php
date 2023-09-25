<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ----------------------------
    // -- Start Users --
    // ----------------------------

    // Datatable Users
    var $table = 'users';
    var $column_order = ['', 'id_user', 'username', 'email', 'role_user'];
    var $column_search = ['id_user', 'username', 'email', 'role_user'];
    var $order = array('id_user' => 'desc');

    public function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like('UPPER(' . $item . ')', strtoupper($_POST['search']['value']));
                } else {
                    $this->db->or_like('UPPER(' . $item . ')', strtoupper($_POST['search']['value']));
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }


        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $j = 0;
            $orderBy = '';
            foreach ($order as $key => $val) {
                $orderBy .= "{$key} {$val}";
                ($j != count($order) - 1) ? $orderBy .= ", " : "";
                $j++;
            }
            $this->db->order_by($orderBy);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    // End Datatable Users

    public function get_dataUsers() // All Users
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_dataUsers_byId($id) // Users by Id
    {
        $query = $this->db->get_where('users', ['id_user' => $id]);
        return $query->row_array();
    }

    // POST
    public function post_dataUsers()
    {
        $dataUser = [
            'id_user' => time(),
            'username' => strtolower($this->input->post('username', true)),
            'email' => strtolower($this->input->post('email', true)),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'role_user' => strtolower($this->input->post('role', true)),
        ];

        $this->db->insert('users', $dataUser);
        return $this->db->affected_rows();
    }

    // PUT
    public function update_dataUser($id)
    {
        $user = $this->db->get_where('users', ['id_user' => $id])->row_array();
        $pk = "id_user";
        $dataUser = [
            'username' => strtolower($this->input->post('username', true)),
            'email' => strtolower($this->input->post('email', true)),
            'role_user' => ($this->input->post('role', true) == "") ? $user['role_user'] : $this->input->post('role', true),
        ];

        $password = $this->input->post('password', true);
        ($password == "") ? "" : $dataUser['password'] = password_hash($password, PASSWORD_DEFAULT);

        $this->db->update('users', $dataUser, array($pk => $id));

        return $this->db->affected_rows();
    }

    public function update_passwordUser($id)
    {
        $password = password_hash($this->input->post('newPassword', true), PASSWORD_DEFAULT);
        $this->db->update('users', ['password' => $password], ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    // DELETE
    public function delete_dataUser($id)
    {
        $this->db->delete('users', ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    // ----------------------------
    // -- End Users --
    // ----------------------------

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ----------------------------
    // -- Start Users Detail --
    // ----------------------------

    public function getUserByEmailOrUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = '{$username}' OR email = '{$username}'";
        return $this->db->query($query)->row_array();
    }

    public function getUserById($user_id)
    {
        $query = "SELECT * FROM users AS user WHERE id_user = '{$user_id}'";
        return $this->db->query($query)->row_array();
    }

}

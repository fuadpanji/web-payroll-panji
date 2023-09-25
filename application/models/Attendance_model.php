<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_model
{
    private $api_url;
    private $api_name;
    private $api_key;

    public function __construct()
    {
        parent::__construct();
        $this->api_url = $this->config->item('api_url');
        $this->api_name = $this->config->item('api_name');
        $this->api_key = $this->config->item('api_key');
    }

    // Menerima Data Presensi
    public function getAttendance($empId, $monthYear)
    {
        $url = $this->api_url . 'employees/attendances?' . http_build_query([
            'empId' => $empId,
            'monthYear' => $monthYear
        ]);

        $headers = array("$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !isset($result['data'])) {
            echo 'Error: Invalid JSON response';
            return null;
        }

        return $result['data'];
    }

    // Menerima Data Presensi datatables Berdasarkan Bulan
    public function get_attendance_datatables($params)
    {
        $url = $this->api_url . 'employees/attendances/datatables?' . http_build_query($params);
        
        $headers = array("$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !isset($result['data'])) {
            echo 'Error: Invalid JSON response';
            return null;
        }

        return $result['data'];
    }
    
    // Menerima Data Presensi Berdasarkan Bulan
    public function get_attendanceMonth($monthYear)
    {
        $url = $this->api_url . 'employees/attendances/months?' . http_build_query([
            'monthYear' => $monthYear
        ]);

        $headers = array("$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !isset($result['data'])) {
            echo 'Error: Invalid JSON response';
            return null;
        }

        return $result['data'];
    }

    // Menerima Data Presensi Berdasarkan Id
    public function get_dataAttendance_byId($id)
    {
        $url = $this->api_url . 'employees/attendances/id?' . http_build_query([
            'id' => $id
        ]);

        $headers = array("$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !isset($result['data'])) {
            echo 'Error: Invalid JSON response';
            return null;
        }

        return $result['data'];
    }
    
    // Menerima Data Presensi Berdasarkan Karyawan
    public function get_attendanceEmployee($empId)
    {
        $url = $this->api_url . 'employees/attendances/employees?' . http_build_query([
            'empId' => $empId
        ]);

        $headers = array("$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!$result || !isset($result['data'])) {
            echo 'Error: Invalid JSON response';
            return null;
        }

        return $result['data'];
    }

    // Mengirim Data Presensi Karyawan (Untuk Masuk)
    public function postAttendance($data)
    {
        $url = $this->api_url . 'employees/attendances';

        $headers = array("$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        $result = json_decode($response, true);

        return $result;
    }
    
    // Mengirim Data Presensi Karyawan (Untuk Keluar)
    public function putAttendance($data)
    {
        $url = $this->api_url . 'employees/attendances';

        $headers = array('Content-Type: application/x-www-form-urlencoded', "$this->api_name:$this->api_key");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        $result = json_decode($response, true);

        return $result;
    }
}

<?php

// ----------------------------
// -- General Helper --
// ----------------------------

use PhpOffice\PhpSpreadsheet\Style\Supervisor;

if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $ci = &get_instance();
        return $ci->identity->getIdentity();
    }
}

if (!function_exists('text_limit')) {
    function text_limit($x, $length)
    {
        return (strlen($x) <= $length) ? $x : substr($x, 0, $length) . " ...";
    }
}

function number_format_short($number)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];

    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && round($display) < 100) ? 1 : 0;
            $number = number_format($display, $decimals) . $abbrev;
            break;
        }
    }

    return $number;
}

// ----------------------------
// -- End General Helper --
// ----------------------------

// ----------------------------
// -- Auth Helper --
// ----------------------------
if (!function_exists('auth_check')) {
    function auth_check()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        if (!in_array($ci->uri->segment(1), ['auth', 'home', null])) {
            $last_time = get_sess_data('last_time_activity');
            // tidak remember me dan tidak ada aktivitas selama 1 jam
            if (!check_cookie_login() && !$ci->session->has_userdata('is_login') && $last_time < strtotime("-90 minute", time())) {
                redirect('auth/logout');
            } else {
                $ci->session->set_userdata('last_time_activity', time());
            }
            // }
        }
    }
}

if (!function_exists('check_cookie_login')) {
    function check_cookie_login()
    {
        $ci = &get_instance();
        $ci->load->helper('cookie');
        $ci->load->library('encryption');

        $ci->load->model('Auth_model', 'auth');
        if (get_cookie('login')) {
            $cookie = $ci->encryption->decrypt(get_cookie('login'));
            $cookie = json_decode($cookie, true);
            // check user id correct or not
            if (!empty($cookie)) {
                $user = $ci->auth->getUserById($cookie['id_user']);
                if (!empty($user)) {
                    if (!$ci->session->userdata('id_user')) {
                        $ci->session->set_userdata($cookie);
                    }
                    return true;
                }
            }
            return false;
        }
        return false;
    }
}

function get_ip()
{
    return $_SERVER['REMOTE_ADDR'];
}

function is_login()
{
    $ci = &get_instance();
    if (!in_array($ci->uri->segment(1), ['auth', null])) {
        if (!$ci->session->has_userdata('is_login')) return false;
        $last_time = get_sess_data('last_time_activity');
        // tidak remember me dan tidak ada aktivitas selama 1 jam
        if (!check_cookie_login() && $last_time < strtotime("-60 minute", time())) return false;
        return true;
    }
    return false;
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $ci = &get_instance();
        if (!is_login()) return false;

        if (get_sess_data('role_user') != "") {
            $role = $ci->db->get_where('users', ['role_user' => get_sess_data('role_user')])->row_array();
            if (in_array($role['role_user'], ['admin', 'staff'])) return true;
        }

        return false;
    }
}

if (!function_exists('get_alert')) {
    function get_alert($type, $message)
    {
        if ($type == 'success') {
            $ti = 'check';
        } else if ($type == 'info') {
            $ti = 'info-circle';
        } else if ($type == 'warning') {
            $ti = 'bell';
        } else if ($type == 'danger') {
            $ti = 'ban';
        }
        return "<div class='alert alert-{$type} alert-dismissible' role='alert'>
            <span class='alert-icon text-{$type} me-2'>
              <i class='ti ti-{$ti} ti-xs'></i>
            </span>
            <span>{$message}</span>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
}

function user_data($user_id)
{
    $ci = &get_instance();
    $query = "
    SELECT *
    FROM users 
    WHERE id_user = '{$user_id}'";
    return $ci->db->query($query)->row_array();
}
// ----------------------------
// -- End Auth Helper --
// ----------------------------

// ----------------------------
// -- Back Helper --
// ----------------------------

// Comp. CSS
function load_comp_css($target_href = array())
{
    $return = '';
    foreach ($target_href as $value) {
        $return .= '<link type="text/css" href="' . $value . '" rel="stylesheet">' . PHP_EOL;
    }
    return $return;
}

// Comp. JS
function load_comp_js($target_src = array())
{
    $return = '';
    foreach ($target_src as $value) {
        $return .= '<script src="' . $value . '" type="text/javascript"></script>' . PHP_EOL;
    }
    return $return;
}

// Comp. Datatable
function get_datatable()
{
    $data['css'] = load_comp_css(array(
        base_url("assets/back/vendor/libs/datatables-bs5/datatables.bootstrap5.css"),
        base_url("assets/back/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css"),
        base_url("assets/back/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css"),
        base_url("assets/back/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css"),
        base_url("assets/back/vendor/libs/flatpickr/flatpickr.css"),
        base_url("assets/back/vendor/libs/sweetalert2/sweetalert2.css"),
        base_url("assets/back/vendor/libs/toastr/toastr.css"),
        base_url("assets/back/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css")
    ));
    $data['js'] = load_comp_js(array(
        base_url('assets/back/vendor/libs/datatables-bs5/datatables-bootstrap5.js'),
    ));
    $data['vendor'] = load_comp_js(array(
        base_url('assets/back/vendor/libs/moment/moment.js'),
        base_url('assets/back/vendor/libs/flatpickr/flatpickr.js'),
        base_url('assets/back/vendor/libs/sweetalert2/sweetalert2.js'),
        base_url('assets/back/vendor/libs/toastr/toastr.js'),
    ));
    return $data;
}

// UUID
if (!function_exists('uuidv4')) {
    function uuidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

// Romawi of Month
if (!function_exists('RomawiOfMonth')) {
    function RomawiOfMonth()
    {
        return $RomawiOfMonth  = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    }
}

// Date time on created & change
function format_datetime($datetime)
{
    # format tanggal, jika hari ini
    if (date('Y-m-d') == date('Y-m-d', strtotime($datetime))) {
        $selisih = time() - strtotime($datetime);

        $detik = $selisih;
        $menit = round($selisih / 60);
        $jam   = round($selisih / 3600);

        if ($detik <= 60) {
            if ($detik == 0) {
                $waktu = "baru saja";
            } else {
                $waktu = $detik . ' detik yang lalu';
            }
        } else if ($menit <= 60) {
            $waktu = $menit . ' menit yang lalu';
        } else if ($jam <= 24) {
            $waktu = $jam . ' jam yang lalu';
        } else {
            $waktu = date('H:i', strtotime($datetime));
        }

        $datetime = $waktu;
    }
    # kemarin
    elseif (date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d')))) == date('Y-m-d', strtotime($datetime))) {
        $datetime = 'Kemarin ' . date('H:i', strtotime($datetime));
    }
    # lusa
    elseif (date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d')))) == date('Y-m-d', strtotime($datetime))) {
        $datetime = '2 hari yang lalu ' . date('H:i', strtotime($datetime));
    } else {
        $datetime = tgl_jam_indo($datetime);
    }

    return $datetime;
}

// Indo Datetime
function tgl_jam_indo($tgl_jam = '') //Y-m-d H:i:s
{
    if (!empty($tgl_jam)) {
        $pisah = explode(' ', $tgl_jam);
        return dateIndo($pisah[0]) . ' ' . date('H:i', strtotime($tgl_jam));
    }
}

// Convert month to Indo format
if (!function_exists('dateIndo')) {
    function dateIndo($date)
    {

        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $date);
        $tanggal = $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        return $tanggal;
    }
}

if (!function_exists('monthIndo')) {
    function monthIndo($date)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $date);
        $tanggal = $bulan[(int)$pecahkan[0]] . ' ' . $pecahkan[1];
        return $tanggal;
    }
}

function form_err_style() // Style form_error
{
    $style = ['<small class="text-danger ps-2" style="font-size: 13px">', '</small>'];
    return $style;
}

function uploadAssetData($name, $rename, $path) // Upload image at Setting
{
    $ci = &get_instance();
    $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/assets/' . $path;
    $config['allowed_types'] = 'gif|svg|jpg|jpeg|png|pdf';
    $config['max_size'] = '3072'; // 3MB
    $config['maintain_ratio'] = TRUE;
    $config['file_name'] = $rename;
    $ci->upload->initialize($config);
    if ($ci->upload->do_upload($name)) {
        $upload_data = $ci->upload->data();
        $res = ['status' => TRUE, 'data' => $upload_data['file_name']];
    } else {
        $upload_data = $ci->upload->display_errors();
        $res = ['status' => FALSE, 'data' => $upload_data];
    }
    return $res;
}

function deleteAssetData($image, $path) // Unlink image at Setting
{
    $expImg = explode(".", $image);
    if ($image != 'default.png') {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/' . $path . $image)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/' . $path . $image);
            // if ($expImg[1] != 'pdf' || $expImg[1] != 'PDF') {
            //     unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/' . $path . '/' . $expImg[0] . '_small.' . $expImg[1]);
            //     unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/' . $path . '/' . $expImg[0] . '_medium.' . $expImg[1]);
            // }
        }
    }
}

function uploadFile($name, $path) // Upload File
{
    $ci = &get_instance();

    $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path;
    $config['allowed_types'] = 'gif|svg|jpg|jpeg|png|pdf';
    $config['max_size'] = '3072'; //3MB
    $config['maintain_ratio'] = TRUE;
    $config['encrypt_name'] = TRUE;
    $ci->load->library('upload', $config);
    $ci->upload->initialize($config);

    if ($ci->upload->do_upload($name)) {
        $upload_data = $ci->upload->data();
        $res = ['status' => TRUE, 'data' => $upload_data['file_name']];

        $imgExt = ['.jpg', '.jpeg', '.png'];
        if (in_array($upload_data['file_ext'], $imgExt)) { // if file type is image, create thumbnail
            create_img_thumb($upload_data['file_path'] . $upload_data['file_name'], '_small', '150', '150');
            create_img_thumb($upload_data['file_path'] . $upload_data['file_name'], '_medium', '400', '400');
        }
    } else {
        $upload_data = $ci->upload->display_errors();
        $res = ['status' => FALSE, 'data' => $upload_data];
    }
    return $res;
}

function deleteUploadImage($image, $path) // Unlink File
{
    $expImg = explode(".", $image);
    if ($image != 'default.png') {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/' . $image)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/' . $image);
            if ($expImg[1] != 'pdf' || $expImg[1] != 'PDF') {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/' . $expImg[0] . '_small.' . $expImg[1]);
                unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/' . $expImg[0] . '_medium.' . $expImg[1]);
            }
        }
    }
}

function uploadMultipleAttachment($name, $path)
{
    $ci = &get_instance();

    $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path;
    $config['allowed_types'] = 'gif|svg|jpg|jpeg|png|pdf';
    $config['max_size'] = '3072'; //3MB
    $config['maintain_ratio'] = TRUE;
    // $config['maintain_ratio'] = FALSE;
    // $config['quality']= '50%';
    // $config['width'] = 600;
    // $config['height'] = 400;
    $config['encrypt_name'] = TRUE;
    $ci->load->library('upload', $config);

    $array_file_name = [];
    $supported_image = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    // $res = [];
    $count = count($_FILES[$name]['name']);
    for ($i = 0; $i < $count; $i++) {
        if (!empty($_FILES[$name]['name'][$i])) {

            $_FILES['file']['name'] = $_FILES[$name]['name'][$i];
            $_FILES['file']['type'] = $_FILES[$name]['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES[$name]['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES[$name]['error'][$i];
            $_FILES['file']['size'] = $_FILES[$name]['size'][$i];

            // Rename File
            // $rename = str_replace("/", "-", $id) . "-" . substr($_FILES['file']['name'], 0, 100);
            // $rename = "tes" . $i;
            // $config['file_name'] = $rename;

            $ci->upload->initialize($config);

            if (!$ci->upload->do_upload('file')) { //if error upload file
                $upload_data[] = $ci->upload->display_errors();
                $res = ['status' => FALSE, 'data' => $upload_data];
            } else { //resize image file for thumbnail
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/thumbs')) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/thumbs', 0777, TRUE);
                }
                $berkas = $ci->upload->data('file_name');
                $ci->load->helper('file');
                $ci->load->library('image_lib');
                array_push($array_file_name, $berkas);

                $ext = strtolower(pathinfo($berkas, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
                if (in_array($ext, $supported_image)) {

                    $config['image_library']    = 'gd2';
                    $config['source_image']     = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/' . $berkas;
                    $config['new_image']        = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/' . $path . '/thumbs/' . $berkas;
                    $config['maintain_ratio']   = TRUE;
                    $config['height']           = '200';
                    $config['width']            = '200';

                    $ci->image_lib->clear();
                    $ci->image_lib->initialize($config);

                    if (!$ci->image_lib->resize()) {
                        $upload_data_rz[] = $ci->image_lib->display_errors();
                        $res = ['status' => FALSE, 'data' => $upload_data_rz];
                        exit;
                    }
                }

                $res = ['status' => TRUE, 'data' => json_encode($array_file_name)];
            }
        }
    }
    return $res;
}

function create_img_thumb($source_path = '', $marker = '_thumb', $width = '90', $height = '90')
{
    $ci = &get_instance();
    $config['image_library']  = 'gd2';
    $config['source_image']   = $source_path;
    $config['create_thumb']   = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config['width']          = $width;
    $config['height']         = $height;
    $config['maintain_ratio'] = TRUE;
    $config['thumb_marker']   = $marker;

    $ci->load->library('image_lib', $config);
    $ci->image_lib->initialize($config);
    $ci->image_lib->resize();
    $ci->image_lib->clear();
    unset($config);

    return true;
}

function get_initials($fullName) // Image initials
{
    $nameArray = explode(' ', trim($fullName)); // Split the name into an array of words
    $initials = '';
    foreach ($nameArray as $name) {
        $initials .= strtoupper(substr($name, 0, 1)); // Get the first letter of each word and append to initials
        if (strlen($initials) >= 2) { // Check if we have reached the maximum of two characters
            break;
        }
    }
    return $initials;
}

if (!function_exists('get_sess_data')) { // GET Session Data
    function get_sess_data($key)
    {
        $ci = &get_instance();
        if (!empty($ci->session->userdata($key))) {
            return $ci->session->userdata($key);
        }
        return "";
    }
}

if (!function_exists('get_checkbox_value')) {
    function get_checkbox_value($input_post)
    {
        if (empty($input_post)) {
            return 0;
        } else {
            return 1;
        }
    }
}

function insertLog($action) // POST Log History
{
    $ci = &get_instance();
    $id_user = get_sess_data('id_user');
    $id_role = get_sess_data('role_user');
    $data_log = [
        'id_log_history' => uuidv4(),
        'user_id' => $id_user,
        'role_id' => $id_role,
        'action' => $action,
        'log_created_at' => time()
    ];
    $ci->db->insert('users_log_history', $data_log);
    return $ci->db->affected_rows();
}

function calculateWorkdaysMonth($y, $m, $ignore = false)
{
    $result = 0;
    $loop = strtotime("$y-$m-01");
    do if (!$ignore or !in_array(strftime("%u", $loop), $ignore))
        $result++;
    while (strftime("%m", $loop = strtotime("+1 day", $loop)) == $m);
    return $result;
}

function workingDays($m, $y)
{
    $ci = &get_instance();
    $check = $ci->db->get_where('holidays', ['month_year' => "$m-$y"])->row_array();
    if (!$check) {
        $workingDays = calculateWorkdaysMonth($y, $m, [6, 7]);
        $data = [
            'month_year' => "$m-$y",
            'working_days' => $workingDays
        ];
        $ci->db->insert('holidays', $data);
    }
}

function terbilangUang($angka)
{
    $intAngka = intval($angka);
    $angka = abs($intAngka);
    $bilangan = array(
        '',
        'satu',
        'dua',
        'tiga',
        'empat',
        'lima',
        'enam',
        'tujuh',
        'delapan',
        'sembilan'
    );
    $temp = "";

    for ($i = 0; $i < count($bilangan); $i++) {
        if ($angka % 10 == $i) {
            $temp = $bilangan[$i];
            break;
        }
    }

    if ($angka < 10) {
        return $temp;
    } elseif ($angka < 20) {
        return $temp . ' belas';
    } elseif ($angka < 100) {
        return terbilangUang($angka / 10) . ' puluh ' . $temp;
    } elseif ($angka < 200) {
        return 'seratus ' . terbilangUang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilangUang($angka / 100) . ' ratus ' . terbilangUang($angka % 100);
    } elseif ($angka < 2000) {
        return 'seribu ' . terbilangUang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilangUang($angka / 1000) . ' ribu ' . terbilangUang($angka % 1000);
    } elseif ($angka < 2000000) {
        return 'satu juta ' . terbilangUang($angka - 1000000);
    } elseif ($angka < 1000000000) {
        return terbilangUang($angka / 1000000) . ' juta ' . terbilangUang($angka % 1000000);
    } else {
        return 'Angka terlalu besar untuk dikonversi';
    }
}

function days_in_month($month, $year){
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
} 
// ----------------------------
// -- End Back Helper --
// ----------------------------
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function send_email($to = '', $from = '', $subject  = '', $body = '', $attachment = [], $cc = [], $bcc = [])

    {
		$controller =& get_instance();
		
    	$settings = $controller->identity->getIdentity();

       	$controller->load->helper('path'); 

       	// Configure email library
		$config = array();
        // $config['useragent']            = "CodeIgniter";
        // $config['mailpath']             = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']             = "smtp";
        $config['smtp_host']            = $settings['smtp_host'];
        $config['smtp_port']            = $settings['smtp_port'];
		$config['smtp_timeout'] 		= '30';
		$config['smtp_user']    		= $settings['smtp_user'];
		$config['smtp_pass']    		= $settings['smtp_pass'];
        $config['mailtype'] 			= 'html';
        $config['charset']  			= 'utf-8';
        $config['newline']  			= "\r\n";
        $config['wordwrap'] 			= TRUE;

        $controller->load->library('email');
        $controller->email->initialize($config);   

		$controller->email->from( $settings['email_from'] , $from );
		$controller->email->to($to);
		$controller->email->subject($subject);
		$controller->email->message($body);

		if(!empty($cc)) 
		{	
			$controller->email->cc($cc);
		}	
		if(!empty($bcc)) 
		{	
			$controller->email->bcc($bcc);
		}	

		if(!empty($attachment))
		{
		    for ($i = 0; $i < count($attachment); $i++) {
                $controller->email->attach($attachment[$i]);
		    }
// 			$controller->email->attach(base_url()."your_file_path/" .$attachment);

		}

		if($controller->email->send()){
			return "success";
		}
		else
		{
			echo $controller->email->print_debugger();
		}
    }
    
function saveEmailQueue($to, $from, $subject, $body, $attachment = [], $cc = [], $bcc = [])
    {
        $ci =& get_instance();
        $data = [
          'email_to' => $to,
          'email_from' => $from,
          'email_subject' => $subject,
          'email_body' => json_encode($body),
          'email_attachment' => json_encode($attachment),
          'email_cc' => json_encode($cc),
          'email_bcc' => json_encode($bcc),
          'email_created_at' => time()
        ];
        $ci->db->insert('email_queue', $data);
        return $ci->db->affected_rows();
    }

function sendEmail($to = '', $from = '', $subject  = '', $body = '', $attachment = [], $cc = [], $bcc = [])
{
    $ci =& get_instance();
    $settings = $ci->identity->getIdentity();
    $config = [
        'protocol'  => 'smtp',
        'smtp_host' => $settings['smtp_host'],
        'smtp_user' => $settings['smtp_user'],
        'smtp_pass' => $settings['smtp_pass'],
        'smtp_port' => $settings['smtp_port'],
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'newline'   => "\r\n",
        'wordwrap'  => TRUE
    ];

    $ci->email->initialize($config);

    $ci->email->from($settings['email_from'], $from);
    $ci->email->to($to);

    // if ($type == 'activation') {
    $ci->email->subject($subject);
    $ci->email->message($body);
    
    if(!empty($cc)) $ci->email->cc($cc);
	if(!empty($bcc)) $ci->email->bcc($bcc);
	
    if(!empty($attachment))
	{
	    for ($i = 0; $i < count($attachment); $i++) {
            $ci->email->attach($attachment[$i]);
	    }

	}
	if ($ci->email->send()) {
        return true;
    } else {
        echo $ci->email->print_debugger();
        die;
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Telegram
{

    private $apiToken;

    public function __construct()
    {
        $this->apiToken = '6620259883:AAETg3ikz5vEUIsPfyCuLMASKPBB0J4lKmQ'; // Web YKI Jatim Notify - Tele Bot
    }

    public function sendMessage($message)
    {
        $url = 'https://api.telegram.org/bot' . $this->apiToken . '/sendMessage';
        $data = array(
            'chat_id' => '5628276293', // Where ID Tele to send
            'text' => $message,
            'parse_mode' => 'HTML' // Add parse_mode option
        );

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}

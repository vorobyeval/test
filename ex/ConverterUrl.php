<?php

require_once 'config.php';
require_once 'DB.php';

class ConverterUrl{

    public $url;

    public function __construct($url)
    {
        if (!isset($url['url'])) {
            responseJSON('Url is empty', 0);
        } elseif (!filter_var($url['url'], FILTER_VALIDATE_URL)) {
            responseJSON('Invalid url', 0);
        }
        $this->url = $url['url'];
    }

    function addUrl()
    {
        $db = DB::instance()->connect(HOST, USER, PASS, DB_NAME);
        $shortUrl = $this->getRandChar();
        $db->query("INSERT INTO Urls (short_url,url) VALUES ('$shortUrl', '$this->url')");
        return $shortUrl;
    }

    function responseJSON($text, $status){
        $resp = [
            'status' => $status,
            'text' => $text
        ];
        exit(json_encode($resp));
    }

    private function getRandChar()
    {
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for ($i = 0; $i < 5; $i++) {
            $result .= $char[rand(0, strlen($char) - 1)];
        }
        return $result;
    }

    public function createUrl($string)
    {
        return $_SERVER['HTTP_ORIGIN'].'/'.$string;
    }

    static function getUrl($url)
    {
        $db = DB::instance()->connect(HOST, USER, PASS, DB_NAME);
        $query = $db->query("SELECT * FROM Urls WHERE short_url = '$url'");
        $result = mysqli_fetch_array($query);
        return isset($result['url']) ? $result['url'] : false;
    }
}
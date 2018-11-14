<?php

require_once 'DB.php';
require_once 'config.php';

class Api
{
    public $reqUri;
    public $reqParams;

    public function __construct()
    {
        //Массив GET параметров разделенных слешем
        $this->reqUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        if (!isset($this->reqUri[1])) {
            $this->response('Api not found', false, 404);
        }

        $action = $this->getAction($this->reqUri[1]);

        if (!$action) {
            $this->response('Method Not Allowed', false, 405);
        }
        $this->reqParams = $_REQUEST;
        $this->$action();
    }

    private function generate(){
        $num = rand(1, 999999);
        $db = DB::instance()->connect(HOST, USER, PASS, DB_NAME);
        if ($db->query("INSERT INTO Numbers (number) VALUES ($num)")) {
            $this->response($db->insert_id, true);
        }
    }

    private function retrieve(){
        if (!isset($this->reqUri[2])) {
            $this->response('Id is not isset', false, 400);
        }
        $id = (int)$this->reqUri[2];
        $db = DB::instance()->connect(HOST, USER, PASS, DB_NAME);
        $query = $db->query("SELECT number FROM Numbers WHERE id = $id");
        if ($query) {
            $this->response($query->fetch_array()['number'], true);
        }
    }

    private function getAction($action){
        switch ($action) {
            case 'generate':
            case 'retrieve':
                return $action;
            default:
                return false;
        }
    }

    private function response($text, $status, $code = null){
        if(!$status){
            $resp = ['error' => ['code' => $code, 'message' => $text]];
        } else {
            $resp = ['data' => ['value' => $text]];
        }
        exit(json_encode($resp));
    }
}
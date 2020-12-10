<?php
namespace App\Lib;

class Response
{
    const STOP_AFTER_RESPONSE = true;

    public function notAcceptable($body = 'Not Acceptable', $stop = Response::STOP_AFTER_RESPONSE)
    {
        @header('HTTP/1.1 406 Not Acceptable');
        echo $body;
        if($stop) exit(0);
    }

    public function notAllowed($body = 'Method Not Allowed', $stop = Response::STOP_AFTER_RESPONSE)
    {
        @header('HTTP/1.1 405 Method Not Allowed');
        echo $body;
        if($stop) exit(0);
    }

    public function notFound($body = 'Not Found', $stop = Response::STOP_AFTER_RESPONSE)
    {
        @header('HTTP/1.0 404 Not Found');
        echo $body;
        if($stop) exit(0);
    }

    public function json($data = [], $stop = Response::STOP_AFTER_RESPONSE)
    {
        @header('HTTP/1.0 200 OK');
        @header('Content-Type: application/json');
        echo json_encode($data);
        if($stop) exit(0);
    }

    public function csv($data = [], $stop = Response::STOP_AFTER_RESPONSE)
    {
        @header('HTTP/1.0 200 OK');
        @header('Content-Type: text/csv');
        foreach($data AS $row) {
            echo implode(',', array_values($row));
        }
        if($stop) exit(0);
    }
}

<?php
namespace Framework\Core;

use Framework\Core\Controller;

class SystemController extends Controller
{

    public function index()
    {
        $this->view('system.404');
        exit();
    }

    public function catchException($code, $message, $line, $file, $tracer)
    {
        $this->view('system.exception', [
            'code' => $code,
            'mensagem' => $message,
            'line' => $line,
            'file' => $file,
            'tracer' => $tracer,
        ]);
    }
}

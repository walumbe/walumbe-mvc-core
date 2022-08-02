<?php

namespace walumbe\phpmvc;

class Response
{
    public function getStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header("Location: ".$url);
    }

}
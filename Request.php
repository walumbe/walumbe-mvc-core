<?php
namespace app\core;

/**
 * @author  JonathanWalumbe
 * @package  app\core
 */

class Request
{
    public function getPath()
    {
       $path =  $_SERVER['REQUEST_URI'] ?? '/';
       $position = strpos($path, '?');
       if($position === false)
       {
           return $path;
       }
       return substr($path, 0, $position);
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];
        if($this->getMethod() === 'get')
        {
            foreach ($_GET as $key => $value)
            {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->getMethod() === 'post')
        {
            foreach ($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
//                var_dump($body[$key]);

            }
        }
        return $body;
    }

    public function isGet()
    {
        return  $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return  $this->getMethod() === 'post';
    }
}

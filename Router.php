<?php

namespace app\core;

use app\core\exception\NotFoundException;
use http\Params;

/**
 * @author JonathanWalumbe <nathanwalumbe@gmail.com>
 * @package app\core
 *
 */

class Router
{
    public Request $request;
    public Response $response;
//    public Controller $controller;
    protected array  $routes =[];

    /**
     * Router constructor
     *
     * @param \app\coe\Request $request
     * @param \app\coe\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
       $path = $this->request->getPath();
       $method = $this->request->getMethod();
       $callback = $this->routes[$method][$path] ?? false;
       if($callback === false)
       {
//           $this->response->getStatusCode(404);
           throw new NotFoundException();
//           return $this->renderView("_404");
       }
       if(is_string($callback))
       {
//           return  $this->renderView($callback);
           return Application::$app->view->renderView($callback);
       }
       if(is_array($callback))
       {
           /**
            * @var Controller $controller
            * */
           $controller = new $callback[0]();
           Application::$app->controller = $controller;
           $controller->action = $callback[1];
           $callback[0] = $controller;
//           $callback[0]  = new $callback[0]();
           foreach ($controller->getMiddlewares() as $middleware)
           {
                $middleware->execute();
           }
       }
//       var_dump($callback);
//       exit();

       return  call_user_func($callback, $this->request, $this->response);

    }


}
<?php

namespace walumbe\phpmvc\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}
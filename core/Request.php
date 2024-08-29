<?php

namespace core;

class Request
{
    private $get;
    private $post;
    private $files;
    private $server;
    private $params;
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }

    public function getGet()
    {
        return $this->get;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParam($key, $default = null)
    {
        Logger::log(__METHOD__ . ' key : ' . $key . ' default : ' . $default);
        Logger::log(__METHOD__ . ' params : ' . print_r($this->params, true));

        return array_key_exists($key, $this->params) ? $this->params[$key] : $default;
    }

    public function hasParam($key)
    {
        return array_key_exists($key, $this->params);
    }

    public function isGet()
    {
        return $this->getMethod() === self::METHOD_GET;
    }

    public function isPost()
    {
        return $this->getMethod() === self::METHOD_POST;
    }

    public function getPath()
    {
        $path = explode('?', $this->server['REQUEST_URI'])[0];
        return $path === '/' ? '/' : rtrim($path, '/');
    }

    public function getMethod()
    {
        $method = $this->server['REQUEST_METHOD'];
        return strtoupper($method);
    }

    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
    }

    public function post($key, $default = null)
    {
        return array_key_exists($key, $this->post) ? $this->post[$key] : $default;
    }

    public function file($key)
    {
        return array_key_exists($key, $this->files) ? $this->files[$key] : null;
    }
}
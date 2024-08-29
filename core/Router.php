<?php

namespace core;

class Router
{
    private $routesConfig;
    private $requestUri;

    public function __construct($routesConfig)
    {
        $this->routesConfig = $routesConfig;
    }

    public function match($requestUri)
    {
        $this->setRequestUri($requestUri);
        $route = $this->getRoute();
        if ($route) {
            $params = $this->getParams($route);
            $params['page'] = $this->routesConfig[$route];
            return $params;
        } else {
            return [
                'page' => 'errors/404'
            ];
        }
    }

    private function getParams($route)
    {
        $routeParts = explode('/', $route);
        $requestParts = explode('/', $this->getRequestUri());
        $params = [];
        foreach ($routeParts as $key => $part) {
            if (strpos($part, ':') !== false) {
                $params[trim($part, ':')] = $requestParts[$key];
            }
        }
        return $params;
    }

    private function getRoute()
    {
        $routesConfig = $this->routesConfig;
        $request = $this->getRequestUri();

        $matchedRoute = null;

        foreach ($routesConfig as $route => $page) {
            $routeParts = explode('/', $route);
            $requestParts = explode('/', $request);

            if (count($routeParts) !== count($requestParts)) {
                continue;
            }
            $matched = true;
            foreach ($routeParts as $key => $part) {
                if (strpos($part, ':') !== false) {
                    continue;
                } else if ($part !== $requestParts[$key]) {
                    $matched = false;
                    break;
                }
            }

            if ($matched) {
                $matchedRoute = $route;
                break;
            }
        }
        return $matchedRoute;
    }

    private function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;
    }

    private function getRequestUri()
    {
        return $this->requestUri;
    }
}

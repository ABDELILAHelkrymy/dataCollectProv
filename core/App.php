<?php

namespace core;

use Exception;

class App
{

    private $router;
    private $request;
    private $config;
    private $db;

    public function __construct()
    {
        $this->initAutoload();
        $this->initConfig();
        $this->initDotenv();
        $this->initSession();
        $this->initDatabase();
        $this->initRequest();
        $this->initRouter();
        $this->initLogger();
    }

    private function initLogger()
    {
        $log = "New request\n";
        $log .= $this->request->getMethod() . " : " . $this->request->getPath() . "\n";
        Logger::log($log);
    }

    public function run()
    {
        $params = $this->router->match($this->request->getPath());
        $this->request->setParams($params);

        $this->verifyAuth($params['page']);
        //$this->verifyRhAuth($params['page']);
        $configPage = $params['page'];
        $this->renderPage($configPage);
    }

    private function initDotenv()
    {
        Dotenv::load();
    }

    private function initConfig()
    {
        $this->config = require APP_ROOT . '/config/config.php';
    }

    private function initRequest()
    {
        $this->request = new Request();
    }

    private function initRouter()
    {
        $this->router = new Router($this->config['routes']);
    }

    private function initAutoload()
    {
        spl_autoload_register(function ($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $classPath = APP_ROOT . DIRECTORY_SEPARATOR . $class . '.php';
            require_once $classPath;
        });
    }

    private function initSession()
    {
        session_start();
    }

    private function initDatabase()
    {
        // var_dump($this->config['database']);
        $this->db = Connection::connect($this->config['database']);
    }

    private function getPagePath($page)
    {
        $page = trim($page, '/');
        $page = str_replace('/', DIRECTORY_SEPARATOR, $page);
        $pagePath = APP_ROOT . '/pages/' . $page . '.php';
        Logger::log(__METHOD__ . ' input : ' . $page);
        Logger::log(__METHOD__ . ' output : ' . $pagePath);
        return $pagePath;
    }

    private function verifyAuth($page)
    {
        $username = $_SESSION['username'] ?? null;
        $page ??= '';

        if (!$username && $page !== 'auth/login') {
            header('Location: /auth/login');
            exit();
        } else if ($username && $page == 'auth/login') {
            header('Location: /');
            exit();
        }
    }

    private function renderPage($configPage)
    {
        $pagePath = $this->getPagePath($configPage);
        $pagePathSys = str_replace('\\', DIRECTORY_SEPARATOR, $pagePath);
        Logger::log(__METHOD__ . ' input : ' . $configPage);
        Logger::log(__METHOD__ . ' pagePathSys : ' . $pagePathSys);
        if (file_exists($pagePathSys)) {
            Logger::log(__METHOD__ . ' file exists : ' . $pagePathSys);
            require_once $pagePathSys;
        } else {
            Logger::log(__METHOD__ . ' file does not exist : ' . $pagePathSys);
            try {
                $configPageParams = $this->getRouteParams($configPage);
                Logger::log(__METHOD__ . ' configPageParams : ' . json_encode($configPageParams));

                $module = $configPageParams['module'] ?? null;
                $module = $module ? "/$module" : "";
                $controller = $configPageParams['controller'];
                $action = $configPageParams['action'];

                $filePath = "$module/$controller/$action";

                $this->render($filePath);
            } catch (Exception $error) {
                Logger::logException($error);
                include_once APP_ROOT . '/pages/errors/index.php';
            }
        }
    }

    public function getRouteParams($route)
    {
        $route = trim($route, '/');
        $routeParts = explode('/', $route);
        if (count($routeParts) === 3) {
            return [
                'module' => $routeParts[0],
                'controller' => $routeParts[1],
                'action' => $routeParts[2]
            ];
        } else if (count($routeParts) === 2) {
            return [
                'controller' => $routeParts[0],
                'action' => $routeParts[1]
            ];
        } else {
            throw new Exception('Invalid dynamic route');
        }
    }

    private function render(string $filePath)
    {
        $viewPath = $this->getPhpSysPath(APP_ROOT . "/views" . "$filePath");
        $actionPath = $this->getPhpSysPath(APP_ROOT . "/controllers" . "$filePath");
        require_once $actionPath;
        if (file_exists($viewPath)) {
            require_once $viewPath;
        }
    }

    private function getPhpSysPath(string $filePath)
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, $filePath) . ".php";
    }
}

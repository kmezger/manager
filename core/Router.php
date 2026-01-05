<?php
class Router {
    private $routes = [];

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                require_once "../app/controllers/{$route['controller']}.php";
                $controller = new $route['controller']();
                return call_user_func_array([$controller, $route['action']], $params);
            }
        }

        http_response_code(404);
        $view = new View();
        $view->render('errors/404.twig', ['title' => '404 - Seite nicht gefunden']);
    }
}

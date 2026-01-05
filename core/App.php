<?php
class App {
    private $router;

    public function __construct() {
        $this->router = new Router();
        $this->defineRoutes();
        $this->run();
    }

    private function defineRoutes() {
        // Character Routes
        $this->router->add('GET', '', 'CharacterController', 'index');
        $this->router->add('GET', 'characters', 'CharacterController', 'index');
        $this->router->add('GET', 'characters/create', 'CharacterController', 'create');
        $this->router->add('POST', 'characters', 'CharacterController', 'store');
        $this->router->add('GET', 'characters/{id}', 'CharacterController', 'show');
        $this->router->add('GET', 'characters/{id}/edit', 'CharacterController', 'edit');
        $this->router->add('POST', 'characters/{id}/update', 'CharacterController', 'update');
        $this->router->add('POST', 'characters/{id}/delete', 'CharacterController', 'destroy');
    }

    private function run() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($uri, $method);
    }
}

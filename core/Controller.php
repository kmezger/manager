<?php
class Controller {
    protected $view;

    public function __construct() {
        $this->view = new View();
    }

    protected function loadModel($model) {
        require_once "../app/models/{$model}.php";
        return new $model();
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }

    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
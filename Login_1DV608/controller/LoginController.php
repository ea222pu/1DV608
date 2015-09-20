<?php

class LoginController {

    private $model;
    private $view;

    /**
    * Constructor
    *
    * @param LoginModel
    * @param LoginView
    */
    public function __construct(LoginModel $model, LoginView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    /**
    * Handle user input
    */
    public function listen() {
        if($this->view->loginButtonPost() && !$this->model->isLoggedIn()) {
            $this->model->verifyLoginCredentials($this->view->getUsername(), $this->view->getPassword());
            $this->view->setMessage($this->model->getMessage());
        }
        else if($this->view->logoutButtonPost() && $this->model->isLoggedIn()) {
            $this->model->logout();
            $this->view->setMessage($this->model->getMessage());
        }
        else if($this->model->isLoggedIn() && $_POST) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}
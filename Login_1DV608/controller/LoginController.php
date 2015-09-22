<?php

class LoginController {

    private $model;
    private $loginView;
    private $layoutView;
    private $dtv;

    /**
    * Constructor
    *
    * @param LoginModel
    * @param LoginView
    * @param LayoutView
    * @param DateTimeView
    */
    public function __construct(LoginModel $model, LoginView $loginView, LayoutView $layoutView, DateTimeView $dtv) {
        $this->model = $model;
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->dtv = $dtv;
    }

    /**
    * Handle user input
    */
    public function listen() {
        if($this->loginView->loginButtonPost() && !$this->model->isLoggedIn()) {
            $this->model->verifyLoginCredentials($this->loginView->getUsername(), $this->loginView->getPassword(), $this->loginView->getPersistentLogin());
            $this->loginView->setMessage($this->model->getMessage());
        }
        else if($this->loginView->logoutButtonPost() && $this->model->isLoggedIn()) {
            $this->model->logout();
            $this->loginView->setMessage($this->model->getMessage());
            $this->loginView->deleteCredentialCookies();
        }
        else if($this->model->isLoggedIn() && $_POST) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
        else if($this->loginView->isCookiesSet()) {
            $this->model->verifyPersistentLogin($this->loginView->getCookieName(), $this->loginView->getCookiePassword());
            if(!$this->model->isLoggedIn())
                $this->loginView->deleteCredentialCookies();
            $this->loginView->setMessage($this->model->getMessage());
        }
        $this->layoutView->render($this->model->isLoggedIn(), $this->loginView, $this->dtv);
    }
}
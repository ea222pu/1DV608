<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('controller/LoginController.php');

require_once('model/LoginModel.php');
require_once('model/UserList.php');
require_once('model/User.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

//Create user with username 'Admin' and password 'Password'
$user = new User("Admin", "Password");
//Create userlist
$userList = new UserList();
//Add user to userlist
$userList->addUser($user);

//Create model
$model = new LoginModel($userList);

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView($model);
$dtv = new DateTimeView();
$lv = new LayoutView();

//Create controller
$controller = new LoginController($model, $v);

$controller->listen();
$lv->render($model->isLoggedIn(), $v, $dtv);
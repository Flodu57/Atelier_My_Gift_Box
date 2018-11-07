<?php

use mygiftbox\controllers\UserController;

$app->get("/login", function(){
    $c = new UserController();
    $c->getLogin();
})->name('login');

$app->post("/login", function(){
    $c = new UserController();
    $c->postLogin();
})->name('post_login');

$app->get("/register", function(){
    $c = new UserController();
    $c->getRegister();
})->name('register');

$app->post("/register", function(){
    $c = new UserController();
    $c->postRegister();
})->name('post_register');

$app->get('/mailcheck', function(){
    $c = new UserController();
    $c->getRegisterMailCheck();
})->name('mailcheck');

$app->get('/logout', function(){
    $c = new UserController();
    $c->getLogout();
})->name('logout');

$app->get('/forgot_password', function(){
    $c = new UserController();
    $c->getForgotPassword();
})->name('forgotpass');

$app->post('/forgot_password', function(){
    $c = new UserController();
    $c->postForgotPassword();
})->name('post_forgotpassword');

$app->get('/forgotpasslink', function(){
    $c = new UserController();
    $c->getForgotLinkClicked();
})->name('forgotpasslink');
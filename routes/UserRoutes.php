<?php

use mygiftbox\controllers\UserController;

$app->get("/login", function() use ($app){
    $c = new UserController();
    $c->getLogin();
})->name('login');

$app->post("/login", function() use ($app){
    include 'src/actions/login.php';
})->name('post_login');

$app->get("/register", function() use ($app){
    $c = new UserController();
    $c->getRegister();
})->name('register');

$app->post("/register", function() use ($app){
    include 'src/actions/register.php';
})->name('post_register');

$app->get('/logout', function() use ($app){
    $c = new UserController();
    $c->getLogout();
})->name('logout');

$app->get('/forgot_password', function() use ($app){
    $c = new UserController();
    $c->getForgotPassword();
})->name('forgotpass');

$app->post('/forgot_password', function() use ($app){
    $c = new UserController();
    $c->postForgotPassword();
})->name('post_forgotpassword');

$app->get('/forgotpasslink', function() use ($app){
    $c = new UserController();
    $c->getUserLinkClicked();
})->name('forgotpasslink');
<?php

//verification que le formulaire de connexion soit complet
if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){

    $mail = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $password = "";
    //hachage du mot de passe
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

    

    //authentification de l'utilisateur
    mygiftbox\actions\Authentification::authentificate($mail,$password);
}else{
    $app = \Slim\Slim::getInstance();
    $app->flash('error', 'Veuillez remplir tous les champs');
    $app->redirect('login');
}
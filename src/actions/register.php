<?php

$app = \Slim\Slim::getInstance();

//verifier si toutes les informations du formulaire sont envoyées
if(isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['email']) && isset($_POST['lastname']) && isset($_POST['firstname'])){

    //on recupere les informations dans des variables en les filtrant
    $nom = filter_var($_POST['lastname'],FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['firstname'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);

    //verification que l'email est au bon format
    if($email){

        //hachage du mot de passe et de la confirmation
        $password = password_hash(filter_var($_POST['password'],FILTER_SANITIZE_STRING), PASSWORD_DEFAULT,['cost' => 12]);

        $password_c = filter_var($_POST['password_confirm'],FILTER_SANITIZE_STRING);


        //verification que les password sont egaux
        if(password_verify($password_c, $password)){


            \mygiftbox\actions\Authentification::createUser($nom, $prenom, $email, $password);
            \mygiftbox\actions\Authentification::authentificate($email, $password_c);
            $app->redirect($app->urlFor('home'));

        }else{

            $app->flash('error', 'Les mots de passes ne sont pas identiques');
            $app->redirect('register');
        }
    }else{
        $app->flash('error', 'Veuillez entrer une adresse email valide');
        $app->redirect('register');
    }


}else{
    $app->flash('error', 'Veuillez remplir tous les champs');
    $app->redirect('register');
}
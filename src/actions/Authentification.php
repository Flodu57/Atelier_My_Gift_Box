<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 13/12/2017
 * Time: 18:56
 */

namespace mygiftbox\actions;


use Slim\Slim;
use mygiftbox\models\User;

class Authentification
{

    //creation d'un utilisateur
    public static function createUser($nom, $prenom, $email, $mdp){
        $verif = User::where('email','=',$email)->first();
        $app = Slim::getInstance();
        if(!$verif){
            //insertion de l'utilisateur
            $user = new User();
            $user->nom = $nom;
            $user->prenom = $prenom;
            $user->email = $email;
            $user->password = $mdp;
            $user->save();
        }else{
            $app->flash('error', "L'utilisateur existe déjà");
            $app->redirect('login');
        }
    }


    //authentification d'un utilisateur
    public static function authentificate($email, $password){
        $app = Slim::getInstance();
        //on recupere l'utilisateur dans la base de donnee
        $user = User::where('email','=',$email)->first();
        //s'il existe
        if($user){
            //on verifie que le mot de passe entree correspond a celui da la base de donnee
            if(password_verify($password,$user->password)){
                //on le connecte
                self::loadProfil($user->email);
            }else{
                $app->flash('error', 'Mot de passe ou utilisateur incorrect');
                $app->redirect('login');
            }
        }else{
            $app->flash('error', 'Mot de passe ou utilisateur incorrect');
            $app->redirect('login');
        }
    }

    //connexion d'un utilisateur
    public static function loadProfil($email){
        //on recupere l'utilisateur grace a son id dans la base de donnee
        $user = User::where('email','=',$email)->first();
        $_SESSION['id_user'] = $user->id;
    }


    //verification des droits d'acces d'un utilisateur
    public static function checkAcessRight($required){
        $app = Slim::getInstance();
        if(isset($_SESSION['account'])){
            //on verifie si l'utilisateur connecte a le niveau requis
            if($_SESSION['account']['auth_level'] < $required){
                $app->flash('error', "Pas le droit d'aceeder a cette page");
                $app->redirect('login');
            }
        }
    }

}
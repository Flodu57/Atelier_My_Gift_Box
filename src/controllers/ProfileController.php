<?php

namespace mygiftbox\controllers;

use mygiftbox\views\ProfileSettingsView;
use mygiftbox\views\ProfileView;
use mygiftbox\views\CreateBoxView;
use mygiftbox\views\BoxView;
use mygiftbox\models\User;
use mygiftbox\models\Box;


class ProfileController {

    public function getSettings(){
        $v = new ProfileSettingsView();
        $v->render();
    }

    public function changePassword(){
        $app      = \Slim\Slim::getInstance();
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $user     = User::byId($_SESSION['id_user']);

        if($user){
            if(password_verify($password,$user->password)){
                $user->password = password_hash(filter_var($_POST['new_password'],FILTER_SANITIZE_STRING), PASSWORD_DEFAULT,['cost' => 12]);
                $user->save();
                $app->redirect($app->urlFor('logout'));
            }
        }

        
    }

    public function deleteAccount(){
        $app = \Slim\Slim::getInstance();
        $user     = User::byId($_SESSION['id_user']);
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

        if($user){
            if(password_verify($password,$user->password)){
                $user->delete();
                $app->redirect($app->urlFor('logout'));
            }
        }

    }

    public function getProfile(){
        $v = new ProfileView();
        $v->render();
    }

    public function getCreateBox(){
        $v = new CreateBoxView();
        $v->render();
    }

    public function postCreateBox(){
        $app = \Slim\Slim::getInstance();
        
        if(isset($_POST['title']) && isset($_POST['title'])){
            $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
            $date  = filter_var($_POST['date'],FILTER_SANITIZE_STRING);
            $token = bin2hex(random_bytes(12));

            if(!empty($title) && !empty($date)){
                if(Box::exists($title)){
                    $app->flash('error','Vous avez déjà une box avec ce titre');
                    $app->redirect($app->urlFor('profile.createBox'));
                }else{
                    $box = new Box();
                    $box->user_id = $_SESSION['id_user'];
                    $box->titre = $title;
                    $box->slug = Box::getSlug($title);
                    $box->date_ouverture = $date;
                    $box->url = $token;
                    $box->save();

                    $app->flash('success',"La box a bien été créé, vous pouvez désormais ajouter des prestations dedans ! ");
                    $app->redirect($app->urlFor('offers'));
                }
            }else{
                $app->flash('error','Veuillez remplir tous les champs');
                $app->redirect($app->urlFor('profile.createBox'));
            }

            
        }else{
            $app->flash('error','Veuillez remplir tous les champs');
            $app->redirect($app->urlFor('profile.createBox'));
        }
    }

    public function getBox($slug){
        $box = Box::bySlug($slug);

        $v = new BoxView($box);
        $v->render();
    }

    public function getDeleteBox($slug){
        $app = \Slim\Slim::getInstance();

        $box = Box::bySlug($slug);

        if($box){
            $box->prestations()->detach();
            $box->delete();
            $app->flash('success','Coffret supprimé avec succès.');
        }else{
            $app->flash('error','Une erreur s\'est produite !');
        }
        $app->redirect($app->urlFor('profile'));
    }
}
<?php

namespace mygiftbox\controllers;

use mygiftbox\views\ProfileSettingsView;
use mygiftbox\models\User;


class ProfileController {

    public function getSettings(){
        $v = new ProfileSettingsView();
        $v->render();
    }

    public function changePassword($id){
        $app = \Slim\Slim::getInstance();
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $user     = User::where('id','=',$id)->first();

        if($user){
            if(password_verify($password,$user->password)){
                $user->password = password_hash(filter_var($_POST['new_password'],FILTER_SANITIZE_STRING), PASSWORD_DEFAULT,['cost' => 12]);
                $user->save();
                $app->redirect($app->urlFor('logout'));
            }
        }

        
    }

    public function deleteAccount($id){
        $app = \Slim\Slim::getInstance();
        $user     = User::where('id','=',$id)->first();
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

        if($user){
            if(password_verify($password,$user->password)){
                $user->delete();
                $app->redirect($app->urlFor('logout'));
            }
        }

    }

}
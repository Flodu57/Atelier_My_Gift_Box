<?php

namespace mygiftbox\controllers;

use mygiftbox\views\OffersView;
use mygiftbox\views\OfferView;

class UserController{

    public function getLogin(){
        $v = new LoginView();
        return $v->render();
    }

    public function getRegister(){
        $v = new RegisterView();
        return $v->render();
    }

}
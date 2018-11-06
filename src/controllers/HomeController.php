<?php

namespace mygiftbox\controllers;

use mygiftbox\views\HomeView;

class HomeController {

    public function getHomePage(){
        $v = new HomeView();
        $v->render();
    }

}
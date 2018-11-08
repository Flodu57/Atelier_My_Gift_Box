<?php

namespace mygiftbox\controllers;

use mygiftbox\views\VisitorBoxView;
use mygiftbox\views\VisitorWaitView;
use mygiftbox\models\Box;

class VisitorController {

    public function getBoxVisitor($token){
        $box = Box::byToken($token);
        $v = new VisitorBoxView($box);
        $v->render();
    }

    public function getWait($token){
        $box = Box::byToken($token);
        $v = new VisitorWaitView($box);
        $v->render();
    }

}
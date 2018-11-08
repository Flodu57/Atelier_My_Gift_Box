<?php

namespace mygiftbox\controllers;

use mygiftbox\views\VisitorBoxView;
use mygiftbox\views\VisitorWaitView;
use mygiftbox\views\VisitorCagnotteView;
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

    public function getCagnotte($token){
        $box = Box::byTokenCagnotte($token);
        $v = new VisitorCagnotteView($box);
        $v->render();
    }

    public function postCagnotte($token){
        $box = Box::byTokenCagnotte($token);
        $app = \Slim\Slim::getInstance();

        if($box && $box->url_cagnotte){
            if(isset($_POST['amount'])){
                $add = $box->montant_cagnotte + intval($_POST['amount']);
                if($add <= $box->prix_total){
                    $box->montant_cagnotte = $box->montant_cagnotte + intval($_POST['amount']);
                    $box->save();
                }else{
                    $reste = $box->prix_total - $box->montant_cagnotte;
                    $app->flash('error', "Veuillez donner un montant inférieur ou égal à $reste");
                    $app->redirect($app->urlFor('visitor.cagnotte', ['token_cagnotte' => $token]));
                }
            }else{
                $app->flash('error', "Une erreur est survenue");
                $app->redirect($app->urlFor('visitor.cagnotte', ['token_cagnotte' => $token]));
            }
        }else{
            $app->flash('error', "Une erreur est survenue");
                $app->redirect($app->urlFor('visitor.cagnotte', ['token_cagnotte' => $token]));
        }
    }

}
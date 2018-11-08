<?php

namespace mygiftbox\controllers;

use mygiftbox\views\VisitorBoxView;
use mygiftbox\views\VisitorWaitView;
use mygiftbox\views\VisitorCagnotteView;
use mygiftbox\models\Box;

class VisitorController {

    public function getBoxVisitor($token){
        $app = \Slim\Slim::getInstance(); 
        $user  = User::byId($_SESSION['id_user']);
        
        $box = Box::byToken($token);
        $offers = Box::prestations();
        $reformatOffers = [];

        foreach($offers as $offer){
            array_push($reformatOffers, [
                'title' => $offer->title,
                'category_id' => $offer->category_id
            ]);
        }

        $this->twigParams['userFirstName']  = $user->first_name;
        $this->twigParams['userName']  = $user->name;;
        $this->twigParams['boxTitle']  = $box->title;
        $this->twigParams['boxAmount']  = $box->jackpot_amount;
        $this->twigParams['message']  = $box->message;
        $this->twigParams['offers']  = $reformatOffers;

        $app->render('VisitorBoxView.twig', $this->twigParams);
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

            $_POST['amount'] = filter_var($_POST['amount'],FILTER_SANITIZE_NUMBER_INT);

            if(isset($_POST['amount'])){
                $add = $box->montant_cagnotte + intval($_POST['amount']);
                $box->montant_cagnotte = $box->montant_cagnotte + intval($_POST['amount']);
                $box->save();
                
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
<?php

namespace mygiftbox\controllers;

use mygiftbox\views\VisitorBoxView;
use mygiftbox\views\VisitorWaitView;
use mygiftbox\views\VisitorCagnotteView;
use mygiftbox\models\Box;

class VisitorController extends Controller{

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
        $app = \Slim\Slim::getInstance();
        $box = Box::byTokenCagnotte($token);
        $this->twigParams['box']['title'] = $box->title;
        $this->twigParams['box']['total'] = $box->price;
        $this->twigParams['box']['jackpot_amount'] = $box->jackpot_amount;
        $this->twigParams['box']['message'] = $box->message;
        $this->twigParams['box']['user'] = $box->user;
        
        $formatOffers = [];
        $offers = $box->prestations()->get();
        foreach ($offers as $offer) {
            array_push($formatOffers, [
                'title' => $offer->title,
                'image' => $offer->image,
                'category' => $offer->category->title,
                'urlDetailed' => $this->getRoute('detailed.offer', ['categorie' => $offer->category->title, 'id' => $offer->id]),
            ]);
        }


        $this->twigParams['offers'] = $formatOffers;

        // $urlOffers = $app->urlFor('offers');

        $app->render('VisitorCagnotteView.twig', $this->twigParams);
    }

    public function postCagnotte($token){
        $box = Box::byTokenCagnotte($token);
        $app = \Slim\Slim::getInstance();

        if($box && $box->jackpot_url){

            $_POST['amount'] = filter_var($_POST['amount'],FILTER_SANITIZE_NUMBER_INT);

            if(isset($_POST['amount'])){
                $add = $box->jackpot_amount + intval($_POST['amount']);
                $box->jackpot_amount = $box->jackpot_amount + intval($_POST['amount']);
                $box->save();
                $app->flash('success', "Merci de votre participation !");
                $app->redirect($app->urlFor('visitor.cagnotte', ['token_cagnotte' => $token]));
                
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
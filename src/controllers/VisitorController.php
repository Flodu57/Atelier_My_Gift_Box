<?php

namespace mygiftbox\controllers;

use mygiftbox\views\VisitorBoxView;
use mygiftbox\views\VisitorWaitView;
use mygiftbox\views\VisitorFundingView;
use mygiftbox\models\Box;
use mygiftbox\models\User;

class VisitorController extends Controller{

    public function getBoxVisitor($token){
        $app = \Slim\Slim::getInstance(); 
        $user  = User::byId($_SESSION['id_user']);
        
        $box = Box::byToken($token);
        $offers = $box->offers()->get();
        $reformatOffers = [];

        foreach($offers as $offer){
            array_push($reformatOffers, [
                'title' => $offer->title,
                'category' => $offer->category->title,
                'image' => $offer->image
            ]);
        }

        $this->twigParams['user']['first_name']  = $user->first_name;
        $this->twigParams['user']['name']  = $user->name;;
        $this->twigParams['box']['title']  = $box->title;
        $this->twigParams['box']['jackpot_amount']  = $box->jackpot_amount;
        $this->twigParams['box']['price']  = $box->price;
        $this->twigParams['box']['message']  = $box->message;
        $this->twigParams['offers']  = $reformatOffers;

        $app->render('VisitorBoxView.twig', $this->twigParams);
    }

    public function postThanks($token){
    $app = \Slim\Slim::getInstance(); 
        
        $box = Box::byToken($token);

        if($box){
            $message = trim(filter_var($_POST['message_return'],FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
            $box->message_return = $message;
            $box->save();

            $app->flash('success', 'Vous avez remercier le créateur de ce coffret');
            $app->redirect($app->urlFor('visitor.token', compact('token')));
        }
    }

    public function getWait($token){
        $app = \Slim\Slim::getInstance(); 

        $box = Box::byToken($token);
        $date = new \DateTime($box->opening_date);
        $date_o = $date->format('Y-m-d H:i:s');
        $this->twigParams['date'] = $date_o;
        $this->twigParams['urlBox'] = $this->getRoute('visitor.token', ['token' => $box->url]);
     
        $app->render('VisitorWaitView.twig', $this->twigParams);
    }

    public function getFunding($token){
        $app = \Slim\Slim::getInstance();
        $box = Box::byTokenFunding($token);

        if(!$box){
            $app->redirect($app->urlFor('home'));
        }

        $this->twigParams['box']['title'] = $box->title;
        $this->twigParams['box']['total'] = $box->price;
        $this->twigParams['box']['jackpot_amount'] = $box->jackpot_amount;
        $this->twigParams['box']['message'] = $box->message;
        $this->twigParams['box']['user'] = $box->user;
        
        $formatOffers = [];
        $offers = $box->offers()->get();
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

        $app->render('VisitorFundingView.twig', $this->twigParams);
    }

    public function postFunding($token){
        $box = Box::byTokenFunding($token);
        $app = \Slim\Slim::getInstance();

        if($box && $box->jackpot_url){

            $_POST['amount'] = filter_var($_POST['amount'],FILTER_SANITIZE_NUMBER_INT);

            if(isset($_POST['amount'])){
                $add = $box->jackpot_amount + intval($_POST['amount']);
                $box->jackpot_amount = $box->jackpot_amount + intval($_POST['amount']);
                $box->save();
                $app->flash('success', "Merci de votre participation !");
                $app->redirect($app->urlFor('visitor.funding', ['token_funding' => $token]));
                
            }else{
                $app->flash('error', "Une erreur est survenue");
                $app->redirect($app->urlFor('visitor.funding', ['token_funding' => $token]));
            }
        }else{
            $app->flash('error', "Une erreur est survenue");
                $app->redirect($app->urlFor('visitor.funding', ['token_funding' => $token]));
        }
    }

}
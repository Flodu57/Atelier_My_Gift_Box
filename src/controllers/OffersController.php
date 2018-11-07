<?php

namespace mygiftbox\controllers;

use mygiftbox\views\OffersView;
use mygiftbox\views\OfferDetailledView;
use mygiftbox\models\Box;

class OffersController{

    public function getOffers(){
        $v = new OffersView();
        return $v->render();
    }

    public function getDetailledOffer($offer){
        $v = new OfferDetailledView($offer);
        return $v->render();
    }

    public function postAddOfferToBox($offer){

        $app = \Slim\Slim::getInstance();
        $boxId = $_POST['box_id'];

        $box = Box::byId($boxId);

        if(!$offer->boxes()->where('id', '=', $boxId)->first()){
            if($box){
                $box->prestations()->attach($offer);
    
                $app->flash('success', "Prestation bien ajoutée au coffret $box->titre !");
                $app->redirect($app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]));
            }else{
                $app->flash('error', "Une erreur est survenue !");
                $app->redirect($app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]));
            }
        }else{
            $app->flash('error', "Cette prestation est déjà présente dans ce coffret !");
            $app->redirect($app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]));
        }
    }

}
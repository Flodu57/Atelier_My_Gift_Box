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
                $box->prix_total = $box->prix_total + $offer->prix;
                $box->save();

                $app->flash('success', "Prestation bien ajoutée à la box $box->titre !");
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

    public function getDeleteOffer($id){
        $app = \Slim\Slim::getInstance();
        $offer = Prestation::byId($id);
        if($offer){
            $offer->boxes()->detach($id);
            $app->flash('success', "La prestation a bien été supprimée.");
        } else {
            $app->flash('error', "Une erreur s'est produite");
        }
        $app->redirect($app->urlFor('offers'));
    }

    public function getModifyOffer($id){
        $app = \Slim\Slim::getInstance();
        $offer = Prestation::byId($id);
        if($offer){
            //REDIRECT TO MODIFY PAGE
        } else {
            $app->flash('error', "Une erreur s'est produite.");
        }
        $app->redirect($app->urlFor('offers'));
    }

    public function getLockOffer($id){
        $app = \Slim\Slim::getInstance();
        $offer = Prestation::byId($id);
        if($offer){
            if($offer->suspendue){
                $offer->suspendue = false;
                $app->flash('success', "La prestation a bien été rétablie.");
            } else {
                $offer->suspendue = true;
                $app->flash('success', "La prestation a bien été suspendue.");
            }
            $offer->save();
        } else {
            $app->flash('error', "Une erreur s'est produite.");
        }
        $app->redirect($app->urlFor('offers'));
    }
}
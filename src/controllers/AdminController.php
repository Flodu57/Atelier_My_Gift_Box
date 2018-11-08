<?php

namespace mygiftbox\controllers;

use mygiftbox\models\Offer;
use mygiftbox\models\User;

class AdminController extends Controller {

    public function getDeleteOffer($id){
        $app = \Slim\Slim::getInstance();
        if(User::current()->isAdmin()){
            $offer = Offer::byId($id);
            if($offer){
                $offer->boxes()->detach($id);
                $offer->delete();
                $app->flash('success', "La prestation a bien été supprimée.");
            } else {
                $app->flash('error', "Une erreur s'est produite");
            }
        } else {
            $app->flash('error', "Vous ne disposez pas des droits administrateurs.");
        }
        $app->redirect($app->urlFor('offers'));
    }

    public function getModifyOffer($id){
        $app = \Slim\Slim::getInstance();
        if(User::current()->isAdmin()){
            $offer = Offer::byId($id);
            if($offer){
                //REDIRECT TO MODIFY PAGE
            } else {
                $app->flash('error', "Une erreur s'est produite.");
            }
        }else {
            $app->flash('error', "Vous ne disposez pas des droits administrateurs.");
        }
        $app->redirect($app->urlFor('offers'));
    }

    public function getLockOffer($id){
        $app = \Slim\Slim::getInstance();
        if(User::current()->isAdmin()){
            $offer = Offer::byId($id);
            if($offer){
                if($offer->on_hold){
                    $offer->on_hold = false;
                    $app->flash('success', "La prestation a bien été rétablie.");
                } else {
                    $offer->on_hold = true;
                    $app->flash('success', "La prestation a bien été suspendue.");
                }
                $offer->save();
            } else {
                $app->flash('error', "Une erreur s'est produite.");
            }
        }else {
            $app->flash('error', "Vous ne disposez pas des droits administrateurs.");
        }
        $app->redirect($app->urlFor('offers'));
    }

    public function getCreateOrModifyOffer($id = null){
        
    }

    public function postCreateOrModifyOffer($id = null){
        $app = \Slim\Slim::getInstance();
        if(User::current()->isAdmin()){
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            if($id === null){
                Offer::addNew($title, $description, $price, $img, $_POST['category']);
                $app->flash('success', "La prestation a bien été ajoutée.");
            } else {
                Offer::modify($id, $title, $description, $price, $img, $_POST['category']);
                $app->flash('success', "La prestation a bien été modifiée.");
            }
        } else {
            $app->flash('error', "Vous ne disposez pas des droits administrateurs.");
        }
        $app->redirect($app->urlFor('offers'));
    }
}
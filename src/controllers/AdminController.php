<?php

namespace mygiftbox\controllers;

use mygiftbox\models\Prestation;

class AdminController {

    public function getDeleteOffer($id){
        $app = \Slim\Slim::getInstance();
        if(User::byId($_SESSION['id_user'])->account_level == 2){
            $offer = Prestation::byId($id);
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
        if(User::byId($_SESSION['id_user'])->account_level == 2){
            $offer = Prestation::byId($id);
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
        if(User::byId($_SESSION['id_user'])->account_level == 2){
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
        }else {
            $app->flash('error', "Vous ne disposez pas des droits administrateurs.");
        }
        $app->redirect($app->urlFor('offers'));
    }
}
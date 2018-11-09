<?php

namespace mygiftbox\controllers;

use mygiftbox\views\OffersView;
use mygiftbox\views\OfferDetailedView;
use mygiftbox\models\Box;
use mygiftbox\models\Offer;
use mygiftbox\models\Category;

class OffersController extends Controller {

    public function getOffers(){
        $app = \Slim\Slim::getInstance();
        $offers = [];
        $categories = [];
        foreach(Category::all() as $category){
            array_push($categories, ['title' => $category->title, 'url' => $app->urlFor('offers.category', ['category' => $category->title])]);
        }
        foreach(Offer::all() as $offer){
            array_push($offers,
                ['title' => $offer->title,
                 'img' => $offer->image,
                 'categ' => $offer->category->title,
                 'price' => $offer->price,
                 'on_hold' => $offer->on_hold,
                 'urls' => [
                        'main' => $app->urlFor('detailed.offer', ['category' => $offer->category->title, 'id' => $offer->id]),
                        'delete' => $app->urlFor('deleteOffer', ['id' => $offer->id]),
                        'modify' => $app->urlFor('modifyOffer', ['id' => $offer->id]),
                        'lock' => $app->urlFor('lockOffer', ['id' => $offer->id])
                        ],
                ]);
        }
        $this->twigParams['categories'] = $categories;
        $this->twigParams['offers'] = $offers;
        $this->twigParams['sorting_category'] = 'all';
        $app->render('OffersView.twig', $this->twigParams);
    }

    public function getOffersByCategory($category){
        $v = new OffersView($category);
        return $v->render();
    }

    public function getDetailedOffer($offer_id){
        $app = \Slim\Slim::getInstance();
        $boxes = Box::boxesForCurrentUser();
        $offer = Offer::byId($offer_id);
        $this->twigParams['offer'] = $offer;
        $this->twigParams['boxes'] = $boxes;
        $app->render('DetailedOffer.twig', $this->twigParams);
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

}
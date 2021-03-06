<?php

namespace mygiftbox\controllers;

use mygiftbox\views\OffersView;
use mygiftbox\views\OfferDetailedView;
use mygiftbox\models\Box;
use mygiftbox\models\User;
use mygiftbox\models\Offer;
use mygiftbox\models\Category;

class OffersController extends Controller {

    public function getOffers($sort, $category_name = 'all'){
        $app = \Slim\Slim::getInstance();
        $categories = [];
        foreach(Category::all() as $category){
            array_push($categories, ['title' => $category->title, 'url' => $app->urlFor('offers.category', ['category' => $category->title])]);
        } 
        if($category_name == 'all'){
            if($sort == 0)
                $offers_pull = Offer::orderBy('price', 'ASC')->get();
            else
                $offers_pull = Offer::orderBy('price', 'DESC')->get();
        } else {
            if($sort == 0)
                $offers_pull = Category::byName($category_name)->offers()->orderBy('price', 'ASC')->get();
            else
                $offers_pull = Category::byName($category_name)->offers()->orderBy('price', 'DESC')->get();
        }
        $offers = [];
        foreach($offers_pull as $offer){
            array_push($offers,
                ['title' => $offer->title,
                 'img' => $offer->image,
                 'categ' => $offer->category->title,
                 'price' => $offer->price,
                 'on_hold' => $offer->on_hold,
                 'urls' => [
                        'main' => $app->urlFor('detailed.offer', ['category' => $offer->category()->first()->title, 'id' => $offer->id]),
                        'delete' => $app->urlFor('deleteOffer', ['id' => $offer->id]),
                        'modify' => $app->urlFor('createModifyOffer', ['id' => $offer->id]),
                        'lock' => $app->urlFor('lockOffer', ['id' => $offer->id])
                        ],
                ]);
        }
        $this->twigParams['categories'] = $categories;
        $this->twigParams['offers'] = $offers;
        $this->twigParams['sorting_order'] = $sort;
        $this->twigParams['sorting_category'] = $category_name;
        $app->render('OffersView.twig', $this->twigParams);
    }

    public function getDetailedOffer($offer_id){
        $app = \Slim\Slim::getInstance();
        $boxes = User::boxesForCurrentUser();
        $offer = Offer::byId($offer_id);
        $this->twigParams['offer'] = $offer;
        $this->twigParams['boxes'] = $boxes;
        $this->twigParams['unpaidBoxes'] = User::unpaidBoxesForCurrentUser();
        $this->twigParams['url'] = $app->urlFor('profile.createBox');
        $app->render('DetailedOfferView.twig', $this->twigParams);
    }

    public function postAddOfferToBox($id){
        $app = \Slim\Slim::getInstance();
        $boxId = $_POST['box_id'];
        $offer = Offer::byId($id);
        $box = Box::byId($boxId);

        if(!$offer->boxes()->where('id', '=', $boxId)->first()){
            if($box){
                $box->offers()->attach($offer);
                $box->price = $box->price + $offer->price;
                $box->save();

                $app->flash('success', "Prestation bien ajoutée à la box $box->title !");
                $app->redirect($app->urlFor('detailed.offer', ['categorie' => $offer->category->title, 'id' => $offer->id]));
            }else{
                $app->flash('error', "Une erreur est survenue !");
                $app->redirect($app->urlFor('detailed.offer', ['categorie' => $offer->category->title, 'id' => $offer->id]));
            }
        }else{
            $app->flash('error', "Cette prestation est déjà présente dans ce coffret !");
            $app->redirect($app->urlFor('detailed.offer', ['categorie' => $offer->category->title, 'id' => $offer->id]));
        }
    }
}
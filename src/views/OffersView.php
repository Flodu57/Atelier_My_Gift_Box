<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;
use mygiftbox\models\Categorie;
use mygiftbox\models\User;

class OffersView extends View{

    private $sorting_category;

    public function __construct($sorting_category = "all"){
        parent::__construct();
        $this->sorting_category = $sorting_category;
    }

    public function render(){
        $app = \Slim\Slim::getInstance();
        $link = $this->getLink();
        $error = parent::error();

        if($this->sorting_category == "all")
            $listed_offers = $this->listOffers(Prestation::all());
        else
            $listed_offers = $this->listOffersByCategory(Prestation::all(), $this->sorting_category);

        $listed_categories = $this->listCategories(Categorie::all());
        $html = <<<END
        <!DOCTYPE html>
            <html>
                $this->header
                <body>
                    <div class='container'>
                        $this->menu
                        <button class="admin admin-create" onclick="$link/create_offer">Ajouter une prestation</button>
                        <div class='menu_categories'>
                            <p>Trier par catégories</p>
                            <i id='slide_arrow' class='fas fa-angle-down'></i>
                            <div id='cat_list' class='cat_list'>
                                $listed_categories
                            </div>
                        </div>
                        $error
                        <div class='offers'> 
                           $listed_offers
                        </div>
                        $this->footer
                    </div>
                    <script src='$link/assets/scripts/jquery.js'></script>
                    <script src='$link/assets/scripts/offers_sliding_sort.js'></script>
                </body>
            </html>
END;
        echo $html;
    }

    public function listCategories($categs){
        $app = \Slim\Slim::getInstance();
        $urlOffers = $app->urlFor('offers');
        if($this->sorting_category == 'all')
            $cat = "<a href='$urlOffers' class='selected_category'>Toutes</a>";
        else
            $cat = "<a href='$urlOffers'>Toutes</a>";
        
        foreach($categs as $categ) {
            $urlCateg = $app->urlFor('offers.category', ['category' => $categ->titre]);
            if($this->sorting_category == $categ->titre){
                $cat .= <<<END
                <a href='$urlCateg' class='selected_category'>$categ->titre</a>
END;
            }
            else {
                $cat .= <<<END
                <a href='$urlCateg'>$categ->titre</a>
END;
            }
        }
        return $cat;
    }

    public function listOffers($offers){
        $app = \Slim\Slim::getInstance();
        $link = $this->getLink();
        $pres = "";
        foreach($offers as $offer) {
            $urlDetailledOffer = $app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]);
            $categorie = $offer->categorie->titre;
            $urlDelete = $app->urlFor('deleteOffer', ['id' => $offer->id]);
            $urlModify = $app->urlFor('modifyOffer', ['id' => $offer->id]);
            $urlLock = $app->urlFor('lockOffer', ['id' => $offer->id]);
            if($offer->suspendue){
                $lock = "<a href='$urlLock'><i class='fa fa-lock-open'></i></a>";
            } else {
                $lock = "<a href='$urlLock'><i class='fa fa-unlock-alt'></i></a>";
            }
            $admin_functions = "";
            if(User::byId($_SESSION['id_user'])->account_level == 2){
                $admin_functions = <<<END
                <a href='$urlDelete'><i class='fa fa-trash'></i></a>
                $lock
                <a href='$urlModify'><i class='fa fa-cog'></i></a>
END;
            }
            $pres .= <<<END
            <div class="offer">
            <a href='$urlDetailledOffer' >
                <img src='$link/assets/img/prestations/$offer->image'>
                <div class='offer_bottom'>
                    <h2>$offer->titre</h2>
                    <div class='offer_bottom_infos'>
                        <p>$categorie</p>
                        <p>$offer->prix €</p>
                        $admin_functions
                    </div>
                </div>
            </a>
            </div>
END;
        }
        return $pres;
    }

    public function listOffersByCategory($offers, $sorting_category){
        $app = \Slim\Slim::getInstance();
        $link = $this->getLink();
        $pres = "";
        foreach($offers as $offer) {
            if($offer->categorie->titre == $sorting_category){
                $urlDetailledOffer = $app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]);
                $categorie = $offer->categorie->titre;
                $pres .= <<<END
                <a href='$urlDetailledOffer' class='offer'>
                    <img src='$link/assets/img/prestations/$offer->image'>
                    <div class='offer_bottom'>
                        <h2>$offer->titre</h2>
                        <div class='offer_bottom_infos'>
                            <p>$categorie</p>
                            <p>$offer->prix €</p>
                        </div>
                    </div>
                </a>
END;
            }
        }
        return $pres;
    }

}
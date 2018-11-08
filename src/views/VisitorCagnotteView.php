<?php

namespace mygiftbox\views;


class VisitorCagnotteView extends View{

    private $box;

    public function __construct($box){
        parent::__construct();
        $this->box = $box;
    }

    public function render(){
        $link = $this->getLink();
        $error = parent::error();
        $titre = $this->box->titre;
        $total = $this->box->prix_total;
        $amount_cagnotte = $this->box->montant_cagnotte;
        $message = $this->box->message;
        $user = $this->box->user;
        $error = parent::error();

        $app = \Slim\Slim::getInstance();

        $urlOffers = $app->urlFor('offers');

        $pres = "";
        $offers = $this->box->prestations()->get();
        foreach($offers as $offer) {
            $urlDetailledOffer = $app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]);
            $urlDeleteOffer = $app->urlFor('profile.deleteOffer', ['slug' => $offer->boxes()->first()->slug,'id' => $offer->id]);

            $pres .= <<<END
            <div class='containerBox'>
                <a href='$urlDetailledOffer' class='offer'>
                    <img src='$link/assets/img/prestations/$offer->image'>
                    <div class='offer_bottom'>
                        <h2 class='label label_title'>$offer->titre</h2>
                        <div class='offer_bottom_infos'>
                            <p class='label label_category'>$offer->categorie_id</p>
                        </div>
                    </div>
                </a>
            </div>
END;
        }

        $html = <<<END
            <html>
                $this->header
                <body>     
                    <div class='container'>
                        $this->menu
                        $error
                        <div class='box'>
                            <div class='box_head visitor'>
                                <h2>$titre</h2>
                                $user->nom
                                $user->prenom
                                <p>Cagnotte : $amount_cagnotte/$total €</p>
                            </div>  
                            <p>$message</p>

                            <div class='box_grid'>
                                $pres 
                            </div>
                            <form class='participate' method='POST'>
                                <h3>Participer à la cagnotte</h3>
                                <input type='text' name='amount'>
                                <div class='buttonLayout'>
                                    <button class='button' type='submit'>Participer</button>
                                </div>
                            </form>
                        </div>
                        $this->footer
                    </div>
                </body>
            </html>  
END;
        echo $html;
    }


}
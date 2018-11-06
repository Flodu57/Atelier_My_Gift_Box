<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;

class OffersView extends View{

    public function render(){
        $header = $this->header("Prestations");
        $menu = $this->menu();
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();

        $offers = Prestation::all();
        foreach($offers as $k => $v) {

        }

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                        
                        $menu
                        <div class='offers'> 
                        $offers
                            <a href='#' class='offer'>
                                <img src='$link/assets/img/diner.jpg'>
                                <h2>Prestations</h2>
                                <div class='offer_info'>
                                    <p>Catégorie</p>
                                    <p>XX €</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}
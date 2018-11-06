<?php

namespace mygiftbox\views;

class OffersView extends View{

    public function render(){
        $header = $this->header("Prestations");
        $menu = $this->menu();
        $link = $this->getLink();

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                        
                        $menu
                        <div class='offers'> 
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
<?php

namespace mygiftbox\views;

class OffersView extends View{

    public function render(){
        $link = $this->getLink();

        $html = "


            <html>
                $this->header
                <body>
                    <div class='container'>
                        
                        $this->menu
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
<?php

namespace mygiftbox\views;

class BoxView extends View{

    private $box;

    public function __construct($box){
        parent::__construct();
        $this->box = $box;
    }

    public function render(){
        $error = parent::error();
        $titre = $this->box->titre;
        $total = $this->box->prix_total;

        $html = <<<END
            <html>
                $this->header
                <body>     
                    <div class='container'>
                        $this->menu
                        
                        <div class='box'>
                          <div class='box_head'>
                            <h2>$titre</h2>
                            <div class='box_head_total'>
                                <p class='p_total'>Total </p>
                                $total
                                <p>€</p>
                            </div>
                          </div>  
                        </div>

                        $this->footer
                    </div>
                </body>
            </html>  
END;
        echo $html;
    }

}
<?php

namespace mygiftbox\views;
use DateTime;

class VisitorWaitView extends View{

    private $box;

    public function __construct($box){
        parent::__construct();
        $this->box = $box;
    }

    public function render(){
        $link = $this->getLink();
        $error = parent::error();
        $date = new DateTime($this->box->date_ouverture);
        $date_o = $date->format('Y-m-d H:i:s');

        $app = \Slim\Slim::getInstance();
        $urlBox = $app->urlFor('visitor.token', ['token' => $this->box->url]);

        $html = <<<END
            <html>
                $this->header
                <body>     
                    <div class='container'>
                        $this->menu
                        $error
                        <input type='hidden' id='date' name="date_ouverture" value="$date_o">
                        <div class='countdown'>
                            <h1 class='couldown_title'>Temps restant avant l'ouverture de votre coffret</h1>
                            <div id='countdown' class='countdown_date'></div>
                            <div class='buttonLayout'>
                                <a href="$urlBox" id='openBox' class='button'>Ouvrir mon coffret</a>
                            </div>
                        </div>
                        $this->footer
                    </div>
                    <script src='$link/assets/scripts/jquery.js'></script>
                    <script src='$link/assets/scripts/countdown.js'></script>
                </body>
            </html>  
END;
        echo $html;
    }


}
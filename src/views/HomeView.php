<?php

namespace mygiftbox\views;

class HomeView extends View {

    public function render(){
        $header = $this->header();
        $menu = $this->menu();
        $s = $_SESSION['id_user'];
        $html = <<<END
        <html>
            $header
            <body>
                $menu
                $s
            </body>
        </html>
END;
        echo $html;
    }   
}
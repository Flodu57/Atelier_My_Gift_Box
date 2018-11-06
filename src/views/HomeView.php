<?php

namespace mygiftbox\views;

class HomeView extends View {

    public function render(){
        $header = $this->header();
        $menu = $this->menu();
        $html = <<<END
        <html>
            $header
            <body>
                $menu
            </body>
        </html>
END;
        echo $html;
    }   
}
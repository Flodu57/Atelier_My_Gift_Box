<?php

namespace mygiftbox\views;

class HomeView extends View {

    public function render(){
        $html = <<<END
        <html>
            $this->header
            <body>
                $this->menu
            </body>
        </html>
END;
        echo $html;
    }   
}
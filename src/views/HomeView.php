<?php

namespace mygiftbox\views;

class HomeView extends View {

    public function render(){
        $header = $this->header();
        $menu = $this->menu();
        $footer = $this->footer();
        $html = "
        <html>
            $header
            <body>
                <div class='container'>
                $menu
                <div class='home'>
                    <h1 class='label label_welcome'>Bienvenue sur MyGiftBox !</h1>
                    <div class='banner'>
                        <img src='../../assets/img/home_gift.jpg' class='img_welcome'>
                        </div>
                        <p class='label label_text'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dignissim vulputate vehicula. Proin auctor felis quis justo finibus, nec venenatis ligula consectetur. Vivamus vel metus ipsum. Cras in maximus erat. Donec rutrum cursus arcu eu accumsan. Donec feugiat dignissim metus, dignissim imperdiet ex malesuada eu. Nulla vel feugiat ipsum. Vivamus mauris tellus, pharetra vitae bibendum eget, mollis quis est. Sed egestas venenatis odio at lacinia. Morbi sed ipsum sit amet nisl sodales malesuada quis ac sem.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dignissim vulputate vehicula. Proin auctor felis quis justo finibus, nec venenatis ligula consectetur. Vivamus vel metus ipsum. Cras in maximus erat. Donec rutrum cursus arcu eu accumsan. Donec feugiat dignissim metus, dignissim imperdiet ex malesuada eu. Nulla vel feugiat ipsum. Vivamus mauris tellus, pharetra vitae bibendum eget, mollis quis est. Sed egestas venenatis odio at lacinia. Morbi sed ipsum sit amet nisl sodales malesuada quis ac sem.</p>
                    </div>
                    <button type='submit' class='button button_createBox'>Commencer ma box</button>
                </body>
                $footer
            </div>
        </html>
        ";
        echo $html;
    }   
}
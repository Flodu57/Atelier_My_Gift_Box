<?php

namespace mygiftbox\views;

class CreateBoxView extends View{

    public function render(){
        $link = $this->getLink();
        $error = parent::error();
        $html = <<<END
            <html>
                $this->header
                <body>     
                    <div class='container'>
                        $this->menu
                        $error
                        
                        <div class='create_box'>
                            <h1>Créer une box</h1>

                            <form class='create_box_form' method='POST'>
                                <div class='form_group'>
                                    <p class='label label_title'>Titre</p>
                                    <input type='text' name='title' class='input input_title'>
                                </div>

                                <div class='form_group'>
                                    <p class='label label_date'>Date</p>
                                    <input type='date' name='date' class='input input_date' id='inputdate'>
                                </div>
                                <button type='submit' class='button buttonCreateBox'>Créer</button>
                            </form>
                        </div>

                        $this->footer
                    </div>
                    <script src='$link/assets/scripts/jquery.js'></script>
                    <script src='$link/assets/scripts/dateinput.js'></script>
                </body>
            </html>  
END;
        echo $html;
    }

}
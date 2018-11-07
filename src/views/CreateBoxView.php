<?php

namespace mygiftbox\views;

class CreateBoxView extends View{

    public function render(){
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
                                    <p class='label label_password'>Titre</p>
                                    <input type='text' name='title' class='input input_titre'>
                                </div>

                                <div class='form_group'>
                                    <p class='label label_password'>Date</p>
                                    <input type='date' name='date' class='input input_date'>
                                </div>
                                <button type='submit'>Ajouter</button>
                            </form>
                        </div>

                        $this->footer
                    </div>
                </body>
            </html>  
END;
        echo $html;
    }

}
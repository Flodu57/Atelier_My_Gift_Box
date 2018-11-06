<?php

namespace mygiftbox\views;

class PrestationsView extends View{

    public function render(){
        $header = $this->header("Prestations");
        $menu = $this->menu();

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                        
                        $menu
                        <div class='register'> 
                            <p class='label label_nom'>Nooooom</p>
                            <input type='text' class='input input_nom'>
                            <p class='label label_prenom'>Prénom</p>
                            <input type='text' class='input input_prenom'>
                            <p class='label label_email'>Email</p>
                            <input type='text' class='input input_email'>
                            <p class='label label_password'>Mot de passe</p>
                            <input type='text' class='input input_password'>
                            <div>
                                <a href=' class='label label_alreadyRegister'>Déjà inscrit ?</a>
                                <button type='submit' class='button button_login'>Register</button>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}
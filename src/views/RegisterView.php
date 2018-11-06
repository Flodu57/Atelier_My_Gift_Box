<?php

namespace mygiftbox\views;

class RegisterView extends View{

    public function render(){
        $header = $this->header("Register");
        $menu = $this->menu();

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                        ".parent::error()."
                        $menu
                        <form class='register' method='POST'> 
                            <p class='label label_nom'>Nom</p>
                            <input type='text' name='lastname' class='input input_nom'>

                            <p class='label label_prenom'>Prénom</p>
                            <input type='text' name='firstname' class='input input_prenom'>

                            <p class='label label_email'>Email</p>
                            <input type='text' name='email' class='input input_email'>

                            <p class='label label_password'>Mot de passe</p>
                            <input type='password' name='password' class='input input_password'>

                            <p class='label label_password'>Confirmer le mot de passe</p>
                            <input type='password' name='password_confirm' class='input input_password'>
                            <div>
                                <a href=' class='label label_alreadyRegister'>Déjà inscrit ?</a>
                                <button type='submit' class='button button_login'>Register</button>
                            </div>
                        </form>
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}
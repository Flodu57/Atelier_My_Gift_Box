<?php

namespace mygiftbox\views;

class LoginView extends View{

    public function render(){
        $header = $this->header();
        $menu = $this->menu();

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                    ".parent::error()."
                        
                        $menu
                        <form class='login' method='POST'> 
                            <p class='label label_email'>Email</p>
                            <input type='email' name='email' class='input input_email'>
                            <p class='label label_password'>Mot de passe</p>
                            <input type='password' name='password' class='input input_password'>
                            <div>
                                <a href='' class='label label_passwordLost'>Mot de passe oublié ?</a>
                                <button type='submit' class='button button_login'>Login</button>
                            </div>
                        </form>
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}
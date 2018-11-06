<?php

namespace mygiftbox\views;

class LoginView extends View{

    public function render(){
        $header = $this->header("Login");
        $menu = $this->menu();
        $footer = $this->footer();

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                        
                        $menu
                        <div class='login'> 
                            <p class='label label_email'>Email</p>
                            <input type='text' class='input input_email'>
                            <p class='label label_password'>Mot de passe</p>
                            <input type='text' class='input input_password'>
                            <div>
                                <a href='' class='label label_passwordLost'>Mot de passe oublié ?</a>
                                <button type='submit' class='button button_login'>Login</button>
                            </div>
                        </div>
                        $footer
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}
<?php

namespace mygiftbox\views;

class LoginView extends View{

    public function render(){
        $app = \Slim\Slim::getInstance();
        $urlForgot = $app->urlFor('forgotpass');
        $error = parent::error();
        $html = <<<END
            <html>
                $this->header
                <body>
                    <div class='container'>
                        $this->menu
                        $error
                        <form class='login' method='POST'> 
                            <p class='label label_email'>Email</p>
                            <input type='email' name='email' class='input input_email'>
                            <p class='label label_password'>Mot de passe</p>
                            <input type='password' name='password' class='input input_password'>
                            <div>
                                <a href='$urlForgot' class='label label_passwordLost'>Mot de passe oublié ?</a>
                                <button type='submit' class='button button_login'>Connexion</button>
                            </div>
                        </form>
                        $this->footer
                    </div>
                </body>
            </html>
END;
        echo $html;
    }

}
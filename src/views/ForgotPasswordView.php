<?php

namespace mygiftbox\Views;

class ForgotPasswordView extends View {

    public function render(){
        $app = \Slim\Slim::getInstance();
        $urlForgot = $app->urlFor('post_forgotpassword');
        echo <<<END
        <html>
            $this->header
            <body>
                <div class="container">
                    $this->menu
                    <h2>Récupération du mot de passe</h2>
                    <form class="login" action='$urlForgot' method='post'>
                        <p class='label label_email'>Email</p>
                        <input type='email' name='email' class='input input_email'>
                        <button type='submit' class='button button_login'>Récupération</button>
                    </form>
                </div>
            </body>
        </html>
END;
    }

}
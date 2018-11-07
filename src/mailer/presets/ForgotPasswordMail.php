<?php

namespace mygiftbox\mailer\presets;

class ForgotPasswordMail {

    public static function Mail($app, $email, $options){
        $hash = $options[0];
        $pass = $options[1];
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        $route = "$link/forgotpasslink?email=$email&hash=$hash"; 
        $urlForgot = $app->urlFor('forgotpasslink') . "?email=$email&hash=$hash";
        $html = <<<MAIL
<!DOCTYPE html>
<html>    
<head>
    
</head>
        
<body>
    <p>Un mot de passe provisoire de récupération a été demandé pour votre compte MyGiftBox.<br></p>
    <p>Si vous êtes à l'origine de cette action, cliquez sur ce lien pour activer le mot de passe : 
    <a href=$route>$urlForgot</a>.<br><br>
    Votre nouveau mot de passe est le suivant : $pass<br></p>
    <p>Nous vous invitons à vous connecter dès maintenant !</p>
</body>
</html>
MAIL;
        return $html;
    }
}
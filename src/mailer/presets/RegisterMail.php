<?php

namespace mygiftbox\mailer\presets;

class RegisterMail {

    public static function Mail($app, $email, $options){
        $hash = $options[0];
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        $route = "$link/mailcheck?email=$email&hash=$hash";
        $urlCheck = $app->urlFor('mailcheck') . "?email=$email&hash=$hash";
        $html = <<<MAIL
<!DOCTYPE html>
<html>

<head>
    
</head>

<body>
    <p>Merci de vous être inscrit sur MyGiftBox !<br>
    Pour finaliser votre inscription, veuillez valider votre compte en cliquant sur le lien ci-dessous : </p>
    <a href=$route>$urlCheck</a>
</body>
</html>
MAIL;
        return $html;
    }
}
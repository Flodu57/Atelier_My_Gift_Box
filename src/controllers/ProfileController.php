<?php

namespace mygiftbox\controllers;

use mygiftbox\views\ProfileSettingsView;
use mygiftbox\views\ProfileView;
use mygiftbox\views\CreateBoxView;
use mygiftbox\views\BoxView;
use mygiftbox\models\User;
use mygiftbox\models\Box;


class ProfileController extends Controller{

    public function getSettings(){
        $app = \Slim\Slim::getInstance();
        $app->render('ProfileSettingsView.twig', $this->twigParams);
    }

    public function changePassword(){
        $app = \Slim\Slim::getInstance();
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $user = User::byId($_SESSION['id_user']);

        if($user){
            if(password_verify($password,$user->password)){
                $user->password = password_hash(filter_var($_POST['new_password'],FILTER_SANITIZE_STRING), PASSWORD_DEFAULT,['cost' => 12]);
                $user->save();
                $app->redirect($app->urlFor('logout'));
            }
        }

        
    }

    public function deleteAccount(){
        $app = \Slim\Slim::getInstance();
        $user     = User::byId($_SESSION['id_user']);
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

        if($user){
            if(password_verify($password,$user->password)){
                $user->delete();
                $app->redirect($app->urlFor('logout'));
            }
        }

    }

    public function getProfile(){
        $user  = User::byId($_SESSION['id_user']);
        $boxes = Box::byUserId($_SESSION['id_user']);

        $reformatBox = [];

        foreach ($boxes as $box) {
            $slug = Box::getSlug($box->title);
            array_push($reformatBox, [
                'title' => $box->title,
                'jackpot_url' => $box->jackpot_url,
                'jackpot_amount' => $box->jackpot_amount,
                'price' => $box->price,
                'urlBox' => $this->getRoute('profile.box', compact('slug')),
                'urlDeleteBox' => $this->getRoute('profile.deleteBox', compact('slug'))
            ]);
        }

        
        $this->twigParams['user']  = User::byId($_SESSION['id_user']);
        $this->twigParams['boxes'] = $reformatBox;
        $app = \Slim\Slim::getInstance();
        $app->render('ProfileView.twig', $this->twigParams);
    }

    public function getCreateBox(){
        $app = \Slim\Slim::getInstance();
        $app->render('CreateBoxView.twig', $this->twigParams);
    }

    public function postCreateBox(){
        $app = \Slim\Slim::getInstance();
        
        if(isset($_POST['title']) && isset($_POST['title'])){
            $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
            $date  = filter_var($_POST['date'],FILTER_SANITIZE_STRING);
            $token = bin2hex(random_bytes(12));

            if(!empty($title) && !empty($date)){
                if(Box::exists($title)){
                    $app->flash('error','Vous avez déjà un coffret avec ce titre');
                    $app->redirect($app->urlFor('profile.createBox'));
                }else{
                    $box = new Box();
                    $box->user_id        = $_SESSION['id_user'];
                    $box->title          = $title;
                    $box->slug           = Box::getSlug($title);
                    $box->opening_date   = $date;
                    $box->url            = $token;
                    $box->status          = 'En cours';

                    if(isset($_POST['funding'])){
                        $box->jackpot_url     = bin2hex(random_bytes(5));
                        $box->jackpot_amount  = 0;
                    }

                    $box->save();

                    $app->flash('success',"Le coffret a bien été créé, vous pouvez désormais ajouter des prestations dedans ! ");
                    $app->redirect($app->urlFor('offers'));
                }
            }else{
                $app->flash('error','Veuillez remplir tous les champs');
                $app->redirect($app->urlFor('profile.createBox'));
            }

            
        }else{
            $app->flash('error','Veuillez remplir tous les champs');
            $app->redirect($app->urlFor('profile.createBox'));
        }
    }

    public function getBox($slug){
        $app = \Slim\Slim::getInstance();
        $box = Box::bySlug($slug);
        $this->twigParams['box']['title'] = $box->title;
        $this->twigParams['box']['total'] = $box->price;
        $this->twigParams['box']['paid'] = $box->paid;
        $this->twigParams['box']['message'] = $box->message;
        $this->twigParams['box']['message_return'] = $box->message_return;
        $this->twigParams['box']['jackpot_url'] = $box->jackpot_url;
        $this->twigParams['box']['status'] = $box->status;
        $this->twigParams['box']['urlClose'] = $this->getRoute('profile.closeFunding', ['slug' => $box->slug]);

        $offers = $box->offers()->get();

        if($box->jackpot_url){
            $total = $box->price;
            $jackpot_amount = $box->jackpot_amount;
            if($box->status == 'closed'){
                $this->twigParams['box']['payment'] = "La cagnotte est fermée et a totalisé : $jackpot_amount / $total €";
            }

            $this->twigParams['box']['payment'] = "Cagnotte : $jackpot_amount / $total €";
        }
        else{
            $p = $box->paid ? 'Payé' : 'Non payé';
            $with = $box->payment_method ? "avec $box->payment_method" : '';
            $this->twigParams['box']['payment'] = "Payer : $p $with ";
        }

        if(!$box->jackpot_url && $box->offers->count() >= 2 ) {
            $this->twigParams['box']['paymentButton']['message'] = 'Passer au payement' ;
            $this->twigParams['box']['paymentButton']['amount'] = $box->price ;
            $this->twigParams['box']['url'] = $app->request()->getUrl().$this->getRoute('visitor.token', ['token' => $box->url]);

        } else{
            $this->twigParams['box']['paymentButton']['type'] = "funding";
            $this->twigParams['box']['url'] = $app->request()->getUrl().$this->getRoute('visitor.funding', ['token_funding' => $box->jackpot_url]);
            $this->twigParams['box']['urlReceiver'] = $app->request()->getUrl().$this->getRoute('visitor.token', ['token' => $box->url]);
            $this->twigParams['box']['paymentButton']['canClose'] = 0;

            if($box->jackpot_amount >= $box->price && $box->status != 'closed' && $box->prestations->count() >= 2){
                $urlClose = $this->getRoute('profile.closeFunding', ['slug' => $box->slug]);

                $this->twigParams['box']['paymentButton']['canClose'] = 1;
                $this->twigParams['box']['paymentButton']['message'] = 'Fermer la cagnotte' ;
                $this->twigParams['box']['paymentButton']['url'] = $urlClose;
            }
        }       

        $formatOffer = [];

        foreach ($offers as $offer) {
            $cat = $offer->category()->first();
            
            array_push($formatOffer, [
                'title' => $offer->title,
                'category' => $cat->title,
                'price' => $offer->price,
                'image' => $offer->image,
                'urlDeleteOffer' => $this->getRoute('profile.deleteOffer', ['slug' => $offer->boxes()->first()->slug,'id' => $offer->id]),
                'urlDetailledOffer' => $this->getRoute('detailed.offer', ['categorie' => $cat->title, 'id' => $offer->id])


            ]);
        }

        $this->twigParams['offers'] = $formatOffer;


        $app = \Slim\Slim::getInstance();
        $app->render('BoxView.twig', $this->twigParams);
    }

    public function putBox($slug){
        $app = \Slim\Slim::getInstance();
        $box = Box::bySlug($slug);
        $message = trim(filter_var($_POST['message'],FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
        $box->message = $message;
        $box->save();

        $app->flash('success', 'Votre message a été ajouté au coffret avec succès');
        $app->redirect($app->urlFor('profile.box', compact('slug')));
    }

    public function getDeleteBox($slug){
        $app = \Slim\Slim::getInstance();

        $box = Box::bySlug($slug);

        if($box){
            $box->prestations()->detach();
            $box->delete();
            $app->flash('success','Coffret supprimé avec succès.');
        }else{
            $app->flash('error','Une erreur s\'est produite !');
        }
        $app->redirect($app->urlFor('profile'));
    }

    public function getDeleteOffer($slug, $id){
        $app = \Slim\Slim::getInstance();

        $box = Box::bySlug($slug);

        $prestation = $box->prestations()->where('id', '=', $id)->first();

        if($box && $prestation){
            $box->prix_total = $box->prix_total - $prestation->prix;
            $box->save();
            $box->prestations()->detach($id);
            $app->flash('success','Prestation supprimée avec succès.');
        }else{
            $app->flash('error','Une erreur s\'est produite !');
        }
        $app->redirect($app->urlFor('profile.box', ['slug' => $slug]));
    }

    public function getCloseFunding($slug){
        $box = Box::bySlug($slug);
        $app = \Slim\Slim::getInstance();

        if($box && $box->status != 'closed'){
            $box->status = 'closed';
            $box->paid = 1;
            $box->save();
            $app->flash('success', 'La cagnotte a été fermé');
            $app->redirect($app->urlFor('profile.box', ['slug' => $box->slug]));
        }else{
            $app->flash('error', 'Une erreur est survenue');
            $app->redirect($app->urlFor('profile.box', ['slug' => $box->slug]));
        }

    }
}
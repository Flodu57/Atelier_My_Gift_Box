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
        $v = new CreateBoxView();
        $v->render();
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
                    $box->titre          = $title;
                    $box->slug           = Box::getSlug($title);
                    $box->date_ouverture = $date;
                    $box->url            = $token;
                    $box->etat           = 'En cours';

                    if(isset($_POST['cagnotte'])){
                        $box->url_cagnotte     = bin2hex(random_bytes(5));
                        $box->montant_cagnotte = 0;
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
        $box = Box::bySlug($slug);


        // $payment = $this->payment();
        // $paymentButton = $this->paymentButton();
        $this->twigParams['box']['title'] = $box->title;
        $this->twigParams['box']['total'] = $box->price;
        $this->twigParams['box']['status'] = $box->status;

        $offers = $box->prestations()->get();

        $formatOffer = [];

        foreach ($offers as $offer) {
            $cat = $offer->categorie()->first();
            echo '<pre>';
            var_dump($offer);
            echo '</pre>';
            
            die();
            array_push($formatOffer, [
                'title' => $offer->title,
                'category' => $cat->title,
                'price' => $offer->price,
                'image' => $offer->image

            ]);
        }

        $this->twigParams['offers'] = $formatOffer;


        $app = \Slim\Slim::getInstance();
        $app->render('BoxView.twig', $this->twigParams);
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

    public function getCloseCagnotte($slug){
        $box = Box::bySlug($slug);
        $app = \Slim\Slim::getInstance();

        if($box && $box->etat != 'fermé'){
            $box->etat = 'fermé';
            $box->save();
            $app->flash('success', 'La cagnotte a été fermé');
            $app->redirect($app->urlFor('profile.box', ['slug' => $box->slug]));
        }else{
            $app->flash('error', 'Une erreur est survenue');
            $app->redirect($app->urlFor('profile.box', ['slug' => $box->slug]));
        }

    }
}
<?php

namespace mygiftbox\models;


class Offer extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'offers';
    public $timestamps = false;

    public function category(){
        return $this->belongsTo('mygiftbox\models\Category');
    }

    public function boxes(){
        return $this->belongsToMany('mygiftbox\models\Box');
    }

    public static function byId($id) {
        return parent::where('id', '=', $id)->first();
    }

    public static function availables(){
        return parent::where('on_hold','=',false)->get();
    }

    public static function addNew($title, $description, $price, $img, $category_id){
        $app = \Slim\Slim::getInstance();
        $offer = new Offer();
        if($error = $offer->tryUploadImage($img, $title)){
            $offer->title = $title;
            $offer->description = $description;
            $offer->price = $price;
            $offer->category_id = $category_id;
            $offer->save();
            $app->flash('success', "La prestation a bien été ajoutée.");
        } else {
            $app->flash('error', $error);
        }
    }

    public static function modify($id, $title, $description, $price, $img, $category_id){
        $app = \Slim\Slim::getInstance();
        $offer = Offer::byId($id);
        if($error = $offer->tryUploadImage($img, $title)){
            $offer->title = $title;
            $offer->description = $description;
            $offer->price = $price;
            $offer->category_id = $category_id;
            $offer->save();
            $app->flash('success', "La prestation a bien été modifiée.");
        } else {
            $app->flash('error', $error);
        }
    }

    private function tryUploadImage($image, $name){
        $error = "";
        switch ($image['error']) {
            case UPLOAD_ERR_NO_FILE:
                return true;
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error = "La taille de l'image est invalide.";
                break;
            case 0:
                if ($image['size'] <= 100000) {
                    $validExtensions = ['.jpg', '.jpeg', '.png'];
                    switch (\mime_content_type($image['tmp_name'])) {
                        case ('image/jpeg'):
                        case ('image/jpg'):
                            $extension = '.jpeg';
                            break;
                        case ('image/png'):
                            $extension = '.png';
                            break;
                        default:
                            $error = "Extension de fichier invalide.";
                            break 2;
                    }
                    if (in_array($extension, $validExtensions)) {
                        $name = implode('_', explode(' ', $name));
                        $filename = 'assets/img/offers/' . $name . $extension;
                        if (\move_uploaded_file($image['tmp_name'], $filename)) {
                            $this->image = $name . $extension;
                            return true;
                        } else {
                            $error = "L'image n'a pas pu être uploadée.";
                        }
                    } else {
                        $error = "Extension de fichier invalide.";
                    }
                } else {
                    $error = "La taille de l'image invalide";
                }
                break;
            default:
                $error = "Une erreur est survenue.";
                break;
        }
        return $error;
    }
}
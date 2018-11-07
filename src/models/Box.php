<?php

namespace mygiftbox\models;

class Box extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'boxes';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('mygiftbox\models\User');
    }

    public function prestations(){
        return $this->belongsToMany('mygiftbox\models\Prestation');
    }

    public static function exists($title) {
        $user = User::byId($_SESSION['id_user']);
        if($user->boxes()->where('titre', '=', $title)->first())
           return true;
        else{
            return false;
        }
    }

    public static function getSlug($title)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $title);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
        return 'n-a';
        }

        return $text;
    }


}
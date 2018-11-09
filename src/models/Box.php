<?php

namespace mygiftbox\models;

class Box extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'boxes';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('mygiftbox\models\User');
    }

    public function prestations(){
        return $this->belongsToMany('mygiftbox\models\Offer');
    }

    public static function byId($id) {
        return parent::where('id', '=', $id)->first();
    }

    public static function byUserId($user_id) {
        return parent::where('user_id', '=', $user_id)->get();
    }

    public static function bySlug($slug) {
        return parent::where('slug', '=', $slug)->first();
    }

    public static function byToken($token) {
        return parent::where('url', '=', $token)->first();
    }

    public static function byTokenFunding($token) {
        return parent::where('jackpot_url', '=', $token)->first();
    }

    public static function exists($title) {
        $user = User::byId($_SESSION['id_user']);
        if($user->boxes()->where('title', '=', $title)->first())
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

    public static function boxesForCurrentUser(){
        $boxes = '';
        if(User::current()){
            $boxes = User::current()->boxes()->get();
        }
        return $boxes;
    }


}
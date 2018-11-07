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
        $user = User::where('id', '=', $_SESSION['id_user'])->first();
        if($user->boxes()->where('titre', '=', $title)->first())
           return true;
        else{
            return false;
        }
    }


}
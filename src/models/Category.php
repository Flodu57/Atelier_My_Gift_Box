<?php

namespace mygiftbox\models;

class Category extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'categories';
    public $timestamps = false;

    public function offers(){
        return $this->hasMany('mygiftbox\models\Offer');
    }

    public static function byName($name){
        return parent::where('title','=', $name)->first();
    }

    public static function byId($id){
        return parent::where('id', '=', $id)->first();
    }

}
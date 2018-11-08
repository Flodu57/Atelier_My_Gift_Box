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

}
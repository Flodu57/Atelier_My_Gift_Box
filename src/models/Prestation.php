<?php

namespace mygiftbox\models;

class Prestation extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'prestations';
    public $timestamps = false;

    public function categorie(){
        return $this->belongsTo('mygiftbox\models\Categorie');
    }

    public function boxes(){
        return $this->belongsToMany('mygiftbox\models\Box');
    }

    public static function byId($id) {
        return parent::where('id', '=', $id)->first();
    }

}
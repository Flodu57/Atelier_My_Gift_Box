<?php

namespace mygiftbox\models;

class Prestation extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'prestations';
    public $timestamps = false;

    public function categorie(){
        return $this->belongsTo('mygiftbox\Categorie');
    }

    public function boxes(){
        return $this->belongsToMany('mygiftbox\Box');
    }

}
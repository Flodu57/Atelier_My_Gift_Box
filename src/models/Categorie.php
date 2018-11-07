<?php

namespace mygiftbox\models;

class Categorie extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'categories';
    public $timestamps = false;

    public function prestations(){
        return $this->hasMany('mygiftbox\Prestation');
    }

}
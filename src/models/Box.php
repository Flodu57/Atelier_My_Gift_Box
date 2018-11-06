<?php

namespace mygiftbox\models;

class Box extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'boxes';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('mygiftbox\user');
    }

    public function prestations(){
        return $this->belongsToMany('mygiftbox\prestation');
    }

}
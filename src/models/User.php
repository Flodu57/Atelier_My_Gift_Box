<?php
namespace mygiftbox\models;

class User extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'users';
    protected $primaryKey ='id';
    public $timestamps = false;

}

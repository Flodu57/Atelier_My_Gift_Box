<?php
namespace mygiftbox\models;

class User extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'users';
    protected $primaryKey ='id';
    public $timestamps = false;

    public function boxes(){
        return $this->hasMany('mygiftbox\Box');
    }

    public static function byMail($email) {
        return parent::where('email', '=', $email)->first();
    }

    public static function exists($email) {
        if(parent::where('email','=',$email)->first()){
            return true;
        } else {
            return false;
        }
    }

}

<?php
namespace mygiftbox\models;

class User extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'users';
    protected $primaryKey ='id';
    public $timestamps = false;

    public function boxes(){
        return $this->hasMany('mygiftbox\models\Box');
    }

    public static function byMail($email) {
        return parent::where('email', '=', $email)->first();
    }

    public static function byId($id) {
        return parent::where('id', '=', $id)->first();
    }

    public static function exists($email) {
        if(parent::where('email','=',$email)->first()){
            return true;
        } else {
            return false;
        }
    }

    public static function addNew($email, $pass, $name, $first_name){
        $user = new User();
        $user->email = $email;
        $user->password = $pass;
        $user->name = $name;
        $user->first_name = $first_name;
        $user->save();
        return $user->id;
    }

}

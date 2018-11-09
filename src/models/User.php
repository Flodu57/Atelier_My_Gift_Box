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

    public static function current(){
        if(isset($_SESSION['id_user'])){
            return self::byId($_SESSION['id_user']);
        }
        return null;
    }

    public static function unpaidBoxesForCurrentUser() {
        $boxes = '';
        if(User::current()){
            $boxes = self::current()->boxes()->where('paid', '=', false)->get();
        }
        return $boxes;
    }

    public static function boxesForCurrentUser(){
        $boxes = '';
        if(User::current()){
            $boxes = self::current()->boxes()->get();
        }
        return $boxes;
    }

    public function isAdmin(){
        if($this->account_level == 2){
            return true;
        }
        return false;
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

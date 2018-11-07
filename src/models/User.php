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

    public static function exists($email) {
        $query = parent::select('email')->get();
        foreach ($query as $k => $v) {
            if ($v->email == $email) {
                return true;
            }
        }
        return false;
    }

}

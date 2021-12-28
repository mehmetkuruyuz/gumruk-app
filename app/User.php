<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','id','role','vergiNo','vergiDairesi','telefonNo','address','bolgeId'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function authorize($roles)
    {
        return true; // Bu projede ihtiyacım yok.
        //print_r($roles);
        /*
            $kim=\Auth::user()->role;
            if ($kim=='root')
            {
                return true;
            }

        return false;
        */
        //abort(401, 'This action is unauthorized. User.php');
    }
    public function findForPassport($identifier) {
        return User::orWhere(‘email’, $identifier)->where('deleted','no')->first();
    }

    public function Yetki()
    {
        return $this->hasMany('App\YetkilerModel','userId','id');
    }


    public function Talimat()
    {
        return $this->hasMany('App\TalimatModel','firmaId','id')->where("deleted",'=','no')->where("durum",'=','tamamlandi');
    }

}

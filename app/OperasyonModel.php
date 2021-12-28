<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperasyonModel extends Model
{
    protected $table = 'operasyon';
    protected $primaryKey='id';

    public function User()
    {
        return $this->hasOne('App\User', 'id','firmaId');
    }

    public function Gumruk()
    {
        return $this->hasMany('App\GumrukModel','talimatId','id');
    }

    public function Evrak()
    {
        return $this->hasMany('App\musteriOperasyonEvrak','operasyonId','id')->where("deleted",'=','no');
    }

}

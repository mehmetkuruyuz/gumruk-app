<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GumrukModel extends Model
{
    protected $table = 'gumrukBilgisi';
    protected $primaryKey='id';

    public function Talimat()
    {
        return $this->hasOne('App\Talimat', 'id','talimatId');
    }
    public function Yukleme()
    {
        return $this->hasMany('App\YuklemeModel','gumrukId','id');
    }
    public function Evrak()
    {
        return $this->hasMany('App\EvrakModel','gumrukId','id')->where('deleted','no');

    }


}

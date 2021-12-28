<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TalimatModel extends Model
{
    protected $table = 'talimat';
    protected $primaryKey='id';



    public function User()
    {
        return $this->hasOne('App\User', 'id','firmaId');
    }

    public function AltModel()
    {
        return $this->hasMany('App\TalimatAltModel','talimatId','id');
    }
    public function Ilgili()
    {
        return $this->hasOne('App\User', 'id','ilgilenenId');
    }
    public function Ilgilikayit()
    {
        return $this->hasOne('App\User', 'id','islemAtanan');
    }

    public function Bolge()
    {
        return $this->hasOne('App\BolgeModal', 'id','bolgeSecim');
    }
    public function Evrak()
    {
      return $this->hasMany('App\musteriEvrak','talimatId','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IhracatMuhasebeModel extends Model
{
    protected $table = 'ihracatmuhasebe';
    protected $primaryKey='id';

    public function User()
    {
        return $this->hasOne('App\User', 'id','firmaId');
    }

    public function Bolge()
    {
        return $this->hasOne('App\BolgeModal', 'id','bolgeId');
    }
    public function Yapan()
    {
        return $this->hasOne('App\User', 'id','yapanId');
    }
    public function Talimat()
    {
        return $this->belongsTo('App\IhracatModel', 'ihracatId','id');
    }
    public function Kapayan()
    {
          return $this->hasOne('App\User', 'id','kapayanId');
    }

    public function Odeme()
    {
          return $this->hasMany('App\IhracatNakitOdemeModel','faturaId','id');
    }
    public function AltModel()
    {
        return $this->hasMany('App\IhracatMuhasebeAltParam','muhasebeid','id');
    }
}

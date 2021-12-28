<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IhracatModel extends Model
{
    protected $table = 'ihracat';
    protected $primaryKey='id';



    public function User()
    {
        return $this->hasOne('App\User', 'id','firmaId');
    }

    public function AltModelJustName()
    {
        return $this->hasMany('App\IhracatAltModel','ihracatId','id')->select("ihracatId","talimatTipi","id");
    }
    public function AltModel()
    {
        return $this->hasMany('App\IhracatAltModel','ihracatId','id')->orderBy("gumrukno","ASC");
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
      return $this->hasMany('App\ihracatEvrak','ihracatId','id');
    }

}

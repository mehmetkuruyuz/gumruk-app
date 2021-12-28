<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MuhasebeModel extends Model
{
    protected $table = 'muhasebe';
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
        return $this->belongsTo('App\TalimatModel', 'talimatId','id');
    }
    public function Kapayan()
    {
          return $this->hasOne('App\User', 'id','kapayanId');
    }

    public function Odeme()
    {
          return $this->belongsTo('App\NakitOdemeModel','id','faturaId');
    }
}

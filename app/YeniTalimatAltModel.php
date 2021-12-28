<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YeniTalimatAltModel extends Model
{
  protected $table = 'yenitalimatalt';
  protected $primaryKey='id';


  public function param()
  {
      return $this->hasMany('App\YeniTalimatAltSubModel', 'talimatAltId','id');
  }

  public function upone()
  {
    return $this->belongsTo('App\NewTalimatModel','talimatId','id');
  }


}

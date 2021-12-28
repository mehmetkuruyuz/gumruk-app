<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewTalimatModel extends Model
{
  protected $table = 'yenitalimat';
  protected $primaryKey='id';

  public function User()
  {
      return $this->hasOne('App\User', 'id','firmaId');
  }

  public function Gumruk()
  {
      return $this->hasMany('App\GumrukModel','talimatId','id');
  }

          public function allparametres()
          {
            return $this->hasManyThrough(
              'App\YeniTalimatAltModel',
              'App\YeniTalimatAltSubModel',
              'talimatAltId',
              'id',
              'id',
              'id'



            );

          }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TalimatAltModel extends Model
{
  protected $table = 'talimatparametre';
  protected $primaryKey='id';

  public function upone()
  {
    return $this->belongsTo('App\TalimatModel','talimatId','id')->where("deleted",'=','no');
  }



}

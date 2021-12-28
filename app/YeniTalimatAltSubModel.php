<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YeniTalimatAltSubModel extends Model
{
  protected $table = 'yenitalimataltparametreleri';
  protected $primaryKey='id';

  public function upone()
  {
    return $this->belongsTo('App\YeniTalimatAltModel','talimatAltId','id')->where("deleted",'=','no');
  }


}

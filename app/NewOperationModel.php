<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewOperationModel extends Model
{
  protected $table = 'yenioperasyon';
  protected $primaryKey='id';

  public function User()
  {
      return $this->hasOne('App\User', 'id','firmaId');
  }

  public function params()
  {
      return $this->hasMany('App\NewOperationParam','operationId','id');
  }
}

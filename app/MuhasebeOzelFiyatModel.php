<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MuhasebeOzelFiyatModel extends Model
{
  protected $table = 'muhasebeozelfiyat';
  protected $primaryKey='id';
  protected $fillable=["firmaId","senaryo","talimattipi","faturatutari","parabirimi","topluuygula"];
  
  public function User()
  {
      return $this->hasOne('App\User', 'id','firmaId');
  }
}

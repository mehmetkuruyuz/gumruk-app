<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    protected $table = 'logfortalimat';
    protected $primaryKey='id';

    public function User()
    {
        return $this->hasOne('App\User', 'id','userid');
    }

    public function Ihracat()
    {
      return $this->hasOne('App\IhracatModel', 'id','talimatid');

    }

}

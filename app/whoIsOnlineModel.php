<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class whoIsOnlineModel extends Model
{
    
    protected $table = 'whoIsOnline';
    protected $primaryKey='id';
    protected $fillable = ['userId'];
    
    
    public function User()
    {
        return $this->hasOne('App\User', 'id','userId');
    }
}

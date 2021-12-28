<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MesajModel extends Model
{
    //
    protected $table = 'mesaj';
    protected $primaryKey='id';
    
    
    public function FromUser() 
    {
        
        $l=$this->hasOne('App\User', 'id','fromUser');
        return $l;
    }
    
    public function ToUser()
    {
       return $this->hasOne('App\User', 'id','toUser');
    }
}

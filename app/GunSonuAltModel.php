<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GunSonuAltModel extends Model
{
    protected $table = 'gunsonuraporalt';
    protected $primaryKey='id';

    public function Muhasebe()
    {
        return $this->belongsTo('App\MuhasebeModel', 'faturaId','id');
    }
    public function Gunsonu()
    {
        return $this->belongsTo('App\GunSonuModel', 'gunsonuId','id');
    }
}

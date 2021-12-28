<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NakitOdemeModel extends Model
{
    protected $table = 'nakitodemelistesi';
    protected $primaryKey='id';

    public function Muhasebe()
    {
        return $this->belongsTo('App\MuhasebeModel', 'faturaId','id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IhracatNakitOdemeModel extends Model
{
    protected $table = 'ihracatnakitodemelistesi';
    protected $primaryKey='id';
    protected $fillable=["faturaId","odemeFiyat","parabirimi","yapanId","durumu","odemealanname","created_at","updated_at"];

    public function Muhasebe()
    {
        return $this->belongsTo('App\IhracatMuhasebeModel', 'faturaId','id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IhracatAltModel extends Model
{
  protected $table = 'ihracataltparametre';
  protected $primaryKey='id';
  protected $fillable=["ihracatId",
"gumrukno",
"varisGumruk",
"baslangicGumruk",
"gumrukSira",
"yuklemeNoktasi",
"yuklemeNoktasiulkekodu",
"indirmeNoktasi",
"indirmeNoktasiulkekodu",
"talimatTipi",
"tekKap",
"tekKilo",
"yukcinsi",
"faturanumara",
"faturabedeli",
"mrnnumber",
"tirnumarasi",
"deleted",
"firmaId",
"islemdurumu"];

  public function upone()
  {
    return $this->belongsTo('App\IhracatModel','ihracatId','id')->where("deleted",'=','no');
  }



}

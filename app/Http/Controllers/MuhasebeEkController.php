<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Mail\InfoMailEvery;

class MuhasebeEkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function ozelfiyatolusturma()
     {
       \Helper::langSet();
       $userId=Auth::user()->id;
       $userRole=Auth::user()->role;
       $lang = Session::get ('locale');
       if ($lang == null)  { $lang='tr'; }


       $talimatList = DB::table('talimatTipi')->where("talimatType","=","ihracat")->where('dil','=',$lang)->get();
       $UserModel=new \App\User();
      // return $talimatList;
       $companylist=$UserModel->where("role","=","watcher")->get();

       return view("yeni_muhasebe.ozelfiyatlandirma",["talimatList"=>$talimatList,"companylist"=>$companylist]);
     }


     public function ozelfiyataltparametre($talimatid)
     {
       //return $talimatid;
       \Helper::langSet();
       $userId=Auth::user()->id;
       $userRole=Auth::user()->role;
       $lang = Session::get ('locale');
       if ($lang == null)  { $lang='tr'; }
       $talimat=DB::table('talimatTipi')->find($talimatid);

        return view("yeni_muhasebe.altaction",["talimat"=>$talimat]);
     }


     public function ozelfiyatsave(Request $req)
     {

       $talimatid=$req->input("talimatid");
       $arrayoftalimatalt=array();

      $price=$req->input("price");
      $moneytype=$req->input("moneytype");
      $toplu=$req->input("toplu");

       foreach ($talimatid as $key => $value)
       {
          $arrayoftalimatalt[$key]["firmaId"]=$req->input("firmaId");
          $arrayoftalimatalt[$key]["senaryo"]=""; // maybe future

          $arrayoftalimatalt[$key]["talimattipi"]=$talimatid[$key];
          if (!empty($price[$key])) {$fiyat=$price[$key];} else {$fiyat=0;}
          $arrayoftalimatalt[$key]["faturatutari"]=$fiyat;

          if (!empty($moneytype[$key])) {$fiyatbirim=$moneytype[$key];} else {$fiyatbirim="TL";}
          $arrayoftalimatalt[$key]["parabirimi"]=$fiyatbirim;

          if (!empty($toplu[$key])) {$tuygu="yes";} else {$tuygu="no";}

          $arrayoftalimatalt[$key]["topluuygula"]=$tuygu;
       }

       $MuhasebeOzelFiyatModel=new \App\MuhasebeOzelFiyatModel();




     $MuhasebeOzelFiyatModel->insert($arrayoftalimatalt);

     $mesaj=trans("messages.ozelfiyatlamatitle")." ".trans("messages.tamamlandi");

     return view("layouts.success",['islemAciklama'=>$mesaj]);
   }

}

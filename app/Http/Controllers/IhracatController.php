<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Mail\InfoMailEvery;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class IhracatController extends Controller
{
    //

    public function __construct()
    {

    }

    public function index(Request $request)
    {


    }


    public function new()
    {

      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');



      $barcode=intval(substr(md5(rand(1264,987654321).microtime().rand(1264,987654321)), 0, 8), 16);

      if ($lang == null)
      {
          $lang='tr';
      }
      $talimatList = DB::table('talimatTipi')->where("talimatType","=","ihracat")->where('dil','=',$lang)->get();

      $bolgeList = DB::table('bolge')->get();
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
      $allUser=new \App\User();
      switch ($userRole)
      {
        case 'admin':
            $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','=','watcher')->get();
        break;
        default:
        case 'bolgeadmin':
            $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('bolgeId',"=",Auth::user()->bolgeId)->where('role','=','watcher')->get();
        break;

      }
      $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','=','watcher')->get(); // İlerde kalkacak.
      $listUser=json_decode($listUser,true);


      $yetkiler=array();
      if ($userRole!='admin')
      {
          $yetkilerc=DB::table("yetkiler")->select("talimatType")->where("userId","=",$userId)->get();
          foreach ($yetkilerc as $key => $value)
          {
              $yetkiler[]=$value->talimatType;
          }
      }


      return view('ihracat.talimat_new',['userlist'=>$listUser,'talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList,"bolge"=>$bolgeList,'yetkiler'=>$yetkiler]);
    }



    public function gumrukdatagetir($say)
    {

      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');
      if ($lang == null)   {$lang='tr';}

      $talimatList = DB::table('talimatTipi')->where("talimatType","=","ihracat")->where('dil','=',$lang)->orderBy("id","DESC")->get();

      for($t=1;$t<=$say;$t++)
      {
          $view="";
          $view=\View::make("ihracat.gumruk",['say'=>($t-1),"talimatList"=>$talimatList]);
          $array[$t]= $view->render();
      }
      return $array;
    }

    public function talimattipigetir($tip,$say,Request $request)
    {
      $which=0;
      $cekici="";
      $dorse="";
      if (!empty($request->input("whichplace"))) {$which=$request->input("whichplace");}
        if (!empty($request->input("cekici"))) {$cekici=$request->input("cekici");}
          if (!empty($request->input("dorse"))) {$dorse=$request->input("dorse");}
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
      switch ($tip) {
        case 'ex1':
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ext1",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case 't2':
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_t2",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case 't1':
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_t2",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ata":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ata",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "tir":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_tirkarnesi",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "t1kapama":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_t1kapama",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "listex":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_listex",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "passage":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_tirpassage",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ext1t2":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ext1-t2",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE1":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE1",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE2":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE2",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE3":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE3",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE4":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE4",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE5":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE5",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE6":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE6",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE7":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE7",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE8":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE8",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE9":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE9",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE10":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE10",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which]);
            $data=$view->render();;
        break;
        case "ihracatE11":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE11",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which,"cekici"=>$cekici,"dorse"=>$dorse]);
            $data=$view->render();;
        break;
        case "ihracatE12":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE12",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which,"cekici"=>$cekici,"dorse"=>$dorse]);
            $data=$view->render();;
        break;
        case "ihracatE13":
            $view="";
            $view=\View::make("ihracat.talimattipleri.talimat_ihracatE13",['say'=>($say),"ulkeList"=>$ulkeList,"talimattipi"=>$tip,"which"=>$which,"cekici"=>$cekici,"dorse"=>$dorse]);
            $data=$view->render();;
        break;
      }
      return $data;

    }

    public function ihracatsave(Request $request)
    {

      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');
      \Helper::langSet();

      if ($request->input("firmaId")==58)
      {
          //return $request;
      }

      if (empty($request->input("gumrukAdedi")))    {  $gumrukAdedi=1;} else { $gumrukAdedi=$request->input("gumrukAdedi"); }
      if (empty($request->input("firmaId")))   { $firmaId=$request->input("externalFirma"); /* Firma Bilgisi eklenecek. Hızlı Ekleme vs.*/   }else { $firmaId=$request->input("firmaId"); }

      $IhracatModel=new \App\IhracatModel();

      $IhracatModel->autoBarcode=$request->input("autoBarcode");
      $IhracatModel->bolgeSecim=$request->input("bolgeSecim");

      $IhracatModel->gumrukAdedi=$gumrukAdedi;
      $IhracatModel->cekiciPlaka=$request->input("cekiciPlaka");
      $IhracatModel->dorsePlaka=$request->input("dorsePlaka");

      $IhracatModel->yeniTalimatMi="yes";
      $IhracatModel->firmaId=$firmaId;
      $IhracatModel->ilgilenenId=$userId;
      $IhracatModel->pozisyonNo=$request->input("pozisyonNo");
      $IhracatModel->note=$request->input("aciklama");

      $IhracatModel->deleted="no";
      $IhracatModel->durum ="bekleme";
      $IhracatModel->islemdurum ="bosta";
      $IhracatModel->teminatTipi=$request->input("teminatTipi");
      $IhracatModel->tasimaTipi=$request->input("tasimaTipi");

      $IhracatModel->sertifikano=$request->input("sertifikano");
      $IhracatModel->plaka=$request->input("ozelplaka");


      $IhracatModel->save();

      $ihracatId=$IhracatModel->id;

      $yuklemeNoktasiAdet=$request->input("yuklemeNoktasiAdet");

      $varisGumrugu=$request->input("varisGumrugu");
      $yuklemeNoktasi=$request->input("yuklemeNoktasi");
      $yuklemeNoktasiulkekodu=$request->input("yuklemeNoktasiulkekodu");
      $indirmeNoktasi=$request->input("indirmeNoktasi");
      $indirmeNoktasiulkekodu=$request->input("indirmeNoktasiulkekodu");
      $tekKap=$request->input("tekKap");
      $tekKilo=$request->input("tekKilo");
      $yukcinsi=$request->input("yukcinsi");
      $faturacinsi=$request->input("faturacinsi");
      $faturanumara=$request->input("faturanumara");
      $faturabedeli=$request->input("faturabedeli");
      $mrnnumber=$request->input("mrnnumber");
      $tirnumarasi=$request->input("tirnumarasi");
      $talimattipi=$request->input("talimattipi");
      $atanumarasi=$request->input("atanumarasi");
      $cekici=$request->input("cekici");
      $dorse=$request->input("dorse");
      $gelendosyalar=$request->file("spuserfile");

      $array=array();

      $kontrolVaris=0;
      $now = \Carbon\Carbon::now('utc')->toDateTimeString();

      foreach ($talimattipi as $key => $value)
      {
        foreach($value as $x=>$y)
        {
          /* Mecburi sıfırlama */

          $array[$key][$x]["ihracatId"]=$ihracatId;
          $array[$key][$x]["gumrukno"]=$key;
          $array[$key][$x]["gumrukSira"]=($x+1);
          $array[$key][$x]["islemdurumu"]="bekliyor";
          $array[$key][$x]["firmaId"]=$firmaId;
          $array[$key][$x]["deleted"]="no";



          if (!empty($faturanumara[$key][$x]))
          {
            $array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
          }else {
            $array[$key][$x]["faturanumara"]=$request->input("autoBarcode");
          }


          if (!empty($varisGumrugu[$key][$x]))            {$array[$key][$x]["varisGumruk"]=$varisGumrugu[$key][$x];}                        else {$array[$key][$x]["varisGumruk"]=""; $kontrolVaris++;}
          if (!empty($yuklemeNoktasi[$key][$x]))          {$array[$key][$x]["yuklemeNoktasi"]=$yuklemeNoktasi[$key][$x];}                   else {$array[$key][$x]["yuklemeNoktasi"]="";}
          if (!empty($yuklemeNoktasiulkekodu[$key][$x]))  {$array[$key][$x]["yuklemeNoktasiulkekodu"]=$yuklemeNoktasiulkekodu[$key][$x];}   else {$array[$key][$x]["yuklemeNoktasiulkekodu"]=0;}
          if (!empty($indirmeNoktasi[$key][$x]))          {$array[$key][$x]["indirmeNoktasi"]=$indirmeNoktasi[$key][$x];}                   else {$array[$key][$x]["indirmeNoktasi"]="";}
          if (!empty($indirmeNoktasiulkekodu[$key][$x]))  {$array[$key][$x]["indirmeNoktasiulkekodu"]=$indirmeNoktasiulkekodu[$key][$x];}   else {$array[$key][$x]["indirmeNoktasiulkekodu"]=0;}
          if (!empty($tekKap[$key][$x]))                  {$array[$key][$x]["tekKap"]=$tekKap[$key][$x];}                                   else {$array[$key][$x]["tekKap"]="";}
          if (!empty($tekKilo[$key][$x]))                 {$array[$key][$x]["tekKilo"]=$tekKilo[$key][$x];}                                 else {$array[$key][$x]["tekKilo"]="";}
          if (!empty($yukcinsi[$key][$x]))                {$array[$key][$x]["yukcinsi"]=$yukcinsi[$key][$x];}                               else {$array[$key][$x]["yukcinsi"]="";}
          if (!empty($tirnumarasi[$key][$x]))             {$array[$key][$x]["tirnumarasi"]=$tirnumarasi[$key][$x];}                         else {$array[$key][$x]["tirnumarasi"]="";}
          if (!empty($talimattipi[$key][$x]))             {$array[$key][$x]["talimatTipi"]=$talimattipi[$key][$x];}                         else {$array[$key][$x]["talimatTipi"]="";}
          if (!empty($faturabedeli[$key][$x]))            {$array[$key][$x]["faturabedeli"]=$faturabedeli[$key][$x];}                       else {$array[$key][$x]["faturabedeli"]="";}
          if (!empty($mrnnumber[$key][$x]))               {$array[$key][$x]["mrnnumber"]=$mrnnumber[$key][$x];}                             else {$array[$key][$x]["mrnnumber"]="";}
          if (!empty($atanumarasi[$key][$x]))             {$array[$key][$x]["atanumarasi"]=$atanumarasi[$key][$x];}                         else {$array[$key][$x]["atanumarasi"]="";}


          if (!empty($cekici[$key][$x]))             {$array[$key][$x]["cekici"]=$cekici[$key][$x];}                         else {$array[$key][$x]["cekici"]="";}
          if (!empty($dorse[$key][$x]))             {$array[$key][$x]["dorse"]=$dorse[$key][$x];}                         else {$array[$key][$x]["dorse"]="";}

          if (!empty($gelendosyalar[$key][$x]))           {$digerarray[$key][$x]["files"]=$gelendosyalar[$key][$x];}

        }

      }

   $_arrayasil=array();
   $z=0;
   $_arraydosya=array();
   foreach ($array as $arraykey => $arrayvalue)
   {
     foreach ($arrayvalue as $xkey => $yalue)
     {
       $_arrayasil[$z]=$yalue;
       if (!empty($gelendosyalar[$arraykey][$xkey]))
       {
         $_arraydosya[$z]=$gelendosyalar[$arraykey][$xkey];
       }
       $z++;
     }
   }

  $IhracatAltModel=new \App\IhracatAltModel();
  $counter=0;
  $fileforEvrakModel=new \App\ihracatEvrak();
  $fileForEvr=array();
  foreach ($_arrayasil as $key => $value)
  {
    $return=$IhracatAltModel->firstOrCreate(["id"=>-1],$value);
    $_arrayasil[$key]['id']=$return->id;
    if (!empty($_arraydosya[$key]))
    {
          foreach ($_arraydosya[$key] as $dosyakey => $dosyavalue)
          {
            $fileForEvr[$counter]=array(
            "ihracatId"=>$ihracatId,
            "kacinci"=>($_arrayasil[$key]["gumrukno"]+1),
            "yukId"=>$_arrayasil[$key]['id'],
            "siraId"=>$dosyakey,
            "fileName"=>Storage::disk('public')->put('ihracatevrak', $dosyavalue),
            "filetype"=>$dosyavalue->getClientOriginalExtension(),
            "filerealname"=>$dosyavalue->getClientOriginalName(),
            "belgetipi"=>$_arrayasil[$key]['talimatTipi'],
            "deleted"=>"no",
            'created_at'=> $now,
            'updated_at'=> $now
          );
            $counter++;
          }
      }

  }
  if (count($fileForEvr)>0)
  {
    $fileforEvrakModel->insert($fileForEvr);
  }
  $talimatMesaj="";
  $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
  $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");

  $ihracatmuhasebeModel=new \App\IhracatMuhasebeModel();
  $ihracatmuhasebeModel->firmaId=$request->input("firmaId");
  $ihracatmuhasebeModel->faturaTarihi=\Carbon\Carbon::parse("now")->format("Y-m-d h:i:s");
  $ihracatmuhasebeModel->senaryo=" ";
  $ihracatmuhasebeModel->faturaReferans=trans("messages.ihracattangelenfatura");
  $ihracatmuhasebeModel->talimatId=$ihracatId;
  $ihracatmuhasebeModel->yapanId=$userId;
  if ($request->input("odemecinsi")=="nakit")
  {
    $ihracatmuhasebeModel->faturadurumu="kapali";

  }else {
    $ihracatmuhasebeModel->faturadurumu="acik";

  }
  $ihracatmuhasebeModel->odemecinsi=$request->input("odemecinsi");
  $ihracatmuhasebeModel->faturaNo=$request->input("autoBarcode");
  $ihracatmuhasebeModel->autoBarcode=$request->input("autoBarcode");
  $ihracatmuhasebeModel->bolgeId=$request->input("bolgeSecim");
  $ihracatmuhasebeModel->deleted='no';
  $ihracatmuhasebeModel->save();

  $muhasebeid=$ihracatmuhasebeModel->id;
  $arrayaltparameter=array();

  $moneytype=$request->input("moneytype");
  $xtyperx=$request->input("xtyperx");
  $xmoney=$request->input("xmoney");


  $moneyandtyper=array();

  foreach ($xtyperx as $key => $value)
  {
      $arrayaltparameter[$key]=array(
        "muhasebeid"=>$muhasebeid,
        "ihracatid"=>$ihracatId,
        "firmaid"=>$request->input("firmaId"),
        "tipi"=>$xtyperx[$key],
        "price"=>$xmoney[$key],
        "moneytype"=>$moneytype[$key]
      );

      if (empty($moneyandtyper[$moneytype[$key]]))
      {
        $moneyandtyper[$moneytype[$key]]=0;
      }

      $moneyandtyper[$moneytype[$key]]=$moneyandtyper[$moneytype[$key]]+$xmoney[$key];
  }

  $IhracatMuhasebeAltParam=new \App\IhracatMuhasebeAltParam();
  $IhracatMuhasebeAltParam->insert($arrayaltparameter);
  $txfxa=0;
  if ($request->input("odemecinsi")=="nakit")
  {
    $nakitOdemeModel=new \App\IhracatNakitOdemeModel();

    foreach ($moneyandtyper as $key => $value)
    {

      $insertermoney[$txfxa]=array(
        "faturaId"=>$muhasebeid,
        "odemeFiyat"=>$value,
        "parabirimi"=>$key,
        "yapanId"=>\Auth::user()->id,
        'created_at'=> $now,
        'updated_at'=> $now
      );
      $txfxa++;
    }
    $nakitOdemeModel->insert($insertermoney);
  }

        $log=new \App\LogModel();
        $log->talimatid=$ihracatId;
        $log->userid=\Auth::user()->id;
        $log->what=trans("messages.ihracat")." ".trans("messages.operasyontamam");
        $log->save();

        $userLK=new \App\User();
        $userkim=$userLK->find($firmaId);
        $userFirmName=$userkim->name;
        $userEmail=$userkim->email;

  /* Mail işlemleri eklenecek */
  return view("layouts.success",['islemAciklama'=>$talimatMesaj]);
  //    return $request;
    }


    public function ihracatlist(Request $request)
    {
              \Helper::langSet();
              $userId=Auth::user()->id;
              $userRole=Auth::user()->role;
              $userBolge=Auth::user()->bolgeId;
            //  return $userBolge;
              $IhracatModel=new \App\IhracatModel();
              $arrayappends=array();
              if(!empty($request->input('inhear')))
              {
                if (!empty($request->input("companyname")))
                {
                    $userBilgi=new \App\User();
                    $udata=$userBilgi->select("id")->where("name","like","%".$request->input("companyname")."%")->get();
                    $arraylist=array();
                    foreach ($udata as $key => $value)
                    {
                      $arraylist[]=$value->id;
                      // code...
                    }
                    $IhracatModel=$IhracatModel->whereIn("firmaId",$arraylist);
                    $arrayappends["companyname"]=$request->input("companyname");
                    //return $arraylist;
                }

                if (!empty($request->input("kayitilgilenen")))
                {
                    $userBilgi=new \App\User();
                    $udata=$userBilgi->select("id")->where("name","like","%".$request->input("kayitilgilenen")."%")->get();
                    $arraylist=array();
                    foreach ($udata as $key => $value)
                    {
                      $arraylist[]=$value->id;
                    }
                    $IhracatModel=$IhracatModel->whereIn("ilgilenenId",$arraylist);
                              $arrayappends["kayitilgilenen"]=$request->input("kayitilgilenen");
                }
                if (!empty($request->input("islemilgilenen")))
                {
                    $userBilgi=new \App\User();
                    $udata=$userBilgi->select("id")->where("name","like","%".$request->input("islemilgilenen")."%")->get();
                    $arraylist=array();
                    foreach ($udata as $key => $value)
                    {
                      $arraylist[]=$value->id;
                    }
                    $IhracatModel=$IhracatModel->whereIn("islemAtanan",$arraylist);
                              $arrayappends["islemilgilenen"]=$request->input("islemilgilenen");
                    //return $arraylist;
                }

                if (!empty($request->input("createddate")))
                {
                  $tarih=explode("/",$request->input("createddate"));
                  $IhracatModel=$IhracatModel->where("created_at",">",trim($tarih[0])." 00:00:00");
                  $IhracatModel=$IhracatModel->where("created_at","<",trim($tarih[1])." 23:59:59");
                            $arrayappends["createddate"]=$request->input("createddate");
                }

                if (!empty($request->input("bolgehangisi")))
                {
                  $IhracatModel=$IhracatModel->where("bolgeSecim","=",$request->input("bolgehangisi"));

                            $arrayappends["bolgehangisi"]=$request->input("bolgehangisi");
                }

                if (!empty($request->input("cekiciplaka")))
                {
                  $IhracatModel=$IhracatModel->where("cekiciplaka","like","%".$request->input("cekiciplaka")."%");
                            $arrayappends["cekiciplaka"]=$request->input("cekiciplaka");
                }
                    if (!empty($request->input("dorseplaka")))
                {
                  $IhracatModel=$IhracatModel->where("dorsePlaka","like","%".$request->input("dorseplaka")."%");
                            $arrayappends["dorseplaka"]=$request->input("dorseplaka");
                }

                if (!empty($request->input("autoBarcode")))
                {
                  $IhracatModel=$IhracatModel->where("autoBarcode","like","%".$request->input("autoBarcode")."%");
                            $arrayappends["autoBarcode"]=$request->input("autoBarcode");
                }

              }

              if ($userRole=="watcher") {$IhracatModel=$IhracatModel->where("firmaId","=",$userId);}

              $allList= $IhracatModel->with(['User','Ilgili','Bolge',"AltModelJustName"])->where("durum","!=","tamamlandi")->orderBy("id","DESC")->paginate(40);
              $allList->appends($arrayappends);

              $justname=array();
              foreach ($allList as $key => $value)
              {
                foreach($value->altmodeljustname as $mkl=>$vlue)
                {
                  if (empty($justname[$value->id][$vlue->talimatTipi])) {$justname[$value->id][$vlue->talimatTipi]=0;}
                  $justname[$value->id][$vlue->talimatTipi]+=1;
                }
                // code...
              }


              $bolgeList = DB::table('bolge')->get();
              return view('ihracat.operasyon_index',['operasyonList'=>$allList,"justname"=>$justname,"bolgeList"=>$bolgeList]);


    }

    public function doneihracatlist(Request $request)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $userBolge=Auth::user()->bolgeId;
    //  return $userBolge;
      $IhracatModel=new \App\IhracatModel();
      $arrayappends=array();
      if(!empty($request->input('inhear')))
      {
        /*
        talimattipi

        bolgehangisi
        */
        if (!empty($request->input("companyname")))
        {
            $userBilgi=new \App\User();
            $udata=$userBilgi->select("id")->where("name","like","%".$request->input("companyname")."%")->get();
            $arraylist=array();
            foreach ($udata as $key => $value)
            {
              $arraylist[]=$value->id;
            }
            $IhracatModel=$IhracatModel->whereIn("firmaId",$arraylist);
            $arrayappends["companyname"]=$request->input("companyname");
          }

        if (!empty($request->input("kayitilgilenen")))
        {
            $userBilgi=new \App\User();
            $udata=$userBilgi->select("id")->where("name","like","%".$request->input("kayitilgilenen")."%")->get();
            $arraylist=array();
            foreach ($udata as $key => $value)
            {
              $arraylist[]=$value->id;
            }
            $IhracatModel=$IhracatModel->whereIn("ilgilenenId",$arraylist);
            $arrayappends["kayitilgilenen"]=$request->input("kayitilgilenen");
        }
        if (!empty($request->input("islemilgilenen")))
        {
            $userBilgi=new \App\User();
            $udata=$userBilgi->select("id")->where("name","like","%".$request->input("islemilgilenen")."%")->get();
            $arraylist=array();
            foreach ($udata as $key => $value)
            {
              $arraylist[]=$value->id;
            }
            $IhracatModel=$IhracatModel->whereIn("islemAtanan",$arraylist);
            $arrayappends["islemilgilenen"]=$request->input("islemilgilenen");
            //return $arraylist;
        }

        if (!empty($request->input("createddate")))
        {
          $tarih=explode("/",$request->input("createddate"));
          $IhracatModel=$IhracatModel->where("created_at",">",trim($tarih[0])." 00:00:00");
          $IhracatModel=$IhracatModel->where("created_at","<",trim($tarih[1])." 23:59:59");
          $arrayappends["createddate"]=$request->input("createddate");
        }

        if (!empty($request->input("bolgehangisi")))
        {
          $IhracatModel=$IhracatModel->where("bolgeSecim","=",$request->input("bolgehangisi"));
          $arrayappends["bolgehangisi"]=$request->input("bolgehangisi");
        }

        if (!empty($request->input("cekiciplaka")))
        {
          $IhracatModel=$IhracatModel->where("cekiciplaka","like","%".$request->input("cekiciplaka")."%");
          $arrayappends["cekiciplaka"]=$request->input("cekiciplaka");
        }
            if (!empty($request->input("dorseplaka")))
        {
          $IhracatModel=$IhracatModel->where("dorsePlaka","like","%".$request->input("dorseplaka")."%");
          $arrayappends["dorseplaka"]=$request->input("dorseplaka");
        }

        if (!empty($request->input("autoBarcode")))
        {
          $IhracatModel=$IhracatModel->where("autoBarcode","like","%".$request->input("autoBarcode")."%");
          $arrayappends["autoBarcode"]=$request->input("autoBarcode");
        }

      }
      if ($userRole=="watcher") {$IhracatModel=$IhracatModel->where("firmaId","=",$userId);}

      $allList= $IhracatModel->with(['User','Ilgili','Bolge',"AltModelJustName"])->where("durum","=","tamamlandi")->orderBy("id","DESC")->paginate(30);

      $allList->appends($arrayappends);

      $justname=array();
      foreach ($allList as $key => $value)
      {
        foreach($value->altmodeljustname as $mkl=>$vlue)
        {
          if (empty($justname[$value->id][$vlue->talimatTipi])) {$justname[$value->id][$vlue->talimatTipi]=0;}
          $justname[$value->id][$vlue->talimatTipi]+=1;
        }
      }
      $bolgeList = DB::table('bolge')->get();
  //    return $bolgeList;
      return view('ihracat.operasyon_index',['operasyonList'=>$allList,"justname"=>$justname,"bolgeList"=>$bolgeList]);

    }


    public function ihracatedit($_id)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');

      $newOperasyon=new \App\IhracatModel();
      $kontrol=$newOperasyon->where('id','=',$_id)->first();

      $bolgeList = DB::table('bolge')->get();
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
      $allUser=new \App\User();
      switch ($userRole) {
        case 'admin':
            $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','=','watcher')->get();
        break;
        default:
        case 'bolgeadmin':
            $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('bolgeId',"=",Auth::user()->bolgeId)->where('role','=','watcher')->get();
        break;

      }

      if ($lang == null)
      {
          $lang='tr';
      }

      $ulkeList = DB::table('ulkeKod')->get();
      $ulke=array();
      foreach ($ulkeList as $key => $value)
      {
        $ulke[$value->id]=$value->global_name;
      }

      $operasyon=$newOperasyon->with(['User','Bolge','Ilgili','AltModel','Ilgilikayit','Evrak'])->where('deleted','=','no')->where('id','=',$_id);

      $data=$operasyon->first();

      //return $data;

      $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
      $autoBarcode="";
      if (!empty($data->autoBarcode))
      {
        $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->autoBarcode, $generator::TYPE_CODE_128)) . '">';
      }
      //
      $muhasebeModel=new \App\MuhasebeModel();
      $md=$muhasebeModel->where("talimatId","=",$_id)->select("faturadurumu")->first();


$talimatList = DB::table('talimatTipi')->where("talimatType","=","ihracat")->where('dil','=',$lang)->get();
      return view("ihracat.operasyon_edit",['talimat'=>$data,"barcode"=>$autoBarcode,'ulke'=>$ulke,'fatura'=>$md,'userlist'=>$listUser,"bolgeList"=>$bolgeList,"talimatList"=>$talimatList]);
    }


    public function ihracatgoster($_id)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');

      $newOperasyon=new \App\IhracatModel();
      $kontrol=$newOperasyon->where('id','=',$_id)->first();


      if ($userRole=='admin' || $userRole=='bolgeadmin')
      {
          if (empty($kontrol->islemAtanan))
          {

            $newOperasyon->where('id','=',$_id)->update(['islemAtanan'=>$userId,'yeniTalimatMi'=>'no',"islemdurum"=>"islemde"]);
            $log=new \App\LogModel();
            $log->talimatid=$_id;
            $log->userid=\Auth::user()->id;
            $log->what=trans("messages.ihracat")." ".trans("messages.islemilgilenen");
            $log->save();
          }
          else
          {
            if($kontrol->yeniTalimatMi=="yes")
            {
              $newOperasyon->where('id','=',$_id)->update(['yeniTalimatMi'=>'no']);
            }
          }
      }

            $log=new \App\LogModel();
            $log->talimatid=$_id;
            $log->userid=\Auth::user()->id;
            $log->what=trans("messages.ihracat")." ".trans("messages.show");
            $log->save();

      if ($lang == null)
      {
          $lang='tr';
      }

      $ulkeList = DB::table('ulkeKod')->get();
      $ulke=array();
      foreach ($ulkeList as $key => $value)
      {
        $ulke[$value->id]=$value->global_name;
      }

      $operasyon=$newOperasyon->with(['User','Bolge','Ilgili','AltModel','Ilgilikayit','Evrak'])->where('deleted','=','no')->where('id','=',$_id);

      $data=$operasyon->first();

      //return $data;

      $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
      $autoBarcode="";
      if (!empty($data->autoBarcode))
      {
        $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->autoBarcode, $generator::TYPE_CODE_128)) . '">';
      }
      //
      $muhasebeModel=new \App\MuhasebeModel();
      $md=$muhasebeModel->where("talimatId","=",$_id)->select("faturadurumu")->first();

      $logfile=$log->with(["User"])->where("talimatid","=",$_id)->orderBy("id","DESC")->get();
  //    return $logfile;

      return view("ihracat.operasyon_view",['talimat'=>$data,"barcode"=>$autoBarcode,'ulke'=>$ulke,'fatura'=>$md,"logfile"=>$logfile]);
    }

    public function yazdir($_id)
    {

      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');

      $newOperasyon=new \App\IhracatModel();
      $kontrol=$newOperasyon->where('id','=',$_id)->first();

      if ($userRole=='admin' || $userRole=='bolgeadmin')
      {
          if (empty($kontrol->islemAtanan))
          {

            $newOperasyon->where('id','=',$_id)->update(['islemAtanan'=>$userId,'yeniTalimatMi'=>'no',"islemdurum"=>"islemde"]);
          }
          else
          {
            if($kontrol->yeniTalimatMi=="yes")
            {
              $newOperasyon->where('id','=',$_id)->update(['yeniTalimatMi'=>'no']);
            }
          }
      }

      if ($lang == null)
      {
          $lang='tr';
      }

      $ulkeList = DB::table('ulkeKod')->get();
      $ulke=array();
      foreach ($ulkeList as $key => $value)
      {
        $ulke[$value->id]=$value->global_name;
      }

      $operasyon=$newOperasyon->with(['User','Bolge','Ilgili','AltModel','Ilgilikayit','Evrak'])->where('deleted','=','no')->where('id','=',$_id);

      $data=$operasyon->first();

      //return $data;

      $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
      $autoBarcode="";
      if (!empty($data->autoBarcode))
      {
        $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->autoBarcode, $generator::TYPE_CODE_128)) . '">';
      }
      //return $data;
      $muhasebeModel=new \App\MuhasebeModel();
      $md=$muhasebeModel->where("talimatId","=",$_id)->select("faturadurumu")->first();


            $log=new \App\LogModel();
            $log->talimatid=$_id;
            $log->userid=\Auth::user()->id;
            $log->what=trans("messages.talimat")." ".trans("messages.yazdir");
            $log->save();

      return view("ihracat.operasyon_print",['talimat'=>$data,"barcode"=>$autoBarcode,'ulke'=>$ulke,'fatura'=>$md]);
    }

    public function ihracatpartdownload()
    {


      $data=new \App\ihracatEvrak();

      $allList= $data->whereIn("id",\Request::input("item"))->get();
       //return $allList;
      $archiveFile = storage_path(str_slug("file".\Carbon\Carbon::parse("now")).".zip");
      $archive = new \ZipArchive();
$eklenendosyalar="";
      if ($archive->open($archiveFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
          // loop through all the files and add them to the archive.
          foreach ($allList as $file) {
            $ihracatId=$file->ihracatId;
            $eklenendosyalar.=$file->talimatId."-".(($file->kacinci)+1)."-".($file->siraId+1)."-".$file->belgetipi."-".$file->filerealname." ";
              if ($archive->addFile("../public/uploads/".$file->fileName, $file->talimatId."-".(($file->kacinci)+1)."-".($file->siraId+1)."-".$file->belgetipi."-".$file->filerealname)) {
                  // do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                  continue;
              } else {
                  throw new Exception("file `{$file}` could not be added to the zip file: " . $archive->getStatusString());
              }
          }
          $log=new \App\LogModel();
          $log->talimatid=$ihracatId;
          $log->userid=\Auth::user()->id;
          $log->what=trans("messages.talimat")." ".trans("messages.dosyaindir")." ".trans("messages.seciliindir")." (".$eklenendosyalar.")";
          $log->save();
          // close the archive.
          if ($archive->close()) {
              // archive is now downloadable ...
              return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);
          } else {
              throw new Exception("could not close zip file: " . $archive->getStatusString());
          }

      } else {
        throw new Exception("zip file could not be created: " . $archive->getStatusString());
      }



    }

    public function ihracatfiledownload($id) {

      $log=new \App\LogModel();
      $log->talimatid=$id;
      $log->userid=\Auth::user()->id;
      $log->what=trans("messages.ihracat")." ".trans("messages.dosyaindir")." ".trans("messages.tumunuindir");
      $log->save();
      $operasyonModel=new \App\IhracatModel();
    $allList=$operasyonModel->with(['User','Evrak'])->where('deleted','=','no')->where('id','=',$id)->first();
    $archiveFile = storage_path($allList->autoBarcode."-".str_slug($allList->user->name).".zip");
    $archive = new \ZipArchive();


    if ($archive->open($archiveFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
        // loop through all the files and add them to the archive.
        foreach ($allList->evrak as $file) {
            if ($archive->addFile("../public/uploads/".$file->fileName, $file->talimatId."-".(($file->kacinci)+1)."-".($file->siraId+1)."-".$file->belgetipi."-".$file->filerealname)) {
                // do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                continue;
            } else {
                throw new Exception("file `{$file}` could not be added to the zip file: " . $archive->getStatusString());
            }
        }

        // close the archive.
        if ($archive->close()) {
            // archive is now downloadable ...
            return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);
        } else {
            throw new Exception("could not close zip file: " . $archive->getStatusString());
        }
    } else {
      throw new Exception("zip file could not be created: " . $archive->getStatusString());
    }
    }

    public function evrakscreen($id)
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

      $newOperasyon=new \App\IhracatModel();

      if ($userRole!='admin' && $userRole!='bolgeadmin' && $userRole!='watcher' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }
      return view("ihracat.ihracat_uploads",["id"=>$id]);
    }

    public function evrakscreensub(Request $req)
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

      $newOperasyon=new \App\IhracatModel();

        if ($userRole!='admin' && $userRole!='bolgeadmin' && $userRole!='watcher' )
        {
          return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
        }
      $id=$req->input("talimatid");
      $gumrukno=$req->input("gumrukno");
      $gumruksira=$req->input("gumruksira");
      return view("ihracat.ihracat_uploads_sub",["id"=>$id,"gumrukno"=>$gumrukno,"gumruksira"=>$gumruksira]);
    }
    public function evrakuploadsub(Request $request)
    {
  //    return $request;
  $talimatMesaj="";
      $kl=new \App\ihracatEvrak();

      $id=$request->input("talimatId");
      $gumrukno=$request->input("gumrukno");
      $gumruksira=$request->input("gumruksira");
      $kl=new \App\ihracatEvrak();
      $gelen=$kl->where("ihracatId","=",$id)->where("kacinci","=",$gumrukno)->where("yukId","=",$gumruksira)->orderBy("siraId","DESC")->first();
      if (!empty($gelen))
      {
              $ekcount=1+$gelen->siraId;
      }else {
          $ekcount=0;
      }




              if(!empty($request->file('files')))
              {
                  $fileforEvrakModel=new \App\ihracatEvrak();
                  $files= $request->file('files');
                  $now = \Carbon\Carbon::now('utc')->toDateTimeString();


                  foreach ($files as $key=>$value)
                  {
                      $counter=0;
                      $fileForEvr[$counter]=array(
                          'ihracatId'=>$id,
                          "fileName"=>Storage::disk('public')->put('ihracatevrak', $files[$key]),
                          "filetype"=>$files[$key]->getClientOriginalExtension(),
                          "kacinci"=>$gumrukno,
                          "yukId"=>$gumruksira,
                          "siraId"=>intval($key+$ekcount),
                          "filerealname"=>$files[$key]->getClientOriginalName(),
                          "belgetipi"=>trans("messages.gumrukdosyalari"),
                          "deleted"=>'no',
                          'created_at'=> $now,
                          'updated_at'=> $now
                      );

                      $counter++;

                  }

                  $fileforEvrakModel->insert($fileForEvr);
                  $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
              }
              $log=new \App\LogModel();
              $log->talimatid=$id;
              $log->userid=\Auth::user()->id;
              $log->what=trans("messages.ihracat")." ".trans("messages.evrakyukle");
              $log->save();
                $mesaj=$talimatMesaj." ".trans("messages.evraksuccess");
                return view("layouts.success",['islemAciklama'=>$mesaj]);
    }
      public function evrakupload(Request $request)
      {


        $id=$request->input("talimatId");

        $talimatMesaj="";


        if(!empty($request->file('files')))
        {
            $fileforEvrakModel=new \App\ihracatEvrak();
            $files= $request->file('files');
            $now = \Carbon\Carbon::now('utc')->toDateTimeString();
            $counter=0;

            foreach ($files as $key=>$value)
            {

                $fileForEvr[$counter]=array(
                    'ihracatId'=>$id,
                    "fileName"=>Storage::disk('public')->put('ihracatevrak', $files[$key]),
                    "filetype"=>$files[$key]->getClientOriginalExtension(),
                    "kacinci"=>0,
                    "yukId"=>0,
                    "siraId"=>$key,
                    "filerealname"=>$files[$key]->getClientOriginalName(),
                    "belgetipi"=>trans("messages.gumrukdosyalari"),
                    "deleted"=>'no',
                    'created_at'=> $now,
                    'updated_at'=> $now
                );

                $counter++;

            }

            $fileforEvrakModel->insert($fileForEvr);
            $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
        }
        $log=new \App\LogModel();
        $log->talimatid=$id;
        $log->userid=\Auth::user()->id;
        $log->what=trans("messages.ihracat")." ".trans("messages.evrakyukle");
        $log->save();
          $mesaj=$talimatMesaj." ".trans("messages.evraksuccess");
          return view("layouts.success",['islemAciklama'=>$mesaj]);
      }


      public function ihracataltislemduzenle($id,$type)
      {
        $IhracatAltModel=new \App\IhracatAltModel();
        $IhracatAltModel->where("id","=",$id)->update(["islemdurumu"=>$type]);
        return back()->withInput();
        return $type;
      }

      public function ihracatdone($id)
      {
            $talimatModel=new \App\IhracatModel();
            $talimatModel->where("id","=",$id)->update(["durum"=>"tamamlandi"]);

            $talimat=$talimatModel->find($id);

            $userLK=new \App\User();
            $userkim=$userLK->find($talimat->firmaId);
            $userFirmName=$userkim->name;
            $userEmail=$userkim->email;
            $aracbilgi=trans("messages.cekiciplaka")." : ".$talimat->cekiciPlaka."- ".trans("messages.dorseplaka")." : ".$talimat->dorsePlaka;
            $mesajkonu=trans('messages.newtalimat')." ".$aracbilgi;
            $talimatMesaj=" <br/> <a href='http://gumruk.iskontrol.com/ihracat/dosya/indirfull/".md5($id)."'>".trans('messages.talimatevrakyuklemebaslik')." ".trans("messages.tumunuindir")."</a>";
            $UserSenderMailListModel=new \App\UserSenderMailListModel();
            $list=$UserSenderMailListModel->where("talimatId","=",$id)->get();
            $bugunmoralimbozuk=array();
            if (!empty($list))
            {
              foreach ($list as $key => $value) {
                $bugunmoralimbozuk[]=$value->usermail;
              }
            }


            if (!empty($bugunmoralimbozuk))
            {
              $konu=$aracbilgi." ".trans("messages.operasyon")." ".trans("messages.kaydedilmis");
              $mesaj=$konu." ".$talimatMesaj;
              \Mail::to("mehmetkuruyuz@gmail.com")->send(new InfoMailEvery($userFirmName,$userEmail,$konu,$mesaj,"nonstandart")) ;

            }else
            {
          //    \Mail::to($userEmail)->bcc(['info@creaception.com'])->send(new InfoMailEvery($userFirmName,$userEmail,$mesajkonu,$talimatMesaj."<br />".$aracbilgi,"nonstandart")) ;
              \Mail::to("mehmetkuruyuz@gmail.com")->send(new InfoMailEvery($userFirmName,$userEmail,$mesajkonu,$talimatMesaj."<br />".$aracbilgi,"nonstandart")) ;
            }
            $log=new \App\LogModel();
            $log->talimatid=$id;
            $log->userid=\Auth::user()->id;
            $log->what=trans("messages.talimattipi")." ".trans("messages.deleted");
            $log->save();
        return redirect('/ihracat/operasyon/list');
      }

      public function ihracataltdelete($_id)
      {
          $IhracatAltModel=new \App\IhracatAltModel();
          $ihracat=$IhracatAltModel->find($_id);
          $IhracatAltModel->where("id","=",$_id)->update(["deleted"=>"yes"]);

          $log=new \App\LogModel();
          $log->talimatid=$ihracat->ihracatId;
          $log->userid=\Auth::user()->id;
          $log->what=trans("messages.talimattipi")." ".trans("messages.deleted");
          $log->save();
          return $_id;
      }

      public function ihracatUpdate(Request $request)
      {
    // return $request;
        $newOperasyon=new \App\IhracatModel();


        $id=$request->input("id");
        $list=$newOperasyon->where("id","=",$id)->first();
        $gumrukAdedi=$list->gumrukAdedi;
        //$operation["firmaId"]=$request->input("firmaId");
        $operation["plaka"]=$request->input("plaka");
        $operation["sertifikano"]=$request->input("sertifikano");
        $operation["cekiciPlaka"]=$request->input("cekiciPlaka");
        $operation["dorsePlaka"]=$request->input("dorsePlaka");
        $operation["pozisyonNo"]=$request->input("pozisyonNo");
        $operation["teminatTipi"]=$request->input("teminatTipi");
        $operation["tasimaTipi"]=$request->input("tasimaTipi");
        $operation["note"]=$request->input("note");
        $newOperasyon->where("id","=",$id)->update($operation);

          $firmaId=$request->input("firmaId");
              $ihracatId=$id;

              $yuklemeNoktasiAdet=$request->input("yuklemeNoktasiAdet");

              $varisGumrugu=$request->input("varisGumrugu");
              $yuklemeNoktasi=$request->input("yuklemeNoktasi");
              $yuklemeNoktasiulkekodu=$request->input("yuklemeNoktasiulkekodu");
              $indirmeNoktasi=$request->input("indirmeNoktasi");
              $indirmeNoktasiulkekodu=$request->input("indirmeNoktasiulkekodu");
              $tekKap=$request->input("tekKap");
              $tekKilo=$request->input("tekKilo");
              $yukcinsi=$request->input("yukcinsi");
              $faturacinsi=$request->input("faturacinsi");
              $faturanumara=$request->input("faturanumara");
              $faturabedeli=$request->input("faturabedeli");
              $mrnnumber=$request->input("mrnnumber");
              $tirnumarasi=$request->input("tirnumarasi");
              $talimattipi=$request->input("talimattipi");
              $atanumarasi=$request->input("atanumarasi");
              $cekici=$request->input("cekici");
              $dorse=$request->input("dorse");
              $gelendosyalar=$request->file("spuserfile");



              $array=array();

              $kontrolVaris=0;
              $now = \Carbon\Carbon::now('utc')->toDateTimeString();
              $counter=0;


              $IhracatAltModel=new \App\IhracatAltModel();

              if (!empty($talimattipi))
              {
                //return $talimattipi;
              foreach ($talimattipi as $key => $value)
              {
                foreach($value as $x=>$y)
                {
                  $sirafinder=$IhracatAltModel->where("id","=",$key)->orderBy("gumrukSira","DESC")->first();
                    // return $sirafinder;
                  /* Mecburi sıfırlama */
                  $array[$key][$x]["ihracatId"]=$sirafinder->ihracatId;
                  $array[$key][$x]["gumrukno"]=$sirafinder->gumrukno;
                  if (empty($sirafinder->gumrukSira)) {$sirax=0;}
                  else {$sirax=$sirafinder->gumrukSira;}

                  $array[$key][$x]["gumrukSira"]=intval($sirax+1);
                  $array[$key][$x]["islemdurumu"]="bekliyor";
                  $array[$key][$x]["firmaId"]=$firmaId;
                  $array[$key][$x]["deleted"]="no";



                  if (!empty($faturanumara[$key][$x]))
                  {
                    $array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
                  }else {
                    $array[$key][$x]["faturanumara"]=$request->input("autoBarcode");
                  }


                  if (!empty($varisGumrugu[$key][$x]))            {$array[$key][$x]["varisGumruk"]=$varisGumrugu[$key][$x];}                        else {$array[$key][$x]["varisGumruk"]=""; $kontrolVaris++;}
                  if (!empty($yuklemeNoktasi[$key][$x]))          {$array[$key][$x]["yuklemeNoktasi"]=$yuklemeNoktasi[$key][$x];}                   else {$array[$key][$x]["yuklemeNoktasi"]="";}
                  if (!empty($yuklemeNoktasiulkekodu[$key][$x]))  {$array[$key][$x]["yuklemeNoktasiulkekodu"]=$yuklemeNoktasiulkekodu[$key][$x];}   else {$array[$key][$x]["yuklemeNoktasiulkekodu"]=0;}
                  if (!empty($indirmeNoktasi[$key][$x]))          {$array[$key][$x]["indirmeNoktasi"]=$indirmeNoktasi[$key][$x];}                   else {$array[$key][$x]["indirmeNoktasi"]="";}
                  if (!empty($indirmeNoktasiulkekodu[$key][$x]))  {$array[$key][$x]["indirmeNoktasiulkekodu"]=$indirmeNoktasiulkekodu[$key][$x];}   else {$array[$key][$x]["indirmeNoktasiulkekodu"]=0;}
                  if (!empty($tekKap[$key][$x]))                  {$array[$key][$x]["tekKap"]=$tekKap[$key][$x];}                                   else {$array[$key][$x]["tekKap"]="";}
                  if (!empty($tekKilo[$key][$x]))                 {$array[$key][$x]["tekKilo"]=$tekKilo[$key][$x];}                                 else {$array[$key][$x]["tekKilo"]="";}
                  if (!empty($yukcinsi[$key][$x]))                {$array[$key][$x]["yukcinsi"]=$yukcinsi[$key][$x];}                               else {$array[$key][$x]["yukcinsi"]="";}
                  if (!empty($tirnumarasi[$key][$x]))             {$array[$key][$x]["tirnumarasi"]=$tirnumarasi[$key][$x];}                         else {$array[$key][$x]["tirnumarasi"]="";}
                  if (!empty($talimattipi[$key][$x]))             {$array[$key][$x]["talimatTipi"]=$talimattipi[$key][$x];}                         else {$array[$key][$x]["talimatTipi"]="";}
                  if (!empty($faturabedeli[$key][$x]))            {$array[$key][$x]["faturabedeli"]=$faturabedeli[$key][$x];}                       else {$array[$key][$x]["faturabedeli"]="";}
                  if (!empty($mrnnumber[$key][$x]))               {$array[$key][$x]["mrnnumber"]=$mrnnumber[$key][$x];}                             else {$array[$key][$x]["mrnnumber"]="";}
                  if (!empty($atanumarasi[$key][$x]))             {$array[$key][$x]["atanumarasi"]=$atanumarasi[$key][$x];}                         else {$array[$key][$x]["atanumarasi"]="";}


                  if (!empty($cekici[$key][$x]))             {$array[$key][$x]["cekici"]=$cekici[$key][$x];}                         else {$array[$key][$x]["cekici"]="";}
                  if (!empty($dorse[$key][$x]))             {$array[$key][$x]["dorse"]=$dorse[$key][$x];}                         else {$array[$key][$x]["dorse"]="";}

                  if (!empty($gelendosyalar[$key][$x]))           {$digerarray[$key][$x]["files"]=$gelendosyalar[$key][$x];}

                }

              }

          //    return $array;

            $_arrayasil=array();
            $z=0;
            $_arraydosya=array();
            foreach ($array as $arraykey => $arrayvalue)
            {
             foreach ($arrayvalue as $xkey => $yalue)
             {
               $_arrayasil[$z]=$yalue;
               if (!empty($gelendosyalar[$arraykey][$xkey]))
               {
                 $_arraydosya[$z]=$gelendosyalar[$arraykey][$xkey];
               }
               $z++;
             }
            }


            $fileforEvrakModel=new \App\ihracatEvrak();

            $fileForEvr=array();
            foreach ($_arrayasil as $key => $value)
            {
            $return=$IhracatAltModel->firstOrCreate(["id"=>-1],$value);
            $_arrayasil[$key]['id']=$return->id;
            if (!empty($_arraydosya[$key]))
            {
                  foreach ($_arraydosya[$key] as $dosyakey => $dosyavalue)
                  {
                    $fileForEvr[$counter]=array(
                    "ihracatId"=>$ihracatId,
                    "kacinci"=>($_arrayasil[$key]["gumrukno"]+1),
                    "yukId"=>$_arrayasil[$key]['id'],
                    "siraId"=>$dosyakey,
                    "fileName"=>Storage::disk('public')->put('ihracatevrak', $dosyavalue),
                    "filetype"=>$dosyavalue->getClientOriginalExtension(),
                    "filerealname"=>$dosyavalue->getClientOriginalName(),
                    "belgetipi"=>$_arrayasil[$key]['talimatTipi'],
                    "deleted"=>"no",
                    'created_at'=> $now,
                    'updated_at'=> $now
                  );
                    $counter++;
                  }
              }

            }


            if (count($fileForEvr)>0)
            {

                $fileforEvrakModel->insert($fileForEvr);
            }

          }
            $talimatMesaj="";
            $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
            $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");

            $log=new \App\LogModel();
            $log->talimatid=$ihracatId;
            $log->userid=\Auth::user()->id;
            $log->what=trans("messages.talimatupdated");
            $log->save();
            /* Mail işlemleri eklenecek */

        //     \Mail::to('info@creaception.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.talimatupdated'),$talimatMesaj,"nonstandart")) ;
            \Mail::to('mehmetkuruyuz@gmail.com')->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.talimatupdated'),$talimatMesaj,"nonstandart")) ;
            return view("layouts.success",['islemAciklama'=>$talimatMesaj]);

        return $request;
      }

        public function exceloperation($tarih="",$tarih2="")
        {

          \Helper::langSet();
          $ulkeList = DB::table('ulkeKod')->get();
          $ulke=array();
          foreach ($ulkeList as $key => $value)
          {
            $ulke[$value->id]=$value->global_name;
          }

          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();

          if (!empty($tarih))
          {
            $start = $tarih." 00:00:00";
          }else {
          $start = date("Y-m-d")." 00:00:00";
          }

          if (!empty($tarih2))
          {
            $end = $tarih2." 23:59:59";
          }else {
            $end = date("Y-m-d")." 23:59:59";
          }

          $newOperasyon=new \App\IhracatModel();

          $userRole=Auth::user()->role;

          if ($userRole=="muhasebeadmin")
          {
          $bolgeler=DB::table("muhasebeBolge")->where("userid","=",Auth::user()->id)->get();

              $izinlibolgeler=array();
              foreach ($bolgeler as $key => $value)
              {
                $izinlibolgeler[]=$value->bolgeId;
              }
              $newOperasyon=$newOperasyon->whereIn("bolgeSecim",$izinlibolgeler);
          }

          $newOperasyon=$newOperasyon->whereBetween("created_at",[$start,$end])->with(["AltModel","User","Ilgili","Ilgilikayit","Bolge","AltModelJustName"])->orderBy("firmaId","ASC");

          $listex=$newOperasyon->get();

      //    return $listex;
          $listofarray=array();
          $fontStyle = [
              'font' => [
                  'size' => 16,
                   'bold' => true,
                   'color'=> ['argb' => 'FF25AAE2'],
              ]
          ];
          $fontStyle2 = [
              'font' => [
                  'size' => 14,
                   'bold' => true,
                   'color'=> ['argb' => 'FF25AAE2'],
              ]
          ];
          $fontStyle3 = [
              'font' => [
                  'size' => 13,
                   'bold' => true,
                   'color'=> ['argb' => 'FF7A0000'],
              ]
          ];
          $fontStyle4 = [
              'font' => [
                  'size' => 13,
                   'bold' => true,
                   'color'=> ['argb' => 'FF000000'],
              ]
          ];
          foreach ($listex as $key => $value)
          {
            $listofarray[$value->bolge->name][]=$value;
          }

          $justname=array();

          //return $listex;
          foreach ($listex as $key => $value)
          {
            foreach($value->altmodeljustname as $mkl=>$vlue)
            {
              if (empty($justname[$value->id][$vlue->talimatTipi])) {$justname[$value->id][$vlue->talimatTipi]=0;}
              $justname[$value->id][$vlue->talimatTipi]+=1;
            }
          }
          $talimatisimarray=array();
          foreach ($justname as $key => $value)
          {
            $isimsecici="";
            foreach ($value as $mk => $vk)
            {
              $isimsecici=$isimsecici.",".trans("messages.".$mk)."(".$vk.")";
            }
            $isimsecici=substr($isimsecici,1);

              if (!empty($talimatisimarray[$key])) {$talimatisimarray[$key]="";}
              $talimatisimarray[$key]=$isimsecici;
          }
        //  return $talimatisimarray;



          foreach(range('A','Z') as $columnID) {
          $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
          $sheet->mergeCells('A1:I1')->setCellValue('A1',trans("messages.ihracataracgiris")." - ".$start." ".$end)->getStyle('A1:I1')->applyFromArray($fontStyle);;
          $superpower=2;


          foreach ($listofarray as $key => $data)
          {
            $tumgumruksay=0;
            $tumyuksay=0;
            $sheet->mergeCells('A'.$superpower.':I'.$superpower)->setCellValue('A'.$superpower,trans("messages.bolgehangisi")." - ".$key)->getStyle('A'.$superpower.':L'.$superpower)->applyFromArray($fontStyle2);

            $superpower++;
            $sheet->setCellValue('B'.$superpower,trans("messages.sirano"));
            $sheet->setCellValue('B'.$superpower,trans("messages.companyname"));
            $sheet->setCellValue('C'.$superpower,trans("messages.autoBarcode"));
            $sheet->setCellValue('D'.$superpower,trans("messages.createddate"));
            $sheet->setCellValue('E'.$superpower,trans("messages.talimattipi"));
            $sheet->setCellValue('F'.$superpower,trans("messages.cekiciplaka"));
            $sheet->setCellValue('G'.$superpower,trans("messages.dorseplaka"));
            $sheet->setCellValue('H'.$superpower,trans("messages.kayitilgilenen"));
            $sheet->setCellValue('I'.$superpower,trans("messages.islemilgilenen"));
            $sheet->setCellValue('J'.$superpower,trans("messages.talimatdurumu"));
            $sheet->setCellValue('K'.$superpower,trans("messages.gumrukadet"));
            $sheet->setCellValue('L'.$superpower,trans("messages.alicigondericiadet"));

            $sheet->getStyle('A'.$superpower.':L'.$superpower)->applyFromArray($fontStyle4);
            $superpower++;
            $zulu=0;
          //$totalalttip="";

            foreach($data as $key=>$value)
            {



                $zulu++;
                $sheet->setCellValue('A'.$superpower,$zulu);
                $sheet->setCellValue('B'.$superpower,$value->user->name);
                $sheet->setCellValue('C'.$superpower,$value->autoBarcode);
                $sheet->setCellValue('D'.$superpower,\Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:i'));
                if (!empty($talimatisimarray[$value->id])) {$talimattipiXtext=$talimatisimarray[$value->id];}
                else {$talimattipiXtext="";}
                $sheet->setCellValue('E'.$superpower,$talimattipiXtext);
                $sheet->setCellValue('F'.$superpower,$value->cekiciPlaka);
                $sheet->setCellValue('G'.$superpower,$value->dorsePlaka);
                $sheet->setCellValue('H'.$superpower,$value->ilgili->name);
                if (!empty($value->ilgilikayit->name)) {$ilgilenen=$value->ilgilikayit->name;} else { $ilgilenen=""; }
                $sheet->setCellValue('I'.$superpower,$ilgilenen);
                $sheet->setCellValue('J'.$superpower,trans("messages.".$value->durum));
                $sheet->setCellValue('K'.$superpower,$value->gumrukAdedi);
                $sheet->setCellValue('L'.$superpower,$value->altmodel->count());


                $tumyuksay+=$value->altmodel->count();
                $tumgumruksay+=$value->gumrukAdedi;
                $superpower++;

                $totalalttip="";
          }
                $sheet->mergeCells('A'.$superpower.':L'.$superpower)->setCellValue('A'.$superpower,"   ");
                $superpower++;

                $sheet->setCellValue('E'.$superpower,trans("messages.toplam")." ".trans("messages.gumruktalimatiheader"));
                $sheet->setCellValue('F'.$superpower,($zulu));

                $sheet->setCellValue('G'.$superpower,trans("messages.toplam")." ".trans("messages.operasyon"));
                $sheet->setCellValue('H'.$superpower,($zulu));

                $sheet->setCellValue('I'.$superpower,trans("messages.toplam")." ".trans("messages.gumrukadet"));
                $sheet->setCellValue('J'.$superpower,$tumgumruksay);

                $sheet->setCellValue('K'.$superpower,trans("messages.toplam")." ".trans("messages.alicigondericiadet"));
                $sheet->setCellValue('L'.$superpower,$tumyuksay);

                $superpower++;

        }
          $writer = new Xlsx($spreadsheet);
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment; filename="'.date("d-m-Y H:i:s").'-file.xlsx"');
          $writer->save("php://output");

        }

        public function topludisariindir($id)
        {
          $data=new \App\ihracatEvrak();

          $allList=$data->where(DB::raw("md5(ihracatId)"),$id)->get();

          if (($allList->count()>0))
          {
          $archiveFile = storage_path(str_slug("file".\Carbon\Carbon::parse("now")).".zip");
          $archive = new ZipArchive();

          if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
              // loop through all the files and add them to the archive.
              foreach ($allList as $file) {
                  if ($archive->addFile("../public/uploads/".$file->fileName, $file->ihracatId."-".(($file->kacinci)+1)."-".($file->siraId+1)."-".($file->yukId+1)."-".$file->belgetipi."-".$file->filerealname)) {
                      // do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                      continue;
                  } else {
                      throw new Exception("file `{$file}` could not be added to the zip file: " . $archive->getStatusString());
                  }
              }

              // close the archive.
              if ($archive->close()) {
                  // archive is now downloadable ...
                  return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);
              } else {
                  throw new Exception("could not close zip file: " . $archive->getStatusString());
              }
          } else {
            throw new Exception("zip file could not be created: " . $archive->getStatusString());
          }
        }else {
          return trans("messages.dosyayok");
        }
        }
}

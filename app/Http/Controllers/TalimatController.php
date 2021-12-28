<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Mail\InfoMailEvery;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TalimatController extends Controller
{
    //

    public function __construct()
    {

    }

    public function index(Request $request)
    {


    }


    public function dosyasil($id)
    {
        \Helper::langSet();
        DB::table('musteriEvrak')->where("id","=",$id)->update(['deleted'=>'yes']);
        $talimatMesaj=trans('messages.dosyasilinmistir');//'Dosya Silinmiştir.';
        return back()->withInput();
        return view("layouts.success",['islemAciklama'=>$talimatMesaj]);
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
      $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

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


          // code...
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

      return view('talimat.talimat_new',['userlist'=>$listUser,'talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList,"bolge"=>$bolgeList,'yetkiler'=>$yetkiler]);
    }

    public function ihracatsave(Request $request)
    {

    //  exit;
    //  return $request;
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');
      \Helper::langSet();

      if (empty($request->input("gumrukAdedi")))    {  $gumrukAdedi=1;} else { $gumrukAdedi=$request->input("gumrukAdedi"); }
      if (empty($request->input("firmaId")))   { $firmaId=$request->input("externalFirma"); /* Firma Bilgisi eklenecek. Hızlı Ekleme vs.*/   }else { $firmaId=$request->input("firmaId"); }

      $talimatModel=new \App\TalimatModel();

      $talimatModel->autoBarcode=$request->input("autoBarcode");
      $talimatModel->bolgeSecim=$request->input("bolgeSecim");

      $talimatModel->gumrukAdedi=$gumrukAdedi;
      $talimatModel->cekiciPlaka=$request->input("cekiciPlaka");
      $talimatModel->dorsePlaka=$request->input("dorsePlaka");

      if (!empty($request->input("ext1tot2")))
      {
        $talimatModel->t2beklemedurumu="yes";
        $talimatModel->talimatTipi="ext1t2";
      }else
      {
        $talimatModel->t2beklemedurumu="no";
        $talimatModel->talimatTipi=$request->input("talimatTipi");
      }

      $talimatModel->note=$request->input("aciklama");
      $talimatModel->yeniTalimatMi="yes";
      $talimatModel->firmaId=$firmaId;

      $talimatModel->ilgilenenId=$userId;

      $talimatModel->deleted="no";
      $talimatModel->durum ="bekleme";
      $talimatModel->islemdurum ="bosta";


      $talimatModel->save();
      $id=$talimatModel->id;

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
      $array=array();

      $kontrolVaris=0;
      foreach ($yuklemeNoktasiAdet as $key => $value)
      {
        for($x=0;$x<$value[0];$x++)
        {

          if (empty($varisGumrugu[$key][$x])) {$kontrolVaris++;}
           $array[$key][$x]["talimatId"]=$id;
           $array[$key][$x]["gumrukId"]=$key;
           $array[$key][$x]["gumrukSira"]=($x+1);
           $array[$key][$x]["varisGumruk"]=$varisGumrugu[$key][$x];
           $array[$key][$x]["yuklemeNoktasi"]=$yuklemeNoktasi[$key][$x];
           $array[$key][$x]["yuklemeNoktasiulkekodu"]=$yuklemeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["indirmeNoktasi"]=$indirmeNoktasi[$key][$x];
           $array[$key][$x]["indirmeNoktasiulkekodu"]=$indirmeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["talimatTipi"]=$talimatModel->talimatTipi;
           $array[$key][$x]["tekKap"]=$tekKap[$key][$x];
           $array[$key][$x]["tekKilo"]=$tekKilo[$key][$x];
           $array[$key][$x]["yukcinsi"]=$yukcinsi[$key][$x];
           $array[$key][$x]["tirnumarasi"]=$tirnumarasi[$key][$x];
           if (!empty($faturanumara[$key][$x]))
           {
             $array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
           }else {
             $array[$key][$x]["faturanumara"]=$request->input("autoBarcode");
           }
           //$array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
           $array[$key][$x]["faturabedeli"]=$faturabedeli[$key][$x];
           $array[$key][$x]["mrnnumber"]=$mrnnumber[$key][$x];
           $array[$key][$x]["deleted"]="no";
           $array[$key][$x]["firmaId"]=$firmaId;
        }
      }

      $talimatAltModel=new \App\TalimatAltModel();



      $_arrayasil=array();
      $z=0;
      foreach ($array as $arraykey => $arrayvalue)
      {
        foreach ($arrayvalue as $xkey => $yalue)
        {
          $_arrayasil[$z]=$yalue;
          $z++;
        }
      }

      $talimatAltModel->insert($_arrayasil);




      $muhasebeModel=new \App\MuhasebeModel();
      $muhasebeModel->firmaId=$request->input("firmaId");

      $muhasebeModel->faturaTarihi=\Carbon\Carbon::parse("now")->format("Y-m-d h:i:s");
      $muhasebeModel->senaryo=" ";
      $muhasebeModel->tipi=$talimatModel->talimatTipi;
      $muhasebeModel->faturaReferans=trans("messages.ihracattangelenfatura");
      $muhasebeModel->talimatId=$id;
      $muhasebeModel->yapanId=$userId;
      $muhasebeModel->price=$request->input("talimatbedeli");
      if ($request->input("odemecinsi")=="nakit")
      {
        $muhasebeModel->faturadurumu="kapali";

      }else {
        $muhasebeModel->faturadurumu="acik";

      }
      $muhasebeModel->odemecinsi=$request->input("odemecinsi");
      $muhasebeModel->moneytype=$request->input("moneytype");
      $muhasebeModel->faturaNo=$request->input("autoBarcode");
      $muhasebeModel->autoBarcode=$request->input("autoBarcode");
      $muhasebeModel->bolgeId=$request->input("bolgeSecim");
      $muhasebeModel->deleted='no';
      $muhasebeModel->save();

      if ($request->input("odemecinsi")=="nakit")
      {
        $nakitOdemeModel=new \App\NakitOdemeModel();
        $nakitOdemeModel->faturaId=$muhasebeModel->id;
        $nakitOdemeModel->odemeFiyat=$request->input("talimatbedeli");
        $nakitOdemeModel->parabirimi=$request->input("moneytype");
        $nakitOdemeModel->yapanId=\Auth::user()->id;
        $nakitOdemeModel->save();
      }
      $talimatMesaj="";

      if(!empty($request->file('files')))
      {
          $fileforEvrakModel=new \App\musteriEvrak();
          $files= $request->file('files');
          $now = \Carbon\Carbon::now('utc')->toDateTimeString();
      //    return $files;
          $counter=0;

          foreach ($files as $key=>$value)
          {

              $fileForEvr[$counter]=array(
                  'talimatId'=>$id,
                  "fileName"=>Storage::disk('public')->put('files', $files[$key]),
                  "filetype"=>$files[$key]->getClientOriginalExtension(),
                  "filerealname"=>$files[$key]->getClientOriginalName(),
                  "belgetipi"=>"toplu",
                  "deleted"=>'no',
                  'created_at'=> $now,
                  'updated_at'=> $now
              );

              $counter++;

          }
          $fileforEvrakModel->insert($fileForEvr);
          $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
      }

      if(!empty($request->file('specialfiles')))
      {
          $fileforEvrakModel=new \App\musteriEvrak();
          $fileXXX=$request->file('specialfiles');
          $now = \Carbon\Carbon::now('utc')->toDateTimeString();
          $counter=0;
          $fileForEvr=array();
          foreach ($fileXXX as $key=>$value)
          {
            // KEY dosya tipi oldu

            foreach ($value as $keygumruk=>$e)
            {

              foreach ($e as $keyyuksira=>$m)
              {
                foreach ($m as $keyevraksira=>$z)
                {
                  if (!empty( $z))
                  {
                    $file=$z;
                    $fileForEvr[$counter]=array(
                        'talimatId'=>$id,
                        "kacinci"=>$keygumruk,
                        "yukId"=>$keyyuksira,
                        'siraId'=>$keyevraksira,
                        "fileName"=>Storage::disk('public')->put('files', $file),
                        "filetype"=>$file->getClientOriginalExtension(),
                        "filerealname"=>$file->getClientOriginalName(),
                        "belgetipi"=>$key,
                        "deleted"=>'no',
                        'created_at'=> $now,
                        'updated_at'=> $now
                    );

                      $counter++;
                //  echo $key." - ".$keygumruk." - ".$keyyuksira." - ".$keyevraksira."<br  />";
                    }
                  }
                }
              }
            }

        //  dd($fileXXX);
        /*
          foreach ($fileXXX as $key=>$value)
          {
            foreach ($value as $y=>$e)
            {
              foreach ($e as $r=>$m)
              {

                if (!empty( $m))
                {


                  $file=$m;
                  $fileForEvr[$counter]=array(
                      'talimatId'=>$id,
                      "kacinci"=>$y,
                      'siraId'=>$r,
                      "fileName"=>Storage::disk('public')->put('files', $file),
                      "filetype"=>$file->getClientOriginalExtension(),
                      "filerealname"=>$file->getClientOriginalName(),
                      "belgetipi"=>$key,
                      "deleted"=>'no',
                      'created_at'=> $now,
                      'updated_at'=> $now
                  );

                    $counter++;
                  }

              }
            }

          }
*/
          $fileforEvrakModel->insert($fileForEvr);
          $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');

      }



      if ($kontrolVaris>0)
      {
        switch ($request->input("talimatTipi"))
        {
          case 'ex1':
          case 't1kapama':
          case "ext1t2":
            $talimatModel->where("id","=",$id)->update(['durum'=>"firmabekleme"]);
            $talimatMesaj=$talimatMesaj.trans("messages.aracgirisifirmaveoperasyon");
          break;
          default:
            $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");
          break;
        }
      }else
      {
        $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");
      }



  if ($request->input("talimatTipi")=="listex")
  {

        $talimatModel->where("id","=",$id)->update(['durum'=>"tamamlandi"]);

    /* Hata veren alanlar blok olarak koy */
        $userLK=new \App\User();
        $userkim=$userLK->find($firmaId);
        $userFirmName=$userkim->name;
        $userEmail=$userkim->email;
      //  return $request;
  /* Hata veren alanlar blok olarak koy */

        $aracbilgi=trans("messages.cekiciplaka")." : ".$request->input("cekiciPlaka")."- ".trans("messages.dorseplaka")." : ".$request->input("dorsePlaka");
        $mesajkonu=trans('messages.newtalimat')." ".$aracbilgi;
        $talimatMesaj=$talimatMesaj." <br/> <a href='http://interbos.bosphoregroup.com/dosya/indirfull/".md5($id)."'>".trans('messages.talimatevrakyuklemebaslik')." ".trans("messages.tumunuindir")."</a>";

        if (!empty($request->input("firmamaillist")))
        {

          \Mail::to($userEmail)->bcc(['interbos@bosphoregroup.com','interbosctrl@bosphoregroup.com','interbos@creaception.com','serhat@bosphoregroup.com'])->cc($request->input("firmamaillist"))->send(new InfoMailEvery($userFirmName,$userEmail,$mesajkonu,$talimatMesaj."<br />".$aracbilgi)) ;
        }else
        {
          \Mail::to($userEmail)->bcc(['interbos@bosphoregroup.com','interbosctrl@bosphoregroup.com','interbos@creaception.com','serhat@bosphoregroup.com'])->send(new InfoMailEvery($userFirmName,$userEmail,$mesajkonu,$talimatMesaj."<br />".$aracbilgi)) ;
        }

  }




        $UserSenderMailListModel=new \App\UserSenderMailListModel();

        $now = \Carbon\Carbon::now('utc')->toDateTimeString();
        $counter=0;
        $mailerman=array();

        $firmamaillist=$request->input("firmamaillist");
        if (!empty($firmamaillist))
        {
          foreach ($firmamaillist as $key => $value)
          {
            $mailerman[$counter]=array(
                'talimatId'=>$id,
                'usermail'=>$value,
                'created_at'=> $now,
                'updated_at'=> $now
            );

              $counter++;
          }
          $UserSenderMailListModel->insert($mailerman);
        }




      return view("layouts.success",['islemAciklama'=>$talimatMesaj]);

    }


    public function ithalatsave(Request $request)
    {

      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');
      \Helper::langSet();

      if (empty($request->input("gumrukAdedi")))    {  $gumrukAdedi=1;} else { $gumrukAdedi=$request->input("gumrukAdedi"); }
      if (empty($request->input("firmaId")))   { $firmaId=$request->input("externalFirma"); /* Firma Bilgisi eklenecek. Hızlı Ekleme vs.*/   }else { $firmaId=$request->input("firmaId"); }

      $talimatModel=new \App\TalimatModel();

      $talimatModel->autoBarcode=$request->input("autoBarcode");
      $talimatModel->bolgeSecim=$request->input("bolgeSecim");

      $talimatModel->gumrukAdedi=$gumrukAdedi;
      $talimatModel->cekiciPlaka=$request->input("cekiciPlaka");
      $talimatModel->dorsePlaka=$request->input("dorsePlaka");
      $talimatModel->talimatTipi=$request->input("talimatTipi");



      $talimatModel->yeniTalimatMi="yes";
      $talimatModel->firmaId=$firmaId;

      $talimatModel->ilgilenenId=$userId;

      $talimatModel->deleted="no";
      $talimatModel->durum ="bekleme";
      if ($request->input("talimatTipi")!="bondeshortie")
      {
        $talimatModel->save();
      }else {
        $talimatModel->dorsePlaka=$request->input("plaka");
        $talimatModel->save();

      }
      $id=$talimatModel->id;


      if ($request->input("talimatTipi")!="bondeshortie")
      {

      $kontrolVaris=0;

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
      $array=array();


      foreach ($yuklemeNoktasiAdet as $key => $value)
      {
        for($x=0;$x<$value[0];$x++)
        {
          if (empty($varisGumrugu[$key][$x])) {$kontrolVaris++;}
           $array[$key][$x]["talimatId"]=$id;
           $array[$key][$x]["gumrukId"]=$key;
           $array[$key][$x]["gumrukSira"]=($x+1);
           $array[$key][$x]["varisGumruk"]=$varisGumrugu[$key][$x];
           $array[$key][$x]["yuklemeNoktasi"]=$yuklemeNoktasi[$key][$x];
           $array[$key][$x]["yuklemeNoktasiulkekodu"]=$yuklemeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["indirmeNoktasi"]=$indirmeNoktasi[$key][$x];
           $array[$key][$x]["indirmeNoktasiulkekodu"]=$indirmeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["talimatTipi"]=$talimatModel->talimatTipi;
           $array[$key][$x]["tekKap"]=$tekKap[$key][$x];
           $array[$key][$x]["tekKilo"]=$tekKilo[$key][$x];
           $array[$key][$x]["yukcinsi"]=$yukcinsi[$key][$x];
           if (!empty($faturanumara[$key][$x]))
           {
             $array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
           }else {
             $array[$key][$x]["faturanumara"]=$request->input("autoBarcode");
           }
           $array[$key][$x]["faturabedeli"]=$faturabedeli[$key][$x];
           $array[$key][$x]["mrnnumber"]=$mrnnumber[$key][$x];
           $array[$key][$x]["deleted"]="no";
           $array[$key][$x]["firmaId"]=$firmaId;
        }
      }

      $talimatAltModel=new \App\TalimatAltModel();
      $_arrayasil=array();
      $z=0;
      foreach ($array as $arraykey => $arrayvalue)
      {
        foreach ($arrayvalue as $xkey => $yalue)
        {
          $_arrayasil[$z]=$yalue;
          $z++;
        }
      }

      $talimatAltModel->insert($_arrayasil);
    }
    /* Devam edeceğim alan */


      $muhasebeModel=new \App\MuhasebeModel();
      $muhasebeModel->firmaId=$request->input("firmaId");

      $muhasebeModel->faturaTarihi=\Carbon\Carbon::parse("now")->format("Y-m-d h:i:s");
      $muhasebeModel->senaryo=" ";
      $muhasebeModel->tipi=$talimatModel->talimatTipi;
      $muhasebeModel->faturaReferans=trans("messages.ithalattangelenfatura");
      $muhasebeModel->talimatId=$id;
      $muhasebeModel->yapanId=$userId;
      $muhasebeModel->bolgeId=$request->input("bolgeSecim");
      $muhasebeModel->price=$request->input("faturabedeli");

      $muhasebeModel->odemecinsi=$request->input("odemecinsi");
      if ($request->input("odemecinsi")=="nakit")
      {
        $muhasebeModel->faturadurumu="kapali";

      }else {
        $muhasebeModel->faturadurumu="acik";

      }
      if ($request->input("talimatTipi")=="bondeshortie")
      {
        $muhasebeModel->faturadurumu="kapali";
        $muhasebeModel->kapayanId=$userId=Auth::user()->id;
        $muhasebeModel->odemecinsi="nakit";
      }

      $muhasebeModel->moneytype=$request->input("moneytype");
      $muhasebeModel->autoBarcode=$request->input("autoBarcode");
      $muhasebeModel->deleted='no';
      $muhasebeModel->save();

      $muhasebeId=$muhasebeModel->id;

      if ($request->input("odemecinsi")=="nakit")
      {

        $nakitOdemeModel=new \App\NakitOdemeModel();
        $nakitOdemeModel->faturaId=$muhasebeModel->id;
        $nakitOdemeModel->odemeFiyat=$request->input("faturabedeli");
        $nakitOdemeModel->parabirimi=$request->input("moneytype");
        $nakitOdemeModel->durumu="odenmedi";
        $nakitOdemeModel->yapanId=\Auth::user()->id;
        $nakitOdemeModel->save();
      }

      $talimatMesaj="";

      if(!empty($request->file('files')))
      {
          $fileforEvrakModel=new \App\musteriEvrak();
          $files= $request->file('files');
          $now = \Carbon\Carbon::now('utc')->toDateTimeString();
          //return $files;
          $counter=0;

          foreach ($files as $key=>$value)
          {

              $fileForEvr[$counter]=array(
                'talimatId'=>$id,
                "fileName"=>Storage::disk('public')->put('files', $files[$key]),
                "filetype"=>$files[$key]->getClientOriginalExtension(),
                "filerealname"=>$files[$key]->getClientOriginalName(),
                "belgetipi"=>$key,
                "deleted"=>'no',
                'created_at'=> $now,
                'updated_at'=> $now
              );

              $counter++;

          }

          $fileforEvrakModel->insert($fileForEvr);
          $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
      }

      if (!empty($kontrolVaris))
      {
            if ($kontrolVaris>0)
            {
              //firmabekleme $id
              $talimatModel->where("id","=",$id)->update(['durum'=>"firmabekleme"]);
              $talimatMesaj=$talimatMesaj.trans("messages.aracgirisifirmaveoperasyon");
            }else
            {
              $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");
            }

        }else {
          $talimatMesaj=$talimatMesaj.trans("messages.save");
        }


        if ($request->input("talimatTipi")=="bondeshortie")
        {
            $talimatModel->where("id","=",$id)->update(['durum'=>"tamamlandi"]);
            $talimatMesaj=trans("messages.bondeshortiesaveok")."<a href='javascript:void(0)' onclick=\"PopupCenter('/operation/print/".$id."','xxaxtf','930','500'); \" class='btn btn-danger' >".trans("messages.bondeshortieprint")."</a>";

            //return redirect('/operation/print/'.$id);
        }

        $userLK=new \App\User();
        $userkim=$userLK->find($firmaId);
        $userFirmName=$userkim->name;
        $userEmail=$userkim->email;

     \Mail::to('interbos@bosphoregroup.com')->bcc(['interbosctrl@bosphoregroup.com'])->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.newtalimat'),$talimatMesaj)) ;

      return view("layouts.success",['islemAciklama'=>$talimatMesaj]);

    }



    public function gumrukListesi()
    {
      \Helper::langSet();
      $all = DB::table('gumrukListesi')->select(DB::RAW("Upper(bigname) as name"),"code","id")->get();
      foreach ( $all as $key => $value)
      {
        $gumrukListesi[$key]["name"]=mb_convert_encoding($value->name,'UTF-8');
        $gumrukListesi[$key]["code"]=$value->code;
        $gumrukListesi[$key]["id"]=$value->id;
      }

      return $gumrukListesi;

    }

    public function yukcinsiListesi()
    {
      //return $req;
      \Helper::langSet();
      $gumrukListesi = DB::table('yukcinsi')->get();
      return $gumrukListesi;

    }

    public function view($id)
    {


    }

    public function edit($id)
    {
        \Helper::langSet();
        return view("talimat/talimat_edit",['talimat'=>$talimatOne,'talimatList'=>$talimatList,'userlist'=>$listUser]);
    }

    public function update(Request $request)
    {
    //    return $request;
        \Helper::langSet();


        \Mail::to('interbos@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.talimatupdated'),$talimatMesaj)) ;

//        return redirect('/talimat')->withErrors([$talimatMesaj]);
        //return ;
    }



    public function print($id)
    {
        \Helper::langSet();
    //    return view("talimat/talimat_print",['talimat'=>$talimatOne,'talimatTipList'=>$talimatList,'isimArray'=>$arrayList,"barcode"=>$autoBarcode]);
    }

    public function evrakupdate(Request $request)
    {
        \Helper::langSet();

//        return view("layouts.success",['islemAciklama'=>$talimatMesaj]);

    }

    public function delete($id)
    {
        \Helper::langSet();
  //      return view("layouts.success",['islemAciklama'=>$talimatMesaj]);
    }





    public function durum($id,$islem)
    {

        \Helper::langSet();

//       \Mail::to('systemautomate@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.talimatupdated'),$talimatMesaj)) ;

  //      return view("talimat/talimat_evrak",['talimat'=>$talimatOne,'talimatTipList'=>$talimatList,'isimArray'=>$arrayList]);

    }


    public function excel()
    {
      /*
        Kaydetmek için
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");
      */

      $inputFileName = 'hello_world.xlsx';
      /** Load $inputFileName to a Spreadsheet Object  **/
      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
      $sheetData = $spreadsheet->getActiveSheet()->toArray();
      print_r($sheetData);
    }


    public function altdata($talimat,$say,$firmaId=0)
    {
      $array=array();
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
      switch ($talimat)
      {
        case 'ex1':
            for($t=1;$t<=$say;$t++)
            {
                $view="";
                $view=\View::make('talimat.talimat_ext1',['say'=>($t-1),'ulkeList'=>$ulkeList]);
                $array[$t]= $view->render();
            }
        break;
        case 't1':
            for($t=1;$t<=$say;$t++)
            {
                $view="";
                $view=\View::make('talimat.talimat_t1',['say'=>($t-1),'ulkeList'=>$ulkeList]);
                $array[$t]= $view->render();
            }
        break;
        case 't2':
            for($t=1;$t<=$say;$t++)
            {
                $view="";
                $view=\View::make('talimat.talimat_t2',['say'=>($t-1),'ulkeList'=>$ulkeList]);
                $array[$t]= $view->render();
            }
        break;
        case "passage":
        for($t=1;$t<=$say;$t++)
        {
            $view="";
            $view=\View::make('talimat.talimat_tirpassage',['say'=>($t-1),'ulkeList'=>$ulkeList]);
            $array[$t]= $view->render();
        }
        break;
        case 't1kapama':
            for($t=1;$t<=$say;$t++)
            {
                $view="";
                $view=\View::make('talimat.talimat_t1kapama',['say'=>($t-1),'ulkeList'=>$ulkeList]);
                $array[$t]= $view->render();
            }
        break;
        case 'tir':
            for($t=1;$t<=$say;$t++)
            {
                $view="";
                $view=\View::make('talimat.talimat_tirkarnesi',['say'=>($t-1),'ulkeList'=>$ulkeList]);
                $array[$t]= $view->render();
            }
        break;
        case 'ata':
            for($t=1;$t<=$say;$t++)
            {
                $view="";
                $view=\View::make('talimat.talimat_ata',['say'=>($t-1),'ulkeList'=>$ulkeList]);
                $array[$t]= $view->render();
            }
        break;
        case "listex":
        for($t=1;$t<=$say;$t++)
        {
            $view="";
            $view=\View::make('talimat.talimat_listex',['say'=>($t-1),'ulkeList'=>$ulkeList]);
            $array[$t]= $view->render();
        }
        break;
        case "ithalatimport":
        for($t=1;$t<=$say;$t++)
        {
            $view="";
            $view=\View::make('talimat.talimat_ithalatimport',['say'=>($t-1),'ulkeList'=>$ulkeList]);
            $array[$t]= $view->render();
        }
        break;

        case "bondeshortie":
        $firm=new \App\User();

        $lis=$firm->select("name")->where("id","=",$firmaId)->first();

        for($t=1;$t<=$say;$t++)
        {
            $view="";
            $view=\View::make('talimat.talimat_bonde',['say'=>($t-1),'ulkeList'=>$ulkeList,'name'=>$lis->name]);
            $array[$t]= $view->render();
        }
        break;
        case "ext1t2":
        for($t=1;$t<=$say;$t++)
        {
            $view="";
            $view=\View::make('talimat.talimat_ext1-t2',['say'=>($t-1),'ulkeList'=>$ulkeList]);
            $array[$t]= $view->render();
        }
        break;
        default:
        for($t=1;$t<=$say;$t++)
        {
          $view="";
          $view=\View::make('talimat.talimat_default',['say'=>($t-1),'talimat'=>$talimat,'ulkeList'=>$ulkeList]);
          $array[$t]= $view->render();

        }
        break;
      }

        return $array;
    }





    public function ithalatnew()
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
      $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

      $bolgeList = DB::table('bolge')->get();
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
      $allUser=new \App\User();
      $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','=','watcher')->get();
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
      switch ($userRole) {
        case 'admin':
            $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','=','watcher')->get();
        break;
        default:
        case 'bolgeadmin':
            $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('bolgeId',"=",Auth::user()->bolgeId)->where('role','=','watcher')->get();
        break;


          // code...
          break;
      }

      return view('ithalat.ithalat_new',['userlist'=>$listUser,'talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList,"bolge"=>$bolgeList,"yetkiler"=>$yetkiler]);
    }




    public function ihracatsavet2(Request $request)
    {

    //  return $request;//


      $kapatId=$request->input("extalimatIdKapanacak");
      $eskitalimatModel=new \App\TalimatModel();
      $eskitalimatModel->where("id","=",$kapatId)->update(["durum"=>"tamamlandi","islemdurum"=>"tamamlandi","t2beklemedurumu"=>"no"]);

      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');
      \Helper::langSet();

      if (empty($request->input("gumrukAdedi")))    {  $gumrukAdedi=1;} else { $gumrukAdedi=$request->input("gumrukAdedi"); }
      if (empty($request->input("firmaId")))   { $firmaId=$request->input("externalFirma"); /* Firma Bilgisi eklenecek. Hızlı Ekleme vs.*/   }else { $firmaId=$request->input("firmaId"); }

      $talimatModel=new \App\TalimatModel();



      $talimatModel->autoBarcode=$request->input("autoBarcode");
      $talimatModel->bolgeSecim=$request->input("bolgeSecim");

      $talimatModel->gumrukAdedi=$gumrukAdedi;
      $talimatModel->cekiciPlaka=$request->input("cekiciPlaka");
      $talimatModel->dorsePlaka=$request->input("dorsePlaka");

      if (!empty($request->input("ext1tot2")))
      {
        $talimatModel->t2beklemedurumu="yes";
        $talimatModel->talimatTipi="ext1t2";
      }else
      {
        $talimatModel->t2beklemedurumu="no";
        $talimatModel->talimatTipi=$request->input("talimatTipi");
      }

      $talimatModel->yeniTalimatMi="yes";
      $talimatModel->firmaId=$firmaId;

      $talimatModel->ilgilenenId=$userId;

      $talimatModel->deleted="no";
      $talimatModel->durum ="bekleme";
      $talimatModel->islemdurum ="bosta";


      $talimatModel->save();
      $id=$talimatModel->id;


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
      $array=array();
      if (!empty($request->input("yuklemeNoktasiAdet")))
      {
        $yuklemeNoktasiAdet=$request->input("yuklemeNoktasiAdet");
      }else {
        $yuklemeNoktasiAdet[0][0]=count($mrnnumber[0]);
      }
      //return $yuklemeNoktasiAdet;

      $kontrolVaris=0;
      foreach ($yuklemeNoktasiAdet as $key => $value)
      {
        for($x=0;$x<$value[0];$x++)
        {

          if (empty($varisGumrugu[$key][$x])) {$kontrolVaris++;}
           $array[$key][$x]["talimatId"]=$id;
           $array[$key][$x]["gumrukId"]=$key;
           $array[$key][$x]["gumrukSira"]=($x+1);
           $array[$key][$x]["varisGumruk"]=$varisGumrugu[$key][$x];
           $array[$key][$x]["yuklemeNoktasi"]=$yuklemeNoktasi[$key][$x];
           $array[$key][$x]["yuklemeNoktasiulkekodu"]=$yuklemeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["indirmeNoktasi"]=$indirmeNoktasi[$key][$x];
           $array[$key][$x]["indirmeNoktasiulkekodu"]=$indirmeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["talimatTipi"]=$talimatModel->talimatTipi;
           $array[$key][$x]["tekKap"]=$tekKap[$key][$x];
           $array[$key][$x]["tekKilo"]=$tekKilo[$key][$x];
           $array[$key][$x]["yukcinsi"]=$yukcinsi[$key][$x];
           if (!empty($faturanumara[$key][$x]))
           {
             $array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
           }else {
             $array[$key][$x]["faturanumara"]=$request->input("autoBarcode");
           }
           //$array[$key][$x]["faturanumara"]=$faturanumara[$key][$x];
           $array[$key][$x]["faturabedeli"]=$faturabedeli[$key][$x];
           $array[$key][$x]["mrnnumber"]=$mrnnumber[$key][$x];
           $array[$key][$x]["deleted"]="no";
           $array[$key][$x]["firmaId"]=$firmaId;
        }
      }

      $talimatAltModel=new \App\TalimatAltModel();



      $_arrayasil=array();
      $z=0;
      foreach ($array as $arraykey => $arrayvalue)
      {
        foreach ($arrayvalue as $xkey => $yalue)
        {
          $_arrayasil[$z]=$yalue;
          $z++;
        }
      }

      $talimatAltModel->insert($_arrayasil);




      $muhasebeModel=new \App\MuhasebeModel();
      $muhasebeModel->firmaId=$request->input("firmaId");

      $muhasebeModel->faturaTarihi=\Carbon\Carbon::parse("now")->format("Y-m-d h:i:s");
      $muhasebeModel->senaryo=" ";
      $muhasebeModel->tipi=$talimatModel->talimatTipi;
      $muhasebeModel->faturaReferans=trans("messages.ihracattangelenfatura");
      $muhasebeModel->talimatId=$id;
      $muhasebeModel->yapanId=$userId;
      $muhasebeModel->price=$request->input("talimatbedeli");
      if ($request->input("odemecinsi")=="nakit")
      {
        $muhasebeModel->faturadurumu="kapali";

      }else {
        $muhasebeModel->faturadurumu="acik";

      }
      $muhasebeModel->odemecinsi=$request->input("odemecinsi");
      $muhasebeModel->moneytype=$request->input("moneytype");
      $muhasebeModel->faturaNo=$request->input("autoBarcode");
      $muhasebeModel->autoBarcode=$request->input("autoBarcode");
      $muhasebeModel->bolgeId=$request->input("bolgeSecim");
      $muhasebeModel->deleted='no';
      $muhasebeModel->save();

      if ($request->input("odemecinsi")=="nakit")
      {
        $nakitOdemeModel=new \App\NakitOdemeModel();
        $nakitOdemeModel->faturaId=$muhasebeModel->id;
        $nakitOdemeModel->odemeFiyat=$request->input("talimatbedeli");
        $nakitOdemeModel->parabirimi=$request->input("moneytype");
        $nakitOdemeModel->yapanId=\Auth::user()->id;
        $nakitOdemeModel->save();
      }
      $talimatMesaj="";

      if(!empty($request->file('files')))
      {
          $fileforEvrakModel=new \App\musteriEvrak();
          $files= $request->file('files');
          $now = \Carbon\Carbon::now('utc')->toDateTimeString();
          //return $files;
          $counter=0;

          foreach ($files as $key=>$value)
          {

              $fileForEvr[$counter]=array(
                  'talimatId'=>$id,
                  "fileName"=>Storage::disk('public')->put('files', $files[$key]),
                  "filetype"=>$files[$key]->getClientOriginalExtension(),
                  "filerealname"=>$files[$key]->getClientOriginalName(),
                  "belgetipi"=>"toplu",
                  "deleted"=>'no',
                  'created_at'=> $now,
                  'updated_at'=> $now
              );

              $counter++;

          }
          $fileforEvrakModel->insert($fileForEvr);
          $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
      }

      if(!empty($request->file('specialfiles')))
      {
          $fileforEvrakModel=new \App\musteriEvrak();
          $fileXXX=$request->file('specialfiles');
          $now = \Carbon\Carbon::now('utc')->toDateTimeString();
          $counter=0;
          $fileForEvr=array();
        //  dd($fileXXX);
          foreach ($fileXXX as $key=>$value)
          {
            foreach ($value as $y=>$e)
            {
              foreach ($e as $r=>$m)
              {

                if (!empty( $m))
                {


                  $file=$m;
                  $fileForEvr[$counter]=array(
                      'talimatId'=>$id,
                      "kacinci"=>$y,
                      'siraId'=>$r,
                      "fileName"=>Storage::disk('public')->put('files', $file),
                      "filetype"=>$file->getClientOriginalExtension(),
                      "filerealname"=>$file->getClientOriginalName(),
                      "belgetipi"=>$key,
                      "deleted"=>'no',
                      'created_at'=> $now,
                      'updated_at'=> $now
                  );

                    $counter++;
                  }

              }
            }

          }

          $fileforEvrakModel->insert($fileForEvr);
          $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');

      }



      if ($kontrolVaris>0)
      {
        switch ($request->input("talimatTipi"))
        {
          case 'ex1':
          case 't1kapama':
          case "listex":
          case "ext1t2":
            $talimatModel->where("id","=",$id)->update(['durum'=>"firmabekleme"]);
            $talimatMesaj=$talimatMesaj.trans("messages.aracgirisifirmaveoperasyon");
          break;
          default:
            $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");
          break;
        }
      }else
      {
        $talimatMesaj=$talimatMesaj.trans("messages.aracgirisioperasyon");
      }

/* Hata veren alanlar blok olarak koy */
      $userLK=new \App\User();
      $userkim=$userLK->find($firmaId);
      $userFirmName=$userkim->name;
      $userEmail=$userkim->email;
    //  return $request;
/* Hata veren alanlar blok olarak koy */
//      \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.newtalimat'),$talimatMesaj)) ;

      return view("layouts.success",['islemAciklama'=>$talimatMesaj]);

    }
}

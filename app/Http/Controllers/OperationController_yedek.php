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

class OperationController extends Controller
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
    public function index()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $userBolge=Auth::user()->bolgeId;
      //  return $userBolge;
        $operasyonModel=new \App\TalimatModel();

        switch ($userRole) {
          case 'watcher':
              $allList=$operasyonModel->with(['User','Bolge','Ilgili','Evrak','Ilgilikayit'])->where("durum","!=","tamamlandi")->where('deleted','=','no')->where('firmaId','=',$userId)->orderBy('created_at','DESC')->get();
          break;
          case "muhasebeadmin":
          case "admin":
            $allList=$operasyonModel->with(['User','Ilgili','Bolge','Evrak','Ilgilikayit'])->where("durum","!=","tamamlandi")->where('deleted','=','no')->orderBy('created_at','DESC')->get();
          break;
          case "bolgeadmin":
          default:
          if ($userBolge==3)
          {
            $allList=$operasyonModel->with(['User','Ilgili','Bolge','Evrak','Ilgilikayit'])->where("durum","=","bekleme")->where('deleted','=','no')->
            where(function ($query) {
                  $query->where('bolgeSecim', '=', Auth::user()->bolgeId)->orWhere("talimatTipi","=","ext1t2")
                      ->orWhere('talimatTipi', '=', "t2");
                  })->
                  orderBy('created_at','DESC')->get();
          }
          else {
            $allList=$operasyonModel->with(['User','Ilgili','Bolge','Evrak','Ilgilikayit'])->where("durum","=","bekleme")->where('deleted','=','no')->where('bolgeSecim','=',$userBolge)->orderBy('created_at','DESC')->get();
          }

          break;
        }


      //  return $allList;
        return view('operasyon.operasyon_index',['operasyonList'=>$allList]);

    }
    public function doneindex()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $userBolge=Auth::user()->bolgeId;
        $operasyonModel=new \App\TalimatModel();
                  $userModel=new \App\User();

        switch ($userRole) {
          case 'watcher':

          $userlist=$userModel->withCount(["Talimat"])->with("Talimat")->where("role","=","watcher")->where('id','=',$userId)->get();
          $filtered_user = $userlist->filter(function($item) {
                  return $item->talimat_count >0;
              });
          //return $filtered_user;
              //$allList=$operasyonModel->with(['User','Bolge','Ilgili'])->where("durum","=","tamamlandi")->where('deleted','=','no')->where('firmaId','=',$userId)->orderBy('created_at','DESC')->get();
          break;

          case "admin":
            $userlist=$userModel->withCount(["Talimat"])->with("Talimat")->where("role","=","watcher")->get();

            $filtered_user = $userlist->filter(function($item) {
                    return $item->talimat_count >0;
                });
          break;
          case "muhasebeadmin":
          case "bolgeadmin":
          default:
          if ($userBolge==3)
          {
            $userlist=$userModel->withCount(["Talimat"])->with(["Talimat"])->where("role","=","watcher")->get();
          }
          else {
              $userlist=$userModel->withCount(["Talimat"])->with(["Talimat"])->where("role","=","watcher")->where('bolgeId','=',$userBolge)->get();
          }
          $filtered_user = $userlist->filter(function($item) {
                  return $item->talimat_count >0;
              });
          //  $allList=$operasyonModel->with(['User','Ilgili','Bolge'])->->where('deleted','=','no')->where('ilgilenenId','=',$userId)->orderBy('created_at','DESC')->get();
          break;
        }


      //return $filtered_user;
        return view('operasyon.operasyon_index_done',['operasyonList'=>$filtered_user]);

    }


    public function save(Request $request)
    {

      //return $request->all();


      $newOperasyon=new \App\OperasyonModel();

      $newOperasyon->firmaId=$request->input("firmaId");
      $newOperasyon->cekiciPlaka=$request->input("cekiciPlaka");
      $newOperasyon->dorsePlaka=$request->input("dorsePlaka");

      $newOperasyon->kap=$request->input("kap");
      $newOperasyon->netkilo=$request->input("netkilo");
      $newOperasyon->brutkilo=$request->input("brutkilo");
      $newOperasyon->ulkekodu=$request->input("ulkekodu");
      $newOperasyon->paketcinsi=$request->input("paketcinsi");
      $newOperasyon->malcinsi=$request->input("malcinsi");


      $newOperasyon->gonderici=$request->input("gonderici");
      $newOperasyon->alici=$request->input("alici");

      $newOperasyon->yeniTalimatMi='yes';
      $newOperasyon->durum="bekliyor";
      $newOperasyon->gumrukAdedi=1;
      $newOperasyon->deleted="no";
      $newOperasyon->save();

      $lom=$newOperasyon->id;

      if(!empty($request->file('dosya')))
      {
        $dosya=$request->file('dosya');
        $now = \Carbon\Carbon::now()->toDateTimeString();

        $counter=0;
        foreach($dosya as $key=>$value)
        {
            foreach($value as $mu=>$tu)
            {
                $fileForEvr[$counter]=array(
                    'operasyonId'=>$lom,
                    "fileName"=>Storage::disk('public')->put('files', $tu),
                    "filetype"=>$tu->extension(),
                    "dosyaTipi"=>$key,
                    "deleted"=>'no',
                    "isWrited"=>'no',
                    'created_at'=> $now,
                    'updated_at'=> $now
                );

                $counter++;

            }

        }
        $fileforEvrakModel=new \App\musteriOperasyonEvrak();
        $fileforEvrakModel->insert($fileForEvr);
      }

      $mesaj=trans("messages.operasyonsuccess");
      return view("layouts.success",['islemAciklama'=>$mesaj]);

    }

    public function goster($_id)
    {

      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');

      $newOperasyon=new \App\TalimatModel();
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

      $muhasebeModel=new \App\MuhasebeModel();
      $md=$muhasebeModel->where("talimatId","=",$_id)->select("faturadurumu")->first();
    //return $data;
      return view("operasyon.operasyon_view",['talimat'=>$data,"barcode"=>$autoBarcode,'ulke'=>$ulke,'fatura'=>$md]);
    }

    public function islem($_id,$islem)
    {
      $newOperasyon=new \App\OperasyonModel();
      $operasyon=$newOperasyon->where('deleted','=','no')->where('id','=',$_id)->update(['durum'=>$islem]);
      if ($islem=="talimatolan")
      {
          $data=$newOperasyon->where('id',$_id)->first();
          //return $data;
          $talimatModel=new \App\TalimatModel();

          $talimatModel->firmaId=$data->firmaId;
          $talimatModel->gumrukAdedi=1;
          $talimatModel->cekiciPlaka=$data->cekiciPlaka;
          $talimatModel->dorsePlaka=$data->dorsePlaka;

          $talimatModel->yeniTalimatMi='yes';
          $talimatModel->deleted='no';
          $talimatModel->durum=0;

          $barcode="BO".intval(substr(md5(rand(1264,987654321).microtime().rand(1264,987654321)), 0, 8), 16);

          $talimatModel->autoBarcode=$barcode;
          $talimatModel->save();
          return redirect('/talimat/edit/'.$talimatModel->id);
      }

      $mesaj=trans("messages.operasyon".$islem);
      return view("layouts.success",['islemAciklama'=>$mesaj]);
    }

    public function edit($_id)
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $lang = Session::get ('locale');
        if ($lang == null)
        {
            $lang='tr';
        }
    //    $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

        $newOperasyon=new \App\TalimatModel();
        $newOperasyon->where('id','=',$_id)->update(['yeniTalimatMi'=>'no']);
        $operasyon=$newOperasyon->with(['User','Bolge','Ilgili','AltModel'])->where('deleted','=','no')->where('id','=',$_id);



        $data=$operasyon->first();
//return $data;
        $altmodel=array();
        foreach ($data->altmodel as $key => $value)
        {
          $altmodel[$value->gumrukId][]=$value;
        }

        if ($userRole=="watcher" && $userId!=$data->firmaId)
        {
            $islemAciklama="Unauthorised Area!. Please Contact Your Admin";
            return view("layouts.error",["islemAciklama"=>$islemAciklama]);
        }

        $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

        $bolgeList = DB::table('bolge')->get();
        $ulkeModel= new \App\UlkeKodModel();
        $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
        $ulke=array();

        foreach ($ulkeList as $key => $value)
        {
          $ulke[$value->id]=$value->global_name;
        }
        $allUser=new \App\User();
/*
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
*/
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
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $autoBarcode="";
        if (!empty($data->autoBarcode))
        {
          $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->autoBarcode, $generator::TYPE_CODE_128)) . '">';
        }





        return view("operasyon.operasyon_edit",['talimat'=>$data,"barcode"=>$autoBarcode,'userlist'=>$listUser,'talimatList'=>$talimatList,'ulkeList'=>$ulkeList,'ulke'=>$ulke,"bolge"=>$bolgeList,'yetkiler'=>$yetkiler,"altmodel"=>$altmodel]);


      }


        public function opupdate(Request $request)
        {
          \Helper::langSet();
          $userId=Auth::user()->id;
          $userRole=Auth::user()->role;
          $lang = Session::get ('locale');
          $tal=new \App\TalimatAltModel();
          $x=$request->input("varisgumruk");
          $kontrol=0;
          foreach ($x as $key => $value)
          {
              $data=$tal->where("id","=",$key)->first();
              if (empty($value)) {$kontrol++;}
              if ($userRole=="watcher" && $userId!=$data->firmaId)
              {

                  $islemAciklama="Unauthorised Area!. Please Contact Your Admin";
                  return view("layouts.error",["islemAciklama"=>$islemAciklama]);
              }
              $tal->where("id","=",$key)->update(["varisGumruk"=>$value]);
          }

          if (!empty($data) && $kontrol==0)
          {
            $talimatAnaModel=new \App\TalimatModel();
            $talimatAnaModel->where("id","=",$data->talimatId)->update(["durum"=>"bekleme"]);
          }

          if($kontrol>0)
          {
            $talimatAnaModel=new \App\TalimatModel();
            $talimatAnaModel->where("id","=",$data->talimatId)->update(["durum"=>"firmabekleme"]);
          }

          if ($userRole=="watcher")
          {
            return redirect('/operation/continue');
          }
          return redirect('/operasyon/goster/'.$data->talimatId);
        }




    public function update(Request $request)
    {


    //  return  $request;

      $newOperasyona=new \App\TalimatModel();



      $newOperasyon["firmaId"]=$request->input("firmaId");
      $newOperasyon["bolgeSecim"]=$request->input("bolgeSecim");

      $newOperasyon["cekiciPlaka"]=$request->input("cekiciPlaka");
      $newOperasyon["dorsePlaka"]=$request->input("dorsePlaka");
      $newOperasyon["autoBarcode"]=$request->input("autoBarcode");
      if (empty($request->input("gumrukAdedi")))    {  $gumrukAdedi=1;} else { $gumrukAdedi=$request->input("gumrukAdedi"); }
      if (empty($request->input("firmaId")))   { $firmaId=$request->input("externalFirma"); /* Firma Bilgisi eklenecek. Hızlı Ekleme vs.*/   }else { $firmaId=$request->input("firmaId"); }
      $newOperasyon["gumrukAdedi"]=$gumrukAdedi;
      $newOperasyon["deleted"]="no";


      $newOperasyona->where("id",'=',$request->input("talimatId"))->update($newOperasyon);

      $id=$request->input("talimatId");
      $firmaId=$request->input("firmaId");
      $yuklemeNoktasiAdet=$request->input("yuklemeNoktasiAdet");

      $varisGumrugu=$request->input("varisGumruk");
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
      $array="";

      $kontrolVaris=0;
      foreach ($yuklemeNoktasiAdet as $key => $value)
      {
        for($x=0;$x<$value[0];$x++)
        {

          if (empty($varisGumrugu[$key][$x])) {$kontrolVaris++;}
           $array[$key][$x]["talimatId"]=$id;
           $array[$key][$x]["gumrukId"]=intval($key);
           $array[$key][$x]["gumrukSira"]=($x+1);
           $array[$key][$x]["varisGumruk"]=$varisGumrugu[$key][$x];
           $array[$key][$x]["yuklemeNoktasi"]=$yuklemeNoktasi[$key][$x];
           $array[$key][$x]["yuklemeNoktasiulkekodu"]=$yuklemeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["indirmeNoktasi"]=$indirmeNoktasi[$key][$x];
           $array[$key][$x]["indirmeNoktasiulkekodu"]=$indirmeNoktasiulkekodu[$key][$x];
           $array[$key][$x]["talimatTipi"]=$request->input("talimatTipi");
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
            $talimatAltModel->where("talimatId",'=',$id)->delete();
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


      return redirect('/operasyon/goster/'.$id);
    }


    public function yazdir($_id)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');
      if ($lang == null)
      {
          $lang='tr';
      }
  //    $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

      $newOperasyon=new \App\TalimatModel();

      $operasyon=$newOperasyon->with(['User','Bolge','Ilgili','AltModel'])->where('deleted','=','no')->where('id','=',$_id);

      if ($userRole!="admin")
      {
      //  $operasyon=$operasyon->where("firmaId",'=',$userId);
      }


      $data= $operasyon->first();
      //return $data;
      $autoBarcode="";

      $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
      if (!empty($data->autoBarcode))
      {
        $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->autoBarcode, $generator::TYPE_CODE_128)) . '">';
      }
      $ulkeList = DB::table('ulkeKod')->get();
      $ulke=array();
      foreach ($ulkeList as $key => $value)
      {
        $ulke[$value->id]=$value->global_name;
      }


      //return $data;

      if ($data->talimatTipi=='bondeshortie')
      {
          return view("operasyon.operasyon_bondieprint",['talimat'=>$data,"barcode"=>$autoBarcode,'ulke'=>$ulke]);
      }else {
          return view("operasyon.operasyon_print",['talimat'=>$data,"barcode"=>$autoBarcode,'ulke'=>$ulke]);
      }




    }

    public function done($id)
    {
      $talimatModel=new \App\TalimatModel();
      $talimatModel->where("id","=",$id)->update(["durum"=>"tamamlandi"]);
      return redirect('/operation/done');
    }

    public function excelyap($id)
    {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();


      $sheet->setCellValue('A1',trans("messages.gumrukno"));
      $sheet->setCellValue('B1',trans("messages.gonderici"));
      $sheet->setCellValue('C1',trans("messages.ulkekodu"));
      $sheet->setCellValue('D1',trans("messages.alici"));
      $sheet->setCellValue('E1',trans("messages.ulkekodu"));
      $sheet->setCellValue('F1',trans("messages.kap"));
      $sheet->setCellValue('G1',trans("messages.kilo"));
      $sheet->setCellValue('H1',trans("messages.yukcinsi"));
      $sheet->setCellValue('I1',trans("messages.faturanumara"));
      $sheet->setCellValue('J1',trans("messages.faturabedeli"));
      $talimatModel=new \App\TalimatModel();
      $listex=DB::table("talimatparametre")->where("talimatId","=",$id)->get();
      $z=2;
      foreach ($listex as $key => $value)
      {
        $sheet->setCellValue('A'.$z,$value->gumrukSira);
        $sheet->setCellValue('B'.$z,$value->yuklemeNoktasi);
        $sheet->setCellValue('C'.$z,$value->yuklemeNoktasiulkekodu);
        $sheet->setCellValue('D'.$z,$value->indirmeNoktasi);
        $sheet->setCellValue('E'.$z,$value->yuklemeNoktasiulkekodu);
        $sheet->setCellValue('F'.$z,$value->tekKap);
        $sheet->setCellValue('G'.$z,$value->tekKilo);
        $sheet->setCellValue('H'.$z,$value->yukcinsi);
        $sheet->setCellValue('I'.$z,$value->faturanumara);
        $sheet->setCellValue('J'.$z,$value->faturabedeli);
        $z++;
      }


      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="file.xlsx"');
      $writer->save("php://output");

    }

    public function evrakscreen($id)
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;


      $newOperasyon=new \App\TalimatModel();
      //$get=$newOperasyon->find($id); BURADA KALDIm

      if ($userRole!='admin' && $userRole!='bolgeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }
      return view("layouts.upload",["id"=>$id]);
    }

  public function evrakupload(Request $request)
  {


    $id=$request->input("talimatId");

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
                "filetype"=>$files[$key]->extension(),
                "deleted"=>'no',
                'created_at'=> $now,
                'updated_at'=> $now
            );

            $counter++;

        }

        $fileforEvrakModel->insert($fileForEvr);
        $talimatMesaj=$talimatMesaj." (".$counter.")  ".trans('messages.dosya');
    }

      $mesaj=$talimatMesaj." ".trans("messages.evraksuccess");
      return view("layouts.success",['islemAciklama'=>$mesaj]);
  }


  public function fileupload(Request $request)
  {
    $id=$request->input("talimatId");

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
              $files=$request->file('specialfiles');
              $now = \Carbon\Carbon::now('utc')->toDateTimeString();
              $counter=0;
              $fileForEvr=array();
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

          return redirect('/operasyon/goster/'.$id);
  }

  public function evrakadetli($kac,$adet=1)
  {
      return view("talimat.dosya",["kac"=>$kac,"adet"=>$adet]);
  }

  public function operationfiledownload($id) {

    $operasyonModel=new \App\TalimatModel();
  $allList=$operasyonModel->with(['User','Evrak'])->where('deleted','=','no')->where('id','=',$id)->first();
//  return $allList;
  //$files = glob(storage_path("../public/uploads/files/*.txt"));
//return $files;
  // define the name of the archive and create a new ZipArchive instance.
  $archiveFile = storage_path($allList->autoBarcode."-".str_slug($allList->user->name).".zip");
  $archive = new ZipArchive();

  // check if the archive could be created.
  if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
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

  public function operationpartdownload()
  {
    $data=new \App\musteriEvrak();

    $allList= $data->whereIn("id",\Request::input("item"))->get();
     //return $allList;
    $archiveFile = storage_path(str_slug("file".\Carbon\Carbon::parse("now")).".zip");
    $archive = new ZipArchive();

    if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
        // loop through all the files and add them to the archive.
        foreach ($allList as $file) {
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

//    return \Request::all();
  }

  public function sendt2($_id)
  {
    \Helper::langSet();
    $userId=Auth::user()->id;
    $userRole=Auth::user()->role;
    $lang = Session::get ('locale');
    if ($lang == null)
    {
        $lang='tr';
    }
//    $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

    $newOperasyon=new \App\TalimatModel();
    $newOperasyon->where('id','=',$_id)->update(['yeniTalimatMi'=>'no']);
    $operasyon=$newOperasyon->with(['User','Bolge','Ilgili','AltModel'])->where('deleted','=','no')->where('id','=',$_id);



    $data=$operasyon->first();
//return $data;
    $altmodel=array();
    foreach ($data->altmodel as $key => $value)
    {
      $altmodel[$value->gumrukId][]=$value;
    }

    if ($userRole=="watcher" && $userId!=$data->firmaId)
    {
        $islemAciklama="Unauthorised Area!. Please Contact Your Admin";
        return view("layouts.error",["islemAciklama"=>$islemAciklama]);
    }

    $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

    $bolgeList = DB::table('bolge')->get();
    $ulkeModel= new \App\UlkeKodModel();
    $ulkeList=$ulkeModel->orderBy("siralama","ASC")->get();
    $ulke=array();

    foreach ($ulkeList as $key => $value)
    {
      $ulke[$value->id]=$value->global_name;
    }
    $allUser=new \App\User();
/*
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
*/
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
    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
    $autoBarcode=intval(substr(md5(rand(1264,987654321).microtime().rand(1264,987654321)), 0, 8), 16);
/*
    if (!empty($data->autoBarcode))
    {
      $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data->autoBarcode, $generator::TYPE_CODE_128)) . '">';
    }
*/
//return $altmodel;
//return $data;


    return view("operasyon.operasyon_ext1t2",['talimat'=>$data,"barcode"=>$autoBarcode,'userlist'=>$listUser,'talimatList'=>$talimatList,'ulkeList'=>$ulkeList,'ulke'=>$ulke,"bolge"=>$bolgeList,'yetkiler'=>$yetkiler,"altmodel"=>$altmodel]);

  }

}

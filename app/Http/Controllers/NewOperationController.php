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
use ZipArchive;
class NewOperationController extends Controller
{


    public function index()
    {

      $yuklemeModel=new \App\YuklemeModel();


      $lang = Session::get ('locale');
      if ($lang == null)      {  $lang='tr';  }
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

        $hiperduperyorgunluksonrasi=new \App\NewOperationModel();
        if ($userRole=='admin')
        {
        $data=$hiperduperyorgunluksonrasi->with(['params','User'])->get();
          }else {
            $data=$hiperduperyorgunluksonrasi->with(['params','User'])->where("firmaId","=",$userId)->get();
          }

        //$talimatList=array();
        //$talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();
        return view('operasyon_new.operasyon_index',['data'=>$data]);


    }

    public function add()
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
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->get();

      if ($userRole=="admin")
      {
           $allUser=new \App\User();
           $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','!=','admin')->get();
           $listUser=json_decode($listUser,true);
           return view('operasyon_new.operasyon_new',['userlist'=>$listUser,'talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList]);
      }else
      {

        return view('operasyon_new.operasyon_new',['talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList]);
      }


    }


    function save(Request $request)
    {

      \Helper::langSet();
      $operationModel=new \App\NewOperationModel();
      $operationModel->gumrukAdedi=1;
      if(!empty($request->input('autoBarcode'))) { $barcode=$request->input('autoBarcode'); } else { $barcode="BO".intval(substr(md5(rand(1264,987654321).microtime().rand(1264,987654321)), 0, 8), 16); }

      $operationModel->autoBarcode=$barcode;
      $operationModel->firmaId=$request->input('firmaId');

      $operationModel->cekiciPlaka=$request->input('cekiciPlaka');
      $operationModel->dorsePlaka=$request->input('dorsePlaka');
      $operationModel->mrnmumber=$request->input('mrnmumber');

      $kaps=$request->input("tekKap");
      $totalkap=0;
        foreach ($kaps as $kapkey => $kapvalue)
         {
           foreach ($kapvalue as $altkapkey => $altkapvalue)
           {
             $totalkap+=intval($altkapvalue);
           }

        }


        $kilos=$request->input("tekKilo");
        $totalkilo=0;
          foreach ($kilos as $kilokey => $kilovalue)
           {
             foreach ($kilovalue as $kilokapkey => $kilokapvalue)
             {
               $totalkilo+=intval($kilokapvalue);
             }
            // code...
          }

          $operationModel->totalkap=$totalkap;
          $operationModel->totalkilo=$totalkilo;
          $operationModel->yeniTalimatMi='yes';
          $operationModel->deleted='no';
          $operationModel->durum=0;
          $operationModel->save();

          $operasyonid=$operationModel->id;
          $m=0;

          $yuklemeNoktasi=$request->input("yuklemeNoktasi");
          $yuklemeNoktasiulkekodu=$request->input("yuklemeNoktasiulkekodu");
          $indirmeNoktasi=$request->input("indirmeNoktasi");
          $indirmeNoktasiulkekodu=$request->input("indirmeNoktasiulkekodu");
          $talimatTipi=$request->input("talimatTipi");
          $tekKap=$request->input("tekKap");
          $tekKilo=$request->input("tekKilo");
          $yukcinsi=$request->input("yukcinsi");
          $faturanumara=$request->input("faturanumara");
          $faturabedeli=$request->input("faturabedeli");
          $adr=$request->input("adr");
          $atr=$request->input("atr");

          $hiperaltuzay=new \App\NewOperationParam();

          foreach ($yuklemeNoktasi[0] as $altaltkey => $altaltvalue)
          {
               $hiperuzayarray[$m]=
               [
                 "operationId"=>$operasyonid,
                 "yuklemeNoktasi"=>$yuklemeNoktasi[0][$altaltkey],
                 "yuklemeNoktasiulkekodu"=>$yuklemeNoktasiulkekodu[0][$altaltkey],
                 "indirmeNoktasi"=>$indirmeNoktasi[0][$altaltkey],
                 "indirmeNoktasiulkekodu"=>$indirmeNoktasiulkekodu[0][$altaltkey],
                 "talimatTipi"=>$talimatTipi[0][$altaltkey],
                 "tekKap"=>$tekKap[0][$altaltkey],
                 "tekKilo"=>$tekKilo[0][$altaltkey],
                 "yukcinsi"=>$yukcinsi[0][$altaltkey],
                 "faturanumara"=>$faturanumara[0][$altaltkey],
                 "faturabedeli"=>$faturabedeli[0][$altaltkey],
                 "adr"=>$adr[0][$altaltkey],
                 "atr"=>$atr[0][$altaltkey],
                 "adtrmessage"=>"",
                 "firmaId"=>$request->input('firmaId'),
                 "deleted"=>"no"
               ];
               $m++;
          }


          $hiperaltuzay->insert($hiperuzayarray);

          $mesaj=trans("messages.operasyonsuccess");
          return view("layouts.success",['islemAciklama'=>$mesaj]);
    }


    
}

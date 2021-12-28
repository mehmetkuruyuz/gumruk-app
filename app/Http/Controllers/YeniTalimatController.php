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

class YeniTalimatController extends Controller
{


    public function index()
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
//      $talimatModel=new \App\TalimatModel();

      $plaka='';
      $tarih="";
      $tarih2="";
      $barcodeX="";
      $mrnCode="";


/*      if (!empty($request->input("barcode")))       { $barcodeX= $request->input("barcode"); }

      if (!empty($request->input("plaka")))    {     $plaka= $request->input("plaka");    }

      if (!empty($request->input("tarih")) && !empty($request->input("tarih2")))      {  $tarih= $request->input("tarih");   $tarih2= $request->input("tarih2"); }
*/
      $yuklemeModel=new \App\YuklemeModel();


      $lang = Session::get ('locale');
      if ($lang == null)      {  $lang='tr';  }


        $hiperduperyorgunluksonrasi=new \App\YeniTalimatAltSubModel();
        $data=$hiperduperyorgunluksonrasi->with(['upone.upone.User'])->get();

        $talimatList=array();
        $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();

        $dataM=array();
        foreach ($data as $key => $value)
        {
            $dataM[$value->talimatTipi][]=$value;
        }

        return view('talimatyeni.talimat_index',['dataM'=>$dataM,'talimatList'=>$talimatList]);
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
      //return $talimatList;
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->get();



      if ($userRole=="admin")
      {
           $allUser=new \App\User();
           $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','!=','admin')->get();
           $listUser=json_decode($listUser,true);
           return view('talimatyeni.talimat_new',['userlist'=>$listUser,'talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList]);
      }else
      {
          return view('talimatyeni.talimat_new',['talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList]);
      }


    }

    function save(Request $request)
    {

      \Helper::langSet();
      $talimatModel=new \App\NewTalimatModel();
      $talimatModel->gumrukAdedi=$request->input('gumrukAdedi');
      $talimatModel->firmaId=$request->input('firmaId');

      $talimatModel->cekiciPlaka=$request->input('cekiciPlaka');
      $talimatModel->dorsePlaka=$request->input('dorsePlaka');


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


      $talimatModel->totalkap=$totalkap;
      $talimatModel->totalkilo=$totalkilo;
      $talimatModel->yeniTalimatMi='yes';
      $talimatModel->deleted='no';
      $talimatModel->durum=0;


      if(!empty($request->input('autoBarcode'))) { $barcode=$request->input('autoBarcode'); } else { $barcode="BO".intval(substr(md5(rand(1264,987654321).microtime().rand(1264,987654321)), 0, 8), 16); }

      $talimatModel->autoBarcode=$barcode;
      //return $request;

      $talimatModel->save();


      $hangitalimat=$talimatModel->id;
      $talimatAltModel=new \App\YeniTalimatAltModel();
      $varisGumrugu=$request->input("varisGumrugu");

      $yuklemeNoktasiAdet=$request->input("yuklemeNoktasiAdet");

      $kap=$request->input("kap");
      $kilo=$request->input("kilo");
      $problem=$request->input("problem");
      $problemAciklama=$request->input("problemAciklama");
      $aciklama=$request->input("aciklama");





      $k=0;


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
      $mrnmumber=$request->input('mrnmumber');

      $totalPrice=0;

      $hiperaltuzay=new \App\YeniTalimatAltSubModel();

      foreach ($varisGumrugu as $gumrukkey => $gumrukvalue)
      {
        $k++;
          $arrayalt[$k]=
          [
            "talimatId"=>$hangitalimat,
            "varisGumrugu"=>$gumrukvalue,
            "yuklemeNoktasiAdet" =>$yuklemeNoktasiAdet[$gumrukkey],
            "kap"=>$kap[$gumrukkey],
            "kilo"=>$kilo[$gumrukkey],
            "problem"=>$problem[$gumrukkey],
            "problemAciklama"=>$problemAciklama[$gumrukkey],
            "aciklama"=>$aciklama[$gumrukkey],
            "deleted"=>"no"
         ];


         $talimatAltModel->insert($arrayalt[$k]);
         $arrayalt[$k]['id']=DB::getPdo()->lastInsertId();//$talimatAltModel->id;
         $hiperuzayarray="";
         $m=0;

         foreach ($yuklemeNoktasi[$gumrukkey] as $altaltkey => $altaltvalue)
         {

           $totalPrice+=intval($faturabedeli[$gumrukkey][$altaltkey]);

              $hiperuzayarray[$m]=
              [
                "talimatAltId"=>$arrayalt[$k]['id'],
                "yuklemeNoktasi"=>$yuklemeNoktasi[$gumrukkey][$altaltkey],
                "yuklemeNoktasiulkekodu"=>$yuklemeNoktasiulkekodu[$gumrukkey][$altaltkey],
                "indirmeNoktasi"=>$indirmeNoktasi[$gumrukkey][$altaltkey],
                "indirmeNoktasiulkekodu"=>$indirmeNoktasiulkekodu[$gumrukkey][$altaltkey],
                "talimatTipi"=>$talimatTipi[$gumrukkey][$altaltkey],
                "tekKap"=>$tekKap[$gumrukkey][$altaltkey],
                "tekKilo"=>$tekKilo[$gumrukkey][$altaltkey],
                "yukcinsi"=>$yukcinsi[$gumrukkey][$altaltkey],
                "faturanumara"=>$faturanumara[$gumrukkey][$altaltkey],
                "faturabedeli"=>$faturabedeli[$gumrukkey][$altaltkey],
                "adr"=>$adr[$gumrukkey][$altaltkey],
                "atr"=>$atr[$gumrukkey][$altaltkey],
                "mrnnumber"=>$mrnmumber[$gumrukkey][$altaltkey],
                "adtrmessage"=>"",
                "firmaId"=>$request->input('firmaId'),
                "deleted"=>"no"
              ];

              $m++;
         }

         $hiperaltuzay->insert($hiperuzayarray);


      }


      $muhasebeModel=new \App\MuhasebeModel();

      $muhasebeModel->firmaId=$request->input("firmaId");
      $muhasebeModel->faturaTarihi=\Carbon\Carbon::parse("now")->format("Y-m-d h:i:s");
      $muhasebeModel->senaryo=" ";
      $muhasebeModel->tipi=" ";
      $muhasebeModel->faturaReferans="Talimattan Gelen Otomatik";
      $muhasebeModel->faturaNo=" ";
      $muhasebeModel->price=$totalPrice;
      $muhasebeModel->autoBarcode=$barcode;
      $muhasebeModel->moneytype="TL";
      $muhasebeModel->deleted='no';
      $muhasebeModel->save();

      $mesaj=trans("messages.talimatoldu");
      return view("layouts.success",['islemAciklama'=>$mesaj]);

    }


    function gumruksayigetir($_say=0)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $lang = Session::get ('locale');

      if ($lang == null)
      {
          $lang='tr';
      }
      $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();
      $ulkeModel= new \App\UlkeKodModel();
      $ulkeList=$ulkeModel->get();

      $array;

      for($t=1;$t<=$_say;$t++)
      {
          $view="";
          $view=\View::make('talimatyeni.gumrukalt',['talimatList'=>$talimatList,'ulkeList'=>$ulkeList,'kacinci'=>$t,'say'=>($t-1)]);
          $array[$t]= $view->render();
      }

      return $array;
    }

    public function show($_id)
    {
      \Helper::langSet();
      $arrayList=array(
          'cmr'=>trans('messages.cmrevrak'),
          'fatura'=>trans('messages.faturaevrak'),
          'atr'=>trans('messages.atrevrak'),
          'talimat'=>trans('messages.transitevrak'),
          'ex1'=>trans('messages.ex1'),
          't2'=>trans('messages.t2talimati'),
          't1'=>trans('messages.t1talimati'),
          'tir'=>trans('messages.tirkarnesi'),
          'ata'=>trans('messages.atakarnesi'),
          't1kapama'=>trans('messages.t1kapama'),
          'listex'=>trans('messages.listeex'),

      );
      $talimatList="";

      $talimatModel=new \App\NewTalimatModel();
      $talimat=$talimatModel->with(["allparametres.param"])->find($_id);

      $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
      $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($talimat->autoBarcode, $generator::TYPE_CODE_128)) . '">';

      return view("talimatyeni/talimat_view",['talimat'=>$talimat,'talimatTipList'=>$talimatList,'isimArray'=>$arrayList,"barcode"=>$autoBarcode]);
      return $talimat;
    }


        public function print($_id)
        {
          \Helper::langSet();
          $arrayList=array(
              'cmr'=>trans('messages.cmrevrak'),
              'fatura'=>trans('messages.faturaevrak'),
              'atr'=>trans('messages.atrevrak'),
              'talimat'=>trans('messages.transitevrak'),
              'ex1'=>trans('messages.ex1'),
              't2'=>trans('messages.t2talimati'),
              't1'=>trans('messages.t1talimati'),
              'tir'=>trans('messages.tirkarnesi'),
              'ata'=>trans('messages.atakarnesi'),
              't1kapama'=>trans('messages.t1kapama'),
              'listex'=>trans('messages.listeex'),

          );
          $talimatList="";

          $talimatModel=new \App\NewTalimatModel();
          $talimat=$talimatModel->with(["allparametres.param"])->find($_id);

          $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
          $autoBarcode='<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($talimat->autoBarcode, $generator::TYPE_CODE_128)) . '">';

          return view("talimatyeni/talimat_print",['talimat'=>$talimat,'talimatTipList'=>$talimatList,'isimArray'=>$arrayList,"barcode"=>$autoBarcode]);
        }

        public function talimatgetir($firmaId)
        {

          $talimatModel=new \App\NewTalimatModel();
          $talimat=$talimatModel->where("firmaId","=",$firmaId)->get();
          return $talimat;

        }

        public function talimataltipgetir($talimatId)
        {

          $talimatModel=new \App\NewTalimatModel();
          $talimat=$talimatModel->with(["allparametres.param"])->find($talimatId);
          $arrayreturn=array();

          $t=0;

            $ozelModel=new \App\MuhasebeOzelFiyatModel();

          foreach ($talimat->allparametres	 as $talimatkey => $talimatvalue)
          {
              foreach ($talimatvalue->param as $paramkey => $paramvalue)
              {
                  $arrayreturn[$t]['talimatTipi']=$paramvalue->talimatTipi;
                  $arrayreturn[$t]['varisGumrugu']=$talimatvalue->varisGumrugu;
                  $arrayreturn[$t]['tekKap']=$paramvalue->tekKap;
                  $arrayreturn[$t]['tekKilo']=$paramvalue->tekKilo;
                  $vardata=$ozelModel->where("firmaId","=",$talimat->firmaId)->where('talimattipi','=',$paramvalue->talimatTipi)->first();
                  if (!empty($vardata->faturatutari))
                  {
                  $arrayreturn[$t]['price']=$vardata->faturatutari;
                }else {$arrayreturn[$t]['price']=0;}

              }
          }
          return $arrayreturn;
        }


        public function talimatfiyatgetir(Request $request)
        {


          $ozelModel=new \App\MuhasebeOzelFiyatModel();
          $vardata=$ozelModel->where("firmaId","=",$request->input("firmaId"))->where('talimattipi','=',$request->input("talimatTipi"))->first();
          return $vardata;

        }


        public function operationtotalimat($_id)
        {
            $hiperduperyorgunluksonrasi=new \App\NewOperationModel();
            $data=$hiperduperyorgunluksonrasi->with(['params','User'])->where("id","=",$_id)->first();
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
            //return $data;
            return view('operasyon_new.operasyontotalimat_new',['talimatList'=>$talimatList,"barcode"=>$barcode,'ulkeList'=>$ulkeList,'data'=>$data]);
            //
          //
        }

}

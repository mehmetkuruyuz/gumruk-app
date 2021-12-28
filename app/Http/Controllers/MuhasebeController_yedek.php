<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\InfoMailEvery;
use Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MuhasebeController extends Controller
{
    //
    public function __construct()
    {
        //$userRole=\Auth::user()->role;

    }

    public function add()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $muhasebeModel=new \App\MuhasebeModel();
        $allUser=new \App\User();
        $listUser=$allUser->select('id','name')->where('role','!=','admin')->get();
        $listUser=json_decode($listUser,true);

        return view('muhasebe.muhasebe_add',['userlist'=>$listUser]);
    }


    public function faturakapat($id)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }

      $muhasebeModel=new \App\MuhasebeModel();
      $data=$muhasebeModel->with(["User","Yapan","Odeme"])->where("id","=",$id)->first();
      //return $data;
      return view('muhasebe.muhasebe_goster',['data'=>$data]);

    }

    public function faturaode($id)
    {

      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }
      $muhasebeModel=new \App\MuhasebeModel();
      $data=$muhasebeModel->where("id","=",$id)->update(["faturadurumu"=>"kapali",'kapayanId'=>$userId]);
      return redirect('/muhasebe/fatura/'.$id);
    }


    public function save(Request $request)
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

          if ($userRole!='admin' && $userRole!='muhasebeadmin' )
          {
            return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
          }

        \Helper::langSet();
     //   return $request;
        $muhasebeModel=new \App\MuhasebeModel();


        $muhasebeModel->firmaId=$request->input("firmaId");
        $muhasebeModel->faturaTarihi=$request->input("faturaTarihi");
        $muhasebeModel->senaryo=$request->input("senaryo");
        $muhasebeModel->tipi=$request->input("tipi");
        $muhasebeModel->faturaReferans=$request->input("faturaReferans");
        $muhasebeModel->faturaNo=$request->input("faturaNo");
        $muhasebeModel->price=$request->input("price");
        $muhasebeModel->moneytype=$request->input("moneytype");
        $muhasebeModel->deleted='no';
        $muhasebeModel->save();
        $mesaj=trans('messages.muhasebekaydieklenmistir');//"Muhasebe Kaydı Eklenmiştir.";

        $userEmail=Auth::user()->email;
        $userFirmName=Auth::user()->name;

        $userLK=new \App\User();
        $userkim=$userLK->find($request->input("firmaId"));
        $userFirmName=$userkim->name;
        $userEmail=$userkim->email;


       \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.newinvoiceheader'), trans('messages.muhasebekaydieklenmistir'))) ;

        return view("layouts.success",['islemAciklama'=>$mesaj]);

    }

    public function index(Request $req)
    {

        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $muhasebeModel=new \App\MuhasebeModel();

        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;




        if ($userRole=="admin")
        {
           $muhasebe=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no');
        }elseif($userRole=="bolgeadmin" )
        {
          $muhasebe=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->where('odemecinsi','=',"cari")->where('yapanId','=',$userId);
        }
        elseif($userRole=="muhasebeadmin")
        {
          $muhasebe=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->where('bolgeId','=',Auth::user()->bolgeId);
        }
        else
        {
          $muhasebe=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->where('firmaId','=',$userId);
        }


        if (!empty($req))
        {

            if (!empty($req->input("datefilter")))
            {
              $tarih=explode("/",$req->input("datefilter"));

              $muhasebe=$muhasebe->whereBetween("created_at",[trim($tarih[0]),trim($tarih[1])]);
            }
        }
            $muhasebeList=$muhasebe->get();

        $filtered_muhasebe = $muhasebeList->filter(function($item) {
                return $item->talimat->durum !='bekleme';
            });

          //  return $filtered_muhasebe;
        return view('muhasebe.muhasebe_index',['muhasebeList'=>$filtered_muhasebe]);

    }

    public function kapalifatura(Request $req)
    {



    \Helper::langSet();
    $userId=Auth::user()->id;
    $userRole=Auth::user()->role;
    $muhasebeModel=new \App\MuhasebeModel();

    $userId=Auth::user()->id;
    $userRole=Auth::user()->role;




    if ($userRole=="admin")
    {
       $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no');
    }elseif($userRole=="bolgeadmin" )
    {
      $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no')->where('odemecinsi','=',"cari")->where('yapanId','=',$userId);
    }
    elseif($userRole=="muhasebeadmin")
    {
      $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no')->where('bolgeId','=',Auth::user()->bolgeId);
    }
    else
    {
      $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no')->where('firmaId','=',$userId);
    }


            if (!empty($req))
            {

                if (!empty($req->input("datefilter")))
                {
                  $tarih=explode("/",$req->input("datefilter"));

                  $muhasebe=$muhasebe->whereBetween("created_at",[trim($tarih[0]),trim($tarih[1])]);
                }
            }

      $muhasebeList=$muhasebe->where("faturadurumu","=","kapali")->get();
    //return $muhasebeList;
    return view('muhasebe.muhasebe_index',['muhasebeList'=>$muhasebeList]);
  }

public function acikfatura(Request $req)
{



\Helper::langSet();
$userId=Auth::user()->id;
$userRole=Auth::user()->role;
$muhasebeModel=new \App\MuhasebeModel();


if ($userRole!='admin' && $userRole!='muhasebeadmin' )
{
  return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
}



if ($userRole=="admin")
{
   $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no');
}elseif($userRole=="bolgeadmin" )
{
  $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no')->where('odemecinsi','=',"cari")->where('yapanId','=',$userId);
}
elseif($userRole=="muhasebeadmin")
{
  $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no')->where('bolgeId','=',Auth::user()->bolgeId);
}
else
{
  $muhasebe=$muhasebeModel->with(['User'])->where("deleted",'=','no')->where('firmaId','=',$userId);
}


        if (!empty($req))
        {

            if (!empty($req->input("datefilter")))
            {
              $tarih=explode("/",$req->input("datefilter"));

              $muhasebe=$muhasebe->whereBetween("created_at",[trim($tarih[0]),trim($tarih[1])]);
            }
        }
  $muhasebeList=$muhasebe->where("faturadurumu","=","acik")->get();
//return $muhasebeList;
return view('muhasebe.muhasebe_index',['muhasebeList'=>$muhasebeList]);
}

    public function delete($id)
    {




        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $talimatModel=new \App\MuhasebeModel();
        if ($userRole!='admin' && $userRole!='muhasebeadmin' )
        {
          return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
        }
        if ($userRole=='watcher')
        {
            return "Hatalı bir alana giriş yaptınız.";
        }

        $talimatModel->where('id','=',$id)->update(['deleted'=>'yes']);
        $talimatMesaj=trans('messages.muhasebekaydisilinmistir');
        //$talimatMesaj="Muhasebe Kaydı Silinmiştir.";
        return view("layouts.success",['islemAciklama'=>$talimatMesaj]);
    }
    public function edit($id)
    {

        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        if ($userRole!='admin' && $userRole!='muhasebeadmin' )
        {
          return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
        }

        $listUser=array();

        $allUser=new \App\User();
        $listUser=$allUser->select('id','name')->where('role','!=','admin')->get();
        $listUser=json_decode($listUser,true);

        $muhasebeModel=new \App\MuhasebeModel();
        $muhasebeList=$muhasebeModel->with(['User'])->where("deleted",'=','no')->find($id);
        //return $muhasebeList;

       return view("muhasebe/muhasebe_edit",['muhasebeOne'=>$muhasebeList,'userlist'=>$listUser]);
    }

    public function update(Request $request)
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }

        \Helper::langSet();
        //return $request;
        $muhasebeModel=new \App\MuhasebeModel();
        $muhasebeModelArray=array(
            "firmaId"=>$request->input('firmaId'),
            "faturaTarihi"=>$request->input('faturaTarihi'),
            "senaryo"=>$request->input('senaryo'),
            "tipi"=>$request->input('tipi'),
            "faturaReferans"=>$request->input('faturaReferans'),
            "price"=>$request->input('price'),
            "faturaNo"=>$request->input('faturaNo'),
            "moneytype"=>$request->input('moneytype')

        );


        $muhasebeModel->where('id','=',$request->input("id"))->update($muhasebeModelArray);
        $talimatMesaj==trans('messages.muhasebekaydiguncellesmis');//"Muhasebe Kaydı Güncellenmiştir.";

        $userLK=new \App\User();
        $userkim=$userLK->find($request->input('firmaId'));
        $userFirmName=$userkim->name;
        $userEmail=$userkim->email;

        \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.editinvoiceheader'), trans('messages.muhasebekaydiguncellesmis'))) ;
        return view("layouts.success",['islemAciklama'=>$talimatMesaj]);
    }


    public function special()
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }

        \Helper::langSet();

        $lang = Session::get ('locale');
        if ($lang == null)
        {
            $lang='tr';
        }

        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();
        $allUser=new \App\User();
        $listUser=$allUser->select('id','name')->where('role','=','watcher')->get();

        $listUser=json_decode($listUser,true);
        //$talimatList=json_decode($talimatList,true);
        return view('muhasebe.ozelfiyatlama',['userlist'=>$listUser,'talimatList'=>$talimatList]);

    }


    public function specialsave(Request $request)
    {
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }

      $ozelModel=new \App\MuhasebeOzelFiyatModel();
      $firmaId=$request->input("firmaId");
      $senaryo=$request->input("senaryo");

      $faturatutari=$request->input("price");
      $parabirimi=$request->input("moneytype");
      $array="";
      $k=0;
        $ozelModel->where("firmaId",'=',$firmaId)->delete();
      foreach ($faturatutari as $key => $value)
      {
        $k++;
          $arrayalt[$k]=
          [
            "firmaId"=>$firmaId,
            "senaryo"=>$senaryo,
            "talimattipi"=>$key,
            "faturatutari"=>$value,
            "parabirimi"=>$parabirimi[$key],
         ];
      }
    //  return $request;
      $ozelModel->insert($arrayalt);

      return redirect('/muhasebe/ozelfiyatlamagoster/'.$request->input("firmaId"));

    }

    public function ozelfiyatgoster($_firmaid=0)
    {

      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
        $ozelModel=new \App\MuhasebeOzelFiyatModel();

        $firma=new \App\User();
        $array=array();
        if ($userRole=="admin" || $userRole=="muhasebeadmin")
        {
          $all=$ozelModel->with(['User'])->get();
        ;
        $t=0;
          foreach ($all as $key => $value)
          {
              if (!empty($value->firmaId))
              {

                $array[$value->user->name]["talimattipi"][$t]=$value->talimattipi;
                $array[$value->user->name]["faturatutari"][$t]=$value->faturatutari;
                $array[$value->user->name]["parabirimi"][$t]=$value->parabirimi;
                $t++;
              }
          }
        }else
        {
          $all=$ozelModel->with(['User'])->where('firmaId','=',$_firmaid)->get();

        }
        //return $array;
        //$listUser=$firma->select('id','name')->first();
        return view('muhasebe.ozelfiyatlama_goster',["list"=>$all,"array"=>$array]);


    }

    public function ozelfiyatgetir($tip,$firmaId)
    {
        $fiyat=DB::table("muhasebeozelfiyat")->where("firmaId","=",$firmaId)->where("talimattipi","=",$tip)->get();
        $array=array();
        if (count($fiyat)>0)
        {
          $array["talimattipi"]=trans("messages.".$fiyat[0]->talimattipi);
          $array["fiyat"]=$fiyat[0]->faturatutari;
          $array["fiyatbirim"]=$fiyat[0]->parabirimi;

        }else {
          $array["talimattipi"]=trans("messages.girilmemis");
          $array["fiyat"]=0;
          $array["fiyatbirim"]="";
        }
          return $array;
    }

    public function raporlama(Request $request)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      $mesajModel=new \App\MesajModel();
      $talimatModel=new \App\TalimatModel();
      $muhasebeModel=new \App\MuhasebeModel();

      $first = \Carbon\Carbon::now()->format("Y-m-d 00:00:00");
      $last = \Carbon\Carbon::now()->format("Y-m-d 23:59:59");
      //->whereBetween("created_at",[$first,$last])
      $allList=$talimatModel->with(['Bolge','Ilgili','Ilgilikayit'])->where('deleted','=','no')->where('durum','=','tamamlandi')->get();
      $muhasebeList=$muhasebeModel->with(['Bolge','Yapan','Kapayan'])->where("deleted",'=','no')->get();
    //  return $allList;


$array=array();
      foreach ($allList as $key => $value)
      {

        if (!empty($value->bolge->name))
        {
          if (empty($array[$value->bolge->name]["talimatdurumu"]['bekleme'])) { $array[$value->bolge->name]["talimatdurumu"]['bekleme']=0; }
          if (empty($array[$value->bolge->name]["talimatdurumu"]['firmabekleme'])) { $array[$value->bolge->name]["talimatdurumu"]['firmabekleme']=0; }
          if (empty($array[$value->bolge->name]["talimatdurumu"]['tamamlandi'])) { $array[$value->bolge->name]["talimatdurumu"]['tamamlandi']=0; }

          switch ($value->durum)
          {
            case 'bekleme':
                $array[$value->bolge->name]["talimatdurumu"]['bekleme']+=1;
            break;
            case 'firmabekleme':
                $array[$value->bolge->name]["talimatdurumu"]['firmabekleme']+=1;
            break;
            case 'tamamlandi':
                $array[$value->bolge->name]["talimatdurumu"]['tamamlandi']+=1;
            break;
          }
        }
      }
      $key="";
      $value="";
      foreach ($muhasebeList as $key => $value)
      {

        if (!empty($value->bolge->name))
        {
          if (empty($array[$value->bolge->name]["muhasebe"]['cari'])) { $array[$value->bolge->name]["muhasebe"]['cari']=0; }
          if (empty($array[$value->bolge->name]["muhasebe"]['nakit'])) { $array[$value->bolge->name]["muhasebe"]['nakit']=0; }
          if (empty($array[$value->bolge->name]["muhasebe"]['acik'])) { $array[$value->bolge->name]["muhasebe"]['acik']=0; }
          if (empty($array[$value->bolge->name]["muhasebe"]['kapali'])) { $array[$value->bolge->name]["muhasebe"]['kapali']=0; }

          switch ($value->odemecinsi)
          {
            case 'cari':
                $array[$value->bolge->name]["muhasebe"]['cari']+=1;
            break;
            case 'nakit':
                $array[$value->bolge->name]["muhasebe"]['nakit']+=1;
            break;
          }

          switch ($value->faturadurumu)
          {
            case 'acik':
                $array[$value->bolge->name]["muhasebe"]['acik']+=1;
            break;
            case 'kapali':
                $array[$value->bolge->name]["muhasebe"]['kapali']+=1;
            break;
          }
        }



      }

    //  return $array;
      //return $muhasebeList;


      return view("muhasebe.raporlama",["data"=>$array]);
    }

    public function makbuzyazdir($id)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

      if ($userRole!='admin' && $userRole!='nakitadmin')
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }

      $muhasebeModel=new \App\MuhasebeModel();
      $data=$muhasebeModel->with(["User","Yapan","Kapayan","Odeme"])->where("id","=",$id)->first();
      $newMakbuzNakitOdeme=new \App\NakitOdemeModel();
      $x=$newMakbuzNakitOdeme->where("faturaId",'=',$id)->first();
      if (count(($x))>0)
      {
        if ($x->durumu=='odenmedi')
          {
            $newMakbuzNakitOdeme->where("faturaId",'=',$id)->update(['durumu'=>'odendi','odemealanname'=>\Auth::user()->name]);
          }
      }

      //return $data;
      return view('muhasebe.makbuz',['data'=>$data]);
    }

    public function print($id)
    {
      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;

      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }

      $muhasebeModel=new \App\MuhasebeModel();
      $data=$muhasebeModel->with(["User","Yapan"])->where("id","=",$id)->first();
      //return $data;
      return view('muhasebe.muhasebe_print',['data'=>$data]);
    }

    public function makbuzfinder(Request $req)
    {
        \Helper::langSet();
        $muhasebeModel=new \App\MuhasebeModel();
        $r=$req->input("c");

        $data=$muhasebeModel->with(["User"])->where("odemecinsi",'=',"nakit")->where("autoBarcode","=",trim($r))->first();
        if (count($data)<1) {  return view("layouts.error",['islemAciklama'=>trans('messages.nakit')." ".trans('messages.yok')]);}
        return view('muhasebe.makbuz_finder',['data'=>$data]);
    }

    public function excelrapor($tarih='')
    {
        \Helper::langSet();
      $muhasebeModel=new \App\MuhasebeModel();
      if (empty($tarih))
      {
        $first = \Carbon\Carbon::now()->format("Y-m-d 00:00:00");
        $last = \Carbon\Carbon::now()->format("Y-m-d 23:59:59");
      }else {
        $first=$tarih." 00:00:00";
        $last=$tarih." 00:00:00";
      }
      $data=$muhasebeModel->with(["User","Odeme"])->where("odemecinsi","=","nakit")->get();
    //  return $data;

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();


      $sheet->setCellValue('A1',trans("messages.companyname"));
      $sheet->setCellValue('B1',trans("messages.autoBarcode"));
      $sheet->setCellValue('C1',trans("messages.invoicedate"));
      $sheet->setCellValue('D1',trans("messages.invoicerefence"));
      $sheet->setCellValue('E1',trans("messages.invoiceprice"));
      $sheet->setCellValue('F1',trans("messages.parabirimi"));
      $sheet->setCellValue('G1',trans("messages.odemecinsi"));
      $sheet->setCellValue('H1',trans("messages.muhasebeodemecheck"));
      $sheet->setCellValue('I1',trans("messages.odemecinsi"));

      $z=2;
      foreach ($data as $key => $value)
      {
        $sheet->setCellValue('A'.$z,$value->user->name);
        $sheet->setCellValue('B'.$z,$value->autoBarcode);
        $sheet->setCellValue('C'.$z,$value->faturaTarihi);
        $sheet->setCellValue('D'.$z,$value->faturaReferans);
        $sheet->setCellValue('E'.$z,$value->price);
        $sheet->setCellValue('F'.$z,$value->moneytype);
        $sheet->setCellValue('G'.$z,$value->odemecinsi);
        if (!empty($data->odeme))
        {
          $sheet->setCellValue('H'.$z,trans("messages.".$data->odeme->durumu));
          $sheet->setCellValue('J'.$z,$value->odeme->odemealanname);
        }else {
          $sheet->setCellValue('H'.$z,"");
          $sheet->setCellValue('I'.$z,"");
        }

        $z++;
      }


      $writer = new Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="file-'.$first.'-excel.xlsx"');
      $writer->save("php://output");

    }
}

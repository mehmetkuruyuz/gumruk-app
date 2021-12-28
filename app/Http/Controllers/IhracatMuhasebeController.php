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

class IhracatMuhasebeController extends Controller
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
        $muhasebeModel=new \App\IhracatMuhasebeModel();
        $allUser=new \App\User();
        $listUser=$allUser->select('id','name')->where('role','!=','admin')->get();
        $listUser=json_decode($listUser,true);

        return view('muhasebe.muhasebe_add',['userlist'=>$listUser]);
    }

    public function gunsonuraporu(Request $req)
    {

      $newGunSonuRaporu=new \App\GunSonuModel();

      if($req->isMethod('post'))
      {
        $tarih=trim($req->input("datefilter"));//explode("/",$req->input("datefilter"));
        $newMakbuzNakitOdeme=new \App\IhracatNakitOdemeModel();
        $newMakbuzNakitOdeme=$newMakbuzNakitOdeme->where("created_at",">",trim($tarih)." 00:00:00");
        $newMakbuzNakitOdeme=$newMakbuzNakitOdeme->where("created_at","<",trim($tarih)." 23:59:59");
//whereBetween
        $check=$newGunSonuRaporu->where("tarihbaslangic",">=",trim($tarih)." 00:00:00")->where("tarihbitis","<=",trim($tarih)." 23:59:59")->count();
        if ($check>0) {return view("layouts.success",['islemAciklama'=>trans("messages.gunsonuerror")]);}

        $makbuzlarList=$newMakbuzNakitOdeme->get();
        $toplam["TL"]=0;
        $toplam["DOLAR"]=0;
        $toplam["EURO"]=0;
        $toplam["POUND"]=0;
        $kayitarray=array();

        foreach ($makbuzlarList as $key => $value)
        {
          if (empty($toplam[$value->parabirimi])) {$toplam[$value->parabirimi]=0;}
          $toplam[$value->parabirimi]+=$value->odemeFiyat;
        }


        $newGunSonuRaporu->tarihbaslangic=trim($tarih)." 00:00:00";
        $newGunSonuRaporu->tarihbitis=trim($tarih)." 23:59:59";
        $newGunSonuRaporu->totaltl=$toplam["TL"];
        $newGunSonuRaporu->totaleuro=$toplam["EURO"];
        $newGunSonuRaporu->totaldolar=$toplam["DOLAR"];
        $newGunSonuRaporu->totalpound=$toplam["POUND"];
        $newGunSonuRaporu->yapanId=\Auth::user()->id;
        $newGunSonuRaporu->save();
        $raporid=$newGunSonuRaporu->id;
        $newAltModel=new \App\IhracatGunSonuAltModel();
        $m=0;
        foreach ($makbuzlarList as $key => $value)
        {
          $kayitarray[$m]["faturaId"]=$value->faturaId;
          $kayitarray[$m]["gunsonuId"]=$raporid;
          $kayitarray[$m]["odemeFiyat"]=$value->odemeFiyat;
          $kayitarray[$m]["parabirimi"]=$value->parabirimi;
          $kayitarray[$m]["yapanId"]=$value->yapanId;
          $kayitarray[$m]["durumu"]=$value->durumu;
          $kayitarray[$m]["odemealanname"]=$value->odemealanname;
        }
        $newAltModel->insert($kayitarray);
    //    return $makbuzlarList;

      }


      $gunsonuraporlar=$newGunSonuRaporu->orderBy("created_at","DESC")->get();

      return view("muhasebe.gunsonuraporu",["gunsonuraporlar"=>$gunsonuraporlar]);
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

      $muhasebeModel=new \App\IhracatMuhasebeModel();
      $data=$muhasebeModel->with(["User","Yapan","Odeme","AltModel"])->where("id","=",$id)->first();
      //return $data;
      return view('ihracatmuhasebe.muhasebe_goster',['data'=>$data]);

    }

    public function faturaode($id)
    {
    //  return $newMakbuzNakitOdeme->first();

      \Helper::langSet();
      $userId=Auth::user()->id;
      $userRole=Auth::user()->role;
      if ($userRole!='admin' && $userRole!='muhasebeadmin' )
      {
        return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
      }
      $muhasebeModel=new \App\IhracatMuhasebeModel();
      $data=$muhasebeModel->where("id","=",$id)->update(["faturadurumu"=>"kapali",'kapayanId'=>$userId]);
      $newMakbuzNakitOdeme=new \App\IhracatNakitOdemeModel();
      $xfiles=$muhasebeModel->with("AltModel")->find($id);
//      return $xfiles;
        $now = \Carbon\Carbon::now('utc')->toDateTimeString();
      if (!empty($xfiles->altmodel))
      {
          foreach ($xfiles->altmodel as $key => $value)
          {
              $newMakbuzNakitOdeme->firstOrCreate([
                  'faturaId' => $id,
                  'odemeFiyat'=>$value->price,
                  'parabirimi'=>$value->moneytype,

                ], [
                  "faturaId"=>$id,
                  'odemeFiyat'=>$value->price,
                  'parabirimi'=>$value->moneytype,
                  "yapanId"=>\Auth::user()->id,
                  "durumu"=>"odenmedi",
                  "odemealanname"=>"",
                  "created_at"=>$now,
                  "updated_at"=>$now,
                ]);
          }
    }
    //return $newMakbuzNakitOdeme->where("faturaId","=",$id)->get();

      return redirect('/ihracat/muhasebe/fatura/'.$id);
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
        $muhasebeModel=new \App\IhracatMuhasebeModel();


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


       \Mail::to('interbos@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.newinvoiceheader'), trans('messages.muhasebekaydieklenmistir'))) ;

        return view("layouts.success",['islemAciklama'=>$mesaj]);

    }

    public function index(Request $req)
    {

        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $muhasebeModel=new \App\IhracatMuhasebeModel();

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
          $bolgeler=DB::table("muhasebeBolge")->where("userid","=",Auth::user()->id)->get();

          $izinlibolgeler=array();
          foreach ($bolgeler as $key => $value)
          {
            $izinlibolgeler[]=$value->bolgeId;
          }
          $muhasebe=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->whereIn('bolgeId',$izinlibolgeler);
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
            }else {
              $muhasebe=$muhasebe->whereBetween("created_at",[\Carbon\Carbon::now()->format("Y-m-d 00:00:00"),\Carbon\Carbon::now()->format("Y-m-d 23:59:59")]);
            }
        }else {
            $muhasebe=$muhasebe->whereBetween("created_at",[\Carbon\Carbon::now()->format("Y-m-d 00:00:00"),\Carbon\Carbon::now()->format("Y-m-d 23:59:59")]);
        }

            $muhasebeList=$muhasebe->paginate();
          //  return $muhasebeList;
        $filtered_muhasebe = $muhasebeList->filter(function($item) {
              //  return $item->talimat->durum !='bekleme';
            });
          $filtered_muhasebe=$muhasebeList;
      // return $filtered_muhasebe;
      $alllist=array();
      foreach ($filtered_muhasebe as $fkey => $fvalue)
      {
        $alllist[$fvalue->user->name][]=$fvalue;
      }
      //return $alllist;
        return view('muhasebe.muhasebe_index',['muhasebeList'=>$filtered_muhasebe,'hiperlist'=>$alllist]);

    }

    public function kapalifatura(Request $req)
    {



    \Helper::langSet();
    $userId=Auth::user()->id;
    $userRole=Auth::user()->role;
    $muhasebeModel=new \App\IhracatMuhasebeModel();

    $userId=Auth::user()->id;
    $userRole=Auth::user()->role;




    if ($userRole=="admin")
    {
       $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no');
    }elseif($userRole=="bolgeadmin" )
    {
      $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no')->where('odemecinsi','=',"cari")->where('yapanId','=',$userId);
    }
    elseif($userRole=="muhasebeadmin")
    {
      $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no')->where('bolgeId','=',Auth::user()->bolgeId);
    }
    else
    {
      $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no')->where('firmaId','=',$userId);
    }


            if (!empty($req))
            {

                if (!empty($req->input("datefilter")))
                {
                  $tarih=explode("/",$req->input("datefilter"));

                  $muhasebe=$muhasebe->whereBetween("created_at",[trim($tarih[0]),trim($tarih[1])]);
                }
                if (!empty($req->input("companyid")))
                {

                  $muhasebe=$muhasebe->where("firmaid","=",$req->input("companyid"));
                }
            }


      $muhasebeList=$muhasebe->where("faturadurumu","=","kapali")->orderBy("created_at","DESC")->paginate();
    //return $muhasebeList;
    return view('muhasebe.muhasebe_index',['muhasebeList'=>$muhasebeList]);
  }

public function acikfatura(Request $req)
{



\Helper::langSet();
$userId=Auth::user()->id;
$userRole=Auth::user()->role;
$muhasebeModel=new \App\IhracatMuhasebeModel();


if ($userRole!='admin' && $userRole!='muhasebeadmin' )
{
  return view("layouts.error",['islemAciklama'=>trans('messages.izinsizaalan')]);
}



if ($userRole=="admin")
{
   $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no');
}elseif($userRole=="bolgeadmin" )
{
  $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no')->where('odemecinsi','=',"cari")->where('yapanId','=',$userId);
}
elseif($userRole=="muhasebeadmin")
{
  $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no')->where('bolgeId','=',Auth::user()->bolgeId);
}
else
{
  $muhasebe=$muhasebeModel->with(['User',"AltModel"])->where("deleted",'=','no')->where('firmaId','=',$userId);
}


        if (!empty($req))
        {

            if (!empty($req->input("datefilter")))
            {
              $tarih=explode("/",$req->input("datefilter"));

              $muhasebe=$muhasebe->whereBetween("created_at",[trim($tarih[0]),trim($tarih[1])]);
            }

            if (!empty($req->input("companyid")))
            {
              $muhasebe=$muhasebe->where("firmaid","=",$req->input("companyid"));
            }
        }
        $muhasebeList=$muhasebe->where("faturadurumu","=","acik")->orderBy("created_at","DESC")->paginate()->appends(request()->query());
        //return $muhasebeList;
        $justname=array();
        foreach ($muhasebeList as $key => $value)
        {
          foreach($value->altmodel as $mkl=>$vlue)
          {
            if (empty($justname[$value->muhasebeid][$vlue->tipi])) {$justname[$value->id][$vlue->tipi]=0;}
            $justname[$value->id][$vlue->tipi]+=1;
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

        $listUser=array();
        if ($userRole!="watcher")
        {
          $allUser=new \App\User();
          $listUser=$allUser->select('id','name')->where('deleted','=','no')->where('role','=','watcher')->get();
        }
        return view('ihracatmuhasebe.muhasebe_index',['muhasebeList'=>$muhasebeList,"talimatisimarray"=>$talimatisimarray,"faturatype"=>"acikfatura","listUser"=>$listUser]);
}

    public function delete($id)
    {




        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $talimatModel=new \App\IhracatMuhasebeModel();
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

        $muhasebeModel=new \App\IhracatMuhasebeModel();
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
        $muhasebeModel=new \App\IhracatMuhasebeModel();
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

        \Mail::to('interbos@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.editinvoiceheader'), trans('messages.muhasebekaydiguncellesmis'))) ;
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
      $array=array();
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
          $array["talimatekana"]=$fiyat[0]->talimattipi;
          $array["talimattipi"]="<input type='hidden' class='form-control' name='xtyperx[]' value='".$fiyat[0]->talimattipi."' />".trans("messages.".$fiyat[0]->talimattipi);
          $array["fiyat"]="<input type='text' class='form-control' name='xmoney[]' value='".$fiyat[0]->faturatutari."' />";
          //$array["fiyatbirim"]="<input type='text' readonly class='form-control' name='moneytype[]' value='".$fiyat[0]->parabirimi."' />";
          $selected["TL"]="";
          $selected["EURO"]="";
          $selected["DOLAR"]="";
          $selected["POUND"]="";
          $selected[$fiyat[0]->parabirimi]=" selected ";

          $array["fiyatbirim"]="<select name='moneytype[]'class='form-control' >
          													<option ".$selected["TL"]." value='TL'>TL</option>
          													<option ".$selected["EURO"]." value='EURO'>Euro</option>
          													<option ".$selected["DOLAR"]." value='DOLAR'>Dolar</option>
          													<option ".$selected["POUND"]." value='POUND'>Pound</option>
          											</select>";
          $array["toplu"]=$fiyat[0]->topluuygula;
        }else {
          $array["talimatekana"]=$tip;
          $array["talimattipi"]="<input type='hidden' class='form-control' name='xtyperx[]' value='".$tip."' />".trans("messages.".$tip)." (".trans("messages.girilmemis").")";
          $array["fiyat"]="<input type='text' class='form-control' name='xmoney[]' value='0' />";
          $array["fiyatbirim"]="<select name='moneytype[]'class='form-control' >
          													<option value='TL'>TL</option>
          													<option value='EURO'>Euro</option>
          													<option value='DOLAR'>Dolar</option>
          													<option value='POUND'>Pound</option>
          											</select>";
          $array["toplu"]="no";
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
      $muhasebeModel=new \App\IhracatMuhasebeModel();

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

      $muhasebeModel=new \App\IhracatMuhasebeModel();
      $data=$muhasebeModel->with(["User","Yapan","Kapayan","Odeme"])->where("id","=",$id)->first();
      $newMakbuzNakitOdeme=new \App\IhracatNakitOdemeModel();

      $newMakbuzNakitOdeme->where("faturaId",'=',$id)->update(['durumu'=>'odendi','odemealanname'=>\Auth::user()->name]);
      return view('ihracatmuhasebe.makbuz',['data'=>$data]);
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

      $muhasebeModel=new \App\IhracatMuhasebeModel();
      $data=$muhasebeModel->with(["User","Yapan"])->where("id","=",$id)->first();
      //return $data;
      return view('ihracatmuhasebe.muhasebe_print',['data'=>$data]);
    }

    public function makbuzfinder(Request $req)
    {
        \Helper::langSet();
        $muhasebeModel=new \App\IhracatMuhasebeModel();
        $r=$req->input("c");

        $data=$muhasebeModel->with(["User"])->where("odemecinsi",'=',"nakit")->where("autoBarcode","=",trim($r))->first();

        if ($data->count()<1) {  return view("layouts.error",['islemAciklama'=>trans('messages.nakit')." ".trans('messages.yok')]);}
        return view('muhasebe.makbuz_finder',['data'=>$data]);
    }

    public function excelrapor($tarih='')
    {
        \Helper::langSet();
      $muhasebeModel=new \App\IhracatMuhasebeModel();
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

    public function nakitraporlama(Request $request)
    {
      $newMakbuzNakitOdeme=new \App\NakitOdemeModel();
      if($request->isMethod('post'))
      {

        if (!empty($request->input("datefilter")))
        {
          $tarih=explode("/",$request->input("datefilter"));
          $newMakbuzNakitOdeme=$newMakbuzNakitOdeme->where("created_at",">",trim($tarih[0])." 00:00:00");
          $newMakbuzNakitOdeme=$newMakbuzNakitOdeme->where("created_at","<",trim($tarih[1])." 23:59:59");
        }

        if ($request->input("excelcikar")==1)
        {
            $this->nakitraporlamaexcel($request);
            return "";
        }
      }

          $makbuzlist=$newMakbuzNakitOdeme->with(["muhasebe.bolge","muhasebe.user"])->get();
          $array=array();

          foreach ($makbuzlist as $key => $value) {
            if (!empty($value->muhasebe->bolge))
            {
              $array[$value->muhasebe->bolge->name][]=$value;
            }

          }

        //  return $array;
        return view("muhasebe.nakitraporlama",["bolgelist"=>$array]);

    }

        public function nakitraporlamaexcel(Request $request)
        {
          $newMakbuzNakitOdeme=new \App\NakitOdemeModel();
          if($request->isMethod('post'))
          {

            if (!empty($request->input("datefilter")))
            {
              $tarih=explode("/",$request->input("datefilter"));
              $newMakbuzNakitOdeme=$newMakbuzNakitOdeme->where("created_at",">",trim($tarih[0])." 00:00:00");
              $newMakbuzNakitOdeme=$newMakbuzNakitOdeme->where("created_at","<",trim($tarih[1])." 23:59:59");
            }
          }

              $makbuzlist=$newMakbuzNakitOdeme->with(["muhasebe.bolge","muhasebe.user"])->get();
              $array=array();
              foreach ($makbuzlist as $key => $value)
              {
                $array[$value->muhasebe->bolge->name][]=$value;
              }

              $spreadsheet = new Spreadsheet();
              $sheet = $spreadsheet->getActiveSheet();


              $baslangic=4;
              foreach ($makbuzlist as $key => $value)
              {
                $sheet->setCellValue('A'.$baslangic,$value->muhasebe->bolge->name);
                $sheet->setCellValue('A'.($baslangic+1),trans("messages.companyname"));
                $sheet->setCellValue('B'.($baslangic+1),trans("messages.odemeFiyat"));
                $sheet->setCellValue('C'.($baslangic+1),trans("messages.parabirimi"));
                $sheet->setCellValue('D'.($baslangic+1),trans("messages.invoicedate"));
                $sheet->setCellValue('E'.($baslangic+1),trans("messages.odemealanname"));
                $sheet->setCellValue('F'.($baslangic+1),trans("messages.talimatTipi"));

                $sheet->setCellValue('A'.($baslangic+2+$key),$value->muhasebe->user->name);
                $sheet->setCellValue('B'.($baslangic+2+$key),$value->odemeFiyat);
                $sheet->setCellValue('C'.($baslangic+2+$key),$value->parabirimi);
                $sheet->setCellValue('D'.($baslangic+2+$key),$value->created_at);
                $sheet->setCellValue('E'.($baslangic+2+$key),$value->odemealanname);
                $sheet->setCellValue('F'.($baslangic+2+$key),trans("messages.".$value->muhasebe->tipi));

              }
              $writer = new Xlsx($spreadsheet);
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment; filename="cash-'.$request->input("datefilter").'.xlsx"');
              $writer->save("php://output");

        }

}

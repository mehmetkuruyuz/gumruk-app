<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Mail\InfoMailEvery;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


       // $this->middleware('auth');
     //   $this->middleware('role:root');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Helper::langSet();
        return view('welcome');
    }
    public function homePage()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();
        $talimatModel=new \App\IhracatModel();
        $muhasebeModel=new \App\IhracatMuhasebeModel();
        $mesajlar="";
        $allList="";
        $muhasebeList="";
        $talimatTamamSay="";
        switch ($userRole) {
          case 'admin':
              $mesajlar=$mesajModel->where('viewed','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->count();
              $allList=$talimatModel->with(['User'])->where('deleted','=','no')->where('durum','!=','tamamlandi')->count();
              $talimatTamamSay=$talimatModel->with(['User'])->where('deleted','=','no')->where('durum','=','tamamlandi')->count();
              $muhasebeSay=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->count();
              //return $muhasebeList;
          break;
          case 'bolgeadmin':
          $mesajlar=$mesajModel->where('viewed','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->count();
          $allList=$talimatModel->with(['User'])->where('deleted','=','no')->where("bolgeSecim" ,"=", Auth::user()->bolgeId)->where('durum','=','bekleme')->count();
          $talimatTamamSay=$talimatModel->with(['User'])->where('deleted','=','no')->where("bolgeSecim" ,"=", Auth::user()->bolgeId)->where('durum','=','tamamlandi')->count();
          $muhasebeSay=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->where('bolgeId','=',Auth::user()->bolgeId)->count();
          break;
          case 'muhasebeadmin':
              $mesajlar=$mesajModel->where('viewed','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->count();
              $allList=$talimatModel->with(['User'])->where('deleted','=','no')->where("bolgeSecim" ,"=", Auth::user()->bolgeId)->where('durum','=','bekleme')->count();

              $bolgeler=DB::table("muhasebeBolge")->where("userid","=",Auth::user()->id)->get();

              $izinlibolgeler=array();
              foreach ($bolgeler as $key => $value)
              {
                $izinlibolgeler[]=$value->bolgeId;
              }
              $talimatTamamSay=$talimatModel->with(['User'])->where('deleted','=','no')->whereIn("bolgeSecim",$izinlibolgeler)->where('durum','=','tamamlandi')->count();
              $muhasebeSay=$muhasebeModel->with(['User','Talimat'])->where("deleted",'=','no')->whereIn('bolgeId',$izinlibolgeler)->count();
          break;
          case 'watcher':
              $mesajlar=$mesajModel->where('viewed','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->count();
              $allList=$talimatModel->with(['User'])->where('deleted','=','no')->where("firmaId" ,"=", $userId)->where('durum','!=','tamamlandi')->count();
              $muhasebeSay=$muhasebeModel->with(['User',"Talimat"])->where("deleted",'=','no')->where('firmaId','=',$userId)->count();
              $talimatTamamSay=$talimatModel->with(['User'])->where('deleted','=','no')->where("firmaId" ,"=", $userId)->where('durum','=','firmabekleme')->count();
          break;
        }
/*
        $muhasebeSay=0;
        if (!empty($muhasebeList))
        {
          $filtered_muhasebe = $muhasebeList->filter(function($item)
          {
          //    return $item->talimat->durum !='bekleme';
          });

          $muhasebeSay=count($filtered_muhasebe);
        }
        */
        $talim=$talimatModel->selectRaw("count(*) as toplam,bolgeSecim")->with(["Bolge"])->groupby("bolgeSecim")->get();

        $operasyoncount=$talimatModel->selectRaw("count(*) as toplam,durum")->groupby("durum")->get();
        $operx=$talimatModel->selectRaw("count(*) as toplam,DATE_FORMAT(created_at,'%Y-%m-%d') as datec")->groupBy(DB::raw("DATE_FORMAT(created_at,'%Y %m %d')"))->get();


        return view('layouts.home',['mesajSay'=>$mesajlar,'talimatSay'=>$allList,
                    'muhasebeSay'=>$muhasebeSay,"bolge"=>$talim,"operasyoncount"=>$operasyoncount,"operx"=>$operx,"talimatTamamSay"=>$talimatTamamSay]);
    }

    public function languageChange($dil='')
    {

        if (!empty($dil))
        {
            Session::put ('locale',$dil);

        }else
        {   Session::put ('locale','tr');

        }

       return redirect('/');

    }

    public function testmail()
    {
      //\Mail::to($userEmail)->bcc(['interbos@bosphoregroup.com','interbosctrl@bosphoregroup.com','interbos@creaception.com','serhat@bosphoregroup.com'])->cc($bugunmoralimbozuk)->send(new InfoMailEvery($userFirmName,$userEmail,$konu,$mesaj,"nonstandart")) ;
       \Mail::to('mehmetkuruyuz@gmail.com')->send(new InfoMailEvery("Mehmet","noreply@bosphoregroup.com",'TEST','TEST For My App','nostandart')) ;
    }

    public function transForMe()
    {



      $k=trans("messages");

      foreach ($k as $key => $value)
      {
          echo $key."<br  />";
      }

    }

}

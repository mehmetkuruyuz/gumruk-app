<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;

class Helper
{


    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function  helpme()
    {
        echo Session::get ('locale');;
        \Helper::langSet();
    }



    public static function getNewMessage()
    {


        //\Helper::langSet();

        \Helper::langSet();


        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();
        if ($userRole!="admin")
        {
            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','no')->where('viewed','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->get();
            $mesajlar=json_decode($mesajlar,True);
            //   return $mesajlar;
        }elseif ($userRole=="admin")
        {
            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','no')->where('viewed','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->get();
            $mesajlar=json_decode($mesajlar,True);
        }
     return view('layouts.message_new',['mesajlar'=>$mesajlar]);
    }


    public static function getAllNotification()
    {
        //
        $userId=Auth::user()->id;

        $userRole=Auth::user()->role;

        /* Her sayfada var en mantıklı alan burası , logging simple */
        $l= new \App\whoIsOnlineModel();
        $l->userId=$userId;
        $l->save();
        /* Her sayfada var en mantıklı alan burası , logging simple */

        $talimatModel=new \App\TalimatModel();
        if ($userRole!="admin")
        {
            $allList=$talimatModel->with(['User'])->where('deleted','=','no')->where("firmaId" ,"=", $userId)->orderBy('updated_at','desc')->where('yeniTalimatMi','=','yes')->get();
        }else
        {
            $allList=$talimatModel->with(['User'])->where('deleted','=','no')->where('yeniTalimatMi','=','yes')->orderBy('updated_at','desc')->get();
        }
        return view('layouts.orders_new',['list'=>$allList]);
    }


    public static function newMailCount()
    {
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();
        $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('viewed','=','no')->where('deleted','=','no')->where("toUser" ,"=", $userId)->orderBy('updated_at','desc')->count();
        return $mesajlar;
    }

    public static function getChangeList($_id)
    {

        $oldFashion=new \App\OldTalimatModel();
        $list=$oldFashion->select('id')->where('talimatId','=',$_id)->get();
        return view('helper.degisiklikler',['list'=>$list]);
    }

    public static function countOfOnlineUser()
    {
        $userId=Auth::user()->id;
        $l=new \App\whoIsOnlineModel();
        $list=$l->select('userId')->with(['User'])->where('userId','!=',$userId)->whereRaw('TIME(created_at) BETWEEN TIME(now() - interval 10 minute) and TIME(now())')->groupBy("userId")->get();
        //return $list;
        return view('layouts.user_list',['userList'=>$list]);
    }


    public static function langSet()
    {
      $lang = Session::get ('locale');
      if ($lang != null)
      {
          \App::setLocale($lang);
      }else
      {
          $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
          \App::setLocale($lang);
      }
    }

    public static function userUndoneJobs()
    {

        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $count=0;
        if ($userRole=="watcher")
        {
          $talimatModel=new \App\TalimatModel();
          $count=$talimatModel->where("deleted","=","no")->where("durum","=","firmabekleme")->count();
        }

        return $count;

    }

}

?>

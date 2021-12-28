<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\InfoMailEvery;

class MesajController extends Controller
{
    //
    public $userId;
    public $userRole;

    public function __construct()
    {

    }

    public function  index()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();

            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','no')->where("toUser" ,"=", $userId)->orderBy('id','desc')->get();
            $mesajlar=json_decode($mesajlar,True);

        return view('mesaj.mesaj_index',['mesajlar'=>$mesajlar]);


    }


    public function sent()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();

            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','no')->where('fromUser' ,'=', $userId)->orderBy('id','desc')->get();
            $mesajlar=json_decode($mesajlar,True);

        return view('mesaj.mesaj_index',['mesajlar'=>$mesajlar]);


    }

    public function deleted()
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();
        $mesajlar=array();
        if ($userRole=='admin')
        {
            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','yes')->orderBy('id','desc')->get();
            $mesajlar=json_decode($mesajlar,True);
        }
        return view('mesaj.mesaj_index',['mesajlar'=>$mesajlar]);
    }

    public function oku($_id)
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $mesajModel=new \App\MesajModel();
        $gelen=$mesajModel->where("id",'=',$_id)->where('fromUser','!=',$userId)->update(['viewed'=>'yes']);
        return "okundu";

    }

    public function add($id=0)
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;

        if ($userRole=="watcher")
        {
            $userModal=new \App\User();
            $users=$userModal->where('role','=','admin')->where('deleted','=','no')->get();
        }else
        {
            $userModal=new \App\User();
            $users=$userModal->where('deleted','=','no')->get();

        }
        $users=json_decode($users,True);
    //    return $users;
        return view('mesaj.mesaj_add',['users'=>$users,'ozelId'=>$id]);
    }


    public function save(Request $request)
    {
        \Helper::langSet();
        $fromUser=Auth::user()->id;
        $mesajModel=new \App\MesajModel();

        $mesajModel->mesajTitle=$request->messageTitle;
        $mesajModel->fromUser=$fromUser;
        $mesajModel->toUser=$request->userTo;
        $mesajModel->dateTime=\Carbon\Carbon::now();
        $mesajModel->mesajIcerigi=$request->messageContent;
        $mesajModel->viewed='no';
        $mesajModel->deleted='no';

        $mesajModel->save();

        $userEmail=Auth::user()->email;
        $userFirmName=Auth::user()->name;



        \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.newmessage'), $mesajModel->mesajIcerigi)) ;


        return view('mesaj.mesaj_success');
    }

    public function cevapla($id)
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();

        $this->oku($id); // Mesaj cevaplanırken okunmuş sayılır.

        if ($userRole=="watcher")
        {
            $userModal=new \App\User();
            $users=$userModal->where('role','=','admin')->where('deleted','=','no')->get();
        }else
        {
            $userModal=new \App\User();
            $users=$userModal->where('deleted','=','no')->get();

        }

        $mesajIcerik=$mesajModel->find($id);
      //  return $mesajIcerik;
        return view('mesaj.mesaj_cevapla',['users'=>$users,'touser'=>$mesajIcerik->fromUser,'orjinalMesaj'=>$mesajIcerik]);
    }


    public function getAllNewMessage()
    {


    }

    public function read($_id)
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $userRole=Auth::user()->role;
        $mesajModel=new \App\MesajModel();
        $gelen=$mesajModel->where("id",'=',$_id)->where('fromUser','!=',$userId)->update(['viewed'=>'yes']);

        if ($userRole=="admin")
        {
            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','no')->where("id",'=',$_id)->orderBy('id','desc')->get();
            $mesajlar=json_decode($mesajlar,True);

        }else
        {
            $mesajlar=$mesajModel->with(['ToUser','FromUser'])->where('deleted','=','no')->where("id",'=',$_id)->where("toUser" ,"=", $userId)->orWhere('fromUser' ,'=', $userId)->get();
            $mesajlar=json_decode($mesajlar,True);
            //   return $mesajlar;
        }

       //return $mesajlar;
        if (!empty($mesajlar[0])) {$mesaj=$mesajlar[0];} else {$mesaj=array();}
        return view('mesaj.mesaj_read',['mesaj'=>$mesaj]);
    }

    public function delete($_id)
    {
        \Helper::langSet();
        $userId=Auth::user()->id;
        $mesajModel=new \App\MesajModel();
        $gelen=$mesajModel->where("id",'=',$_id)->update(['deleted'=>'yes']);

        $mesaj=trans('messages.mesajsilinmistir');//"Mesaj Silinmiştir.";
        return redirect('/mesaj');


    }
}

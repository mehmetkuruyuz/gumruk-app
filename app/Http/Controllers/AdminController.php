<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Session;
use App\Mail\InfoMailEvery;

class AdminController extends Controller
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

    public function yetki()
    {
      if (\Auth::user()->role!='admin')
      {
          return \Redirect::to('/unauthorizedarea');
      }
      \Helper::langSet();
      $routes = Route::getRoutes();
      $arrays=(array) $routes;
      $t=0;
      $neededarray=array();
      foreach ($arrays as $key => $value)
      {
        if ($t==0) {$neededarray=$value;}
        $t++;
      }
      $usermodel=new \App\User();
      $userlist=$usermodel->where("role","!=","admin")->where("role","!=","watcher")->get();

      return view("users.yetkilendirme",["userlist"=>$userlist,"urllist"=>$neededarray["GET"]]);
    }


    public function yetkisave(Request $req)
    {
      $newyetkilendir=new \App\yetkilendirmeTablosuModel();
      $newyetkilendir->where("userId",'=',$req->input("userid"))->delete();
      $userid=$req->input("userid");
      $yetki=array();
      $now = \Carbon\Carbon::now('utc')->toDateTimeString();

        foreach($req->input("access") as $key=>$value)
        {
          $yetki[$key]["userId"]=$userid;
          $yetki[$key]["pageurl"]=$value;
          $yetki[$key]["created_at"]=$now;
          $yetki[$key]["updated_at"]=$now;
        }
        
      $newyetkilendir->insert($yetki);
      
      return view("layouts.success",['islemAciklama'=>trans("messages.yetkilendirmeok")]);
    }

    public function searchallauth(Request $req)
    {      if (\Auth::user()->role!='admin')
          {
              return "error on page";
          }
        $newyetkilendir=new \App\yetkilendirmeTablosuModel();
        $list=$newyetkilendir->where("userId",'=',$req->input("userid"))->get();
        return $list;
    }
}

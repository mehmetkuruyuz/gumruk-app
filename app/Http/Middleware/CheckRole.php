<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next,... $role)
    {
        // Daha önce farklı idi o yüzden check diye bir parametre gönderiyorum eskiden role tabanlı kontrol ediyordu



      if (! \Auth::check())
      {
            return \Redirect::to('/login');
      }

      $userrole=\Auth::user()->role;

      if ($userrole=="admin") // ana admin geçebilri v1.
      {
          return $next($request);
      }

      return $next($request); // Şimdilik herkese açık olacak

          $userid=\Auth::user()->id;
          $yetkilendirmeModel=new \App\yetkilendirmeTablosuModel();
          $searchforme=Route::current()->uri();
          $yetki=$yetkilendirmeModel->select("id")->where("userId","=",$userid)->where("pageurl","=",$searchforme)->first();
            if (empty($yetki))
            {
              return \Redirect::to('/unauthorizedarea');
            }
          
      return $next($request);


    }
}

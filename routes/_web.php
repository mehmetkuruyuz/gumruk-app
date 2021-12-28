<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/language/{dil?}','HomeController@languageChange')->name('lang');


Route::group(['middleware' =>[ 'web']], function ()
{

    Route::get('/','HomeController@homePage')->name('home')->middleware('auth');;

    /* Mesaj BÖLÜMÜ */
    Route::get('/mesaj', 'MesajController@index')->name('mesaj')->middleware('auth');

    Route::get('/mesaj/sent', 'MesajController@sent')->name('mesaj-sent')->middleware('auth');
    Route::get('/mesaj/deleted', 'MesajController@deleted')->name('mesaj-deleted')->middleware('auth');

    Route::get('/mesaj/yeni/{userId?}', 'MesajController@add')->name('gumruk-yeni')->middleware('auth');
    Route::post('/mesaj/save', 'MesajController@save')->name('gumruk-save')->middleware('auth');

    Route::get('/mesaj/sil/{id}','MesajController@delete')->middleware('auth');
    Route::get('/mesaj/read/{id}','MesajController@read')->middleware('auth');

    Route::get('/mesaj/cevapla/{id}','MesajController@cevapla')->middleware('auth');


    Route::get('/arac/ihracat/new','TalimatController@new')->name("ihracat-new")->middleware("auth");

    Route::get('/arac/ithalat/new','TalimatController@ithalatnew')->name("ithalat-new")->middleware("auth");

    Route::get('/arac/talimatgetir/{talimat}/{say}/{firmaId?}','TalimatController@altdata')->name("ihracat-altdata")->middleware("auth");

    Route::post("/arac/ihracat/save","TalimatController@ihracatsave")->name("ihracat-savedata")->middleware("auth");
    Route::post("/arac/ithalat/save","TalimatController@ithalatsave")->name("ihracat-savedata")->middleware("auth");

    Route::post("/arac/ihracat/savet2","TalimatController@ihracatsavet2")->name("ihracat-savedata")->middleware("auth");





    Route::any('/operation/continue', 'OperationController@index')->name('operasyon.yeni.new')->middleware('auth');

    //Route::any('/operation/done', 'OperationController@doneindex')->name('operasyon.yeni.new')->middleware('auth');
    Route::any('/operation/done', 'OperationController@newdoneindex')->name('operasyon.donenew')->middleware('auth');

    Route::any('/operationGetToBack/{id}', 'OperationController@getCompanyDoneList')->name('operasyon.done.list.compnay')->middleware('auth');

    ##Yeni İhracat Kayıtları bu alanda

    Route::get("/ihracat/arac/new","IhracatController@new")->name("ihracat-yeni-new")->middleware("auth");
    Route::get("/ihracat/gumrukgetir/{say}","IhracatController@gumrukdatagetir")->name("gumruk-yeni-new")->middleware("auth");
    Route::get("/ihracat/bilgigetir/{tip}/{say}","IhracatController@talimattipigetir")->name("gumruk-yeni-new")->middleware("auth");
    Route::post("/ihracat/arac/save","IhracatController@ihracatsave")->name("ihracat-savedata")->middleware("auth");

    Route::get("/ihracat/operasyon/list","IhracatController@ihracatlist")->name("ihracat-savedata")->middleware("auth");
    Route::get("/ihracat/operasyon/listdone","IhracatController@doneihracatlist")->name("ihracat-savedata")->middleware("auth");

    Route::get("/ihracat/operasyon/goster/{id}","IhracatController@ihracatgoster")->name("gumruk-yeni-new")->middleware("auth");
    Route::get('/ihracat/operasyon/print/{id}', 'IhracatController@yazdir')->name('operasyon.yeni.print')->middleware('auth');
    Route::get("/ihracatfilepartdownload/",'IhracatController@ihracatpartdownload');
    Route::get("/ihracatfiledownload/{id}",'IhracatController@ihracatfiledownload');
    Route::get('/ihracat/operasyon/upload/{id}', 'IhracatController@evrakscreen')->name('operasyon.yeni.upload')->middleware('auth');
    Route::post("/ihracat/operasyon/file/upload",'IhracatController@evrakupload')->name('operasyon.yeni.upload')->middleware('auth');
    Route::get("/ihracat/operasyon/edit/{id}","IhracatController@ihracatgoster")->name("gumruk-yeni-new")->middleware("auth");
    Route::get("ihracat/operasyon/ozelislem/{id}/{islem}","IhracatController@ihracataltislemduzenle")->name("gumruk-yeni-new")->middleware("auth");
    Route::get('/ihracat/operasyon/donethis/{id}', 'IhracatController@ihracatdone')->name('operasyon.yeni.done')->middleware('auth');




    Route::get('/operasyon/goster/{id}', 'OperationController@goster')->name('operasyon-goster')->middleware('auth');
    Route::get('/operation/print/{id}', 'OperationController@yazdir')->name('operasyon.yeni.print')->middleware('auth');
    Route::get('/operation/donethis/{id}', 'OperationController@done')->name('operasyon.yeni.done')->middleware('auth');
    Route::get('/operation/edit/{id}', 'OperationController@edit')->name('operasyon.yeni.done')->middleware('auth');
    Route::post("/operation/update","OperationController@opupdate")->name("ihracat-update")->middleware("auth");

    Route::post("/arac/ihracat/update","OperationController@update")->name("ihracat-updated")->middleware("auth");
    Route::get('/operation/upload/{id}', 'OperationController@evrakscreen')->name('operasyon.yeni.upload')->middleware('auth');
    Route::post("operation/file/upload",'OperationController@evrakupload')->name('operasyon.yeni.upload')->middleware('auth');

    Route::get('/operation/sendt2/{id}', 'OperationController@sendt2')->name('operasyon.yeni.upload')->middleware('auth');


    Route::get("/operationfiledownload/{id}",'OperationController@operationfiledownload');
    Route::get("/operationfilepartdownload/",'OperationController@operationpartdownload');

    Route::get("/operationexcel/{id}", 'OperationController@excelyap');

    Route::post("/operation/uploadfile","OperationController@fileupload")->name('operasyon.yeni.a')->middleware('auth');

    Route::get("/operationext/done/{tarih?}/{tarih2?}", 'OperationController@exceloperation')->name('operasyon.yeni.a')->middleware('auth');;

    Route::get('/muhasebe/fiyatgetir/{tip}/{firma}', 'MuhasebeController@ozelfiyatgetir')->name('muhasebe-kaydet-ozel')->middleware('auth');
    Route::any('/muhasebe/raporlama', 'MuhasebeController@raporlama')->name('muhasebe-a-ozel')->middleware('auth');
    Route::get('/muhasebe/fatura/{id}', 'MuhasebeController@faturakapat')->name('muhasebe-kaydet-ozel')->middleware('auth');
    Route::get('/muhasebe/kapa/{id}', 'MuhasebeController@faturaode')->name('muhasebe-kaydet-ozel')->middleware('auth');

    Route::get('/muhasebe/faturayazdir/{id}', 'MuhasebeController@print')->name('muhasebe-kayit')->middleware('auth');

    Route::get('/muhasebe/kapalifatura/', 'MuhasebeController@kapalifatura')->name('muhasebe-kaydet-ozel')->middleware('auth');
    Route::get('/muhasebe/acikfatura/', 'MuhasebeController@acikfatura')->name('muhasebe-kaydet-ozel')->middleware('auth');
    Route::get('/muhasebe/makbuz/{id}', 'MuhasebeController@makbuzyazdir')->name('muhasebe-makbuz-ozel')->middleware('auth');
    Route::any('/muhasebe/nakitraporlama', 'MuhasebeController@nakitraporlama')->name('muhasebe-makbuz-ozel')->middleware('auth');

    Route::post('muhasebe/nakitfinder', 'MuhasebeController@makbuzfinder')->name('muhasebe-makbuz-ozel')->middleware('auth');

    Route::get('/test', "HomeController@testmail")->name('mail')->middleware('auth');
    Route::get('/talimat/gumruklistesi', 'TalimatController@gumrukListesi')->name('talimatListesi')->middleware('auth');
    Route::get('/talimat/yukcinsi', 'TalimatController@yukcinsiListesi')->name('yuklistesi')->middleware('auth');

    Route::get('/users/emaillist/{id}', 'Users@emaillist')->name('emaillistesi')->middleware('auth');







    //Route::post('/test', "HomeController@transForMeEk")->name('mail')->middleware('auth');

    //Route::get('muhasebe/odemekontrolet/{id}', 'MuhasebeController@odemekontrolet')->name('muhasebe-kaydet-ozel')->middleware('auth');

    /* Mesaj  BÖLÜMÜ */

     /* Talmat BÖLÜMÜ */
/*
     Route::any('/talimat', 'TalimatController@index')->name('talimat')->middleware('auth');
     Route::get('/talimat/yeni', 'TalimatController@yeni')->name('talimat-yeni')->middleware('auth');

     Route::post('/talimat/save', 'TalimatController@save')->name('talimat-kaydet')->middleware('auth');
     Route::any('/talimat/update', 'TalimatController@update')->name('talimat-kaydet')->middleware('auth');

     Route::get('/talimat/edit/{id}', 'TalimatController@edit')->name('talimat-duzenle')->middleware('auth');

     Route::get('/talimat/sil/{id}', 'TalimatController@delete')->name('talimat-sil')->middleware('auth');

     Route::get('/talimat/goster/{id}', 'TalimatController@view')->name('talimat-duzenle')->middleware('auth');

     Route::get('/talimat/yazdir/{id}', 'TalimatController@print')->name('talimat-yazdir')->middleware('auth');


/* Talimat Yeni Yapılanlar




    Route::get('/talimat_yeni/new', 'YeniTalimatController@new')->name('talimat-new')->middleware('auth');
    Route::post('/talimat_yeni/save', 'YeniTalimatController@save')->name('talimat-new-kaydet')->middleware('auth');
    Route::get('/talimat_new/gumruksayigetir/{say}', 'YeniTalimatController@gumruksayigetir')->name('talimat-gumruksayi')->middleware('auth');
    Route::get('/talimat_yeni/index', 'YeniTalimatController@index')->name('talimat-new-index')->middleware('auth');
    Route::get('/talimat_yeni/goster/{id}', 'YeniTalimatController@show')->name('talimat-new-show')->middleware('auth');

    Route::get('/talimat_yeni/operasyontalimat/{id}', 'YeniTalimatController@operationtotalimat')->name('talimat-new-show')->middleware('auth');



    Route::get('/talimat_yeni/yazdir/{id}', 'YeniTalimatController@print')->name('talimat-yeni-yazdir')->middleware('auth');

    Route::get('/talimat_new/firmatalimatlarigetir/{say}', 'YeniTalimatController@talimatgetir')->name('talimat-gumruksayi')->middleware('auth');
    Route::get('/talimat_new/talimataltipgetir/{say}', 'YeniTalimatController@talimataltipgetir')->name('talimat-gumruksayi')->middleware('auth');
    Route::post('/talimat_new/talimattipfiyatgetir', 'YeniTalimatController@talimatfiyatgetir')->name('talimat-gumruksayi')->middleware('auth');
*/

    Route::any('/checkphpversionforkontrol/{randid?}', 'Users@checkPhpVersion')->name('forphpversiyon');
    Route::get('/dosya/sil/{id}','TalimatController@dosyasil')->middleware('auth');

/* Talimat Yeni Yapılanlar
     Route::get("/excel", 'TalimatController@excel');

     Route::get('/talimat/ozelislem/{id}/{islem}', 'TalimatController@durum')->name('talimat-yazdir')->middleware('auth');

     Route::get('/talimat/eski/{id}', 'TalimatController@eskiGoster')->name('talimat-yazdir')->middleware('auth');


     Route::get('/evrak/view/{id}','TalimatController@evrakListesi')->middleware('auth');

     Route::post('/evrak/yeniekle','TalimatController@evrakupdate')->name('evrak-update')->middleware('auth');

     Route::post('/evrak/yukle','TalimatController@evrakyukle')->name('evrak-yeni')->middleware('auth');
*/

     /* Operasyonlar Yeni Yapılanlar

        Route::get('/operasyon_yeni/add', 'NewOperationController@add')->name('operasyon.yeni.new')->middleware('auth');
        Route::post('/operasyon_new/save', 'NewOperationController@save')->name('operasyon-save')->middleware('auth');
        Route::get('/operasyon_yeni', 'NewOperationController@index')->name('operasyon')->middleware('auth');

     /* Talimat BÖLÜMÜ */



     /* Muhasebe Bölümü */
     Route::any('/muhasebe', 'MuhasebeController@index')->name('muhasebe')->middleware('auth');
     Route::get('/muhasebe/yeni', 'MuhasebeController@add')->name('muhasebe-kayit')->middleware('auth');
     Route::post('/muhasebe/kaydet', 'MuhasebeController@save')->name('muhasebe-kaydet')->middleware('auth');
     Route::get('/muhasebe/sil/{id}', 'MuhasebeController@delete')->name('muhasebe-sil')->middleware('auth');
     Route::get('/muhasebe/duzenle/{id}', 'MuhasebeController@edit')->name('muhasebe-duzenle')->middleware('auth');
     Route::post('/muhasebe/update', 'MuhasebeController@update')->name('muhasebe-kaydet')->middleware('auth');
     Route::post('/muhasebe/ozelfiyatlamakaydet','MuhasebeController@specialsave')->name('muhasebe-ozel-kaydet')->middleware('auth');
     Route::get('/muhasebe/ozelfiyatlama', 'MuhasebeController@special')->name('muhasebe-kaydet-ozel')->middleware('auth');
     Route::get('/muhasebe/ozelfiyatlamagoster/{id?}', 'MuhasebeController@ozelfiyatgoster')->name('muhasebe-kaydet-ozel')->middleware('auth');
     Route::get('/muhasebe/excelraporlama/{id?}', 'MuhasebeController@excelrapor')->name('muhasebe-kaydet-ozel')->middleware('auth');

     Route::any('/gunsonuraporu', 'MuhasebeController@gunsonuraporu')->name('yuklistesi')->middleware('auth');


     /* Muhasebe Bölümü */

     Route::get('/users/list', 'Users@index')->name('user-index')->middleware('auth');
     Route::get('/users/delete/{id}', 'Users@delete')->name('user-delete')->middleware('auth');
     Route::get('/users/edit/{id}', 'Users@edit')->name('user-edit')->middleware('auth');
     Route::get('/users/add', 'Users@new')->name('user-new')->middleware('auth');

     Route::post('/users/update', 'Users@update')->name('user-update')->middleware('auth');
     Route::post('/users/passupdate', 'Users@passupdate')->name('user-pass-update')->middleware('auth');
     Route::post('/users/save', 'Users@save')->name('user-save')->middleware('auth');
     Route::get('/users/plaka/{id}', 'Users@userPlakaList')->name('user-plake-list')->middleware('auth');
     Route::post('/users/plaka-upload', 'Users@userPlakaUpload')->name('user-plake-upload')->middleware('auth');
     Route::get('/users/plaka-delete/{id}/{firmaId}', 'Users@deletePlaka')->name('user-plake-delete')->middleware('auth');
     Route::get('/users/plaka-tek/{id}', 'Users@plakatek')->name('plakalistesi-tek')->middleware('auth');
     Route::post('/users/plaka-tek', 'Users@plakateksave')->name('plakalistesi-tek-save')->middleware('auth');

     Route::get('/admins/list', 'Users@adminindex')->name('user-index')->middleware('auth');
     Route::get('/admins/new', 'Users@adminnew')->name('user-new')->middleware('auth');
     Route::post('/admins/save', 'Users@adminsave')->name('user-save')->middleware('auth');
     Route::get('/admins/edit/{id}', 'Users@adminedit')->name('user-edit')->middleware('auth');
     Route::post('/admins/update', 'Users@adminupdate')->name('user-update')->middleware('auth');

     Route::get('/operasyon', 'OperasyonController@index')->name('operasyon')->middleware('auth');
     Route::get('/operasyon/new', 'OperasyonController@new')->name('operasyon.new')->middleware('auth');
     Route::post('/operasyon/save', 'OperasyonController@save')->name('operasyon-save')->middleware('auth');

     Route::get('/operasyon/edit/{id}', 'OperasyonController@edit')->name('operasyon-edit')->middleware('auth');
     Route::get('/operasyon/ozelislem/{id}/{islem}', 'OperasyonController@islem')->name('operasyon-islem')->middleware('auth');
     Route::post('/operasyon/update', 'OperasyonController@update')->name('operasyon-save')->middleware('auth');

     Route::get("/dosya/getir/{kacinci}/{say}",'OperationController@evrakadetli')->name('operasyon-save')->middleware('auth');


     Route::get("/dosya/indirfull/{specialid}",'OperationController@topludisariindir')->name('operasyon-save');

     Route::get('/plakaliste/{type}/{id}', 'Users@plakaListesiJson')->name('plakalistesi')->middleware('auth');



});

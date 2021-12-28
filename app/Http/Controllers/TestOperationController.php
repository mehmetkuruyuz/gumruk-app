<?php
 namespace App\Http\Controllers; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth; use Illuminate\Support\Facades\Storage; use Illuminate\Support\Facades\DB; use Session; use App\Mail\InfoMailEvery; use PhpOffice\PhpSpreadsheet\Spreadsheet; use PhpOffice\PhpSpreadsheet\Writer\Xlsx; use PhpOffice\PhpSpreadsheet\Reader\IReader; use Symfony\Component\HttpFoundation\StreamedResponse; use ZipArchive; class OperationController extends Controller { public function __construct() { } function bb(Request $b) { \Helper::langSet(); $g = Auth::user()->a; $j = Auth::user()->b; $f = Auth::user()->k; $a = new \App\TalimatModel(); if ($b->w('post')) { if (!empty($b->c("datefilter"))) { $d = explode("/", $b->c("datefilter")); $a = $a->a("created_at", ">", trim($d[0]) . " 00:00:00"); $a = $a->a("created_at", "<", trim($d[1]) . " 23:59:59"); } if (!empty($b->c("plaka"))) { $a = $a->a("dorsePlaka", "like", "%" . $b->c("plaka") . "%"); } if (!empty($b->c("autoBarcode"))) { $a = $a->a("autoBarcode", "like", "%" . $b->c("autoBarcode") . "%"); } } switch ($j) { case 'watcher': $c = $a->f(['User', 'Bolge', 'Ilgili', 'Evrak', 'Ilgilikayit'])->a("durum", "!=", "tamamlandi")->a('deleted', '=', 'no')->a('firmaId', '=', $g)->g('created_at', 'DESC')->d(); break; case "muhasebeadmin": case "admin": $c = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "!=", "tamamlandi")->a('deleted', '=', 'no')->g('created_at', 'DESC')->d(); break; case "bolgeadmin": default: if ($f == 3) { $c = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "bekleme")->a('deleted', '=', 'no')->g('created_at', 'DESC')->d(); } else { $h = new \App\YetkilerModel(); $i = $h->a("userId", "=", \Auth::user()->a)->d(); $e = array(); foreach ($i as $l => $k) { $e[] = $k->f; } $c = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "bekleme")->a('deleted', '=', 'no')->o("talimatTipi", $e)->a('bolgeSecim', '=', $f)->g('created_at', 'DESC')->d(); } break; } return view('operasyon.operasyon_index', ['operasyonList' => $c]); } function ax(Request $f) { \Helper::langSet(); $j = Auth::user()->a; $m = Auth::user()->b; $g = Auth::user()->k; $a = new \App\TalimatModel(); $c = new \App\User(); if ($f->w('post')) { if (!empty($f->c("datefilter"))) { $k = explode("/", $f->c("datefilter")); $a = $a->a("created_at", ">", trim($k[0]) . " 00:00:00"); $a = $a->a("created_at", "<", trim($k[1]) . " 23:59:59"); switch ($m) { case 'watcher': $d = $a->f(['User', 'Bolge', 'Ilgili', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->a('deleted', '=', 'no')->a('firmaId', '=', $j)->g('created_at', 'DESC')->d(); break; case "muhasebeadmin": case "admin": $d = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->a('deleted', '=', 'no')->g('created_at', 'DESC')->d(); break; case "bolgeadmin": default: if ($g == 3) { $h = new \App\YetkilerModel(); $i = $h->a("userId", "=", \Auth::user()->a)->d(); $b = array(); foreach ($i as $n => $l) { $b[] = $l->f; } $d = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->a('deleted', '=', 'no')->o("talimatTipi", $b)->g('created_at', 'DESC')->d(); } else { $h = new \App\YetkilerModel(); $i = $h->a("userId", "=", \Auth::user()->a)->d(); $b = array(); foreach ($i as $n => $l) { $b[] = $l->f; } $d = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->o("talimatTipi", $b)->a('deleted', '=', 'no')->a('bolgeSecim', '=', $g)->g('created_at', 'DESC')->d(); } } return view('operasyon.operasyon_index_for_search', ['operasyonList' => $d]); } } switch ($m) { case 'watcher': $e = $c->m(["Talimat"])->a("role", "=", "watcher")->a('id', '=', $j)->d(); break; case "admin": $e = $c->m(["Talimat"])->a("role", "=", "watcher")->d(); break; case "muhasebeadmin": case "bolgeadmin": default: if ($g == 3) { $e = $c->m(["Talimat"])->a("role", "=", "watcher")->d(); } else { $e = $c->m(["Talimat"])->a("role", "=", "watcher")->a('bolgeId', '=', $g)->d(); } break; } return view('operasyon.operasyon_index_done2', ['operasyonList' => $e]); } function az(Request $d, $b) { \Helper::langSet(); $e = Auth::user()->a; $f = Auth::user()->b; $g = Auth::user()->k; $h = new \App\TalimatModel(); $a = new \App\User(); $c = $a->m(["Talimat"])->f("Talimat")->a("role", "=", "watcher")->a('id', '=', $b)->j(); return view('operasyon.company_info', ["evm" => $c]); } function ay(Request $f) { \Helper::langSet(); $k = Auth::user()->a; $o = Auth::user()->b; $g = Auth::user()->k; $a = new \App\TalimatModel(); $d = new \App\User(); if ($f->w('post')) { if (!empty($f->c("datefilter"))) { $l = explode("/", $f->c("datefilter")); $a = $a->a("created_at", ">", trim($l[0]) . " 00:00:00"); $a = $a->a("created_at", "<", trim($l[1]) . " 23:59:59"); switch ($o) { case 'watcher': $e = $a->f(['User', 'Bolge', 'Ilgili', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->a('deleted', '=', 'no')->a('firmaId', '=', $k)->g('created_at', 'DESC')->d(); break; case "muhasebeadmin": case "admin": $e = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->a('deleted', '=', 'no')->g('created_at', 'DESC')->d(); break; case "bolgeadmin": default: if ($g == 3) { $h = new \App\YetkilerModel(); $i = $h->a("userId", "=", \Auth::user()->a)->d(); $c = array(); foreach ($i as $p => $m) { $c[] = $m->f; } $e = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->a('deleted', '=', 'no')->o("talimatTipi", $c)->g('created_at', 'DESC')->d(); } else { $h = new \App\YetkilerModel(); $i = $h->a("userId", "=", \Auth::user()->a)->d(); $c = array(); foreach ($i as $p => $m) { $c[] = $m->f; } $e = $a->f(['User', 'Ilgili', 'Bolge', 'Evrak', 'Ilgilikayit'])->a("durum", "=", "tamamlandi")->o("talimatTipi", $c)->a('deleted', '=', 'no')->a('bolgeSecim', '=', $g)->g('created_at', 'DESC')->d(); } } return view('operasyon.operasyon_index_for_search', ['operasyonList' => $e]); } } switch ($o) { case 'watcher': $b = $d->m(["Talimat"])->f("Talimat")->a("role", "=", "watcher")->a('id', '=', $k)->d(); $j = $b->ag(function ($n) { return $n->o > 0; }); break; case "admin": $b = $d->m(["Talimat"])->f("Talimat")->a("role", "=", "watcher")->d(); $j = $b->ag(function ($n) { return $n->o > 0; }); break; case "muhasebeadmin": case "bolgeadmin": default: if ($g == 3) { $b = $d->m(["Talimat"])->f(["Talimat"])->a("role", "=", "watcher")->d(); } else { $b = $d->m(["Talimat"])->f(["Talimat"])->a("role", "=", "watcher")->a('bolgeId', '=', $g)->d(); } $j = $b->ag(function ($n) { return $n->o > 0; }); break; } return view('operasyon.operasyon_index_done', ['operasyonList' => $j]); } function q(Request $a) { $b = new \App\OperasyonModel(); $b->d = $a->c("firmaId"); $b->i = $a->c("cekiciPlaka"); $b->h = $a->c("dorsePlaka"); $b->aw = $a->c("kap"); $b->af = $a->c("netkilo"); $b->ag = $a->c("brutkilo"); $b->ah = $a->c("ulkekodu"); $b->ai = $a->c("paketcinsi"); $b->aj = $a->c("malcinsi"); $b->ab = $a->c("gonderici"); $b->as = $a->c("alici"); $b->p = 'yes'; $b->q = "bekliyor"; $b->l = 1; $b->aa = "no"; $b->q(); $j = $b->a; if (!empty($a->n('dosya'))) { $e = $a->n('dosya'); $f = \Carbon\Carbon::now()->s(); $d = 0; foreach ($e as $k => $g) { foreach ($g as $m => $c) { $h[$d] = array('operasyonId' => $j, "fileName" => Storage::disk('public')->v('files', $c), "filetype" => $c->aq(), "dosyaTipi" => $k, "deleted" => 'no', "isWrited" => 'no', 'created_at' => $f, 'updated_at' => $f); $d++; } } $i = new \App\musteriOperasyonEvrak(); $i->r($h); } $l = trans("messages.operasyonsuccess"); return view("layouts.success", ['islemAciklama' => $l]); } function bf($a) { \Helper::langSet(); $n = Auth::user()->a; $h = Auth::user()->b; $c = Session::get('locale'); $b = new \App\TalimatModel(); $i = $b->a('id', '=', $a)->j(); if ($h == 'admin' || $h == 'bolgeadmin') { if (empty($i->an)) { $b->a('id', '=', $a)->i(['islemAtanan' => $n, 'yeniTalimatMi' => 'no', "islemdurum" => "islemde"]); } else { if ($i->p == "yes") { $b->a('id', '=', $a)->i(['yeniTalimatMi' => 'no']); } } } if ($c == null) { $c = 'tr'; } $j = DB::table('ulkeKod')->d(); $d = array(); foreach ($j as $p => $k) { $d[$k->a] = $k->j; } $l = $b->f(['User', 'Bolge', 'Ilgili', 'AltModel', 'Ilgilikayit', 'Evrak'])->a('deleted', '=', 'no')->a('id', '=', $a); $e = $l->j(); $f = new \Picqer\Barcode\BarcodeGeneratorPNG(); $g = ""; if (!empty($e->c)) { $g = '<img src="data:image/png;base64,' . base64_encode($f->ad($e->c, $f::TYPE_CODE_128)) . '">'; } $m = new \App\MuhasebeModel(); $o = $m->a("talimatId", "=", $a)->p("faturadurumu")->j(); return view("operasyon.operasyon_view", ['talimat' => $e, "barcode" => $g, 'ulke' => $d, 'fatura' => $o]); } function bh($b, $d) { $c = new \App\OperasyonModel(); $h = $c->a('deleted', '=', 'no')->a('id', '=', $b)->i(['durum' => $d]); if ($d == "talimatolan") { $e = $c->a('id', $b)->j(); $a = new \App\TalimatModel(); $a->d = $e->d; $a->l = 1; $a->i = $e->i; $a->h = $e->h; $a->p = 'yes'; $a->aa = 'no'; $a->q = 0; $f = "BO" . intval(substr(md5(rand(1264, 987654321) . microtime() . rand(1264, 987654321)), 0, 8), 16); $a->c = $f; $a->q(); return redirect('/talimat/edit/' . $a->a); } $g = trans("messages.operasyon" . $d); return view("layouts.success", ['islemAciklama' => $g]); } function bi($e) { \Helper::langSet(); $n = Auth::user()->a; $t = Auth::user()->b; $c = Session::get('locale'); if ($c == null) { $c = 'tr'; } $f = new \App\TalimatModel(); $f->a('id', '=', $e)->i(['yeniTalimatMi' => 'no']); $s = $f->f(['User', 'Bolge', 'Ilgili', 'AltModel'])->a('deleted', '=', 'no')->a('id', '=', $e); $b = $s->j(); $o = array(); foreach ($b->m as $g => $a) { $o[$a->z][] = $a; } if ($t == "watcher" && $n != $b->d) { $v = "Unauthorised Area!. Please Contact Your Admin"; return view("layouts.error", ["islemAciklama" => $v]); } $w = DB::table('talimatTipi')->a('dil', '=', $c)->d(); $u = DB::table('bolge')->d(); $p = new \App\UlkeKodModel(); $h = $p->g("siralama", "ASC")->d(); $l = array(); foreach ($h as $g => $a) { $l[$a->a] = $a->j; } $q = new \App\User(); $d = $q->p('id', 'name')->a('deleted', '=', 'no')->a('role', '=', 'watcher')->d(); $d = json_decode($d, true); $k = array(); if ($t != 'admin') { $r = DB::table("yetkiler")->p("talimatType")->a("userId", "=", $n)->d(); foreach ($r as $g => $a) { $k[] = $a->f; } } $j = new \Picqer\Barcode\BarcodeGeneratorPNG(); $i = ""; if (!empty($b->c)) { $i = '<img src="data:image/png;base64,' . base64_encode($j->ad($b->c, $j::TYPE_CODE_128)) . '">'; } $m = array(); $m = DB::table('usersEkMail')->a('userId', "=", $b->d)->d(); return view("operasyon.operasyon_edit", ['talimat' => $b, "barcode" => $i, 'userlist' => $d, 'talimatList' => $w, 'ulkeList' => $h, 'ulke' => $l, "bolge" => $u, 'yetkiler' => $k, "altmodel" => $o, "allmaillist" => $m]); } function bj(Request $f) { \Helper::langSet(); $j = Auth::user()->a; $g = Auth::user()->b; $l = Session::get('locale'); $c = new \App\TalimatAltModel(); $h = $f->c("varisgumruk"); $e = 0; foreach ($h as $d => $i) { $b = $c->a("id", "=", $d)->j(); if (empty($i)) { $e++; } if ($g == "watcher" && $j != $b->d) { $k = "Unauthorised Area!. Please Contact Your Admin"; return view("layouts.error", ["islemAciklama" => $k]); } $c->a("id", "=", $d)->i(["varisGumruk" => $i]); } if (!empty($b) && $e == 0) { $a = new \App\TalimatModel(); $a->a("id", "=", $b->g)->i(["durum" => "bekleme"]); } if ($e > 0) { $a = new \App\TalimatModel(); $a->a("id", "=", $b->g)->i(["durum" => "firmabekleme"]); } if ($g == "watcher") { return redirect('/operation/continue'); } return redirect('/operasyon/goster/' . $b->g); } function i(Request $c) { $w = new \App\TalimatModel(); $e["firmaId"] = $c->c("firmaId"); $e["bolgeSecim"] = $c->c("bolgeSecim"); $e["note"] = $c->c("aciklama"); $e["cekiciPlaka"] = $c->c("cekiciPlaka"); $e["dorsePlaka"] = $c->c("dorsePlaka"); $e["autoBarcode"] = $c->c("autoBarcode"); if (empty($c->c("gumrukAdedi"))) { $m = 1; } else { $m = $c->c("gumrukAdedi"); } if (empty($c->c("firmaId"))) { $f = $c->c("externalFirma"); } else { $f = $c->c("firmaId"); } $e["gumrukAdedi"] = $m; $e["deleted"] = "no"; $w->a("id", '=', $c->c("talimatId"))->i($e); $k = $c->c("talimatId"); $f = $c->c("firmaId"); $q = $c->c("yuklemeNoktasiAdet"); $j = $c->c("varisGumruk"); $s = $c->c("yuklemeNoktasi"); $n = $c->c("yuklemeNoktasiulkekodu"); $o = $c->c("indirmeNoktasi"); $aa = $c->c("indirmeNoktasiulkekodu"); $z = $c->c("tekKap"); $y = $c->c("tekKilo"); $x = $c->c("yukcinsi"); $ad = $c->c("faturacinsi"); $i = $c->c("faturanumara"); $v = $c->c("faturabedeli"); $u = $c->c("mrnnumber"); $t = $c->c("tirnumarasi"); $d = array(); $ab = 0; foreach ($q as $b => $r) { for ($a = 0; $a < $r[0]; $a++) { if (empty($j[$b][$a])) { $ab++; } $d[$b][$a]["talimatId"] = $k; $d[$b][$a]["gumrukId"] = intval($b); $d[$b][$a]["gumrukSira"] = $a + 1; $d[$b][$a]["varisGumruk"] = $j[$b][$a]; $d[$b][$a]["yuklemeNoktasi"] = $s[$b][$a]; $d[$b][$a]["yuklemeNoktasiulkekodu"] = $n[$b][$a]; $d[$b][$a]["indirmeNoktasi"] = $o[$b][$a]; $d[$b][$a]["indirmeNoktasiulkekodu"] = $aa[$b][$a]; $d[$b][$a]["talimatTipi"] = $c->c("talimatTipi"); $d[$b][$a]["tekKap"] = $z[$b][$a]; $d[$b][$a]["tekKilo"] = $y[$b][$a]; $d[$b][$a]["yukcinsi"] = $x[$b][$a]; $d[$b][$a]["tirnumarasi"] = $t[$b][$a]; if (!empty($i[$b][$a])) { $d[$b][$a]["faturanumara"] = $i[$b][$a]; } else { $d[$b][$a]["faturanumara"] = $c->c("autoBarcode"); } $d[$b][$a]["faturabedeli"] = $v[$b][$a]; $d[$b][$a]["mrnnumber"] = $u[$b][$a]; $d[$b][$a]["deleted"] = "no"; $d[$b][$a]["firmaId"] = $f; } } $h = new \App\TalimatAltModel(); $h->a("talimatId", '=', $k)->bk(); $g = array(); $l = 0; foreach ($d as $ae => $p) { foreach ($p as $af => $ac) { $g[$l] = $ac; $l++; } } $h->r($g); return redirect('/operasyon/goster/' . $k); } function bl($f) { \Helper::langSet(); $l = Auth::user()->a; $k = Auth::user()->b; $d = Session::get('locale'); if ($d == null) { $d = 'tr'; } $g = new \App\TalimatModel(); $h = $g->f(['User', 'Bolge', 'Ilgili', 'AltModel'])->a('deleted', '=', 'no')->a('id', '=', $f); if ($k != "admin") { } $a = $h->j(); $b = ""; $e = new \Picqer\Barcode\BarcodeGeneratorPNG(); if (!empty($a->c)) { $b = '<img src="data:image/png;base64,' . base64_encode($e->ad($a->c, $e::TYPE_CODE_128)) . '">'; } $i = DB::table('ulkeKod')->d(); $c = array(); foreach ($i as $m => $j) { $c[$j->a] = $j->j; } if ($a->w == 'bondeshortie') { return view("operasyon.operasyon_bondieprint", ['talimat' => $a, "barcode" => $b, 'ulke' => $c]); } else { return view("operasyon.operasyon_print", ['talimat' => $a, "barcode" => $b, 'ulke' => $c]); } } function ar($b) { $e = new \App\TalimatModel(); $e->a("id", "=", $b)->i(["durum" => "tamamlandi"]); $g = $e->ap($b); $n = new \App\User(); $m = $n->ap($g->d); $d = $m->e; $a = $m->ax; $i = trans("messages.cekiciplaka") . " : " . $g->i . "- " . trans("messages.dorseplaka") . " : " . $g->h; $j = trans('messages.newtalimat') . " " . $i; $l = " <br/> <a href='http://interbos.bosphoregroup.com/dosya/indirfull/" . md5($b) . "'>" . trans('messages.talimatevrakyuklemebaslik') . " " . trans("messages.tumunuindir") . "</a>"; $k = new \App\UserSenderMailListModel(); $f = $k->a("talimatId", "=", $b)->d(); $c = array(); if (!empty($f)) { foreach ($f as $q => $p) { $c[] = $p->av; } } if (!empty($c)) { $h = $i . " " . trans("messages.operasyon") . " " . trans("messages.kaydedilmis"); $o = $h . " " . $l; \Mail::to($a)->an(['interbos@bosphoregroup.com', 'interbos@creaception.com', 'serhat@bosphoregroup.com'])->br($c)->ao(new InfoMailEvery($d, $a, $h, $o, "nonstandart")); } else { \Mail::to($a)->an(['interbos@bosphoregroup.com', 'interbos@creaception.com', 'serhat@bosphoregroup.com'])->ao(new InfoMailEvery($d, $a, $j, $l . "<br />" . $i)); } return redirect('/operation/done'); } function bq($e) { $d = new Spreadsheet(); $a = $d->aj(); $a->b('A1', trans("messages.gumrukno")); $a->b('B1', trans("messages.gonderici")); $a->b('C1', trans("messages.ulkekodu")); $a->b('D1', trans("messages.alici")); $a->b('E1', trans("messages.ulkekodu")); $a->b('F1', trans("messages.kap")); $a->b('G1', trans("messages.kilo")); $a->b('H1', trans("messages.yukcinsi")); $a->b('I1', trans("messages.faturanumara")); $a->b('J1', trans("messages.faturabedeli")); $h = new \App\TalimatModel(); $f = DB::table("talimatparametre")->a("talimatId", "=", $e)->d(); $b = 2; foreach ($f as $i => $c) { $a->b('A' . $b, $c->au); $a->b('B' . $b, $c->at); $a->b('C' . $b, $c->x); $a->b('D' . $b, $c->ar); $a->b('E' . $b, $c->x); $a->b('F' . $b, $c->aq); $a->b('G' . $b, $c->ap); $a->b('H' . $b, $c->ao); $a->b('I' . $b, $c->al); $a->b('J' . $b, $c->am); $b++; } $g = new Xlsx($d); header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); header('Content-Disposition: attachment; filename="file.xlsx"'); $g->q("php://output"); } function bp($b) { $c = Auth::user()->a; $a = Auth::user()->b; $d = new \App\TalimatModel(); if ($a != 'admin' && $a != 'bolgeadmin' && $a != 'watcher') { return view("layouts.error", ['islemAciklama' => trans('messages.izinsizaalan')]); } return view("layouts.upload", ["id" => $b]); } function bo(Request $a) { $i = $a->c("talimatId"); $c = ""; if (!empty($a->n('files'))) { $f = new \App\musteriEvrak(); $b = $a->n('files'); $g = \Carbon\Carbon::now('utc')->s(); $d = 0; foreach ($b as $e => $k) { $h[$d] = array('talimatId' => $i, "fileName" => Storage::disk('public')->v('files', $b[$e]), "filetype" => $b[$e]->aq(), "deleted" => 'no', 'created_at' => $g, 'updated_at' => $g); $d++; } $f->r($h); $c = $c . " (" . $d . ") " . trans('messages.dosya'); } $j = $c . " " . trans("messages.evraksuccess"); return view("layouts.success", ['islemAciklama' => $j]); } function bn(Request $c) { $k = $c->c("talimatId"); $f = ""; if (!empty($c->n('files'))) { $g = new \App\musteriEvrak(); $a = $c->n('files'); $h = \Carbon\Carbon::now('utc')->s(); $d = 0; foreach ($a as $b => $j) { $e[$d] = array('talimatId' => $k, "fileName" => Storage::disk('public')->v('files', $a[$b]), "filetype" => $a[$b]->al(), "filerealname" => $a[$b]->ak(), "belgetipi" => "toplu", "deleted" => 'no', 'created_at' => $h, 'updated_at' => $h); $d++; } $g->r($e); $f = $f . " (" . $d . ") " . trans('messages.dosya'); } if (!empty($c->n('specialfiles'))) { $g = new \App\musteriEvrak(); $a = $c->n('specialfiles'); $h = \Carbon\Carbon::now('utc')->s(); $d = 0; $e = array(); foreach ($a as $b => $j) { foreach ($j as $i => $l) { $e[$d] = array('talimatId' => $k, "fileName" => Storage::disk('public')->v('files', $a[$b][$i]), "filetype" => $a[$b][$i]->al(), "filerealname" => $a[$b][$i]->ak(), "belgetipi" => $b, "deleted" => 'no', 'created_at' => $h, 'updated_at' => $h); $d++; } } $g->r($e); $f = $f . " (" . $d . ") " . trans('messages.dosya'); } return redirect('/operasyon/goster/' . $k); } function bm($a, $b = 1) { return view("talimat.dosya", ["kac" => $a, "adet" => $b]); } function bg($e) { $f = new \App\TalimatModel(); $d = $f->f(['User', 'Evrak'])->a('deleted', '=', 'no')->a('id', '=', $e)->j(); $c = storage_path($d->c . "-" . str_slug($d->v->e) . ".zip"); $a = new ZipArchive(); if ($a->x($c, ZipArchive::CREATE | ZipArchive::OVERWRITE)) { foreach ($d->ak as $b) { if ($a->y("../public/uploads/" . $b->n, $b->g . "-" . ($b->r + 1) . "-" . ($b->s + 1) . "-" . $b->t . "-" . $b->u)) { continue; } else { throw new Exception("file `{$b}` could not be added to the zip file: " . $a->l()); } } if ($a->z()) { return response()->aa($c, basename($c))->ac(true); } else { throw new Exception("could not close zip file: " . $a->l()); } } else { throw new Exception("zip file could not be created: " . $a->l()); } } function be() { $d = new \App\musteriEvrak(); $e = $d->o("id", \Request::input("item"))->d(); $c = storage_path(str_slug("file" . \Carbon\Carbon::parse("now")) . ".zip"); $a = new ZipArchive(); if ($a->x($c, ZipArchive::CREATE | ZipArchive::OVERWRITE)) { foreach ($e as $b) { if ($a->y("../public/uploads/" . $b->n, $b->g . "-" . ($b->r + 1) . "-" . ($b->s + 1) . "-" . $b->t . "-" . $b->u)) { continue; } else { throw new Exception("file `{$b}` could not be added to the zip file: " . $a->l()); } } if ($a->z()) { return response()->aa($c, basename($c))->ac(true); } else { throw new Exception("could not close zip file: " . $a->l()); } } else { throw new Exception("zip file could not be created: " . $a->l()); } } function au($d) { \Helper::langSet(); $i = Auth::user()->a; $n = Auth::user()->b; $c = Session::get('locale'); if ($c == null) { $c = 'tr'; } $f = new \App\TalimatModel(); $f->a('id', '=', $d)->i(['yeniTalimatMi' => 'no']); $m = $f->f(['User', 'Bolge', 'Ilgili', 'AltModel'])->a('deleted', '=', 'no')->a('id', '=', $d); $g = $m->j(); $h = array(); foreach ($g->m as $e => $a) { $h[$a->z][] = $a; } if ($n == "watcher" && $i != $g->d) { $t = "Unauthorised Area!. Please Contact Your Admin"; return view("layouts.error", ["islemAciklama" => $t]); } $r = DB::table('talimatTipi')->a('dil', '=', $c)->d(); $s = DB::table('bolge')->d(); $p = new \App\UlkeKodModel(); $k = $p->g("siralama", "ASC")->d(); $l = array(); foreach ($k as $e => $a) { $l[$a->a] = $a->j; } $q = new \App\User(); $b = $q->p('id', 'name')->a('deleted', '=', 'no')->a('role', '=', 'watcher')->d(); $b = json_decode($b, true); $j = array(); if ($n != 'admin') { $o = DB::table("yetkiler")->p("talimatType")->a("userId", "=", $i)->d(); foreach ($o as $e => $a) { $j[] = $a->f; } } $v = new \Picqer\Barcode\BarcodeGeneratorPNG(); $u = intval(substr(md5(rand(1264, 987654321) . microtime() . rand(1264, 987654321)), 0, 8), 16); return view("operasyon.operasyon_ext1t2", ['talimat' => $g, "barcode" => $u, 'userlist' => $b, 'talimatList' => $r, 'ulkeList' => $k, 'ulke' => $l, "bolge" => $s, 'yetkiler' => $j, "altmodel" => $h]); } function bc($o = "", $v = "") { \Helper::langSet(); $y = DB::table('ulkeKod')->d(); $x = array(); foreach ($y as $e => $c) { $x[$c->a] = $c->j; } $j = new Spreadsheet(); $a = $j->aj(); if (!empty($o)) { $k = $o . " 00:00:00"; } else { $k = date("Y-m-d") . " 00:00:00"; } if (!empty($v)) { $g = $v . " 23:59:59"; } else { $g = date("Y-m-d") . " 23:59:59"; } $d = new \App\TalimatModel(); $aa = Auth::user()->b; if ($aa == "muhasebeadmin") { $w = DB::table("muhasebeBolge")->a("userid", "=", Auth::user()->a)->d(); $l = array(); foreach ($w as $e => $c) { $l[] = $c->k; } $d = $d->o("bolgeSecim", $l); } $d = $d->av("created_at", [$k, $g])->f(["AltModel", "User", "Ilgili", "Ilgilikayit", "Bolge"])->g("firmaId", "ASC"); $s = $d->d(); $h = array(); $u = ['font' => ['size' => 16, 'bold' => true, 'color' => ['argb' => 'FF25AAE2']]]; $t = ['font' => ['size' => 14, 'bold' => true, 'color' => ['argb' => 'FF25AAE2']]]; $ab = ['font' => ['size' => 13, 'bold' => true, 'color' => ['argb' => 'FF7A0000']]]; $q = ['font' => ['size' => 13, 'bold' => true, 'color' => ['argb' => 'FF000000']]]; foreach ($s as $e => $c) { $h[$c->ae->e][] = $c; } foreach (range('A', 'Z') as $r) { $a->aw($r)->at(true); } $a->af('A1:I1')->b('A1', trans("messages.ihracataracgiris") . " - " . $k . " " . $g)->ah('A1:I1')->ab($u); $b = 2; foreach ($h as $e => $p) { $n = 0; $m = 0; $a->af('A' . $b . ':I' . $b)->b('A' . $b, trans("messages.bolgehangisi") . " - " . $e)->ah('A' . $b . ':L' . $b)->ab($t); $b++; $a->b('B' . $b, trans("messages.sirano")); $a->b('B' . $b, trans("messages.companyname")); $a->b('C' . $b, trans("messages.autoBarcode")); $a->b('D' . $b, trans("messages.createddate")); $a->b('E' . $b, trans("messages.talimattipi")); $a->b('F' . $b, trans("messages.cekiciplaka")); $a->b('G' . $b, trans("messages.dorseplaka")); $a->b('H' . $b, trans("messages.kayitilgilenen")); $a->b('I' . $b, trans("messages.islemilgilenen")); $a->b('J' . $b, trans("messages.talimatdurumu")); $a->b('K' . $b, trans("messages.gumrukadet")); $a->b('L' . $b, trans("messages.alicigondericiadet")); $a->ah('A' . $b . ':L' . $b)->ab($q); $b++; $f = 0; foreach ($p as $e => $c) { $f++; $a->b('A' . $b, $f); $a->b('B' . $b, $c->v->e); $a->b('C' . $b, $c->c); $a->b('D' . $b, \Carbon\Carbon::parse($c->ad)->ba('d-m-Y H:i')); $a->b('E' . $b, trans("messages." . $c->w)); $a->b('F' . $b, $c->i); $a->b('G' . $b, $c->h); $a->b('H' . $b, $c->ac->e); if (!empty($c->y->e)) { $i = $c->y->e; } else { $i = ""; } $a->b('I' . $b, $i); $a->b('J' . $b, trans("messages." . $c->q)); $a->b('K' . $b, $c->l); $a->b('L' . $b, $c->m->ai()); $m += $c->m->ai(); $n += $c->l; $b++; } $a->af('A' . $b . ':L' . $b)->b('A' . $b, " "); $b++; $a->b('E' . $b, trans("messages.toplam") . " " . trans("messages.gumruktalimatiheader")); $a->b('F' . $b, $f); $a->b('G' . $b, trans("messages.toplam") . " " . trans("messages.operasyon")); $a->b('H' . $b, $f); $a->b('I' . $b, trans("messages.toplam") . " " . trans("messages.gumrukadet")); $a->b('J' . $b, $n); $a->b('K' . $b, trans("messages.toplam") . " " . trans("messages.alicigondericiadet")); $a->b('L' . $b, $m); $b++; } $z = new Xlsx($j); header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); header('Content-Disposition: attachment; filename="' . date("d-m-Y H:i:s") . '-file.xlsx"'); $z->q("php://output"); } function bs($e) { $f = new \App\musteriEvrak(); $d = $f->a(DB::raw("md5(talimatId)"), $e)->d(); if ($d->ai() > 0) { $c = storage_path(str_slug("file" . \Carbon\Carbon::parse("now")) . ".zip"); $a = new ZipArchive(); if ($a->x($c, ZipArchive::CREATE | ZipArchive::OVERWRITE)) { foreach ($d as $b) { if ($a->y("../public/uploads/" . $b->n, $b->g . "-" . ($b->r + 1) . "-" . ($b->s + 1) . "-" . $b->t . "-" . $b->u)) { continue; } else { throw new Exception("file `{$b}` could not be added to the zip file: " . $a->l()); } } if ($a->z()) { return response()->aa($c, basename($c))->ac(true); } else { throw new Exception("could not close zip file: " . $a->l()); } } else { throw new Exception("zip file could not be created: " . $a->l()); } } else { return trans("messages.dosyayok"); } } }
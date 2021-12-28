<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="author" content="">
  <title>Bosphore GROUP - Yönetim Sayfası</title>
  <!-- Bootstrap core CSS-->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/css/sb-admin.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet">

  @yield('scripts')
  <style type="text/css">
  #backermer{background: url(/img/backme.png) no-repeat; background-position:bottom right;  background-repeat: no-repeat;}
  body{font-family:'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:1.1em;}

  .bg-ozel{background: #3c8dbc;color:#FFF;}
  .bg-ozel>a{color:#FFF;}
  #mainNav .navbar-brand {

    width: 238px;
    height: 55px;
    margin-top: -5px !important;

}
  </style>
</head>

<body class="fixed-nav sticky-footer" id="page-top">
  <!-- Navigation-->

    <nav class="navbar navbar-expand-lg  navbar-dark bg-ozel fixed-top" id="mainNav" >
     <a class="navbar-brand" href="{{ url('/') }}" style="background: #357ca5;">
     	<img src='/img/logo-b.png' class='img-fluid mr-5'/>
     	<span class='ml-5 pt-4'>BOSPHORE GROUP Yönetim Paneli</span>
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive" style=''>
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="{{ url('/') }}">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Anasayfa</span>
          </a>
        </li>


            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Muhasebe">
              <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMuhasebe" data-parent="#exampleAccordion">
                <i class="fa fa-fw fa-area-chart"></i>
                <span class="nav-link-text">Muhasebe Bölümü</span>
              </a>
              <ul class="sidenav-second-level collapse" id="collapseMuhasebe">
                <li>
                  <a href="{{ url('/muhasebe') }}">Ödemeler Listesi</a>
                </li>
                 @if (\Auth::user()->role=='admin')
                    <li>
                      <a href="{{ url('/muhasebe/yeni') }}">Ödeme Oluşturma</a>
                    </li>
                @endif
              </ul>
            </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gümrük">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Gümrük İşlemleri</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="{{ url('/talimat') }}">Talimat Listesi</a>
            </li>
            <li>
              <a href="{{ url('/talimat/yeni') }}">Talimat Oluşturma</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Sistem Yöneticisine Mesaj</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a href="{{ url('/mesaj') }}">Mesajları Listele</a>
            </li>
            <li>
              <a href="{{ url('/mesaj/yeni') }}">Yeni Mesaj Gönder</a>
            </li>

          </ul>
        </li>
    	 @if (\Auth::user()->role=='admin')

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUser" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Kullanıcılar</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseUser">
            <li>
              <a href="{{ url('/users/list') }}">Kullanıcıları Listele</a>
            </li>
            <li>
              <a href="{{ url('/users/add') }}">Yeni Kullanıcı</a>
            </li>

          </ul>
        </li>
         @elseif (\Auth::user()->role=='watcher')
         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="/users/edit/{{\Auth::user()->id}}">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Bilgilerimi Düzenle</span>
          </a>
        </li>

        @endif


        {{--

                 <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="/users/list/">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Kullanıcılar</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-link"></i>
            <span class="nav-link-text">Dışarı Bağlantısı</span>
          </a>
        </li>
        --}}
      </ul>


      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">

             {!! Helper::getNewMessage() !!}

        </li>
        <li class="nav-item dropdown">
			{!! Helper::getAllNotification() !!}
        </li>
       <!--
        <li class="nav-item">

          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Belgelerde Hızlı Arama...">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>

        </li>
        -->
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Güvenli Çıkış</a>
        </li>
      </ul>
    </div>
  </nav>


<!--  Navigation End -->
  <div class="content-wrapper"  id='backermer'>
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">Anasayfa</a>
        </li>
        <li class="breadcrumb-item active">@yield('kirinti')</li>
      </ol>
      <div class="row">
        <div class="col-12">
           @yield('content')
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © {Bosphore GROUP} 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Çıkış Yapılsın mı?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">"Güvenli Çıkışa" Basarak Oturumunuzu Sonlandırabilirsiniz.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">İptal Et</button>
                		  	<a class="btn btn-primary" href="{{ route('logout') }}"   onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Güvenli Çıkış</a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>

    @yield('endscripts')

  </div>
</body>

</html>

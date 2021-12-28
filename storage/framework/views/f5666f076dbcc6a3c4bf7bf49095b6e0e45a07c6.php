<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <title><?php echo e(trans('messages.pagetitle')); ?> - v.1.0.12</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/70134b03ec.js"></script>
    <script src="/assets/js/require.min.js"></script>
    <script>
      requirejs.config({
          baseUrl: 'http://gumruk.iskontrol.com'
      });
    </script>
    <script src="//code.jquery.com/jquery-3.3.1.js"  ></script>
    <!-- Dashboard Core -->
    <link href="/assets/css/dashboard.css" rel="stylesheet" />
    <script src="/assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="/assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="/assets/plugins/input-mask/plugin.js"></script>


    <?php echo $__env->yieldContent('scripts'); ?>
    <style>
      .nav-tabs .nav-link {color: rgba(0,0,0,.8) !important;}
      .dropdown-item {color: rgba(0,0,0,.8) !important;}
      .table th, .text-wrap table th{color:#000 !important;}
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->

  </head>
  <body class="">
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-136510370-2');
    </script>
    <div class="page    bg-white text-dark">
      <div class="page-main">
        <div class="header py-4">
          <div class="container-fluid">
            <div class="d-flex">
              <a class="header-brand" href="/">
                <img src="https://www.nar10.com/wp-content/uploads/2019/06/nar10com123.png" class="header-brand-img" alt="tabler logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">

                <div class="dropdown d-none d-md-flex">
                  <a class="nav-link icon h-50" data-toggle="dropdown">
                    <i class="fe fe-mail"></i>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <?php echo Helper::getNewMessage(); ?>

                  </div>
                </div>


                <div class="dropdown d-none d-md-flex">
                  <a class="nav-link icon h-50" data-toggle="dropdown">
                    <i class="fe fe-bell"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <?php echo Helper::getAllNotification(); ?>

                  </div>
                </div>
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(./uploads/<?php echo e(Auth::user()->photo); ?>)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php echo e(Auth::user()->name); ?></span>
                      <small class="text-muted d-block mt-1"><?php echo e(Auth::user()->role); ?></small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="/users/edit/<?php echo e(Auth::user()->id); ?>">
                      <i class="dropdown-icon fe fe-user"></i> <?php echo e(trans('messages.usercontrolmy')); ?>

                    </a>
                    <a class="dropdown-item" href="/mesaj">
                      <i class="dropdown-icon fe fe-mail"></i> <?php echo e(trans('messages.mailbox')); ?>

                    </a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item"  onclick="event.preventDefault();document.getElementById('logout-form').submit();">  <i class="dropdown-icon fe fe-log-out"></i> <?php echo e(trans('messages.logout')); ?></a>
                       <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>

                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">

                  <li class="nav-item">
                    <a href="/" class="nav-link"><i class="fe fe-home"></i> <?php echo e(trans('messages.mainpage')); ?></a>
                  </li>
                  <?php if(\Auth::user()->role!='muhasebeadmin' && \Auth::user()->role!='watcher' && \Auth::user()->role!='nakitadmin'): ?>
                  <li class="nav-item">

                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-truck" aria-hidden="true"></i> <span><?php echo e(trans('messages.gumruktalimatiheader')); ?></span></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?php echo e(url('/ihracat/arac/new')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.gumruktalimatiheader')); ?></a>
                    </div>

                  </li>
                  <?php endif; ?>
                  <?php if(\Auth::user()->role=='admin' || \Auth::user()->role=='bolgeadmin' || \Auth::user()->role=="watcher"): ?>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-handshake-o" aria-hidden="true"></i> <span><?php echo e(trans('messages.operasyon')); ?></span></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?php echo e(url('/ihracat/operasyon/list')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.operasyonlist')); ?></a>
                      <a href="<?php echo e(url('/ihracat/operasyon/listdone')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.operasyontamam')); ?></a>
                    </div>
                  </li>
                  <?php endif; ?>
                  <?php if(\Auth::user()->role=='admin' || \Auth::user()->role=='muhasebeadmin' || \Auth::user()->role=="watcher"): ?>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-university" aria-hidden="true"></i> <span><?php echo e(trans('messages.muhasebeheader')); ?></span></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?php echo e(url('/muhasebe')); ?>" class="dropdown-item "><i class="fa fa-money"></i><?php echo e(trans('messages.muhasebelist')); ?></a>
                      <?php if(\Auth::user()->role=='admin' || \Auth::user()->role=='muhasebeadmin' ): ?>
                      <!--  <a href="<?php echo e(url('/muhasebe/yeni')); ?>" class="dropdown-item "><i class="fa fa-money"></i><?php echo e(trans('messages.muhasebenew')); ?></a> -->
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(url('/muhasebe/new/ozelfiyatolusturma')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.muhasebefiyatlama')); ?></a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(url('/muhasebe/kapalifatura')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.kapanmisfatura')); ?></a>
                        <a href="<?php echo e(url('/muhasebe/acikfatura')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.acikfatura')); ?></a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(url('/muhasebe/nakitraporlama')); ?>" class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.nakitraporlama')); ?></a>
                        <?php endif; ?>
                    </div>
                  </li>
                  <?php endif; ?>
                  <?php if(\Auth::user()->role!='nakitadmin'): ?>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-users" aria-hidden="true"></i> <span><?php echo e(trans('messages.usercontrolheader')); ?></span></a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <?php if(\Auth::user()->role=='admin'): ?>
                      <a href="<?php echo e(url('/users/list')); ?>"  class="dropdown-item "><i class="fa fa-circle-o"></i> <?php echo e(trans('messages.usercontrollist')); ?></a>
                      <a  href="/users/add"  class="dropdown-item "><i class="fa fa-circle-o"></i> <?php echo e(trans('messages.newuser')); ?></a>
                      <div class="dropdown-divider"></div>
                      <a href="<?php echo e(url('/admins/new')); ?>"  class="dropdown-item "><i class="fa fa-circle-o"></i> <?php echo e(trans('messages.adminnew')); ?></a>
                      <a href="<?php echo e(url('/admins/list')); ?>"  class="dropdown-item "><i class="fa fa-circle-o"></i> <?php echo e(trans('messages.adminlist')); ?></a>
                      <div class="dropdown-divider"></div>
                      <?php endif; ?>
                      <a href="/users/edit/<?php echo e(\Auth::user()->id); ?>"  class="dropdown-item "><i class="fa fa-circle-o"></i><?php echo e(trans('messages.usercontrolmy')); ?></a>
                    </div>
                  </li>
                  <?php endif; ?>
                  <li class="nav-item">
                  <a href="/mesaj" class="nav-link">
                    <i class="fa fa-envelope"></i> <span><?php echo e(trans('messages.mailbox')); ?></span>
                  </a>
                  </li>
                  <?php if(\Auth::user()->role=='watcher'): ?>
                    <?php if(Helper::userUndoneJobs()>0): ?>
                      <li class="nav-item">
                          <a href="<?php echo e(url('/operation/continue')); ?>"  class="btn btn-danger"><span class=""><i class="fa fa-list-alt" aria-hidden="true"></i>
                            <?php echo Helper::userUndoneJobs(); ?> <?php echo e(trans('messages.operasyonmecburi')); ?></a>
                      </li>
                    <?php endif; ?>
                  <?php endif; ?>
                  <?php if(\Auth::user()->role=='admin'): ?>
                    <li class="nav-item">
                          <a href="<?php echo e(url('/muhasebe/raporlama')); ?>" class="nav-link"><i class="fa fa-list-alt" aria-hidden="true"></i>
<?php echo e(trans('messages.raporlama')); ?></a>
                    </li>
                    <li class="nav-item">
                      <a href="javascript:void(0)" data-t="" class="nav-link" id='checkDateForCash'><i class="fa fa-money" aria-hidden="true"></i>
<?php echo e(trans('messages.nakit')); ?> <?php echo e(trans('messages.raporlama')); ?></a>
                    </li>
                  <?php endif; ?>
                    <?php if(\Auth::user()->role=='nakitadmin' || \Auth::user()->role=='admin'): ?>
                      <li class="nav-item">
                        <a href="/gunsonuraporu" data-t="" class="nav-link" id=''><i class="fa fa-list-ul" aria-hidden="true"></i><?php echo e(trans('messages.gunsonuraporlama')); ?></a>
                      </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->role=='admin'  || \Auth::user()->role=='muhasebeadmin'): ?>
                      <li class="nav-item">
                        <a href="javascript:void(0)" data-t="" class="nav-link" id='checkDateForOperation'><i class="fa fa-truck" aria-hidden="true"></i>
                            <?php echo e(trans('messages.operasyon')); ?> <?php echo e(trans('messages.raporlama')); ?></a>
                      </li>
                    <?php endif; ?>

                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="my-3 p-2 my-md-5">
            <?php echo $__env->yieldContent('content'); ?>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <div class="col-auto">
                  <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li>
                    <li class="list-inline-item"><a href="./faq.html">FAQ</a></li>
                  </ul>
                </div>

              </div>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © 2018 - <?php echo date("Y"); ?>
            </div>
          </div>
        </div>
      </footer>


    </div>
      <?php echo $__env->yieldContent('endscripts'); ?>

      <script>

          require(['daterangepicker'], function() {

            $('#checkDateForCash').daterangepicker({
              "singleDatePicker": true,
          }, function(start, end, label) {
            window.location.href ='<?php echo e(url('/muhasebe/excelraporlama/')); ?>/'+start.format('YYYY-MM-DD');
          });

          $('#checkDateForOperation').daterangepicker({
        }, function(start, end, label) {
          window.location.href ='<?php echo e(url('/operationext/done')); ?>/'+start.format('YYYY-MM-DD')+"/"+end.format("YYYY-MM-DD");
        });

    });
      </script>
  </body>
</html>

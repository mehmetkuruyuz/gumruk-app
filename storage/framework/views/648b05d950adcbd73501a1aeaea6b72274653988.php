
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Bosphore GROUP - Yönetim Sayfası</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  </head>
  <body class="" onload="window.print()">
    <div class="page    bg-white text-dark">
      <div class="page-main">
        <div class="header py-4">
          <div class="container-fluid">


	<div class="card mb-3">
    <div class="card-header">
            <h2 class="text-center">BON DE SORTIE</h2>
    </div>
				<div class="card-body">
				<div class='row'>

					<div class='col-8'><i class="fa fa-table"></i> <span><?php echo e(trans('messages.createddate')); ?> : <?php echo e(\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')); ?> / <?php echo e(trans('messages.updateddate')); ?> : <?php echo e(\Carbon\Carbon::parse($talimat->updated_at)->format('d-m-Y H:i')); ?></span></div>
				</div>
					<div class="row mt-5">
            <div class="col-4 ">

               <div class="border" style="height:150px;">
                  Visa de la Douane
               </div>
            </div>
              <div class="col-8">
                  <table  class="table table-bordered" cellspacing="0">
                      <tr>
                        <td >
                          <?php echo e(trans("messages.talimatverenkullanici")); ?>

                        </td>
                        <td>
                          <?php echo e($talimat->user->name); ?>

                        </td>
                      </tr>
                      <tr>
                        <td>
                              <?php echo e(trans("messages.plaka")); ?>

                        </td>
                        <td>
                          <?php echo e($talimat->dorsePlaka); ?>

                        </td>
                      </tr>
                      <tr>
                        <td>
                            <?php echo e(trans("messages.createddate")); ?>

                        </td>
                        <td>
                          <?php echo e(\Carbon\Carbon::parse($talimat->created_at)->format('d-m-Y H:i')); ?>

                        </td>

                      </tr>
                  </table>
              </div>
            


		 				</div>
            <div class="col-12 text-center">
                  <img src='/img/0RRZ19.png' class="img-fluid w-50  mx-auto" />
            </div>
			 </div>

</div>
</div>
</div>
</div>
</body>
</html>

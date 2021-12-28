<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Iskontrol</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/flags.css">

  <style type="text/css">
    body{background: url("/img/cargo-ship-01.jpg") bottom left no-repeat;}
  </style>
</head>

<body class="bg-dark" >
  <div class="container"  >
  <?php echo Helper::helpme(); ?>

      <div class="card card col-md-5 col-xl-8 mx-auto mt-5">
      <div class="card-header"><?php echo e(trans('messages.loginheader')); ?></div>
      <div class="card-body">
			<form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>">
				<?php echo e(csrf_field()); ?>


				 	<div class="<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    	<div class="col-md-12 my-5">
                    		<img src='https://www.nar10.com/wp-content/uploads/2021/01/bannerson12.gif' class='img-fluid mx-auto'/>
                    	</div>
                     </div>
                     <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                            <label for="email" class="col-md-12 control-label"><?php echo e(trans('messages.loginemail')); ?></label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-12 control-label"><?php echo e(trans('messages.loginpassword')); ?></label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row px-5">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> <?php echo e(trans('messages.loginremember')); ?>

                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary"><?php echo e(trans('messages.loginenter')); ?></button>
                            </div>
                            
                        </div>

        </form>
        <div class="text-center">


        	  	<a href="/language/tr">
              		<img src="blank.gif" class="flag flag-tr" alt=""/>
            	</a>
        	  	<a href="/language/en" >
              		<img src="blank.gif" class="flag flag-us" alt=""  />
            	</a>
        	  	<a href="/language/de">
              		<img src="blank.gif" class="flag flag-de" alt=""  />
            	</a>
        	  	<a href="/language/fr">
              		<img src="blank.gif" class="flag flag-fr"  alt="" />
            	</a>
      </div>
    </div>
  </div>
    </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>

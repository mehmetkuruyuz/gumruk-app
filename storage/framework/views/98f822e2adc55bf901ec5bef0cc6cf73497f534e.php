

<?php $__env->startSection('kirinti'); ?>
	<?php echo e(trans("messages.talimatyenibaslik")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<style>
.gallery div{margin:5px;padding:5px;}
#myTab{font-size:0.9em;}
.easy-autocomplete{
  width:100% !important
}

.easy-autocomplete input{
  width: 100%;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('endscripts'); ?>

<script src="/assets/plugins/easyautocomplete.js"></script>

<script>


require(['select2'], function() {

		 $('#firmamaillist').select2();
});


var optionsAJAX = {

		  url: "/talimat/yukcinsi",


					  getValue:function(element) {
						    return element.name+" "+element.code;
					  },

					  list: {
					    match: {
					      enabled: true
					    }
					  },

					 // theme: "square"
					};


var options = {

		  url: "/talimat/gumruklistesi",

		  getValue:function(element) {
			    return element.name+" "+element.code;
		  },
		  list: {
		    match: {
		      enabled: true,
					caseSensitive: false,
		    }
		  },

		 // theme: "square"
		};




function formTemizle()
{

$(':input','.temizlenebilir')
.not(':button, :submit, :reset')
.val('')
.prop('checked', false)
.prop('selected', false);

}
//h

function openPr(t)
{

	if ($(t).val()=='no')
	{
		$(t).parent().children(".problemYazi").addClass('hidden');
	}
	else
	{
		$(t).parent().children(".problemYazi").removeClass('hidden');
	}

}


function noktalariBaslat(t,kacinci)
{
	var i;
	var adet=1;

	if ($(t).val()=='parsiyal') {adet=10}
	else {
		$(t).parent().children("div").children(".malYuklemeBosaltmaTablolari").children("tbody").empty();
		$(t).parent().children("div").children(".malYuklemeBosaltmaTablolari").children("tbody").append(''+
				'<tr>'+
	        	'<td>'+1+'</td>'+
	            '<td><input type="text" class="form-control" name="yuklemeNoktasi['+kacinci+'][]" required="required"/></td>'+
	            '<td><input type="text" class="form-control" name="indirmeNoktasi['+kacinci+'][]" required="required"/></td>'+
	            '<td><input type="text" class="form-control hesaplanacakKap" name="tekKap['+kacinci+'][]" required="required" onchange="hesaplaKapKilo('+kacinci+')"/></td>'+
	            '<td><input type="text" class="form-control  hesaplanacakKilo" name="tekKilo['+kacinci+'][]" required="required"  onchange="hesaplaKapKilo('+kacinci+')"/></td>'+

	         '</tr>'+
			+'');
	}
	$(t).parent().children("div").children(".yuklemeNoktasi").empty();

	for (i = 1; i <= adet; i++)
	{
		$(t).parent().children("div").children(".yuklemeNoktasi").append("<option value='"+i+"'>"+i+"</option>");
	}



}



function changeTalimatData(t)
{

	var data=$(t).val();
	$("#nmo").removeClass("d-none");
	$("#nmo").attr("disabled", false);

	$("#myTab").children().remove();
	$("#myTabContent").children().remove();

	switch (data) {
		case "ex1":
			//	console.log("Starting Ex1 Data....");
				$("#nmo").val("1");
				$("#nmo").attr("disabled", true);
				$("#nmo").addClass("d-none");


		break;
		default:

	}
	addTabData();
}


function noktalarIcinAlanOlustur(t,kacinci)
{
	var adet=$(t).val();
	var sample=$("#sampletr"+kacinci);
	var newsample;
	newsample=$(sample).html();
  //newsample=newsample.find('input').val('');
  var num = parseInt( newsample.match(/\d+/g), 10 );
  //alert(num);
	//$(sample).parent().children( 'tr:not(:first)' ).remove();

	$(sample).parent().children( 'tr:not(:first)' ).remove();
	for (i=1;i<adet;i++)
	{
		$(sample).parent().append("<tr>"+newsample+"</tr>");

	}




  	$(".varisGumruk").each(function( index )
    {
      num++;
      $(this).attr("id","each-"+num);
    });

		var rand=Math.floor(Math.random() * 100000000) + 1;
		$(".yukcinsi").each(function( index )
    {
      rand++;
      $(this).attr("id","each-"+rand);
    });

	var talimatTipi=$("#talimatTipi").val();
	 var firmaId=$("#firmaXixD").val();
	 muhasebeDataGetir(talimatTipi,firmaId);

	$(".varisGumruk").easyAutocomplete(options);
	$(".yukcinsi").easyAutocomplete(optionsAJAX);
	openFileModal(kacinci,adet);
}


function hesaplaKapKilo(kim)
{
	var toplamkilo=0;
	var toplamkap=0;

	$( "input[type=text][name='tekKap["+kim+"][]']" ).each(function( index ) {
		if (jQuery.type(parseInt($( this ).val()))=='number')
		{
			if (!isNaN(parseInt($( this ).val())))
			{
				toplamkap+=parseInt($( this ).val());
			}
		}
		});

	$( "input[type=text][name='tekKilo["+kim+"][]']"  ).each(function( index ) {
		if (jQuery.type(parseFloat($( this ).val()))=='number')
		{
			if (!isNaN(parseFloat($( this ).val())))
			{
				toplamkilo+=parseFloat($( this ).val());
			}
		}
		});

		$("input[type=text][name='kap["+kim+"]']").val(toplamkap);
		$("input[type=text][name='kilo["+kim+"]']").val(toplamkilo);
		//console.log('Toplam Kilo :'+toplamkilo);
		//console.log('Toplam Kap :'+toplamkap);
}








function karneBilgisiEkle(t)
{


	if ($(t).val()=='tir' || $(t).val()=='ata')
	{
		$(t).parent().children(".karnecik").removeClass('hidden');
	}else
	{
		$(t).parent().children(".karnecik").addClass('hidden');
	}

}



function getPlakaList()
{

		var firmaid=$("#firmaXixD").val();

	var options2 = {

				url: "/plakaliste/cekici/"+firmaid,
					getValue:function(element) {
						return element.plaka;
				},
					list: {
					match: {
						enabled: true
					}
				},
			};


		var options3 = {

					url: "/plakaliste/dorse/"+firmaid,
						getValue:function(element) {
							return element.plaka;
					},
						list: {
						match: {
							enabled: true
						}
					},
				};

		$("#cekiciPlaka").easyAutocomplete(options2);
		$("#dorsePlaka").easyAutocomplete(options3);

	$.get("/users/emaillist/"+firmaid, function(data, status){
		console.log(data.length);

		$("#firmamaillist").children().remove();
		if (data.length>0) {
				$("#firmamail").removeClass("d-none");
					$.each(data, function (index, value){
						$("#firmamaillist").append("<option value='"+value.emailAdres+"'>"+value.emailAdres+"</option>");
					});
			} else {$("#firmamail").addClass("d-none");}
	});

}



function gettalimatData(t)
{

	$.post("/talimat_new/talimattipfiyatgetir",
  {
		"_token": "<?php echo e(csrf_token()); ?>",
    firmaId:$("#firmaXixD").val(),
    talimatTipi:$(t).val()
  },
  function(data, status){
		if (data.faturatutari>0)
		{
			var price=data.faturatutari;
		}else {
			var price=0;
		}
		$(t).parent().parent().children(".faturabedel").children("input").val(price);

  });

}



function addTabData()
{

		var say=$("#nmo").val();
		var talimatTipi=$("#talimatTipi").val();
		var t;

		$("#myTab").children().remove();
			$("#myTabContent").children().remove();
			$("#myTabContent").html("");
		$.get("/arac/talimatgetir/"+talimatTipi+"/"+say,
	   function(data, status){
			 	$("#myTabContent").children().remove();
					$("#myTab").children().remove();
					$.each(data, function (index, value)
							 {
								 	$("#myTabContent").append(value);
									openFileModal((index-1),1);
								});
								for(t=1;t<=say;t++)
								{
										$("#myTab").append('<li class="nav-item"><a class="nav-link " id="linktab-'+t+'" data-toggle="tab" href="#tab-'+t+'" role="tab" aria-controls="tab'+t+'" aria-selected="false"> <?php echo e(trans("messages.gumruk")); ?> '+(t)+' </a>');
								}
								var firmaId=$("#firmaXixD").val();
								muhasebeDataGetir(talimatTipi,firmaId);
								$(".varisGumruk").easyAutocomplete(options);

								$(".yukcinsi").easyAutocomplete(optionsAJAX);

	   });





}
function muhasebeDataGetir(tip,firma)
{
		$.get("/muhasebe/fiyatgetir/"+tip+"/"+firma, function(data, status)
		{

			//	console.log(data);

		//		$("#fiyatlamagoster").children().remove();
		//		$("#fiyatlamagoster").append("<div class='alert alert-info'><?php echo e(trans('messages.birimfiyati')); ?> "+data.talimattipi+" "+data.fiyat+" "+data.fiyatbirim+"</div>");


			var say=$("#nmo").val();
			switch (tip) {
				case "t2":
						var ekstra=$(".kolaysay").length;
						$.get("/muhasebe/fiyatgetir/t2ek/"+firma, function(datax, statusx)	{

							$("#faturabedeli").val(data.fiyat*say+datax.fiyat*ekstra);
							if (data.fiyatbirim.length>1)
							{
							$("#moneytype").val(data.fiyatbirim);
							}
						});
					break;
					case "ex1":
						var ekstra=$(".kolaysay").length;

						$("#faturabedeli").val(data.fiyat*length);
						if (data.fiyatbirim.length>1)
						{
						$("#moneytype").val(data.fiyatbirim);
						}

					break;
				default:
					$("#faturabedeli").val(data.fiyat*say);
					if (data.fiyatbirim.length>1)
					{
					$("#moneytype").val(data.fiyatbirim);
				}
			}
				//console.log();
		});




}

function kontrolformtoaction()
{

	 var k=confirm('<?php echo e(trans("messages.formconfirm")); ?>');

	 var bolge=$("#bolgeSecim").val();
	 var userId=$("#firmaXixD").val();

	 var messages="";

	 if (bolge<1)	 { k=false; messages='<?php echo e(trans("messages.bolgehata")); ?>';}
	 if (userId<1) { k=false; messages='<?php echo e(trans("messages.kullanicihata")); ?>'; }
	 if (k==false) {alert(messages);}
     return k;
}


function openFileModal(kacinci,t)
{

	$.get("/dosya/getir/"+kacinci+"/"+t, function(data, status)
	{
			$("#evrakbolumu_"+kacinci).html(data);
	});



}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action='/arac/ihracat/save' method="post" name='a' id='actionFormElement' enctype="multipart/form-data"   onsubmit="return kontrolformtoaction()">
	<?php echo e(csrf_field()); ?>

      <div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>

       		<div class='col-md-12 border pt-5'>
       		<h2><?php echo e(trans("messages.ihracataracgiris")); ?></h2>
       		<br />
					<div class="row">
							<div class="col-md-4">
								<label for="autoBarcode"><?php echo e(trans("messages.autoBarcode")); ?></label>
								<input type='text' readonly name="autoBarcode" id="autoBarcode" value="<?php echo e($barcode); ?>" class="form-control" />
							</div>
							<div class="form-group col-md-4 temizlenebilir">
						<label for="bolgeSecim"><?php echo e(trans("messages.bolge")); ?></label>
						<?php if(\Auth::user()->role=="admin" || \Auth::user()->role=="bolgeadmin"): ?>
								<select name='bolgeSecim' class="form-control"  id="bolgeSecim" >
										<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
											<?php if(!empty($bolge)): ?>
												<?php $__currentLoopData = $bolge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value='<?php echo e($m->id); ?>'><?php echo e($m->name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
								</select>
						<?php else: ?>
							<?php if(!empty($bolge)): ?>
								<?php $__currentLoopData = $bolge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($m->id==\Auth::user()->bolgeId): ?>
										<br />
										<div class="alert alert-secondary  alert-md"> <?php echo e($m->name); ?> </div><?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
									<input type="hidden" value="<?php echo e(\Auth::user()->bolgeId); ?>" name="bolgeSecim"  id="bolgeSecim" />
						<?php endif; ?>
							</div>
					</div>
					 <br />
       		 <div class='row'>
           	 <?php if(\Auth::user()->role=='admin'  || \Auth::user()->role=="bolgeadmin"): ?>
           		<div class="form-group col-md-4">
							<label for="firmaId"><?php echo e(trans("messages.companyname")); ?></label>
           		<?php if(!empty($userlist)): ?>
           		<select name='firmaId' class="form-control"  id="firmaXixD" onchange="getPlakaList()" >
								<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
           			<?php $__currentLoopData = $userlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           				<option value='<?php echo e($m["id"]); ?>'><?php echo e($m["name"]); ?></option>
           			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           		</select>
           		<?php endif; ?>
         		 </div>
           	<?php else: ?>
           	   <div class="form-group col-md-4">
                  <label for="orderNo"><?php echo e(trans("messages.companyname")); ?></label>
                  <input type='hidden' name='firmaId' id="firmaXixD"  value='<?php echo e(\Auth::user()->id); ?>' />
                  <input type="text" disabled="disabled" value='<?php echo e(\Auth::user()->name); ?>' class="form-control" name='__firmaAdi' id="__firmaAdi" placeholder="Firma Adı">
           	  </div>
           	 <?php endif; ?>
						 <div class="form-group col-md-4 temizlenebilir d-none">
							 <label for="externalFirma"><?php echo e(trans("messages.companyname")); ?></label>
							 <input type="text" class="form-control" name='externalFirma' id="externalFirma" >
						 </div>
						 <div class="form-group col-md-4 temizlenebilir" id="firmamail">
							 		<label for="firmamail"><?php echo e(trans("messages.sendinguser")." ".trans("messages.moreemailadd")); ?></label>
									<select name="firmamaillist[]" id="firmamaillist" class="form-control" multiple="multiple">
										<option value="0">Hepsi</option>
									</select>
						</div>


           	  </div>

   						<div class='row'>
                  <div class="form-group col-md-4 temizlenebilir">
                <label for="cekiciPlaka"><?php echo e(trans("messages.cekiciplaka")); ?></label>
                    <input type="text" class="form-control" name='cekiciPlaka' id="cekiciPlaka">
                  </div>
									<div class="form-group col-md-4 temizlenebilir">
								<label for="dorsePlaka"><?php echo e(trans("messages.dorseplaka")); ?></label>
										<input type="text" class="form-control" name='dorsePlaka' id="dorsePlaka" placeholder="Dorse Çekici Plaka"  required="required">
									</div>
              </div>
							  <div class='row'>
						 <div class="form-group col-md-4 temizlenebilir">
								<label for=""><?php echo e(trans("messages.talimat")); ?></label>

								<?php if(!empty($talimatList)): ?>
									<select name='talimatTipi' class="form-control" id='talimatTipi' onchange='changeTalimatData(this)'>
										<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>

											 <?php $__currentLoopData = $talimatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											 	 <?php if(\Auth::user()->role!='admin'): ?>
													 <?php if(in_array($value->kisaKod, $yetkiler)): ?>
														 <option value="<?php echo e($value->kisaKod); ?>" ><?php echo e($value->kodName); ?></option>
													 <?php endif; ?>
												 <?php else: ?>
													 <option value="<?php echo e($value->kisaKod); ?>" ><?php echo e($value->kodName); ?></option>
							 					 <?php endif; ?>
											 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
								 <?php endif; ?>
							</div>
							<div class="form-group col-md-4 temizlenebilir">
								<label for="gumrukAdedi"><?php echo e(trans("messages.gumrukadet")); ?></label>
								<select name='gumrukAdedi' id='nmo' class="form-control d-none" onchange='addTabData()'>
									<option value='0'>(<?php echo e(trans("messages.choose")); ?>)</option>
									 <?php for($i = 1; $i < 11; $i++): ?>
										 <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
									 <?php endfor; ?>
								</select>
							</div>
			 				</div>
					 <div class='row'>

						</div>
            <div id='idXLKO'></div>
            	<ul class="nav nav-tabs" id="myTab">
               	<li class="nav-item">
									<a class="nav-link" id="bir-0" data-toggle="tab" href="#tab-0" role="tab" aria-controls="bir" aria-selected="false"> <?php echo e(trans("messages.gumruk")); ?> 1</a>
								</li>
              </ul>
              <div class="tab-content col-md-12 py-5  border-3" id="myTabContent" >

              </div>
              <br />


   		</div>
      <div class="col-md-12 border p-2">
			 <div class="form-group col-md-4 temizlenebilir">
				<h3><?php echo e(trans("messages.aciklama")); ?></h3>
        <textarea class="form-control" rows="6" name="aciklama"></textarea>
			</div>
      </div>
		</div>


		<div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
		<div class='col-md-12 border'>
			
		<h2><?php echo e(trans("messages.talimatevrakyuklemebaslik")); ?></h2>
		<br />
			<div class="form-group col-md-12">
									<label for="gallery-photo-add"><?php echo e(trans("messages.evrakyukle")); ?></label>
									<small><?php echo e(trans("messages.evrakyuklealt")); ?></small>
									<input type="file" name='files[]' class='form-control' multiple id="gallery-photo-add">
										<div id='dgalleryd' class="gallery"></div>
								</div>
		</div>

	</div>
		<div class='row' style='margin-left:2px;margin-top:4px;background: #FFF;'>
				<div class='col-md-12 border'>
					<div class="row">
							<div class="col-md-6">
								<h2><?php echo e(trans("messages.muhasebeheader")); ?></h2>
									<br />
										<div class="form-group col-md-12">
											<label for="kimyapmis"><?php echo e(trans("messages.kayityapanismi")); ?></label>
											<input type="text" name='kayitismi' class='form-control' value="<?php echo e(\Auth::user()->name); ?>" readonly="readonly" />
										</div>
										<div class="form-group col-md-12">
											<label for=""><?php echo e(trans("messages.faturabedel")); ?></label>
											<select name='odemecinsi' id='' class="form-control">
													 <option value="cari"><?php echo e(trans("messages.cariodeme")); ?></option>
													 <option value="nakit"><?php echo e(trans("messages.nakitodeme")); ?></option>
											</select>
										</div>
										<div class="form-group col-md-12">
											<label for=""><?php echo e(trans("messages.faturabedeli")); ?></label>
											<input type="text" name='talimatbedeli' class='form-control' id="faturabedeli" />
										</div>
										<div class="form-group col-md-12">
											<label for=""><?php echo e(trans("messages.parabirimi")); ?></label>
											<select name='moneytype' id="moneytype" class="form-control" >
													<option value='TL'>TL</option>
													<option value='EURO'>Euro</option>
													<option value='DOLAR'>Dolar</option>
													<option value='POUND'>Pound</option>
											</select>
										</div>
							</div>
							<div class="col-md-4 offset-md-2" id="fiyatlamagoster">


							</div>
					</div>


		</div>

	</div>




   </div>
	 <?php echo $__env->make('submits.forms', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</form>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(trans("messages.evrakyukle")); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="testerVX">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans("messages.close")); ?></button>
        <button type="button" class="btn btn-primary"><?php echo e(trans("messages.add")); ?></button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
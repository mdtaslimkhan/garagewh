@extends('layouts.app')
@section('content')
<style type='text/css'>
  .ui-datepicker-calendar,.ui-datepicker-month { display: none; }​
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle')}}</span></a>
					</div>
					 @include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('vehicle_view')				
					<li role="presentation" class=""><a href="{!! url('/vehicle/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle List')}}</a></li>
				@endcan

				@can('vehicle_add')
					<li role="presentation" class="active"><a href="{!! url('/vehicle/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Vehicle')}}</b></a></li>
				@endcan
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
					<div class="row">
										<div class="form-group" style="margin-top:20px;">
											<div class="my-form-group">
												<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle VIN')}} <label class="color-danger">*</label></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<input type="text"  name="VIN" autocomplete="off" placeholder="VIN" value=""  class="form-control vinnumber"/>
												</div>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<button class="btn btn-primary searchvin" >Search</button>
												</div>
												
											</div>
											</div>
										</div>
										<div class="row">
											<div class="vin-result">
											
												<div class="details">
												</div>

											</div>
										</div>
						
									</div>
								</div>
							</div>	
						</div>
					</div>
				<!-- End Model Name -->
				</div>
			</div>
		</div>
	</div>
	

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
		
    });
</script>


<!-- vehicle type -->
<script>
    $(document).ready(function(){

		$(".searchvin").on('click',function(){
			var vin = $('.vinnumber').val();
			console.log("vin "+ vin);
			var div = $('.vin-result');
			var op = "";
			$.ajax({
				type: 'get',
			//	url: '{!!URL::to('admin/showStudentInfo')!!}',
				url: 'https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/'+vin+'?format=json',
				async: false,
				data: {
				},
				dataType: 'json',
				success: function (data) {
					console.log(data.Results);
					var str = ["Make","Manufacturer Name", "Model", "Model Year", "Displacement (L)","Engine Model", "Trim", "Vehicle Descriptor","Fuel Type - Primary", "Series"];
								op += `
								<form id="vehicleAdd-Form" action="{{ url('/vehicle/store') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform vehicleAddForm">
									<input type="hidden" name="_token" value="{{csrf_token()}}">`;
					for(var s = 0; s < str.length; s++){
					
						for (var i = 0; i < data.Results.length; i++) {
							if(data.Results[i].Variable == str[s]){
								if(str[s] == "Model Year"){
								op += `
								<form id="vehicleAdd-Form" action="{{ url('/vehicle/store') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform vehicleAddForm">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group">
								<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Model Years')}} <label class="color-danger"></label></label>
										<div class="col-md-4 col-sm-4 col-xs-12 input-group">
											<input type="text"  name="modelyear" autocomplete="off" value="${data.Results[i].Value}"  class="form-control"/>
										</div>								
									</div>
								</div>`;
								}else if(str[s] == "Make"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="vehicabrand" autocomplete="off" placeholder="Brand" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Model"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Name')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Manufacturer Name"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Manufacturer')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Displacement (L)"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Engine Size')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Engine Model"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Engine')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Trim"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Trim')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Vehicle Descriptor"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model WMI/VDS/VIS')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Fuel Type - Primary"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Fuel Type')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>`;
								}else if(str[s] == "Series"){
									op += `<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Series')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  name="modelname" autocomplete="off" placeholder="modelname" value="${data.Results[i].Value}"  class="form-control"/>
											</div>
										</div>
									</div>
									
									`;
								}

									/* op += "<p><span>"+data.Results[i].Value+"</span> - ";
									op += "<span>"+data.Results[i].Variable+"</span></p>"; */
								}
							}
					}

					op += `
					<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Number Plate')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="number_plate"  value="{{ old('number_plate') }}" placeholder="{{ trans('app.Enter Number Plate')}}" maxlength="30" class="form-control">
									</div>
								</div>
					</div>
					<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Odometer Reading')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="odometerreading"  value="{{ old('number_plate') }}" placeholder="{{ trans('app.Enter Odometer Reading')}}" maxlength="30" class="form-control">
									</div>
								</div>
					</div>
					<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Odometer Transaxle')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="odometerreading"  value="{{ old('number_plate') }}" placeholder="{{ trans('app.Enter Transaxle')}}" maxlength="30" class="form-control">
									</div>
								</div>
					</div>
					</form>`;

					div.find('.details').html(" ");
					div.find('.details').append(op);
				},
				error: function () {

				}
				
			});
		})


		
		$('.vehicaltypeadd').click(function(){
			
		 	var vehical_type= $('.vehical_type').val();
		 	var url = $(this).attr('url');
        	
        	function define_variable()
			{
				return {
					vehicle_type_value: $('.vehical_type').val(),
					vehicle_type_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
		
			var call_var_vehicletypeadd = define_variable();		 

	        if(vehical_type == ""){
	            swal('Please enter vehicle type');
	        }
	        else if (!call_var_vehicletypeadd.vehicle_type_pattern.test(call_var_vehicletypeadd.vehicle_type_value))
			{
				$('.vehical_type').val("");
				swal('Please enter only alphanumeric data');
			}
	        else if(!vehical_type.replace(/\s/g, '').length){
				$('.vehical_type').val("");
	        	swal('Only blank space not allowed');
	        }
	        else{ 
				$.ajax({
					type:'GET',
					url:url,

		   			data :{vehical_type:vehical_type},

		   			//Form submit at a time only one for vehicleTypeAdd
		   			beforeSend : function () {
		 				$(".vehicaltypeadd").prop('disabled', true);
		 			},

		   			success:function(data)
		   			{
			   			var newd = $.trim(data);
				   
			   			var classname = 'del-'+newd;
				   
			   			if (newd == '01')
			   			{
				   			swal('Duplicate Data !!! Please try Another...');
			   			}
			   			else
			   			{
			   				$('.vehical_type_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_type+'</td><td class="text-center"><button type="button" vehicletypeid='+data+' deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button></a></td><tr>');
				   
							$('.select_vehicaltype').append('<option value='+data+'>'+vehical_type+'</option>');
							$('.vehical_type').val('');
					
							$('.vehical_id').append('<option value='+data+'>'+vehical_type+'</option>');
								$('.vehical_type').val('');
				   		}

				   		//Form submit at a time only one for vehicleTypeAdd
				   		$(".vehicaltypeadd").prop('disabled', false);
						return false;
			   		},
		 		});
			}
		});

	});
</script>

<!-- vehical Type delete-->
<script>
$(document).ready(function(){
	
	$('body').on('click','.deletevehicletype',function(){
		
		var vtypeid = $(this).attr('vehicletypeid');
		
		var url = $(this).attr('deletevehical');
		
		swal({
		     title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
					$.ajax({
							type:'GET',
							url:url,
							data:{vtypeid:vtypeid},
							success:function(data){
		
								$('.del-'+vtypeid).remove();
								$(".select_vehicaltype option[value="+vtypeid+"]").remove();
								swal("Done!","It was succesfully deleted!","success");
					}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
	
		});
	});
</script>


<!-- vehical brand -->
<script>
    $(document).ready(function(){
		
		$('.vehicalbrandadd').click(function(){
			 		
        	var vehical_id = $('.vehical_id').val();
			var vehical_brand= $('.vehical_brand').val();
			var url = $(this).attr('vehiclebrandurl');

			function define_variable()
			{
				return {
					vehicle_brand_value: $('.vehical_brand').val(),
					vehicle_brand_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
			
			var call_var_vehiclebrandadd = define_variable();		

			if ($("#vehicleTypeSelect")[0].selectedIndex <= 0) {

				swal('Please first select vehicle type');
			}
			else{
				if(vehical_brand == ""){
		            swal('Please enter vehicle brand');
		        }
		        else if (!call_var_vehiclebrandadd.vehicle_brand_pattern.test(call_var_vehiclebrandadd.vehicle_brand_value))
				{
					$('.vehical_brand').val("");
					swal('Please enter only alphanumeric data');

				}
		        else if(!vehical_brand.replace(/\s/g, '').length){
		       		// var str = "    ";
					$('.vehical_brand').val("");
		        	swal('Only blank space not allowed');
		        }
		        else{ 
					$.ajax({
				   		type:'GET',
				   		url:url,
	             
				   		data :{vehical_id:vehical_id, vehical_brand:vehical_brand},

				   		//Form submit at a time only one for vehicleBrandAdd
			   			beforeSend : function () {
			 				$(".vehicalbrandadd").prop('disabled', true);
			 			},

				   		success:function(data)
	               		{ 
				       		var newd = $.trim(data);
					   		var classname = 'del-'+newd;
	                  
				    		if (newd == "01")
				       		{
				 	     		swal('Duplicate Data !!! Please try Another...');
					   		}
					   		else
					   		{
						   		$('.vehical_brand_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_brand+'</td><td class="text-center"><button type="button" brandid='+data+' deletevehicalbrand="{!! url('vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button></a></td><tr>');
								
								$('.select_vehicalbrand').append('<option value='+data+'>'+vehical_brand+'</option>');
								
								$('.vehical_brand').val('');
							}

							//Form submit at a time only one for vehicleBrandAdd
							$(".vehicalbrandadd").prop('disabled', false);
							return false;
				   		},
				   
			 		});
				}
			}
		});
	});
</script>

<!-- vehical brand delete-->

	<script>
	$(document).ready(function(){
		$('body').on('click','.deletevehiclebrands',function(){
			
		var vbrandid = $(this).attr('brandid');
		var url = $(this).attr('deletevehicalbrand');
		swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {  
				$.ajax({
						type:'GET',
						url:url,
						data:{vbrandid:vbrandid},
						success:function(data){
							 $('.del-'+vbrandid).remove();
							 $(".select_vehicalbrand option[value="+vbrandid+"]").remove();
							swal("Done!","It was succesfully deleted!","success");
						}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
					} 
				})
	});
	});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Fuel type -->
<script>
    $(document).ready(function(){
		
		$('.fueltypeadd').click(function(){
			 
		 	var fuel_type = $('.fuel_type').val();
		 	var url = $(this).attr('fuelurl');
        	
        	function define_variable()
			{
				return {
					vehicle_fuel_value: $('.fuel_type').val(),
					vehicle_fuel_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
			
			var call_var_vehiclefueladd = define_variable();
			
	        if(fuel_type == ""){
	            swal('Please enter fuel type');
	        }
	        else if (!call_var_vehiclefueladd.vehicle_fuel_pattern.test(call_var_vehiclefueladd.vehicle_fuel_value))
			{
				$('.fuel_type').val("");
				swal('Please enter only alphanumeric data');

			}
	        else if(!fuel_type.replace(/\s/g, '').length){
	       		// var str = "    ";
				$('.fuel_type').val("");
	        	swal('Only blank space not allowed');
	        }
	        else{  
				$.ajax({
			   		type:'GET',
			   		url:url,

			   		data :{fuel_type:fuel_type},
			   		
			   		//Form submit at a time only one for fuelType
		   			beforeSend : function () {
		 				$(".fueltypeadd").prop('disabled', true);
		 			},

			   		success:function(data)
			   		{ 
				       var newd = $.trim(data);
					   var classname = 'del-'+newd;
				   
				   		if(newd == '01')
				   		{
					   		swal('Duplicate Data !!! Please try Another...');
				   		}
				   		else
				   		{
				    		$('.fuel_type_class').append('<tr class="'+classname+'"><td class="text-center">'+fuel_type+'</td><td class="text-center"><button type="button" fuelid='+data+' deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button></a></td><tr>');
					
								$('.select_fueltype').append('<option value='+data+'>'+fuel_type+'</option>');
								
								$('.fuel_type').val('');
				   		}

				   		//Form submit at a time only one for fuelType
						$(".fueltypeadd").prop('disabled', false);
						return false;
			   		},
			   
				});
			}
		});
	});
</script>

<!-- Fuel  Type delete-->
<script>
$(document).ready(function(){
	
	$('body').on('click','.fueldeletes',function(){
   
	
	var fueltypeid = $(this).attr('fuelid');
	var url = $(this).attr('deletefuel');
	swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
								$.ajax({
								type:'GET',
								url:url,
								data:{fueltypeid:fueltypeid},
								success:function(data)
									{
										$('.del-'+fueltypeid).remove();
										$(".select_fueltype option[value="+fueltypeid+"]").remove();
										swal("Done!","It was succesfully deleted!","success");
									}
								});
							}else{
									swal("Cancelled", "Your imaginary file is safe :)", "error");
								} 
						})
	
				});
		});
</script>

<!-- Add Vehicle Model -->
<script>
	$(document).ready(function(){

		$('.vehi_model_add').click(function(){
			var model_name = $('.vehi_modal_name').val();
			var model_url = $(this).attr('modelurl');
			
			function define_variable()
			{
				return {
					vehicle_model_value: $('.vehi_modal_name').val(),
					vehicle_model_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
		
			var call_var_vehiclemodeladd = define_variable();		 

	        if(model_name == ""){
            	swal('Please enter model name');
        	}
	        else if (!call_var_vehiclemodeladd.vehicle_model_pattern.test(call_var_vehiclemodeladd.vehicle_model_value))
			{
				$('.vehi_modal_name').val("");
				swal('Please enter only alphanumeric data');
			}
	        else if(!model_name.replace(/\s/g, '').length){
				$('.vehi_modal_name').val("");
	        	swal('Only blank space not allowed');
	        }
			else{	
				$.ajax({
					
					type:'GET',
					url:model_url,
					data:{model_name:model_name},

					//Form submit at a time only one for addVehicleModel
		   			beforeSend : function () {
		 				$(".vehi_model_add").prop('disabled', true);
		 			},
				
					success:function(data)
					{					
						var newd = $.trim(data);
						var classname = 'mod-'+newd;
				
				
						if(newd == '01')
						{
							swal("Duplicate Data !!! Please try Another... ");
						}
						else
						{
							$('.vehi_model_class').append('<tr class="'+classname+'"><td class="text-center">'+model_name+'</td><td class="text-center"><button type="button" modelid='+data+' deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button></a></td><tr>');
							
							/*$('.model_addname').append('<option value='+model_name+'>'+model_name+'</option>');*/
							$('.model_addname').append("<option value='"+model_name+"'>"+model_name+"</option>");
							$('.vehi_modal_name').val('');
						}

						//Form submit at a time only one for addVehicleModel
						$(".vehi_model_add").prop('disabled', false);
						return false;
					},
				});
			}
		});
		
	
		$('body').on('click','.modeldeletes',function(){
			
			var mod_del_id = $(this).attr('modelid');
			var del_url = $(this).attr('deletemodel');
			
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) 
				{
					$.ajax({
						
						type:'GET',
						url:del_url,
						data:{mod_del_id:mod_del_id},
						success:function(data)
						{
							$('.mod-'+mod_del_id).remove();
							$(".model_addname option[value="+mod_del_id+"]").remove();
							swal("Done!","It was succesfully deleted!","success");
						}
					});
				}
				else
				{
					swal("Cancelled", "Your imaginary file is safe :)", "error");
				} 
			})
		});	
	});

</script>
<!-- End Add Vehicle Model -->


<!-- vehical Type from brand -->

<script>
$(document).ready(function(){
	
	$('.select_vehicaltype').change(function(){
		vehical_id = $(this).val();
		var url = $(this).attr('vehicalurl');

		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:vehical_id },
			success:function(response){
				$('.select_vehicalbrand').html(response);
			}
		});
	});
	
});

</script>

<!-- Vehical Description-->
<script>
$("#add_new_description").click(function(){

		var row_id = $("#tab_decription_detail > tbody > tr").length;
		
		var url = $(this).attr('url');
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {row_id:row_id},
                     beforeSend: function() { 
				      $("#add_new_description").prop('disabled', true); // disable button
				    },
                     success: function (response)
                        {	
						
                            $("#tab_decription_detail > tbody").append(response.html);
                            $("#add_new_description").prop('disabled', false); // enable button
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.delete_description',function(){
	
		var row_id = $(this).attr('data-id');
	
		$('table#tab_decription_detail tr#row_id_'+row_id).remove();		
		return false;
	});
</script>

<!-- vehical color -->
<script>
$("#add_new_color").click(function(){
		var color_id = $("#tab_color > tbody > tr").length;
		
		var url = $(this).attr('url');
        
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {color_id:color_id},
                     beforeSend: function() { 
				      $("#add_new_color").prop('disabled', true); // disable button
				    },
                     success: function (response)
                        {	
						   
                            $("#tab_color > tbody").append(response.html);
                            $("#add_new_color").prop('disabled', false); // disable button
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.remove_color',function(){
	
		var color_id = $(this).attr('data-id');
	
		$('table#tab_color tr#color_id_'+color_id).remove();		
		return false;
	});
</script>

<!-- Vehical image-->

<script>

            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        
</script>
<!-- images show in multiple in for loop -->

<script>
$(document).ready(function(){
    $(".imageclass").click(function(){
        $(".classimage").empty();
    });
});
</script>
  <script>
		function preview_images() 
		{
		 	var total_file=document.getElementById("images").files.length;
		 
		 	for(var i=0;i<total_file;i++)
		 	{
			 
		  		$('#image_preview').append("<div class='col-md-3 col-sm-3 col-xs-12' style='padding:5px;'><img class='uploadImage' src='"+URL.createObjectURL(event.target.files[i])+"' width='100px' height='60px'> </div>");
		 	}
		}
		
	</script>	
<!--  new image append -->
<script>
$("#add_new_images").click(function(){
		var image_id = $("#tab_images > tbody > tr").length;
		
		var url = $(this).attr('url');

		$.ajax({
                       type: 'GET',
                       url: url,
                     data : {image_id:image_id},
                     success: function (response)
                        {	
						   
                            $("#tab_images > tbody").append(response);
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.trash_accounts',function(){
	
		var image_id = $(this).attr('data-id');
		
		$('table#tab_images tr#image_id_'+image_id).fadeOut();	
		return false;
	});
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\VehicleAddEditFormRequest', '#vehicleAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.vehicleAddSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.vehicleAddForm').submit(function () {
        $('.vehicleAddSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.vehicleAddForm').bind('invalid-form.validate', function () {
      $('.vehicleAddSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection
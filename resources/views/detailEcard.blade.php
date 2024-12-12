<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - Ecard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.bootstrap5.js"></script>
        <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.bootstrap5.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>
    <body class="antialiased">
        <div class="container relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
            <div class="row">
                <div class="col-md-6">
                    <div id="column_60_ecard">            
                        <div class="card">
                            <div class="card-body">
                                {!! Form::model($model,[
                                    'route' => $model->exists? ['updateEcard', $model->id] : 'storeEcard',
                                    'method' => $model->exists? 'PUT' : 'POST',
                                    'files' => true,
                                    'id' => 'updateEcard'
                                ]) !!}

                                <input type="hidden" id="cardId" name="cardId" value="{{ $model->id }}">
                                <div class="form-group row mb-2">
                                    <div class="col-md-4">
                                        <label class="control-label">Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $model->name }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col-md-4">
                                        <label class="control-label">Occupation</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="occupation" id="occupation" class="form-control" placeholder="Occupation" value="{{ $model->occupation }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col-md-4">
                                        <label class="control-label">Company</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="company" id="company" class="form-control" placeholder="Company" value="{{ $model->company }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col-md-4">
                                        <label class="control-label">Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $model->email }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col-md-4">
                                        <label class="control-label">Mobile No</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" value="{{ $model->mobile }}">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="col-md-4">
                                        <label class="control-label">Website</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="website" id="website" class="form-control" placeholder="Website" value="{{ $model->website }}">
                                    </div>
                                </div>
                                    
                                    <div class="form-group" id="load_page"></div>
                                    <div id='loadingmessage' class="form-group mt-2 text-center" style="display: none;">
                                        <img src="{{ asset('images/spinner-mini.gif') }}"/> Please wait
                                    </div>
                                    <div class="text-right d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-primary" id="submit_btn">UPDATE</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
				</div>
                <div class="col-md-6">
					<div id="column_40_ecard">            
						<?php
							$width = "<script>document.write(window.innerWidth);</script>";
						?>
						
						<div class="card" style="width:550px; height:336px;" id="ecard_printarea">
							<div class="card-body" style="background-image: url('{{ asset('images/background-card.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
								<div class="row mt-4">
									<div id="column_70_card">
										<div class="row">
											<div class="col-12 h1 font-bold">{{ $model->name }}</div>
											<div class="col-12 h5 mb-3">{{ $model->occupation }}</div>
										</div>
										<div class="row mt-5 font-40">
                                            <table style="width:280px;">
                                                <tr>
                                                    <td class="ps-2" style="width:30px;"> <i class="fa-brands fa-whatsapp"></i></td>
                                                    <td>&nbsp; {{ $model->mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-2"> <i class="fas fa-envelope"></i></td>
                                                    <td>&nbsp; {{ $model->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-2"> <i class="fas fa-building"></i></td>
                                                    <td>&nbsp; {{ $model->company }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-2"> <i class="fas fa-globe"></i></td>
                                                    <td>&nbsp; {{ $model->website }}</td>
                                                </tr>
                                            </table>
                                        </div>
									</div>
									<div id="column_30_card">
										<img src='{{ asset("qrcodes/" . $model->qrcode) }}' style="position:absolute; top:12em; right:9rem; width:110px; height:auto">
									</div>
								</div>
							</div>
						</div>
                        @if($width > 1650 || ($width > 876 && $width <= 1500))
						<div class="row">
							<div class="col-12 mb-2 mt-3 text-right d-flex justify-content-end">
								<button class="btn btn-sm btn-primary" id="download_ecard">DOWNLOAD</button> 
							</div>
						</div>
						@endif
					</div> 
				</div>
            </div>
            @include('_modal')
        </div>
        
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('#updateEcard').on('submit', function(e){
					e.preventDefault(); 
					var form = $('#updateEcard'),
						url = form.attr('action');        
						
						form.find('.form-control').removeClass('is-invalid');
						form.find('.alert_point').html('');
						form.find('#alert_project_member').attr('style', 'width:100%');
						$('#loadingmessage').show();
						$("#submit_btn").hide();

					$.ajax({
						url: url,
						method: "POST",  
						data: new FormData(this),  
						contentType: false,  
						cache: false,  
						processData:false,
						success:function(returnData)
						{  	
							Swal.fire({
                                icon: 'success',
                                title: 'Success',
							}).then(function() {
								location.reload();
							});
							$('#loadingmessage').hide();
							$("#submit_btn").show();
						},
						error: function (xhr, error, thrown) {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Something went wrong!',
							}).then(function(){
								location.reload();
							});
						}
					});  
				});

				$("#download_ecard").on('click', function() { 

					var width = window.innerWidth;
					if(width > 1650 || (width > 876 && width <= 1500)){

						html2canvas($('#ecard_printarea')[0], {
							width: 550,
							height: 336
						}).then(function(canvas) {
							var a = document.createElement('a');
							a.href = canvas.toDataURL("image/png");
							a.download = 'mycard.png';
							a.click();
						});
					}else{
						swal.fire({
							icon : 'warning',
							title : 'Resolution Monitor is not Support',
						})
					}
				}); 
			});
		</script>
	</body>
</html>
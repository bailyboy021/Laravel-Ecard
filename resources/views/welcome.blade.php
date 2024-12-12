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
    </head>
    <body class="antialiased">
        <div class="container relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
        <div class="row">
                <div class="col-md-12 text-right">					
                    <button type="button" link="{{ route('addEcard') }}" token="{{ csrf_token() }}" class="btn btn-sm btn-primary add_activity" title="Create New">+ Create New</button>
				</div>
                
                <div class="col-md-12 mt-2">
                    <div class="card">                
                        <div class="card-header text-white bg-primary">
                            <i class="fa fa-list"></i>&nbsp; Ecards Lists
                        </div>                               
                        <div class="card-body" id="list_input">
							<div class="row">
								<div class="mt-4 table-responsive">
									<table class="table table-bordered table-sm table-striped table_row" id="data-ecard" style="cursor:pointer" width="100%">
										<thead>
											<tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>QR Code</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('_modal')
        
        <script>
            $('body').on('click', '.add_activity', function(e)
            {
                var me= $(this),
                    url = me.attr('link'),
                    title = me.attr('title'),
                    token = me.attr('token');

                $('#content_title').text(title);
                $('#content_save').text(me.hasClass('edit') ? 'Update' : 'Submit');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { '_token' :  token },
                    // dataType: 'html',
                    success: function(response)
                    {
                        $('#content_body').html(response);
                    },
                    beforeSend: function(msg)
                    {
                        $('#content_body').html("<img src='images/spinner-mini.gif' /> Please wait");
                    },
                    error: function (xhr, error, thrown)
                    {           
                        location.href = "/";
                    }
                });

                var myModal = new bootstrap.Modal(document.getElementById('modal_add'), {
                    // backdrop: 'static',
                    keyboard: false
                });
                myModal.show();

            });

            $(function() {
                $('#modal_add').on('hidden.bs.modal', function (e) {
                    $('#content_body').html('');
                });

                $('#modal').on('hidden.bs.modal', function (e) {
                    $('#modal-body').html('');
                });

            });

        </script>
        <script type="text/javascript">
            $(function() {
                var csrf_token = '{{ csrf_token() }}';
                var ecard = $('#data-ecard').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: 
                    {
                        url: '{{ route('getEcard') }}',
                        data: function (d) {
                            d._token = csrf_token;
                        },
                        method: 'post',
                        error: function (xhr, error, thrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            }).then(function(){
                                location.reload();
                            });
                        }		
                    },
                    columns: [
                        {   data: "id",
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        {   data: 'name', name: 'name',"orderable":false },
                        {   data: 'email', name: 'email',"orderable":false },
                        {   data: 'qrcode', name: 'qrcode',"orderable":false },
                    ],
                    columnDefs: [{ 
                            "targets": [ 0, 1 ],
                            "orderable": false, 
                        },
                    ],
                            
                    order: [],
                    
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    language: {
                        "search" : "Search : ",
                        "searchPlaceholder" : "Type to search"
                    }
                    
                });

                $('#data-ecard tbody').on('click', 'tr', function () {
                    var data = ecard.row( this ).data();

                    var node = data.action;
                    var href = $(node).attr("href");
                    
                    window.open(href, '_blank');
                });
            });
        </script>
    </body>
</html>

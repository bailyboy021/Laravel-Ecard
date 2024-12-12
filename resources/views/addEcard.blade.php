<div class="row">
	<div class="col-md-12">	
		{!! Form::model($model,[
			'route' => 'storeEcard',
			'method' => 'POST',
			'files' => true,
			'id' => 'request_form'
		]) !!}	
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label class="control-label">Name</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="">
				</div>
			</div>
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label class="control-label">Occupation</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="occupation" id="occupation" class="form-control" placeholder="Occupation" value="">
				</div>
			</div>
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label class="control-label">Company</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="company" id="company" class="form-control" placeholder="Company" value="">
				</div>
			</div>
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label class="control-label">Email</label>
				</div>
				<div class="col-md-8">
					<input type="email" name="email" id="email" class="form-control" placeholder="Email" value="">
				</div>
			</div>
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label class="control-label">Mobile No</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" value="+62">
				</div>
			</div>
            <div class="form-group row mb-2">
				<div class="col-md-4">
					<label class="control-label">Website</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="website" id="website" class="form-control" placeholder="Website" value="">
				</div>
			</div>
			<div id='loadingmessage' class="col-md-12 mt-2 text-center" style="display: none;">
				<img src="{{ asset('images/spinner-mini.gif') }}"/> Please wait
			</div>
			<div class="text-right d-flex justify-content-end">
				<button type="submit" class="btn btn-primary btn-sm" id="submit_btn">CREATE</button>
			</div>
		{!! Form::close() !!}
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#request_form').on('submit', function(e) {
        e.preventDefault();

        var form = $('#request_form'),
            url = form.attr('action'),
            modalAdd = bootstrap.Modal.getInstance(document.getElementById('modal_add'));

        form.find('.invalid-feedback').remove();
        form.find('.form-control').removeClass('is-invalid');
        $('#loadingmessage').show();
        $("#submit_btn").hide();

        $.ajax({
            url: url,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(returnData) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    // text: 'Data has been successfully submitted!',
                    allowOutsideClick: false
                }).then(function() {
                    modalAdd.hide();
                    $('#data-ecard').DataTable().ajax.reload(); // Reload DataTable
                });

                $('#loadingmessage').hide();
                $("#submit_btn").show();
            },
            error: function(xhr) {
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function(key, value) {
                        $('#' + key).closest('.form-control').addClass('is-invalid');
                    });
                }

                $('#loadingmessage').hide();
                $("#submit_btn").show();
            }
        });
    });
});
</script>

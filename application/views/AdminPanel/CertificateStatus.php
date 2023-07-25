<!--Modal Start-->
<div class="modal fade" id="CertificateModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content border-primary">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white">Certificate</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<form action="<?php echo base_url("AdminPanel/CertificateStatus/Update"); ?>" method="POST" id="registerForm">
				<div class="modal-body">
					
				</div>
				<div class="modal-footer d-block">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
					value="<?= $this->security->get_csrf_hash(); ?>" />
					<button type="submit" id="registerBtn" class="btn btn-primary"><i
					class="icon-lock"></i> Submit <i class="fa fa-spin fa-spinner" id="registerSpin" style="display:none;"></i></button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<!--Modal End-->

<script>
	
	function CertificateStatus(e,id) {
		var status = 'true';
		var check = $(e).prop("checked");
		if (check) {
			swal({
				title: "Are you sure?",
				text: "Do you want to Issued this Certificate !",
				icon: "warning",
				buttons: true,
				dangerMode: true
				}).then((willDelete) => {
				if (willDelete) {
					$("#CertificateModal").modal("show");
					$("#CertificateModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
					$("#CertificateModal .modal-body").load("<?php echo base_url('AdminPanel/CertificateStatus/Edit/');?>"+id+"/"+status);
				}
			});
			} else {
			var status = 'false';
			swal({
				title: "Are you sure?",
				text: "Do you want to Non-Issued this Certificate !",
				icon: "warning",
				buttons: true,
				dangerMode: true
				}).then((willDelete) => {
				if (willDelete) {
					$("#CertificateModal").modal("show");
					$("#CertificateModal .modal-body").html("<center><i class='fa fa-2x fa-spin fa-spinner'></i></center>");
					$("#CertificateModal .modal-body").load("<?php echo base_url('AdminPanel/CertificateStatus/Edit/');?>"+id+"/"+status);
				}
			});
		}
		return status;
	}
	
	$('#registerForm').on('submit', function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: $('#registerForm').attr('action'),
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$("#registerBtn").attr("disabled", true);
				$('#registerSpin').show();
			},
			success: function(response) {
				
				console.log(response);
				
				var response = JSON.parse(response);
				$("#registerBtn").removeAttr("disabled");
				$('#registerSpin').hide();
				if (response[0].res == 'success') 
				{
					$('.notifyjs-wrapper').remove();
					$.notify("" + response[0].msg + "", "success");
					window.setTimeout(function() {
						window.location.reload();
					}, 1000);
				}
				else if (response[0].res == 'error')
				{
					$('.notifyjs-wrapper').remove();
					$.notify("" + response[0].msg + "", "error");
				}
			},
			error: function() {
				window.location.reload();
			}
		});
	});
	
</script>
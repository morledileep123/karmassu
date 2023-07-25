<?php
defined("BASEPATH") or exit("No direct scripts allowed here");
?>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url("assets_panel/js/jquery.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/js/popper.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/js/bootstrap.min.js"); ?>"></script>

<!-- simplebar js -->
<script src="<?php echo base_url("assets_panel/plugins/simplebar/js/simplebar.js"); ?>"></script>
<!-- sidebar-menu js -->
<script src="<?php echo base_url("assets_panel/js/sidebar-menu.js"); ?>"></script>
<!-- loader scripts -->
<!--
<script src="<?php echo base_url("assets_panel/js/jquery.loading-indicator.js"); ?>"></script>-->
<!-- Custom scripts -->
<script src="<?php echo base_url("assets_panel/js/app-script.js"); ?>"></script>
<!-- Chart js -->

<script src="<?php echo base_url("assets_panel/plugins/Chart.js/Chart.min.js"); ?>"></script>
<!-- Vector map JavaScript -->
<script src="<?php echo base_url("assets_panel/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/vectormap/jquery-jvectormap-world-mill-en.js"); ?>"></script>
<!-- Easy Pie Chart JS -->
<script src="<?php echo base_url("assets_panel/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"); ?>"></script>
<!-- Sparkline JS -->
<script src="<?php echo base_url("assets_panel/plugins/sparkline-charts/jquery.sparkline.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/jquery-knob/excanvas.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/jquery-knob/jquery.knob.js"); ?>"></script>

<script src="<?php echo base_url("assets_panel/plugins/summernote/dist/summernote-bs4.min.js"); ?>"></script>

<!--
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"); ?>"></script>
  -->

<!--notification js -->
<script src="<?php echo base_url("assets_panel/plugins/notifications/js/lobibox.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/notifications/js/notifications.min.js"); ?>"></script>

<!--Data Tables js-->
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"); ?>">
</script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/jszip.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/pdfmake.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/vfs_fonts.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/buttons.html5.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/buttons.print.min.js"); ?>"></script>
<script src="<?php echo base_url("assets_panel/plugins/bootstrap-datatable/js/buttons.colVis.min.js"); ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap.min.js"></script>
<!--Sweet Alerts -->
<script src="<?php echo base_url("assets_panel/plugins/alerts-boxes/js/sweetalert.min.js"); ?>"></script>
<!--Switchery Js-->
<script src="<?php echo base_url("assets_panel/plugins/switchery/js/switchery.min.js"); ?>"></script>

<script src="<?php echo base_url("assets_panel/js/own-script.js"); ?>"></script>
<!-- Index js -->
<script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
<!--form validation parsley-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
		$('.js-switch').each(function() {
			new Switchery($(this)[0], $(this).data());
		});
	});
</script>

<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
	$(function() {
		$(".knob").knob();
	});
	$(document).ready(function() {
		//form validation call function
		$('form').parsley();
		//Default data table
		$('#default-datatable').DataTable();
		var table = $('#example').DataTable({
			responsive:true,
			lengthChange: false,
			buttons: [ 'excel', 'pdf' ]
		});
		table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
	});
	$('.dropify').dropify({
		messages: {
			'default': 'Drag and drop a file here or click',
			'replace': 'Drag and drop or click to replace',
			'remove': 'Remove',
			'error': 'Ooops, something wrong appended.'
		},
		error: {
			'fileSize': 'The file size is too big (2M max).'
		}
	});
</script>
<script>
    $(function() {
        $(".knob").knob();
    });
    </script>
    <!-- Index js -->
    <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous"></script>


<script src="<?php //echo base_url("assets/js/settings.js"); ?>"></script>
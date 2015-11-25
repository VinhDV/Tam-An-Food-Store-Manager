<?php 
	include($_SERVER["DOCUMENT_ROOT"] . 'Tam-An-Food-Store-Manager/'. 'config.php');
?>

<!doctype html>
<html>

<?php require_once(VIEW_PATH . "head.php");?>
<body style = "background-color : #FFE6CF;">
		<script type="text/javascript">
		// on document ready load default task
		// might need cookie or chace in the near future
		$(document).ready(function(){
			$("#task1").parent().find("div.load").load('<?php echo CONFIG_PATH("view")."receipt_task_view.php"; ?>');
		});
		// Switch task upon selected task
		function switch_task(task_id) {
			var task = document.getElementById(task_id);
			var val = task.value;
				
			if(val == "receipt")
				$("#"+task_id).parent().find("div.load").load('<?php echo CONFIG_PATH("view")."receipt_task_view.php"; ?>');
			else 
				$("#"+task_id).parent().find("div.load").load('<?php echo CONFIG_PATH("view")."blank.php"; ?>');
		}
		</script>
		
		<div class="no-print"> 
				<?php require_once(VIEW_PATH."header.php");?>
			
				<div class="col-md-6">
					<div class="inner-content">
						<select id="task1" tabindex="-1" class="form-control" onchange="switch_task('task1')">
							<option value="receipt">In hóa đơn</option>
							<option value="2">Quản lý nhập</option>
							<option value="3">Quản lý dư</option>
						</select>	

						<div class="load">IF YOU SEE THIS THEN SWITCH TASK FUNCTION IS NOT WORKING</div>		
					</div>
				</div>

				<div class="col-md-6">
					<div class="inner-content">
						<select id="task2" tabindex="-1" class="form-control">
							<option value="receipt">In hóa đơn</option>
							<option value="2">Quản lý nhập</option>
							<option value="3">Quản lý dư</option>
						</select>
						<div class="load">THIS FUNCTION HAS NOT BEEN IMPLEMENTED</div>	
					</div>
				</div>
			
		</div>
		<!-- Only the latest submit print is accepted  -->
		<div id="print_here" class="print-blocks">IF YOU SEE THIS THEN PRINT FUNCTION IS NOT WORKING</div>
	</body>
</html>
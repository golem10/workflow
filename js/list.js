function blueRadioListClick(e){
		$("#id_edit").val($(e).val());
		$("#id_delete").val($(e).val());
		$("#id_priority").val($(e).val());
		$("#buttonPriority").removeAttr("disabled");
		$("#buttonEdit").removeAttr("disabled");
		$("#buttonDelete").removeAttr("disabled");
}
$(function(){
	$("#buttonEdit").click(function(){
		$("#editFormSend").submit();
	});
	$("#buttonPriority").click(function(){
		$("#changePriorityFormSend").submit();
	});
	$("#deleteModalButtonYes").click(function(){
		$("#deleteFormSend").submit();
	});
	
	$('#dataTable').on( 'draw.dt', function () {
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').on("ifClicked",function(){blueRadioListClick(this)}).iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		});
		$("#buttonEdit").attr("disabled","disabled");
		$("#buttonDelete").attr("disabled","disabled");
	});
})
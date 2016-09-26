$(function(){

	$(".btn-app").click(function(){
		$("#id_report").val($(this).attr("rel"));
		setTimeout(function(){$("#formSend").submit()},100);
	});
})
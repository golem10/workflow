<?php //print_r($data);?>

  <table id="dataTable" class="table table-bordered table-striped table-hover">
	<thead>
	  <tr>
		<th></th>
		<th>Data wystawienia PZ</th> 
		<th>Numer PZ</th>
		<th>Odbiorca</th>
		<th>Wartość PZ</th>	
		<th>Przewidywany termin realizacji</th>	
		<th>Data wykonania</th>
		<th>Numer paragonu lub FV</th>
	  </tr>
	</thead>
	<tbody>
	<?php foreach ($data as $v)
	{
		echo"
		<tr><td class='details-control' rel='".(isset($dataElements[$v->id_order][0]) ? $dataElements[$v->id_order][0] : '')."' rel2='".(isset($dataElements[$v->id_order][1]) ? $dataElements[$v->id_order][1] : '')."' rel3='".(isset($dataElements[$v->id_order][2]) ? $dataElements[$v->id_order][2] : '')."' ><button type='button' class='btn btn-sm btn-success'><i class='fa fa-plus'></i></button></td>
			<td>{$v->date_add}</td> 
			<td>{$v->number}</td>
			<td>{$v->name}</td>
			<td>".number_format($v->pz_value, 2, '.', '')."</td>	
			<td>{$v->execution_date}</td>	
			<td>{$v->execution_date_complete}</td>
			<td>{$v->bill_number}</td>
	    </tr>
	    ";
	}?>
	</tbody>
	<tfoot>
	  <tr>
		<th></th>
		<th>Data wystawienia PZ</th> 
		<th>Numer PZ</th>
		<th>Odbiorca</th>
		<th>Wartość PZ</th>	
		<th>Przewidywany termin realizacji</th>	
		<th>Data wykonania</th>
		<th>Numer paragonu lub FV</th>
	  </tr>
	</tfoot>
  </table>
              

<script>
    $(function () {
        dTable = $("#dataTable").DataTable( {			
			"order": [[ 1, "asc" ]],
			"language": {
				"url": "<?php echo base_url("plugins/datatables/polish.txt");?>"
			}			
		});
				
	});
	$('#dataTable tbody').on('click', 'td.details-control', function () {
		var rel = $(this).attr('rel');
		var rel2 = $(this).attr('rel2');
		var rel3 = $(this).attr('rel3');
        var tr = $(this).closest('tr');
        var row = dTable.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
			$(this).find("button").find("i").removeClass("fa-minus");
			$(this).find("button").find("i").addClass("fa-plus");
        }
        else { 
            // Open this row
            row.child( format(rel,rel2,rel3) ).show();
            tr.addClass('shown');
			$(this).find("button").find("i").removeClass("fa-plus");
			$(this).find("button").find("i").addClass("fa-minus");
        }
    } );
	function format ( rel,rel2,rel3 ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Elementy oraz farby:</td>'+
        '</tr>'+
        '<tr>'+
            '<td>'+rel+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>'+rel2+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td>'+rel3+'</td>'+
        '</tr>'+
    '</table>';
}
</script>
      
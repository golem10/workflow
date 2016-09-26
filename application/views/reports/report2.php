<?php //print_r($data);?>

  <table id="dataTable" class="table table-bordered table-striped table-hover">
	<thead>
	  <tr>
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
		<tr>
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
</script>
      
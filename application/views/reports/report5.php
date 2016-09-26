
  <table id="dataTable" class="table table-bordered table-striped table-hover">
	<thead>
	  <tr>
		<th>Farba</th>
		<th>Ilość</th>
		<th>Jednostka</th>
	  </tr>
	</thead>
	<tbody>
	<?php foreach($data as $v){ ?>
		<tr>
			<td><?php echo $v->name;?></td>
			<td><?php echo $v->quantity;?></td>
			<td><?php echo $v->unit;?></td>
		</tr>
	<?php }  ?>
	</tbody>
	<tfoot>
	  <tr>
		<th>Farba</th>
		<th>Ilość</th> 
		<th>Jednostka</th>
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
      
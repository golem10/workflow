<?php if($type == 0){?>
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-warning"></i> Błąd!</h4>
	<?php echo $value; ?>
</div>
<?php
} elseif($type == 1){?>
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-check"></i> Sukces</h4>
	<?php echo $value; ?>
</div>
<?php
}?>
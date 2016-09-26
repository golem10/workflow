<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Tablica</a></li>
<?php foreach($breadcrumbs as $k=>$v){?>
	<li><a href="<?php echo ($v['url']!="") ? $v['url'] : "#";?>" <?php echo ($v['url']=="") ? 'class="active""' : "";?>></i> <?php echo $v['name'];?></a></li>
<?php
}?>

</ol>

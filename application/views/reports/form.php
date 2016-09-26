
	
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $site_info['title']."<small>".$site_info['description']."</small>";?>
          </h1>
          <?php echo $breadcrumbs;?>
        </section>

        <!-- Main content -->

        <section class="content">
			<?php echo $msgBlock;?>			
			<div class="row">
				<!-- left column -->
				
				<div class="col-md-3">
				  <!-- general form elements -->
				  <div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">Zakres dat generowanego raportu</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body form-horizontal">					  						
						<?php echo form_open(base_url("reports"),array('id' => 'formSend','method' => 'post'),array());?>
						<input type="hidden" name="id_report" id="id_report" class="form-control" value="" />
  
						<div class="form-group">
						  <label for="range_from" class="col-sm-2 control-label">Do</label>
						  <div class="col-sm-10">
							  <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" id="range_from" value="<?php echo $range_from;?>" name="range_from">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</div>
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="range_to" class="col-sm-2 control-label">Do</label>
						  <div class="col-sm-10">
							  <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" id="range_to" value="<?php echo $range_to;?>" name="range_to">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</div>
							  </div>
						  </div>
						</div>
						<?php echo form_close();?>
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				<div class="col-md-9">
				  <!-- general form elements -->
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Generuj raport (Uwaga, generowanie raportu może trwać długo)</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body form-horizontal">					  						
						<button class="btn btn-app <?php echo ($id_report == 1) ? "btn-primary active" : "";?>" rel="1">
							<i class="fa fa-area-chart"></i> PZ Wystawione
						</button>
						<button class="btn btn-app <?php echo ($id_report == 2) ? "btn-primary active" : "";?>" rel="2">
							<i class="fa fa-area-chart"></i> PZ Zrealizowane
						</button>
						<button class="btn btn-app <?php echo ($id_report == 3) ? "btn-primary active" : "";?>" rel="3">
							<i class="fa fa-area-chart"></i> PZ W trakcie realizacji
						</button>
						<button class="btn btn-app <?php echo ($id_report == 4) ? "btn-primary active" : "";?>" rel="4">
							<i class="fa fa-area-chart"></i> PZ Wg. kontrahentów
						</button>
						<button class="btn btn-app <?php echo ($id_report == 5) ? "btn-primary active" : "";?>" rel="5">
							<i class="fa fa-area-chart"></i> Zestawienie farb
						</button>
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
			</div>		
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Dane raportu:</h3>
						  <div class="btn-group pull-right">						
								<a href="<?php echo base_url("reports/pdfList/".$id_report."/".$range_from."/".$range_to); ?>" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i>&nbsp; Drukuj</a>
						  </div>
						</div><!-- /.box-header -->
						<!-- form start -->
						  <div class="box-body form-horizontal">					  						
							<?php echo $dataBlock;?>
						  </div><!-- /.box-body -->
					  </div><!-- /.box -->	
				</div>
			</div>
		</section>
	  
      </div><!-- /.content-wrapper -->
  
      
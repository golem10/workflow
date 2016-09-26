 <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
			<?php if(isset($access[5]) || isset($access[6]) || isset($access[3])){?>
			<li class="header">Obsługa</li>
			<?php }?>
			<?php if(isset($access[5])){?>
		    <li <?php if($site_info["active"] == "orders") echo 'class="active"';?>><a href="<?php echo base_url('orders/');?>"><i class="fa fa-list-alt"></i> <span>Zamówienia</span></a></li>
			<?php }?>
			<?php if(isset($access[6])){?>
			<li <?php if($site_info["active"] == "pz") echo 'class="active"';?>><a href="<?php echo base_url('pz');?>"><i class="fa fa-sticky-note"></i> <span>Druki PZ</span></a></li>
			<?php } ?>
			<?php if(isset($access[3])){?>
			<li <?php if($site_info["active"] == "customers") echo 'class="active"';?>><a href="<?php echo base_url('customers');?>"><i class="fa fa-street-view"></i> <span>Klienci</span></a></li>
			<?php } ?>
			<?php /* <li class="header">Raporty</li>
			<li class="treeview">
              <a href="#"><i class="fa fa-list"></i> <span>Zestawienia</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">PZ Zrealizowane</a></li>
                <li><a href="#">PZ Niezrealizowane</a></li>
              </ul>
            </li>
			*/ ?>
			<?php if(isset($access[7])){?>
			<li class="header">Produkcja</li>			
			<li <?php if($site_info["active"] == "pz_production") echo 'class="active"';?>><a href="<?php echo base_url('pz_production');?>"><i class="fa fa-list-alt"></i> <span>Zlecenia</span></a></li>
			<?php } ?>
			<?php if(isset($access[8])){?>
			<li class="header">Dostawa</li>			
			<li <?php if($site_info["active"] == "delivery") echo 'class="active"';?>><a href="<?php echo base_url('delivery');?>"><i class="fa fa-paint-brush"></i> <span>Farby</span></a></li>
			<?php } ?>
			<?php if(isset($access[4]) || isset($access[2]) || isset($access[1])){?>
            <li class="header">Administracja</li>
			<?php }?>
			<?php if(isset($access[4])){?>
            <li class="treeview <?php if($site_info["active"] == "definitions") echo 'active';?>" >
              <a href="#"><i class="fa fa-list-ol"></i> <span>Definicje</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
				<li><a href="<?php echo base_url('definitions/paints');?>">Farby</a></li>
              </ul>
            </li>
			<?php }?>			
			<?php if(isset($access[9][5])){?>
				<li <?php if($site_info["active"] == "reports") echo 'class="active"';?>><a href="<?php echo base_url('reports');?>"><i class="fa fa-area-chart"></i> <span>Raporty</span></a></li>
			<?php }?>			
			<?php if(isset($access[2])){?>
				<li <?php if($site_info["active"] == "users") echo 'class="active"';?>><a href="<?php echo base_url('users');?>"><i class="fa fa-user"></i> <span>Użytkownicy</span></a></li>
			<?php }?>
			<?php /* if(isset($access[1])){?>
				<li <?php if($site_info["active"] == "usersGroups") echo 'class="active"';?>><a href="<?php echo base_url('usersGroups');?>"><i class="fa fa-users"></i> <span>Grupy użytkowników</span></a></li>
            <?php } */ ?>
			
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
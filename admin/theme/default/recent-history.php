<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright � 202KOVATZra
 *
 */
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>  
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php adminLink(); ?>"><i class="<?php getAdminMenuIcon($controller,$menuBarLinks); ?>"></i> Admin</a></li>
        <li class="active"><a href="<?php adminLink($controller); ?>"><?php echo $pageTitle; ?></a> </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#domain-history" data-toggle="tab"><?php echo $subTitle; ?></a></li>
                <li><a href="#com-history" data-toggle="tab">Competitive Analysis History</a></li>
            </ul>
          
          <div class="tab-content">

            <?php if(isset($msg)) echo $msg; ?><br />
            <div class="tab-pane active" id="domain-history" >
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="domainHistory">
                	<thead>
                		<tr>
                          <th>Domain Name</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>IP</th>
                          <th>Country</th>
                          <th>Actions</th>
                		</tr>
                	</thead>         
                    <tbody>                        
                    </tbody>
                </table>
            </div>   
            
            <div class="tab-pane" id="com-history" >
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="comHistory">
                	<thead>
                		<tr>
                          <th>Website URL</th>
                          <th>Competitor URL</th>
                          <th>Username</th>
                          <th>Date</th>
                          <th>IP</th>
                          <th>Country</th>
                          <th>Actions</th>
                		</tr>
                	</thead>         
                    <tbody>                        
                    </tbody>
                </table>
            </div>  
            
            <br />
        </div> </div>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<?php 
$ajaxLink = adminLink('?route=ajax/domainHistory',true); 
$ajaxLink2 = adminLink('?route=ajax/comHistory',true); 
$footerAddArr[] = <<<EOD
    <script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
    	$('#domainHistory').dataTable( {
    		"processing": true,
    		"serverSide": true,
    		"ajax": "$ajaxLink",
            "order": [[ 4, "desc" ]]
    	} );
    } );
    </script>
    <script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
    	$('#comHistory').dataTable( {
    		"processing": true,
    		"serverSide": true,
    		"ajax": "$ajaxLink2",
            "order": [[ 5, "desc" ]]
    	} );
    } );
    </script>
EOD;
?>
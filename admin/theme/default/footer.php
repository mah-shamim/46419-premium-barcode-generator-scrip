<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: Tools
 * @copyright © 2024 KOVATZ
 *
 */
?>
     <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Your Version <?php echo VER_NO; ?>
        </div>
        <!-- Copyright -->
        <strong>Copyright &copy; <?php echo date("Y"); ?> <a target="_blank" href="http://www.kovatz.com/">KOVATZ</a></strong> All rights reserved.
      </footer>

      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- Bootstrap 3.3.2 JS -->
    <?php scriptLink('bootstrap/js/bootstrap.min.js',true); ?>
    
    <!-- App -->
    <?php scriptLink('dist/js/app.min.js',true); ?>
    
    <?php scriptLink('dist/js/custom.js',true); ?>
    
    <!-- Morris.js charts -->
    <?php scriptLink('https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',true,true); ?>
    
    <?php scriptLink('plugins/morris/morris.min.js',true); ?>
    
    <!-- iCheck -->
    <?php scriptLink('plugins/iCheck/icheck.min.js',true); ?>
    
    <!-- DATA TABES SCRIPT -->
    <?php scriptLink('plugins/datatables/jquery.dataTables.min.js',true); ?>
    
    <?php scriptLink('plugins/datatables/dataTables.bootstrap.min.js',true); ?>
    
    <!-- date-range-picker -->
    <?php scriptLink('plugins/daterangepicker/moment.min.js',true); ?>
    
    <?php scriptLink('plugins/daterangepicker/daterangepicker.js',true); ?>

    <!-- CK Editor -->
    <?php scriptLink('plugins/ckeditor/ckeditor.js',true); ?>
    
    <!-- Select2 -->
    <?php scriptLink('plugins/select2/select2.full.min.js',true); ?>
    
    <!-- Checkbox -->
    <?php scriptLink('plugins/checkbox/bootstrap-checkbox.min.js',true); ?>
    
    <!-- colorpicker -->
    <?php scriptLink('plugins/colorpicker/bootstrap-colorpicker.min.js',true); ?>
    
    <?php if(isset($footerAdd) && $footerAdd){ 
        foreach($footerAddArr as $footerCodes)
            echo $footerCodes;
    } ?>

  </body>
</html>
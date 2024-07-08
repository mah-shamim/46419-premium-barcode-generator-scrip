<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright © 2024 KOVATZ
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

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $subTitle; ?></h3>
            </div><!-- /.box-header ba-la-ji -->
            <form action="#" method="POST">
            <div class="box-body">
          
            <?php if(isset($msg)) echo $msg; ?><br />

            <?php if($pointOut == 'clone'){ if(isset($log)) {  ?>
                <textarea readonly="" id="tableRes" rows="12" class="form-control"><?php echo $logData; ?></textarea>
                <br>
                <a class="btn btn-danger" href="<?php adminLink($controller); ?>">Go to Manage Themes</a>
                <br>
                <br>
            <?php } else { ?>
           <div class="form-group">
                <label>Theme Name</label>
                <input value="<?php echo $themeDetails['name']; ?> Clone" required="required" type="text" placeholder="Type theme name" name="theme[name]" class="form-control" />
           </div>

            <div class="form-group">
                <label>Theme Directory Name <small>(Only Alphanumeric characters)</small></label>
                <input value="<?php echo $args[0]; ?>clone" pattern="[a-zA-Z0-9 ]+" required="required" type="text" placeholder="Type directory name" name="theme[dir]" class="form-control" />
            </div>

            <div class="form-group">
                <label>Description</label>
                <input value="<?php echo $themeDetails['description']; ?>" required="required" type="text" placeholder="Type theme description" name="theme[des]" class="form-control" />
            </div>

            <div class="form-group">
                <label>Your Name</label>
                <input value="<?php echo $themeDetails['author']; ?>" required="required" type="text" placeholder="Type author name" name="theme[author]" class="form-control" />
            </div>

            <div class="form-group">
                <label>Your Email</label>
                <input value="<?php echo $themeDetails['authorEmail']; ?>" required="required" type="text" placeholder="Type author email" name="theme[email]" class="form-control" />
            </div>

            <div class="form-group">
                <label>Your Website Link:</label>
                <input value="<?php echo $themeDetails['authorWebsite']; ?>" required="required" type="text" placeholder="Type author website link" name="theme[link]" class="form-control" />
            </div>

            <div class="form-group">
                <label>Copyright:</label>
                <input value="<?php echo $themeDetails['copyright']; ?>" required="required" type="text" placeholder="Type author website link" name="theme[copy]" class="form-control" />
            </div>
            <table class="table table-bordered">
                <tbody><tr>
                    <th>#</th>
                    <th>Required directory permissions</th>
                    <th>Status</th>
                </tr>
                <?php
                $loopC = 1;
                foreach($minMsg as $msg){
                    echo '
              <tr>
                <td>'.$loopC.'</td>
                <td>'.$msg[0].'</td>
                <td>'.$msg[1].'</td>
              ';
                    $loopC++;
                }
                ?>
                </tbody></table>
            <br />
            <input <?php if($minError) echo ' disabled="" '; ?> type="submit" name="save" value="Clone Theme" class="btn btn-success"/>
            <a class="btn btn-danger" href="<?php adminLink($controller); ?>">Cancel</a>
            <br />
            <br />

            <?php } } else { ?>
                <div class="row">
                <?php
                    foreach(getThemeList() as $themes){
                    $themeDirRaw = $themes[0]; $themeDir = $themes[1]; $themeDetails = $themes[2]; $previewLink = '';

                    if(file_exists($themeDir.D_S.$themeDetails['preview']))
                        $previewLink = createLink('theme/'.$themeDirRaw.'/'.$themeDetails['preview'],true);
                    else
                        $previewLink  = createLink('core/library/img/no-preview.png',true);;
                ?>

                    <div class="col-sm-6 col-md-4">
                        <div class="panel panel-white themePanel">
                            <div class="panel-body themePanelBody">
                                <img src="<?php echo $previewLink; ?>" alt="<?php echo $themeDetails['description']; ?>" class="screenPreview img-responsive" />
                            </div>
                            <div class="panel-footer">
                                <h4 class="remove-margin-bottom">
                                    <a href="" class="theme-title"><?php echo $themeDetails['name']; ?></a>
                                </h4>
                                <p class="font-small author">KOVATZ</p>
                                <div class="clearfix font-small purchases-col">
                                    <div class="pull-right">
                                        <?php if($defaultTheme == $themes[0]){ ?>
                                        <a class="btn btn-primary btn-xs disabled" href=""> <i class="fa fa-paint-brush"></i>&nbsp;Active</a>
                                        <?php } else{ ?>
                                        <a class="btn btn-primary btn-xs" onclick="return confirm('Are you want to make default template?');" href="<?php adminLink('ajax/theme/set/frontend/'.$themes[0]); ?>"> <i class="fa fa-paint-brush"></i>&nbsp;Apply</a>
                                        <?php } ?>
                                        <a href="<?php adminLink($controller.'/clone/'.$themes[0]); ?>" class="btn btn-warning btn-xs"> <i class="fa fa-copy"></i>&nbspClone</a>
                                        <a href="<?php createLink('templates/preview/'.$themes[0]); ?>" target="_blank" class="btn btn-success btn-xs"> <i class="fa fa-eye"></i>&nbspPreview</a>
                                        <?php if(!nullCheck($themeDetails['builder'])){ ?>
                                        <a target="_blank" class="btn btn-danger btn-xs" href="<?php adminLink($themeDetails['builder']); ?>"> <i class="fa fa-edit"></i>&nbspEdit</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                </div>
               <?php }?>
             <br />
            </div><!-- /.box-body -->
            </form>
          </div><!-- /.box -->
  
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
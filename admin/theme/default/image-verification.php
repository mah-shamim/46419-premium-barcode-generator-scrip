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
				<?php echo $p_title; ?>
					<small>
						Control panel
					</small>
			</h1>
			<ol class="breadcrumb">
				<li>
					<a href="/admin/?route=image-verification"><i class="fa fa-bar-chart"></i> Admin</a>
				</li>
				<li class="active">
					<?php echo $p_title; ?>
				</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">
						General Settings
					</h3>
				</div>
				<!-- /.box-header -->

				<form action="/admin/?route=image-verification" method="POST">
					<div class="box-body">
                    <div class="row" style="padding-left: 5px;">
                        <div class="col-md-8">
						<?php if(isset($msg)){ echo $msg; }?>
							<div class="form-group">
								<div class="checkbox">
									<label class="checkbox inline">
										<input <?php if ($cap_e=="on") echo 'checked="true"'; ?>
										type="checkbox" name="cap_e"  /> Enable captcha mode for all PDF tools, to protect from spam and unwanted behaviour.
									</label>
								</div>
							</div>

						<div class="callout callout-warning">
						  <p>Note: If you want to enable captcha protection for specific tools than discheck this box and goto "<a href="/admin/?route=manage-tools">Manage PDF Tools</a>" option.  </p>
                      </div>
                  
                        	<div class="form-group">
								<div class="checkbox">
									<label class="checkbox inline">
										<input <?php if ($cap_c=="on") echo 'checked="true"'; ?>
										type="checkbox" name="cap_c" /> Enable captcha protection for Contact Us page.
									</label>
								</div>
							</div>
							<br />
							<div class="form-group">
								<label>
									Select Capthca Type
								</label>
								<select class="form-control" name="mode" id="mode">
									<?php if($mode=="Easy") { echo '<option selected="">Easy</option>'; } else { echo '<option>Easy</option>'; } if($mode=="Normal") { echo '<option selected="">Normal</option>'; } else { echo
									'<option>Normal</option>'; } if($mode=="Tough") { echo '<option selected="">Tough</option>'; } else { echo '<option>Tough</option>'; } ?>
								</select>
							</div>
							<br />
							<div class="form-group">
								<div class="checkbox">
									<label class="checkbox inline">
										<input <?php if ($mul=="on") echo 'checked="true"'; ?>
										type="checkbox" name="mul" /> Enable multiple background images for captcha [More Secure]
									</label>
								</div>
							</div>
							<br />
							<div class="form-group">
								<label>
									Allowed characters
								</label>
								<input type="text" name="allowed" placeholder="Enter allowed characters list..." value="<?php echo $allowed; ?>" class="form-control" />
							</div>
							<div class="form-group">
								<label>
									Captcha text color
								</label>
								<input type="text" name="color" placeholder="Enter captcha text color..." value="<?php echo $color; ?>" class="form-control" />
							</div>
                            </div></div>
							<input type="submit" name="save" value="Save" class="btn btn-primary"/>
							<br />
					</div>
					<!-- /.box-body -->
				</form>
			</div>
			<!-- /.box -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
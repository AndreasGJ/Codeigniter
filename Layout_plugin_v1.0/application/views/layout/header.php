<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Layout: header.php
*/
$data = (isset($data) && $data ? $data : false);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('layout/head', array('data' => $data)); ?>
	</head>
	<body class="<?php if(current_url() == site_url()) echo ' frontpage';?>">
		<div id="page">
			<header id="header">
				<div class="header-inner">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-3 logo-field">
								<a class="logo-link" href="<?php echo site_url(); ?>">
									Logo
								</a>
							</div><!-- .fh-logo-field -->
							<div class="col-xs-12 col-sm-8 col-md-9 mainmenu-field">
								<?php $this->load->view('layout/mainmenu', array('data' => $data)); ?>
							</div><!-- .fh-mainmenu-field -->
						</div><!-- .row -->
					</div><!-- .container -->
				</div><!-- .header-inner -->
			</header>
			<section id="content">
				<div class="content-field">
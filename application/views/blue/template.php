<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/reset.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/text.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/grid.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/layout.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/nav.css" media="screen" />
		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../../../css/ie6.css" media="screen" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../../../css/ie.css" media="screen" /><![endif]-->
		<script type="text/javascript" src="<?php echo base_url();?>script/script.js"></script>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jquery.validity/jquery.validity.css" />
        <script type="text/javascript" src="<?php echo base_url();?>jquery.validity/jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>jquery.validity/jquery.validity.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>jquery.validity/main.js"></script>
	</head>
	<body>
		<div class="container_16">
			<div class="grid_16">
				<h1 id="branding">
					<a href="<?php echo base_url(); ?>"><?php echo $title; ?></a>
				</h1>
			</div>
			<div class="clear"></div>
			<div class="grid_16">
				<?php $this->load->view($menu); ?>
			</div>
			<div class="clear"></div>
			<div class="grid_16">
				<h2 id="page-heading"></h2>
			</div>
			<div class="clear"></div>
			<div class="grid_3">
				<?php $this->load->view($sidebar_left); ?>
			<div class="grid_9">
				<div class="box">
					<h2><?php echo $heading; ?></h2>
					<?php $this->load->view($content);?>
				</div>
			</div>
			<div class="grid_4">
				<?php $this->load->view($sidebar_right); ?>
			</div>
			<div class="clear"></div>
			<div class="grid_16" id="site_info">
				<div class="box">
					<p align="center"><?php echo $title; ?> <?php echo $owner; ?></p>
					<?php if(($address != '') || ($phone_number != '') || ($fax != '') || ($email != '')): ?>
					<p align="center"><?php if($address != ''): ?>Alamat: <?php echo $address; ?> <?php endif; ?><?php if($phone_number != ''): ?>Telepone: <?php echo $phone_number; ?> <?php endif; ?><?php if($fax != ''): ?>Fax:<?php echo $fax; ?> <?php endif; ?><?php if($email != ''): ?>Email:<?php echo $email; ?><?php endif; ?></p>
					<?php endif; ?>
					<p align="center"></p>
					<p align="center"><?php echo $footer; ?></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<script type="text/javascript" src="<?php echo base_url(); ?>script/modal-window.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>style/blue/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>style/blue/js/jquery-fluid16.js"></script>
	</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $title; ?></title>

		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../../../css/ie6.css" media="screen" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../../../css/ie.css" media="screen" /><![endif]-->
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/reset.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/text.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/grid.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/layout.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>style/blue/css/nav.css" media="screen" />
		
		
		<!--JQUERY-->
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>script/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>style/blue/js/jquery-fluid16.js"></script>
		
		<!--Datatables-->
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>datatables/js/jquery.dataTables.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>datatables/css/demo_table_jui.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				$('#example').dataTable( {
							"bJQueryUI": true,
							"sPaginationType": "full_numbers",
							"bAutoWidth": true,
							//"bSort": false,
							"aoColumnDefs": [
								{ "bSortable": false, "aTargets": [ ] }
							],
							"oLanguage": {
								"sSearch": "Cari Data:",
								"sLengthMenu": "Menampilkan _MENU_ data per halaman",
								"sInfo": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
								"sInfoEmpty": "Menampilkan 0 sampai 0 dari total 0 data",
								"sInfoFiltered": "(jumlah data yang ada: _MAX_)",
								"sZeroRecords": "Data Tidak Ditemukan"
							},
						} );
			} );
		</script>
		
		<!--Token Input-->
		<script type="text/javascript" src="<?php echo base_url();?>tokeninput/src/jquery.tokeninput.js"></script>
		<link rel="stylesheet" href="<?php echo base_url();?>tokeninput/styles/token-input-facebook.css" type="text/css" />
		
		<!--Script-->
		<script type="text/javascript" src="<?php echo base_url();?>script/script.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>script/modal-window.js"></script>
		
		<!--CHOSEN-->
		<link rel="stylesheet" href="<?php echo base_url();?>chosen/chosen.css" />
		
		<!--Validity-->
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>jquery.validity/jquery.validity.css" />
        <script type="text/javascript" src="<?php echo base_url();?>jquery.validity/jquery.validity.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>jquery.validity/main.js"></script>		
		
		<!--Tiny MCE-->
		<script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript">
			tinyMCE.init({
				mode : "exact",
				elements : "info,about",
				theme : "advanced",
				skin : "o2k7",
				theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,cleanup"
			});
		</script>

		<script type="text/javascript">
			$(document).ready(function() {
				$('#loader').hide();
				
				$('#show_heading').hide();

				$('#journal_id').change(function(){
					$('#path').fadeOut();
					$('#loader').show();
					$.post("<?php echo base_url().'mahasiswa/get_url';?>", {
						journal_id: $('#journal_id').val(),
						paper_id: $('#paper_id').val(),
					}, function(response){
						
						setTimeout("finishAjax('path', '"+escape(response)+"')", 400);
					});
					return false;
				});
			});

			function finishAjax(id, response){
			  $('#loader').hide();
			  $('#show_heading').show();
			  $('#'+id).html(unescape(response));
			  $('#'+id).fadeIn();
			} 
		</script>

		<script type="text/javascript">			
			$(document).ready(function() {	
				//select all the a tag with name equal to modal
				$('a[name=modal]').click(function(e) {
				
					//Cancel the link behavior
					e.preventDefault();
					
					//Get the A tag
					var id = $(this).attr('href');
					
					//Get the screen height and width
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();
					
					//Set heigth and width to mask to fill up the whole screen
					$('#mask').css({'width':maskWidth,'height':maskHeight});
					
					//transition effect		
					$('#mask').fadeIn(1000);	
					$('#mask').fadeTo("slow",0.8);	
					
					//Get the window height and width
					var winH = $(window).height();
					var winW = $(window).width();

					//Set the popup window to center
					$(id).css('top',  winH/2-$(id).height()/2);
					$(id).css('left', winW/2-$(id).width()/2);

					//transition effect
					$(id).fadeIn(2000); 
				});
				
				//if close button is clicked
				$('.window .close').click(function (e) {
					//Cancel the link behavior
					e.preventDefault();
					$('#mask').hide();
					$('.window').hide();
				});		

				//if mask is clicked
				$('#mask').click(function () {
					$(this).hide();
					$('.window').hide();
				});			

				$(window).resize(function () {
					var box = $('#boxes .window');

					//Get the screen height and width
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();

					//Set height and width to mask to fill up the whole screen
					$('#mask').css({'width':maskWidth,'height':maskHeight});

                    //Get the window height and width
					var winH = $(window).height();
					var winW = $(window).width();

					//Set the popup window to center
					box.css('top',  winH/2 - box.height()/2);
					box.css('left', winW/2 - box.width()/2);
				});
			});
		</script>
	</head>
	<body>
		<div class="container_16">
			<div class="grid_16">
				<?php $this->load->view($menu); ?>
			</div>
			<div class="clear"></div>
			<div class="grid_16">
				<h2 id="page-heading"><a href="<?php echo base_url().$this->uri->segment(1); ?>"><?php echo $title; ?></a></h2>
				<noscript><font color="red"><b>Javascript Tidak Terdeteksi Pada Browser yang Anda Pakai, Aktifkan Javascript Atau Gunakan Browser Lain</b></font></noscript>
			</div>
			<div class="clear"></div>
			<div class="grid_6 suffix_6">
				<div class="box">
					<h2><a href="#" id="toggle-search">Cari Publikasi</a></h2>
					<div class="block" id="search">
						<form id="search" name="search" method="post" action="<?php echo base_url().$this->uri->segment(1).'/search'; ?>" class="search" onSubmit="return paper_search_check(search)">
							<p>
								<input type="text" id="keyword" name="keyword" onBlur="white_space(keyword)" onKeyPress="return disableEnterKey(event)" />
								<select name="option" id="option">
									<option value="title">Judul</option>
									<option value="author">Penulis</option>
								</select>
								<input class="search button" type="submit" value="Cari" />
							</p>
						</form>
					</div>
				</div>
			</div>
			<div class="grid_4">
				<div class="box">
					<h2><?php echo tgl_indo(date("Y-m-d")); ?></h2>
					<div class="block">
						<p><?php if($user_detail): ?>Selamat datang <a href="<?php echo base_url().$this->session->userdata('user_type').'/profile';?>"><?php echo $user_detail->full_name; ?></a><?php else: ?>Tidak ada detail mengenai pengguna<?php endif; ?></p>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="grid_12">
				<div class="box">
					<h2><?php echo $heading; ?></h2>
					<?php $this->load->view($content);?>
				</div>
			</div>
			<div class="grid_4">
				<?php $this->load->view($sidebar_user); ?>
			</div>
			<div class="clear"></div>
			<div class="grid_16" id="site_info">
				<div class="box">
					<p align="center"><?php echo $title; ?> <?php echo $owner; ?></p>
					<?php if(($address != '') || ($phone_number != 0) || ($fax != '') || ($email != '')): ?>
					<p align="center"><?php if($address != ''): ?>Alamat: <?php echo $address; ?> <?php endif; ?><?php if($phone_number != ''): ?>Telepone: <?php echo $phone_number; ?> <?php endif; ?><?php if($fax != ''): ?>Fax:<?php echo $fax; ?> <?php endif; ?><?php if($email != ''): ?>Email:<?php echo $email; ?><?php endif; ?></p>
					<?php endif; ?>
					<p align="center"></p>
					<p align="center"><?php echo $footer; ?></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>		
		<script type="text/javascript" src="<?php echo base_url();?>chosen/chosen.jquery.js"></script>
		<script type="text/javascript"> $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true}); </script>
		<script type="text/javascript">
		$('a.title').click(function(){
			  var target = $(this).closest('div').next('div');
			  var mode = target.is(':visible');
			  target.siblings('div.reply').hide();
			  if(!mode) target.show(); else target.hide();
		 });
		</script>
	</body>
</html>
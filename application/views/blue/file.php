<!DOCTYPE html>
<html lang="en">
<head>
<title>Menampilkan File</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>script/acrobat_detection.js"></script>
</head>
<body>
	<div id="container">
	<h1>Menampilkan File</h1>
<script type="text/javascript">
	var browser_info = perform_acrobat_detection();
	if(browser_info.acrobat == "installed"){
		document.write('<p>File Sedang Ditampilkan. Silakan Tunggu...</p>');
		window.location.href = "<?php echo base_url().$this->uri->segment(1).'/preview/'.$paper_id; ?>";
	}else{
		document.write('<p>Browser yang Anda gunakan tidak mendukung file dokumen PDF. Silakan unduh file <a href="<?php echo base_url().$this->uri->segment(1).'/download/'.$paper_id; ?>">disini</a></p>');
	}
</script>
	</div>
</body>
</html>
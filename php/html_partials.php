<?php

	function OpenHTMLDefaultApplication($title, $body=NULL) {
		$wrap = "";
		$head = "<head> \n <title>" . $title . "</title>";
		$meta = "	<meta charset='utf-8'>
		            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
		            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />  
		            <meta name='viewport' content='width=device-width, initial-scale=1'>
		            <meta name='description' content=''>
		            <meta name='author' content=''>";

		/* add global css imports here */
		$css = '
				<link href="assets/css/main.css" rel="stylesheet">
				<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
				<link href="assets/css/dashboard.css" rel="stylesheet">
				<link href="assets/css/animate-custom.css" rel="stylesheet">
				<link href="assets/css/icomoon.css" rel="stylesheet">
				<link href="assets/css/scaffolds.scss" rel="stylesheet">
				
		';

		/* add global javascript imports here */
		$javascripts = '
		       	<script src="https://code.jquery.com/jquery-2.2.2.min.js"> </script>
						<script src="assets/javascripts/interact.js"></script>
						<script src="assets/javascripts/jquery.easing.1.3.js"></script>
						<script src="assets/javascripts/jquery-func.js"></script>
						<script src="assets/javascripts/modernizr.custom.js"></script>
						<script src="assets/javascripts/retina.js"></script>
						<script src="assets/javascripts/smoothscroll.js"></script>
						<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
						<script src="assets/javascripts/dropdown.js"></script>

		';

		$shim = '<!--[if lt IE 9]>
				<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js">
  				</script>
				<![endif]--> </head>';

		$openbody = '<body data-spy="scroll" data-offset="0" data-target="#navbar-main">';
		$openbody = $wrap . $head . $meta . $javascripts . $css . $shim . $openbody;
		$closebody = '</body>';

		if (is_null($body)) {
			return $openbody;
		} else {
			return $openbody + $body + $closebody;
		}
	}

	function closeHTMLDefaultApplication() {
		return '</body>';
	}

	function genNavBar() {
			$navbar = '
		  	<div id="navbar-main">
		      <!-- Fixed navbar -->
		    <div class="navbar navbar-inverse navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="icon icon-shield" style="font-size:30px; color:#3498db;"></span>
		          </button>
		          <a class="navbar-brand hidden-xs hidden-sm" href="#home"><span class="icon icon-shield" style="font-size:18px; color:#3498db;"></span></a>
		        </div>
		        <div class="navbar-collapse collapse">
		          <ul class="nav navbar-nav">
		            <li><a href="/#home" class="smoothScroll">Home</a></li>
					<li> <a href="/#about" class="smoothScroll"> About</a></li>
					<li> <a href="/#make-location" class="smoothScroll"> Contact</a></li>
		        </div><!--/.nav-collapse -->
		      </div>
		    </div>
		    </div>
			';
		return $navbar;
	}

	function openGenNavBarHome() {
		$navbar = '
		  	<div id="navbar-main">
		      <!-- Fixed navbar -->
		    <div class="navbar navbar-inverse navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="icon icon-shield" style="font-size:30px; color:#3498db;"></span>
		          </button>
		          <a class="navbar-brand hidden-xs hidden-sm" href="#home"><span class="icon icon-shield" style="font-size:18px; color:#3498db;"></span></a>
		        </div>
		        <div class="navbar-collapse collapse">
		          <ul class="nav navbar-nav">
		            <li><a href="#home" class="smoothScroll">Home</a></li>
					<li> <a href="#about" class="smoothScroll"> About</a></li>
					<li> <a href="#make-location" class="smoothScroll"> Contact</a></li>
			';
		return $navbar;
	}

	function closeNavBar() {
		$closenav = '
										</div><!--/.nav-collapse -->
								    </div>
								    </div>
								    </div>';
		return $closenav;
	}
?>
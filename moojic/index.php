<?php
include 'fbaccess.php' ;
$_SESSION['j']=1;
?>
<!DOCTYPE HTML>
<!--
	TXT 2.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>TXT by HTML5 UP</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700|Open+Sans+Condensed:700" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>

		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	<body class="homepage">

		<!-- Header -->

			<header id="header">
				<div class="logo">
					<div>
						<h1 style="margin-top:-2px";><a href="#" id="logo">Moojic</a></h1>
						
					</div>
				</div>
			</header>
		<!-- /Header -->

		<!-- Nav -->
			<nav id="nav" class="skel-panels-fixed">
				<ul>
					<li class="current_page_item"><a href="index.html">Home</a></li>
					<li><a href="http://www.moojic.com">Go to Moojic.com</a></li>
					
				</ul>
			</nav>
		<?php  include 'tmhOAuth/examples/auth.php'; ?>
                 <!-- /Nav -->
		
		<!-- Banner -->
			<div id="banner-wrapper">
				<section id="banner">
					<h2>Be the DJ wherever you go!!</h2>
					<span class="byline">Login</span>
					<?php 
                    echo '<a href='.$loginUrl.' class="button">Sign in with Facebook</a>';
                     ?>
			<a href="?authenticate=1" class="button">Sign in with Twitter</a>
                        	
				</section>
			</div>
		<!-- /Banner -->

		<!-- Main -->
			
							<!-- Features -->
								

		<!-- Footer -->
			<footer id="footer" class="container">
				
				<div class="row">
					<div class="12u">

						<!-- Contact -->
							<section>
								<h2 class="major"><span>Get in touch</span></h2>
								<ul class="contact">
									<li><a href="#" class="facebook">Facebook</a></li>
									<li><a href="http://twitter.com/n33co" class="twitter">Twitter</a></li>
									<li><a href="http://n33.co/feed/" class="rss">RSS</a></li>
									<li><a href="http://dribbble.com/n33" class="dribbble">Dribbble</a></li>
									<li><a href="#" class="linkedin">LinkedIn</a></li>
									<li><a href="#" class="googleplus">Google+</a></li>
								</ul>
							</section>
						<!-- /Contact -->
					
					</div>
				</div>
				<div class="row">

					<!-- Copyright -->
						<div id="copyright">
							&copy; 2012 Moojic.com | Images: <a href="http://fotogrph.com">fotogrph</a> + <a href="http://iconify.it">Iconify.it</a> | Design: <a href="http://html5up.net/">HTML5 UP</a>
						</div>
					<!-- /Copyright -->

				</div>
			</footer>
		<!-- /Footer -->

	</body>
</html>

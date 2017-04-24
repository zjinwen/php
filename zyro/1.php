<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Home</title>
	<base href="{{base_url}}" />
			<meta name="viewport" content="width=992" />
		<meta name="description" content="" />
	<meta name="keywords" content="" />
	
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>

	<link href="css/site.css?v=1.1.40" rel="stylesheet" type="text/css" />
	<link href="css/common.css?ts=1486362175" rel="stylesheet" type="text/css" />
	<link href="css/1.css?ts=1486362175" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">var currLang = '';</script>		
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>


<body>{{ga_code}}<div class="root"><div class="vbox wb_container" id="wb_header">
	
<div id="wb_element_instance0" class="wb_element"><ul class="hmenu"><li class="active"><a href="Home/" target="_self" title="Home">Home</a></li><li><a href="%E8%AF%95%E5%94%B1%E7%BB%83%E8%80%B3/" target="_self" title="试唱练耳">试唱练耳</a></li><li><a href="%E4%B9%90%E5%99%A8/" target="_self" title="乐器">乐器</a></li><li><a href="Contacts/" target="_self" title="Contacts">Contacts</a><ul><li><a href="About/" target="_self" title="About">About</a></li></ul></li></ul></div><div id="wb_element_instance1" class="wb_element"><img alt="heart" src="gallery_gen/3189934774aa880fa7fbf8da8f9e446d_100x100.png"></div><div id="wb_element_instance2" class="wb_element" style=" line-height: normal;"><h5 class="wb-stl-subtitle">Lovely</h5></div></div>
<div class="vbox wb_container" id="wb_main">
	
<div id="wb_element_instance4" class="wb_element" style=" line-height: normal;"><h1 class="wb-stl-heading1">How does it work?</h1></div><div id="wb_element_instance5" class="wb_element" style=" line-height: normal;"><h2 class="wb-stl-heading2">You will find the latest information about us on this page. Our company is constantly evolving and growing. We provide wide range of services. Our mission is to provide best solution that helps...</h2>
<p> </p>
<p class="wb-stl-normal">Everyone. If you want to contact us, please fill the contact form on our website. We wish you a good day! You will find the latest information about us on this page. Our company is constantly evolving and growing. We provide wide range of services. Our mission is to provide best solution that helps everyone. If you want to contact us, please fill the contact form on our website. We wish you a good day! You will find the latest...</p></div><div id="wb_element_instance6" class="wb_element"><a class="wb_button" href="About/"><span>Exclusive offer</span></a></div><div id="wb_element_instance7" class="wb_element" style=" line-height: normal;"><h4 class="wb-stl-pagetitle">Welcome</h4>

<p><span class="wb-stl-highlight">Please insert information that will be useful to your customers here Please insert information that will be useful to your customers here... </span></p>
</div><div id="wb_element_instance8" class="wb_element"><img alt="star" src="gallery_gen/8ff953dd97c4405234a04291dee39e0b_256x256.png"></div><div id="wb_element_instance9" class="wb_element"><img alt="iconmonstr-christmas-gift-2-icon-256" src="gallery_gen/d4d0fdf821c12f48109b0ad9120b4b9c_256x256.png"></div><div id="wb_element_instance10" class="wb_element" style="width: 100%;">
			<?php
				global $show_comments;
				if (isset($show_comments) && $show_comments) {
					renderComments(1);
			?>
			<script type="text/javascript">
				$(function() {
					var block = $("#wb_element_instance10");
					var comments = block.children(".wb_comments").eq(0);
					var contentBlock = $("#wb_main");
					contentBlock.height(contentBlock.height() + comments.height());
				});
			</script>
			<?php
				} else {
			?>
			<script type="text/javascript">
				$(function() {
					$("#wb_element_instance10").hide();
				});
			</script>
			<?php
				}
			?>
			</div></div>
<div class="vbox wb_container" id="wb_footer" style="height: 141px;">
	
<div id="wb_element_instance3" class="wb_element" style=" line-height: normal;"><p class="wb-stl-footer">© 2017 <a href="http://101game.esy.es">101game.esy.es</a></p></div><div id="wb_element_instance11" class="wb_element" style="text-align: center; width: 100%;"><div class="wb_footer"></div><script type="text/javascript">
			$(function() {
				var footer = $(".wb_footer");
				var html = (footer.html() + "").replace(/^\s+|\s+$/g, "");
				if (!html) {
					footer.parent().remove();
					footer = $("#wb_footer");
					footer.height(74);
				}
			});
			</script></div></div><div class="wb_sbg"></div></div></body>
</html>

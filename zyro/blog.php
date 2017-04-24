<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Blog</title>
	<base href="{{base_url}}" />
			<meta name="viewport" content="width=992" />
		<meta name="description" content="" />
	<meta name="keywords" content="Blog" />
	
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>

	<link href="css/site.css?v=1.1.40" rel="stylesheet" type="text/css" />
	<link href="css/common.css?ts=1486362175" rel="stylesheet" type="text/css" />
	<link href="css/blog.css?ts=1486362175" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">var currLang = '';</script>		
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>


<body>{{ga_code}}<div class="root"><div class="vbox wb_container" id="wb_header">
	
<div id="wb_element_instance63" class="wb_element"><ul class="hmenu"><li><a href="Home/" target="_self" title="Home">Home</a></li><li><a href="%E8%AF%95%E5%94%B1%E7%BB%83%E8%80%B3/" target="_self" title="试唱练耳">试唱练耳</a></li><li><a href="%E4%B9%90%E5%99%A8/" target="_self" title="乐器">乐器</a></li><li><a href="Contacts/" target="_self" title="Contacts">Contacts</a><ul><li><a href="About/" target="_self" title="About">About</a></li></ul></li></ul></div><div id="wb_element_instance64" class="wb_element"><img alt="heart" src="gallery_gen/3189934774aa880fa7fbf8da8f9e446d_100x100.png"></div><div id="wb_element_instance65" class="wb_element" style=" line-height: normal;"><h5 class="wb-stl-subtitle">Lovely</h5></div></div>
<div class="vbox wb_container" id="wb_main">
	
<div id="wb_element_instance67" class="wb_element" style="width: 100%;">
			<?php
				global $show_comments;
				if (isset($show_comments) && $show_comments) {
					renderComments(blog);
			?>
			<script type="text/javascript">
				$(function() {
					var block = $("#wb_element_instance67");
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
					$("#wb_element_instance67").hide();
				});
			</script>
			<?php
				}
			?>
			</div></div>
<div class="vbox wb_container" id="wb_footer" style="height: 141px;">
	
<div id="wb_element_instance66" class="wb_element" style=" line-height: normal;"><p class="wb-stl-footer">© 2017 <a href="http://101game.esy.es">101game.esy.es</a></p></div><div id="wb_element_instance68" class="wb_element" style="text-align: center; width: 100%;"><div class="wb_footer"></div><script type="text/javascript">
			$(function() {
				var footer = $(".wb_footer");
				var html = (footer.html() + "").replace(/^\s+|\s+$/g, "");
				if (!html) {
					footer.parent().remove();
					footer = $("#wb_footer");
					footer.height(61);
				}
			});
			</script></div></div><div class="wb_sbg"></div></div></body>
</html>

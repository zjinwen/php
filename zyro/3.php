<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Contacts</title>
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
	<link href="css/3.css?ts=1486362175" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">var currLang = '';</script>		
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>


<body>{{ga_code}}<div class="root"><div class="vbox wb_container" id="wb_header">
	
<div id="wb_element_instance22" class="wb_element"><ul class="hmenu"><li><a href="Home/" target="_self" title="Home">Home</a></li><li><a href="%E8%AF%95%E5%94%B1%E7%BB%83%E8%80%B3/" target="_self" title="试唱练耳">试唱练耳</a></li><li><a href="%E4%B9%90%E5%99%A8/" target="_self" title="乐器">乐器</a></li><li class="active"><a href="Contacts/" target="_self" title="Contacts">Contacts</a><ul><li><a href="About/" target="_self" title="About">About</a></li></ul></li></ul></div><div id="wb_element_instance23" class="wb_element"><img alt="heart" src="gallery_gen/3189934774aa880fa7fbf8da8f9e446d_100x100.png"></div><div id="wb_element_instance24" class="wb_element" style=" line-height: normal;"><h5 class="wb-stl-subtitle">Lovely</h5></div></div>
<div class="vbox wb_container" id="wb_main">
	
<div id="wb_element_instance26" class="wb_element" style=" line-height: normal;"><h5 class="wb-stl-subtitle">Contacts</h5></div><div id="wb_element_instance27" class="wb_element" style=" line-height: normal;"><h2 class="wb-stl-heading2"><span class="wb-stl-highlight">Please insert information that will be...<span style="background-color: transparent;">Useful to your customers here Please insert...</span><span style="background-color: transparent;">Information that will be useful to...</span></span></h2></div><div id="wb_element_instance28" class="wb_element" style=" line-height: normal;"><h3 class="wb-stl-heading3">+1 212 736 3100</h3>
<h3 class="wb-stl-heading3">Empire State Building</h3>
<h3 class="wb-stl-heading3">350 5th Ave</h3>
<h3 class="wb-stl-heading3">New York</h3>
<h3 class="wb-stl-heading3">NY 10118</h3>
<h3 class="wb-stl-heading3">USA</h3></div><div id="wb_element_instance29" class="wb_element"><form class="wb_form" method="post"><input type="hidden" name="wb_form_id" value="b231aeca"><textarea name="message" rows="3" cols="20" class="hpc"></textarea><table><tr><th class="wb-stl-normal">Name&nbsp;&nbsp;</th><td><input type="hidden" name="wb_input_0" value="Name"><input class="form-control form-field" type="text" value="" name="wb_input_0"></td></tr><tr><th class="wb-stl-normal">E-mail&nbsp;&nbsp;</th><td><input type="hidden" name="wb_input_1" value="E-mail"><input class="form-control form-field" type="text" value="" name="wb_input_1"></td></tr><tr class="area-row"><th class="wb-stl-normal">Message&nbsp;&nbsp;</th><td><input type="hidden" name="wb_input_2" value="Message"><textarea class="form-control form-field form-area-field" rows="3" cols="20" name="wb_input_2"></textarea></td></tr><tr class="form-footer"><td colspan="2"><button type="submit" class="btn btn-default">Send</button></td></tr></table></form><script type="text/javascript">
			<?php global $wb_form_id; if (isset($wb_form_id) & $wb_form_id == "b231aeca") { ?>
				var formValues = <?php echo json_encode($_POST); ?>;
				var formErrors = <?php global $formErrors; echo json_encode($formErrors); ?>;
				wb_form_validateForm("b231aeca", formValues, formErrors);
				<?php global $wb_form_send_state; if (isset($wb_form_send_state) && $wb_form_send_state) { ?>
					setTimeout(function() {
						alert("<?php echo addcslashes($wb_form_send_state, "\\'\"&\n\r\0\t<>"); ?>");
					}, 1);
					<?php $wb_form_send_state = null; ?>
				<?php } ?>
			<?php } ?>
			</script></div><div id="wb_element_instance30" class="wb_element"><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;key=&amp;sensor=false&amp;libraries=places&amp;region=US&amp;language=en_US"></script><script type="text/javascript">
				function initialize() {
					if (window.google) {
						var div = document.getElementById("wb_element_instance30");
						var ll = new google.maps.LatLng(40.7484405,-73.98566440000002);
						var map = new google.maps.Map(div, {
							zoom: 16,
							center: ll,
							mapTypeId: "roadmap"
						});
						
						var marker = new google.maps.Marker({
							position: ll,
							clickable: false,
							map: map
						});
					}
				}
				google.maps.event.addDomListener(window, "load", initialize);
			</script></div><div id="wb_element_instance31" class="wb_element" style="width: 100%;">
			<?php
				global $show_comments;
				if (isset($show_comments) && $show_comments) {
					renderComments(3);
			?>
			<script type="text/javascript">
				$(function() {
					var block = $("#wb_element_instance31");
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
					$("#wb_element_instance31").hide();
				});
			</script>
			<?php
				}
			?>
			</div></div>
<div class="vbox wb_container" id="wb_footer" style="height: 141px;">
	
<div id="wb_element_instance25" class="wb_element" style=" line-height: normal;"><p class="wb-stl-footer">© 2017 <a href="http://101game.esy.es">101game.esy.es</a></p></div><div id="wb_element_instance32" class="wb_element" style="text-align: center; width: 100%;"><div class="wb_footer"></div><script type="text/javascript">
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


	<footer>

	</footer>


	<!-- JavaScript at the bottom for fast page loading -->

	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url();?>js/libs/jquery-1.7.1.min.js"><\/script>')</script>

	<!-- scripts concatenated and minified via build script -->

	<script src="<?php echo base_url();?>js/libs/sammy.js"></script>
	<script src="<?php echo base_url();?>js/libs/knockout.js"></script>
	<script src="<?php echo base_url();?>js/plugins.js"></script>
	<script src="<?php echo base_url();?>js/script.js"></script>
	<script>var result = jQuery.parseJSON('<?php echo $map;?>');</script>
	<script src="<?php echo base_url();?>js/view/browse.js">
	</script>
	<!-- end scripts -->

	<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
			 mathiasbynens.be/notes/async-analytics-snippet -->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>
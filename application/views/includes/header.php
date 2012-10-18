<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<!-- Use the .htaccess and remove these lines to avoid edge case issues.
			 More info: h5bp.com/i/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>
	<meta name="description" content="">

	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
	<link rel="stylesheet/less" type="text/css" href="<?php echo base_url();?>css/styles.less">
	<script src="<?php echo base_url();?>js/libs/less.js" type="text/javascript"></script>

	<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

	<!-- All JavaScript at the bottom, except this Modernizr build.
			 Modernizr enables HTML5 elements & feature detects for optimal performance.
			 Create your own custom Modernizr build: www.modernizr.com/download/ -->
	<script src="<?php echo base_url();?>js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body >
	<!-- oncontextmenu="return false;"
	Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
			 chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<header>
	<!--fb:login-button autologoutlink='true' id='loginButton'></fb:login-button-->
    <div id="fb-root"></div>
    <img id="logo" src="<?php echo base_url();?>images/botoslogo.png" />
    <?php 
    	//$attributes = array( 'id' => 'search-form', 'data-bind' => 'hasFocus: searchIsSelected');
		//echo form_open('browse/search', $attributes);?>
		<div id="search-form" tabindex="-1">
			<input type="text" name="term" id="search-input" data-bind="value: queryString, valueUpdate: 'keyup'">
			<input type="submit" name="submit" value="search" id="search-button">
			<div id="search-results">
				<!--div class="header" >
					<h2>Search Results</h2>
				</div-->
				<div class="content">
					<ul>
						<li class="category" data-bind="visible: searchResultsFolders().length > 0">Folders</li>
		    		<!-- ko foreach: searchResultsFolders -->
		      			<li class="directory" data-bind="class: $data.file_type">
					        <a class='directory-link' data-bind="text: $data.shortened_name, attr: { title: $data.file_name, href: '<?php echo base_url();?>#'+$data.file_path.substr(6) }"></a>
					    </li>
		    		<!-- /ko -->
		    			<li class="category" data-bind="visible: searchResultsFiles().length > 0">Files</li>
		    		<!-- ko foreach: searchResultsFiles -->
		      			<li class="file" data-bind="class: $data.file_type">
					        <a class='directory-link' data-bind="text: $data.shortened_name, attr: { title: $data.file_name,  href: '<?php echo base_url();?>files/'+$data.file_path }"></a>
					    </li>
		    		<!-- /ko -->
					</ul>
				</div>
			</div>
		</div>
	<?php 
		//echo form_close();
	?>
	</header>
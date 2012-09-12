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
					        <a class='directory-link' data-bind="text: $data.shortened_name, attr: { title: $data.file_name, href: '<?php echo base_url();?>files/'+$data.file_path }"></a>
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
	<div id="sidebar">
		<ul>
			<li><a class="download" href="#">Download</a></li>
			<li><a class="upload" href="#">Upload</a></li>
		</ul>
	</div>
	<div role="main" id="main">
		<h1>Please enter the subject: </h1>
		<input type="text" name="term" id="subject-input" data-bind="value: subjectQueryString, valueUpdate: 'keyup'">
		<ul data-bind="visible: subjectQueryString().length > 0">
			<!-- ko foreach: subjectSearchResultsFolders -->
        	 <li data-bind="text: $data.file_name"></li>
    		<!-- /ko -->
    		<li>Add New</li>
		</ul>
	</div>
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
	<script>
			//$('#first-level').tinyscrollbar();
		$("#search-input").on('keyup', function(){
			if(	$(this).val() != ""){
				$("#search-results").show();
			}
			else
				$("#search-results").hide();
		});

		$("#search-form").click(function(event){
			 event.stopPropagation();
		});
		$("#search-form").blur(function(){
			$("#search-results").hide();
		});
		function positionSearchResults(){
			$( "#search-results" ).position({
				of: $( "#search-input" ),
				my: "left bottom",
				at: "left top",
				offset: "0 -5",
				//collision: $( "#collision_horizontal" ).val() + " " + $( "#collision_vertical" ).val()
			});
		};
		// This is a simple *viewmodel* - JavaScript that defines the data and behavior of your UI

		function FolderViewModel() {
		    // Data
		    var self = this;

			self.queryString = ko.observable("");
			self.searchResultsDirectories = ko.computed(function(){
				if(self.queryString() != ""){
					$.post('<?php echo base_url();?>index.php/browse/search', { 'term' :  self.queryString()}, function(data){
			        	var s_data = jQuery.parseJSON(data);
			        	self.searchResultsFiles(s_data.files);
			        	self.searchResultsFolders(s_data.directory);
			        	return (s_data.directory);
			        	//console.log($(this).children().first().val());
			        });
				}
			});
			self.searchResultsFiles = ko.observableArray();
			self.searchResultsFolders = ko.observableArray();
			self.resulsExists = ko.computed(function(){
				//positionSearchResults();
				if((self.searchResultsFolders().length + self.searchResultsFiles().length > 0) && (self.searchIsSelected()) && (self.queryString() != "")){
					return true;
				}
				else
					return false;
			});

			self.searchIsSelected = ko.observable(false);

			self.subjectQueryString = ko.observable("");
			self.subjectSearchResults = ko.computed(function(){
				if(self.subjectQueryString() != ""){
					$.post('<?php echo base_url();?>index.php/upload/subject_search', { 'term' :  self.subjectQueryString()}, function(data){
			        	var s_data = jQuery.parseJSON(data);
			        	console.log(s_data);
			        	//return s_data;
			        	//self.subjectSearchResults(s_data.files);
			        	self.subjectSearchResultsFolders(s_data);
			        	//return (s_data.directory);
			        	//console.log($(this).children().first().val());
			        });
				}
			});
			self.subjectSearchResultsFolders = ko.observableArray();
			/*self.resulsExists = ko.computed(function(){
				//positionSearchResults();
				if((self.searchResultsFolders().length + self.searchResultsFiles().length > 0) && (self.searchIsSelected()) && (self.queryString() != "")){
					return true;
				}
				else
					return false;
			});

			self.searchIsSelected = ko.observable(false);*/



		    // Behaviours    

		    // Client-side routes
			Sammy(function() {
		    	
		    }).run(); 

		};

		ko.applyBindings(new FolderViewModel());


		//jQuery(document).ready(function($){
			//Getting rid of the fourth column when clicking anywhere else
			$('html').click(function() {
				//undoFourth();
				$("#search-results").hide();
				//$("#search-results").hide();
			});
			$('#fourth-level, #third-level').click(function(event){
				 event.stopPropagation();
			});
			
		//});
	</script>

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
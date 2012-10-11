
	<div id="sidebar">
		<ul>
			<li><a class="download" href="#">Download</a></li>
			<li><a class="upload" href="#">Upload</a></li>
		</ul>
	</div>
	<div id="wrap">
		<ul id="breadcrumb">
			<li><a href="#Arts and Architecture">Home</a></li>
		</ul>
		<div role="main" id="main">
			<div id="first-level" class="level-container">
					<ul class="folders">
					<!-- ko foreach: folders -->
		      			<li class="directory" data-bind=" css: { active: $data.path.split('/').last() == $root.firstLevelActive()}, click: $root.goToLevels">
					        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path}"></a>
					    </li>
		    		<!-- /ko -->
		    		<!-- ko foreach: files -->
		      			<li class="file" data-bind="  class: $data.type">
					        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path }"></a>
					    </li>
		    		<!-- /ko -->
					</ul>
			</div>
			<div id="second-level" class="level-container">
				<ul class="folders">
				<!-- ko foreach: secondLevelFolders -->
	      			<li class="directory" data-bind=" css: {active: $data.path.split('/').last() == $root.secondLevelActive()}, click: $root.goToLevels">
				        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path}"></a>
				    </li>
	    		<!-- /ko -->
	    		<!-- ko foreach: secondLevelFiles -->
	      			<li class="file" data-bind="class: $data.type">
				        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path }"></a>
				    </li>
	    		<!-- /ko -->
				</ul>
			</div>
			<div id="third-level" class="level-container">
			</div>
		</div>
	</div>



	<div id="sidebar">
		<ul>
			<li><a class="download" href="#">Download</a></li>
			<li><a class="upload" href="#">Upload</a></li>
		</ul>
	</div>
	<div role="main" id="main">
		<div id="first-level" class="level-container">
			<div class="scrollbar">
				<div class="track">
					<div class="thumb">
						<div class="end"></div>
					</div>
				</div>
			</div>
			<div class="viewport">
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
			<ul class="folders">
			<!-- ko foreach: thirdLevelFolders -->
      			<li class="directory" data-bind=" css: { active: $data.path.split('/').last() == $root.thirdLevelActive() }, click: $root.goToLevels">
			        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path}"></a>
			    </li>
    		<!-- /ko -->
    		<!-- ko foreach: thirdLevelFiles -->
      			<li class="file" data-bind=" class: $data.type">
			        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path }"></a>
			    </li>
    		<!-- /ko -->
			</ul>
		</div>
		<div id="fourth-level" class="level-container">
			<ul class="folders">
			<!-- ko foreach: fourthLevelFolders -->
      			<li class="directory">
			        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path}"></a>
			    </li>
    		<!-- /ko -->
    		<!-- ko foreach: fourthLevelFiles -->
      			<li class="file" data-bind=" class: $data.type">
			        <a class='directory-link' data-bind="text: $data.name, attr: { href: '<?php echo base_url();?>files/'+$data.path }"></a>
			    </li>
    		<!-- /ko -->
			</ul>
		</div>
	</div>


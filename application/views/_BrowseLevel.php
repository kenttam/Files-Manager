<?php /* old template
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
?*/
?>

<ul class="folders">
	<?php 
	foreach ($directories as $key => $value) {
		/*echo $value["path"];
		echo $value["name"];
		echo $value["type"];*/?>
		<li class="directory">
			<a class='directory-link' href="<?php echo base_url().'files/'.$value['path'];?>"><?php echo $value['name']?></a>
		</li>
	<?php 
	}

	foreach($files as $key => $value){?>
		<li class="directory">
			<a class='directory-link' href="<?php echo base_url().'files/'.$value['path'];?>"><?php echo $value['name']?></a>
		</li>
	<?php 
	}
	?>
</ul>
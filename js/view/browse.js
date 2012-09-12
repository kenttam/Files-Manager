var base_url = "/test_bank";


$(document).ready(function(){
	$('#first-level').jScrollPane();
});

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

$('html').click(function() {
	undoFourth();
	$("#search-results").hide();
});
$('#fourth-level, #third-level').click(function(event){
	 event.stopPropagation();
});




// This is a simple *viewmodel* - JavaScript that defines the data and behavior of your UI
	//Map is the array of folders and files passed from the model

function FolderViewModel() {
    // Data
    var self = this;

    self.folders = ko.observableArray(result.directories);
    self.files = ko.observableArray(result.files);
    self.firstLevelActive = ko.observable();

    self.secondLevelFolders = ko.observableArray();
	self.secondLevelFiles = ko.observableArray();
	self.secondLevelActive = ko.observable();

    self.thirdLevelFolders = ko.observableArray();
	self.thirdLevelFiles = ko.observableArray();
	self.thirdLevelActive = ko.observable();

	self.fourthLevelFolders = ko.observableArray();
	self.fourthLevelFiles = ko.observableArray();

	self.fourthLevelVisible = ko.observable();

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
		/*else{
			self.searchResultsFiles();
	        self.searchResultsFolders();
		}*/
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


    // Behaviours    
    self.goToLevels = function(folder) { 
		location.hash = folder.path;	
    };

    self.goToLevel4 = function(folder) { 
        //alert(folder.path);
        $.get('<?php echo base_url();?>index.php/browse/directory_map', {  'directory' :  folder.path}, function(data){
        	var s_data = jQuery.parseJSON(data);
        	self.fourthLevelFolders(s_data.directories);
        	self.fourthLevelFiles(s_data.files);
        	//alert(d);
        });
    };


    // Client-side routes
	Sammy(function() {
		//gotolevel2
        this.get(/\#(.*)/, function(){ 
        	var route = this.params.splat[0];
        	var level = route.split("/").length;  // this would tell me which level I'm on
        	browse.goToLevel(route, level);	
        	/*$.get( base_url+'/browse/directory_map', { 'directory' : route } , function(data){
	        	var s_data = jQuery.parseJSON(data);
	        	//self.secondLevelFolders(s_data.directories);
	        	//self.secondLevelFiles(s_data.files);
	        });*/
        });

        //gotolevel3
       	this.get('#:subject/:course', function(){ //level2
       		if(!$("#second-level").find("a").html()){
		        $.get(base_url+'/browse/directory_map', { 'directory' :  this.params.subject}, function(data){
		        	var s_data = jQuery.parseJSON(data);
		        	self.secondLevelFolders(s_data.directories);
		        	self.secondLevelFiles(s_data.files);
		        	//alert(s_data);
		        });
		        self.firstLevelActive(this.params.subject);
	    	}	
	    	//third level
        	$.get(base_url+'/browse/directory_map', { 'directory' :  this.params.subject+"/"+this.params.course}, function(data){
	        	var s_data = jQuery.parseJSON(data);
	        	self.thirdLevelFolders(s_data.directories);
	        	self.thirdLevelFiles(s_data.files);
	        	//alert(s_data);
	        });
	        self.secondLevelActive(this.params.course);
	        undoFourth();
	        self.thirdLevelActive("");

        });

       	//gotolevel4
        this.get('#:subject/:course/:folder', function(){
	        if(!$("#third-level").find("a").html()){
		        $.get(base_url+'/browse/directory_map', { 'directory' :  this.params.subject+"/"+this.params.course}, function(data){
		        	var s_data = jQuery.parseJSON(data);
		        	self.thirdLevelFolders(s_data.directories);
		        	self.thirdLevelFiles(s_data.files);
		        	//alert(s_data);
		        });
		        self.secondLevelActive(this.params.course);
		    }
	        if(!$("#second-level").find("a").html()){
		        $.get('base_url+/browse/directory_map', { 'directory' :  this.params.subject}, function(data){
		        	var s_data = jQuery.parseJSON(data);
		        	self.secondLevelFolders(s_data.directories);
		        	self.secondLevelFiles(s_data.files);
		        	//alert(s_data);
		        });
		        self.firstLevelActive(this.params.subject);
	    	}	

	    	$.get(base_url+'/browse/directory_map', { 'directory' :  this.params.subject+"/"+this.params.course+"/"+this.params.folder}, function(data){
	        	var s_data = jQuery.parseJSON(data);
	        	self.fourthLevelFolders(s_data.directories);
	        	self.fourthLevelFiles(s_data.files);
	        	//alert(s_data);
	        });
	        self.thirdLevelActive(this.params.folder);
	       	//animation
	        $("#second-level").animate({marginLeft: "-235px"}, function(){
				$("#fourth-level").show();
			});
        });
    	
    }).run(); 

};

ko.applyBindings(new FolderViewModel());

function undoFourth(){
	if($('#fourth-level').css('display') == "block"){
		$('#fourth-level').hide();
		$("#second-level").animate({marginLeft: "0"});
	}
	$(".custom-menu").hide(); //custom menu
}

function positionSearchResults(){
	$( "#search-results" ).position({
		of: $( "#search-input" ),
		my: "left bottom",
		at: "left top",
		offset: "0 -5",
	});
};

var browse = {
	init: function(){

	},
	goToLevel: function(route, level){
        $.get(base_url+'/browse/directory_map2', { 'directory' : route } , function(data){
    		$(".level-container").eq(level).children(".viewport").html(data);
    	});
	}
}
	

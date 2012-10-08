var base_url = "/test_bank";


$(document).ready(function(){
	browse.init();
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

$('#fourth-level, #third-level').click(function(event){
	 event.stopPropagation();
});


$("#search-form").click(function(event){
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
			$.post(base_url+'/browse/search', { 'term' :  self.queryString()}, function(data){
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

var browse = {
	folder : false,
	currentLevelContainer: null,
	init: function(){
		this.goToLevel("", 0);
		$(".level-container").on("click", ".directory-link", this.changeLocation);
		$(".level-container").on("click", ".directory-link", this.makeLinkActive);
		$("#search-form").blur(this.hideSearchResults);
		$("html").click(this.hideSearchResults);
	},
	goToLevel: function(route, level){
        $.get(base_url+'/browse/directory_map2', { 'directory' : route } , function(data){
        	/*if(level >= $(".level-container").length){
        		//browse.createNewLevel();
        		//browse.removeHigherLevel(browse.currentLevelContainer);
        	}
        	else{
    			$(".level-container").eq(level).html(data).jScrollPane();
    		}*/
    		$(".level-container").eq(level).html(data).jScrollPane();
    	});
	},
	changeLocation: function(){
		location.hash = $(this).attr("data-path");
		browse.currentLevelContainer = $(this).parents(".level-container");

		var index = $(".level-container").index(browse.currentLevelContainer);
		var length = $(".level-container").length;

		var level = 4 - (length - index);

		switch(level){
			case 1:
				//if first stack has more than one or more than 3 total level then shift
				//else no shift so need to clear third
				browse.firstLevelClick();
				break;
			case 2:
				//never initiates a shift
				break;
			case 3:
				//always shifts
				//create new column
				browse.createNewLevel();
				browse.shiftAllLevels();
				break;
			default:
				break;
		}

		return false;
	},
	hideSearchResults: function(){
		$("#search-results").hide();
	},
	makeLinkActive: function(){
		//remove all "active" from the current level 
		var currentLevelContainer = $(this).parents(".level-container");
		currentLevelContainer.find(".active").removeClass("active");
		$(this).parent().addClass("active");
	},
	createNewLevel: function(){
		$("#main").append("<div class='level-container'></div>");
		var $levelContainer = $(".level-container");
		$levelContainer.last().css("left", 900);
	},
	shiftAllLevels: function(){
		var $levelContainer = $(".level-container");
		var numLevels = $levelContainer.length;
		$levelContainer.eq(numLevels - 1).animate({"left": "-=300"});
		$levelContainer.eq(numLevels - 2).animate({"left": "-=300"});
		$levelContainer.eq(numLevels - 3).animate({"left": "-=300"});
	},
	firstLevelClick: function(){
		//if first stack has more than one or more than 3 total level then shift
		//else no shift so need to clear third
		var $levelContainer = $(".level-container");
		var numLevels = $levelContainer.length;
		if(numLevels > 3){
			$levelContainer.eq(numLevels-2).animate({"left": "+=300"});
			$levelContainer.eq(numLevels-3).animate({"left": "+=300"});
			$levelContainer.eq(numLevels-1).remove();
		}
		else{
			$levelContainer.eq(numLevels-1).html("");
		}

	},
	removeHigherLevel: function(currentLevelContainer){
		//only happens by clicking on first
		//only need to clear third level



		/*var $levelContainer = $(".level-container");
		var currentLevel = $levelContainer.index(currentLevelContainer);
		var levelCount = $levelContainer.length;
		for (var x = currentLevel+1; x < levelCount; x++){
			$levelContainer.eq(x).html("");
		}

		if(levelCount > 3 && currentLevel <= levelCount - 1){ 
			//must have levels folded
			//the current level will have to go to the second slot
			var lastValidLevel = currentLevelContainer.animate({"left": "600px"})
				.next().animate({"left": "900px"});
			var lastIndex = currentLevel+1;
			for(var x = levelCount; x > currentLevel + 1; x--){
				$levelContainer.last().remove();
			}
		}*/
			
		//slide levels back if needed
	}
}
	

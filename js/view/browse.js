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

/*$(document).bind("contextmenu", function(event) { 
    event.preventDefault();
    $("<div class='custom-menu'><a href='/test_bank/browse/zip_file' target='_blank'>Download as zip</a></div>")
        .appendTo("body")
        .css({top: event.pageY + "px", left: event.pageX + "px"});
}).bind("click", function(event) {
    $("div.custom-menu").hide();
});*/

$("#main").on("contextmenu", ".directory-link", function(event){
	var path = $(this).attr("data-path");
    event.preventDefault();
    $("<div class='custom-menu'><a href='/test_bank/browse/zip_file' target='_blank'>Download as zip</a></div>")
        .appendTo("body")
        .css({top: event.pageY + "px", left: event.pageX + "px"});
});

$(document).click(function(){
	$("div.custom-menu").hide();
});


function FolderViewModel() {
    // Data
    var self = this;

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



};

ko.applyBindings(new FolderViewModel());


Sammy(function() {
	//gotolevel2
    this.get(/\#(.*)/, function(){ 
    	var route = this.params.splat[0];
    	var level = route.split("/").length;  // this would tell me which level I'm on
    	browse.goToLevel(route, level, false);

    	var currentLevels = route.split("/");
    	var lastHashArray = browse.lastHash.split("/");

    	if(currentLevels.length > 1 &&currentLevels[currentLevels.length-2] != lastHashArray[currentLevels.length-2]){
    		var subroute = route.substr(0, route.length - currentLevels.last().length);
    		browse.goToLevel(subroute, level-1, false);
    	}

    	if(browse.currentLevel < level && level >= 3){ //added a level
    		browse.createNewLevel();
			browse.shiftAllLevels();
    	}
    	else if (browse.currentLevel > level){ //removed a level
    		browse.firstLevelClick();
    	}
    	browse.currentLevel = level;
    	browse.lastHash = route;



    	var temp = "";
    	
    	for(var x = 0; x < currentLevels.length; x++){ //this is for backbuttons where the levels already exists
    		temp += currentLevels[x] + "/";
    		browse.makeLinkActiveCallback(temp, x+1);
    	}
    	if(currentLevels.length < $(".level-container active").length){
    		var currentLength = currentLevels.length;
    		while(currentLength < $(".level-container active").length){
    			$(".level-container").eq($(".level-container active").length).find("active").removeClass("active");

    		}
    	}

    	browse.makeBreadcrumb();
    	//browse.changeLocation();	
    });
	
}).run(); 

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
	currentLevel: window.location.hash === "" ? 0 : window.location.hash.split("/").length,
	returned:0,
	lastHash : window.location.hash.substr(1),
	levelQueue : $({}),
	init: function(){
		this.initializeLevels();
		$(".level-container").on("click", ".directory-link", this.changeLocation);
		$(".level-container").on("click", ".directory-link", this.makeLinkActive);
		$("#search-form").blur(this.hideSearchResults);
		$("html").click(this.hideSearchResults);
		$("#breadcrumb").on("click", "a", this.followBreadcrumb);
		$("#search-results").on("click", ".directory .directory-link", function(){browse.refreshPage($(this).attr("href"))});
	},
	initializeLevels: function(){
		var hash = window.location.hash.substr(1);
		var hashArray = hash.split("/");
		this.goToLevel("", 0, true);
		var temp = "";
		for(var x = 0; x < hashArray.length; x++){
			if(hashArray[x] == ""){
				continue;
			}

			if(x+1 > 2){
				this.createNewLevel();
				this.shiftAllLevels();
			}

			temp += hashArray[x]+"/";
			this.goToLevel(temp, x+1, true);

		}
		this.makeBreadcrumb();
		
	},
	goToLevel: function(route, level, initCall){
        $.get(base_url+'/browse/directory_map2', { 'directory' : route } , function(data){
    		$(".level-container").eq(level).html(data).jScrollPane();    			//var routeArray = route.split("/");
    			//var folderClicked = routeArray[routeArray.length - 2]; //second to last element
    		if(route.substr(-1) != "/"){ //to make data consistent
    			route+="/";
    		}
    		browse.levelQueue.queue('level',function(next){
    			browse.makeLinkActiveCallback(route, level);
    			next();
    		});
    		browse.returned++;
    		if(browse.returned === $(".level-container").length || (browse.returned == 2 && $(".level-container").length == 3 && $(".length-container").eq(2).text() == "" && window.location.hash.substr(0, window.location.hash.length-1 ).split("/").length == 1)){
    			browse.levelQueue.dequeue('level');
    			browse.returned = 0;
    		}
    		/*callbacks.add(browse.makeLinkActiveCallback);
    		callbacks.fire([route, level]);*/
    	});
	},
	makeLinkActiveCallback: function(route, level){
	    $(".level-container").eq(level-1).find(".active").removeClass("active");
		$(".level-container").eq(level-1).find("a[data-path='"+route.substr(0, route.length-1)+"']").parent().addClass("active");
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
		$levelContainer.last().on("click", ".directory-link", this.changeLocation);
		$levelContainer.last().on("click", ".directory-link", this.makeLinkActive);
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
	makeBreadcrumb: function(){
		route = window.location.hash;
		var routeArray = route.split("/");
		var temp = "";
		var breadcrumbHtml = "<li><a href='/test_bank'>Root</a></li>";
		for(var x = 0; x < routeArray.length; x++){
			if(routeArray[x].length === 0){
				continue;
			}
			if(x === 0){
				routeArray[x] = routeArray[x].substr(1);
			}
			temp += routeArray[x];
			breadcrumbHtml += ("<li><a href='#"+temp+"'>"+routeArray[x]+"</a></li>");
			temp += "/";
		}
		$("#breadcrumb").html(breadcrumbHtml);
	},
	followBreadcrumb: function(){
		//follow breadcrumb that are farther back so just gonna refresh the page
		var $li = $(this).parent(),
			index = $("#breadcrumb li").index($li),
			length = $("#breadcrumb").find("li").length,
			hash = $(this).attr("href");
		if(index < length - 2) {
			//document.location.reload();
			browse.refreshPage(hash);
		}

	},
	refreshPage: function(hash){
		window.location.hash = hash;
		$("body").fadeOut("fast", function(){
			document.location.reload();
		});
	}
}
	

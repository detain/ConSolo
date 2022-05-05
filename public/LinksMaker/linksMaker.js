/* 
 Copyright (C) Philippe Meyer 2019
 Distributed under the MIT License
 LinksMaker v 0.62 : mobile friendly idea by Norman Tomlins => make links more easily on touch devices just by clicking 
*/
let LM_Factory_Lists = null;

(function ( $ ) {
	const errMsg  = "LinksMaker error : "
	var factory;
	var data = {};
	var listsNr = 0;
	var listNames = [];
	var listA = [];
	var listB = [];
	var chosenListA = ""
	var chosenListB = ""
	
	var dropDownForLists = null;
	var canvasTopMarg = 0;
	var $leftDiv,$midDiv,$rightDiv,$canvas;
	
	var canvasId = "";
	var canvasCtx = null;
	var canvasPtr = null;
	var canvasWidth = 0;
	var canvasHeight = 0;
	var canvasTopMargin;
	var onError = false;
	var className = "linksMaker";
	var linksByName=[];	
	var ListHeights1 = [];
	var ListHeights2 = [];	
	var move = null;
	var that = null;
	var lineStyle = "straight"; // straight or square-ends
	var handleColor = "#CF0000,#00AD00,#0000AD,#FF4500,#00ADAD,#AD00AD,#582900,#FFCC00,#000000,#33FFCC".split(",");
	var lineColor = "black";
	var autoDetect = "off";
	var associationMode = "oneToOne";
	var canvasTopOffset = 0;
	var isDisabled = false;
	var globalAlpha = 1;
	var isTouchScreen = is_touch_device();
	let mobileClickIt = isTouchScreen;
	
	var draw = function () {
		
		var tablesAB = chosenListA+"|"+chosenListB;

		//{"tables":tablesAB,"from":infos.nameA,"to":infos.nameB}
	    canvasCtx.globalAlpha = globalAlpha;
		canvasCtx.beginPath(); 
		canvasCtx.fillStyle = 'white';
		canvasCtx.strokeStyle = lineColor;
		canvasCtx.clearRect(0, 0, canvasWidth, canvasHeight);
			
		var links = linksByName.filter(function(x){
			return x.tables == tablesAB;
			
		});	

		
		links.forEach(function(item,i){
			var positionA = listA.indexOf(item.from);
			var positionB = listB.indexOf(item.to);
			
			if(positionB == -1 || positionA == -1){
				console.log("error link names unknown");
				return;
			}
			var Ax = 0;
			var Ay = ListHeights1[positionA];

			var Bx = canvasWidth;
			var By = ListHeights2[positionB];
		
			canvasCtx.beginPath(); 
			
			canvasCtx.moveTo(Ax, Ay);
			var handleCurrentColor = handleColor[positionA%handleColor.length];
			if(lineStyle == "square-ends"){
				canvasCtx.fillStyle = handleCurrentColor;
				canvasCtx.strokeStyle = handleCurrentColor;
				canvasCtx.rect(Ax, Ay-4, 8, 8);
				canvasCtx.rect(Bx-8, By-4, 8, 8);
				canvasCtx.fill();
				
				canvasCtx.moveTo(Ax+8, Ay);
				canvasCtx.lineTo(Ax+16, Ay);
				canvasCtx.lineTo(Bx-16, By);
				canvasCtx.lineTo(Bx-8, By);
				canvasCtx.stroke();
			}else{
				canvasCtx.strokeStyle = handleCurrentColor;
				canvasCtx.lineTo(Bx, By);
				canvasCtx.stroke();
			}
			
		});
	}
		
	var makeLink  = function(infos){
		var tablesAB = chosenListA+"|"+chosenListB;
		var already = false;
		
		var test = linksByName.filter(function(x){
			return x.tables == tablesAB && x.to == infos.nameB && x.from == infos.nameA; 
		});
		
		if(test.length > 0) already = true;
		
		if(!already){
		if(associationMode=="oneToOne"){
			for(var i = linksByName.length-1; i >=0 ;i--){
				if(linksByName[i].tables == tablesAB && linksByName[i].to == infos.nameB){
					linksByName.splice(i,1);
				}
			}
			for(var i = linksByName.length-1; i >=0 ;i--){
				if(linksByName[i].tables == tablesAB && linksByName[i].from == infos.nameA){
					linksByName.splice(i,1);
				}
			}
		}
		
		linksByName.push({"tables":tablesAB,"from":infos.nameA,"to":infos.nameB});
		
		$("body").trigger({
		    type: "fieldLinkerUpdate",
		    what: "addLink"
		});
		}
		draw();


	}

	var eraseLinkA = function (nameA) {
		var tablesAB = chosenListA+"|"+chosenListB;
		
		for(var i = linksByName.length-1; i >=0 ;i--){
			if(linksByName[i].tables == tablesAB && linksByName[i].from == nameA){
				linksByName.splice(i,1);
			}
		}
		draw();
		$("body").trigger({
		    type: "fieldLinkerUpdate",
		    what: "removeLink"
		});
	}

	var eraseLinkB = function (nameB) {
		var tablesAB = chosenListA+"|"+chosenListB;
		
		for(var i = linksByName.length-1; i >=0 ;i--){
			if(linksByName[i].tables == tablesAB && linksByName[i].to == nameB){
				linksByName.splice(i,1);
			}
		}
		draw();
		$("body").trigger({
		    type: "fieldLinkerUpdate",
		    what: "removeLink"
		});
	}
	
	var readUserPreferences = function(){
		if(data.options.className){
			className = data.options.className;
		}

		if(data.options.lineStyle){
			if(data.options.lineStyle=="square-ends")
				lineStyle = "square-ends";
		}		
		
		if(data.options.lineColor){
			lineColor = data.options.lineColor;
		}
		
		if(data.options.handleColor){
			handleColor = data.options.handleColor.split(",");
		}
		
		if(data.options.associationMode){
			associationMode = data.options.associationMode;
		}

		if (data.options.canvasTopOffset) {
			canvasTopOffset = data.options.canvasTopOffset;
		}
	}
	
	var fillChosenLists = function(){
		listNames = [];
		listA = [];
		listB = [];
		if(chosenListA == "" || chosenListB == ""){
			chosenListA = data.Lists[0].name;
			chosenListB = data.Lists[1].name;
		}
		data.Lists.forEach(function(x){
			listNames.push(x.name);
			if(x.name == chosenListA){
				x.list.forEach(function(y){
					listA.push(y);
				});
			}
			if(x.name == chosenListB){
				x.list.forEach(function(y){
					listB.push(y);
				});
			}
		});
	}
	
	var makeDropDownForLists = function(){
		dropDownForLists = $("<select></select>");
		dropDownForLists
			.css("width","100%");

		listNames.forEach(function(x){
			var $option = $("<option></option>")
			$option
				.val(x)
				.text(x)
				.appendTo(dropDownForLists);
		});
		
	}
	
	var drawColumnsAtLoadTime = function(){
		
		$(factory).html("");
				
		var $main = $("<div></div>");
		$main
			.appendTo($(factory))
			.addClass("FL-main "+className)
			.css({"position":"relative","width":"100%","text-align":"left"});
		
		$leftDiv =  $("<div></div>");
		$leftDiv
			.appendTo($main)
			.addClass("FL-left")
			.css({ "float": "left", "width": "40%", "display": "inline-block", "text-align": "left", "white-space": "nowrap" })
			.append(dropDownForLists.clone());
			
		$leftDiv.find("select")
			.attr("id","select1")
			.val(chosenListA)
			.on("change",function(){
				chosenListA = $(this).val();
				fillChosenLists();
			})
	
		$midDiv =  $("<div></div>");
		$midDiv
			.appendTo($main)
			.addClass("FL-mid")
			.css({ "display": "inline-block", "width": "20%" });
			
		$rightDiv =  $("<div></div>");
		$rightDiv
			.appendTo($main)
			.addClass("FL-right")
			.css({"float":"right","width":"40%","display":"inline-block","text-align":"left","white-space": "nowrap"})
			.append(dropDownForLists.clone());
			
			$rightDiv.find("select")
				.attr("id","select2")
				.val(chosenListB)
				.on("change",function(){
					chosenListB = $(this).val();
					fillChosenLists();
				});
			
		var $ul =  $("<ul></ul>");
		$ul
		.appendTo($leftDiv)
		.css({"text-align":"left","list-style":"none"})
		
		if(data.options.buttonErase){
			var $btn =  $("<button></button>");
			$btn 
				.appendTo($(factory).find(".FL-main"))
				.attr("type","button")
				.addClass("btn btn-danger  btn-sm eraseLink")
				.html(data.options.buttonErase);
		}
	}
	var drawColumnsContentA = function(){
		var $ulA =	$(".FL-left ul");
		if($ulA.length == 1){
			$ulA.empty();
		}else{

			$ulA =  $("<ul></ul>");
		}
		$ulA 
			.appendTo($leftDiv)
			.attr("data-col",chosenListA)
			.css({"text-align":"left","list-style":"none"});
			
		listA.forEach(function(x,i){
			var $li =  $("<li></li>");
			$li
				.appendTo($ulA)
				.attr("data-offset",i)
				.attr("data-name",x)
				.css({"width":"100%","position": "relative"});
				
			var $div =$("<div></div>");	
			$div
				.appendTo($li)
				.attr("ondrop","LM_drop(event)")
				.attr("ondragover","LM_allowDrop(event)")
				.attr("ondragstart","LM_drag(event)")
				.attr("draggable","true")
				.css({"width":"80%"})
				.text(x);
				
			
			var $eraseIcon = $("<i></i>");
			$eraseIcon 
				.appendTo($li)
				.addClass("fa fa-undo unlink")
				.attr("draggable","false")
				.css({"right":"28px","color":"#aaa","position": "absolute","top":"50%","transform": "translateY(-50%)"});
			var $pullIcon = $("<i></i>");
			$pullIcon 
				.appendTo($li)
				.addClass("fa fa-arrows-alt link")
				.attr("draggable","false")
				.css({"right":"8px","color":"#aaa","position": "absolute","top":"50%","transform": "translateY(-50%)"});
		});
		
	// Computing the vertical offset of the middle of each cell.
	ListHeights1 = [];
	$(factory).find(".FL-main .FL-left li").each(function(i){
		var position = $(this).position();
		var hInner = $(this).height();
		var hOuter = $(this).outerHeight();
		var delta = Math.floor(0.5 + (hOuter - hInner)/2);
		var midInner = Math.floor(0.5 + hInner/2);
		var midHeight = position.top + midInner - delta -1;
		ListHeights1.push(midHeight);
		if (i == 0) {
			canvasTopMarg = position.top;
		}
	});
	

	if(!mobileClickIt){	
			// On mousedown in left List : 
		$(factory).find(".FL-main .FL-left li").off("mousedown").on("mousedown",function(e){
			// we make a move object to keep track of the origine and also remember that we are starting a mouse drag (mouse is down)
			if (isDisabled) return;
			move = {};
			move.offsetA = $(this).data("offset");
			move.nameA = $(this).data("name");
			move.offsetB = -1;
			move.nameB = -1;
		});
		
		$(factory).find(".FL-main .FL-left li").off("mouseup").on("mouseup", function (e) {
			if (isDisabled) return;
			// We do a mouse up on le teft side : the drag is canceled
			move=null;
		});
		
		$(factory).find(".FL-main .FL-left li").off("click").on("click", function (e) {
			if (isDisabled) return;
			eraseLinkA($(this).parent().data("name"));
			draw();
		});
	}else{
		$(factory).find(".link").off("click").on("click",function(e){
			if (isDisabled) return;
			move = {};
			move.offsetA = $(this).parent().data("offset");
			move.nameA = $(this).parent().data("name");
			move.offsetB = -1;
			move.nameB = -1;
		});
	}
	
	$(factory).find(".unlink").off("click").on("click", function (e) {
		if (isDisabled) return;
		eraseLinkA($(this).parent().data("name"));	
		draw();
	});
}

	var drawColumnsContentB = function(){
		var $ulB =	$(".FL-right ul");
		
		if($ulB.length == 1){
			$ulB.empty();
		}else{
			$ulB =  $("<ul></ul>");
		}
		
		$ulB
			.appendTo($rightDiv)
			.attr("data-col",chosenListB)
			.css({"text-align":"left","list-style":"none"})
			

		listB.forEach(function(x,i){			
			var $li =  $("<li></li>");
			$li
				.appendTo($ulB)
				.attr("data-offset",i)
				.attr("data-name",x)
				.attr("draggable","true");
				
			var $div =$("<div></div>");	
			$div
				.appendTo($li)
				.attr("ondrop","LM_drop(event)")
				.attr("ondragover","LM_allowDrop(event)")
				.attr("ondragstart","LM_drag(event)")
				.attr("draggable","true")
				.css({"width":"80%"})
				.text(x);
				
		});
		
		// Computing the vertical offset of the middle of each cell.
		ListHeights2 = [];
		$(factory).find(".FL-main .FL-right li").each(function(i){
			var position = $(this).position();
			var hInner = $(this).height();
			var hOuter = $(this).outerHeight();
			var delta = Math.floor(0.5 + (hOuter - hInner)/2);
			var midInner = Math.floor(0.5 + hInner/2);
			var midHeight = position.top + midInner - delta;
			ListHeights2.push(midHeight);
		});
		
		// Mouse up on the right side 
		$(factory).find(".FL-main .FL-right li").off("mouseup").on("mouseup", function (e) {
			if (isDisabled) return;
			if(move != null){ // no drag 
				if(associationMode=="oneToOne"){
					eraseLinkB($(this).data("name")); // we erase an existing link if any
				}
				move.offsetB = $(this).data("offset");
				move.nameB = $(this).data("name");
				var infos =  JSON.parse(JSON.stringify(move));
				move = null;
				makeLink(infos);
			}
		});
	
		$(factory).find(".FL-main .FL-right li").off("dblclick").on("dblclick", function (e) {
		if (isDisabled) return;
			eraseLinkB($(this).data("name")); // we erase an existing link if any
			draw();
		});
		
	if(mobileClickIt){
		$(factory).find(".FL-right li").off("click").on("click", function (e) {
			if (isDisabled) return;
			if(move != null){ 
				move.offsetB = $(this).data("offset");
				move.nameB = $(this).data("name");
				var infos =  JSON.parse(JSON.stringify(move));
				move = null;
				makeLink(infos);
			}
		});
	}
	
	// mousemove over a right cell
	$(factory).find(".FL-main .FL-right li").off("mousemove").on("mousemove",function(e){
		if (isDisabled) return;
		if(move != null){ // drag occuring

			var _from = move.offsetA;
			var _To = $(this).data("offset");
			 
			var Ax = 0;
			var Ay = ListHeights1[_from];
			 
			var Bx = canvasWidth;
			var By = ListHeights2[_To];
			 
			draw();
			canvasCtx.beginPath(); 
			var color= handleColor[_from%handleColor.length];
			canvasCtx.fillStyle = 'white';
			canvasCtx.strokeStyle = color;
			
			canvasCtx.moveTo(Ax, Ay);
			canvasCtx.lineTo(Bx, By);
			canvasCtx.stroke();
		}
	});
	
	}

var createCanvas = function(){
	
   canvasId = "cnv_"+Date.now();
		
		var w = $midDiv.width();	
		var h2 = $rightDiv.height();	
		var h1 = $leftDiv.height();	
		var h = h1 >= h2 ? h1 : h2;
		$canvas =  $("<canvas></canvas>");
		
		$canvas
			.appendTo($midDiv)
			.attr("id",canvasId)
			.css({"width": w+"px","height":h+"px"});
		
		canvasWidth = w;
		canvasHeight = h;		
		canvasPtr= document.getElementById(canvasId);
		canvasPtr.width = canvasWidth;
		canvasPtr.height = canvasHeight;
		canvasCtx = canvasPtr.getContext("2d");

		canvasTopMargin = canvasTopOffset;
		

	   $canvas
				.css("margin-top", canvasTopMarg+"px");
	
}

var setListeners = function(){
	
	// Listeners :
	if (data.options.buttonErase) {
		$(factory).find(".FL-main .eraseLink").on("click", function (e) {
			if (isDisabled) return;
			linksByName.length = 0;
			draw();
			$("body").trigger({
				type: "fieldLinkerUpdate",
				what: "removeLink"
			});
		});
	}
	

	// mousemove over the canvas
	$(factory).find("canvas").on("mousemove", function (e) {
		if (isDisabled) return;
		if(move != null){
			canvasCtx.clearRect(0, 0, canvasWidth, canvasHeight);
			// we redraw all the existing links
			draw();
			canvasCtx.beginPath(); 
			// we draw the new would-be link
			var _from = move.offsetA;
			var color= handleColor[_from%handleColor.length];
			canvasCtx.fillStyle = 'white';
			canvasCtx.strokeStyle = color;
			
			var Ax = 0;
			var Ay = ListHeights1[_from];
			// mouse position relative to the canvas
			var Bx = e.offsetX;
			var By = e.offsetY;
			
			canvasCtx.moveTo(Ax, Ay);
			canvasCtx.lineTo(Bx, By);
			canvasCtx.stroke();
		}
	});
	
	$(factory).find(".FL-main").on("mouseup", function (e) {
		if (isDisabled) return;
		if(move!=null){
			move = null;
			draw();
		}
	});
	
	$(".FL-left select").on("change", function (e) {
		if (isDisabled) return;
		chosenListA = $(this).val();
		$(".FL-right select option").each(function(){
			$(this).attr("disabled",$(this).val()==chosenListA);
		});
		drawColumnsContentA();
		draw();
	});
	
	$(".FL-right select").on("change", function (e) {
		if (isDisabled) return;
		chosenListB = $(this).val();
		$(".FL-left select option").each(function(){
			$(this).attr("disabled",$(this).val()==chosenListB);
		});
		drawColumnsContentB();
		draw();
	});
}

	$.fn.linksMaker = function(action,input) {
		factory = this;
		
	    if (action == "init") {
			
			$("body").on("LM_Message_Redraw",function(){
				move=null;
				listA = [];
				listB = [];
				LM_Factory_Lists.Lists.forEach(function(x){
					if(x.name == chosenListA){
						listA = x.list;
					}
					if(x.name == chosenListB){
						listB = x.list;
					}
				});
				drawColumnsContentA();
				drawColumnsContentB();
				draw();
			});
			

	        if(!input){
	            onError = true;
	            console.log(errMsg + "no input parameter provided (param 2)" );
				return;
	        }
	        
	        data = JSON.parse(JSON.stringify(input));
			
			LM_Factory_Lists = data;
			
			if(!data.Lists || data.Lists.length < 2){
				onError = true;
	            console.log(errMsg + "provide at least 2 lists" );
				return;
			}
			
			listsNr = data.Lists.length;
			
			readUserPreferences();
			
			fillChosenLists();
			
			makeDropDownForLists();

			drawColumnsAtLoadTime();
			drawColumnsContentA();
			drawColumnsContentB();
			createCanvas();
			

			setListeners();
			
	        $(".FL-left select").trigger("change");
	        $(".FL-right select").trigger("change");
				
	            if(data.existingLinks){
					linksByName = data.existingLinks.links;
	            }	
				
	            $(window).resize(function() {
	                canvasWidth = $(factory).find(".FL-main .FL-mid").width();
	                canvasPtr.width = canvasWidth;
	                $("#"+canvasId).css("width",canvasWidth+"px");
	                draw();
	            });
	            draw();			
	   
	        return (factory);

	    }else if(action == "eraseLinks"){
	        linksByName.length = 0;
	        draw();
		
		}else if( action === "getLinks") {

				return {
					  "links" : linksByName
				  };  
	
		}else if( action === "changeParameters" ) {
			if(!onError){
				if(input){
					var options = JSON.parse(JSON.stringify(input));
					
					if(options.className){
						className = options.className;
					}
					
					if(options.lineStyle){
						lineStyle =options.lineStyle;
						draw();
					}		
					
					if(options.lineColor){
						lineColor = options.lineColor;
					}
					
					if(options.handleColor){
						handleColor = options.handleColor;
					}
					if(options.associationMode){
						let unicityTokenA = "";
						let unicityTokenB = "";
						let formerAssociation = associationMode;
						associationMode = options.associationMode;
						if(associationMode == "oneToOne" && formerAssociation == "manyToMany"){
							let unicityDict= {};
							for(var i = linksByName.length-1; i >=0 ;i--){
								unicityTokenA = linksByName[i].tables + "_A_" + linksByName[i]["from"];
								unicityTokenB = linksByName[i].tables + "_B_" + linksByName[i]["to"];
								let doDelete = false;
								if(!unicityDict[unicityTokenA]){
									unicityDict[unicityTokenA] = true;
								}else{
									doDelete = true;
								}
								if(!unicityDict[unicityTokenB]){
									unicityDict[unicityTokenB] = true;
								}else{
									doDelete = true;
								}
								if(doDelete){
									linksByName.splice(i,1);
								}
							}
						}
					}
				}
			draw();
			}
		} else if (action == "disable") {
		    isDisabled = true;
		    $(factory)
                .find(".eraseLink")
                .prop("disabled", isDisabled);

		    $(factory)
                .find("li")
                .addClass("inactive");

		    $(factory)
                .find("select")
                .prop("disabled", isDisabled);
				
		    globalAlpha = 0.5;

		    draw();

		    return (that);
		}
		else if (action == "enable") {
		    
		    isDisabled = false;
		    $(factory)
                .find(".eraseLink")
                .prop("disabled", isDisabled);

		    $(factory)
                .find("li")
                .removeClass("inactive");

		    $(factory)
                .find("select")
                .prop("disabled", isDisabled);
				
		    globalAlpha = 1;

		    draw();

		    return (factory);
		} else {
			onError = true;
			console.log(errMsg + "no action parameter provided (param 1)" );
		} 
	}
}( jQuery ));


function LM_allowDrop (ev) {
  ev.preventDefault();
}

function LM_drag(ev) {

	let $target = $(ev.target);
	let data = {};
	data.name = $target.parent().attr("data-name");
	data.col = $target.parent().parent().attr("data-col");
	data.offset = $target.parent().attr("data-offset");

	ev.dataTransfer.setData("text/plain", JSON.stringify({"data":data}));
}

function LM_drop (ev) {
  ev.preventDefault();
  let src = JSON.parse(ev.dataTransfer.getData("text"));
  if(src){
	  src = src.data;
  }
  let $target = $(ev.target);
  	let dest = {};
	dest.name = $target.parent().attr("data-name");
	dest.col = $target.parent().parent().attr("data-col");
	dest.offset = $target.parent().attr("data-offset");

  

if(src.col == dest.col && src.offset != dest.offset && src.name != dest.name){
	  
		LM_Factory_Lists.Lists.forEach(function(x){
			if(x.name == src.col){
				let indexA = x.list.indexOf(src.name);
				let indexB = x.list.indexOf(dest.name);
				if(indexA != -1 && indexB != -1){
					let temp =  x.list[indexA];
					x.list[indexA] = x.list[indexB];
					x.list[indexB] = temp;
				}
			}
		});
		
		$("body").trigger("LM_Message_Redraw")

		
    }
}

function is_touch_device() { // from bolmaster2 - stackoverflow
  var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
  var mq = function(query) {
    return window.matchMedia(query).matches;
  }

  if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
    return true;
  }

  // include the 'heartz' as a way to have a non matching MQ to help terminate the join
  // https://git.io/vznFH
  var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
  return mq(query);
}
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>linksMaker</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- external css -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,500">
	<link rel="stylesheet" href="/lib/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="./linksMaker.css">
	<!-- internal css -->
	<style>
		body{
			font-family: "Roboto,Helvetica Neue",Helvetica,Arial,sans-serif;
		}
		#container{
			padding-top: 20px;
			padding-left:50px;
			width:90%;
		}
		h5 {
			color: #2e44b9;
			font-weight: bold;
			font-size: 24px;;
		}
		/* ---------- */
		#bonds{
			min-width:400px;
			width : 50%;
			min-height:410px;
		}
		.lavender{
			background-color:#E6E6FA;
			padding: 5px 8px 2px 8px;
			border-radius:2px;
			min-width:300px;
		}
		a.btn-back:hover {
			background-image: linear-gradient(to bottom,#ccc 0,#ddd 100%);
		}
		a.btn-back {
			font-family: Tahoma, Calibri, Arial, sans-serif;
			color : grey;
			border-radius: 4px;
			text-decoration: none;
			border: 1px solid #ddd;
			padding: 4px 8px 4px 8px;
			margin:4px;
			background-image: linear-gradient(to bottom,#fff 0,#eee 100%);
		}
		input[type=radio] {
			font-size: 11px;
			cursor: pointer;
		}
		input[type=radio]:before {
			background: white;
			border: 2px solid #337ab7;
			border-radius: 50%;
			margin-top: -2px;
			margin-right: 6px;
			display: inline-block;
			vertical-align: middle;
			content: '';
			width: 14px;
			height: 14px;
		}
		input[type=radio]:checked:before {
			background: #337ab7;
			border-color: #337ab7;
			box-shadow: inset 0px 0px 0px 2px #fff;
		}
		.choices{
			display:inline-block;
			margin-right:40px;
		}
		.choices label{
			font-weight:normal;
			margin-left:4px;
			margin-right:4px;
			vertical-align:8%;
		}
		.nice-group{
			width:680px;
			line-height: 16px;
			padding:10px;
			border:1px solid #ccc;
			background-color:#fff
			border-radius:5px;
		}
		.nice-group legend {
			color: #337ab7;
			width:120px;
			font-size:14px !important;
			border-bottom:none;
		}
	</style>
</head>
<body>
<div id="container">
<div id="linksMakerZone" style="max-width:800px;width:800px;" >
	<fieldset class="nice-group">
		<legend>Change options :</legend>
		<div class="choices">
			<input name="associationMode" type="radio" value="oneToOne" /><label>oneToOne</label>
			<input name="associationMode" type="radio" value="manyToMany" checked="checked" /><label>manyToMany</label>
		</div>
		<div class="choices">
			<input name="enable" type="radio" value="enable" checked="checked"  /><label>Enable</label>
			<input name="enable" type="radio" value="disable" /><label>Disable</label>
		</div>
		<div class="choices">
			<input name="lineStyle" type="radio" value="straight"  /><label>straight</label>
			<input name="lineStyle" type="radio" value="square-ends" checked="checked" /><label>square-ends</label>
		</div>
	</fieldset>
<br/> <br/>	 </div>
<div id="bonds"></div>
<hr/>
<button type="button" class="btn fieldLinkerSave btn-sm btn-primary">Save links</button>
<div id="input"></div>
<div id="output"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="./linksMaker.js"></script>
<?php
    $type = 'emulators';
    $local = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
    $sources = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
    $lists = [];
    foreach ($sources as $sourceId => $sourceData) {
        if (file_exists(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json')) {
            $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
            $lists[] = ['name' => $sourceId, 'list' => array_keys($source)];
        }
    }
    $links = [];
    foreach ($local as $localId => $localData) {
        if (isset($localData['matches'])) {
            foreach ($localData['matches'] as $sourceId => $sourceTypeIds) {
                foreach ($sourceTypeIds as $sourceTypeId) {
                    $links[] = ['tables' => 'local|'.$sourceId, 'from' => $localId, 'to' => $sourceTypeId];
                    foreach ($localData['matches'] as $subSourceId => $subSourceTypeIds) {
                        foreach ($subSourceTypeIds as $subSourceTypeId) {
                            $links[] = ['tables' => $sourceId.'|'.$subSourceId, 'from' => $sourceTypeId, 'to' => $subSourceTypeId];
                        }
                    }
                }
            }
        }
    }
?>
<script>
	var fieldLinks;
	$( document ).ready(function() {
		var input = {
			"existingLinks":{"links":<?php echo json_encode($links); ?>},
			"options":{
				"lineStyle":"square-ends",
				"buttonErase":"Erase Links",
				"associationMode":"manyToMany", // oneToOne,manyToMany
				"handleColor":"Blue,Orange,Green,Brown,Slate,grey,Red,Black,Yellow,darkViolet,Rose,Aqua"
			},
			"Lists":<?php echo json_encode($lists); ?>
		};
		fieldLinks=$("#bonds").linksMaker("init",input);
		$(".fieldLinkerSave").on("click",function(){
			var results = fieldLinks.linksMaker("getLinks");
			$("#output").html("output => " + JSON.stringify(results));
		});
	});
	$("input[name='associationMode']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.linksMaker("changeParameters",{"associationMode":choice});
	});
	$("input[name='enable']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.linksMaker(choice);
	});
	$("input[name='lineStyle']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.linksMaker("changeParameters",{"lineStyle":choice});
	});
</script>
</html>
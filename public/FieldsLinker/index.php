<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>FieldsLinker</title>
	<link rel="icon" href="pi.ico" />    <meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- external css -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,500">
	<link rel="stylesheet" href="/lib/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" SameSite="Lax" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="/lib/bootstrap/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" href="./fieldsLinker.css">
	<!-- internal css -->
	<style>
		body{
			font-family: "Roboto,Helvetica Neue",Helvetica,Arial,sans-serif;
		}
		#container{
			padding-top: 0px;
			padding-left:50px;
			width:90%;
		}
		@media screen and (max-width: 600px) {
			#container{
				padding-top: -10px;
				padding-left:10px;
				width:98%;
			}
		}
		h5 {
			color: #2e44b9;
			font-weight: bold;
			font-size: 24px;;
		}
		/* ---------- */
		label{
			font-weight:300;
			display:inline-block;
		}
		label input[type='radio']{
			vertical-align: top;
		}
		label.active{
			font-weight:600;
			color: #2e44b9;
		}
		.bonds{
			min-width:400px;
			width : 50%;
			min-height:410px;
		}
		.radio-zone{
			padding: 0px 8px 0px 8px;
			border-radius:2px;
			min-width:300px;
		}
		.presentation{
			line-height : 14px;
			font-size : 12px;
		}
		hr{
			margin-bottom : 10px;
			margin-top:10px;
		}
		.fieldLinkerSave {
			display:inline-block;
		}
		input[type=radio] {
			font-size: 11px;
			cursor: pointer;
		}
		input[type=checkbox]::before{
			content: "";
			display: inline-block;
			font-size: inherit;
			float:left;
			font-weight:bold;
			margin-left:0;
			margin-right:2px;
			border: 2px solid #337ab7;
			border-radius : 3px;
			padding : 5px;
			margin-top:0px;
			color:black;
			background: white;
		}
		input[type=checkbox].active::after {
			content: "";
			display: inline-block;
			font-size: inherit;
			float: left;
			transform: rotate(45deg);
			margin-left: 6px;
			margin-top:-13px;
			height: 10px;
			width:  5px;
			color: #337ab7;
			border-bottom: 2px solid #337ab7;
			border-right:  2px solid #337ab7;
		}
		div.action-check.off {
			color: silver;
		}
		div.action-check {
			color: black;
			cursor: pointer;
			font-size: 18px;
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
			margin-left:4px;
			margin-right:4px;
			vertical-align:8%;
		}
		.choices label.group{
			font-weight:bold;
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
	<div id="fieldLinkerZone" style="max-width:800px;width:800px;" >
		<div class="row" >
			<div>
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
					<div class="choices">
						<input name="mobileClickIt" type="checkbox"/><label>mobileClickIt</label>
					</div>
					<div class="choices">
						<label class="group">whiteSpace :</label>
						<input name="whiteSpace" type="radio" value="normal"  /><label>normal</label>
						<input name="whiteSpace" type="radio" value="nowrap" checked="checked" /><label>nowrap</label>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	<hr/>
	<div class="bonds" id="original" style="display:block;">
	</div>
	<hr/>
	<button type="button" class="btn fieldLinkerSave btn-sm btn-primary">Save links</button>
	&nbsp;<span id="output"></span>
	<br /><br />
	<div id="input"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/lib/bootstrap/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="./fieldsLinker.js?v1.03"></script>
<?php
    $sourceId = 'windspro';
    $type = 'emulators';
	$local = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
    $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
    $lists = [
        [
            'name' => 'Local',
            'list' => array_keys($local)
        ],
        [
            'name' => 'WinDSPro',
            'list' => array_keys($source)
        ]
    ];
    $links = [];
    foreach ($local as $localId => $localData) {
        if (isset($localData['matches']) && array_key_exists($sourceId, $localData['matches'])) {
            foreach ($localData['matches'][$sourceId] as $sourceTypeId) {
                $links[] = ['from' => $localId, 'to' => $sourceTypeId];
            }
        }
    }
?>
<script>
	var fieldLinks;
	var inputOri;
	$(document).ready(function () {
		inputOri = {
			"localization": {
			},
			"options": {
				"associationMode": "manyToMany", // oneToOne,manyToMany
				"lineStyle": "square-ends",
				"buttonErase": "Erase Links",
				"displayMode": "original",
				"whiteSpace": $("input[name='whiteSpace']:checked").val(), //normal,nowrap,pre,pre-wrap,pre-line,break-spaces default => nowrap
				"mobileClickIt": false
			},
			"Lists": <?php echo json_encode($lists); ?>,
			"existingLinks": <?php echo json_encode($links); ?>
		};
		$(".fieldLinkerSave").on("click",function(){
			var results = fieldLinks.fieldsLinker("getLinks");
			$("#output").html("output => " + JSON.stringify(results));
		});
		fieldLinks=$("#original").fieldsLinker("init",inputOri);
	});
	$("input[name='associationMode']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.fieldsLinker("changeParameters",{"associationMode":choice});
	});
	$("input[name='enable']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.fieldsLinker(choice);
	});
	$("input[name='lineStyle']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.fieldsLinker("changeParameters",{"lineStyle":choice});
	});
	$("input[name='whiteSpace']").on("click", function () {
		let choice = $(this).val();
		fieldLinks.fieldsLinker("changeParameters",{"whiteSpace":choice});
	});
	$("input[name='mobileClickIt']").on("click", function () {
		let isCheck = $(this).prop("checked");
		if(isCheck)
			$(this).addClass("active");
		else
			$(this).removeClass("active");
		$("#original").html="";
		inputOri.options.mobileClickIt = isCheck;
		fieldLinks=$("#original").fieldsLinker("init",inputOri);
	});
</script>
</html>

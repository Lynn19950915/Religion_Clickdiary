<?php 
	session_start();
	include("db.php"); 

	$today 		= date("Y-m-d"); 
	$yesterday 	= date("Y-m-d",strtotime("-1 day"));
	// $id = $_SESSION['id'];
	
?>
<!doctype html>
<html lang="zh-tw">
<head>
	<title>生活日記</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type="text/javascript">	
		$(document).ready(function(){
			$("#sport1").click(function(){
		        	$("#sp1_hide").show();
		        	$("#sp2_hide").show();
		        	$("#sp3_hide").show();
			});
			$("#sport0").click(function(){
		        	$("#sp1_hide").hide();
		        	$("#sp2_hide").hide();
		        	$("#sp3_hide").hide();
		        	
		        	$("#sportlight_lbl").prop("checked", false); 
					$("#sportlight_btn").prop("checked", false); // 清除checkbox值
		        	$('#sp1_hide').find('label').removeClass('active');
		        	$("#sportlighttime_sel").hide();
					
		        	$("#sportmoderate_lbl").prop("checked", false);
					$("#sportmoderate_btn").prop("checked", false);
		        	$('#sp2_hide').find('label').removeClass('active');
		        	$("#sportmoderatetime_sel").hide();
					
					$("#sportvigorous_lbl").prop("checked", false);
					$("#sportvigorous_btn").prop("checked", false);
		        	$('#sp3_hide').find('label').removeClass('active');
		        	$("#sportvigoroustime_sel").hide();
					
					
					
					$("#sportlighttime_opt0").prop("selected",true);
					$("#sportmoderatetime_opt0").prop("selected",true);
					$("#sportvigoroustime_opt0").prop("selected",true);
			});

			$("#sportlight_btn").click(function(){
	        	$("#sportlighttime_sel").toggle();
	        	if(!$(this).is(':checked'))
	        	$("#sportlighttime_opt0").prop("selected",true);
			});
			$("#sportmoderate_btn").click(function(){  
	        	$("#sportmoderatetime_sel").toggle();
	        	if(!$(this).is(':checked'))			
	        	$("#sportmoderatetime_opt0").prop("selected",true);
			});
			$("#sportvigorous_btn").click(function(){  
	        	$("#sportvigoroustime_sel").toggle();
	        	if(!$(this).is(':checked'))			
	        	$("#sportvigoroustime_opt0").prop("selected",true);
			});

			$("#symptom1").click(function(){
		    	$("#symptom_hide").show();
			});
			$("#symptom0").click(function(){
	        	$("#symptom_hide").hide();
	        	$(".lbl-symptom").prop("checked", false);
				$(".btn-symptom").prop("checked", false);
	        	$('#symptom_hide').find('label').removeClass('active');
			});


			$(".stressT").click(function(){
		        $("#stress_hide").show();
			});
			$(".stressF").click(function(){
	        	$("#stress_hide").hide();
	        	$(".lbl-stress").prop("checked", false);
				$(".btn-stress").prop("checked", false);
				$('#stress_hide').find('label').removeClass('active');
			});

			$("select[name='att_reason']").on('change', function(evt){
				var tmp = $(this).val()
				if (tmp != 0) {
					$(".post_writer").show()
				} else {
					$(".post_writer").hide()
				}
			})

			$("#group-add").on("click", function (event) {
				event.preventDefault();
				var tmp   = $(".post_temp").clone().last();
				// var index = _.toNumber(tmp.find("input[class='group_check_freq']").attr('name').split('_').slice(-1)[0])
				// console.log(index)
				// tmp.find("input[class='group_check_freq']").attr({'name': 'group_check_freq_' + (index + 1)})
				// tmp.find("input[class='group_is_religious']").attr({'name': 'group_is_religious_' + (index + 1)})
				// tmp.find("input[class='group_n_invitees']").attr({'name': 'group_n_invitees_' + (index + 1)})
				tmp.find("label").removeClass('active');
				// console.log(tmp)
				$(".post_wrapper").append(tmp)
			})

			$("#group-minus").on("click", function (event) {
				event.preventDefault();
				var tmp = $(".post_temp").clone()
				// console.log(tmp)
				
				if (tmp.length > 1) {
					$(".post_wrapper").children().last().remove()
				} else {
					$.confirm({
						title: '',
					    content: '至少保留一則回應',
					    buttons: {
					        OK: function () {}
					    }
					});
				}
			})

			$("input[name='rel_activity']").on('change', function(evt){
				evt.preventDefault();
				var tmp = $("input[name='rel_activity']:checked").val()

				if (tmp == 0) {
					$("#rel_answers").hide()
				} else {
					$("#rel_answers").show()
				}
			})
		});		
	</script>

	<script type="text/javascript"> 
		// log date
		$(document).ready(function(){	
			var datetemp = $("select[id='date']").val(); 
			// 當天
			var date_selected = new Date(datetemp).toISOString();
			console.log(date_selected);
			var date_selected_reformat = date_selected.substring(5, 7)+'/'+datetemp.substring(8,10);
			// 前一晚
			var d_temp = new Date(datetemp);
			d_temp.setDate(d_temp.getDate() - 1);
			var date_selected_minus = ( d_temp.getMonth()+1 )+'/'+d_temp.getDate();
			
			$('.changebydate').html(date_selected_reformat);
			$('.changebydate2').html(date_selected_minus);

			$("#date").on('change',function(){
				var datetemp = $("select[id='date']").val(); 
				var date_selected = new Date(datetemp).toISOString();
				var date_selected_reformat = date_selected.substring(6, 7)+'/'+datetemp.substring(8,10);
				var d_temp = new Date(datetemp);
				d_temp.setDate(d_temp.getDate() - 1);
				var date_selected_minus = ( d_temp.getMonth()+1 )+'/'+d_temp.getDate();
				
				$('.changebydate').html(date_selected_reformat);
				$('.changebydate2').html(date_selected_minus);
			});
			
			
			$("input[id='symptom_other']").on("click", function (event) {
			var symptom_other	=$("input[id='symptom_other']").is(':checked')? 1: 0;
			if (symptom_other==1){
				//$("#relationship").attr({'style':'width:30%'});
				//$("#relationship_other").attr({'style':'width:60%'});
				$("input[id='symptom_other_text']").show();
				//$("input[id='symptom_other_text']").attr({required:'true'});
				
			}else{
				//$("#relationship").attr({'style':'width:60%'});
				$("input[id='symptom_other_text']").hide();
				//$("input[id='symptom_other_text']").removeAttr('required');
				$("input[id='symptom_other_text']").val('');    

			}
		});
			
		});
	</script>
	<style type="text/css">
			html {
			  position: relative;
			  min-height: 100%;
			}
			body {
			  /*Avoid nav bar overlap web content*/
			  padding-top: 70px; 
			  /* Margin bottom by footer height ，avoid footer overlap web content*/
			  margin-bottom: 60px;
			}
			.footer {
			  position: absolute;
			  bottom: 0;
			  width: 100%;
			  /* Set the fixed height of the footer here */
			  /*height: 60px;*/
			  /*line-height: 60px; */
			  /* Vertically center the text there */
			  background-color: #f5f5f5;
			  
			}
			.text{
				display: table-cell;
			    vertical-align: middle;
			    /*height: 100%;*/
			    font-size: 0.8em;
			    padding-top: 0.5em
			}
			#footerimg{
				float: left;
				height: 3em;
				padding-top: 0.5em;
			}
			#getup-h,#getup-m,#gobed-h,#gobed-m{
				width: 40%;
			}
			.form-control{
				display: inline;
				width: 80%;
			}
			/*控制button顏色 */
			.btn-primary { 
			    color: #3084cc;
			    background-color: white; 
			    border-color: #2e6da4;

			}
			.btn-success { 
			    color: #3c763d;
			    background-color: white; 
			    border-color: #4cae4c;

			}
			
			
			/* hover doesn't perform well on mobile*/
			.btn-success:hover{
				
			}
			
			
			
			
			
			/* 按鈕被點選時的顏色變化*/
			.btn-primary:hover, .btn-primary:focus, .btn-primary.focus, .btn-primary:active, .btn-primary.active, .open>.dropdown-toggle.btn-primary { 
			    color: #fff;
			    background-color: /*#286090;*/ #3084cc;
			    border-color: #204d74;

			}
			.btn-default:hover, .btn-default:focus, .btn-default.focus, .btn-default:active, .btn-default.active{
				color: #fff;
				background-color: #888888;
			}
		
			label{font-weight: 400}     /* 字體不加粗 */
			.btn {        
		    padding: 0.5em 0;
		    margin-bottom: 0;
		    font-size: 0.9em;
		    font-weight: 400;
		    line-height: 1.42857143;
		    width: 20%;   /* Radio button的寬度 */
		    
			}
			
			.btn-group-vertical{

			}
			/*先設btn-group為100%，再用.btn控制width*/
			.btn-group{
				width: 100%
			}

			.panel-success {
			    border-color: #4cae4c;
			}
			.panel-success>.panel-heading {
			    color: white;/*#3c763d;*/
			    background-color: /*#dff0d8;*/ #4cae4c;
			    border-color: #d6e9c6;
			}
			
			/*壓力*/
			#stress_hide{
				display:none;
			}
			.lbl-stress{
				width:45%;
			}
			/*運動相關文提、選項*/
			#sp1_hide,#sp2_hide,#sp3_hide{
				display: none
			}
			#sportlight_lbl,#sportlighttime_sel,#sportmoderate_lbl,#sportmoderatetime_sel,#sportvigorous_lbl,#sportvigoroustime_sel{
				width: 100%;
			}
			#sportlighttime_sel,#sportmoderatetime_sel,#sportvigoroustime_sel{/*先將選單隱藏，點checkbox label才顯示 */
				display: none;
			}
			
			/*症狀按鈕的外觀控制*/
			.lbl-symptom{
				width: 49%;
				font-size:0.95em;
			}
			.lbl-symptom-left{
				width: 37%;
			}
			.lbl-symptom-right{
				width: 61%;
			}
			.div-symptom-opt{
				padding-right: 0;
			}
			#symptom_hide{
				display: none;
			}
			.symptom-hide-lbl{
				display:none
			}
			
			/*submit button */
			#submit{
				color: white;
			    background-color: #2e6da4;
			    border-color: #2e6da4;
			    height: 3em;
			}
			
			/* Dynamic Div*/
			.dynamic_title{
				font-size:1.3em;
				/*padding-bottom:1em;*/
				// background-color:lightblue;
			}
			.dynamic_content{
				font-size:1.2em;
				letter-spacing:0.25em;
			}
			.q_checkbox_lbl{
				font-size:1em;
				padding-right:1em
			}
			.q_textarea{
				width:60vw;

			}
			.dynamic_qtext{
				padding-top: 1em;
			}
			.dynamic_radio_opt{
				/*width: 12%;*/  /* Adjust width For 7 opts*/
			}
			
			#dynamic_content{
				padding: 1em 0.25em;
			}
			.dynamic_radio_opt {
				font-size: 0.7em;
			}
			
			
			/*針對大螢幕進行調整*/
			@media screen and (min-width: 550px) { 
				.btn { 
					font-size:1.1em
				}
				#sportlight_lbl,#sportmoderate_lbl,#sportvigorous_lbl{
					width: 50%;
				}
				#sportlighttime_sel,#sportmoderatetime_sel,#sportvigoroustime_sel{
					width: 30%;
				}
				.lbl-symptom{
					width: 40%;
					font-size:1em;
				}
				.symptom-hide-lbl{
					display:block
				}
				.div-symptom-opt{
					padding-left: 15px;padding-right: 15px;
				}
				#submit{
					width: 40vw
				}
				.q_checkbox_lbl{
					font-size:1.8em;
				}
				.q_textarea{
					width:35vw;
				}
				#dynamic_content{
					padding: 1em ;
				}
			}
			
	</style>
</head>
<body>
	<?php include("header_b3.php");?>
	<div class="container">
		<form id="form" class="form-horizontal">
		<div class="panel panel-primary">
		  <div class="panel-heading">生活紀錄</div>
		  <div class="panel-body">	
		  	<div class="form-group">
				<label class="col-sm-3 control-label" >填寫哪一天的生活紀錄</label>
				<div class="col-sm-6">
					<select id="date" name="date" class="form-control" required>
						<?php 
							if( date('H')<18){
								echo "<option value={$yesterday}> {$yesterday}&nbsp(昨日) </option>";
								
								
							}else if(date('H')>=18){
								echo "<option value={$today}> 	  {$today}&nbsp(今日)    </option>";
								echo "<option value={$yesterday}> {$yesterday}&nbsp(昨日)</option>";
							}
						
						?>
						<!--
						<option value="<?php echo $today; ?>" />	<?php echo $today; ?>	 </option>
						<option value="<?php echo $yesterday; ?>" /><?php echo $yesterday; ?></option>
						-->
					</select>
				</div> 
			</div>
			<div class="form-group" data-toggle="buttons">
				<label class="col-sm-3 control-label" ><span class="changebydate"></span>當天心情如何</label>
				<div class="col-sm-6" >
					<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-success"><input name="mood" type="radio" value="0" required>非常好</label>
					<label class="btn btn-success"><input name="mood" type="radio" value="1" >很好</label>
					<label class="btn btn-success"><input name="mood" type="radio" value="2" >還好</label>
					<label class="btn btn-success"><input name="mood" type="radio" value="3" >不好</label>
					<label class="btn btn-success"><input name="mood" type="radio" value="4" >非常不好</label>
					</div>
				</div>
			</div>
			<div class="form-group" data-toggle="buttons">
					<label class="col-sm-3 control-label" ><span class="changebydate"></span>當天是否有身體不適</label>
					<div class="col-sm-6" >
						<div class="btn-group" data-toggle="buttons">
						<label id="symptom1" class="btn btn-success"><input name="symptom" type="radio" value="1" required>有</label>
						<label id="symptom0" class="btn btn-success"><input name="symptom" type="radio" value="0" >無</label>
						</div>
					</div>
			</div>
			<div id="symptom_hide" class="form-group" > <!-- 若有data-toggle="buttons"會導致checkbox無法被勾選 -->
					<label class="col-sm-3 control-label" >請選擇症狀(可複選)</label>
					<div  class="col-sm-8 div-symptom-opt" >
						<div  class="checkbox">
							<label  for="sick" class="lbl-symptom-left" > <input id="sick"	class="btn-symptom" type="checkbox" name="sick" value="1">確定有感冒</label>
						  	<label  for="fever" class="lbl-symptom-right" ><input id="fever" 	class="btn-symptom" type="checkbox" name="fever" value="1">發燒(高於38度)</label>
						</div>
					</div>
					<label class="col-sm-3 control-label symptom-hide-lbl" ></label>
					<div  class="col-sm-8 div-symptom-opt" >
						<div  class="checkbox">
							<label  for="cough" class="lbl-symptom-left" >		<input id="cough" 		class="btn-symptom" type="checkbox" name="cough" value="1">咳嗽</label>
							<label  for="sorethroat" class="lbl-symptom-right" >	<input id="sorethroat"  class="btn-symptom" type="checkbox" name="sorethroat" value="1">喉嚨痛</label>
						</div>
					</div>
					<label class="col-sm-3 control-label symptom-hide-lbl" ></label>
					<div  class="col-sm-8 div-symptom-opt" >
						<div  class="checkbox">
							<label  for="hospital"  ><input id="hospital"  class="btn-symptom" type="checkbox" name="hospital" value="1">前往就醫(含診所)</label>
							
						</div>
					</div>
					<label class="col-sm-3 control-label symptom-hide-lbl" ></label>
					<div  class="col-sm-8 div-symptom-opt" >
						<div  class="checkbox">
							<label for="symptom_other"  ><input id="symptom_other" name="symptom_other"  class="btn-symptom" type="checkbox"  value="1">其他</label>
							<input id="symptom_other_text" name="symptom_other_text" type="text" placeholder="請描述身體不適的症狀" style="display:none">
						</div>
						
					</div>
			</div>
			<div class="form-group" data-toggle="buttons">
				<label class="col-sm-3 control-label" ><span class="changebydate"></span>當天總共跟多少人接觸</label>
				<div class="col-sm-6" >
					<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-success"><input name="touchpeople" type="radio" value="0" required>0-4人</label>
					<label class="btn btn-success"><input name="touchpeople" type="radio" value="1" >5-9人</label>
					<label class="btn btn-success"><input name="touchpeople" type="radio" value="2" >10-19人</label>
					<label class="btn btn-success"><input name="touchpeople" type="radio" value="3" >20人以上</label>
					</div>
				</div>
			</div>
		  </div>
		</div>
		<div class="panel panel-success">
		  	<div class="panel-heading">網路世界中一對多的群組互動</div>
		  	<div class="panel-body">	
				<div class="form-group" data-toggle="buttons">
					<label class="col-sm-4 control-label" ><span class="changebydate"></span>當天曾瀏覽或查閱以下哪些群組</label>
					<div class="col-sm-8" >
						<!-- <div class="btn-group" data-toggle="buttons"> -->
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupA</label>
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupB</label>
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupC</label>
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupD</label>
						<!-- </div> -->
					</div>
				</div>
				<div class="form-group" data-toggle="buttons">
					<label class="col-sm-4 control-label" ><span class="changebydate"></span>當天曾在哪些群組回應或發文</label>
					<div class="col-sm-8" >
						<!-- <div class="btn-group" data-toggle="buttons"> -->
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupA</label>
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupB</label>
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupC</label>
						<label class="btn btn-success"><input name="touchpeople" type="checkbox" >GroupD</label>
						<!-- </div> -->
					</div>
				</div>
				<div class="post_wrapper">
					<div class="post_temp">
						<div class="form-group">
							<label class="col-sm-4 control-label" >在網站群組中有閱讀到令您特別關注的<br>他人發文，特別關注的原因是</label>
							<div class="col-sm-8">
								<select id="att_reason" name="att_reason" class="form-control" required>
									<option value="">請選擇</option>
									<option value="1">知識性(文化知識、歷史知識)　</option>
									<option value="2">訊息公告</option>
									<option value="3">靈性的收穫與感動</option>
									<option value="4">溫馨的感受</option>
									<option value="5">其他</option>
									<option value="0">沒有任何令我特別關注的訊息</option>
								</select>
							</div> 
						</div>
						<div class="form-group post_writer">
							<label class="col-sm-4 control-label" >您是否留意這篇令您關注的文是誰發的</label>
							<div class="col-sm-8">
								<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-success"><input name="touchpeople" type="radio" value="1" required>是</label>
								<label class="btn btn-success"><input name="touchpeople" type="radio" value="0" >否</label>
								</div>
							</div> 
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="col-sm-4 control-label" style="color: blue;">若令您特別關注的發文大於一篇以上<br>請透過右方按鈕進行增減</label>
					<div class="col-sm-8">
						<button id="group-add" class="btn" style="font-size: 2em; padding: 0; background-color: white; ">
							<i class="fas fa-plus-circle"></i>	
						</button>
						<button id="group-minus" class="btn" style="font-size: 2em; padding: 0; background-color: white;">
							<i class="fas fa-minus-circle"></i>	
						</button>
					</div> 
				</div>

		  </div>
		</div>
		<div class="panel panel-warning">
		  	<div class="panel-heading">宗教集體性活動的參與經驗 (實際互動中的多對一)</div>
		  	<div class="panel-body">
		  		<div class="form-group" data-toggle="buttons" style="padding-bottom: 1.5em;">
					<label class="col-sm-4 control-label" ><span class="changebydate"></span>當天是否參與任何團體性的宗教活動</label>
					<div class="col-sm-8" >
						<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-success"><input name="rel_activity" type="radio" value="1" required>有</label>
						<label class="btn btn-success"><input name="rel_activity" type="radio" value="0" >無</label>
						</div>
					</div>
				</div>
				<div id="rel_answers" style="display: none;">
					<div class="form-group">
						<label class="col-sm-4 control-label" >活動中是否經歷(看到或聽到)令您特別印象深刻<br>(如啟發、感動、神秘體驗等)的事情或物件？</label>
						<div class="col-sm-8">
							<select id="att_reason" name="att_reason" class="form-control" >
								<option value="">請選擇</option>
								<option value="1">義工間的互動　</option>
								<option value="2">信徒的行為</option>
								<option value="3">儀式物件</option>
								<option value="4">活動氛圍</option>
								<option value="5">個人的神祕體驗</option>
								<option value="6">其他</option>
								<option value="0">無</option>
							</select>
						</div> 
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" >活動中是否經歷(看到或聽到)令您有特別負面感受的事件</label>
						<div class="col-sm-8">
							<select id="att_reason" name="att_reason" class="form-control" >
								<option value="">請選擇</option>
								<option value="1">義工間的互動　</option>
								<option value="2">信徒的行為</option>
								<option value="3">儀式物件</option>
								<option value="4">活動氛圍</option>
								<option value="5">個人的神祕體驗</option>
								<option value="6">其他</option>
								<option value="0">無</option>
							</select>
						</div> 
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" >活動中您對團體的整體氣氛印象</label>
						<div class="col-sm-8">
							<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success"><input name="atmos" type="radio" value="0" >非常好</label>
							<label class="btn btn-success"><input name="atmos" type="radio" value="1" >很好</label>
							<label class="btn btn-success"><input name="atmos" type="radio" value="2" >還好</label>
							<label class="btn btn-success"><input name="atmos" type="radio" value="3" >不好</label>
							</div>
						</div> 
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" >參加後，我是否有任何靈性方面的啟發或感受</label>
						<div class="col-sm-8">
							<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success"><input name="gain_spirit" type="radio" value="0" >很大</label>
							<label class="btn btn-success"><input name="gain_spirit" type="radio" value="1" >有一點</label>
							<label class="btn btn-success"><input name="gain_spirit" type="radio" value="2" >幾乎沒有</label>
							<label class="btn btn-success"><input name="gain_spirit" type="radio" value="3" >有額外損失 / 付出</label>
							</div>
						</div> 
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" >參加前，我的心情如何</label>
						<div class="col-sm-8">
							<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success"><input name="gain_mood_0" type="radio" value="0" >非常好</label>
							<label class="btn btn-success"><input name="gain_mood_0" type="radio" value="1" >很好</label>
							<label class="btn btn-success"><input name="gain_mood_0" type="radio" value="2" >還好</label>
							<label class="btn btn-success"><input name="gain_mood_0" type="radio" value="3" >不好</label>
							<label class="btn btn-success"><input name="gain_mood_0" type="radio" value="4" >非常不好</label>
							</div>
						</div> 
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" >參加後，我的心情如何</label>
						<div class="col-sm-8">
							<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success"><input name="gain_mood_1" type="radio" value="0" >非常好</label>
							<label class="btn btn-success"><input name="gain_mood_1" type="radio" value="1" >很好</label>
							<label class="btn btn-success"><input name="gain_mood_1" type="radio" value="2" >還好</label>
							<label class="btn btn-success"><input name="gain_mood_1" type="radio" value="3" >不好</label>
							<label class="btn btn-success"><input name="gain_mood_1" type="radio" value="4" >非常不好</label>
							</div>
						</div> 
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" >參加後，是否有與靈性、心情情緒無關的具體收穫?(例如: 健康、資訊...等)</label>
						<div class="col-sm-8">
							<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-success"><input name="gain_ins" type="radio" value="0" >很大</label>
							<label class="btn btn-success"><input name="gain_ins" type="radio" value="1" >有一點</label>
							<label class="btn btn-success"><input name="gain_ins" type="radio" value="2" >幾乎沒有</label>
							<label class="btn btn-success"><input name="gain_ins" type="radio" value="3" >有額外損失 / 付出</label>
							</div>
						</div> 
					</div>
					
				</div>
			</div>
		  	</div>
		</div>


		<div class="submit_button" align="center">
			<div id='loadingtext' style='font-size:1.5em;color:red;display:none'>傳送中˙˙˙請稍候</div>
			<input class="btn btn-lg btn-block " type="submit" id="submit" value="送出!" rows=5 >
		</div>
		</form>
	</div>
	<footer class="footer">
      		<div class="container">
      			<img id="footerimg"src="./pic/Academia_Sinica_Emblem.png" >
			    <div class="text">
				著作權©中研院統計科學研究所. 版權所有.<br>
			    Copyright© Institute of Statistical Science, Academia Sinica.
			    All rights reserved.
			    </div>
			</div>
   	</footer>
		 
	

	
	
</body>
</html>
<?php
	session_start();
	include("db.php"); 
	CheckAccInfo();
	
	if (isset($_POST['FetchCity'])) {
		$sql  = "SELECT DISTINCT City, COUN_ID FROM county ORDER BY CityID";
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$json = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

	if (isset($_POST['FetchTown'])) {
		$city = $_POST["city"];

		$sql  = "SELECT DISTINCT District,TOWN_ID FROM county WHERE City = :city ORDER BY TOWN_ID";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':city', $city);
		$stmt->execute();

		$json = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

	if (isset($_POST['FetchProfile'])) {
		$id = $_SESSION['acc_info']['id'];
		$sql = "SELECT * FROM `profile` WHERE id = :v1 ORDER BY datakey DESC LIMIT 1";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $id);
		$stmt->execute();
		$json = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

	if (isset($_POST['FormSubmit'])) {
		$name 						= $_POST['name'];
		$name_line 					= $_POST['name_line'];
		$height 					= $_POST['height'];
		$weight 					= $_POST['weight'];
		$gender 					= $_POST['gender'];
		$age 						= $_POST['age'];
		$city 						= $_POST['city'];
		$town 						= $_POST['town'];
		$res_other 					= $_POST['res_other'];
		$livewithfamily 			= $_POST['livewithfamily'];
		$marriage 					= $_POST['marriage'];
		$marriage_other 			= $_POST['marriage_other'];
		$livewithcouple 			= $_POST['livewithcouple'];
		$livewithcouple_other 		= $_POST['livewithcouple_other'];
		$job 						= $_POST['job'];
		$job_other 					= $_POST['job_other'];
		$edu 						= $_POST['edu'];
		$income 					= $_POST['income'];
		$income_other 				= $_POST['income_other'];
		$surveymail 				= $_POST['surveymail'];
		$internal_member 			= $_POST['internal_member'];
		$god 						= $_POST['god'];
		$god_other 					= $_POST['god_other'];
		$rel_activity 				= $_POST['rel_activity'];
		$rel_activity_other 		= $_POST['rel_activity_other'];
		$rel_donate_buddhism 		= $_POST['rel_donate_buddhism'];
		$rel_donate_christianity 	= $_POST['rel_donate_christianity'];
		$rel_donate_folkbelief 		= $_POST['rel_donate_folkbelief'];
		$rel_donate_taoism 			= $_POST['rel_donate_taoism'];
		$rel_donate_other 			= $_POST['rel_donate_other'];
		$rel_vol_buddhism 			= $_POST['rel_vol_buddhism'];
		$rel_vol_christianity 		= $_POST['rel_vol_christianity'];
		$rel_vol_folkbelief 		= $_POST['rel_vol_folkbelief'];
		$rel_vol_taoism 			= $_POST['rel_vol_taoism'];
		$rel_vol_other 				= $_POST['rel_vol_other'];
		$rel_pb_biblestudy 			= $_POST['rel_pb_biblestudy'];
		$rel_pb_meditate 			= $_POST['rel_pb_meditate'];
		$rel_pb_worship 			= $_POST['rel_pb_worship'];
		$rel_pb_pray 				= $_POST['rel_pb_pray'];
		$rel_pb_other 				= $_POST['rel_pb_other'];
		$rel_temple 				= $_POST['rel_temple'];
		
		$now = date("Y-m-d H:i:s");

		$sql = "
				INSERT INTO
				  `profile`(
				    `datakey`,
				    `id`,
				    `name`,
				    `name_line`,
				    `height`,
				    `weight`,
				    `gender`,
				    `age`,
				    `city`,
				    `town`,
				    `res_other`,
				    `livewithfamily`,
				    `marriage`,
				    `marriage_other`,
				    `livewithcouple`,
				    `livewithcouple_other`,
				    `job`,
				    `job_other`,
				    `edu`,
				    `income`,
				    `income_other`,
				    `surveymail`,
				    `internal_member`,
				    `god`,
				    `god_other`,
				    `rel_activity`,
				    `rel_activity_other`,
				    `rel_donate_buddhism`,
				    `rel_donate_christianity`,
				    `rel_donate_folkbelief`,
				    `rel_donate_taoism`,
				    `rel_donate_other`,
				    `rel_vol_buddhism`,
				    `rel_vol_christianity`,
				    `rel_vol_folkbelief`,
				    `rel_vol_taoism`,
				    `rel_vol_other`,
				    `rel_pb_biblestudy`,
				    `rel_pb_meditate`,
				    `rel_pb_worship`,
				    `rel_pb_pray`,
				    `rel_pb_other`,
				    `rel_temple`,
				    `create_time`
				  )
				VALUES(
				  NULL,
				  :v2,
				  :v3,
				  :v4,
				  :v5,
				  :v6,
				  :v7,
				  :v8,
				  :v9,
				  :v10,
				  :v11,
				  :v12,
				  :v13,
				  :v14,
				  :v15,
				  :v16,
				  :v17,
				  :v18,
				  :v19,
				  :v20,
				  :v21,
				  :v22,
				  :v23,
				  :v24,
				  :v25,
				  :v26,
				  :v27,
				  :v28,
				  :v29,
				  :v30,
				  :v31,
				  :v32,
				  :v33,
				  :v34,
				  :v35,
				  :v36,
				  :v37,
				  :v38,
				  :v39,
				  :v40,
				  :v41,
				  :v42,
				  :v43,
				  :v44
				)
		";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v2', $_SESSION['acc_info']['id']);
		$stmt->bindParam(':v3', $name);
		$stmt->bindParam(':v4', $name_line);
		$stmt->bindParam(':v5', $height);
		$stmt->bindParam(':v6', $weight);
		$stmt->bindParam(':v7', $gender);
		$stmt->bindParam(':v8', $age);
		$stmt->bindParam(':v9', $city);
		$stmt->bindParam(':v10', $town);
		$stmt->bindParam(':v11', $res_other);
		$stmt->bindParam(':v12', $livewithfamily);
		$stmt->bindParam(':v13', $marriage);
		$stmt->bindParam(':v14', $marriage_other);
		$stmt->bindParam(':v15', $livewithcouple);
		$stmt->bindParam(':v16', $livewithcouple_other);
		$stmt->bindParam(':v17', $job);
		$stmt->bindParam(':v18', $job_other);
		$stmt->bindParam(':v19', $edu);
		$stmt->bindParam(':v20', $income);
		$stmt->bindParam(':v21', $income_other);
		$stmt->bindParam(':v22', $surveymail);
		$stmt->bindParam(':v23', $internal_member);
		$stmt->bindParam(':v24', $god);
		$stmt->bindParam(':v25', $god_other);
		$stmt->bindParam(':v26', $rel_activity);
		$stmt->bindParam(':v27', $rel_activity_other);
		$stmt->bindParam(':v28', $rel_donate_buddhism);
		$stmt->bindParam(':v29', $rel_donate_christianity);
		$stmt->bindParam(':v30', $rel_donate_folkbelief);
		$stmt->bindParam(':v31', $rel_donate_taoism);
		$stmt->bindParam(':v32', $rel_donate_other);
		$stmt->bindParam(':v33', $rel_vol_buddhism);
		$stmt->bindParam(':v34', $rel_vol_christianity);
		$stmt->bindParam(':v35', $rel_vol_folkbelief);
		$stmt->bindParam(':v36', $rel_vol_taoism);
		$stmt->bindParam(':v37', $rel_vol_other);
		$stmt->bindParam(':v38', $rel_pb_biblestudy);
		$stmt->bindParam(':v39', $rel_pb_meditate);
		$stmt->bindParam(':v40', $rel_pb_worship);
		$stmt->bindParam(':v41', $rel_pb_pray);
		$stmt->bindParam(':v42', $rel_pb_other);
		$stmt->bindParam(':v43', $rel_temple);
		$stmt->bindParam(':v44', $now);

		try {
			$stmt->execute();
			echo "success";
		} catch (Exception $e) {
		    echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
		exit();
	}
?>
<!doctype html>
<html lang="zh-tw">
<head>
	<meta charset="utf-8" http-equiv="content-type" >
	<title>??????????????????</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootsrap 4 CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
	<style type="text/css">
		body, html{
		     /*height: 100%;*/
		 	background-repeat: no-repeat;
		 	background-color: #d3d3d3;
		 	overscroll-behavior: contain;  /* ?????????????????? */
		}
		.main-login{
		 	background-color: #fff;
		    /* shadows and rounded borders */
		    -moz-border-radius: 2px;
		    -webkit-border-radius: 2px;
		    border-radius: 2px;
		    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

		}

		.main-center{
		 	margin-top: 2em;
		 	margin-bottom: 2em;
		 	margin: auto;
		 	/*max-width: 85vw;*/
		    padding: 0.5em 1.5em;
		    width: 70%;

		}

		.btn {        
		    padding: 0.5em 0;
		    margin-bottom: 0;
		    font-size: 1em;
		    font-weight: 400;
		}
		
		.btn-group{
			/*width: 65%*/
			width: 100%
		}
		
		.form-control{
			width: 100%;
		}
		
		.card-header{
			background-color: 	#FFE299;
		}

		h4 {
			/*font-size: 1.5em;*/
			margin-top: 0;
			margin-bottom: 0;
		}
		
		label {
			font-weight: 400
		}

		.btn-last-page,.btn-next-page,#submit{
			width: 15rem;
			height: 3rem;
		}

		.input-group{
			margin: 2rem auto;
		}

		.input-group-text{
			font-size: 0.9rem;
			width: 100%;
		}
		.group-info-wrapper>.input-group-prepend>.input-group-text{
			width: 17rem;
		}

		.pt-onls{
			padding-top: 1rem;
		}

		.btn-group-toggle.col-sm-12,.input-group-prepend.col-sm-12,.col-sm-8{
			padding-left: 0;
			padding-right: 0;
		}

		.hide_atfirst{
			display: none;
		}

		/* ------------------------------ Navbar & Footer  ----------------------------------- */
		html {
			  position: relative;
			  min-height: 100%;
		}

		body {
		  padding-top: 90px;  /* Avoid nav bar overlap web content */
		  margin-bottom: 60px; /* Margin bottom by footer height ???avoid footer overlap web content */
		}

		.footer {
		  position: absolute;
		  bottom: 0;
		  width: 100%;
		  background-color: #f5f5f5;
		}

		.text{
			display: table-cell;
		    vertical-align: middle;
		    font-size: 0.8em;
		    padding-top: 0.5em
		}

		#footerimg{
			float: left;
			height: 3em;
			padding-top: 0.5em;
		}
		/* ---------------------------------------------------------------------------------- */

		@media screen and (max-width: 550px) {
			.main-center{
				width: 98%;
				padding: 1em;
			}
			.btn-last-page,.btn-next-page,#submit{
				width: 6rem;
				height: 3rem;
			}

			#citySelect, #townSelect {
				width: 10em;	
			}

			#age{
				width: 100%;
			}

			.input-group-prepend{
				width: 100%;
			}

			.input-group-text{
				width: 100%;
				border: 1px solid #ced4da !important;
    			border-radius: .25rem !important;
			}

			.btn-group{
				width: 100%
			}

			.pt-onls{
				padding-top: 0.5em;
			}
			.pt-onss{
				padding-top: 1rem;
			}

			.btn.focus {
				color: inherit;
				background-color: transparent;
			}
		}
	</style>
	<script type="text/javascript">

		$(document).ready(function(){

			new Promise((resolve, reject) => {
			    LoadCityTownSelect()
 	        	setTimeout(function(){
			    	resolve();
			    }, 1000);
			}).then(() => {
			    FillAnswerCache()
			})

			AnswerCache()
			ToggleSupplement()
			FetchProfile()

			$(".btn-last-page").on("click", function (event) {
			    event.preventDefault();
			    var tmp = $(this).attr('id')
			    // console.log(tmp)
			    
			    if (tmp == "btn_page_2") {
			    	window.scrollTo(0,0)
			    	$("#page_2").hide();
			    	$("#page_1").show();
			    }
			})

			$(".btn-next-page").on("click", function (event) {
			    event.preventDefault();
			    var tmp = $(this).attr('id')
			    // console.log(tmp)
			    
			    if (tmp == "btn_page_1") {
			    	if (ValidateForm_1()) {
			    		window.scrollTo(0,0)
				    	$("#page_1").hide();
				    	$("#page_2").show();
			    	}
			    }
			})

			

			$("#form").on("submit", function (event) {
			    event.preventDefault();

				var name 		= $("input[name='name']").val()
				var name_line 	= $("input[name='name_line']").val()
				var height 		= $("input[name='height']").val() || 999;
				var weight 		= $("input[name='weight']").val() || 999;
				var gender 		= $("input[name='gender']:checked").val()
				var age    		= $("select[id='age']").val()
				var city  		= $("select[id='citySelect']").val()
				var town   		= $("select[id='townSelect']").val()
				var res_other 	= $("input[name='res_other']").val()
				var livewithfamily 	= $("input[name='livewithfamily']:checked").val() || 999;
				var marriage 		= $("input[name='marriage']:checked").val() || 999;
				var marriage_other 	= $("input[name='marriage_other']").val() || "";
				var livewithcouple  = $("select[id='livewithcouple']").val() || 999;
				var livewithcouple_other = $("input[name='livewithcouple_other']").val() || "";
				var job 			= $("select[id='job']").val()
				var job_other 		= $("input[name='job_other']").val()
				var edu 			= $("select[id='edu']").val()
				var income 			= $("select[id='income']").val()
				var income_other 	= $("input[name='income_other']").val()
				var surveymail 		= $("input[name='surveymail']:checked").val()
				var internal_member = $("input[name='internal_member']:checked").val()

				var god 					= $("select[id='god']").val()
				var god_other 				= $("input[name='god_other']").val()
				var rel_activity 			= $("input[name='rel_activity']:checked").val()
				var rel_activity_other 		= $("input[name='rel_activity_other']").val()
				var rel_donate_buddhism 	= $("input[name='rel_donate_buddhism']").prop('checked')?1 :0;
				var rel_donate_christianity = $("input[name='rel_donate_christianity']").prop('checked')?1 :0;
				var rel_donate_folkbelief 	= $("input[name='rel_donate_folkbelief']").prop('checked')?1 :0;
				var rel_donate_taoism 		= $("input[name='rel_donate_taoism']").prop('checked')?1 :0;
				var rel_donate_other_chk 	= $("input[name='rel_donate_other_chk']").prop('checked')?1 :0;
				var rel_donate_other 		= $("input[name='rel_donate_other']").val()
				var rel_vol_buddhism 		= $("input[name='rel_vol_buddhism']").prop('checked')?1 :0;
				var rel_vol_christianity 	= $("input[name='rel_vol_christianity']").prop('checked')?1 :0;
				var rel_vol_folkbelief 		= $("input[name='rel_vol_folkbelief']").prop('checked')?1 :0;
				var rel_vol_taoism 			= $("input[name='rel_vol_taoism']").prop('checked')?1 :0;
				var rel_vol_other_chk 		= $("input[name='rel_vol_other_chk']").prop('checked')?1 :0;
				var rel_vol_other 			= $("input[name='rel_vol_other']").val()
				var rel_pb_biblestudy 		= $("input[name='rel_pb_biblestudy']").prop('checked')?1 :0;
				var rel_pb_meditate 		= $("input[name='rel_pb_meditate']").prop('checked')?1 :0;
				var rel_pb_worship 			= $("input[name='rel_pb_worship']").prop('checked')?1 :0;
				var rel_pb_pray 			= $("input[name='rel_pb_pray']").prop('checked')?1 :0;
				var rel_pb_other_chk 		= $("input[name='rel_pb_other_chk']").prop('checked')?1 :0;
				var rel_pb_other 			= $("input[name='rel_pb_other']").val()
				var rel_temple 				= $("select[id='rel_temple']").val()
					
    			$.ajax({ 
					type: "POST",
					url: '',
					data: {
						FormSubmit: 1,
						name: name,
						name_line: name_line,
						height: height,
						weight:weight,
						gender:gender,
						age:age,
						city:city,
						town:town,
						res_other:res_other,
						livewithfamily:livewithfamily,
						marriage: marriage,
						marriage_other: marriage_other,
						livewithcouple: livewithcouple,
						livewithcouple_other: livewithcouple_other,
						job: job,
						job_other: job_other,
						edu: edu,
						income: income,
						income_other: income_other,
						surveymail: surveymail,
						internal_member: internal_member,
						god: god,
						god_other: god_other,
						rel_activity: rel_activity,
						rel_activity_other: rel_activity_other,
						rel_donate_buddhism: rel_donate_buddhism,
						rel_donate_christianity: rel_donate_christianity,
						rel_donate_folkbelief: rel_donate_folkbelief,
						rel_donate_taoism: rel_donate_taoism,
						rel_donate_other: rel_donate_other,
						rel_vol_buddhism: rel_vol_buddhism,
						rel_vol_christianity: rel_vol_christianity,
						rel_vol_folkbelief: rel_vol_folkbelief,
						rel_vol_taoism: rel_vol_taoism,
						rel_vol_other: rel_vol_other,
						rel_pb_biblestudy: rel_pb_biblestudy,
						rel_pb_meditate: rel_pb_meditate,
						rel_pb_worship: rel_pb_worship,
						rel_pb_pray: rel_pb_pray,
						rel_pb_other: rel_pb_other,
						rel_temple: rel_temple
					},beforeSend: function() { 
						//$("#loadingtext").show();
						$("#submit").prop('disabled', true);
					},complete : function (){
						//$("#loadingtext").hide();
						$("#submit").prop('disabled', false);
					},success: function(data){
						console.log(data);
						if(data == "success"){
							$.alert("????????????????????????")
							setTimeout(function() {
								window.location.href = 'http://cdiary3.tw/main.php';
							}, 1500);
							
						}else {

						}
					},error: function(e){
						$.alert("???????????????????????????????????????<br>????????????????????????????????????<br>***@stat.sinica.edu.tw")
					}
				});
					
			});
    	});
	
		function LoadCityTownSelect() {
			var CitySelect;
			var TownSelect;
			
			CitySelect 		= 	$("<select>").attr({ 'id': 'citySelect', 'class':'form-control'}).on('change', function(){ update3();	})
			TownSelect 		= 	$("<select>").attr({ 'id': 'townSelect', 'class':'form-control'})
			Res_other_Input = 	$("<input>").attr({
									'type': 'text',
									'name': 'res_other', 
									'class': 'form-control', 
									'placeholder': '?????????????????????'
								}).hide()

			$('#residence').empty().append(CitySelect).append(TownSelect).append(Res_other_Input);
			update2()

			function update2(){   
				$.ajax({ 
					type: "POST",
					dataType: "json", 
					url: '',
					data:{
						FetchCity: 1
					},
					success: function (data) {
						var json_profile = JSON.parse(localStorage.getItem('profile_cache'))
						localStorage.setItem('profile_cache', JSON.stringify(json_profile));
						
						$(CitySelect).empty();	
						$(CitySelect).append(
							$("<option>").html('?????????').attr('value','')
						);		
						for(var key in data){
							$(CitySelect).append(
								$("<option />").html(data[key].City).attr('value', data[key].City)
							)
						}
						$(CitySelect).append(
							$("<option />").html('??????').attr('value', '??????')
						)

						if(json_profile){
							if (json_profile.citySelect) {
								$(CitySelect).val(json_profile.citySelect)
							}	
						}
						
						update3()
					}
				});	
			}
	    
			function update3(){
				city = $("select[id='citySelect']").val()

				$(TownSelect).empty();

				if (city == "??????") {
					$(TownSelect).empty().hide();
					$(Res_other_Input).show()
				} else {
					$(Res_other_Input).val('').hide()
					$(TownSelect).show();

					$.ajax({ 
						type: "POST",
						dataType: "json", 
						url: '',
						data:{
							FetchTown: 1,
							city: city
						},
						success: function (data) {
							$(TownSelect).append(
								$("<option>").html('?????????').attr('value','')
							);
							
							for(var key in data){
								$(TownSelect).append(
									$("<option />").html(data[key].District).attr('value',data[key].District)
								);
							}
						}
					});	
				}
				
			}
		}

		function ToggleSupplement() {
			$("input[name='marriage']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $("input[name='marriage']:checked").val()
				// console.log(tmp)
				if (tmp == 2) {
					$("input[name='marriage_other']").show()
				} else {
					$("input[name='marriage_other']").val('')
					$("input[name='marriage_other']").hide()
					
					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.marriage_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("select[id='livewithcouple']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $("select[id='livewithcouple']").val()
				// console.log(tmp)
				if (tmp == 7) {
					$("input[name='livewithcouple_other']").show()
				} else {
					$("input[name='livewithcouple_other']").val('')
					$("input[name='livewithcouple_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.livewithcouple_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("select[id='job']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $("select[id='job']").val()
				// console.log(tmp)
				if (tmp == 11) {
					$("input[name='job_other']").show()
				} else {
					$("input[name='job_other']").val('')
					$("input[name='job_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.job_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("select[id='income']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $("select[id='income']").val()
				// console.log(tmp)
				if (tmp == 7) {
					$("input[name='income_other']").show()
				} else {
					$("input[name='income_other']").val('')
					$("input[name='income_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.income_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("select[id='god']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $("select[id='god']").val()
				// console.log(tmp)
				if (tmp == 10) {
					$("input[name='god_other']").show()
				} else {
					$("input[name='god_other']").val('')
					$("input[name='god_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.god_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("input[name='rel_activity']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $("input[name='rel_activity']:checked").val()
				// console.log(tmp)
				if (tmp == 4) {
					$("input[name='rel_activity_other']").show()
				} else {
					$("input[name='rel_activity_other']").val('')
					$("input[name='rel_activity_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.rel_activity_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("input[name='rel_donate_other_chk']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $(this).is(':checked')? 1: 0;
				// console.log(tmp)
				if (tmp == 1) {
					$("input[name='rel_donate_other']").show()
				} else {
					$("input[name='rel_donate_other']").val('')
					$("input[name='rel_donate_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.rel_donate_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("input[name='rel_vol_other_chk']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $(this).is(':checked')? 1: 0;
				// console.log(tmp)
				if (tmp == 1) {
					$("input[name='rel_vol_other']").show()
				} else {
					$("input[name='rel_vol_other']").val('')
					$("input[name='rel_vol_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.rel_vol_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$("input[name='rel_pb_other_chk']").on('change', function(evt){
				evt.preventDefault()
				var tmp = $(this).is(':checked')? 1: 0;
				// console.log(tmp)
				
				if (tmp == 1) {
					
					$("input[name='rel_pb_other']").show()
				} else {
					$("input[name='rel_pb_other']").val('')
					$("input[name='rel_pb_other']").hide()

					var js_tmp = JSON.parse(localStorage.getItem('profile_cache'))
					js_tmp.rel_pb_other = ""
 					localStorage.setItem('profile_cache', JSON.stringify(js_tmp));
 					// console.log(JSON.parse(localStorage.getItem('profile_cache')))
				}
			})

			$(jQuery).on('change', "input[type='checkbox']", function(e) {
				var tmp 	= $(this).is(':checked') ?1 :0 ;
				var target 	= $(this).parent()
				
				if (tmp == 0) {
					$(target).attr({'style': 'color: #007bff; background-color: transparent;'})
				} else {
					$(target).attr({'style': 'color: #fff; background-color: #007bff;'})
					    
				}
			});
		}

		function ValidateForm_1() {
			var name 		= $("input[name='name']").val()
			var name_line 	= $("input[name='name_line']").val()
			var height 		= $("input[name='height']").val() || 999;
			var weight 		= $("input[name='weight']").val() || 999;
			var gender 		= $("input[name='gender']:checked").val()
			var age    		= $("select[id='age']").val()
			var city  		= $("select[id='citySelect']").val()
			var town   		= $("select[id='townSelect']").val()
			var res_other 	= $("input[name='res_other']").val()
			var livewithfamily 	= $("input[name='livewithfamily']:checked").val() || 999;
			var marriage 		= $("input[name='marriage']:checked").val() || 999;
			var marriage_other 	= $("input[name='marriage_other']").val()
			var livewithcouple  = $("select[id='livewithcouple']").val() || 999;
			var livewithcouple_other = $("input[name='livewithcouple_other']").val()
			var job 			= $("select[id='job']").val()
			var job_other 		= $("input[name='job_other']").val()
			var edu 			= $("select[id='edu']").val()
			var income 			= $("select[id='income']").val()
			var income_other 	= $("input[name='income_other']").val()
			var surveymail 		= $("input[name='surveymail']:checked").val()
			var internal_member = $("input[name='internal_member']:checked").val()

			if (name == "" || !name) {
				$.alert('??????????????? / ??????')
				return false;
			} else if (height == "" || !height) {
				$.alert('???????????????')
				return false;
			} else if (weight == "" || !weight) {
				$.alert('???????????????')
				return false;
			} else if (gender == "" || !gender) {
				$.alert('???????????????')
				return false;
			} else if (age == "" || !age) {
				$.alert('???????????????')
				return false;
			} else if (city == "" || !city) {
				$.alert('?????????????????????')
				return false;
			} else if (city == "??????" && res_other == "") {
				$.alert('?????????????????????')
				return false;
			} else if (city != "??????" && (town == "" || !town)) {
				$.alert('???????????????????????????')
				return false;
			} else if (!livewithfamily) {
				$.alert('??????????????????????????????')
				return false;
			} else if (!marriage) {
				$.alert('?????????????????????')
				return false;
			} else if (!livewithcouple) {
				$.alert('????????????????????????????????????')
				return false;
			} else if (!job) {
				$.alert('???????????????')
				return false;
			} else if (!edu) {
				$.alert('?????????????????????')
				return false;
			} else if (!income) {
				$.alert('???????????????????????????')
				return false;
			} else if (!surveymail) {
				$.alert('???????????????????????????????????????????????????')
				return false;
			} else {
				return true;
			}

			// else if (marriage == 2 && marriage_other == "") {
			// 	$.alert('?????????????????????')
			// 	return false;
			// } else if (livewithcouple == 6 && livewithcouple_other == "") {
			// 	$.alert('??????????????????????????????')
			// 	return false;
			// } else if (job == 11 && job_other == "") {
			// 	$.alert('???????????????')
			// 	return false;
			// } else if (income == 7 && jobincome_other == "") {
			// 	$.alert('???????????????????????????')
			// 	return false;
			// } 
		}

		function ValidateForm_2() {
			var god 					= $("select[id='god']").val()
			var god_other 				= $("input[name='god_other']").val()
			var rel_activity 			= $("input[name='rel_activity']:checked").val()
			var rel_activity_other 		= $("input[name='rel_activity_other']").val()
			var rel_donate_buddhism 	= $("input[name='rel_donate_buddhism']").prop('checked')?1 :0;
			var rel_donate_christianity = $("input[name='rel_donate_christianity']").prop('checked')?1 :0;
			var rel_donate_folkbelief 	= $("input[name='rel_donate_folkbelief']").prop('checked')?1 :0;
			var rel_donate_taoism 		= $("input[name='rel_donate_taoism']").prop('checked')?1 :0;
			var rel_donate_other_chk 	= $("input[name='rel_donate_other_chk']").prop('checked')?1 :0;
			var rel_donate_other 		= $("input[name='rel_donate_other']").val()
			var rel_vol_buddhism 		= $("input[name='rel_vol_buddhism']").prop('checked')?1 :0;
			var rel_vol_christianity 	= $("input[name='rel_vol_christianity']").prop('checked')?1 :0;
			var rel_vol_folkbelief 		= $("input[name='rel_vol_folkbelief']").prop('checked')?1 :0;
			var rel_vol_taoism 			= $("input[name='rel_vol_taoism']").prop('checked')?1 :0;
			var rel_vol_other_chk 		= $("input[name='rel_vol_other_chk']").prop('checked')?1 :0;
			var rel_vol_other 			= $("input[name='rel_vol_other']").val()
			var rel_pb_biblestudy 		= $("input[name='rel_pb_biblestudy']").prop('checked')?1 :0;
			var rel_pb_meditate 		= $("input[name='rel_pb_meditate']").prop('checked')?1 :0;
			var rel_pb_worship 			= $("input[name='rel_pb_worship']").prop('checked')?1 :0;
			var rel_pb_pray 			= $("input[name='rel_pb_pray']").prop('checked')?1 :0;
			var rel_pb_other_chk 		= $("input[name='rel_pb_other_chk']").prop('checked')?1 :0;
			var rel_pb_other 			= $("input[name='rel_pb_other']").val()
			var rel_temple 				= $("select[id='rel_temple']").val()

			if (!god) {
				$.alert('??????????????????????????????')
				return false ;
			} else if (god == 10 && god_other == "") {
				$.alert('??????????????????????????????')
				return false ;
			} else if (!rel_activity) {
				$.alert('????????????????????????????????????????????????????????????????????????')
				return false ;
			} else {
				return true;
			}

			// else if (rel_activity == 4 && rel_activity_other == "") {
			// 	$.alert('????????????????????????????????????????????????????????????????????????')
			// 	return false ;
			// } else if (rel_donate_other_chk == 1 && rel_donate_other == "") {
			// 	$.alert('????????????????????????????????????????????????')
			// 	return false ;
			// } else if (rel_vol_other_chk == 1 && rel_vol_other == "") {
			// 	$.alert('?????????????????????????????????????????????????????????????????????')
			// 	return false ;
			// } else if (rel_pb_other_chk == 1 && rel_pb_other == "") {
			// 	$.alert('??????????????????????????????????????????????????????')
			// 	return false ;
			// } 
		}

		function AnswerCache() {

 			var ans_cache = JSON.parse(localStorage.getItem('profile_cache'));
 			if (!ans_cache) {
 				ans_cache = {};
 			}
 			
 			$("input[type='text']").on('change', function() {
 				ans_cache[$(this).attr('name')] = $(this).val()
 				localStorage.setItem('profile_cache', JSON.stringify(ans_cache));
 				console.log(JSON.parse(localStorage.getItem('profile_cache')))
 			})

 			$("input[type='number']").on('change', function() {
 				ans_cache[$(this).attr('name')] = $(this).val()
 				localStorage.setItem('profile_cache', JSON.stringify(ans_cache)); 	
 				console.log(JSON.parse(localStorage.getItem('profile_cache')))
 			})

 			$("input[type='radio']").on('change', function() {
 				ans_cache[$(this).attr('name')] = $(this).val()
 				localStorage.setItem('profile_cache', JSON.stringify(ans_cache)); 	
 				console.log(JSON.parse(localStorage.getItem('profile_cache')))
 			})

 			$("input[type='checkbox']").on('change', function() {
 				ans_cache[$(this).attr('name')] = $(this)[0].checked ?1 :0 ;
 				localStorage.setItem('profile_cache', JSON.stringify(ans_cache)); 	
 				console.log(JSON.parse(localStorage.getItem('profile_cache')))
 			})

 			$("select").on('change', function() {
 				ans_cache[$(this).attr('id')] = $(this).val()
 				localStorage.setItem('profile_cache', JSON.stringify(ans_cache)); 	
 				console.log(JSON.parse(localStorage.getItem('profile_cache')))
 			})
		}

		function FillAnswerCache() {
			var json_profile = JSON.parse(localStorage.getItem('profile_cache'))
			localStorage.setItem('profile_cache', JSON.stringify(json_profile));
			// console.log(json_profile)
			
			if (json_profile) {
				_.map(json_profile, function(value, key){
					// console.log(key, value)
					$("input[type='text'][name='" + key + "']").val(value)
					$("input[type='number'][name='" + key + "']").val(value)
					$("input[type='radio'][name='" + key + "'][value='" + value + "']").attr({ 'checked': 'true'}).parent().addClass('active')
					
					if (value == 1) {
						$("input[type='checkbox'][name='" + key + "']").attr({ 'checked': true}).parent().addClass('active')
					} else {
						$("input[type='checkbox'][name='" + key + "']").attr({ 'checked': false}).parent().removeClass('active')
					}

					$("select[id='" + key + "']").val(value)
				})

				if (json_profile.internal_member == 1) {
					$("input[type='radio'][name='internal_member'][value='1']").attr({ 'checked': true }).parent().addClass('active')
					$("input[type='radio'][name='internal_member'][value='0']").attr({ 'checked': false}).parent().removeClass('active')
				}

				// if (json_profile.marriage_other && json_profile.marriage_other != "") {
				// 	$("input[name='marriage_other']").show()
				// }

				// if (json_profile.livewithcouple_other && json_profile.livewithcouple_other != "") {
				// 	$("input[name='livewithcouple_other']").show()
				// }

				if (json_profile.job_other && json_profile.job_other != "") {
					$("input[name='job_other']").show()
				}

				if (json_profile.income_other && json_profile.income_other != "") {
					$("input[name='income_other']").show()
				}

				if (json_profile.god_other && json_profile.god_other != "") {
					$("input[name='god_other']").show()
				}

				if (json_profile.rel_activity_other && json_profile.rel_activity_other != "") {
					$("input[name='rel_activity_other']").show()
				}

				if (json_profile.rel_donate_other && json_profile.rel_donate_other != "") {
					$("input[name='rel_donate_other']").show()
				}

				if (json_profile.rel_vol_other && json_profile.rel_vol_other != "") {
					$("input[name='rel_vol_other']").show()
				}

				if (json_profile.rel_pb_other && json_profile.rel_pb_other != "") {
					$("input[name='rel_pb_other']").show()
				}
			}
		}

		function FetchProfile() {
			$.ajax({ 
				type: "POST",
				dataType: "json", 
				url: '',
				data: {
					FetchProfile: 1
				},success: function(data) {
					// console.log(data)
					var json_profile = data[0];
					console.log(json_profile)
					if (json_profile) {
						_.map(json_profile, function(value, key){
							// console.log(key, value)
							$("input[type='text'][name='" + key + "']").val(value)
							$("input[type='number'][name='" + key + "']").val(value)
							$("input[type='radio'][name='" + key + "'][value='" + value + "']").attr({ 'checked': 'true'}).parent().addClass('active')
							
							if (value == 1) {
								$("input[type='checkbox'][name='" + key + "']").attr({ 'checked': true}).parent().addClass('active')
							} else {
								$("input[type='checkbox'][name='" + key + "']").attr({ 'checked': false}).parent().removeClass('active')
							}

							$("select[id='" + key + "']").val(value)
						})

						if (json_profile.internal_member == 1) {
							$("input[type='radio'][name='internal_member'][value='1']").attr({ 'checked': true }).parent().addClass('active')
							$("input[type='radio'][name='internal_member'][value='0']").attr({ 'checked': false}).parent().removeClass('active')
						}

						// if (json_profile.marriage_other && json_profile.marriage_other != "") {
						// 	$("input[name='marriage_other']").show().val(json_profile.marriage_other)
						// }

						// if (json_profile.livewithcouple_other && json_profile.livewithcouple_other != "") {
						// 	$("input[name='livewithcouple_other']").show().val(json_profile.livewithcouple_other)
						// }

						if (json_profile.job_other && json_profile.job_other != "") {
							$("input[name='job_other']").show().val(json_profile.job_other)
						}

						if (json_profile.income_other && json_profile.income_other != "") {
							$("input[name='income_other']").show().val(json_profile.income_other)
						}

						if (json_profile.god_other && json_profile.god_other != "") {
							$("input[name='god_other']").show().val(json_profile.god_other)
						}

						if (json_profile.rel_activity_other && json_profile.rel_activity_other != "") {
							$("input[type='checkbox'][name='rel_activity_other']").attr({ 'checked': true}).parent().addClass('active')
							$("input[name='rel_activity_other']").show().val(json_profile.rel_activity_other)
						}

						if (json_profile.rel_donate_other && json_profile.rel_donate_other != "") {
							$("input[type='checkbox'][name='rel_donate_other']").attr({ 'checked': true}).parent().addClass('active')
							$("input[name='rel_donate_other']").show().val(json_profile.rel_donate_other)
						}

						if (json_profile.rel_vol_other && json_profile.rel_vol_other != "") {
							$("input[type='checkbox'][name='rel_vol_other']").attr({ 'checked': true}).parent().addClass('active')
							$("input[name='rel_vol_other']").show().val(json_profile.rel_vol_other)
						}

						if (json_profile.rel_pb_other && json_profile.rel_pb_other != "") {
							$("input[type='checkbox'][name='rel_pb_other']").attr({ 'checked': true}).parent().addClass('active')
							$("input[name='rel_pb_other']").show().val(json_profile.rel_pb_other)
						}

						FillResSelect(json_profile)
					}
				},error: function(e) {
					console.log(e)
				}
			})

			function FillResSelect(fdata) {
				$("select[id='citySelect']").val(fdata.city)
				var city 			= fdata.city;
				var TownSelect 		= $("select[id='townSelect']");

				$(TownSelect).empty();
				
				if (city == "??????") {
					$(TownSelect).empty().hide();
					$("input[name='res_other']").show().val(fdata.res_other)
				} else {
					$(TownSelect).show();
					$("input[name='res_other']").val('').hide()
					
					$.ajax({ 
						type: "POST",
						dataType: "json", 
						url: '',
						data:{
							FetchTown: 1,
							city: city
						},success: function (data) {
							$(TownSelect).empty().append(
								$("<option>").html('?????????').attr('value','')
							);
							
							for(var key in data){
								$(TownSelect).append(
									$("<option />").html(data[key].District).attr('value',data[key].District)
								);
							}

							$(TownSelect).val(fdata.town)
						}
					});	
				}
				
			}
		}
	</script>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container">
		<div class="main-login main-center">        
		<form id="form" >
			<fieldset >
				<div id="page_1">
					<div class="card-header text-center">
			           	<h4>????????????????????????</h4>
			        </div> 
					<div class="input-group">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text " >?????? / ??????</span>
					  	</div>
						<input type="text" class="form-control" name="name"  required>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????LINE??????????????????</span>
						</div>
						<input type="text" class="form-control" name="name_line"  placeholder="?????????">
					</div>
					<!-- <div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????</span>
						</div>
						<input name="height" type="number" class="form-control"   placeholder="?????? : ??????" min="100" required>
					</div> -->
					<!-- <div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????</span>
						</div>
						<input name="weight" type="number" class="form-control"   placeholder="?????? : ??????" min="30" required>
					</div> -->
					<div class="input-group">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
							<span class="input-group-text" id="test">??????</span>
						</div>
						<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-8 pl-0 pr-0" data-toggle="buttons">
						  <label class="btn btn-outline-primary">
						    <input type="radio" name="gender" value="1" required> ???
						  </label>
						  <label class="btn btn-outline-primary">
						    <input type="radio" name="gender" value="0"> ???
						  </label>
						</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????</span>
						</div>
					  	<div class="col-sm-8 pl-0 pr-0">
					  		<select id="age" class="form-control" required>
					  			<option value="" >?????????</option>
								<option value="0" >0 - 10???</option>
								<option value="1" >11 - 20???</option>
								<option value="2" >21 - 30???</option>
								<option value="3" >31 - 40???</option>
								<option value="4" >41 - 50???</option>
								<option value="5" >51 - 60???</option>
								<option value="6" >61 - 70???</option>
								<option value="7" >71 - 80???</option>
								<option value="8" >81 - 90???</option>
								<option value="9" >90?????????</option>
							</select>
					  	</div>
					</div>
					<div class="input-group ">
					  <div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    <span class="input-group-text" >??????????????????</span>
					  </div>
					  <div id="residence" class="col-sm-8 pl-0 pr-0 d-inline-flex"></div>
					</div>
					<!-- <div class="input-group ">
					  <div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    <span class="input-group-text" >?????????????????????</span>
					  </div>
					  <div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-8 pl-0 pr-0" data-toggle="buttons">
						  <label class="btn btn-outline-primary">
						    <input type="radio" name="livewithfamily" value="1"> ???
						  </label>
						  <label class="btn btn-outline-primary">
						    <input type="radio" name="livewithfamily" value="0"> ???
						  </label>
						</div>
					</div> -->
					<!-- <div class="input-group ">
					  	<div class="input-group-prepend col-sm-3 pl-0 pr-0">
							<span class="input-group-text" >????????????</span>
						</div>
						<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-primary">
							    <input type="radio" name="marriage" value="0"> ??????
							</label>
							<label class="btn btn-outline-primary">
							    <input type="radio" name="marriage" value="1"> ??????
							</label>
							<label class="btn btn-outline-primary">
								<input type="radio" name="marriage" value="2"> ??????
							</label>
						</div>
						<div class="col-sm-11 pl-0 pr-0">
							<input type="text" name="marriage_other" class="form-control hide_atfirst" placeholder="?????????????????????">
						</div>
					</div> -->
					<!-- <div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????????????? / ????????????</span>
						</div>
					  	<div class="col-sm-8 pl-0 pr-0">
					  		<select id="livewithcouple" class="form-control" required>
					  			<option value=""  >?????????</option>
								<option value="0" >????????? / ????????????</option>
								<option value="1" >??????</option>
								<option value="2" >??????</option>
								<option value="3" >???????????????????????????????????????????????????</option>
								<option value="4" >????????????</option>
								<option value="5" >?????????????????????????????????</option>
								<option value="6" >?????????(??????)</option>
								<option value="7" >??????</option>

							</select>
					  	</div>
					  	<div class="col-sm-11 pl-0 pr-0">
							<input type="text" name="livewithcouple_other" class="form-control hide_atfirst" placeholder="???????????????">
						</div>
					</div> -->
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????</span>
						</div>
					  	<div class="col-sm-8 pl-0 pr-0">
					  		<select id="job" class="form-control" required>
								<option value="" >?????????</option>
								<option value="0" >?????????</option>
								<option value="1" >????????????/???????????????</option>
								<option value="2" >?????????&????????????</option>
								<option value="3" >??????????????????</option>
								<option value="4" >?????????</option>
								<option value="5" >??????</option>
								<option value="6" >??????</option>
								<option value="7" >????????????</option>
								<option value="8" >?????????????????????</option>
								<option value="9" >????????????</option>
								<option value="10" >????????????</option>
								<option value="11" >??????</option>
							</select>
					  	</div>
					  	<div class="col-sm-11 pl-0 pr-0">
							<input type="text" name="job_other" class="form-control hide_atfirst" placeholder="???????????????">
						</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >????????????</span>
						</div>
					  	<div class="col-sm-8 pl-0 pr-0">
					  		<select id="edu" class="form-control" required>
					  			<option value="" >?????????</option>
								<option value="0" >???????????????</option>
								<option value="1" >??????/??????</option>
								<option value="2" >??????/???</option>
								<option value="3" >??????</option>
								<option value="4" >??????</option>
								<option value="5" >??????</option>
								<option value="6" >??????</option>
							</select>
					  	</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >??????????????????</span>
						</div>
					  	<div class="col-sm-8 pl-0 pr-0">
					  		<select id="income" class="form-control" required>
					  			<option value="" >?????????</option>
								<option value="0" >????????????</option>
								<option value="1" >????????????</option>
								<option value="2" >?????????</option>
								<option value="3" >????????????</option>
								<option value="4" >????????????</option>
								<option value="5" >?????????</option>
								<option value="6" >???</option>
								<option value="7" >??????</option>
							</select>
					  	</div>
					  	<div class="col-sm-11 pl-0 pr-0">
							<input type="text" name="income_other" class="form-control hide_atfirst" placeholder="???????????????">
						</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text text-left">????????????????????????<br class="d-none d-sm-block">?????????????????????</span>
						</div>
						<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-primary pt-onls">
						    	<input type="radio" name="surveymail" value="1"> ???
							</label>
							<label class="btn btn-outline-primary pt-onls">
						    	<input type="radio" name="surveymail" value="0"> ???
							</label>
						</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >???????????????????????????</span>
						</div>
						<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-primary">
						    	<input type="radio" name="internal_member" value="1"> ???
							</label>
							<label class="btn btn-outline-primary active" >
						  		<input type="radio" name="internal_member" value="0" checked> ???
							</label>
						</div>
					</div>
					<div align="center">
						<button id="btn_page_1" class="btn btn-success btn-lg btn-next-page">?????????</button>
					</div>
				</div>
				
				<div id="page_2" class="hide_atfirst">
					<div class="card-header text-center">
			           	<h4>?????????????????????????????????</h4>
			        </div> 
					<div class="input-group ">
						<div class="input-group-prepend col-sm-3 pl-0 pr-0">
					    	<span class="input-group-text" >?????????????????????????</span>
						</div>
					  	<div class="col-sm-8 pl-0 pr-0">
					  		<select id="god" class="form-control" required>
					  			<option value="" >?????????</option>
								<option value="0" >???????????????(??????)</option>
								<option value="1" >??????/??????</option>
								<option value="2" >???????????????</option>
								<option value="3" >??????</option>
								<option value="4" >????????????(??????)</option>
								<option value="5" >??????(???????????????)</option>
								<option value="6" >????????????</option>
								<option value="7" >?????????</option>
								<option value="8" >????????????(?????????)</option>
								<option value="9" >????????????</option>
								<option value="10" >??????</option>
								<option value="11" >??????????????????????????????</option>
							</select>
					  	</div>
					  	<div class="col-sm-11 pl-0 pr-0">
					  		<input type="text" name="god_other" placeholder="???????????????" class="form-control hide_atfirst">
					  	</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-12 pl-0 pr-0">
					    	<span class="input-group-text col-sm-12 text-left" >?????????????????????????????????????????????<br class="d-sm-none">??????????????????????</span>
						</div>
					  	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-12" data-toggle="buttons">
						  <label class="btn btn-outline-primary">
						    <input name="rel_activity" type="radio" value="0" required/>??????
						  </label>
						  <label class="btn btn-outline-primary">
						    <input name="rel_activity" type="radio" value="1" />?????????/?????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_activity" type="radio" value="2" />????????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_activity" type="radio" value="3" />??????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_activity" type="radio" value="4" />??????
						  </label>
						</div>
						<div class="col-sm-12 pl-0 pr-0">
					  		<input type="text" name="rel_activity_other" placeholder="???????????????" class="form-control hide_atfirst">
					  	</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-12">
					    	<span class="input-group-text col-sm-12" >????????????????????????????????????(??????)?</span>
						</div>
					  	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-12" data-toggle="buttons">
						  <label class="btn btn-outline-primary">
						    <input name="rel_donate_buddhism" type="checkbox"/>??????
						  </label>
						  <label class="btn btn-outline-primary">
						    <input name="rel_donate_christianity" type="checkbox"/>?????????/?????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_donate_folkbelief" type="checkbox"/>????????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_donate_taoism" type="checkbox"/>??????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_donate_other_chk" type="checkbox"/>??????
						  </label>
						</div>
						<div class="col-sm-12 pl-0 pr-0">
					  		<input type="text" name="rel_donate_other" placeholder="???????????????" class="form-control hide_atfirst">
					  	</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-12">
					    	<span class="input-group-text col-sm-12 text-left" >????????????????????????????????????????????????<br class="d-sm-none">???????????????(??????)?</span>
						</div>
					  	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-12" data-toggle="buttons">
						  <label class="btn btn-outline-primary">
						    <input name="rel_vol_buddhism" type="checkbox"/>??????
						  </label>
						  <label class="btn btn-outline-primary">
						    <input name="rel_vol_christianity" type="checkbox"/>?????????/?????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_vol_folkbelief" type="checkbox"/>????????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_vol_taoism" type="checkbox"/>??????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_vol_other_chk" type="checkbox"/>??????
						  </label>
						</div>
						<div class="col-sm-12 pl-0 pr-0">
					  		<input type="text" name="rel_vol_other" placeholder="???????????????" class="form-control hide_atfirst">
					  	</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-12">
					    	<span class="input-group-text col-sm-12 text-left" >????????????????????????????????????????????????(??????)</span>
						</div>
					  	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-12" data-toggle="buttons">
						  <label class="btn btn-outline-primary">
						    <input name="rel_pb_biblestudy" type="checkbox"/>?????????
						  </label>
						  <label class="btn btn-outline-primary">
						    <input name="rel_pb_meditate" type="checkbox"/>??????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_pb_worship" type="checkbox"/>?????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_pb_pray" type="checkbox"/>?????????????????????
						  </label>
						  <label class="btn btn-outline-primary">
						  	<input name="rel_pb_other_chk" type="checkbox"/>??????
						  </label>
						</div>
						<div class="col-sm-12 pl-0 pr-0">
					  		<input type="text" name="rel_pb_other" placeholder="???????????????" class="form-control hide_atfirst">
					  	</div>
					</div>
					<div class="input-group ">
						<div class="input-group-prepend col-sm-12">
					    	<span class="input-group-text col-sm-12" >?????????????????????????????????????</span>
						</div>
					  	<div class="col-sm-12 pl-0 pr-0">
					  		<select id="rel_temple" class="form-control" required>
					  			<option value="" >?????????</option>
								<option value="0" >??????</option>
								<option value="1" >???????????????</option>
								<option value="2" >??????????????? (???????????????????????????)</option>
								<option value="3" >????????????(????????????)</option>
								<option value="4" >????????????</option>
							</select>
					  	</div>
					</div>
					<hr>
					<div align="center">
						<button id="btn_page_2" class="btn btn-success btn-lg btn-last-page">?????????</button>
						<input class="btn btn-primary btn-lg " type="submit" id="submit" value="??????!">
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	</div>
	<footer class="footer">
  		<div class="container">
  			<img id="footerimg"src="./pic/Academia_Sinica_Emblem.png" >
		    <div class="text">
			?????????????????????????????????????????. ????????????.<br>
		    Copyright?? Institute of Statistical Science, Academia Sinica.
		    All rights reserved.
		    </div>
		</div>
   	</footer>
</body>

</html>
<?php
	session_start();
	include("db.php"); 
	CheckAccInfo();
	
	$ego_id   = $_SESSION['acc_info']['id'];
 	$alter_id = $_GET['alter_id'];

	if (isset($_POST['FetchAlterProfile'])) {
		$sql  = "SELECT alter_name FROM `alter_list` WHERE ego_id = :v1 and alter_id = :v2";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $alter_id);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		echo $rs["alter_name"];
		exit();
	}

	if(isset($_POST['getalters'])){
		GetAlters();
		exit();	
	}

	if (isset($_POST['CheckTdiaryExist'])) {
		$date = $_POST['date'];
		$sql = "SELECT * FROM `tdiary` WHERE ego_id = :v1 AND alter_id = :v2 AND `date` = :v3";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $alter_id);
		$stmt->bindParam(':v3', $date);
		$stmt->execute();
		echo $stmt->rowCount();
		exit();
	}

	if (isset($_POST['FormSubmit'])) {
		$date 			= $_POST['date'];
		$period 		= $_POST['period'];
		$familiar 		= $_POST['familiar'];
		$who_touch 		= $_POST['who_touch'];
		$touch_approach = $_POST['touch_approach'];
		$other_people 	= $_POST['other_people'];
		$touch_time 	= $_POST['touch_time'];
		$touch_book 	= $_POST['touch_book'];
		$touch_leisure 	= $_POST['touch_leisure'];
		$touch_social 	= $_POST['touch_social'];
		$touch_homelife = $_POST['touch_homelife'];
		$touch_rel 		= $_POST['touch_rel'];
		$touch_other 	= $_POST['touch_other'];
		$symptom 		= $_POST['symptom'];
		$symptom_sick 	= $_POST['symptom_sick'];
		$symptom_fever 	= $_POST['symptom_fever'];
		$symptom_cough 	= $_POST['symptom_cough'];
		$symptom_sorethroat = $_POST['symptom_sorethroat'];
		$symptom_hospital 	= $_POST['symptom_hospital'];
		$symptom_other 		= $_POST['symptom_other'];
		$gain_spiritual 	= $_POST['gain_spiritual'];
		$mood_ego_0 		= $_POST['mood_ego_0'];
		$mood_ego_1 		= $_POST['mood_ego_1'];
		$mood_alter_0 		= $_POST['mood_alter_0'];
		$mood_alter_1 		= $_POST['mood_alter_1'];
		$gain_instrumental 	= $_POST['gain_instrumental'];
		$place 	= $_POST['place'];
		// $alter_tbl 			= $_POST['alter_tbl'];
		$alter_tbl 			= empty($_POST['alter_tbl'])  ? null :$_POST['alter_tbl'];
		$index_duplicate    = $ego_id."_".$alter_id."_".$date;
		$now 				= date("Y-m-d H:i:s");

		$sql = "INSERT INTO
				    `tdiary`(
				        `ego_id`,
				        `alter_id`,
				        `date`,
				        `period`,
				        `familiar`,
				        `who_touch`,
				        `touch_approach`,
				        `other_people`,
				        `touch_time`,
				        `touch_book`,
				        `touch_leisure`,
				        `touch_social`,
				        `touch_homelife`,
				        `touch_rel`,
				        `touch_other`,
				        `symptom`,
				        `symptom_sick`,
				        `symptom_fever`,
				        `symptom_cough`,
				        `symptom_sorethroat`,
				        `symptom_hospital`,
				        `symptom_other`,
				        `gain_spiritual`,
				        `mood_ego_0`,
				        `mood_ego_1`,
				        `mood_alter_0`,
				        `mood_alter_1`,
				        `gain_instrumental`,
						`place`,
				        `index_duplicate`,
				        `create_time`
				    )
				VALUES (
					:v1,
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
					:v31
				)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $alter_id);
		$stmt->bindParam(':v3', $date);
		$stmt->bindParam(':v4', $period);
		$stmt->bindParam(':v5', $familiar);
		$stmt->bindParam(':v6', $who_touch);
		$stmt->bindParam(':v7', $touch_approach);
		$stmt->bindParam(':v8', $other_people);
		$stmt->bindParam(':v9', $touch_time);
		$stmt->bindParam(':v10', $touch_book);
		$stmt->bindParam(':v11', $touch_leisure);
		$stmt->bindParam(':v12', $touch_social);
		$stmt->bindParam(':v13', $touch_homelife);
		$stmt->bindParam(':v14', $touch_rel);
		$stmt->bindParam(':v15', $touch_other);
		$stmt->bindParam(':v16', $symptom);
		$stmt->bindParam(':v17', $symptom_sick);
		$stmt->bindParam(':v18', $symptom_fever);
		$stmt->bindParam(':v19', $symptom_cough);
		$stmt->bindParam(':v20', $symptom_sorethroat);
		$stmt->bindParam(':v21', $symptom_hospital);
		$stmt->bindParam(':v22', $symptom_other);
		$stmt->bindParam(':v23', $gain_spiritual);
		$stmt->bindParam(':v24', $mood_ego_0);
		$stmt->bindParam(':v25', $mood_ego_1);
		$stmt->bindParam(':v26', $mood_alter_0);
		$stmt->bindParam(':v27', $mood_alter_1);
		$stmt->bindParam(':v28', $gain_instrumental);
		$stmt->bindParam(':v29', $place);
		$stmt->bindParam(':v30', $index_duplicate);
		$stmt->bindParam(':v31', $now);

		try {
			
			$stmt->execute();
			$arr = $alter_tbl;

			if(count($arr) > 0){
				$n = count($arr['altersid']);
				for ($i = 0; $i < $n; $i = $i+1) { 
					$a = $arr['altersid'][$i]; // alter 2's id
					$b = $arr['familiar'][$i];	
					$check_index = $ego_id."_".$alter_id."_".$a."_".$b; 	// ego_id + alter_id_1 + alter_id2_2 + familiar
					
					$sql = " SELECT * FROM alters_table 
							 WHERE ego_id = :ego_id and alter_id1 = :alter_id1 and alter_id2 = :alter_id2
							 ORDER BY date DESC limit 1 ";
					$stmt0 = $db->prepare($sql);
					$stmt0->bindParam(':ego_id', $ego_id);
					$stmt0->bindParam(':alter_id1', $alter_id);
					$stmt0->bindParam(':alter_id2', $a);
					$stmt0->execute();
					$rs = $stmt0->fetch(PDO::FETCH_ASSOC);
					$rs_check_index = $rs['check_index'];

					// 跟最近一次record相比，有改變才寫入
					if( $rs_check_index != $check_index){		
						$sql_query = "INSERT into alters_table(ego_id,alter_id1,alter_id2,date,familiar,create_time,check_index)  
									  VALUES(:ego_id,:alter_id1,:alter_id2,:date,:familiar,:create_time,:check_index)  ";
						$stmt=$db->prepare($sql_query);
						$stmt->bindParam(':ego_id', $ego_id);
						$stmt->bindParam(':alter_id1', $alter_id);
						$stmt->bindParam(':alter_id2', $a);
						$stmt->bindParam(':date', $date);
						$stmt->bindParam(':familiar', $b);
						$stmt->bindParam(':create_time', $now);
						$stmt->bindParam(':check_index', $check_index);
						$stmt->execute();
					}
				}
			}

			$sql  = "UPDATE `alter_list` 
						 SET `last_record` = :now ,`touchtimes` = `touchtimes` + 1
						 WHERE `ego_id` = :ego_id AND `alter_id` = :alter_id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':ego_id', $ego_id);
			$stmt->bindParam(':alter_id', $alter_id);
			$stmt->bindParam(':now',$now);
			$stmt->execute();

			echo "SubmitSuccess";
			
		} catch (Exception $e) {
		    echo 'Caught exception: ',  $e -> getMessage(), "\n";
		}
		exit();
	}

	function GetAlters(){
		// Function外定義的變數需經過global定義才能直接在function內使用
		global $db;
		global $ego_id;
		global $alter_id;
		
		//query all other alters to show in table
		$sql  = " SELECT alter_id, alter_name FROM alter_list where ego_id = :v1 and alter_id != :v2";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $alter_id);
		$stmt->execute();
		$json = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}

		//query alters has been checked familiar with this alter
		$sql  = "SELECT  alter_id1 as tmp FROM `alters_table` WHERE ego_id = :v1 AND alter_id2 = :v2
				 UNION DISTINCT 
				 SELECT  alter_id2 as tmp FROM `alters_table` WHERE ego_id = :v1 AND alter_id1 = :v2";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $alter_id);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$arr_alters_checked[] = $row['tmp'];
			}	
		} else {
			$arr_alters_checked = [];
		}
		
		// Identify whether checked for each alter
		foreach ($json as $key => $value) {
			if(in_array($json[$key]['alter_id'], $arr_alters_checked)) {
				$json[$key]['checked'] = 1;
			}else{
				$json[$key]['checked'] = 0;
			}
		}
		$rs_other_alters_all = json_encode($json, JSON_UNESCAPED_UNICODE);
		echo $rs_other_alters_all;
		exit();
	}


?><!doctype html>
<html lang="zh-tw">
<head>
	<title>接觸日記</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta http-equiv="cache-control" content="no-cache">
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
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- SelectPicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
	<!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
	<script type="text/javascript">	
		$(document).ready(function(){
			
			FetchAlterProfile();
			DisplayDate();
			MovementControl();
			GetAlters();
			
			
			$("#form").on('submit', function(evt) {
				evt.preventDefault();

				var date 				= $("select[id='date']").val()
				var period 				= $("select[id='period']").val()
				var familiar 			= 999;
				var who_touch 			= $("input[name='who_touch']:checked").val()
				var touch_approach 		= $("input[name='touch_approach']:checked").val()
				var other_people 		= $("input[name='other_people']:checked").val()
				var touch_time 			= $("input[name='touch_time']:checked").val()

				var touch_book 			= $("input[name='touch_book']").is(":checked") ?1 :0 ;
				var touch_leisure 		= $("input[name='touch_leisure']").is(":checked") ?1 :0 ;
				var touch_social 		= $("input[name='touch_social']").is(":checked") ?1 :0 ;
				var touch_homelife 		= $("input[name='touch_homelife']").is(":checked") ?1 :0 ;
				var touch_rel 			= $("input[name='touch_rel']").is(":checked") ?1 :0 ;
				var touch_other_chk 	= $("input[name='touch_other_chk']").is(":checked") ?1 :0 ;
				var touch_other 		= $("input[name='touch_other']").val()
				var touch_sum 			= touch_book + touch_leisure + touch_social + touch_homelife + touch_rel + touch_other_chk;

				// var symptom 			= $("input[name='symptom']:checked").val()
				// var symptom_sick 		= $("input[name='sick']").is(":checked") ?1 :0 ;
				// var symptom_fever 		= $("input[name='fever']").is(":checked") ?1 :0 ;
				// var symptom_cough 		= $("input[name='cough']").is(":checked") ?1 :0 ;
				// var symptom_sorethroat 	= $("input[name='sorethroat']").is(":checked") ?1 :0 ;
				// var symptom_hospital 	= $("input[name='hospital']").is(":checked") ?1 :0 ;
				// var symptom_other_chk 	= $("input[name='symptom_other_chk']").is(":checked") ?1 :0 ;
				// var symptom_other 		= $("input[name='symptom_other']").val()
				var symptom 			= 999;
				var symptom_sick 		= 999;
				var symptom_fever 		= 999;
				var symptom_cough 		= 999;
				var symptom_sorethroat 	= 999;
				var symptom_hospital 	= 999;
				var symptom_other_chk 	= 999;
				var symptom_other 		= "";
				var symptom_sum 		= symptom_sick + symptom_fever + symptom_cough + symptom_sorethroat + symptom_hospital + symptom_other_chk;

				var gain_spiritual 		= $("input[name='gain_spiritual']:checked").val();
				var mood_ego_0 			= $("input[name='mood_ego_0']:checked").val();
				var mood_ego_1 			= $("input[name='mood_ego_1']:checked").val();
				var mood_alter_0 		= $("input[name='mood_alter_0']:checked").val();
				var mood_alter_1 		= $("input[name='mood_alter_1']:checked").val();
				var gain_instrumental 	= $("input[name='gain_instrumental']:checked").val();
				var place 				= $("input[name='place']:checked").val();

				var alter_tbl = { altersid: [], familiar:[] };
	    		$("input[class='familiars']:checked").each(function(){
					alter_tbl.altersid.push($(this).attr('name'))
					alter_tbl.familiar.push($(this).val())
				})
				
				console.log(
					date,
					period,
					familiar,
					who_touch,
					touch_approach,
					other_people,
					touch_time,

					touch_book,
					touch_leisure,
					touch_social,
					touch_homelife,
					touch_rel,
					touch_other_chk,
					touch_other,
					touch_sum,

					symptom,
					symptom_sick,
					symptom_fever, 
					symptom_cough , 
					symptom_sorethroat,
					symptom_hospital, 	
					symptom_other_chk, 
					symptom_other, 	
					symptom_sum
				)


				console.log(
					 gain_spiritual,
					 mood_ego_0,
					 mood_ego_1,
					 mood_alter_0,
					 mood_alter_1,
					 gain_instrumental
				)
				
				console.log(alter_tbl)

				
				if (!date) {
					$.alert("填寫哪一天的接觸紀錄？")
					return false;
				} else if (!period) {
					$.alert("本次接觸的時段？")
					return false;
				} else if (!who_touch) {
					$.alert("這次是誰主動接觸？")
					return false;
				} else if (!touch_approach) {
					$.alert("這次主要接觸方式？")
					return false;
				} else if (!other_people) {
					$.alert("這次接觸有多少他人在場？")
					return false;
				} else if (!touch_time) {
					$.alert("這次互動接觸的時間？")
					return false;
				} else if (touch_sum == 0) {
					$.alert("請選擇這次互動接觸的內容(可複選)？")
					return false;
				} else if (!symptom) {
					$.alert("這次接觸時對方是否身體不適？")
					return false;
				} else if ((symptom == 1 || symptom == 2) && symptom_sum == 0) {
					$.alert("請點選症狀(可複選)")
					return false;
				} else if (!gain_spiritual) {
					$.alert("接觸過程中，我是否有靈性方面的啟發/感受？")
					return false;
				} else if (!mood_ego_0) {
					$.alert("這次接觸前，我的心情如何？")
					return false;
				} else if (!mood_ego_1) {
					$.alert("這次接觸後，我的心情如何？")
					return false;
				} else if (!mood_alter_0) {
					$.alert("這次接觸開始時，對方的心情如何？")
					return false;
				} else if (!mood_alter_1) {
					$.alert("這次接觸結束時，對方的心情如何？")
					return false;
				} else if (!gain_instrumental) {
					$.alert("接觸過程中，我是否有靈性方面的啟發/感受？")
					return false;
				} else if (!place) {
					$.alert("這次接觸的時候你人在哪裡？")
					return false;
				}

				$.ajax({ 
					type: "POST",
					url: '',
					data: {
						FormSubmit: 1,
						date: date,
						period: period,
						familiar: familiar,
						who_touch: who_touch,
						touch_approach: touch_approach,
						other_people: other_people,
						touch_time: touch_time,
						touch_book: touch_book,
						touch_leisure: touch_leisure,
						touch_social: touch_social,
						touch_homelife: touch_homelife,
						touch_rel: touch_rel,
						touch_other: touch_other,
						symptom: symptom,
						symptom_sick: symptom_sick,
						symptom_fever: symptom_fever, 
						symptom_cough: symptom_cough, 
						symptom_sorethroat: symptom_sorethroat,
						symptom_hospital: symptom_hospital, 	
						symptom_other: symptom_other, 	
						gain_spiritual: gain_spiritual,
						mood_ego_0: mood_ego_0,
						mood_ego_1: mood_ego_1,
						mood_alter_0: mood_alter_0,
						mood_alter_1: mood_alter_1,
						gain_instrumental: gain_instrumental,
						place: place,
						alter_tbl: alter_tbl
					},beforeSend: function() { 
						//$("#loadingtext").show();
						$("#FormSubmit").prop('disabled', true);
					},complete : function (){
						//$("#loadingtext").hide();
						$("#FormSubmit").prop('disabled', false);
					},success: function(data){
						// console.log(data)
						if (data == "SubmitSuccess") {

							$.alert({
								title: '',
							    content: '本次接觸紀錄完成！',
							});

							setTimeout(function() {
								window.location.href = 'http://cdiary3.tw/alter_list.php';
							}, 1250);
							
						}
					},error: function(e){
						console.log(e)
						$.alert("錯誤，請確認是否有題目漏填<br>若問題持續發生請聯繫我們<br>***@stat.sinica.edu.tw")
					}
				})
				
			});
			
		})

		function MovementControl() {

			$("#date").on('change', function(evt){
				evt.preventDefault()
				var tmp = $(this).val()
				// console.log(tmp)
				if (tmp) {
					CheckTdiaryExist(tmp);
				}
			})

			$("input[name='symptom']").on('change', function(){
				var tmp = $(this).val()

				if (tmp == 1 || tmp == 2) {
					$("#div_symptom").show()
				} else {
					$(".chkbox_symptoms").attr({'checked': false}).parent().removeClass('active').attr({'style': 'color: #007bff; background-color: transparent;'})
					$("input[name='symptom_other']").val('')
					$("#div_symptom").hide()
				}
			})

			$("input[name='symptom_other_chk']").on('change', function(){
				var tmp = $(this).is(':checked') ?1 :0 ;
				// console.log(tmp)
				if (tmp == 1) {
					$("input[name='symptom_other']").show()
				} else {
					$("input[name='symptom_other']").val('')
					$("input[name='symptom_other']").hide()
				}
			})

			$("input[name='touch_other_chk']").on('change', function(){
				var tmp = $(this).is(':checked') ?1 :0 ;
				// console.log(tmp)
				if (tmp == 1) {
					$("input[name='touch_other']").show()
				} else {
					$("input[name='touch_other']").val('')
					$("input[name='touch_other']").hide()
				}
			})

			$("#back").on('click', function() {
				window.location.href = "http://cdiary3.tw/alter_list.php";
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

		function DisplayDate() {
			var date_td = (function(d){ 
							var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
							var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
							var yyyy = d.getFullYear();			
							return (yyyy + "-" + MM + "-" + dd);
						  })(new Date);

			var date_yd = (function(d){ 
							d.setDate(d.getDate()-1);
							var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
							var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
							var yyyy = d.getFullYear();			
							return (yyyy + "-" + MM + "-" + dd);
						  })(new Date);

			(function(d){ 
				$("#date").append(
					$("<option>").html("請選擇日期").attr({'value': ''})
				).append(
					$("<option>").html(date_yd + " (昨日)").attr({'value': date_yd})
				).append(
					$("<option>").html(date_td + " (今日)").attr({'value': date_td})
				)
			})(new Date);
		}

		function FetchAlterProfile() {
			$.ajax({ 
				type: "POST",
				url: '',
				data: {
					FetchAlterProfile: 1
				},success: function(data) {
					console.log(data)
					$("#alter_name").empty().html(data).attr({
						'style': 'position: fixed; left: 0; z-index: 1000; writing-mode: vertical-lr; font-size: 1.5rem; font-weight: 500;'
					});
					$(".alter_name_fill").empty().html(data)
				},error: function(e) {
					console.log(e)
				}
			})
		}

		function GetAlters(){
			$.ajax({ 
				type: "POST",
				dataType: "json", 
				url: '',
				data: {
					getalters: 1
				},success: function(data){
					console.log("altersWithCheckedORNOT", data);
					other_alters = data;
					LoadAltersTbl(other_alters);

					$(jQuery).on('click', "#get5more", function(evt){
						evt.preventDefault();
						// 1.檢查目前5位已點選熟悉程度
						// 表中有幾位alter
						var k_currentAlters = $(".altersname").length
						var k_checkedAlters = $("input[class='familiars']:checked").length
						console.log(k_currentAlters, k_checkedAlters)

						if(k_currentAlters != k_checkedAlters){
							$.alert("請先確認目前對象的熟悉程度");
							return false;
						}else{
							// 2.另抽5位，已確認的5位自畫面隱藏
							$(".table").hide();
							alters_remain = Get5moreAlters(other_alters);
							console.log("another5", alters_remain)
							LoadAltersTbl(alters_remain);		
						}
						
					})
				},error: function(e){ 
				    console.log(e);
				}
			});
		}

		function LoadAltersTbl(falters){
			var isFirstLoad = $(".alters_ids").length;
			// console.log(isFirstLoad)
			if(falters.length == 0){
				var errormsg = '找不到更多認識的對象可供確認,多建立幾位接觸對象吧!!<br>';
				$('#alters_table').append(
					$('<span>').html(errormsg).attr({style:'color:red'})
				);
			}else{
				alter_checkedN = _.filter(falters, {'checked': 0})
				alter_checkedY = _.filter(falters, {'checked': 1})
				if(alter_checkedN.length >= 5){
					falters = _.sampleSize(alter_checkedN, 5);	
				}else{
					falters = _.concat( alter_checkedN, _.sampleSize(alter_checkedY, 5 - alter_checkedN.length) )
				}
				// falters = _.sampleSize(falters, 5);
				var alters = falters;
				var rows   = falters.length;
				var cols   = 5;
				var table  = $('<table>').attr({'class':'table'}).append($('<tbody>'));
				
				table.append(
					$('<tr>').append(
						$('<td>').append(
							$('<span>').attr({'class':'alter_name_fill'})
						).append(
							$('<span>').html('認不認識<br>下列對象')
						)
					  ).append(
					  	$('<td>').append(
					  		$('<span>').html('熟悉程度')
					  	)
					  )
				);
				for(var r = 0; r < rows; r++){   
				    var tr2=$('<tr>');
				    var td1=$('<td>').attr({'class':'altersname'});
				    // 
				    td1.append(alters[r].alter_name).append(
				    	$('<input>').attr({	type:'hidden',
				    						value:alters[r].alter_id,
				    						name:'alter_id'+(r+1),
				    						class: 'alters_ids'})
				    );
				    
				    var td2 		= $('<td>');
					var colsm8div 	= $('<div>').attr({class:'col-sm-8 table-col-sm-8'});
					var btndiv 		= $('<div>').attr({class:'btn-group btn-group-toggle','data-toggle':'buttons', style: 'width: 100%'});
				    td2.append(colsm8div);
					colsm8div.append(btndiv);
					
					btndiv.append( 
							$('<label>').html('很熟').attr({class:'btn btn-outline-primary btn-familiar'}).prepend( 
								$('<input>').attr({ 
									type: 'radio',
									name: alters[r].alter_id,
									value: 0,
									class: 'familiars',
									required: true
								})
							)
						 ).append( 
						 	$('<label>').html('認識但不熟').attr({class:'btn btn-outline-primary btn-familiar'}).prepend( 
						 		$('<input>').attr({
						 			type: 'radio',
						 			name: alters[r].alter_id,
						 			value: 1,
						 			class: 'familiars'
						 		})  
						 	)
						 ).append( 
						 	$('<label>').html('不認識').attr({class:'btn btn-outline-primary btn-familiar'}).prepend(
						 		$('<input>').attr({
						 			type: 'radio',
						 			name: alters[r].alter_id,
						 			value: 2,
						 			class: 'familiars'
						 		}) 
						 	)
						 );
				    
				    table.append(tr2);
				    tr2.append(td1).append(td2);
				 }

				table.appendTo('#alters_table'); 
				if(isFirstLoad == 0){
					btn_get5more = $('<div>').append($('<button>').html('再抽5位接觸對象').attr(
								{'id':'get5more','class':'btn btn-info','style':'width: 10em; padding: 0.5em'}
							  ))
					btn_get5more.appendTo('#alters_table');
					
				}
			}
		}

		function Get5moreAlters(falters){
			// All alters
			// falters
			// Define alters have been sampled
			var filter = [];
			$(".alters_ids").each(function(){
				filter.push($(this).val())
			})
			// console.log(filter)
			// Remaining alters
			result = _.filter(falters, function(o) {   
					return _.indexOf(filter, o.alter_id) === -1    
		 		  });
			// console.log(result)
			return result;

		}

		function CheckTdiaryExist(fdate){
			$.ajax({ 
				type: "POST",
				dataType: "json", 
				url: '',
				data: {
					CheckTdiaryExist: 1,
					date: fdate
				},success: function(data){
					console.log("CheckTdiaryExist", data);
					if (data == 1) {
						$("#CheckTdiaryExist").empty().html('已填過' + fdate + '的接觸日記囉~ 請勿重複填寫')
						$("#FormSubmit").prop('disabled', true);
					} else {
						$("#CheckTdiaryExist").empty()
						$("#FormSubmit").prop('disabled', false);
					}
				},error: function(e){ 
				    console.log(e);
				}
			});
		}
	</script>
	<style type="text/css">
		/* ------------------------------ Navbar & Footer  ----------------------------------- */
		html {
			position: relative;
			min-height: 100%;
		}

		body {
			padding-top: 90px;  /* Avoid nav bar overlap web content */
			margin-bottom: 60px; /* Margin bottom by footer height ，avoid footer overlap web content */
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
		#date, #period {
			width: 50%;
		}

		.card{
			margin: 1rem auto;
		}

		.input-group{
			margin: 1rem auto;
		}

		.input-group-text{
			width: 100%;
			font-size: 0.9rem;
		}

		#div_symptom>.btn{
			margin-top: 0.5rem;
			width: 24%;
		}

		input[name='symptom_other']{
			/*display: inline-flex; */
			margin-top: 0.5rem;
			width: 50%;
			vertical-align: middle;
		}

		/* Alter Table */
			tbody {
			    display: table-row-group;
			    vertical-align: middle;
			    border-color: inherit;
			}
			.table>tbody>tr>td {
			    padding: 0.5em 0.25em 0;
			}
			.altersname{
				width:8em
			}
			.table-col-sm-8 {
			    padding-left: 0;
			    padding-right: 0;
			}
		/* --------------------------- */

		.hide_atfirst {
			display: none;
		}

		.btn-lg {
			width: 35%;
			height: 3rem;
			margin: auto 1em;
		}

		@media screen and (max-width: 550px) {
			.btn {
			    padding: .375rem .05rem;
			}

			.btn.focus {
				color: inherit;
				background-color: transparent;
			}

			#div_symptom>.btn {
				width: 49%;
			}

			input[name='symptom_other'] {
				width: 100%;
			}

			#alter_name {
				top: 10%;
				font-size: 1rem;
				padding: .25rem .35rem;
			}

			.container {
				padding: 0.25rem;
			}

			.card-body {
				padding: 0.75rem 0.5rem;
			}

			.btn-familiar {
				padding: .5rem .25rem;
			}
		}
	</style>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container">
		<form id="form">
		<span id="alter_name" class="badge badge-warning"></span>
		<div class="card border-primary">
			<div class="card-header text-white bg-primary">本次接觸紀錄</div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">本次主要接觸時段</span>
					</div>
					<div class="col-sm-8 pl-0 pr-0 d-inline-flex">
						<select id="date"   class="form-control" required></select>
						<select id="period" class="form-control" required>
							<option value="">請選擇時段</option>
							<option value="1">上午</option>
							<option value="2">中午</option>
							<option value="3">下午</option>
							<option value="4">晚上</option>
							<option value="5">凌晨</option>
						</select>
					</div>
					<div class="col-sm-12 text-danger" id="CheckTdiaryExist"></div>
				</div>
				<!-- <div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次接觸以前我和<span class="alter_name_fill"></span>的熟悉程度</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="familiar" value="0" required>非常熟</label>
						<label class="btn btn-outline-primary"><input type="radio" name="familiar" value="1" required>很熟</label>
						<label class="btn btn-outline-primary"><input type="radio" name="familiar" value="2" required>普通</label>
						<label class="btn btn-outline-primary"><input type="radio" name="familiar" value="3" required>不熟</label>
						<label class="btn btn-outline-primary"><input type="radio" name="familiar" value="4" required>非常不熟</label>
					</div>
				</div> -->
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次是誰主動接觸</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="who_touch" value="0" required>自己</label>
						<label class="btn btn-outline-primary"><input type="radio" name="who_touch" value="1" required>對方</label>
						<label class="btn btn-outline-primary"><input type="radio" name="who_touch" value="2" required>事先約定</label>
						<label class="btn btn-outline-primary"><input type="radio" name="who_touch" value="3" required>偶遇</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次主要接觸方式</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="touch_approach" value="0" required>見面</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_approach" value="1" required>視訊</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_approach" value="2" required>語音通話</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_approach" value="3" required>文字(簡訊、email、Line等)</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次接觸有多少他人在場</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="other_people" value="0" required>0人</label>
						<label class="btn btn-outline-primary"><input type="radio" name="other_people" value="1" required>1-2人</label>
						<label class="btn btn-outline-primary"><input type="radio" name="other_people" value="2" required>3-5人</label>
						<label class="btn btn-outline-primary"><input type="radio" name="other_people" value="3" required>大於5人</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次互動接觸的時間</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="touch_time" value="0" required>少於1分鐘</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_time" value="1" required>1-4分</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_time" value="2" required>5-14分</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_time" value="3" required>15-59分</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_time" value="4" required>1-4小時</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touch_time" value="5" required>大於4小時</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次互動接觸的內容(可複選)</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="checkbox" name="touch_rel" 		>宗教活動</label>
						<label class="btn btn-outline-primary"><input type="checkbox" name="touch_book"		>課業/工作</label>
						<label class="btn btn-outline-primary"><input type="checkbox" name="touch_leisure" 	>運動休閒</label>
						<label class="btn btn-outline-primary"><input type="checkbox" name="touch_social" 	>社交聊天</label>
						<label class="btn btn-outline-primary"><input type="checkbox" name="touch_homelife" >日常作息/家務事</label>
						<label class="btn btn-outline-primary"><input type="checkbox" name="touch_other_chk" 	>其他</label>
					</div>
					<div class="col-sm-12 pl-0 pr-0">
						<input name="touch_other" type="text" class="form-control hide_atfirst" placeholder="補充說明互動接觸內容">
					</div>
				</div>			
				<!-- <div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次接觸時對方是否身體不適</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="symptom" value="0" required>沒有</label>
						<label class="btn btn-outline-primary"><input type="radio" name="symptom" value="1" required>可能有</label>
						<label class="btn btn-outline-primary"><input type="radio" name="symptom" value="2" required>確定有</label>
						<label class="btn btn-outline-primary"><input type="radio" name="symptom" value="3" required>不知道</label>
					</div>
					<div id="div_symptom" class="btn-group-toggle col-sm-12 pl-0 pr-0 hide_atfirst" data-toggle="buttons">
						<div class="mt-2">請點選症狀(可複選)</div>
						<label for="sick" class="btn btn-outline-info">
							<input id="sick" class="chkbox_symptoms" type="checkbox" name="sick" >確定有感冒
						</label>
					  	<label for="fever" class="btn btn-outline-info">
					  		<input id="fever" class="chkbox_symptoms" type="checkbox" name="fever">發燒(高於38度)
					  	</label>
					  	<label for="cough" class="btn btn-outline-info">
					  		<input id="cough" class="chkbox_symptoms" type="checkbox" name="cough">咳嗽
					  	</label>
						<label for="sorethroat" class="btn btn-outline-info">
							<input id="sorethroat"  class="chkbox_symptoms" type="checkbox" name="sorethroat">喉嚨痛
						</label>
						<label for="hospital" class="btn btn-outline-info">
							<input id="hospital"  class="chkbox_symptoms" type="checkbox" name="hospital">前往就醫(含診所)
						</label>
						<label for="symptom_other" class="btn btn-outline-info">
							<input id="symptom_other_chk" class="chkbox_symptoms" type="checkbox" name="symptom_other_chk">其他
						</label>
						<input name="symptom_other" type="text" class="form-control hide_atfirst" placeholder="請描述身體不適的症狀">
					</div>
				</div> -->
			</div>
		</div>
		<div class="card border-success">
			<div class="card-header text-white bg-success">本次接觸收穫</div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">接觸過程中，我是否有靈性方面的啟發/感受</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="gain_spiritual" value="0" required>很大</label>
						<label class="btn btn-outline-primary"><input type="radio" name="gain_spiritual" value="1" required>有一點</label>
						<label class="btn btn-outline-primary"><input type="radio" name="gain_spiritual" value="2" required>幾乎沒有</label>
						<label class="btn btn-outline-primary"><input type="radio" name="gain_spiritual" value="3" required>有損失/額外付出</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次接觸過程中，我的心情如何</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input name="mood_ego_0" type="radio" value="0" >非常好</label>
						<label class="btn btn-outline-primary"><input name="mood_ego_0" type="radio" value="1" >很好</label>
						<label class="btn btn-outline-primary"><input name="mood_ego_0" type="radio" value="2" >還好</label>
						<label class="btn btn-outline-primary"><input name="mood_ego_0" type="radio" value="3" >不好</label>
						<label class="btn btn-outline-primary"><input name="mood_ego_0" type="radio" value="4" >非常不好</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次的接觸是否讓我的心情變好或變壞</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input name="mood_ego_1" type="radio" value="0" >變好</label>
						<label class="btn btn-outline-primary"><input name="mood_ego_1" type="radio" value="1" >沒有改變</label>
						<label class="btn btn-outline-primary"><input name="mood_ego_1" type="radio" value="2" >變壞</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次接觸過程中，我覺得對方的心情如何</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input name="mood_alter_0" type="radio" value="0" >非常好</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_0" type="radio" value="1" >很好</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_0" type="radio" value="2" >還好</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_0" type="radio" value="3" >不好</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_0" type="radio" value="4" >非常不好</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_0" type="radio" value="5" >不知道</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次的接觸是否讓對方的心情變好或變壞</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input name="mood_alter_1" type="radio" value="0" >變好</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_1" type="radio" value="1" >沒有改變</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_1" type="radio" value="2" >變壞</label>
						<label class="btn btn-outline-primary"><input name="mood_alter_1" type="radio" value="3" >不知道</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-5 pl-0 pr-0">
						<span class="input-group-text text-left">接觸過程中，我是否有除了靈性、心情以外的具體收穫<br>(例如: 健康、資訊...等)</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input name="gain_instrumental" type="radio" value="0" >很大</label>
						<label class="btn btn-outline-primary"><input name="gain_instrumental" type="radio" value="1" >有一點</label>
						<label class="btn btn-outline-primary"><input name="gain_instrumental" type="radio" value="2" >幾乎沒有</label>
						<label class="btn btn-outline-primary"><input name="gain_instrumental" type="radio" value="3" >有額外損失/付出</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">這次接觸的時候你人在哪裡？</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input name="place" type="radio" value="0" >家裡</label>
						<label class="btn btn-outline-primary"><input name="place" type="radio" value="1" >宗教場所</label>
						<label class="btn btn-outline-primary"><input name="place" type="radio" value="2" >其他非宗教場所</label>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><span class="alter_name_fill"></span>認不認識下面這些人</div>
			<div class="card-body">
				<div id="alters_table"></div>
			</div>
		</div>
		<div align="center">
			<button id="back" 		class="btn btn-primary btn-lg">返回</button>
			<button id="FormSubmit" class="btn btn-primary btn-lg" type="submit">送出</button>
		</div>	
			</div>
		</form>
	</div>
	<footer class="footer">
  		<div>
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

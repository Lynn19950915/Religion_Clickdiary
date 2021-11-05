<?php
	session_start()	;
	include "db.php";
	CheckAccInfo();
	
	$ego_id   = $_SESSION['acc_info']['id'];
 	$alter_id = $_GET['alter_id'];

	if (isset($_POST['FetchGroupList'])) {
		$sql = "SELECT * FROM `group_list` WHERE id = :v1" ;
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $_SESSION['acc_info']['id']);
		$stmt->execute();
		$json = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

	if(isset($_POST['FetchCity'])){
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

	if(isset($_POST['FetchTown'])){
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

	if(isset($_POST['getalters'])){
		GetAlters();
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

	if (isset($_POST['FetchAlterProfile'])) {
		$sql = "SELECT * FROM `alter_list` WHERE ego_id = :v1 AND alter_id = :v2";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $alter_id);
		$stmt->execute();

		$json = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

	if(isset($_POST['FormSubmit'])) {
		$alter_name 	= $_POST['alter_name'];
		$alter_nickname = $_POST['alter_nickname'];
		$group_info 	= json_encode(array_filter($_POST['group_info']), 384);
		$relationship 	= json_encode($_POST['relationship']);
		$relationship_other = $_POST['relationship_other'];
		$seniority 		= $_POST['seniority'];
		$gender 		= $_POST['gender'];
		$age 			= $_POST['age'];
		$job 			= $_POST['job'];
		$edu 			= $_POST['edu'];
		$marriage 		= $_POST['marriage'];
		$city 			= $_POST['city'];
		$town 			= $_POST['town'];
		$res_other 		= $_POST['res_other'];
		$know_howlong 	= $_POST['know_howlong'];
		$meet_freq 		= $_POST['meet_freq'];
        $contact 		= $_POST['contact'];
		$is_rel_group 	= $_POST['is_rel_group'];
		$alter_tbl 		= empty($_POST['alter_tbl'])  ? null :$_POST['alter_tbl'];
		$now 			= date("Y-m-d H:i:s");

		$sql = "UPDATE
				    `alter_list`
				SET
				    `alter_name` 		= :v1,
				    `alter_nickname` 	= :v2,
				    `group_info` 		= :v3,
				    `relationship` 		= :v4,
				    `relationship_other`= :v5,
				    `seniority` 		= :v6,
				    `gender` 			= :v7,
				    `age` 				= :v8,
				    `job` 				= :v9,
				    `edu` 				= :v10,
				    `marriage` 			= :v11,
				    `city` 				= :v12,
				    `town` 				= :v13,
				    `res_other` 		= :v14,
				    `know_howlong` 		= :v15,
				    `meet_freq` 		= :v16,
                    `contact`           = :v21,
				    `is_rel_group` 		= :v17
				WHERE
				    ego_id = :v19
				AND 
					alter_id = :v20
				";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $alter_name);
		$stmt->bindParam(':v2', $alter_nickname);
		$stmt->bindParam(':v3', $group_info);
		$stmt->bindParam(':v4', $relationship);
		$stmt->bindParam(':v5', $relationship_other);
		$stmt->bindParam(':v6', $seniority);
		$stmt->bindParam(':v7', $gender);
		$stmt->bindParam(':v8', $age);
		$stmt->bindParam(':v9', $job);
		$stmt->bindParam(':v10', $edu);
		$stmt->bindParam(':v11', $marriage);
		$stmt->bindParam(':v12', $city);
		$stmt->bindParam(':v13', $town);
		$stmt->bindParam(':v14', $res_other);
		$stmt->bindParam(':v15', $know_howlong);
		$stmt->bindParam(':v16', $meet_freq);
        $stmt->bindParam(':v21', $contact);
		$stmt->bindParam(':v17', $is_rel_group);
		$stmt->bindParam(':v19', $ego_id);
		$stmt->bindParam(':v20', $alter_id);

		try {
			$stmt->execute();
			$date 		= date("Y-m-d");
			$arr  		= $alter_tbl;

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
			$rs_arr = 	array( 	'0' => "SubmitSuccess",
								'1' => $alter_id
						);
			echo json_encode($rs_arr);
		} catch (Exception $e) {
		    echo 'Caught exception: ',  $e -> getMessage(), "\n";
		}
		exit();
	}

?><!DOCTYPE html>
<html>
<head>
	<title>編輯接觸對象基本資料</title>
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
	<!-- Bootstrap Multiselect -->
	<script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
	<!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			new Promise((resolve, reject) => {
				LoadCityTownSelect();
				FetchGroupList();
				GetAlters();
				return resolve();
			}).then(function() {
				setTimeout(function() {
					FetchAlterProfile();
				}, 250);
			})
			

			$(".alter_name_fill").html("他/她");
			$("input[name='alter_name']").on("change", function(evt){
				if($(this).val() != ""){
					$(".alter_name_fill").empty().append($(this).val())	
				}
			});

			

			$("select[id='same_group']").on('change', function() {

				var tmp 		= $(this).val()
				var alter_name 	= $("input[name='alter_name']").val()

				if (_.includes(tmp, "0") && tmp.length > 1) {
					$.alert("回答錯誤")
					$(this).val('')
					$(this).multiselect('refresh')
					$("#group_list").empty()
				} else if (!_.includes(tmp, "0") && tmp.length > 0) {
					
					$("#group_list").empty().append(
						$("<div>").attr({'class': 'text-primary'}).html('若' + alter_name + '在群組中使用其他暱稱，請補充說明<br>若' + alter_name + '使用本名，保留空白即可')
					)

					_.map(tmp, function(obj) {
						$("<div>").attr({'class': 'col-sm-12 pl-0 pr-0'}).append(
							$("<input>").attr({'type': 'text','class': 'form-control group_alter_name', 'placeholder': alter_name + '在' + obj + '使用的暱稱為?', 'name': 'group_alter_name'})
						).appendTo(
							$("#group_list")
						)
					})
				} else {
					$("#group_list").empty()
				}
			});
			
			$("#form").on('submit', function(evt) {
				evt.preventDefault();

				var alter_name		= $("input[name='alter_name']").val();
				// var alter_nickname	= $("input[name='alter_nickname']").val();
				var alter_nickname	= "";

				var group_info = {
					same_group: [],
					group_alter_name: []
				}
				group_info.same_group = $("select[id='same_group']").val(); 

				$("input[name='group_alter_name']").each(function() {
					console.log($(this).val())
					group_info.group_alter_name.push($(this).val())
				})

			    var relationship 		= $("select[id='relationship']").val(); 
				var relationship_other 	= $("input[name='relationship_other']").val(); 
			    var seniority 	= $("input[name='seniority']:checked").val(); 
			    var gender 		= $("input[name='gender']:checked").val(); 
			    var age 		= $("select[id='age']").val(); 
				var job			= $("select[id='job']").val(); 
				var edu 		= $("select[id='edu']").val(); 
				var marriage 	= $("input[name='marriage']:checked").val();
				var city 		= $("select[id='citySelect']").val();
				var town 		= $("select[id='townSelect']").val();
				var res_other 	= $("input[name='res_other']").val();
	    		var know_howlong = $("select[id='know_howlong']").val();
	    		var meet_freq 	= $("input[name='meet_freq']:checked").val();
                var contact 	= $("input[name='contact']:checked").val();
	    		var is_rel_group = $("input[name='is_rel_group']:checked").val();

		    	var alter_tbl = { altersid: [], familiar:[] };
	    		$("input[class='familiars']:checked").each(function(){
					alter_tbl.altersid.push($(this).attr('name'))
					alter_tbl.familiar.push($(this).val())
				})

	    		console.log(
	    			alter_name, alter_nickname, group_info,
	    			relationship, relationship_other, seniority,
	    			gender, age, job, edu, marriage, city, town, res_other,
	    			know_howlong, meet_freq, contact, is_rel_group, alter_tbl
	    		)

	    		if (!alter_name) {
	    			$.alert("請輸入接觸對象的真實姓名")
	    			return false;
	    		} else if (group_info.same_group.length == 0) {
	    			$.alert("他/她是否也在我參與的群組中？")
	    			return false;
	    		} else if (relationship.length == 0) {
	    			$.alert("請選擇關係類別")
	    			return false;
	    		} else if (!seniority) {
	    			$.alert("請選擇輩分高低")
	    			return false;
	    		} else if (!gender) {
	    			$.alert("請選擇性別")
	    			return false;
	    		} else if (!age) {
	    			$.alert("請選擇年齡")
	    			return false;
	    		} else if (!job) {
	    			$.alert("目前是否有工作")
	    			return false;
	    		} else if (!edu) {
	    			$.alert("請選擇教育程度")
	    			return false;
	    		} else if (!marriage) {
	    			$.alert("請選擇婚姻狀況")
	    			return false;
	    		} else if (!know_howlong) {
	    			$.alert("認識多久")
	    			return false;
	    		} else if (!meet_freq) {
	    			$.alert("是否常碰面(面對面接觸)")
	    			return false;
	    		} else if (!contact) {
	    			$.alert("喜不喜歡和他接觸")
	    			return false;
	    		} else if (!is_rel_group) {
	    			$.alert("他/她屬於我宗教生活圈中的朋友嗎")
	    			return false;
	    		} else if (!city) {
	    			$.alert("請選擇居住地區(縣市)")
	    			return false;
	    		} else if (city && city != "國外" && city != "不知道" && !town) {
	    			$.alert("請選擇居住地區(鄉鎮市區)")
	    			return false;
	    		}

	    		$.ajax({ 
					type: "POST",
					url: '',
					dataType: "json",
					data: {
						FormSubmit: 1,
						alter_name: alter_name,
						alter_nickname: alter_nickname,
						group_info: group_info,
						relationship: relationship,
						relationship_other: relationship_other,
						seniority: seniority,
						gender: gender,
						age: age,
						job: job,
						edu: edu,
						marriage: marriage,
						city: city,
						town: town,
						res_other: res_other,
						know_howlong: know_howlong,
						meet_freq: meet_freq,
                        contact: contact,
						is_rel_group: is_rel_group,
						alter_tbl: alter_tbl
					},beforeSend: function() { 
						//$("#loadingtext").show();
						$("#FormSubmit").prop('disabled', true);
					},complete : function (){
						//$("#loadingtext").hide();
						$("#FormSubmit").prop('disabled', false);
					},success: function(data){
						console.log(data)
						if (data[0] == "SubmitSuccess") {
							$.confirm({
								title: '',
							    content: '接觸對象資料修改完成！<br>接著填寫接觸日記嗎？',
							    buttons: {
							    	'稍後再填': function() {
							    		window.location.href = 'http://cdiary3.tw/alter_list.php';
							        },
							        '好': function() {
							        	window.location.href = 'http://cdiary3.tw/tdiary.php?alter_id=' + data[1];
							        }
							    }
							});
						}
					},error: function(e){
						console.log(e)
						// $.alert("此接觸對象已存在，請確認名單<br>若問題持續發生請聯繫我們<br>***@stat.sinica.edu.tw")
						$.alert("錯誤，請確認是否有題目漏填<br>若問題持續發生請聯繫我們<br>***@stat.sinica.edu.tw")
					}
				})
			});
	
			$("#back").on('click', function(evt) {
				window.location.href = 'http://cdiary3.tw/alter_list.php';
			});
		})

		function FetchGroupList() {
			$.ajax({ 
				type: "POST",
				url: '',
				dataType: "json",
				data: {
					FetchGroupList: 1
				},success: function(data){
					// console.log("MyGroupList", data)
					$("select[id='same_group']").append(
						$("<option>").html("他/她未參與相同群組").attr({'value': '0'})
					)
					
					_.map(data, function(obj) {
						// console.log(obj)
						$("select[id='same_group']").append(
							$("<option>").html(obj.group_name).attr({'value': obj.group_name})
						)
					})

					$('.multiselect').multiselect({
						buttonWidth: '100%',
						buttonClass: 'form-control',
						nonSelectedText: '請選擇',
						maxHeight: 200,
						templates: {
					 		ul: '<ul class="multiselect-container dropdown-menu text-center" style="width: 100%;"></ul>',
					        li: '<li><a href="javascript:void(0);"><label style="width: 100%;"></label></a></li>'
					    }
					});
				},error: function(e){
					console.log(e)
				}
			})
		}

		function LoadCityTownSelect() {
			var CitySelect;
			var TownSelect;
			
			CitySelect 		= 	$("<select>").attr({ 'id': 'citySelect', 'class':'form-control'}).on('change', function(){ update3();	})
			TownSelect 		= 	$("<select>").attr({ 'id': 'townSelect', 'class':'form-control'})
			Res_other_Input = 	$("<input>").attr({
									'type': 'text',
									'name': 'res_other', 
									'class': 'form-control', 
									'placeholder': '請填寫居住地區'
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
						
						$(CitySelect).empty();	
						$(CitySelect).append(
							$("<option>").html('請選擇').attr('value','')
						);		
						
						for(var key in data){
							$(CitySelect).append(
								$("<option />").html(data[key].City).attr('value', data[key].City)
							)
						}
						
						$(CitySelect).append(
							$("<option />").html('國外').attr('value', '國外')
						).append(
							$("<option />").html('不知道').attr('value', '不知道')
						)
						
						update3()
					}
				});	
			}
	    
			function update3(){
				city = $("select[id='citySelect']").val()
				$(TownSelect).empty();

				if (city == "國外") {
					$(TownSelect).empty().hide();
					$("input[name='res_other']").show()
				} else if (city == "不知道") {
					$(TownSelect).empty().hide();
					$("input[name='res_other']").val('').hide()
				} else {
					$("input[name='res_other']").val('').hide()
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
							$(TownSelect).empty().append(
								$("<option>").html('請選擇').attr('value','')
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

		function GetAlters(){
			$.ajax({ 
				type: "POST",
				dataType: "json", 
				url: '',
				data: {
					getalters: 1
				},success: function(data){
					console.log(data);
					LoadAltersTbl(data);

					$(jQuery).on('click', "button[id='get5more']", function(evt){
						evt.preventDefault();
						// 1.檢查目前5位已點選熟悉程度
						// 表中有幾位alter
						var k_currentAlters = $(".altersname").length
						var k_checkedAlters = $("input[class='familiars']:checked").length
						console.log(k_currentAlters, k_checkedAlters)

						if(k_currentAlters != k_checkedAlters){
							alert("請先確認目前對象的熟悉程度");
							return false;
						}else{
							// 2.另抽5位，已確認的5位自畫面隱藏
							$(".table").hide();
							alters_remain = Get5moreAlters(data);
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
				falters = _.sampleSize(falters, 5);
				var alters = falters;
				var rows   = falters.length;
				var cols   = 5;
				var table  = $('<table>').attr({'class':'table'}).append($('<tbody>'));
				var alter_name = $("#altername").val();

				table.append(
					$('<tr>').append(
						$('<td>').append(
							$('<span>').attr({'class':'alter_name_fill'}).html(alter_name)
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
					var colsm8div	= $('<div>').attr({class:'col-sm-8 table-col-sm-8'});
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
						 ).append( 
						 	$('<label>').html('不清楚').attr({class:'btn btn-outline-primary btn-familiar'}).prepend(
						 		$('<input>').attr({
						 			type: 'radio',
						 			name: alters[r].alter_id,
						 			value: 3,
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


		function FetchAlterProfile() {
			$.ajax({ 
				type: "POST",
				dataType: "json", 
				url: '',
				data: {
					FetchAlterProfile: 1
				},success: function(data){
					// console.log(data);
					var alter_prof = data[0]
					console.log(alter_prof);
					$("input[name='alter_name']").val(alter_prof.alter_name)
					// $("input[name='alter_nickname']").val(alter_prof.alter_nickname)
					// console.log()
					var group_info = JSON.parse(alter_prof.group_info)
					// console.log(group_info)
					if (_.includes(group_info.same_group, "0")) {
						// console.log("nsame")
						$("select[id='same_group']").val("0")
						$("select[id='same_group']").multiselect('refresh')
					} else {
						// console.log("same")
						$("#group_list").empty().append(
							$("<div>").attr({'class': 'text-primary'}).html('若' + alter_prof.alter_name + '在群組中使用其他暱稱，請補充說明<br>若' + alter_prof.alter_name + '使用本名，保留空白即可')
						)
						_.map(group_info.same_group, function(obj) {
							// console.log(obj)
							
							$('option[value="' + obj + '"]', $("select[id='same_group']")).prop('selected', true);
				            $("select[id='same_group']").multiselect('refresh')

				            $("<div>").attr({'class': 'col-sm-12 pl-0 pr-0'}).append(
								$("<input>").attr({
									'type': 'text',
									'class': 'form-control group_alter_name', 
									'placeholder': alter_prof.alter_name + '在' + obj + '使用的暱稱為?', 
									'name': 'group_alter_name',
								})
							).appendTo(
								$("#group_list")
							)
						})
						
						_.map(group_info.group_alter_name, function(obj, key) {
							// console.log(obj, key)
							$("input[name='group_alter_name']").eq(key).val(obj)
						})	
					}

					console.log()
					_.map(JSON.parse(alter_prof.relationship), function (obj) {
						$('option[value=' + obj + ']', $("select[id='relationship']")).prop('selected', true);
			            $("select[id='relationship']").multiselect('refresh')
					})
					$("input[name='relationship_other']").val(alter_prof.relationship_other)
					$("input[name='seniority'][value='" + alter_prof.seniority + "']").attr({'checked': true}).parent().addClass('active')
					$("input[name='gender'][value='" + alter_prof.gender + "']").attr({'checked': true}).parent().addClass('active')
					$("select[id='age']").val(alter_prof.age)
					$("select[id='job']").val(alter_prof.job)
					$("select[id='edu']").val(alter_prof.edu)
					$("input[name='marriage'][value='" + alter_prof.marriage + "']").attr({'checked': true}).parent().addClass('active')
					$("select[id='citySelect']").val(alter_prof.city)
					FillTownSelect(alter_prof);	
					$("select[id='know_howlong']").val(alter_prof.know_howlong)
					$("input[name='meet_freq'][value='" + alter_prof.meet_freq + "']").attr({'checked': true}).parent().addClass('active')
                    $("input[name='contact'][value='" + alter_prof.contact + "']").attr({'checked': true}).parent().addClass('active')
					$("input[name='is_rel_group'][value='" + alter_prof.is_rel_group + "']").attr({'checked': true}).parent().addClass('active')
					
				}
			})

			function FillTownSelect(fdata) {
				var city 			= fdata.city;
				var TownSelect 		= $("select[id='townSelect']");

				$(TownSelect).empty();
				
				if (city == "國外") {
					$(TownSelect).empty().hide();
					$("input[name='res_other']").show().val(fdata.res_other)
				} else if (city == "不知道") {
					$(TownSelect).empty().hide();
					$("input[name='res_other']").val('').hide()
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
								$("<option>").html('請選擇').attr('value','')
							);
							
							for(var key in data){
								$(TownSelect).append(
									$("<option />").html(data[key].District).attr('value',data[key].District)
								);
							}

							// $("select[id='townSelect']").val(fdata.town)
							$(TownSelect).val(fdata.town)
						}
					});	
				}
				
			}
		}
	</script>
	<style type="text/css">
		/* ------------------------------ Navbar & Footer  ----------------------------------- */
		html {
			position: relative;
			min-height: 100%;
		}

		body {
			padding-top: 70px;  /* Avoid nav bar overlap web content */
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
			
		/* Customized */
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

		#citySelect,#townSelect{
			width: 50%;	
		}

		.btn-lg {
			width: 35%;
			margin: auto 1em;
		}

		ul::-webkit-scrollbar {
		    -webkit-appearance: none;
		}

		ul::-webkit-scrollbar:vertical {
		    width: 12px;
		}

		ul::-webkit-scrollbar:horizontal {
		    height: 12px;
		}

		ul::-webkit-scrollbar-thumb {
		    background-color: rgba(0, 0, 0, .5);
		    border-radius: 10px;
		    border: 2px solid #ffffff;
		}

		ul::-webkit-scrollbar-track {
		    border-radius: 10px;  
		    background-color: #ffffff; 
		}


		/* --------------------------- */
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
		
		@media screen and (max-width: 550px) { 
			.container {
				padding: 0.25rem;
			}

			.card-body {
				padding: 0.75rem 0.5rem;
			}

			#group_list>.input-group>.col-sm-3 {
				width: 35%;
			}

			#group_list>.input-group>.col-sm-9 {
				width: 60%;
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
	<form id="form" class="form-horizontal">
		<div class="card card-primary">
			<div class="card-header">編輯接觸對象基本資料</div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text" >接觸對象姓名/暱稱</span>
				  	</div>
				  	<div class="col-sm-8 pl-0 pr-0">
						<input type="text" class="form-control" name="alter_name" placeholder="建議填寫在LINE中的名稱或您未來繼續填寫時能辨識的暱稱" required>
					</div>
					<!-- <div class="col-sm-4 pl-0 pr-0">
						<input type="text" class="form-control" name="alter_nickname" placeholder="可輸入接觸對象的其他暱稱">
					</div> -->
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>是否也在我參與的宗教群組中</span>
				  	</div>
				  	<div class="col-sm-8 pl-0 pr-0">
				  		<select id="same_group" class="multiselect" multiple="multiple" required></select>
				  	</div>
					<div id="group_list" class="input-group"></div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text">關係類別</span>
				  	</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="relationship" class="multiselect" multiple="multiple" required>
							<option value="0">家人</option>
							<option value="1">親戚</option>
							<option value="2">同學</option>
							<option value="3">同事</option>
							<option value="4">好友</option>
							<option value="5">一般朋友</option>
							<option value="6">鄰居</option>
							<option value="7">宗教團體</option>
							<option value="8">非宗教社團</option>
							<option value="9">網友(主要僅在網路中互動)</option>
							<option value="10">間接關係</option>
							<option value="11">其他</option>
						</select>
					</div>
					<div class="col-sm-12 pl-0 pr-0">
						<input type="text" class="form-control" name="relationship_other" placeholder="可補充描述關係類別">
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>的輩分比我高或低</span>
				  	</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="seniority" value="0" required>輩分比我高</label>
						<label class="btn btn-outline-primary"><input type="radio" name="seniority" value="1" required>平輩</label>
						<label class="btn btn-outline-primary"><input type="radio" name="seniority" value="2" required>輩分比我低</label>
						<label class="btn btn-outline-primary"><input type="radio" name="seniority" value="3" required>無法辨別</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>的性別</span>
				  	</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="gender" value="1" required>男性</label>
						<label class="btn btn-outline-primary"><input type="radio" name="gender" value="0" required>女性</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>的年齡</span>
				  	</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="age" class="form-control" required >
							<option value="" >請選擇</option>
							<option value="0" >1-10歲</option>
							<option value="1" >11-20歲</option>
							<option value="2" >21-30歲</option>
							<option value="3" >31-40歲</option>
							<option value="4" >41-50歲</option>
							<option value="5" >51-60歲</option>
							<option value="6" >61-70歲</option>
							<option value="7" >71-80歲</option>
							<option value="8" >81-90歲</option>
							<option value="9" >90歲以上</option>
							<option value="10" >不知道</option>
						</select>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>目前是否有工作</span>
				  	</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="job" class="form-control" required>
							<option value="" >請選擇</option>
							<option value="0" >目前沒有工作(待業中)</option>
							<option value="1" >目前沒有工作(無工作意願)</option>
							<option value="2" >有工作</option>
							<option value="3" >學生</option>
							<option value="4" >家庭主婦</option>
							<option value="5" >目前沒有工作(已退休)</option>
							<option value="6" >不知道</option>
						</select>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>的教育程度</span>
				  	</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="edu" class="form-control" required>
				  			<option value="" >請選擇</option>
							<option value="0" >小學或以下</option>
							<option value="1" >國中/初中</option>
							<option value="2" >高中/職</option>
							<option value="3" >專科</option>
							<option value="4" >大學</option>
							<option value="5" >碩士</option>
							<option value="6" >博士</option>
							<option value="7" >不知道</option>
						</select>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>的婚姻狀況</span>
				  	</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="marriage" value="0">未婚</label>
						<label class="btn btn-outline-primary"><input type="radio" name="marriage" value="1">已婚</label>
						<label class="btn btn-outline-primary"><input type="radio" name="marriage" value="2">其他</label>
						<label class="btn btn-outline-primary"><input type="radio" name="marriage" value="3">不知道</label>
					</div>
				</div>		
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>的居住地區</span>
				  	</div>
					<div id="residence" class="col-sm-8 pl-0 pr-0 d-inline-flex"></div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text">和<span class="alter_name_fill"></span>認識多久</span>
				  	</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="know_howlong" class="form-control" required >
							<option value="" >請選擇</option>
							<option value="1" >不到3個月</option>
							<option value="2" >不到1年</option>
							<option value="3" >1-4年多</option>
							<option value="4" >5-19年多</option>
							<option value="5" >20年以上</option>
							<option value="0" >原先不認識</option>
						</select>
					</div>
				</div>	
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text">和<span class="alter_name_fill"></span>是否常碰面(面對面接觸)</span>
				  	</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="meet_freq" value="0">很常</label>
						<label class="btn btn-outline-primary"><input type="radio" name="meet_freq" value="1">偶爾</label>
						<label class="btn btn-outline-primary"><input type="radio" name="meet_freq" value="2">從未</label>
					</div>
				</div>
                <div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text">喜不喜歡和<span class="alter_name_fill"></span>接觸</span>
				  	</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="contact" value="0">非常喜歡</label>
						<label class="btn btn-outline-primary"><input type="radio" name="contact" value="1">喜歡</label>
						<label class="btn btn-outline-primary"><input type="radio" name="contact" value="2">還好</label>
                        <label class="btn btn-outline-primary"><input type="radio" name="contact" value="3">不喜歡</label>
						<label class="btn btn-outline-primary"><input type="radio" name="contact" value="4">非常不喜歡</label>
					</div>
				</div>
                
                
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
				    	<span class="input-group-text"><span class="alter_name_fill"></span>屬於我宗教生活圈中的人嗎</span>
				  	</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="is_rel_group" value="1">是</label>
						<label class="btn btn-outline-primary"><input type="radio" name="is_rel_group" value="0">否</label>
					</div>
				</div>		
			</div>		
		</div>
		<div class="card">
		  <div class="card-header"><span class="alter_name_fill"></span>認不認識下面這些人</div>
		  <div class="card-body">
			<div id="alters_table"></div>
		  </div>
		</div>
		<div align="center">
			<input id="back" type="button" class="btn btn-primary btn-lg"  value="返回">
			<input id="FormSubmit" type="submit" class="btn btn-primary btn-lg" value="送出">
		</div>
	</form>
		<div id="invite"></div>
	</div>
	<footer class="footer">
  		<div class="">
  			<img id="footerimg" src="./pic/Academia_Sinica_Emblem.png" >
		    <div class="text">
			著作權©中研院統計科學研究所. 版權所有.<br>
		    Copyright© Institute of Statistical Science, Academia Sinica.
		    All rights reserved.
		    </div>
		</div>
	</footer>
</body>
</html>
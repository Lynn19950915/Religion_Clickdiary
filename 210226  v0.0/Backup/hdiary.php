<?php
	session_start();
	include("db.php"); 
	CheckAccInfo();
	
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

	if (isset($_POST['FormSubmit'])) {
		$id = $_SESSION['acc_info']['id'];
		$rel_event_atm = $_POST['rel_event_atm'];

		$date 	= $_POST['date'];
		$mood 	= $_POST['mood'];
		$symptom 			= $_POST['symptom'];
		$symptom_sick 		= $_POST['symptom_sick'];
		$symptom_fever 		= $_POST['symptom_fever']; 
		$symptom_cough 		= $_POST['symptom_cough']; 
		$symptom_sorethroat = $_POST['symptom_sorethroat'];
		$symptom_hospital 	= $_POST['symptom_hospital']; 	
		$symptom_other 		= $_POST['symptom_other']; 	
		$touchpeople 		= $_POST['touchpeople'];

		$group_view 		= empty($_POST['group_view'])  ? null :json_encode(array_filter($_POST['group_view']), 384);
		$group_post 		= empty($_POST['group_post'])  ? null :json_encode(array_filter($_POST['group_post']), 384);
		$group_view_other 	= empty($_POST['group_view_other'])  ? null :$_POST['group_view_other'];
		$group_post_other 	= empty($_POST['group_post_other'])  ? null :$_POST['group_post_other'];
		$group_post_info 	= json_encode(array_filter($_POST['group_post_info']), 384);

		$rel_event 				= $_POST['rel_event'];
		$rel_event_name 		= $_POST['rel_event_name'];
		$rel_event_time 		= $_POST['rel_event_time'];
		$rel_event_population 	= $_POST['rel_event_population'];
		$rel_event_pos 			= empty($_POST['rel_event_pos'])  ? null : $_POST['rel_event_pos'];
		$rel_event_pos_other 	= $_POST['rel_event_pos_other'];
		$rel_event_neg 			= empty($_POST['rel_event_neg'])  ? null : $_POST['rel_event_neg'];
		$rel_event_neg_other 	= $_POST['rel_event_neg_other'];
		$rel_event_atm 			= empty($_POST['rel_event_atm'])  ? null : $_POST['rel_event_atm'];
		$gain_spiritual 		= empty($_POST['gain_spiritual']) ? null : $_POST['gain_spiritual'];
		$mood_0 				= empty($_POST['mood_0']) ? null : $_POST['mood_0'];
		$mood_1 				= empty($_POST['mood_1']) ? null : $_POST['mood_1'];
		$gain_instrumental 		= empty($_POST['gain_instrumental']) ? null : $_POST['gain_instrumental'];
		$dynamic_response       = NULL;
		$index_duplicate    	= $id."_".$date;
		$now 					= date("Y-m-d H:i:s");

		$sql = "INSERT INTO
				    `hdiary`(
				        `id`,
				        `date`,
				        `mood`,
				        `symptom`,
				        `symptom_sick`,
				        `symptom_fever`,
				        `symptom_cough`,
				        `symptom_sorethroat`,
				        `symptom_hospital`,
				        `symptom_other`,
				        `touchpeople`,
				        `group_view`,
				        `group_post`,
				        `group_post_info`,
				        `rel_event`,
						`rel_event_name`,
						`rel_event_time`,
						`rel_event_population`,
				        `rel_event_pos`,
				        `rel_event_pos_other`,
				        `rel_event_neg`,
				        `rel_event_neg_other`,
				        `rel_event_atm`,
				        `gain_spiritual`,
				        `mood_0`,
				        `mood_1`,
				        `gain_instrumental`,
				        `dynamic_response`,
				        `index_duplicate`,
				        `create_time`
				    )
				VALUES(
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
					:v30
				)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $_SESSION['acc_info']['id']);
		$stmt->bindParam(':v2', $date);
		$stmt->bindParam(':v3', $mood);
		$stmt->bindParam(':v4', $symptom);
		$stmt->bindParam(':v5', $symptom_sick);
		$stmt->bindParam(':v6', $symptom_fever);
		$stmt->bindParam(':v7', $symptom_cough);
		$stmt->bindParam(':v8', $symptom_sorethroat);
		$stmt->bindParam(':v9', $symptom_hospital);
		$stmt->bindParam(':v10', $symptom_other);
		$stmt->bindParam(':v11', $touchpeople);
		$stmt->bindParam(':v12', $group_view);
		$stmt->bindParam(':v13', $group_post);
		$stmt->bindParam(':v14', $group_post_info);
		$stmt->bindParam(':v15', $rel_event);
		$stmt->bindParam(':v16', $rel_event_name);
		$stmt->bindParam(':v17', $rel_event_time);
		$stmt->bindParam(':v18', $rel_event_population);
		$stmt->bindParam(':v19', $rel_event_pos);
		$stmt->bindParam(':v20', $rel_event_pos_other);
		$stmt->bindParam(':v21', $rel_event_neg);
		$stmt->bindParam(':v22', $rel_event_neg_other);
		$stmt->bindParam(':v23', $rel_event_atm);
		$stmt->bindParam(':v24', $gain_spiritual);
		$stmt->bindParam(':v25', $mood_0);
		$stmt->bindParam(':v26', $mood_1);
		$stmt->bindParam(':v27', $gain_instrumental);
		$stmt->bindParam(':v28', $dynamic_response);
		$stmt->bindParam(':v29', $index_duplicate);
		$stmt->bindParam(':v30', $now);

		try {
			$stmt->execute();
			if (!empty($group_view_other)) {
				$sql = "INSERT INTO `group_list`
							(`id`, `group_name`, `myname`, `check_freq`, `is_religious`, `n_invitees`, `create_time`) 
						VALUES (:v1, :v2, '', 999, 999, 999, NOW())";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':v1', $id);
				$stmt->bindParam(':v2', $group_view_other);
				$stmt->execute();
			}

			if (!empty($group_post_other) && ($group_view_other != $group_post_other)) {
				$sql = "INSERT INTO `group_list`
							(`id`, `group_name`, `myname`, `check_freq`, `is_religious`, `n_invitees`, `create_time`) 
						VALUES (:v1, :v2, '', 999, 999, 999, NOW())";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':v1', $id);
				$stmt->bindParam(':v2', $group_post_other);
				$stmt->execute();
			}

			echo "SubmitSuccess";
		} catch (Exception $e) {
		    echo 'Caught exception: ',  $e -> getMessage(), "\n";
		}
		exit();
	}
?><!doctype html>
<html lang="zh-tw">
<head>
	<title>?????????3.0 - ????????????</title>
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
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->
	<!-- Bootstrap Multiselect -->
	<script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
	<!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
	<script type="text/javascript">	
		$(document).ready(function(){

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
				if (d.getHours() >= 18) {
					$("#date").append(
						$("<option>").html("?????????").attr({'value': ''})
					).append(
						$("<option>").html(date_yd + " (??????)").attr({'value': date_yd})
					).append(
						$("<option>").html(date_td + " (??????)").attr({'value': date_td})
					)
				} else {
					$("#date").append(
						$("<option>").html(date_yd + " (??????)").attr({'value': date_yd})
					)
					$(".change_bydate").empty().html(date_yd.substring(5))
				}
			})(new Date);
			
			MovementControl();
			FetchGroupList();

			$("#FormSubmit").on('click', function(evt) {
				evt.preventDefault();

				var date 				= $("select[id='date']").val()
				var mood 				= $("input[name='mood']:checked").val()
				var symptom 			= $("input[name='symptom']:checked").val()
				var symptom_sick 		= $("input[name='sick']").is(":checked") ?1 :0 ;
				var symptom_fever 		= $("input[name='fever']").is(":checked") ?1 :0 ;
				var symptom_cough 		= $("input[name='cough']").is(":checked") ?1 :0 ;
				var symptom_sorethroat 	= $("input[name='sorethroat']").is(":checked") ?1 :0 ;
				var symptom_hospital 	= $("input[name='hospital']").is(":checked") ?1 :0 ;
				var symptom_other_chk 	= $("input[name='symptom_other_chk']").is(":checked") ?1 :0 ;
				var symptom_other 		= $("input[name='symptom_other']").val()
				var symptom_sum 		= symptom_sick + symptom_fever + symptom_cough + symptom_sorethroat + symptom_hospital + symptom_other_chk;
				var touchpeople 		= $("input[name='touchpeople']:checked").val()

				var group_view = $("select[id='group_view']").val() || "";
				var group_post = $("select[id='group_post']").val() || "";

				var group_view_other = $("input[name='group_view_other']").val();
				var group_post_other = $("input[name='group_post_other']").val();

				var group_post_info = {
					att_reason: [],
					know_writer: [],
					writer: [],
				}

				$("select[name='group_post_att_reason']").each(function() {
					group_post_info.att_reason.push($(this).val())
				})

				$("input[class='group_post_know_writer'][value='1']").each(function() {
					var tmp = $(this).is(":checked") ?1 :0;
					group_post_info.know_writer.push(tmp)
				})

				$("input[name='group_post_writer']").each(function(){
					group_post_info.writer.push($(this).val())
				})

				var rel_event 			= $("input[name='rel_event']:checked").val()
				var rel_event_name 		= $("input[name='rel_event_name']").val()
				var rel_event_time 		= $("input[name='rel_event_time']").val()
				var rel_event_population= $("input[name='rel_event_population']").val()				
				var rel_event_pos 		= $("select[id='rel_event_pos']").val()
				var rel_event_pos_other = $("input[name='rel_event_pos_other']").val()
				var rel_event_neg 		= $("select[id='rel_event_neg']").val()
				var rel_event_neg_other = $("input[name='rel_event_neg_other']").val()
				var rel_event_atm 		= $("input[name='rel_event_atm']:checked").val()  || "";
				var gain_spiritual 		= $("input[name='gain_spiritual']:checked").val() || "";
				var mood_0 				= $("input[name='mood_0']:checked").val() || "";
				var mood_1 				= $("input[name='mood_1']:checked").val() || "";
				var gain_instrumental 	= $("input[name='gain_instrumental']:checked").val() || "";

				/*
				console.log(
					date,
					mood,
					symptom,
					symptom_sick,
					symptom_fever, 
					symptom_cough , 
					symptom_sorethroat,
					symptom_hospital, 	
					symptom_other_chk, 
					symptom_other, 	
					touchpeople
				)

				console.log(
					group_view,
					group_post,
					group_post_info
				)

				console.log(
					 rel_event,
					 rel_event_pos,
					 rel_event_pos_other,
					 rel_event_neg,
					 rel_event_neg_other,
					 rel_event_atm,
					 gain_spiritual,
					 mood_0,
					 mood_1,
					 gain_instrumental
				)
				*/

				if (!date) {
					$.alert("?????????????????????????????????")
					return false;
				} else if (!mood) {
					$.alert("?????????????????????")
					return false;
				} else if (!symptom) {
					$.alert("???????????????????????????")
					return false;
				} else if (symptom == 1 && symptom_sum == 0) {
					$.alert("???????????????(?????????)")
					return false;
				} else if (!touchpeople) {
					$.alert("????????????????????????")
					return false;
				} else if (!rel_event) {
					$.alert("??????????????????????????????????????????")
					return false;
				} else if (rel_event == 1) {
					if (!rel_event_name) {
						$.alert("????????????????????????")
						return false;
					} else if (!rel_event_time) {
						$.alert("????????????????????????")
						return false;
					} else if (!rel_event_population) {
						$.alert("????????????????????????")
						return false;
					} else if (!rel_event_pos) {
						$.alert("??????????????????????????????????????????/?????????")
						return false;
					} else if (!rel_event_neg) {
						$.alert("???????????????????????????????????????????????????/?????????")
						return false;
					} else if (!rel_event_atm) {
						$.alert("?????????????????????????????????????????????")
						return false;
					} else if (!gain_spiritual) {
						$.alert("?????????????????????????????????????????????/?????????")
						return false;
					} else if (!mood_0) {
						$.alert("??????????????????????????????")
						return false;
					} else if (!mood_1) {
						$.alert("??????????????????????????????")
						return false;
					} else if (!gain_instrumental) {
						$.alert("????????????????????????????????????????????????????????????")
						return false;
					}
				}
				
				$.ajax({ 
					type: "POST",
					url: '',
					data: {
						FormSubmit: 1,
						date: date,
						mood: mood,
						symptom: symptom,
						symptom_sick: symptom_sick,
						symptom_fever: symptom_fever, 
						symptom_cough: symptom_cough, 
						symptom_sorethroat: symptom_sorethroat,
						symptom_hospital: symptom_hospital, 	
						symptom_other: symptom_other, 	
						touchpeople: touchpeople,
						group_view: group_view,
						group_post: group_post,
						group_view_other: group_view_other,
						group_post_other: group_post_other,
						group_post_info: group_post_info,
						rel_event: rel_event,
						rel_event_name: rel_event_name,
						rel_event_time: rel_event_time,
						rel_event_population: rel_event_population,
						rel_event_pos: rel_event_pos,
						rel_event_pos_other: rel_event_pos_other,
						rel_event_neg: rel_event_neg,
						rel_event_neg_other: rel_event_neg_other,
						rel_event_atm: rel_event_atm,
						gain_spiritual: gain_spiritual,
						mood_0: mood_0,
						mood_1: mood_1,
						gain_instrumental: gain_instrumental
					},beforeSend: function() { 
						//$("#loadingtext").show();
						$("#FormSubmit").prop('disabled', true);
					},complete : function (){
						//$("#loadingtext").hide();
						$("#FormSubmit").prop('disabled', false);
					},success: function(data){
						console.log(data)
						if (data == "SubmitSuccess") {
							$.confirm({
								title: '',
							    content: '??????????????????????????????????????????<br> ??????"??????"???????????????',
							    buttons: {
							    	// '????????????': function() {
							     //    	window.location.href = 'http://cdiary3.tw/main.php';
							     //    },
							        '??????': function() {
							        	window.location.href = 'http://cdiary3.tw/alter_list.php';
							        }
							    }
							});
						} else {
							$.alert("????????????????????????????????????<br>??????????????????")	
						}
					},error: function(e){
						console.log(e)
						$.alert("???????????????????????????????????????<br>???????????????????????????????????????<br>????????????????????????????????????<br>***@stat.sinica.edu.tw")
					}
				}) 
			});
			
		})

		function MovementControl() {
			$("#date").on('change', function(){
				if ($(this).val()) {
					var tmp = $(this).val().substring(5)
					$(".change_bydate").empty().html(tmp)
				} else {
					$(".change_bydate").empty()
				}
			})

			$("input[name='symptom']").on('change', function(){
				var tmp = $(this).val()

				if (tmp == 1) {
					$("#div_symptom").show()
				} else {
					$(".chkbox_symptoms").attr({'checked': false}).parent().removeClass('active')
					$("input[name='symptom_other']").val('')
					$("#div_symptom").hide()
				}
			})

			$(jQuery).on('change', "input[type='checkbox']", function(e) {
				var tmp 	= $(this).is(':checked') ?1 :0 ;
				var target 	= $(this).parent()
				
				if (tmp == 0) {
					$(target).attr({'style': 'color: inherit; background-color: transparent;'})
				} else {
					$(target).attr({'style': 'color: #fff; background-color: #17a2b8;'})
					    
				}
			});
			

			$(jQuery).on('change', "input[name='symptom_other_chk']", function() {

				var tmp = $(this).is(':checked') ?1 :0 ;
				// console.log(tmp)
				if (tmp == 1) {
					$("input[name='symptom_other']").show()
				} else {
					$("input[name='symptom_other']").val('')
					$("input[name='symptom_other']").hide()
				}
			})
			
			$(jQuery).on('change', "select[id='group_view']", function() {
				var tmp = $(this).val()
				console.log(tmp)
				if (_.includes(tmp, '??????????????????????????????')) {
					$("#div_group_view_other").removeClass('hide_atfirst')
				} else {
					$("input[name='group_view_other']").val('')
					$("#div_group_view_other").addClass('hide_atfirst')
				}
			})

			$(jQuery).on('change', "select[id='group_post']", function() {
				var tmp = $(this).val()
				console.log(tmp)
				if (_.includes(tmp, '??????????????????????????????')) {
					$("#div_group_post_other").removeClass('hide_atfirst')
				} else {
					$("input[name='group_post_other']").val('')
					$("#div_group_post_other").addClass('hide_atfirst')
				}
			})

			$(jQuery).on('change', "select[name='group_post_att_reason']", function() {
				var tmp = $(this).val()
				// console.log($(this).parent().parent())
				// console.log($(this).parent().parent().next().children().find($("input[name='group_post_know_writer']")))

				if (tmp == 0) {
					$(this).parent().parent().next().children().find($("input[name='group_post_know_writer']")).attr({ 'checked': false}).parent().removeClass('active')
					$(this).parent().parent().next().hide()
				} else {
					$(this).parent().parent().next().attr({'style': 'display: flex'})
				}

			})

			$(jQuery).on('change', "input[class='group_post_know_writer']", function() {
				var tmp = $(this).val()

				if (tmp == 1) {
					$(this).parent().parent().parent().children().find($("input[name='group_post_writer']")).show()
				} else {
					$(this).parent().parent().parent().children().find($("input[name='group_post_writer']")).val('').hide()
				}
			})

			$(jQuery).on('change', "input[name='rel_event']", function() {
				var tmp = $(this).val()

				if (tmp == 1) {
					$("#rel_event_details").show()
				} else {
					$("#rel_event_details").children().find($("input[type='radio']")).attr({ 'checked': false}).parent().removeClass('active')
					$("#rel_event_details").children().find($("input[type='text']")).val('')
					$("#rel_event_details").children().find($("select")).val('')
					$("#rel_event_details").hide()
				}
			})

			$(jQuery).on('change', "select[id='rel_event_pos']", function() {
				var tmp = $(this).val()

				if (tmp == 6) {
					$("input[name='rel_event_pos_other']").show()
				} else {
					$("input[name='rel_event_pos_other']").val('').hide()
				}
			})
			
			$(jQuery).on('change', "select[id='rel_event_neg']", function() {
				var tmp = $(this).val()

				if (tmp == 6) {
					$("input[name='rel_event_neg_other']").show()
				} else {
					$("input[name='rel_event_neg_other']").val('').hide()
				}
			})

			$("#group-add").on("click", function (event) {
				event.preventDefault();
				var tmp   = $(".group_post").clone().last();
				var index = _.toNumber(tmp.find("input[class='group_post_know_writer']").attr('name').split('_').slice(-1)[0])
				tmp.find("input[class='group_post_know_writer']").attr({'name': 'group_post_know_writer_' + (index + 1)})
				tmp.find("label").removeClass('active');
				// console.log(tmp)
				$(".group_post_wrapper").append(tmp)
			})

			$("#group-minus").on("click", function (event) {
				event.preventDefault();
				var tmp = $(".group_post").clone()
				// console.log(tmp)
				
				if (tmp.length > 1) {
					$(".group_post_wrapper").children().last().remove()
				} else {
					$.confirm({
						title: '',
					    content: '????????????????????????',
					    buttons: {
					        OK: function () {}
					    }
					});
				}
			})
		}

		function FetchGroupList() {
			$.ajax({ 
				type: "POST",
				url: '',
				dataType: "json",
				data: {
					FetchGroupList: 1
				},success: function(data){
					console.log(data)

					_.map(data, function(obj) {
						$("select[id='group_view']").append(
							$("<option>").html(obj.group_name)
						)
						$("select[id='group_post']").append(
							$("<option>").html(obj.group_name)
						)	
					})

					$("select[id='group_view']").append(
						$("<option>").html('??????????????????????????????')
					)

					$("select[id='group_post']").append(
						$("<option>").html('??????????????????????????????')
					)

					$('.multiselect').multiselect({
						buttonWidth: '100%',
						buttonClass: 'form-control',
						nonSelectedText: '?????????',
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
	</script>
	<style type="text/css">
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

		.dropdown-item {
			/*font-size: 1.2rem;*/
		}

		select[name='group_post_att_reason'], select[id='rel_event_pos'] {
			height: 3.5rem;
		}

		#group-add,#group-minus {
			font-size: 2rem;
		}

		.group_post{
			margin: 0.5rem auto;
		}

		.group_post>.input-group {
			margin: 0.1rem auto;
		}

		.hide_atfirst {
			display: none;
		}

		.btn_submit {
			height: 8rem;
		}

		@media screen and (max-width: 550px) {
			.btn {
			    padding: .375rem .05rem;
			}

			.btn.focus,.btn.mouseup,.btn.focusout,.btn.blur {
				color: inherit;
				background-color: transparent;
			}

			#div_symptom>.btn {
				width: 49%;
			}

			input[name='symptom_other'] {
				width: 100%;
			}

			select[name='group_post_att_reason'], select[id='rel_event_pos'] {
				height: 2.5rem;
			}

		}
	</style>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container">
		<div class="card border-primary">
			<div class="card-header text-white bg-primary">????????????</div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text">??????????????????????????????</span>
					</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="date" class="form-control" required></select>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>??????????????????</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="mood" value="0" required>?????????</label>
						<label class="btn btn-outline-primary"><input type="radio" name="mood" value="1" required>??????</label>
						<label class="btn btn-outline-primary"><input type="radio" name="mood" value="2" required>??????</label>
						<label class="btn btn-outline-primary"><input type="radio" name="mood" value="3" required>??????</label>
						<label class="btn btn-outline-primary"><input type="radio" name="mood" value="4" required>????????????</label>
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>????????????????????????</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="symptom" value="1" required>???</label>
						<label class="btn btn-outline-primary"><input type="radio" name="symptom" value="0"         >???</label>
					</div>
					<div id="div_symptom" class="btn-group-toggle col-sm-12 pl-0 pr-0 hide_atfirst" data-toggle="buttons" data-style="ios">
						<div class="mt-2">???????????????(?????????)</div>
						<label for="sick" class="btn btn-outline-info">
							<input id="sick" class="chkbox_symptoms" type="checkbox" name="sick" >???????????????
						</label>
					  	<label for="fever" class="btn btn-outline-info">
					  		<input id="fever" class="chkbox_symptoms" type="checkbox" name="fever">??????(??????38???)
					  	</label>
					  	<label for="cough" class="btn btn-outline-info">
					  		<input id="cough" class="chkbox_symptoms" type="checkbox" name="cough">??????
					  	</label>
						<label for="sorethroat" class="btn btn-outline-info">
							<input id="sorethroat"  class="chkbox_symptoms" type="checkbox" name="sorethroat">?????????
						</label>
						<label for="hospital" class="btn btn-outline-info">
							<input id="hospital"  class="chkbox_symptoms" type="checkbox" name="hospital">????????????(?????????)
						</label>
						<label for="symptom_other_chk" class="btn btn-outline-info">
							<input id="symptom_other_chk" class="chkbox_symptoms" type="checkbox" name="symptom_other_chk">??????
						</label>
						<input name="symptom_other" type="text" class="form-control hide_atfirst" placeholder="??????????????????????????????">
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text d-inline text-left"><span class="change_bydate"></span>??????????????????????????????????????????????????????<br>(???????????????????????????????????????????????????????????????LINE)</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-primary"><input type="radio" name="touchpeople" value="0" required>0???</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touchpeople" value="1" required>1-4???</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touchpeople" value="2" required>5-9???</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touchpeople" value="3" required>10-19???</label>
						<label class="btn btn-outline-primary"><input type="radio" name="touchpeople" value="4" required>20?????????</label>
					</div>
				</div>
			</div>
		</div>
		<div class="card border-success">
			<div class="card-header text-white bg-success"></div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>???????????????/????????????????????????</span>
					</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="group_view" class="multiselect" multiple="multiple" required></select>
					</div>
				</div>
				<div class="input-group hide_atfirst" id="div_group_view_other">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>???????????????????????????????????????(?????????/??????)</span>
					</div>
					<div class="col-sm-8 pl-0 pr-0">
						<input type="text" name="group_view_other" class="form-control">
					</div>
				</div>
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>????????????????????????????????????/??????</span>
					</div>
					<div class="col-sm-8 pl-0 pr-0">
						<select id="group_post" class="multiselect" multiple="multiple" required></select>
					</div>
				</div>
				<div class="input-group hide_atfirst" id="div_group_post_other">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>???????????????????????????????????????(?????????/??????)</span>
					</div>
					<div class="col-sm-8 pl-0 pr-0">
						<input type="text" name="group_post_other" class="form-control">
					</div>
				</div>
				<div class="group_post_wrapper">
					<div class="group_post border border-warning">
						<div class="input-group">
							<div class="input-group-prepend col-sm-4 pl-0 pr-0">
								<span class="input-group-text d-inline text-left"><span class="change_bydate"></span>?????????LINE???????????????????????????????????????????????????<br>???????????????????????????????????????</span>
							</div>
							<div class="col-sm-8 pl-0 pr-0">
								<select name="group_post_att_reason" class="form-control" required>
									<option value="">?????????</option>
									<option value="1">?????????(???????????????????????????)???</option>
									<option value="2">????????????</option>
									<option value="3">????????????????????????</option>
									<option value="4">???????????????</option>
									<option value="5">??????</option>
									<option value="0">???????????????????????????????????????</option>
								</select>
							</div>
						</div>
						<div class="input-group hide_atfirst">
							<div class="input-group-prepend col-sm-4 pl-0 pr-0">
								<span class="input-group-text">????????????????????????????????????????????????</span>
							</div>
							<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
								<label class="btn btn-outline-success"><input type="radio" name="group_post_know_writer_0" class="group_post_know_writer" value="1" >???</label>
								<label class="btn btn-outline-success"><input type="radio" name="group_post_know_writer_0" class="group_post_know_writer" value="0" >???</label>
							</div>
							<div class="col-sm-12 pl-0 pr-0">
								<input type="text" name="group_post_writer" class="form-control hide_atfirst" placeholder="?????????????????????LINE?????????????????????">
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="input-group">
					<label class="col-sm-4 control-label text-success">????????????????????????????????????????????????<br>?????????"+" "-"????????????????????????</label>
					<div class="col-sm-8">
						<button id="group-add" class="btn"><i class="fas fa-plus-circle"></i></button>
						<button id="group-minus" class="btn"><i class="fas fa-minus-circle"></i></button>
					</div> 
				</div>
			</div>
		</div>
		<div class="card border-info">
			<div class="card-header text-white bg-info"></div>
			<div class="card-body">
				<div class="input-group">
					<div class="input-group-prepend col-sm-4 pl-0 pr-0">
						<span class="input-group-text"><span class="change_bydate"></span>??????????????????????????????????????????</span>
					</div>
					<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
						<label class="btn btn-outline-info"><input type="radio" name="rel_event" value="1" required>???</label>	
						<label class="btn btn-outline-info"><input type="radio" name="rel_event" value="0" required>???</label>
					</div>
				</div>
				<div id="rel_event_details" class="hide_atfirst">
					<div class="input-group">
						<div class="col-sm-12 pl-0 pr-0">
							<input type="text" name="rel_event_name" class="form-control" placeholder="??????????????????">
						</div>
						<div class="col-sm-12 pl-0 pr-0">
							<input type="text" name="rel_event_time" class="form-control" placeholder="??????????????????">
						</div>
						<div class="col-sm-12 pl-0 pr-0">
							<input type="text" name="rel_event_population" class="form-control" placeholder="??????????????????">
						</div>
					</div>					
				
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text text-left">????????????????????????(??????/??????)??????????????????<br>(????????????????????????????????????)?????????/??????</span>
						</div>
						<div class="col-sm-8 pl-0 pr-0">
							<select id="rel_event_pos" class="form-control">
								<option value="" >?????????</option>
								<option value="1">?????????????????????</option>
								<option value="2">???????????????</option>
								<option value="3">????????????</option>
								<option value="4">????????????</option>
								<option value="5">?????????????????????</option>
								<option value="6">??????</option>
								<option value="0">???</option>
							</select>
						</div>
						<div class="col-sm-12 pl-0 pr-0">
							<input type="text" name="rel_event_pos_other" class="form-control hide_atfirst" placeholder="????????????????????????????????????/??????">
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text text-left">??????????????????????????????????????????????????????</span>
						</div>
						<div class="col-sm-8 pl-0 pr-0">
							<select id="rel_event_neg" class="form-control">
								<option value="" >?????????</option>
								<option value="1">?????????????????????</option>
								<option value="2">???????????????</option>
								<option value="3">????????????</option>
								<option value="4">????????????</option>
								<option value="5">?????????????????????</option>
								<option value="6">??????</option>
								<option value="0">???</option>
							</select>
						</div>
						<div class="col-sm-12 pl-0 pr-0">
							<input type="text" name="rel_event_neg_other" class="form-control hide_atfirst" placeholder="?????????????????????????????????????????????/??????">
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text">??????????????????????????????????????????</span>
						</div>
						<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-info"><input name="rel_event_atm" type="radio" value="0" >?????????</label>
							<label class="btn btn-outline-info"><input name="rel_event_atm" type="radio" value="1" >??????</label>
							<label class="btn btn-outline-info"><input name="rel_event_atm" type="radio" value="2" >??????</label>
							<label class="btn btn-outline-info"><input name="rel_event_atm" type="radio" value="3" >??????</label>
							<label class="btn btn-outline-info"><input name="rel_event_atm" type="radio" value="4" >????????????</label>
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text">?????????????????????????????????????????????/??????</span>
						</div>
						<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-info"><input name="gain_spiritual" type="radio" value="0" >??????</label>
							<label class="btn btn-outline-info"><input name="gain_spiritual" type="radio" value="1" >?????????</label>
							<label class="btn btn-outline-info"><input name="gain_spiritual" type="radio" value="2" >????????????</label>
							<label class="btn btn-outline-info"><input name="gain_spiritual" type="radio" value="3" >???????????????/??????</label>
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text">???????????????????????????</span>
						</div>
						<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-info"><input name="mood_0" type="radio" value="0" >?????????</label>
							<label class="btn btn-outline-info"><input name="mood_0" type="radio" value="1" >??????</label>
							<label class="btn btn-outline-info"><input name="mood_0" type="radio" value="2" >??????</label>
							<label class="btn btn-outline-info"><input name="mood_0" type="radio" value="3" >??????</label>
							<label class="btn btn-outline-info"><input name="mood_0" type="radio" value="4" >????????????</label>
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text">???????????????????????????</span>
						</div>
						<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-info"><input name="mood_1" type="radio" value="0" >?????????</label>
							<label class="btn btn-outline-info"><input name="mood_1" type="radio" value="1" >??????</label>
							<label class="btn btn-outline-info"><input name="mood_1" type="radio" value="2" >??????</label>
							<label class="btn btn-outline-info"><input name="mood_1" type="radio" value="3" >??????</label>
							<label class="btn btn-outline-info"><input name="mood_1" type="radio" value="4" >????????????</label>
						</div>
					</div>
					<div class="input-group">
						<div class="input-group-prepend col-sm-4 pl-0 pr-0">
							<span class="input-group-text text-left">????????????????????????????????????????????????????????????????????????<br>(??????: ???????????????...???)</span>
						</div>
						<div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
							<label class="btn btn-outline-info"><input name="gain_instrumental" type="radio" value="0" >??????</label>
							<label class="btn btn-outline-info"><input name="gain_instrumental" type="radio" value="1" >?????????</label>
							<label class="btn btn-outline-info"><input name="gain_instrumental" type="radio" value="2" >????????????</label>
							<label class="btn btn-outline-info"><input name="gain_instrumental" type="radio" value="3" >???????????????/??????</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div align="center">
			<button id="FormSubmit" class="btn btn-default">
				<img class="btn_submit" src="/pic/btn_save.png">
			</button>
		</div>
	</div>
	<footer class="footer">
  		<div>
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

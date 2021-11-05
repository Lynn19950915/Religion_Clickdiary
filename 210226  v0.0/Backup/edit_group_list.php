<?php
	session_start();
	include("db.php"); 

	$id = $_SESSION['acc_info']['id'];

	if (isset($_POST['FetchGroupList'])) {
		$sql = "SELECT * FROM `group_list` WHERE id = :v1" ;
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $id);
		$stmt->execute();
		$json = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

	if (isset($_POST['FormSubmit'])) {
		$group_list = $_POST['group_list'];

		$arr = $group_list;
		$n   = count($arr['group_name']);
		if ($n > 0) {
			for ($i = 0; $i < $n; $i = $i + 1) { 
				$sql = "SELECT * FROM `group_list` WHERE id = :v1 AND group_name = :v2";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':v1', $id);
				$stmt->bindParam(':v2', $arr['group_name'][$i]);
				$stmt->execute();

				if ($stmt->rowCount() > 0) {
					// $sql = "UPDATE
					// 		    `group_list`
					// 		SET
					// 		    `group_name` 	= :v1,
					// 		    `myname` 		= :v2,
					// 		    `check_freq` 	= :v3,
					// 		    `is_religious` 	= :v4,
					// 		    `n_invitees` 	= :v5,
					// 		WHERE
					// 		    id = :v6";
				} else {
					$sql = "INSERT INTO
						  `group_list`(
						    `id`,
						    `group_name`,
						    `myname`,
						    `check_freq`,
						    `is_religious`,
						    `n_invitees`,
						    `create_time`
						  )
						VALUES(
						  :v1,
						  :v2,
						  :v3,
						  :v4,
						  :v5,
						  :v6,
						  :v7
						)";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':v1', $id);
					$stmt->bindParam(':v2', $arr['group_name'][$i]);
					$stmt->bindParam(':v3', $arr['group_myname'][$i]);
					$stmt->bindParam(':v4', $arr['group_check_freq'][$i]);
					$stmt->bindParam(':v5', $arr['group_is_religious'][$i]);
					$stmt->bindParam(':v6', $arr['group_n_invitees'][$i]);
					$stmt->bindParam(':v7', $now);
					$stmt->execute();
				}				
			}
		}	
		exit();
	}
?><!DOCTYPE html>
<html>
<head>
	<title>編輯我的群組</title>
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
		$(document).ready(function() {
			

			$("input[name='functiontoggle']").on("change", function(evt) {
				evt.preventDefault()
				var tmp = $(this).val()
				console.log(tmp)

				if (tmp == 0) {

				} else {
					FetchGroupList();		
				}

			})

			$("#group-add").on("click", function (event) {
				event.preventDefault();
				var tmp   = $(".group-info-wrapper").clone().last().find("input[type='text']").val("").end();
				var index = _.toNumber(tmp.find("input[class='group_check_freq']").attr('name').split('_').slice(-1)[0])
				// console.log(index)
				tmp.find("input[class='group_check_freq']").attr({
					'name': 'group_check_freq_' + (index + 1),
					'checked': false
				})
				tmp.find("input[class='group_is_religious']").attr({
					'name': 'group_is_religious_' + (index + 1),
					'checked': false
				})
				tmp.find("input[class='group_n_invitees']").attr({
					'name': 'group_n_invitees_' + (index + 1),
					'checked': false
				})
				tmp.find("label").removeClass('active');
				// console.log(tmp)
				$(".group-info").append(tmp)
			})

			$("#group-minus").on("click", function (event) {
				event.preventDefault();
				var tmp = $(".group-info-wrapper").clone()
				// console.log(tmp)
				
				if (tmp.length > 1) {
					$(".group-info").children().last().remove()
				} else {
					$.confirm({
						title: '',
					    content: '至少填寫一個群組',
					    buttons: {
					        OK: function () {}
					    }
					});
				}
			})

			$("#form").on("submit", function(evt) {
				evt.preventDefault()
				var group_list = {
					group_name: [],
					group_myname: [],
					group_check_freq: [],
					group_is_religious: [],
					group_n_invitees: []
				}

				$("input[name='group_name']").each(function(){
					group_list.group_name.push($(this).val().trim())
				})

				$("input[name='group_myname']").each(function(){
					group_list.group_myname.push($(this).val())
				})

				$("input[class='group_check_freq']:checked").each(function(){
					group_list.group_check_freq.push($(this).val())
				})

				$("input[class='group_is_religious']:checked").each(function(){
					group_list.group_is_religious.push($(this).val())
				})

				$("input[class='group_n_invitees']:checked").each(function(){
					group_list.group_n_invitees.push($(this).val())
				})

				console.log(group_list)

				$.ajax({ 
					type: "POST",
					url: '',
					data: {
						FormSubmit: 1,
						group_list: group_list
					},success: function(data){
						console.log(data);
						if(data == "success"){
							$.alert("個人資料填寫完成")
							setTimeout(function() {
								window.location.href = 'http://cdiary3.tw/main.php';
							}, 1500);
						}else {

						}
					},error: function(e){
						console.log(e)
						$.alert("錯誤，請確認是否有題目漏填<br>若問題持續發生請聯繫我們<br>***@stat.sinica.edu.tw")
					}
				})
			})
		})

		function FetchGroupList() {
			$.ajax({ 
				type: "POST",
				url: '',
				dataType: "json",
				data: {
					FetchGroupList: 1
				},success: function(data){
					console.log(data)
					if (data) {
						for (var i = 0; i < data.length; i++) {
							var obj = data[i]
							var tmp = $(".group-info-wrapper").clone().last()
							if (i == 0) $(".group-info-wrapper").remove()

							tmp.find("input[name='group_name']").val(obj.group_name)
							tmp.find("input[name='group_myname']").val(obj.myname)

							tmp.find("input[class='group_check_freq']").attr({
								'name': 'group_check_freq_' + i,
								'checked': false
							}).parent().removeClass('active')
							tmp.find("input[class='group_check_freq'][value='" + obj.check_freq +"']").attr({'checked': true}).parent().addClass('active')
							tmp.find("input[class='group_is_religious']").attr({
								'name': 'group_is_religious_' + i,
								'checked': false
							}).parent().removeClass('active')
							tmp.find("input[class='group_is_religious'][value='" + obj.is_religious +"']").attr({'checked': true}).parent().addClass('active')
							tmp.find("input[class='group_n_invitees']").attr({
								'name': 'group_n_invitees_' + i,
								'checked': false
							}).parent().removeClass('active')
							tmp.find("input[class='group_n_invitees'][value='" + obj.n_invitees +"']").attr({'checked': true}).parent().addClass('active')

							$(".group-info").append(tmp)
						}
					}
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
		/* ---------------------------------------------------------------------------------- */
			
			.bg-warning {
				background-color: #fcf8e3 !important;
			}

			.border-warning {
				border-color: #faebcc !important;
			}

			.input-group-prepend {
				margin: 0.2rem;
			}

			.btn-group {
				width: 100%;
			}

			#group-add,#group-minus {
				font-size: 2rem;
				padding: .375rem .75rem;
			}

			.btn_submit {
				height: 8rem;
			}

			@media screen and (max-width: 550px) { 
				.container {
					padding: 1rem 0.25rem
				}
				
				.card-body {
					padding: 1.25rem 0.5rem;
				}

				.input-group-text.adj-width {
					width: 12rem;
				}

				.btn {
					padding: .375rem;
				}
			}
	</style>	
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container">
		<form id="form">
			<div class="card border-warning">
				<div class="card-header text-dark bg-warning">我的群組清單</div>
				<div class="card-body">	
					<div class="input-group mb-2">
						<div class="input-group-prepend col-sm-12 pl-0 pr-0">
					    	<div class="input-group-text col-sm-3 text-left">
					    		<span>功能選擇</span>
					    	</div>
					    	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-9 pl-0 pr-0" data-toggle="buttons">
								<label class="btn btn-outline-primary">
							    	<input type="radio" name="functiontoggle" class="" value="0" > 新增群組
								</label>
								<label class="btn btn-outline-primary">
							    	<input type="radio" name="functiontoggle" class="" value="1" > 編輯群組
								</label>
							</div>
						</div>
					</div>
					<div>
						
					</div>
					<div class="input-group mb-2">
						<div class="input-group-prepend col-sm-12 pl-0 pr-0">
					    	<div class="input-group-text col-sm-12 text-left">
					    		<span>
					    			我目前固定查閱、瀏覽或發文的LINE群組有哪些<br>
					    			<span class="text-danger">請盡量多填，但宗教群組為必填</span>
					    		</span>
					    	</div>
						</div>
					</div>
					<div class="input-group group-info mt-2 mb-2">
						<div class="group-info-wrapper col-sm-12 pl-0 pr-0 mt-2 mb-2">
							<div class="input-group-prepend col-sm-12 pl-0 pr-0">
						    	<span class="input-group-text col-sm-3 pr-0">群組名稱</span>
						    	<input type="text" class="form-control" name="group_name" required>
							</div>
							<div class="input-group-prepend col-sm-12 pl-0 pr-0">
						    	<span class="input-group-text col-sm-3 pr-0">我在群組中使用的名字</span>
						    	<input type="text" class="form-control" name="group_myname" required>
							</div>
							<div class="input-group-prepend col-sm-12 pl-0 pr-0">
						    	<span class="input-group-text col-sm-3 pr-0 adj-width">查閱頻率</span>
						    	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-9 pl-0 pr-0" data-toggle="buttons">
								  <label class="btn btn-outline-primary">
								    <input type="radio" name="group_check_freq_0" class="group_check_freq" value="0" required> 每天多次
								  </label>
								  <label class="btn btn-outline-primary">
								    <input type="radio" name="group_check_freq_0" class="group_check_freq" value="1" required> 每天一次
								  </label>
								  <label class="btn btn-outline-primary">
								    <input type="radio" name="group_check_freq_0" class="group_check_freq" value="2" required> 兩三天一次
								  </label>
								  <label class="btn btn-outline-primary">
								    <input type="radio" name="group_check_freq_0" class="group_check_freq" value="3" required> 偶爾
								  </label>
								</div>
							</div>
							<div class="input-group-prepend col-sm-12 pl-0 pr-0">
						    	<span class="input-group-text col-sm-3 pr-0 adj-width">是否為宗教群組</span>
						    	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-9 pl-0 pr-0" data-toggle="buttons">
								  <label class="btn btn-outline-primary">
								    <input type="radio" name="group_is_religious_0" class="group_is_religious" value="1" required> 是
								  </label>
								  <label class="btn btn-outline-primary">
								    <input type="radio" name="group_is_religious_0" class="group_is_religious" value="0" required> 否
								  </label>
								</div>
							</div>
							<div class="input-group-prepend col-sm-12 pl-0 pr-0">
						    	<span class="input-group-text text-left col-sm-3 pr-0 adj-width">我曾邀請多少人<br class="d-sm-none">加入此群組</span>
						    	<div class="btn-group btn-group-toggle btn-group-custom-flex col-sm-9 pl-0 pr-0" data-toggle="buttons">
								  <label class="btn btn-outline-primary pt-onss">
								    <input type="radio" name="group_n_invitees_0" class="group_n_invitees" value="0" required> 0人
								  </label>
								  <label class="btn btn-outline-primary pt-onss">
								    <input type="radio" name="group_n_invitees_0" class="group_n_invitees" value="1" required> 1 - 4人
								  </label>
								  <label class="btn btn-outline-primary pt-onss">
								    <input type="radio" name="group_n_invitees_0" class="group_n_invitees" value="2" required> 5人以上
								  </label>
								</div>
							</div>
						</div>
					</div>
					<div class="input-group-prepend col-sm-12 pl-0 pr-0">
						<div class="col-sm-3 pl-0 pr-0" style="align-self: center;">
							<label class="control-label text-success">請透過右方按鈕<br class="d-sm-none">增減群組</label>
						</div>
						<div class="col-sm-6 pl-0 pr-0">
							<button id="group-add"   class="btn"><i class="fas fa-plus-circle"></i></button>
							<button id="group-minus" class="btn"><i class="fas fa-minus-circle"></i></button>	
						</div>	
					</div>
				</div>
			</div>
			<div align="center">
				<button id="FormSubmit" class="btn btn-default">
					<img class="btn_submit" src="/pic/btn_save.png">
				</button>
			</div>
		</form>
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
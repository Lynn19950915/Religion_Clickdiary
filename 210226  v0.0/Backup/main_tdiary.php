<?php
	session_start();
	include("db.php"); 
	CheckAccInfo();
?><!DOCTYPE html>
<html>
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
		$(document).ready(function() {
			$("#btn_alter_list").on('click', function() {
				window.location.href = "http://cdiary3.tw/alter_list.php";
			})

			$("#btn_create_alter").on('click', function() {
				window.location.href = "http://cdiary3.tw/create_alter.php";	
			})

		})
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

			.card-footer {
			    background-color: transparent;
			    border: none;
			}

			.msg-text {
				letter-spacing: 0.25rem;
				line-height: 2.5rem;
			    text-align: justify;
			}

			.btn-img {
				border-color: #8a6d3b;
				color: #8a6d3b;
				height: 7em;
				width: 12em;
				margin: auto 1em;
			}

			.btn-img:hover {
				background: #FFB655;
				color: white;
			}

			@media screen and (max-width: 550px) { 
				ol {
					padding-left: 1.2em;
				}

				.btn-img {
					border-color: #8a6d3b;
					color: #8a6d3b;
					height: 8em;
					width: 8em;
					margin: auto 0.25em;
				}
			}
	</style>	
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container">
		<div class="card border-warning">
			<div class="card-header text-dark bg-warning">接觸的定義</div>
			<div class="card-body">	
				<div class="msg-text">日常生活中，有雙向互動對話: 包括講話、打電話、文字、透過LINE或其他社交媒體...等。</div>
			</div>
			<div class="card-footer">
		  		<div class="text-center">
		  			<button id="btn_alter_list"   class="btn btn-img">
						<img src="./pic/alter_list_64.png"><br>已建檔之接觸對象名單
					</button>
					<button id="btn_create_alter" class="btn btn-img">
						<img src="./pic/create_alter_64.png"><br>新增接觸對象
					</button>
				</div>
			</div>
		</div>
		<div class="card border-warning mt-4">
			<div class="card-header text-dark bg-warning" >使用說明 & 注意事項</div>
			<div class="card-body">	
				<div class="msg-text">
					<ol>
						<li>點選新增接觸對象，開始建立我的接觸對象名單</li>
						<li>「接觸對象基本資料表」填寫完成後，即可開始填寫接觸日記</li>
						<li>已填過基本資料表的接觸對象，可在接觸對象名單中查看</li>
						<li>當天若與同一人有多次接觸，只需紀錄最主要的一次接觸</li>	
					</ol>
				</div>
			</div>
		</div>
		<br>
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
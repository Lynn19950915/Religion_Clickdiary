<?php
	session_start();
	include("db.php"); 
	
?><!DOCTYPE html>
<html>
<head>
	<title>點日記3.0</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache">
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
	<!-- React -->
	<script src="https://cdn.staticfile.org/react/16.4.0/umd/react.development.js"></script>
	<script src="https://cdn.staticfile.org/react-dom/16.4.0/umd/react-dom.development.js"></script>
	<script src="https://cdn.staticfile.org/babel-standalone/6.26.0/babel.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			
		})

	</script>
	<style type="text/css">
		/*For nav and footer*/
		html {
		  position: relative;
		  min-height: 100%;
		}
		body {
		  /*Avoid nav bar overlap web content*/		  
		  padding-top: 70px;
		  /* Margin bottom by footer height ，avoid footer overlap web content*/
		  /*margin-bottom: 60px;*/
		}
		.footer {
		  /*position: absolute;*/
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
		/**/
		.text-customized {
			font-size: 1.2rem;
			line-height: 2.5rem;
			letter-spacing: 0.4rem;
			/*text-align: justify;*/
		}

		/*.url {
			letter-spacing:  0rem;
			font-size: 0.9rem;
		}*/

		.ios_img {
			width: 50vw;
			/*height: 20rem;*/
		}
		
		ol>li {
			font-size: 1.6rem;
		}

		@media screen and (max-width: 550px) {
			.url {
				letter-spacing:  0rem;
				font-size: 0.9rem;
			}

			ol>li {
				font-size: 1rem;
			}
		}
	</style>
	
</head>
<body>
	<?php include_once("header.php");?>
	<div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="page_1-tab" data-toggle="tab" href="#page_1" role="tab" aria-controls="page_1" aria-selected="true">Android版本</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="page_2-tab" data-toggle="tab" href="#page_2" role="tab" aria-controls="page_2" aria-selected="false">iOS版本</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="page_1" role="tabpanel" aria-labelledby="page_1-tab">
				<div class="card border-primary">
					<div class="card-header text-white bg-primary">apk下載 & 安裝</div>
					<div class="card-body text-customized">
						<a href="http://cdiary3.tw/cdiary3.apk" style="color: black;" download>點此下載手機桌面捷徑(Android) <i class="fas fa-file-download"></i></a>
						<div>下載後安裝此apk即可建立點日記3.0捷徑</div>
					</div>
				</div>
				<div class="card border-primary mt-4">
					<div class="card-header text-white bg-primary">瀏覽器建立手機桌面捷徑</div>
					<div class="card-body text-customized">
						<ol>
							<li>利用chrome瀏覽器開啟點日記3.0首頁 (http://cdiary3.tw)<br>並點選畫面上方按鈕</li>
							<img class="ios_img" src="../pic/android (1).png" >
							<li>點選"加入主畫面"按鈕</li>
							<img class="ios_img" src="../pic/android (2).png" >
							<li>點選"新增"按鈕，即可將點日記3.0捷徑加入手機桌面</li>
							<img class="ios_img" src="../pic/android (3).png" >
							<li>點選此捷徑，即可快速前往點日記3.0網站</li>
							<img class="ios_img" src="../pic/android (4).png" >
						</ol>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="page_2" role="tabpanel" aria-labelledby="page_2-tab">
				<span style="font-size: 1.4em;">
				請務必先開啟safari瀏覽器，然後進入此網址<a href="http://cdiary3.tw">http://cdiary3.tw</a>(可拷貝至safari貼上)，然後依以下指示設定：<br><br>
				</span>
				<ol>
					<li>點選此圖示按鈕 (因版本不同，可能出現在畫面上方或下方)</li>
					<img class="ios_img" src="../pic/ios (1).PNG" >
					<li>在底部選單上向右滑動，並點選"加入主畫面"按鈕  (若找不到此按鈕，請先點選"切換為電腦版網站"便可找到)</li>
					<img class="ios_img" src="../pic/ios (2).PNG" >
					<li>點選"新增"按鈕，即可將點日記3.0捷徑加入手機桌面</li>
					<img class="ios_img" src="../pic/ios (3).PNG" >
					<li>點選此捷徑，即可快速前往點日記3.0網站</li>
					<img class="ios_img" src="../pic/ios (4).PNG" >
				</ol>
			</div>
		</div>















		
	</div>
	<footer class="footer">
  		<div>
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
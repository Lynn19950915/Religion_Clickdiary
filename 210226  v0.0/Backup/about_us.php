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

		@media screen and (max-width: 550px) {
			.url {
				letter-spacing:  0rem;
				font-size: 0.9rem;
			}			
		}
	</style>
	
</head>
<body>
	<?php include_once("header.php");?>
	<div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="page_1-tab" data-toggle="tab" href="#page_1" role="tab" aria-controls="page_1" aria-selected="true">計畫簡介</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="page_1" role="tabpanel" aria-labelledby="page_1-tab">
				<div class="card border-primary">
					<div class="card-header text-white bg-primary">簡介</div>
					<div class="card-body text-customized">
						台灣社會的宗教活動蓬勃發展，不論是佛教團體的志工，還是民間信仰信徒主動發心的儀式活動義工，都為台灣社會的宗教注入相當高的活力。隨著3C時代的來臨，新的溝通模式創造了更多組織動員的新可能，也讓宗教參與的型態更為豐富。<br><br>
						為瞭解這群發心自願參與宗教活動的義工，如何在宗教參與及日常生活間達到平衡？平時如何獲得訊息？彼此如何溝通、互動？有何心靈上的收穫？<br><br>
						中研院統計所及社會所計畫進行一項線上填答的研究，希望(定期或不定期)參與宗教服務活動的人，能定期在線上填答簡單問卷，讓我們更瞭解台灣宗教發展背後的活力如何產生。本研究將提供微薄的回饋作為答謝，謝謝您發心參與!!<br>					
					</div>
				</div>
				<div class="card border-primary mt-4">
					<div class="card-header text-white bg-primary">研究團隊與聯絡資訊</div>
					<div class="card-body text-customized">
						<ul class="pl-2">
							<li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
                            <li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
                            <li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
                            <li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
                            <li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
                            <li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
                            <li>*** <a class="url" target="_blank" href="http://***">http://***</a></li>
						</ul>
						<div>聯絡信箱: <a class="url" href="mailto:***@stat.sinica.edu.tw">***@stat.sinica.edu.tw</a></div>
					</div>
				</div>
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
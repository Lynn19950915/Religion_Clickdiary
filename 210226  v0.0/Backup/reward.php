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
			font-size: 1.1rem;
			line-height: 2.5rem;
			letter-spacing: 0.4rem;
			/*text-align: justify;*/
		}

		.card-header {
			padding: 0.5rem 1.25rem;
		}

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
			<!-- <li class="nav-item"><a class="nav-link active" id="page_1-tab" data-toggle="tab" href="#page_1" role="tab" aria-controls="page_1" aria-selected="true">獎勵規則說明</a></li> -->
			<!-- <li class="nav-item"><a class="nav-link" id="page_2-tab" data-toggle="tab" href="#page_2" role="tab" aria-controls="page_2" aria-selected="false">參與者說明書</a></li> -->
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="page_1" role="tabpanel" aria-labelledby="page_1-tab">
				<div class="card border-primary">
					<div class="card-header text-white bg-primary">獎勵規則說明</div>
					<div class="card-body text-customized">
						核發以下獎金的條件為每個月須有20個不同人次的接觸量，此數量為參考過去一般人接觸經驗的參考值。
						<br/>
						會員符合以下條件者，每月底結算後可以獲得現金回饋：
						<br/>
						<!-- 
						<ol>
							<li>顧及您的負擔，建議一天填寫的接觸對象以不超過30位為原則<br>但每個月填寫的接觸對象，依經驗值合理應至少達30位</li>
							<li>符合上述條件並且每月填寫<span class="bg-warning">生活日記 & 接觸日記各達10天以上</span>，可得200元全聯禮券;<br><span class="bg-warning">達20天以上</span>，可得500元全聯禮券 </li>
							<li>參與宗教活動期間，請務必每天填寫日記</li>
						</ol> 
						-->
						<ol>
							<li>若能每週填寫達2次，將每月發給現金500元</li>
							<li>若能每周填寫達4次，將每月發給現金1000元</li
						</ol>
					</div>
				</div>
				<div class="card border-success mt-4">
					<div class="card-header text-white bg-success">注意事項</div>
					<div class="card-body text-customized">
						<ol>
							<!-- <li>本研究團隊保留隨時修改所有獎勵活動與領獎資格的權利</li> -->
							<li>如有發現您資料填寫異常，研究團隊將去信給您說明取消獎勵的理由</li>
							<li>通知發放獎勵的兩週內，您需提供真實姓名與聯絡地址，以便郵寄全聯禮券，逾期視同放棄領取獎勵</li>
							<li>依中華民國稅法規定，中獎贈品或獎金都算所得稅，全年所中獎的獎品價值超過市價1,000 元，年度報稅時必須計入個人所得。因此每年度領取的商品卡禮券金額累計達1,000元者，請配合提供<span class="bg-warning">真實姓名、身分證字號與戶籍地址</span>作為申報依據，若無法提供者，視同放棄領取獎勵</li>
						</ol>
					</div>
				</div>
			</div>
			<!-- <div class="tab-pane fade" id="page_2" role="tabpanel" aria-labelledby="page_2-tab" align="center"></div> -->
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
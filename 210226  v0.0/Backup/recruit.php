<?php


?><!DOCTYPE html>
<html>
<head>
	<title>點日記3.0 - 招募說明</title>
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
	<style type="text/css">
		/* BASIC */
		html,body {
		  background-color: #f0f0f0;
		  height: 100%;
		}

		.container{
			height: 100%;
			align-content: center;
			padding-top: 5rem;
			padding-bottom: 5vw;
			margin-bottom: 5vw;
		}

		.card-text{
			line-height: 2.5rem;
			letter-spacing: 0.4rem;
		}

		.bg-warning{
			background-color: #FFE499!important;
		}

		.bg-primary{
			background-color: #99CAFF!important;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#btn_register").on("click", function (event) {
			    event.preventDefault();
			    window.location.href = "http://cdiary3.tw/register.php";
			})

    	});
	</script>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container">
		<div class="card">
			<div class="card-body card-text">
				感謝您有興趣瞭解此線上填答的研究計畫，此研究計畫是由中央研究院統計所與社會學研究所研究團隊所共同策畫，第一階段以三個月為期，以下簡單說明參與計畫的重要資訊：
			</div>
		</div>
		<div class="card border-primary mb-4">
			<div class="card-header bg-primary">您在參與期間，所需填寫的資料</div>
			<div class="card-body card-text">
				<div>1.個人資料表</div>
				<div class="pl-4">在一開始登錄參加時，需先線上填一份簡單的「個人資料表」</div>
				<div>2.接觸對象基本資料表</div>
				<div class="pl-4">每新增一位接觸對象，需填寫一份「接觸對象基本資料表」</div>
				<div>3.互動記錄表 & 生活日記</div>
				<div class="pl-4">每週請至少應擇2~3天填寫互動記錄表 & 生活日記兩份表。注意：參與宗教活動的當天請務必填寫。</div>
			</div>
		</div>
		<div class="card border-warning mb-4">
			<div class="card-header bg-warning">獎勵條件說明</div>
			<div class="card-body card-text">
				<ol>
					<li>顧及您的負擔，建議一天填寫的接觸對象以不超過30位為原則，但每個月填寫的接觸對象，依經驗值合理應至少達30位</li>
					<li>符合上述條件並且每月填寫生活日記與接觸日記各達10天以上，可得200元商品禮券;<br>達20天以上，可得500元商品禮券 (參與宗教活動期間，請務必每天填寫日記)</li>
				</ol>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-header">保密聲明</div>
			<div class="card-body card-text">
				<ol>
					<li>您在本研究所提供的任何資料，僅供本團隊研究之用，本團隊不會將您的資料提供給任何其他的個人或團體。您提供的所有人名，都將匿名處理，並且所有的具體資料內容，在未來的研究成果發表中，將不會以任何形式被提及。</li>
					<li>您在任何時刻，都有退出研究計畫的權利。退出研究前所獲得的獎勵，無繳回之義務。	</li>
				</ol>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-body card-text text-center">
				<div>若您有興趣參加，請按以下連結，進行資料登錄</div>
				<div>連結的網站，也有更多詳細的說明。</div>
				<a href="http://cdiary3.tw/register.php" class="btn btn-lg btn-primary mt-2">前往註冊</a>
				<a href="http://cdiary3.tw" class="btn btn-lg btn-info mt-2">已註冊者可點此進入網站</a>
			</div>
		</div>
    </div>
</body>
</html>
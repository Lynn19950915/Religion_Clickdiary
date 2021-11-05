<?php
	session_start();
	include("db.php");	
?>

<!DOCTYPE html>
<html>
<head>
	<title>獎勵規則</title>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache">
    
	<!-- Bootsrap 4 CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	
	<style>
        /* BASIC */
        html{
            min-height: 100%;
            font-family: Microsoft JhengHei; position: relative;
        }
        
        body{
            padding-top: 100px; padding-bottom: 100px;
        }
        
        /* STRUCTURE */
        .container{
			width: 50%; margin: 40px auto;
			align-content: center;
		}
        
        .card{
            border: 0.1em solid #E9CCD3;
        }
        
        .card-header{
            letter-spacing: 0.05em;
            background-color: #E9CCD3; color: #2E317C;
            text-align: left;
        }
        
        .card-body{
		    line-height: 1.75em; letter-spacing: 0.1em;
            font-size: 0.95em; text-align: left;
		}
        
        /* DETEAILED */
        .panel{
            color: #000000;
            -webkit-border-radius: 10px 10px 0px 0px; border-radius: 10px 10px 0px 0px;
        }
        
        .panel:hover, .panel:focus{
            color: #E9CCD3;
            background-color: #E9CCD3;
        }

		/* RESPONSIVE */
		@media screen and (max-width: 800px){
            .container{
                width: 90%; margin: auto; margin-bottom: 2.5%;
                font-size: 0.8em;
            }
            
            .card-body{
                line-height: 2em; padding: 5%; letter-spacing: 0.05em;
            }
            
            .justify-content-center{
                line-height: 0.75em;
            }
            
            .tab-content{
                padding-top: 0.75em;
            }
		}
	</style>	
</head>


<body>
	<?php include("header.php");?>
    
    <div class="container">
        <ul class="nav justify-content-center" style="letter-spacing: 0.05em">
			<li class="nav-item">
				<a class="nav-link panel active" data-toggle="tab" href="#page1" aria-controls="page1" aria-selected="true">獎勵金說明</a>
			</li>
            <li class="nav-item">
				<a class="nav-link panel" data-toggle="tab" href="#page2" aria-controls="page2" aria-selected="false">注意事項</a>
			</li>
		</ul>
        
        <div class="tab-content">
            <div id="page1" class="tab-pane show active" role="tabpanel">
                <div class="card">
                    <div class="card-header"><b>獎勵金說明</b></div>
                    <div class="card-body">
                    <p style="text-align: center; padding-bottom: 1em">
                        核發獎金的條件為：<br>每個月需有<span style="padding: 0.25em; color: #FFFFFF; background-color: #2E317C">20 個不同人次</span>的接觸量<br>
                        （此數量為參考過去一般人接觸經驗的平均值）
                    </p>
                    <div>
                        ▼ 會員符合以下條件者，每月底結算後可獲得獎勵金回饋：<br>
                        1. 每週填寫達 2 次者，每月發給獎勵金 500 元。<br>
                        2. 每週填寫達 4 次者，每月發給獎勵金 1000 元。
                    </div>
                    </div>
                </div>
            </div>
            
            <div id="page2" class="tab-pane show" role="tabpanel">
                <div class="card">
                    <div class="card-header"><b>注意事項</b></div>
                    <div class="card-body" id="rule" style="font-size: 0.8em">
                    <p>
                        一、您在本研究提供的任何資料，僅供本團隊研究之用，本團隊不會將您的資料提供給任何其他的個人或團體。您提供的所有人名，都將匿名處理，並且所有的具體資料內容，在未來的研究成果發表中，將不會以任何形式被提及。
                    </p>
                    <p>
                        二、如有發現您資料填寫異常，研究團隊將來信給您說明取消獎勵的理由。
                    </p>
                    <p>
                        三、通知發放獎勵的兩週內，您需提供真實姓名與聯絡地址，以便郵寄全聯禮券，逾期視同放棄領取獎勵。
                    </p>
                    <p>
                        四、依中華民國稅法規定，中獎贈品或獎金都算所得稅，全年所中獎的獎品價值超過市價 1000 元，年度報稅時必須計入個人所得。因此每年度領取的商品卡禮券金額累計達 1000 元者，請配合提供<span style="padding: 0.25em; color: #FFFFFF; background-color: #2E317C">真實姓名、身分證字號與戶籍地址</span>作為申報依據，若無法提供者，視同放棄領取獎勵。
                    </p>
                    <div>
                        五、您在任何時刻，都有退出研究計畫的權利。退出研究前所獲得的獎勵，無繳回之義務。
                    </div>
				    </div>
                </div>
            </div>
        </div>
    </div>
    
	<?php include("footer.php");?>
</body>
</html>

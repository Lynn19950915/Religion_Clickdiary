<?php
	session_start();
	include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>關於日記</title>
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
                padding: 5%; letter-spacing: 0.05em;
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
				<a class="nav-link panel active" data-toggle="tab" href="#page1" aria-controls="page1" aria-selected="true">計畫簡介</a>
			</li>
            <li class="nav-item">
				<a class="nav-link panel" data-toggle="tab" href="#page2" aria-controls="page2" aria-selected="false">參與者說明書</a>
			</li>
			<li class="nav-item">
				<a class="nav-link panel" data-toggle="tab" href="#page3" aria-controls="page3" aria-selected="false">研究團隊與聯絡資訊</a>
			</li>
		</ul>
        
        <div class="tab-content">
            <div id="page1" class="tab-pane show active" role="tabpanel">
                <div class="card">
                    <div class="card-header"><b>計畫簡介</b></div>
                    <div class="card-body">
				    台灣社會的宗教活動蓬勃發展，不論是佛教團體的志工，還是民間信仰信徒主動發心的儀式活動義工，都為台灣社會的宗教注入相當高的活力。隨著 3C 時代的來臨，新的溝通模式創造了更多組織動員的新可能，也讓宗教參與的型態更為豐富。
                    <br><br>
				    為瞭解這群發心自願參與宗教活動的義工，如何在宗教參與及日常生活間達到平衡？平時如何獲得訊息？彼此如何溝通、互動？有何心靈上的收穫？
                    <br><br>
				    中研院統計所及社會所計畫進行一項線上填答的研究，希望（定期或不定期）參與宗教服務活動的人，能定期在線上填答簡單問卷，讓我們更瞭解台灣宗教發展背後的活力如何產生。本研究將提供微薄的回饋作為答謝，謝謝您發心參與！
                    <br>					
				    </div>
                </div>
            </div>
            
            <div id="page2" class="tab-pane show" role="tabpanel">
                <div class="card">
                    <div class="card-header"><b>參與者說明書</b></div>
                    <div class="card-body" style="text-align: center">
                    <img style="width: 33vmin" src="./pic/cry.png"><br>
                    內容待補					
				    </div>
                </div>
            </div>
            
            <div id="page3" class="tab-pane show" role="tabpanel">
                <div class="card">
                    <div class="card-header"><b>研究團隊與聯絡資訊</b></div>
                    <div class="card-body">
                        <p>
                            ▼ 點擊姓名即可進入個人網站
                        </p>
                        <p style="font-size: 1.2em; text-align: center">
                            <a href="https://***" target="_blank">***</a>
                            <a href="https://***" target="_blank">***</a>
                            <a href="https://***" target="_blank">***</a>
                            <a href="https://***" target="_blank">***</a>
                            <a href="https://***" target="_blank">***</a>
                            <a href="https://***" target="_blank">***</a>
                            <a href="https://***" target="_blank">***</a>
                        </p>
                        <p>
                            ▼ 專用聯絡信箱
                        </p>
                        <div style="font-size: 1.2em; text-align: center">
                            <a href="mailto: ***@stat.sinica.edu.tw">***@stat.sinica.edu.tw</a>
                        </div>			
				    </div>
                </div>
            </div>
        </div>
    </div>
		
	<?php include("footer.php");?>
</body>
</html>

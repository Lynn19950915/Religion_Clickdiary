<?php
    session_start();
	include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>手機桌面捷徑教學</title>
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
		html, body{
            height: 100%;
            background-color: #E9CCD3;
            font-family: Microsoft JhengHei;
		}
        
        /* STRUCTURE */
        .container{
            height: 100%;
			align-content: center;
		}
        
		.wrapper{
            min-height: 100%; width: 100%;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
		}
        
        #formContent{
            width: 70%; padding: 2em 2em 1em 2em;
            background-color: #FFFFFF;
            position: relative; text-align: center;
            -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3); box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3); -webkit-border-radius: 15px; border-radius: 15px; 
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
            font-size: 0.9em; text-align: left;
		}   
        
        /* DETAILED */
        .panel{
            color: #000000;
            -webkit-border-radius: 10px 10px 0px 0px; border-radius: 10px 10px 0px 0px;
        }
        
        .panel:hover, .panel:focus{
            color: #E9CCD3;
            background-color: #E9CCD3;
        }
        
        .pic{
			width: 20em; padding: 1em 1.5em;
		}
        
        .icon{
			width: 7.5em; height: 5em;
		}

        *:focus {
		    outline: none;
		}
        
		/* RESPONSIVE */
		@media screen and (max-width: 800px){
            #formContent{
                width: 95%;
                font-size: 0.8em;
            }
            
            .card-body{
                padding: 5%;
            }
            
            .icon{
                width: 5.25em; height: 3.5em;
            }
		}
	</style>
    
    <script>
		$(document).ready(function(){
            $("#back").on("click", function(event){
                event.preventDefault();
			    window.location.href="./index.php";
			})
        })
	</script>
</head>


<body>
    <div class="container">
    <div class="wrapper">
        <div id="formContent">
            <ul class="nav justify-content-center" style="letter-spacing: 0.05em">
                <li class="nav-item">
				    <a class="nav-link panel active" data-toggle="tab" href="#page1" aria-controls="page1" aria-selected="true">Android 版本</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link panel" data-toggle="tab" href="#page2" aria-controls="page2" aria-selected="false">iOS 版本</a>
                </li>
            </ul>
        
            <div class="tab-content">
                <div id="page1" class="tab-pane show active" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><b>apk 下載安裝</b></div>
                        <div class="card-body">
                            <a href="./cdiary3.apk" download>按此下載</a>手機捷徑 apk (Android)<br>
                            下載後完成安裝，即自動建立桌面捷徑。		
				        </div>
                    </div><br>
                
                    <div class="card">
                        <div class="card-header"><b>手動建立桌面捷徑</b></div>
                        <div class="card-body">
                            1. 利用 Chrome 瀏覽器開啟<a href="http://cdiary3.tw" target="_blank">點日記首頁</a>，並點選畫面上方按鈕。
                            <p><center><img class="pic" src="./pic/android1.png"></center></p>
                            2. 選擇「加入主畫面」功能，並點選「新增」，即可將捷徑加入手機桌面。
                            <p><center><img class="pic" src="./pic/android2.png"><img class="pic" src="./pic/android3.png"></center></p>
                            3. 點選此捷徑，即可快速進入宗教點日記 3.0。
                            <div><center><img class="pic" src="./pic/android4.png"></center></div>
				        </div>
                    </div>
                </div>
            
                <div id="page2" class="tab-pane show" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><b>手動建立桌面捷徑</b></div>
                        <div class="card-body">
                            <p>請務必先開啟 safari 瀏覽器，並進入<a href="http://cdiary3.tw" target="_blank">點日記首頁</a>。</p>
                            1. 點選此圖示按紐（因版本不同，可能出現在畫面上方或下方）。
                            <p><center><img class="pic" src="./pic/iOS1.png"></center></p>
                            2. 在選單底部上往右滑動，選擇「加入主畫面」功能，並點選「新增」，即可將捷徑加入手機桌面。<br>
                            ※ 若找不到按鈕，可先切換為「電腦版網站」。
                            <p><center><img class="pic" src="./pic/iOS2.png"><img class="pic" src="./pic/iOS3.png"></center></p>
                            3. 點選此捷徑，即可快速進入宗教點日記 3.0。
                            <div><center><img class="pic" src="./pic/iOS4.png"></center></div>
				        </div>
                    </div>
                </div>
            </div><br>
            
            <button id="back" class="btn">
                <img src="./pic/back.png" class="icon">
            </button>
        </div>
    </div>
    </div>
</body>
</html>

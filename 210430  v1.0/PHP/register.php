<?php
    session_start();
	include "db.php";

    if(isset($_POST["username"])){
        $sql1="SELECT * FROM `account` WHERE username= :v1";
        $stmt=$db->prepare($sql1);
		$stmt->bindParam(":v1", $_POST["username"]);
		$stmt->execute();
        $rs1=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if($stmt->rowCount()==1){
			echo "Username Existed";
		}else{
            $vcode=randomNumber();
            $valid_time=date("Y-m-d H:i:s", strtotime("15 minute"));
            
            $sql2="INSERT INTO `pw_forget_param` VALUES (NULL, :v1, :v2, :v3)";
			$stmt=$db->prepare($sql2);
			$stmt->bindParam(":v1", $_POST["username"]);
			$stmt->bindParam(":v2", $vcode);
			$stmt->bindParam(":v3", $valid_time);
            
            try{
                $stmt->execute();
            
                include("mail_function.php");
                $sendername="中央研究院-宗教點日記團隊";
                $receiver=$_POST["username"];
                $subject="歡迎加入宗教點日記 3.0";
                $body="親愛的會員您好：<br>
                      感謝您參與宗教點日記 3.0 研究計畫，請點擊以下網址啟用會員帳號：<br>
                      <a href='http://cdiary3.tw/verify.php?param={$vcode}'>http://cdiary3.tw/verify.php?param={$vcode}</a>";            
            
                Send_Gmail($sender="***", $sendername, $receiver, $subject, $body);
                Send_WebMail($sender="***", $sendername, $receiver, $subject, $body);
                echo "Sendmail Success";
            }catch(Exception $e){
                echo $e->getMessage()."<br>";
            }
        }
        exit();
    }

    function randomNumber($length=10, $validCharacters="0123456789"){
		$validCharNumber=strlen($validCharacters);
		$result="";
		for($i=0; $i<$length; $i++){
            $index=mt_rand(0, $validCharNumber-1);
            $result.=$validCharacters[$index];
		}
		return $result;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>會員註冊</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
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
        
        .card-body, .agree{
		    line-height: 1.75em; letter-spacing: 0.1em;
            font-size: 0.9em; text-align: left;
		}   
        
        /* DETAILED */        
        .agree{
            letter-spacing: 0.05em;
            text-align: center;
        }
        
        #back, #startRegist{
            margin: -0.5em;
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
            
            $("#registerForm").on("submit", function(event){
				event.preventDefault();
                $("#startRegist").attr("disabled", true);
                var agree=$("#agree").is(":checked")?1 :0;
                               
                if(agree!=1){
                    $("#startRegist").attr("disabled", false);
                    $.alert({
					    title: "",
					    content: "請先勾選下方文字！",
					})
                }else{
                    $.ajax({ 
				        type: "POST",
				        url: "",
				        data: $('#registerForm').serialize(),
                        success: function(data){ 
                            console.log(data);
                            
				            if(data=="Username Existed"){
                                $("#startRegist").attr("disabled", false);
                                $.alert({
								    title: "帳號已註冊",
								    content: "此 Email 帳號已被註冊，請修正！",
                                })
                            }else if(data=="Sendmail Success"){
                                $.alert({
								    title: "寄信成功",
								    content: "已寄發驗證信，請至 Email 信箱點選信中的連結，以設定密碼。",
                                })
                            }
                        }, error: function(e){
                            console.log(e);
                        }
                    })    
                }
			})
        })
	</script>
</head>


<body>
	<div class="container">
    <div class="wrapper">
        <div id="formContent">
            <div class="card">
                <div class="card-header"><b>宗教點日記 3.0 簡介</b></div>
				<div class="card-body">
				    台灣社會的宗教活動蓬勃發展，不論是佛教團體的志工，還是民間信仰信徒主動發心的儀式活動義工，都為台灣社會的宗教注入相當高的活力。隨著 3C 時代的來臨，新的溝通模式創造了更多組織動員的新可能，也讓宗教參與的型態更為豐富。
                    <br><br>
					為瞭解這群發心自願參與宗教活動的義工，如何在宗教參與及日常生活間達到平衡？平時如何獲得訊息？彼此如何溝通、互動？有何心靈上的收穫？
                    <br><br>
					中研院統計所及社會所計畫進行一項線上填答的研究，希望（定期或不定期）參與宗教服務活動的人，能定期在線上填答簡單問卷，讓我們更瞭解台灣宗教發展背後的活力如何產生。本研究將提供微薄的回饋作為答謝，謝謝您發心參與！				
				</div>
            </div><br>
            
            <div class="card">
                <div class="card-header"><b>參與方式及獎勵金說明</b></div>
				<div class="card-body">
                    <div>▼ 您在參與期間，所需提供：</div><br>
                    <p>
                        1. 個人資料表<br>
                        首次登入時，需先完成一份簡單的個人資料填寫。
                    </p>
                    <p>
                        2. 生活日記<br>
                        每日例行填寫，內容主要包含「宗教訊息互動」與「宗教活動參與」，約五分鐘內可完成。<br>
                        注意：每週請至少擇 2~3 天完成，<span style="padding: 0.25em; color: #FFFFFF; background-color: #2E317C">參與宗教活動的當天請務必填寫</span>。
                    </p>
                    <div>
                        3. 接觸紀錄<br>
                        日常接觸之互動紀錄，單日可填寫多筆。唯每新增一位接觸對象時，均需完成一份「接觸對象基本資料表」。<br>
                    </div>
                    <hr>
                    <div>▼ 會員符合以下條件者，每月底結算後可獲得獎勵金回饋：</div><br>
                    <div>
                        1. 每個月需有<span style="padding: 0.25em; color: #FFFFFF; background-color: #2E317C">20 個不同人次</span>的接觸量。<br>
                        2. 每週填寫達 2 次者，每月發給獎勵金 500 元。<br>
                        3. 每週填寫達 4 次者，每月發給獎勵金 1000 元。
                    </div>
				</div>
            </div><br>
            
            <form id="registerForm">
            <p class="agree">
                <input id="agree" type="checkbox"> 本人已詳閱以上說明並同意參與研究計畫
            </p>
            <div style="font-size: 0.9em; letter-spacing: 0.05em">請輸入您的信箱：<input name="username" type="email" required><br><br></div>
                
            <button id="back" class="btn">
                <img src="./pic/back.png" class="icon">
            </button>
            <button id="startRegist" class="btn">
                <img src="./pic/submit.png" class="icon">
            </button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>

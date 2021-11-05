<?php
    session_start();
	include "db.php";

	if(isset($_POST["username"])){
		$password=isset($_POST["password1"])?$_POST["password1"]: $_POST["password2"];
		$password_encoded=base64_encode($password);

		$sql1="SELECT * FROM `account` WHERE username= :v1";
		$stmt=$db->prepare($sql1);
		$stmt->bindParam(":v1", $_POST["username"]);
		$stmt->execute();
		$rs1=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount()==0){
			echo "Invalid Username";
		}else if($password_encoded!=$rs1["password"]){
			echo "Wrong Password";
		}else{ 
            $sql2="UPDATE `account` SET last_login= NOW() WHERE username= :v1";
            $stmt=$db->prepare($sql2);
            $stmt->bindParam(":v1", $_POST["username"]);
            $stmt->execute();
            
            $_SESSION["acc_info"]=$rs1;
            if($rs1["reg_status"]==1){
                echo "Profile Undone";
            }else{
                echo "Profile Done";
            }
		}
        exit();
	}

    if(isset($_POST["email"])){        
        $sql3="SELECT * FROM `account` WHERE username= :v1";
        $stmt=$db->prepare($sql3);
		$stmt->bindParam(":v1", $_POST["email"]);
		$stmt->execute();
        $rs3=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if($stmt->rowCount()==0){
			echo "Invalid Username";
		}else{
            $vcode=randomNumber();
            $valid_time=date("Y-m-d H:i:s", strtotime("15 minute"));
            
            $sql4="INSERT INTO `pw_forget_param` VALUES (NULL, :v1, :v2, :v3)";
			$stmt=$db->prepare($sql4);
			$stmt->bindParam(":v1", $_POST["email"]);
			$stmt->bindParam(":v2", $vcode);
			$stmt->bindParam(":v3", $valid_time);
            
            try{
                $stmt->execute();
            
                include("mail_function.php");
                $sendername="中央研究院-宗教點日記團隊";
                $receiver=$_POST["email"];
                $subject="宗教點日記 3.0：密碼重置連結";
                $body="親愛的會員您好：<br>
                    請於 15 分鐘內進入以下連結，以重置您的宗教點日記登入密碼<br>
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
	<title>宗教點日記 3.0</title>
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
            height: 100%; letter-spacing: 0.05em;
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
            width: 50%; padding: 2em 2em 1em 2em;
            background-color: #FFFFFF;
            position: relative; text-align: center;
            -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3); box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3); -webkit-border-radius: 15px; border-radius: 15px; 
		}
        
        #formFooter{
            text-align: center;
        }
        
        /* DETAILED */
        .form-group{
            justify-content: center;
		}
        
        hr{
            height: 0.1em; border: 0;
            background-color: #E9CCD3;
        }
        
        input[type=email], input[type=password], input[type=text]{
            width: 60%; padding: 0.5em; border: 0;
            color: black; background-color: #F0F5E5;
            font-size: 1em; text-align: center; display: inline-block;
            -webkit-border-radius: 5px; border-radius: 5px;
		}

		input[type=email]:focus, input[type=password]:focus, input[type=text]:focus{
            border: 2.5px solid #E9CCD3;
		}
        
        a{
            color: #E9CCD3;
        }
        
        .logo{
			width: 3em; height: 2.5em; padding: 0% 1.5%;
		}
        
        #signIn, #register{
            margin: -0.5em;
        }

		.icon{
			width: 7.5em; height: 5em;
		}
        
        #emailReset{
            top: 25vmin;
        }
        
        *:focus {
		    outline: none;
		}
    
		/* ANIMATIONS */
        @-webkit-keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
		@-moz-keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
		@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .fadeIn{
            opacity: 0;
            -webkit-animation:fadeIn ease-in 1; -moz-animation:fadeIn ease-in 1; animation:fadeIn ease-in 1;
            -webkit-animation-duration: 1s; -moz-animation-duration: 1s; animation-duration: 1s;
            -webkit-animation-fill-mode: forwards; -moz-animation-fill-mode: forwards; animation-fill-mode: forwards;
		}

		.fadeIn.first{
            -webkit-animation-delay: 0.1s; -moz-animation-delay: 0.1s; animation-delay: 0.1s;
		}
		.fadeIn.second{
            -webkit-animation-delay: 0.3s; -moz-animation-delay: 0.3s; animation-delay: 0.3s;
		}
		.fadeIn.third{
            -webkit-animation-delay: 0.5s; -moz-animation-delay: 0.5s; animation-delay: 0.5s;
		}
		.fadeIn.fourth{
            -webkit-animation-delay: 0.7s; -moz-animation-delay: 0.7s; animation-delay: 0.7s;
		}
        
        /* RESPONSIVE */
		@media screen and (max-width: 800px){
            #formContent{
                width: 95%; line-height: 0.85em;
                font-size: 0.8em;
            }
            
            logo{
                width: 1.5em; height: 1.25em;
            }
            
            .icon{
                width: 5.25em; height: 3.5em;
            }
            
            h4{
                font-size: 1.375em;
            }

            #service, #reset{
                padding: 2%;
            }
            
            #emailReset{
                top: 35vmax;
            }
            
            h5{
                font-size: 1.125em;
            }
		}
	</style>
    
	<script>
		$(document).ready(function(){
            $("#eye1").on("click", function(event){
			    event.preventDefault();
                var password1=$("#password1").val();
			    $("#password1").replaceWith(`<input id="password2" name="password2" type="text" value="${password1}">`);
                $("#eye1").hide();
                $("#eye2").show();
			})
            
            $("#eye2").on("click", function(event){
			    event.preventDefault();
                var password2=$("#password2").val();
			    $("#password2").replaceWith(`<input id="password1" name="password1" type="password" value="${password2}">`);
                $("#eye1").show();
                $("#eye2").hide();
			})
            
            $("#loginForm").on("submit", function(event){
			    event.preventDefault();
                $("#signIn").attr("disabled", true);
                
                $.ajax({ 
                    type: "POST",
                    url: "",
                    data: $("#loginForm").serialize(),
                    success: function(data){ 
                        console.log(data);
                        
                        if(data=="Invalid Username"){
                            $("#signIn").attr("disabled", false);
                            $.alert({
								title: "帳號未註冊",
								content: "此 Email 帳號尚未註冊，請修正！",
                            })
                        }else if(data=="Wrong Password"){
                            $("#signIn").attr("disabled", false);
                            $.alert({
                                title: "密碼錯誤",
                                content: "密碼不正確，請重新輸入！",
                            })
                        }else if(data=="Profile Undone"){
                            window.location.href="./profile.php";
                        }else{
                            window.location.href="./main.php";
                        }
                    }, error: function(e){
                        console.log(e);
                    }
                })
            })  

            $("#register").on("click", function(event){
			    event.preventDefault();
			    window.location.href="./register.php";
			})
            
            $("#reset").on("click", function(event){
			    event.preventDefault();
			    $("#emailReset").modal("show");
			})
            
            $("#resetForm").on("submit", function(event){
				event.preventDefault();
                $("#startReset").attr("disabled", true);
                
                $.ajax({ 
				    type: "POST",
				    url: "",
				    data: $("#resetForm").serialize(),
                    success: function(data){ 
                        console.log(data);
                        
				        if(data=="Invalid Username"){
                            $("#startReset").attr("disabled", false);
                            $.alert({
								title: "帳號未註冊",
								content: "此 Email 帳號尚未註冊，請修正！",
                            })
                        }else if(data=="Sendmail Success"){
                            $.alert({
								title: "寄信成功",
								content: "已寄發驗證信，請至 Email 信箱點選信中的連結，以重置密碼。",
                            })
                        }
                    }, error: function(e){
                        console.log(e);
                    }
                })
            })  
    	})
	</script>
</head>


<body>
	<div class="container">
    <div class="wrapper">
        <div id="formContent">
        <div class="fadeIn first">
            <h4><img src="./pic/logo.png" class="logo">
            <span class="logo_title" style="color: #EEB8C3"><b>宗教點日記 3.0</b></span></h4><hr>
        </div>

        <form id="loginForm">
            <div class="input-group form-group fadeIn second">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input name="username" type="email" placeholder="請輸入帳號 (Email)" required>
            </div>
        
            <div class="input-group form-group fadeIn second">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="password1" name="password1" type="password" placeholder="請輸入密碼" required>
                <button id="eye1" ><i class="fas fa-eye"></i></button>
                <button id="eye2" style="display: none"><i class="fas fa-eye-slash"></i></button>
            </div>
            
            <button id="signIn" class="btn fadeIn third">
                <img src="./pic/sign_in.png" class="icon">
            </button>
            <button id="register" class="btn fadeIn third">
                <img src="./pic/register.png" class="icon">
            </button>
        </form>
        
        <div id="formFooter" class="fadeIn fourth">
            <hr><p>
                <a href="./desktop.php" style="color: #2E317C"><b>建立手機桌面捷徑</b></a>
            </p>
            <p>
                有任何疑問？<button id="service" style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>我要來信</b></button>
            </p>
            <p>
                無法登入嗎？<button id="reset" style="border: none"><b>密碼重置</b></button>
            </p>    
        </div>
            
        <div id="emailReset" class="modal fade">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="background-color: yellow">⭐ 請輸入您的信箱 ⭐</h5>
                    <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                
                <div class="modal-body" style="padding: 2em 2em 1em 2em">
                    <form id="resetForm">
                    <input name="email" type="email" required><br><br>
                    <button id="startReset" class="btn">
                        <img src="./pic/submit.png" class="icon">
                    </button>
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</body>
</html>

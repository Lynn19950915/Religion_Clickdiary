<?php
    session_start();
    include("db.php");
    $vcode=isset($_GET["param"])?$_GET["param"]: 0;

    if(isset($_POST["checkVerify"])){
        $sql1="SELECT * FROM `pw_forget_param` WHERE param= :v1 and valid_time>= NOW()";
        $stmt=$db->prepare($sql1);
        $stmt->bindParam(":v1", $vcode);
        $stmt->execute();
        $rs1=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if($stmt->rowCount()==0){
            echo "Error";
        }else{
            echo $rs1["id"];
        }
        exit();
    }

    if(isset($_POST["username"])){
		$password=isset($_POST["password1"])?$_POST["password1"]: $_POST["password2"];
		$password_encoded=base64_encode($password);
        
        $sql2="SELECT * FROM `account` WHERE username= :v1";
        $stmt=$db->prepare($sql2);
		$stmt->bindParam(":v1", $_POST["username"]);
		$stmt->execute();
		$rs2=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount()==0){
			$sql3="INSERT INTO `account` VALUES (NULL, :v1, :v2, 1, NOW(), NULL, NULL, 999, NULL, 0)";
            $stmt=$db->prepare($sql3);
            $stmt->bindParam(":v1", $_POST["username"]);
            $stmt->bindParam(":v2", $password_encoded);
            $stmt->execute();
		}else{
            $sql4="UPDATE `account` SET password= :v1 WHERE username= :v2";
            $stmt=$db->prepare($sql4);
            $stmt->bindParam(":v1", $password_encoded);
            $stmt->bindParam(":v2", $_POST["username"]);
            $stmt->execute();
        }   
        echo "Register Success";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>密碼設定</title>
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
        
        /* DETAILED */
        .form-group{
		    justify-content: center;
		}
        
        hr{
            height: 1.5px; border: 0;
            background-color: #E9CCD3;
        }
        
        input[type=email], input[type=password], input[type=text]{
            width: 60%; padding: 0.5em; border: 0;
            color: black; background-color: #F0F5E5;
            font-size: 1em; text-align: center; display: inline-block;
            -webkit-border-radius: 5px; border-radius: 5px;
		}

		input[type=password]:focus, input[type=text]:focus{
            border: 2.5px solid #E9CCD3;
		}
        
        a{
            color: #E9CCD3;
        }
        
        .logo{
			width: 3em; height: 2.5em; padding: 0% 1.5%;
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
            
            logo{
                width: 1.5em; height: 1.25em;
            }
            
            .icon{
                width: 5.25em; height: 3.5em;
            }
            
            h4{
                font-size: 1.375em;
            }
		}
	</style>
    
    <script>
		$(document).ready(function(){
            $.ajax({ 
               type: "POST",
               url: "",
               data: {checkVerify: 1},
               success: function(data){
                   console.log(data);
                   
                   if(data=="Error"){
                       $("#register").attr("disabled", true);
                       $.alert({
                            title: "",
                            content: "驗證碼錯誤或已超時失效，請重試！",
                        })
                   }else{
                       $("input[name='username']").val(data);
                   }
                }, error: function(e){
                    console.log(e);
                }     
            })
            
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
            
            $("#eye3").on("click", function(event){
			    event.preventDefault();
                var password3=$("#password3").val();
			    $("#password3").replaceWith(`<input id="password4" name="password4" type="text" value="${password3}">`);
                $("#eye3").hide();
                $("#eye4").show();
			})
            
            $("#eye4").on("click", function(event){
			    event.preventDefault();
                var password4=$("#password4").val();
			    $("#password4").replaceWith(`<input id="password3" name="password3" type="password" value="${password4}">`);
                $("#eye3").show();
                $("#eye4").hide();
			})
            
            $("#passwordForm").on("submit", function(event){
			    event.preventDefault();
                $("#register").attr("disabled", true);
                
                var password1=$("#password1").val();
                if(!password1){var password1=$("#password2").val()};
                var password2=$("#password3").val();
                if(!password2){var password2=$("#password4").val()};
                
                if(!password1){
                    $("#register").attr("disabled", false);
                    $.alert({
                        title: "",
                        content: "密碼長度過短（至少 6 碼）。",
                    }) 
                }else if(password1.length<6){
                    $("#register").attr("disabled", false);
                    $.alert({
                        title: "",
                        content: "密碼長度過短（至少 6 碼）。",
                    }) 
                }else if(password1!=password2){
                    $("#register").attr("disabled", false);
                    $.alert({
                        title: "",
                        content: "兩次輸入密碼不一致，請重新確認！",
                    })
                }else{
                    $.ajax({ 
                        type: "POST",
                        url: "",
                        data: $("#passwordForm").serialize(),
                        success: function(data){
                            console.log(data);
                            
                            if(data=="Register Success"){
                                $.confirm({
                                    title: "設定成功",
                                    content: "密碼已完成設定，立即登入系統吧！",
                                    buttons:{
								        "GO": function(){
								            window.location.href="./index.php";
								        }
								    }   
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
            <div>
                <h4><img src="./pic/logo.png" class="logo">
                <span class="logo_title" style="color: #EEB8C3"><b>密碼設定</b></span></h4><hr>
            </div>
            
            <form id="passwordForm">
            <div class="input-group form-group">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input name="username" type="email" style="background-color: #F0F5E5; cursor: not-allowed" readonly>
            </div>
        
            <div class="input-group form-group">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="password1" name="password1" type="password" placeholder="請輸入密碼（至少 6 碼）" required>
                <button id="eye1"><i class="fas fa-eye"></i></button>
                <button id="eye2" style="display: none"><i class="fas fa-eye-slash"></i></button>
            </div>
                
            <div class="input-group form-group">
				<div class="input-group-prepend">
				<span class="input-group-text"><i class="fas fa-key"></i></span>
				</div>
				<input id="password3" name="password3" type="password" placeholder="請再次確認密碼" required>
                <button id="eye3"><i class="fas fa-eye"></i></button>
                <button id="eye4" style="display: none"><i class="fas fa-eye-slash"></i></button>
            </div>
            
            <button id="register" class="btn">
                <img src="/pic/submit.png" class="icon">
            </button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>

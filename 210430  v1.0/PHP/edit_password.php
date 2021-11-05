<?php
	session_start();
	include("db.php");

    if(!$_SESSION["acc_info"]["id"]){
		header("Location: ./index.php");
    }
    if(isset($_POST["checkStatus"])){
        if($_SESSION["acc_info"]["reg_status"]!=2){
            echo "Error";
        }
        exit();
    }

    if(isset($_POST["username"])){
        $oldpassword=isset($_POST["oldpassword1"])?$_POST["oldpassword1"]: $_POST["oldpassword2"];
		$oldpassword_encoded=base64_encode($oldpassword);
        $newpassword=isset($_POST["newpassword1"])?$_POST["newpassword1"]: $_POST["newpassword2"];
		$newpassword_encoded=base64_encode($newpassword);
		$now=date("Y-m-d H:i:s");
        
        $sql1="SELECT * FROM `account` WHERE username= :v1 and password= :v2";
		$stmt=$db->prepare($sql1);
		$stmt->bindParam(":v1", $_POST["username"]);
        $stmt->bindParam(":v2", $oldpassword_encoded);
		$stmt->execute();
		$rs1=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount()==0){
			echo "Wrong Password";
		}else{
            $sql2="UPDATE `account` SET password= :v1 WHERE username= :v2";
            $stmt=$db->prepare($sql2);
            $stmt->bindParam(":v1", $newpassword_encoded);
            $stmt->bindParam(":v2", $_POST["username"]);
            $stmt->execute();
            
            echo "Edit Success";
        }
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>密碼變更</title>
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
        .modal{
            top: 25vmin; letter-spacing: 0.05em;
        }
        
        .modal-body{
            padding: 2em 2em 0em 2em;
            font-size: 1.05em; text-align: left;
        }
        
        .container{
			width: 50%; margin: 40px auto;
			align-content: center;
		}
        
        .card-header{
            letter-spacing: 0.05em;
            text-align: left;
        }
        
        .card-body{
		    line-height: 1.75em; letter-spacing: 0.1em; padding-bottom: 0.5em;
            font-size: 0.95em; text-align: left;
		}

        /* DETAILED */
        .sheep1{
            width: 7.5em; margin: 0 3.75% 0% 10%;
            float: left;
        }
        
        .sheep2{
            width: 7.5em; margin: 0 5% 0% 10%;
            float: left;
        }
        
        .icon{
			width: 7.5em; height: 5em;
		}
        
        *:focus {
		    outline: none;
		}
        
        /* RESPONSIVE */
		@media screen and (max-width: 800px){
            .modal{
                top: 30vmax;
            }
            
            .modal-body{
                line-height: 1.25em;
                font-size: 0.8em; text-align: center;
            }
            
            .container{
                width: 90%; margin: 10px auto;
                font-size: 0.8em;
            }
            
            .card-body{
                line-height: 2em;
            }
            
            .imgwrap{
                display: flex; text-align: center;
            }
            
            .sheep1, .sheep2{
                width: 5em; margin: 0px auto;
            }
            
            .icon{
                width: 6em; height: 4em;
            }
            
            h5{
                font-size: 1em;
            }

            .col-sm-4{
                width: auto;
            }
            
            .col-sm-6{
                width: 75%;
                margin-left: 8%;
            }
		}
	</style>
    
	<script>
		$(document).ready(function(){
            $.ajax({ 
               type: "POST",
               url: "",
               data: {checkStatus: 1},
               success: function(data){
                   console.log(data);
                   
                   if(data=="Error"){
                       $("#error").modal("show");
                       setTimeout("window.location.href='./profile.php'", 5000);
                   }
                }, error: function(e){
                    console.log(e);
                }     
            })
            
            $("#eye1").on("click", function(event){
			    event.preventDefault();
                var oldpassword1=$("#oldpassword1").val();
			    $("#oldpassword1").replaceWith(`<input id="oldpassword2" name="oldpassword2" type="text" class="col-sm-6" value="${oldpassword1}">`);
                $("#eye1").hide();
                $("#eye2").show();
			})
            
            $("#eye2").on("click", function(event){
			    event.preventDefault();
                var oldpassword2=$("#oldpassword2").val();
			    $("#oldpassword2").replaceWith(`<input id="oldpassword1" name="oldpassword1" type="password" class="col-sm-6" value="${oldpassword2}">`);
                $("#eye1").show();
                $("#eye2").hide();
			})
            
            $("#eye3").on("click", function(event){
			    event.preventDefault();
                var newpassword1=$("#newpassword1").val();
			    $("#newpassword1").replaceWith(`<input id="newpassword2" name="newpassword2" type="text" class="col-sm-6" value="${newpassword1}">`);
                $("#eye3").hide();
                $("#eye4").show();
			})
            
            $("#eye4").on("click", function(event){
			    event.preventDefault();
                var newpassword2=$("#newpassword2").val();
			    $("#newpassword2").replaceWith(`<input id="newpassword1" name="newpassword1" type="password" class="col-sm-6" value="${newpassword2}">`);
                $("#eye3").show();
                $("#eye4").hide();
			})
            
            $("#eye5").on("click", function(event){
			    event.preventDefault();
                var newpassword3=$("#newpassword3").val();
			    $("#newpassword3").replaceWith(`<input id="newpassword4" name="newpassword4" type="text" class="col-sm-6" value="${newpassword3}">`);
                $("#eye5").hide();
                $("#eye6").show();
			})
            
            $("#eye6").on("click", function(event){
			    event.preventDefault();
                var newpassword4=$("#newpassword4").val();
			    $("#newpassword4").replaceWith(`<input id="newpassword3" name="newpassword3" type="password" class="col-sm-6" value="${newpassword4}">`);
                $("#eye5").show();
                $("#eye6").hide();
			})

            $("#editPasswordForm").on("submit", function(event){
			    event.preventDefault();
                $("#editPassword").attr("disabled", true);
                var newpassword1=$("#newpassword1").val();
                if(!newpassword1){var newpassword1=$("#newpassword2").val()};
                var newpassword2=$("#newpassword3").val();
                if(!newpassword2){var newpassword2=$("#newpassword4").val()};
                
                if(newpassword1.length<6){
                    $("#editPassword").attr("disabled", false);
                    $.alert({
                        title: "",
                        content: "密碼長度過短（至少 6 碼）。",
                    }) 
                }else if(newpassword1!=newpassword2){
                    $("#editPassword").attr("disabled", false);
                    $.alert({
                        title: "",
                        content: "兩次輸入密碼不一致，請重新確認！",
                    })
                }else{
                    $.ajax({ 
                        type: "POST",
                        url: "",
                        data: $("#editPasswordForm").serialize(),
                        success: function(data){
                            console.log(data);
                            
                            if(data=="Wrong Password"){
                                $("#editPassword").attr("disabled", false);
                                $.alert({
								    title: "舊密碼錯誤",
								    content: "舊密碼不正確，請重新輸入！",
                                })
                            }else if(data=="Edit Success"){
                                $("#success").modal("show");
                                setTimeout("window.location.href='./index.php'", 5000);
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
	<?php include("header.php");?>
    
    <div id="error" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: black; color: #FFFFFF">💔 功能尚未解鎖 💔</h5>
            </div>
                
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep1" src="./pic/error.png"></div>
                <p>
                    <br>請先完成 <b><a href="./profile.php">個人資料填寫</a></b>，才能解鎖本頁功能唷！
                    <br><br>
                    系統出現異常？<button style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>回報客服人員</b></button>
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❿</div>
        </div>
        </div>
    </div>
    
    <div id="success" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: yellow">⭐ 更新完成 ⭐</h5>
            </div>
            
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/greeting.png"></div>
                <p>
                    <br>密碼已成功變更，請重新登入系統！
                    <br><br>
                    5 秒後將為您導回：登入頁
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❼</div>
        </div>
        </div>
    </div>
    
    <div class="container">
        <div class="card" style="border: 0.1em #E9CCD3 solid">
            <div class="card-header" style="background-color: #E9CCD3; color: #2E317C"><b>密碼變更</b></div>
            <div class="card-body">
                <form id="editPasswordForm" style="padding-bottom: -1em">
                <p>
                    ▼ 請輸入以下資訊來變更您的密碼
                </p>
                <div class="row" style="padding-bottom: 1em">
                    <div class="col-sm-4" style="text-align: right">帳號(Email)：</div>
                    <input id="username" name="username" type="email" class="col-sm-6" value="<?=$_SESSION['acc_info']['username']?>" style="background-color: #F0F5E5; cursor: not-allowed" readonly>
                </div>
                <div class="row" style="padding-bottom: 1em">
                    <div class="col-sm-4" style="text-align: right">舊密碼：</div>
                    <input id="oldpassword1" name="oldpassword1" type="password" class="col-sm-6" required>
                    <button id="eye1"><i class="fas fa-eye"></i></button>
                    <button id="eye2" style="display: none"><i class="fas fa-eye-slash"></i></button>
                </div>
                <div class="row" style="padding-bottom: 1em">
                    <div class="col-sm-4" style="text-align: right">新密碼：</div>
                    <input id="newpassword1" name="newpassword1" type="password" class="col-sm-6" placeholder="至少 6 碼" required>
                    <button id="eye3"><i class="fas fa-eye"></i></button>
                    <button id="eye4" style="display: none"><i class="fas fa-eye-slash"></i></button>
                </div>
                <div class="row" style="padding-bottom: 1em">
                    <div class="col-sm-4" style="text-align: right">確認新密碼：</div>
                    <input id="newpassword3" name="newpassword3" type="password" class="col-sm-6" placeholder="至少 6 碼" required>
                    <button id="eye5"><i class="fas fa-eye"></i></button>
                    <button id="eye6" style="display: none"><i class="fas fa-eye-slash"></i></button>
                </div>
                
                <div style="text-align: center">
                    <button id="editPassword" class="btn">
                        <img src="./pic/submit.png" class="icon">
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
	<?php include("footer.php");?>
</body>
</html>

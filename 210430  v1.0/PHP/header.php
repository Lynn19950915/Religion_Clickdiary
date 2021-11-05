<?php
    $today=date("Y-m-d");

    if(isset($_POST["checkDiaries"])){
		$sqlA="SELECT COUNT(*) FROM `hdiary` WHERE id = :v1 and date= :v2";
		$stmt=$db->prepare($sqlA);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $today);
		$stmt->execute();
        $rsA=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sqlB="SELECT COUNT(*) FROM `tdiary` WHERE ego_id = :v1 and date= :v2";
		$stmt=$db->prepare($sqlB);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $today);
		$stmt->execute();
        $rsB=$stmt->fetch(PDO::FETCH_ASSOC);
        
		if($rsA["COUNT(*)"]==0&$rsB["COUNT(*)"]==0){
            echo "H+T";
        }else if($rsA["COUNT(*)"]>0&$rsB["COUNT(*)"]==0){
            echo "H done+T";
        }else if($rsA["COUNT(*)"]==0&$rsB["COUNT(*)"]>0){
            echo "H+T done";
        }else{
            echo "H done+T done";
        }
		exit();
	}
?>

<style>
    nav{
        background-color: #E9CCD3;
    }
    
    .logo{
        width: 1.75em; height: 1.5em; padding: 0% 1.5%;
    }
    
    .nav-link:hover{
        background-color: #FFFFFF;
    }
    
    .dropdown-item:hover{
        background-color: #E9CCD3;
    }

    @media screen and (max-width: 800px){
        .nav-item, .dropdown-item{
            font-size: 0.95em;
        }
        
        .navbar-brand{
            letter-spacing: 0;
            font-size: 1.125em;
        }
        
        .mr-3{
            padding: 0.3em 0;
        }
    }
</style>

<script>
	$(document).ready(function(){
        $.ajax({ 
            type: "POST",
            url: "",
            data: {checkDiaries: 1},
            success: function(data){
                console.log(data);
                
                if(data.match(/H\+T$/)){
                    $(".Hundone").show();
                    $(".Hdone").hide();
                    $(".Tundone").show();
                    $(".Tdone").hide();
                }else if(data.match(/H done\+T$/)){
                    $(".Hundone").hide();
                    $(".Hdone").show();
                    $(".Tundone").show();
                    $(".Tdone").hide();
                }else if(data.match(/H\+T done$/)){
                    $(".Hundone").show();
                    $(".Hdone").hide();
                    $(".Tundone").hide();
                    $(".Tdone").show();
                }else{
                    $(".Hundone").hide();
                    $(".Hdone").show();
                    $(".Tundone").hide();
                    $(".Tdone").show();
                }
            }, error: function(e){
                console.log(e);
            }     
        })
        
        $(document).click(function(event){
            $(".navbar-collapse").collapse("hide");    
        })
    })
</script>


<header>
	<nav class="navbar navbar-expand-lg navbar-light fixed-top">
		<a class="navbar-brand" href="./main.php" style="background-color: #FFFFFF; -webkit-border-radius: 10px; border-radius: 10px">
            <img class="logo" src="./pic/logo.png">宗教點日記<b><sub><sub>3.0</sub></sub></b>
		</a>
        
		<button class="navbar-toggler" data-toggle="collapse" data-target="#option">
			<span class="navbar-toggler-icon"></span>
		</button>
        
		<div id="option" class="collapse navbar-collapse">
			<ul class="navbar-nav">
                <li class="nav-item"><a class="func nav-link" href="./about_us.php">關於日記</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">我的日記</a>
                    <div class="dropdown-menu">
                        <a class="func dropdown-item" href="./main.php">填答概覽</a>
                        <a class="func dropdown-item Hundone" href="./hdiary.php" style="color: red">填寫生活日記 <i class="fa fa-exclamation-circle"></i></a>
                        <a class="func dropdown-item Hdone" href="./hdiary.php">填寫生活日記</a>
                        <a class="func dropdown-item Tundone" href="./alter_list.php" style="color: red">填寫接觸紀錄 <i class="fa fa-exclamation-circle"></i></a>
                        <a class="func dropdown-item Tdone" href="./alter_list.php">填寫接觸紀錄</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">帳號管理</a>
                    <div class="dropdown-menu">
                        <a class="func dropdown-item" href="./edit_profile.php">修改個人資料</a>
                        <a class="func dropdown-item" href="./edit_password.php">變更密碼</a>
                        <a class="func dropdown-item" href="./alter_list.php">管理接觸對象</a>
                    </div>
                </li>
                <li class="nav-item"><a class="func nav-link" href="./reward.php">獎勵規則</a></li>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-3"><a href="mailto: ***@stat.sinica.edu.tw" style="color: white"><b>聯絡我們</b></a></li>
				<li class="nav-item mr-3"><a href="./logout.php" style="color: white"><b>登出</b></a></li>
			</ul>
		</div>
	</nav>
</header>

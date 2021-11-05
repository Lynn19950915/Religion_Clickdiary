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

    $year=date("Y");
    $month=date("m");
    $today=date("Y-m-d");
    $last1=date("Y-m-d", strtotime("-1 day"));
    $last2=date("Y-m-d", strtotime("-2 day"));
    $last3=date("Y-m-d", strtotime("-3 day"));
    $last4=date("Y-m-d", strtotime("-4 day"));
    $last5=date("Y-m-d", strtotime("-5 day"));
    $last6=date("Y-m-d", strtotime("-6 day"));
    $time=date("H");

    if(isset($_POST["fetchData"])){        
        $sql1="SELECT COUNT(*) FROM `hdiary` WHERE id= :v1 and MONTH(date)= :v2";
        $stmt=$db->prepare($sql1);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $month);
        $stmt->execute();
        $json=array();
        $json[0]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql2="SELECT COUNT(*) FROM `group_list` WHERE id= :v1";
        $stmt=$db->prepare($sql2);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->execute();
        $json[1]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql3="SELECT COUNT(*) FROM `alter_list` WHERE ego_id= :v1";
        $stmt=$db->prepare($sql3);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->execute();
        $json[2]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql4="SELECT COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and YEAR(date)= :v2 and MONTH(date)= :v3";
        $stmt=$db->prepare($sql4);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $year);
        $stmt->bindParam(":v3", $month);
        $stmt->execute();
        $json[3]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql5="SELECT COUNT(DISTINCT date) FROM `tdiary` WHERE ego_id= :v1 and YEAR(date)= :v2 and MONTH(date)= :v3";
        $stmt=$db->prepare($sql5);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $year);
        $stmt->bindParam(":v3", $month);
        $stmt->execute();
        $json[4]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql6="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
        $stmt=$db->prepare($sql6);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last6);
        $stmt->execute();
        $json[5]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql7="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
        $stmt=$db->prepare($sql7);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last5);
        $stmt->execute();
        $json[6]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql8="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
        $stmt=$db->prepare($sql8);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last4);
        $stmt->execute();
        $json[7]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql9="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
        $stmt=$db->prepare($sql9);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last3);
        $stmt->execute();
        $json[8]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql10="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
        $stmt=$db->prepare($sql10);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last2);
        $stmt->execute();
        $json[9]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql11="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
        $stmt=$db->prepare($sql11);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last1);
        $stmt->execute();
        $json[10]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if($time<18){
            $json[11]["COUNT(*)"]=-1;
        }else{
            $sql12="SELECT date, COUNT(*) FROM `hdiary` WHERE id= :v1 and date= :v2";
            $stmt=$db->prepare($sql11);
            $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
            $stmt->bindParam(":v2", $today);
            $stmt->execute();
            $json[11]=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        $sql13="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql13);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last6);
        $stmt->execute();
        $json[12]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql14="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql14);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last5);
        $stmt->execute();
        $json[13]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql15="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql15);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last4);
        $stmt->execute();
        $json[14]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql16="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql16);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last3);
        $stmt->execute();
        $json[15]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql17="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql17);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last2);
        $stmt->execute();
        $json[16]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql18="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql18);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $last1);
        $stmt->execute();
        $json[17]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql19="SELECT date, COUNT(*) FROM `tdiary` WHERE ego_id= :v1 and date= :v2";
        $stmt=$db->prepare($sql19);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $today);
        $stmt->execute();
        $json[18]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        exit(); 
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>總覽儀表板</title>
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
    
    <!-- Progress Bar -->
	<script src="js/progressbar.js"></script>
    
	<style>
        /* BASIC */
        html{
            min-height: 100%;
            font-family: Microsoft JhengHei; position: relative;
        }
        
        /* STRUCTURE */
        .modal{
            top: 25vmin; letter-spacing: 0.05em;
        }
        
        .modal-body{
            padding: 2em 2em 0em 2em;
            font-size: 1.05em; text-align: left;
        }
        
        .todiary{
            margin: 5em 0 2em 0;
            display: flex; flex-direction: row; justify-content: center;
        }
        
        .wrapper{
            padding: 6.25%; margin-top: -7.5%; text-align: center;
        }
        
        .outer{
            display: flex; flex-direction: row; justify-content: center;
        }
        
        .dashboard1{
            width: 50%; margin: 1%;
        }
        
        .dashboard2{
            width: 35vmax; margin: 1%;
        }
        
        .wrapper1{
            padding: 5% 5% 2.5% 5%; text-align: left;
        }
        
        .wrapper2{
            padding: 2.5% 2.5% 0% 2.5%; text-align: left;
        }
        
        .twrapper1{
            width: 8%; margin: 0% auto;
            background-color: #BACF65;
            font-size: 0.9em;
        }
        
        .tbar{
            height: 13.75vmax;
        }
        
        .twrapper2{
            width: 12%; margin: 0% auto;
            font-size: 0.85em;
        }
        
        /* DETAILED */
        .btn{
            width: 10em; margin: auto 2.75%;
        }
        
        .diaryimg{
            width: 5em; margin: 10% 5% 5% 5%;
        }
        
        .sheep{
            width: 7.5em; margin: 0 3.75% 0% 10%;
            float: left;
        }
        
        .description{
            font-size: 0.75em;
        }

		/* RESPONSIVE */
		@media screen and (max-width: 800px){
            .modal{
                top: 30vmax;
            }
            
            .modal-body{
                line-height: 1.25em;
                font-size: 0.75em; text-align: center;
            }
            
            .todiary{
                margin: 5em 0 0.5em 0;
            }
            
            .wrapper{
                margin: 3.75em auto; margin-top: -1em;
            }
            
            .outer{
                font-size: 0.65em;
                display: block;
            }

            .dashboard2{
                width: 100%; padding: 2.5% 0%;
            }
            
            .tbar{
                height: 66.25vmin;
            }
            
            .btn{
                width: 7.5em; margin: auto 7.5%;
                font-size: 0.75em;
            }
        
            .diaryimg{
                width: 4.5em; margin-bottom: 15%;
            }
            
            .imgwrap{
                display: flex; text-align: center;
            }
            
            .sheep{
                width: 5em; margin: 0px auto;
            }
		}
    </style>
    
    <script>
		$(document).ready(function(){
            var Today=new Date();            
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
            
            $.ajax({ 
               type: "POST",
               dataType: "json",
               url: "",
               data: {fetchData: 1},
               success: function(data){
                   console.log(data);
                   
                   Today.setMonth(Today.getMonth());
                   Today.setDate(0);
                   var monthdays=Today.getDate();
                   
                   progressbar("#346C9C", hdate_n, data[0]["COUNT(*)"]/monthdays);
                   numberscroll("group_n", data[1]["COUNT(*)"]);
                   numberscroll("alter_n", data[2]["COUNT(*)"]);
                   numberscroll("tdiary_n", data[3]["COUNT(*)"]);
                   progressbar("#142334", tdate_n, data[4]["COUNT(DISTINCT date)"]/monthdays);
                   
                   if(data[5]["COUNT(*)"]==0){
                       $("#hlast6").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast6").style.color="#5698C3";
                   }else{
                       $("#hlast6").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast6").style.color="#FF7F50";
                   }
                   
                   if(data[6]["COUNT(*)"]==0){
                       $("#hlast5").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast5").style.color="#5698C3";
                   }else{
                       $("#hlast5").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast5").style.color="#FF7F50";
                   }
                   
                   if(data[7]["COUNT(*)"]==0){
                       $("#hlast4").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast4").style.color="#5698C3";
                   }else{
                       $("#hlast4").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast4").style.color="#FF7F50";
                   }
                   
                   if(data[8]["COUNT(*)"]==0){
                       $("#hlast3").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast3").style.color="#5698C3";
                   }else{
                       $("#hlast3").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast3").style.color="#FF7F50";
                   }
                   
                   if(data[9]["COUNT(*)"]==0){
                       $("#hlast2").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast2").style.color="#5698C3";
                   }else{
                       $("#hlast2").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast2").style.color="#FF7F50";
                   }
                   
                   if(data[10]["COUNT(*)"]==0){
                       $("#hlast1").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast1").style.color="#5698C3";
                   }else{
                       $("#hlast1").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast1").style.color="#FF7F50";
                   }
                   
                   if(data[11]["COUNT(*)"]==-1){
                       $("#hlast0").empty().append("i class='fa fa-lock' title='★ 18:00 解鎖 ★'></i>");
                   }else if(data[11]['COUNT(*)']==0){
                       $("#hlast0").empty().append("<i class='fa fa-times'></i>");
                       document.getElementById("hlast0").style.color="#5698C3";
                   }else{
                       $("#hlast0").empty().append("<i class='fas fa-star'></i>");
                       document.getElementById("hlast0").style.color="#FF7F50";
                   }
                   
                   for(i=12; i<19; i++){
                       if(data[i]["COUNT(*)"]>10){ data[i]["COUNT(*)"]=10;}
                   }
                   
                   heightscroll("tlast6", data[12]["COUNT(*)"]);
                   heightscroll("tlast5", data[13]["COUNT(*)"]);
                   heightscroll("tlast4", data[14]["COUNT(*)"]);
                   heightscroll("tlast3", data[15]["COUNT(*)"]);
                   heightscroll("tlast2", data[16]["COUNT(*)"]);
                   heightscroll("tlast1", data[17]["COUNT(*)"]);
                   heightscroll("tlast0", data[18]["COUNT(*)"]);
                   
                   
                   function progressbar(color, element, prob){
                       var bar=new ProgressBar.Circle(element, {
                           color: color,
                           trailColor: "#C1B2A3",
                           easing: "easeInOut",
                           strokeWidth: 10,
                           trailWidth: 10,
                           duration: 1500,
                           text: {autoStyleContainer: false},
                           step: function(state, bar){
                               bar.setText(Math.round(bar.value()*monthdays, 0));
                           }
                       })
                       bar.text.style.fontFamily="'Raleway', Helvetica, sans-serif";
                       bar.text.style.fontSize="3vmax";
                       bar.animate(prob);
                   }
                   
                   function numberscroll(element, value){
                       var number= document.getElementById(element);
                       var scroll= 0;
                       var add= value/40;
                       var minTime= 1000/add;
                       var t= setInterval(function(){
                           if(scroll>=value){
                               clearInterval(t)
                               number.innerText= value;
                           }else{
                               scroll+=add;
                               number.innerText= Math.round(scroll, 0);
                           }
                       }, 25)
                    }
                   
                   function heightscroll(element, value){
                       var number= document.getElementById(element);
                       var scroll= 0;
                       var add= value/40;
                       var minTime= 1000/add;
                       if(value>10){
                           number.append(">10");
                           value=10;
                       }else if(value>0){
                           number.append(value);
                       }
                       
                       var t= setInterval(function(){
                           if(scroll>=value){
                               clearInterval(t)
                               number.style.height= value;
                           }else{
                               scroll+=add;
                               number.style.height= scroll*20+"px";
                           }
                       }, 25)
                    }
               }, error: function(e){
                   console.log(e);
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
                <div class="imgwrap"><img class="sheep" src="./pic/error.png"></div>
                <p>
                    <br>請先完成 <b><a href="./profile.php">個人資料</a></b>，才能解鎖本頁功能唷！
                    <br><br>
                    系統出現異常？<button style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>回報客服人員</b></button>
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❿</div>
        </div>
        </div>
    </div>    
    

    <div class="todiary">
        <button class="btn" style="background-color: #FFFFBB" onclick="location.href='./hdiary.php'">
            <img class="diaryimg" src="./pic/diary.png">
            <center><marquee><b>按我填寫生活日記</b></marquee></center>
        </button>        
        <button class="btn" style="background-color: #F0F5E5" onclick="location.href='./alter_list.php'">
            <img class="diaryimg" src="./pic/diary.png">
            <center><marquee><b>按我填寫接觸紀錄＆新增接觸對象名單</b></marquee></center>
        </button>
    </div>
    
    <div class="wrapper">
    <div class="outer">
        <div>
            <div style="display: flex; flex-direction: row">
                <div class="dashboard1" style="background-color: #986524; color: #FFFFFF">
                    <div class="wrapper1"><b>我的會員編號</b><br>
                        <span class="description" style="color: #986524">★</span>
                    </div>
                    <div style="font-size: 4.5em"><?=$_SESSION["acc_info"]["id"]?></div>
                </div>
                <div class="dashboard1" style="background-color: #F8EBE6">
                    <div class="wrapper1"><b><?php if(date("m")[0]==0){?><?=date("m")[1]?><?php }else{?><?=date("m")?><?php }?> 月生活日記完成天數</b><br>
                        <span class="description" style="color: #F8EBE6">★</span>
                    </div>
                    <div id="hdate_n" style="margin: 2.5% 27.5%; position: relative"></div>
                </div>
            </div>
    
            <div style="display: flex; flex-direction: row">
                <div class="dashboard2" style="background-color: #FFFFBB">
                    <div class="wrapper2"><b>本週生活日記填寫狀況</b><br>
                        <span class="description" style="color: #986524">
                            1. 生活日記每日 18:00 開放填寫。<br>
                            2. 每日只需填寫一次，約五分鐘內可完成。<br>
                            3. 您可填寫「前一天」及「當天」的生活日記。
                        </span>
                    </div>
            
                    <div style="padding: 2.5% 5% 3% 5%">
                        <table align="center" style="width: 90%; table-layout: fixed; background-color: #E2E7BF; border-radius: 2.5px">
                            <tr style="font-size: 0.85em">
                                <td><?=date("m/d", strtotime("-6 day"))?></td>
                                <td><?=date("m/d", strtotime("-5 day"))?></td>
                                <td><?=date("m/d", strtotime("-4 day"))?></td>
                                <td><?=date("m/d", strtotime("-3 day"))?></td>
                                <td><?=date("m/d", strtotime("-2 day"))?></td>
                                <td><?=date("m/d", strtotime("-1 day"))?></td>
                                <td><?=date("m/d")?></td>
                            </tr>
                            <tr style="font-size: 1.25em">
                                <td><span id="hlast6"></span></td>
                                <td><span id="hlast5"></span></td>
                                <td><span id="hlast4"></span></td>
                                <td><span id="hlast3"></span></td>
                                <td><span id="hlast2"></span></td>
                                <td style="border: 1px dashed"><span id="hlast1"></span></td>
                                <td style="border: 1px dashed"><span id="hlast0"></span></td>
                            </tr>
                        </table>
                    </div> 
                </div>
            </div>
        
            <div style="display: flex; flex-direction: row">
                <div class="dashboard1" style="background-color: #FED71A">
                    <div class="wrapper1"><b>宗教群組清單數量</b><br>
                        <span class="description" style="color: #FED71A">★</span>
                    </div>
                    <div style="font-size: 4.5em" id="group_n"></div>
                </div>
                <div class="dashboard1" style="background-color: #2E317C; color: #FFFFFF">
                    <div class="wrapper1"><b>接觸對象名單人數</b><br>
                        <span class="description" style="color: #2E317C">★</span>
                    </div>
                    <div style="font-size: 4.5em" id="alter_n"></div>
                </div>
            </div>
        </div>
    
        <div>
            <div style="display: flex; flex-direction: row">
                <div class="dashboard1" style="background-color: #856D72; color: #FFFFFF">
                    <div class="wrapper1"><b><?php if(date("m")[0]==0){?><?=date("m")[1]?><?php }else{?><?=date("m")?><?php }?> 月累積接觸人次</b><br>
                        <span class="description">本月份一共建立了幾筆接觸紀錄</span>
                    </div>
                    <div style="font-size: 4.5em" id="tdiary_n"></div>
                </div>
                <div class="dashboard1" style="background-color: #FFFF00">
                    <div class="wrapper1"><b><?php if(date("m")[0]==0){?><?=date("m")[1]?><?php }else{?><?=date("m")?><?php }?> 月接觸紀錄填寫天數</b><br>
                        <span class="description">本月份共有幾天「有建立接觸紀錄」</span>
                    </div>
                    <div id="tdate_n" style="padding: 2.5% 27.5%; position: relative"></div>
                </div>
            </div>
    
            <div style="display: flex; flex-direction: row">
                <div class="dashboard2" style="background-color: #F0F5E5">
                    <div class="wrapper2"><b>本週接觸紀錄填寫狀況</b><br>
                        <span class="description" style="color: #986524">
                            1. 請先完成「接觸對象基本資料表」，建立自己的接觸對象名單。<br>
                            2. 完成後即可從名單內，選擇人來建立接觸紀錄。<br>
                            3. 每日可建立多筆，但針對同一對象只可記錄一次（請以最主要的那次互動為主）<br>
                            4. 您可填寫「前一天」及「當天」的接觸紀錄。
                        </span>
                    </div>
            
                    <div class="tbar" style="width: 80%; margin: 2.5% auto; padding: 0% 2.5%; background-color: #FFFFFF; display: flex; align-items: flex-end">
                        <div id="tlast6" class="twrapper1"></div>
                        <div id="tlast5" class="twrapper1"></div>
                        <div id="tlast4" class="twrapper1"></div>
                        <div id="tlast3" class="twrapper1"></div>
                        <div id="tlast2" class="twrapper1"></div>
                        <div id="tlast1" class="twrapper1" style="border: 1px dashed"></div>
                        <div id="tlast0" class="twrapper1" style="border: 1px dashed"></div>
                    </div>
                    <div style="width: 80%; margin: 1.25% auto; padding: 0% 2.5%; background-color: #F0F5E5; display: flex">
                        <div class="twrapper2"><?=date("m/d", strtotime("-6 day"))?></div>
                        <div class="twrapper2"><?=date("m/d", strtotime("-5 day"))?></div>
                        <div class="twrapper2"><?=date("m/d", strtotime("-4 day"))?></div>
                        <div class="twrapper2"><?=date("m/d", strtotime("-3 day"))?></div>
                        <div class="twrapper2"><?=date("m/d", strtotime("-2 day"))?></div>
                        <div class="twrapper2"><?=date("m/d", strtotime("-1 day"))?></div>
                        <div class="twrapper2"><?=date("m/d")?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>    

	<?php include("footer.php");?>
</body>
</html>

<?php
	session_start();
	include("db.php");
    $alter_id=isset($_GET["alter_id"])?$_GET["alter_id"]: 0;

    if(!$_SESSION["acc_info"]["id"]){
		header("Location: ./index.php");
    }
    if(isset($_POST["checkStatus"])){
        if($_SESSION["acc_info"]["reg_status"]!=2){
            echo "Error";
        }else{
            $sql1="SELECT * FROM `alter_list` WHERE ego_id= :v1 and alter_id= :v2";
            $stmt=$db->prepare($sql1);
            $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
            $stmt->bindParam(":v2", $alter_id);
            $stmt->execute();
            $rs1=$stmt->fetch(PDO::FETCH_ASSOC);
            
            if($stmt->rowCount()==0){
                echo "Invalid Alter";
            }else{
                echo $rs1["alter_name"];
            }
        }
        exit();
    }

    $yesterday=date("Y-m-d", strtotime("-1 day"));
    $today=date("Y-m-d");
    $checkmonth=date("Y-m-d", strtotime("-3 month"));
    if(isset($_POST["fetchTdiary"])){
        $index_duplicate1=$_SESSION["acc_info"]["id"]."_".$alter_id."_".$yesterday;
        $index_duplicate2=$_SESSION["acc_info"]["id"]."_".$alter_id."_".$today;
        
        $sql2="SELECT COUNT(*) FROM `tdiary` WHERE index_duplicate= :v1";
        $stmt=$db->prepare($sql2);
        $stmt->bindParam(":v1", $index_duplicate1);
        $stmt->execute();
        $rs2=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql3="SELECT COUNT(*) FROM `tdiary` WHERE index_duplicate= :v1";
        $stmt=$db->prepare($sql3);
        $stmt->bindParam(":v1", $index_duplicate2);
        $stmt->execute();
        $rs3=$stmt->fetch(PDO::FETCH_ASSOC);
		
        if($rs2["COUNT(*)"]==0&$rs3["COUNT(*)"]==0){
            echo "Y+T";
        }else if($rs2["COUNT(*)"]>0&$rs3["COUNT(*)"]==0){
            echo "Y done+T";
        }else if($rs2["COUNT(*)"]==0&$rs3["COUNT(*)"]>0){
            echo "Y+T done";
        }else{
            echo "Y done+T done";
        }
        exit();
    }

    if(isset($_POST["fetchAlterList"])){
		$sql4="SELECT * FROM
               (SELECT alter_id, alter_name FROM `alter_list` WHERE ego_id= :v1 and alter_id NOT IN(
               SELECT alter_id2 FROM `alter_table` WHERE ego_id= :v1 and alter_id1= :v2
               UNION DISTINCT
               SELECT alter_id1 FROM `alter_table` WHERE ego_id= :v1 and alter_id2= :v2)
               ORDER BY RAND()) a
               UNION DISTINCT
               SELECT * FROM
               (SELECT alter_id, alter_name FROM `alter_list` WHERE ego_id= :v1 and alter_id NOT IN(
               SELECT alter_id2 FROM `alter_table` WHERE ego_id= :v1 and alter_id1= :v2 and create_time> :v3
               UNION DISTINCT
               SELECT alter_id1 FROM `alter_table` WHERE ego_id= :v1 and alter_id2= :v2 and create_time> :v3)
               ORDER BY RAND()) b";
		$stmt=$db->prepare($sql4);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $alter_id);
        $stmt->bindParam(":v3", $checkmonth);
		$stmt->execute();
        $rs4=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
		$alter_done=array();
        for($i=0; $i<count($rs4); $i++){
            if($rs4[$i]["alter_id"]!=$alter_id){
                array_push($alter_done, $rs4[$i]);
            }
        }

		echo json_encode($alter_done, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["formSubmit"])){
        $index_duplicate=$_SESSION["acc_info"]["id"]."_".$alter_id."_".$_POST["tdate"];
        
        $sql5="INSERT INTO `tdiary` VALUES (NULL, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9, :v10, :v11, :v12, :v13, :v14, :v15, :v16, :v17, :v18, :v19, :v20, :v21, :v22, :v23, :v24, :v25, :v26, :v27, :v28, :v29, :v30, :v31, :v32, NOW())";        
		$stmt=$db->prepare($sql5);
		$stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v3", $alter_id);
        $stmt->bindParam(":v4", $_POST["tdate"]);
        $stmt->bindParam(":v5", $_POST["tperiod"]);
        $stmt->bindParam(":v6", $_POST["familiar"]);
        $stmt->bindParam(":v7", $_POST["who"]);
        $stmt->bindParam(":v8", $_POST["approach"]);
        $stmt->bindParam(":v9", $_POST["other_one"]);
        $stmt->bindParam(":v10", $_POST["duration"]);
        $stmt->bindParam(":v11", $_POST["contact_work"]);
        $stmt->bindParam(":v12", $_POST["contact_leisure"]);
        $stmt->bindParam(":v13", $_POST["contact_social"]);
        $stmt->bindParam(":v14", $_POST["contact_chore"]);
        $stmt->bindParam(":v15", $_POST["contact_rel"]);
        $stmt->bindParam(":v16", $_POST["contact_other"]);
        $stmt->bindParam(":v17", $_POST["symptom"]);
        $stmt->bindParam(":v18", $_POST["symptom_sick"]);
        $stmt->bindParam(":v19", $_POST["symptom_fever"]);
        $stmt->bindParam(":v20", $_POST["symptom_cough"]);
        $stmt->bindParam(":v21", $_POST["symptom_sorethroat"]);
        $stmt->bindParam(":v22", $_POST["symptom_hospital"]);
        $stmt->bindParam(":v23", $_POST["symptom_other"]);              
        $stmt->bindParam(":v24", $_POST["gain_spiritual"]);
        $stmt->bindParam(":v25", $_POST["mood_ego0"]);
        $stmt->bindParam(":v26", $_POST["mood_ego1"]);
        $stmt->bindParam(":v27", $_POST["mood_alter0"]);
        $stmt->bindParam(":v28", $_POST["mood_alter1"]);
        $stmt->bindParam(":v29", $_POST["gain_instrumental"]);
        $stmt->bindParam(":v30", $_POST["place"]);
        $stmt->bindParam(":v31", $_POST["self_disclosure"]);                          
        $stmt->bindParam(":v32", $index_duplicate);
		$stmt->execute();
        
        if($_POST["alter_table"]["alter_id"][0]!=0){
            $alter_n=count($_POST["alter_table"]["alter_id"]);
            for($i=0; $i<$alter_n; $i++){
                $check_index=$_SESSION["acc_info"]["id"]."_".$alter_id."_".$_POST["alter_table"]["alter_id"][$i]."_".$_POST["alter_table"]["familiar"][$i];
            
                $sql6="INSERT INTO `alter_table` VALUES(NULL, :v2, :v3, :v4, :v5, :v6, NOW(), :v8)";
                $stmt=$db->prepare($sql6);
                $stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
                $stmt->bindParam(":v3", $alter_id);
                $stmt->bindParam(":v4", $_POST["alter_table"]["alter_id"][$i]);
                $stmt->bindParam(":v5", $_POST["alter_table"]["familiar"][$i]);
                $stmt->bindParam(":v6", $today);
                $stmt->bindParam(":v8", $check_index);
                $stmt->execute();
            }
        }  
        $sql7="UPDATE `alter_list` SET last_record= NOW(), touchtimes= touchtimes+1 WHERE ego_id= :v1 and alter_id= :v2";
        $stmt=$db->prepare($sql7);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $alter_id);
        $stmt->execute();
        
        echo "Tdiary Insert Success";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>接觸記錄</title>
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
        
        .wrap{
            width: 100%; margin: 20px auto;
            display: inline-block; position: relative; text-align: center;
        }
                
        .title{
            width: 100%; top: 20%; left: 0; letter-spacing: 0.05em;
            color: #2E317C;
            font-size: 1.8em; font-weight: bold; text-align: center; position: absolute;
        }
        
        .container{
			width: 60%; margin: 20px auto;
			align-content: center;
		}
        
        .card{
            background-color: #FFFFBB;
        }
        
        .card-body{
		    line-height: 1.75em; letter-spacing: 0.05em;
            font-size: 0.95em; text-align: left;
		}
        
        .row{
            width: 95%; margin: 0px auto;
        }
        
        /* DETEAILED */
        .sheep1{
            width: 7.5em; margin: 0 3.75% 0% 10%;
            float: left;
        }
        
        .sheep2{
            width: 7.5em; margin: 0 5% 0% 10%;
            float: left;
        }
        
        .remind{
            font-size: 0.95em;
        }
        
        #title{
            width: 15%;
        }
        
        .infobar{
            letter-spacing: 0.1em;
            text-align: right;
        }
        
        .input-group-text, .btn, .form-control{
            font-size: 1em;
        }
        
        .part1{
            background-color: #FBDA41;
        }
        
        .part3{
            background-color: #C08EAF; color: #FFFFFF;
        }
        
        .warn{
            color: #EE475D;
            display: none;
        }
        
        hr{
            background-color: #E9CCD3;
        }
        
        .get_alter{
            padding-top: 1em; padding-right: 3%;
            text-align: right;
        }
 
        .icon{
			width: 10em;
		}
        
		/* RESPONSIVE */
		@media screen and (max-width: 800px){
            .modal{
                top: 30vmax;
            }
            
            #date{
                top: 27.5vmax;
            }
            
            .modal-body{
                line-height: 1.25em;
                font-size: 0.75em; text-align: center;
            }
            
            .remind{
                padding-bottom: 1em;
            }
            
            .wrap{
                margin: auto;
            }
            
            .title{
                font-size: 1.125em;
            }
            
            .infobar{
                font-size: 0.75em;
            }
            
            .container{
                width: 100%; margin: auto; margin-top: 6.25%;
            }
            
            .card-body{
                padding: 2.5%;
                font-size: 0.7em;
            }
            
            .imgwrap{
                display: flex; text-align: center;
            }
            
            .sheep1, .sheep2{
                width: 5em; margin: 0px auto; margin-bottom: 1em;
            }         
  
            #title{
                width: 8em;
            }
            
            .input-group-text{
                padding-left: 1.5%;
            }
            
            .row{
                width: 90%; margin-bottom: 1.5em;
            }
            
            .get_alter{
                margin-top: -1.25em;
            }
            
            .icon{
                width: 8.75em;
            }
            
            h5{
                font-size: 0.95em;
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
                   }else if(data=="Invalid Alter"){
                       $("#invalid").modal("show");
                       setTimeout("window.location.href='./alter_list.php'", 5000);
                   }else{
                       $("#date").modal("show");
                       $(".alter_name").empty().append(data);
                   }
                }, error: function(e){
                    console.log(e);
                }     
            })
            
            $.ajax({ 
               type: "POST",
               url: "",
               data: {fetchTdiary: 1},
               success: function(data){
                   console.log(data);
                   
                   if(data=="Y+T"){
                       $("#yesterday").show();
                       $("#yesterday_done").hide();
                       $("#today").show();
                       $("#today_done").hide();
                   }else if(data=="Y+T done"){
                       $("#yesterday").show();
                       $("#yesterday_done").hide();
                       $("#today").hide();
                       $("#today_done").show();
                   }else if(data=="Y done+T"){
                       $("#yesterday").hide();
                       $("#yesterday_done").show();
                       $("#today").show();
                       $("#today_done").hide();
                   }else{
                       $("#yesterday").hide();
                       $("#yesterday_done").show();
                       $("#today").hide();
                       $("#today_done").show();
                   }
                }, error: function(e){
                    console.log(e);
                }     
            })
            
            $.ajax({ 
				type: "POST",
				dataType: "json", 
				url: "",
				data: {fetchAlterList: 1},
                success: function(data){
                    console.log(data);
                    
                    if(data){
                        for(var i=0; i<data.length; i++){
                            var tmp1=$(".alter_info").clone().last();
                            if(i==0){$(".alter_info").remove()};
                            tmp1.find("span[class='alter_listname']").empty().append(data[i].alter_name);
                            tmp1.find("input[class='familiar']").attr("name", data[i].alter_id).prop("checked", false);

                            if(i>0&i%5==0){
                                tmp1.attr("style", "padding-top: 3.75%")
                            }else{
                                tmp1.attr("style", "padding: 0");
                            }
                            if(i>4){tmp1.hide();}
							$(".vertical_wrapper").append(tmp1);
                        }
                        
                        if(data.length==0){
                            $(".vertical_wrapper").hide();
                            $(".get_alter").hide();
                            $(".none").show();
                        }else if(data.length<=5){
                            $(".get_alter").hide();
                        }else if(data.length<=10){
                            $(".alter_left").empty().append(data.length-5);
                        }else{
                            $(".alter_left").empty().append("5");
                        }
                    }
                }, error: function(e){
                    console.log(e);
                }
            })
            
            $("#yesterday").on("click", function(event){
			    event.preventDefault();
                $("#yesterday").attr("disabled", true);
                $("#today").attr("disabled", true);
                $("#date").modal("hide");
                $(".container").show();
                $("#tdate").val("<?=$yesterday?>");
			})
            
            $("#today").on("click", function(event){
			    event.preventDefault();
                $("#yesterday").attr("disabled", true);
                $("#today").attr("disabled", true);
                $("#date").modal("hide");
                $(".container").show();
                $("#tdate").val("<?=$today?>");
			})
            
            $("input[name='contact_other_chk']").on("change", function(){
                event.preventDefault();
				var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $("input[name='contact_other']").show();
                }else{
                    $("input[name='contact_other']").hide().val("");
                }
			})
            
            $("#get_five").on("click", function(event){
				event.preventDefault();                
                var alter_show=$(".alter_info:visible").length;
                var alter_checked=$("input[class='familiar']:checked").length;
                
                if(alter_show!=alter_checked){
                    $.alert({
						title: "",
					    content: "請先完成目前的對象，才能繼續抽唷！",
					})
                }else{
                    var alter_left=$(".alter_info:hidden");             
                    if(alter_left.length<=5){
                        $(".get_alter").hide();
                        $(".alter_info").show();
                    }else{
                        for(i=0; i<5; i++){
                            alter_left[i].style.display="block";
                        }
                        if(alter_left.length<=10){
                            $(".alter_left").empty().append(alter_left.length-5);
                        }else{
                            $(".alter_left").empty().append("5");
                        }
                    }
                }
            })
            
            $("#submit").on("click", function(event){
                event.preventDefault();
                $(".warn").hide();
                $("#submit").attr("disabled", true);
                
                var tdate=              $("select[id='tdate']").val();
                var tperiod=            $("select[id='tperiod']").val();
                var contact_rel=        $("input[name='contact_rel']").is(":checked")?1 :0;
                var contact_work=       $("input[name='contact_work']").is(":checked")?1 :0;
                var contact_leisure=    $("input[name='contact_leisure']").is(":checked")?1 :0;
                var contact_social=     $("input[name='contact_social']").is(":checked")?1 :0;
                var contact_chore=      $("input[name='contact_chore']").is(":checked")?1 :0;
                var contact_other_chk=  $("input[name='contact_other_chk']").is(":checked")?1 :0;
                var contact_other=      $("input[name='contact_other']").val();
                var contact_sum=        contact_rel+contact_work+contact_leisure+contact_social+contact_chore+contact_other_chk;
                var who=                $("input[name='who']:checked").val();
                var approach=           $("input[name='approach']:checked").val();    
                var other_one=          $("input[name='other_one']:checked").val();
				var duration=           $("input[name='duration']:checked").val();
                var place=              $("input[name='place']:checked").val();
                var gain_spiritual=     $("input[name='gain_spiritual']:checked").val();
                var mood_ego0=          $("input[name='mood_ego0']:checked").val();
                var mood_ego1=          $("input[name='mood_ego1']:checked").val();
                var mood_alter0=        $("input[name='mood_alter0']:checked").val();
                var mood_alter1=        $("input[name='mood_alter1']:checked").val();
                var gain_instrumental=  $("input[name='gain_instrumental']:checked").val();
                var self_disclosure=    $("input[name='self_disclosure']:checked").val();
                
                var alter_table={
					alter_id: [],
					familiar: [],
				}
				$("input[class='familiar']:checked").each(function(){
					alter_table.alter_id.push($(this).attr("name"));
                    alter_table.familiar.push($(this).val());
				})
                if(alter_table.alter_id.length==0){alter_table.alter_id.push(0);}
                
                var record=[], j=0;
                if(!tdate|!tperiod)                                     {record[j]="1"; j++;    $("#warning1").show()}
                if(contact_sum==0|(contact_other_chk==1&!contact_other)){record[j]="2"; j++;    $("#warning2").show()}
                if(!who)                                                {record[j]="3"; j++;    $("#warning3").show()}
                if(!approach)                                           {record[j]="4"; j++;    $("#warning4").show()}
                if(!other_one)                                          {record[j]="5"; j++;    $("#warning5").show()}
                if(!duration)                                           {record[j]="6"; j++;    $("#warning6").show()}
                if(!place)                                              {record[j]="7"; j++;    $("#warning7").show()}
                if(!gain_spiritual)                                     {record[j]="8"; j++;    $("#warning8").show()}
                if(!mood_ego0)                                          {record[j]="9"; j++;    $("#warning9").show()}
                if(!mood_ego1)                                          {record[j]="10"; j++;   $("#warning10").show()}
                if(!mood_alter0)                                        {record[j]="11"; j++;   $("#warning11").show()}
                if(!mood_alter1)                                        {record[j]="12"; j++;   $("#warning12").show()}
                if(!gain_instrumental)                                  {record[j]="13"; j++;   $("#warning13").show()}
                if(!self_disclosure)                                    {record[j]="14"; j++;   $("#warning14").show()}
                
                if(j>0){
                    $("#submit").attr("disabled", false);
                    $.alert({
						title: "",
					    content: "您好，第 "+record+" 題尚未填答完畢唷！",
					})
                    return false;
                }else{
                    $.ajax({ 
				        type: "POST",
				        url: "",
				        data: {
                            formSubmit: 1,                         
                            tdate: tdate,
                            tperiod: tperiod,
                            familiar: 999,
                            contact_rel: contact_rel,
                            contact_work: contact_work,
                            contact_leisure: contact_leisure,
                            contact_social: contact_social,
                            contact_chore: contact_chore,
                            contact_other: contact_other,
                            symptom: 999,
                            symptom_sick: 999,
                            symptom_fever: 999,
                            symptom_cough: 999,
                            symptom_sorethroat: 999,
                            symptom_hospital: 999,
                            symptom_other: 999,
                            who: who,
                            approach: approach,
                            other_one: other_one,
                            duration: duration,
                            place: place,
                            gain_spiritual: gain_spiritual,
                            mood_ego0: mood_ego0,
                            mood_ego1: mood_ego1,
                            mood_alter0: mood_alter0,
                            mood_alter1: mood_alter1,
                            gain_instrumental: gain_instrumental,
                            self_disclosure: self_disclosure, 
                            alter_table: alter_table
                        },
                        success: function(data){ 
                            console.log(data);
                            
                            $("#success").modal("show");
                            $(".ttdate").empty().append(tdate);
                            setTimeout("window.location.href='./alter_list.php'", 5000);
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
            })
            
            if(window.matchMedia("(max-width: 800px)").matches){
                $(".btn-group-toggle").removeClass("btn-group").addClass("btn-group-vertical");
                $(".col-sm-3").removeClass("col-sm-3").addClass("col-sm-12");
                $(".col-sm-9").removeClass("col-sm-9").addClass("col-sm-12");
            }
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
                    <br>請先完成 <b><a href="./profile.php">個人資料</a></b>，才能解鎖本頁功能唷！
                    <br><br>
                    系統出現異常？<button style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>回報客服人員</b></button>
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❿</div>
        </div>
        </div>
    </div>
    
    <div id="invalid" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: black; color: #FFFFFF">💔 連結無效 💔</h5>
            </div>
                
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep1" src="./pic/error.png"></div>
                <p>
                    很抱歉，您使用的連結有誤！<br>請在 <b><a href="./alter_list.php">管理接觸對象</a></b> 重新選擇所要記錄的對象
                    <br><br>
                    系統出現異常？<button style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>回報客服人員</b></button><br>
                    5 秒後將為您導回：接觸對象管理頁
                </p>
            </div>
            <div style="text-align: right; padding: 1%; font-size: 1.5em">⓫</div>
        </div>
        </div>
    </div>
    
    <div id="success" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: yellow">⭐ 作答完成 ⭐</h5>
            </div>
                
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/done.gif"></div>
                <p>
                    您已建立一筆與【<b><span class="alter_name"></span></b>】的接觸紀錄<br>互動日期為 <b><span class="ttdate"></span></b>
                    <br><br>
                    提醒您：也別忘了填寫生活日記唷！<br>5 秒後將為您導回：接觸對象管理頁
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❺</div>
        </div>
        </div>
    </div>
    
    <div id="date" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: yellow">⭐ 請選擇填寫日期 ⭐</h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
                
            <div class="modal-body" style="padding-bottom: 1.5em; text-align: center">
                <div class="remind">注意：同一位對象，每天最多可記錄一筆互動</div>
                <button id="yesterday" class="btn btn-warning" style="margin: 2.5%">
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/diary.png"></div>
                    <div style="display: inline-block; width: 6em"><?=date("m/d", strtotime("-1 day"))?> (昨天)</div>
                </button>
                <button id="yesterday_done" class="btn btn-warning" style="margin: 2.5%; filter: brightness(25%); cursor: not-allowed" disabled>
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/diary.png"></div>
                    <div style="display: inline-block; width: 6em"><h5 style="color: #2E317C"><b>您已完成</b></h5></div>
                </button>
                <button id="today" class="btn btn-info" style="margin: 2.5%">
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/diary.png"></div>
                    <div style="display: inline-block; width: 6em"><?=date("m/d")?> (今天)</div>
                </button>
                <button id="today_done" class="btn btn-info" style="margin: 2.5%; filter: brightness(25%); cursor: not-allowed" disabled>
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/diary.png"></div>
                    <div style="display: inline-block; width: 6em"><h5 style="color: #FFFFBB"><b>您已完成</b></h5></div>
                </button>
            </div>
        </div>
        </div>
    </div>
    
    <div class="wrap">
        <img id="title" src="./pic/square.png">
        <div class="title">接觸紀錄</div>
    </div>
    
    <div class="container" style="display: none">
        <div class="infobar">
            <b><span style="background-color: orange; padding: 0.5em; -webkit-border-radius: 10px 0px 0px 10px; border-radius: 10px 0px 0px 10px">填寫對象</span><span style="background-color: yellow; padding: 0.5em; -webkit-border-radius: 0px 10px 10px 0px; border-radius: 0px 10px 10px 0px" class="alter_name"></span></b>
        </div><br>
        
        <div class="card">
            <div class="card-body">
            <form id="tdiaryForm">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                
                <p>
                    第一部分：本次接觸概況
                </p>
                <div id="warning1" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">1. 本次主要接觸時段：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
				    <select id="tdate" class="form-control btn-outline-success" disabled>
                        <option value="">請選擇時段</option>
                        <option value="<?=$yesterday?>"><?=$yesterday?></option>
                        <option value="<?=$today?>"><?=$today?></option>
                    </select>
                    <select id="tperiod" class="form-control btn-outline-success">
                        <option value="">請選擇時段</option>
                        <option value="1">上午</option>
                        <option value="2">中午</option>
                        <option value="3">下午</option>
                        <option value="4">晚上</option>
                        <option value="5">凌晨</option>
                    </select>
				</div><br><br>
                
                <div id="warning2" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">2. 這次互動接觸的內容？<span style="background-color: #5CB85C; color: #FFFFFF">可複選</span></div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="checkbox" name="contact_rel">宗教活動</label>
				    <label class="btn btn-outline-success"><input type="checkbox" name="contact_work">課業／工作</label>
				    <label class="btn btn-outline-success"><input type="checkbox" name="contact_leisure">運動休閒</label>
				    <label class="btn btn-outline-success"><input type="checkbox" name="contact_social">社交聊天</label>
                    <label class="btn btn-outline-success"><input type="checkbox" name="contact_chore">日常作息／家務事</label>
                    <label class="btn btn-outline-success"><input type="checkbox" name="contact_other_chk">其他</label>
                </div>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="contact_other" placeholder="補充說明互動接觸內容" style="display: none">
				</div><br>               
                
                <div id="warning3" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">3. 這次是誰主動接觸？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="who" value="0">自己</label>
				    <label class="btn btn-outline-success"><input type="radio" name="who" value="1">對方</label>
				    <label class="btn btn-outline-success"><input type="radio" name="who" value="2">事先約定</label>
				    <label class="btn btn-outline-success"><input type="radio" name="who" value="3">偶遇</label>
				</div><br><br>
                
                <div id="warning4" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">4. 這次主要接觸方式？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="approach" value="0">見面</label>
				    <label class="btn btn-outline-success"><input type="radio" name="approach" value="1">視訊</label>
				    <label class="btn btn-outline-success"><input type="radio" name="approach" value="2">語音通話</label>
				    <label class="btn btn-outline-success"><input type="radio" name="approach" value="3"><b title="★ 例如：簡訊、Email、LINE 等 ★">文字<i class="fa fa-info-circle"></i></b></label>
				</div><br><br>
                
                <div id="warning5" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">5. 這次接觸有多少他人在場？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="other_one" value="0">0 人</label>
				    <label class="btn btn-outline-success"><input type="radio" name="other_one" value="1">1-2 人</label>
				    <label class="btn btn-outline-success"><input type="radio" name="other_one" value="2">3-5 人</label>
				    <label class="btn btn-outline-success"><input type="radio" name="other_one" value="3">>5 人</label>
				</div><br><br>
                
                <div id="warning6" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">6. 這次互動接觸的時間？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="duration" value="0"><1 分鐘</label>
				    <label class="btn btn-outline-success"><input type="radio" name="duration" value="1">1-4 分鐘</label>
				    <label class="btn btn-outline-success"><input type="radio" name="duration" value="2">5-14 分鐘</label>
				    <label class="btn btn-outline-success"><input type="radio" name="duration" value="3">15-59 分鐘</label>
                    <label class="btn btn-outline-success"><input type="radio" name="duration" value="4">1-4 小時</label>
                    <label class="btn btn-outline-success"><input type="radio" name="duration" value="5">>4 小時</label>
				</div><br><br>
                
                <div id="warning7" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">7. 這次接觸的時候我人在哪裡？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="place" value="0">家裡</label>
				    <label class="btn btn-outline-success"><input type="radio" name="place" value="1">宗教場所</label>
				    <label class="btn btn-outline-success"><input type="radio" name="place" value="2">其他非宗教場所</label>
				</div><br><br><hr>          
              
                
                <p>
                    第二部分：本次接觸收穫
                </p>
                <div id="warning8" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">8. 接觸過程中，我是否有靈性方面的啟發／感受？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="gain_spiritual" value="0">很大</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="gain_spiritual" value="1">有一點</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="gain_spiritual" value="2">幾乎沒有</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="gain_spiritual" value="3">有額外損失／付出</label>
				</div><br><br>
                
                <div id="warning9" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">9. 這次接觸過程中，我的心情如何？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego0" value="0">非常好</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego0" value="1">很好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego0" value="2">還好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego0" value="3">不好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego0" value="4">非常不好</label>
				</div><br><br>
                
                <div id="warning10" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">10. 這次的接觸是否讓我的心情變好或變壞？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego1" value="0">變好</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego1" value="1">沒有改變</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_ego1" value="2">變壞</label>
				</div><br><br>
                
                <div id="warning11" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">11. 這次接觸過程中，我覺得對方的心情如何？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter0" value="0">非常好</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter0" value="1">很好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter0" value="2">還好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter0" value="3">不好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter0" value="4">非常不好</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter0" value="5">不知道</label>
				</div><br><br>
                
                <div id="warning12" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">12. 這次的接觸是否讓對方的心情變好或變壞？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter1" value="0">變好</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter1" value="1">沒有改變</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter1" value="2">變壞</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="mood_alter1" value="3">不知道</label>
				</div><br><br>
                
                <div id="warning13" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">13. 我是否有除了靈性、心情以外的<b title="★ 例如：健康、資訊 ... 等 ★">具體收穫<i class="fa fa-info-circle"></i></b>？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="gain_instrumental" value="0">很大</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="gain_instrumental" value="1">有一點</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="gain_instrumental" value="2">幾乎沒有</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="gain_instrumental" value="3">有額外損失／付出</label>
				</div><br><br>
                    
                <div id="warning14" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">14. 在這一次的接觸過程中，我是否有分享內心的看法或感受？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="self_disclosure" value="0">完全沒有</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="self_disclosure" value="1">沒有</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="self_disclosure" value="2">有一些</label>
                    <label class="btn btn-outline-secondary"><input type="radio" name="self_disclosure" value="3">很多</label>
				</div><br><br>
            </form>
            </div>
        </div>
    </div>
        
    <div class="container" style="padding-top: 1em; display: none">        
        <div class="card">
            <div class="card-body">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                
                <p>
                    第三部分：熟悉關係表
                </p>  
                <div class="col-sm-auto">
                    <div class="part3" style="padding: 0.5em; text-align: center">
                        <b><span class="alter_name"></span></b> 認不認識下列這些人呢？
                    </div>
				</div><br>
                <div class="row none" style="display: none">
                    <h6 class="col-sm-12" style="letter-spacing: 0.1em; color: #5CB85C; text-align: center"><b>目前無待確認關係之對象</b></h6>
                </div>
                
                <div class="vertical_wrapper">
                <div class="alter_info">
                    <div class="row">
                        <div class="col-sm-3 pl-0 pr-0">
                            <div class="input-group-text part3"><b><span class="alter_listname"></span></b></div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-9 pl-0 pr-0" data-toggle="buttons">
				            <label class="btn btn-outline-info"><input type="radio" class="familiar" value="0">很熟</label>
				            <label class="btn btn-outline-info"><input type="radio" class="familiar" value="1">認識但不熟</label>
                            <label class="btn btn-outline-info"><input type="radio" class="familiar" value="2">不認識</label>
                            <label class="btn btn-outline-info"><input type="radio" class="familiar" value="3">我不知道</label>
				        </div>
				    </div>
                </div>
                </div>
                <div class="get_alter"><hr>
                    <button id="get_five" class="btn btn-info">再抽 <span class="alter_left"></span> 位</button>
                </div><br>
                    
                <div style="text-align: center">
                    <button id="submit" class="btn">
                        <img src="/pic/submit.png" class="icon">
                    </button>
                </div>
            </div>
        </div>
    </div>
    
	<?php include("footer.php");?>
</body>
</html>

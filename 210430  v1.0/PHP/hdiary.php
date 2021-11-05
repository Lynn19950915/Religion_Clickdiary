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
    $yesterday=date("Y-m-d", strtotime("-1 day"));
    $today=date("Y-m-d");
    $time=date("H");
    if(isset($_POST["fetchHdiary"])){     
        if($time<18){
            $index_duplicate1=$_SESSION["acc_info"]["id"]."_".$yesterday;
            
            $sql1="SELECT COUNT(*) FROM `hdiary` WHERE index_duplicate= :v1";
            $stmt=$db->prepare($sql1);
            $stmt->bindParam(":v1", $index_duplicate1);
            $stmt->execute();
            $rs1=$stmt->fetch(PDO::FETCH_ASSOC);
		
            if($rs1["COUNT(*)"]==0){
                echo "Y+T yet";
            }else{
                echo "Y done+T yet";
            }  
        }else{
            $index_duplicate1=$_SESSION["acc_info"]["id"]."_".$yesterday;
            $index_duplicate2=$_SESSION["acc_info"]["id"]."_".$today;
            
            $sql1="SELECT COUNT(*) FROM `hdiary` WHERE index_duplicate= :v1";
            $stmt=$db->prepare($sql1);
            $stmt->bindParam(":v1", $index_duplicate1);
            $stmt->execute();
            $rs1=$stmt->fetch(PDO::FETCH_ASSOC);

            $sql2="SELECT COUNT(*) FROM `hdiary` WHERE index_duplicate= :v1";
            $stmt=$db->prepare($sql2);
            $stmt->bindParam(":v1", $index_duplicate2);
            $stmt->execute();
            $rs2=$stmt->fetch(PDO::FETCH_ASSOC);
            
            if($rs1["COUNT(*)"]==0&$rs2["COUNT(*)"]==0){
                echo "Y+T";
            }else if($rs1["COUNT(*)"]>0&$rs2["COUNT(*)"]==0){
                echo "Y done+T";
            }else if($rs1["COUNT(*)"]==0&$rs2["COUNT(*)"]>0){
                echo "Y+T done";
            }else{
                echo "Y done+T done";
            }
        }
        exit();
    }

    if(isset($_POST["fetchGroupList"])){
		$sql3="SELECT * FROM `group_list` WHERE id= :v1";
		$stmt=$db->prepare($sql3);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        
		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["searchGroup"])){
		$sql4="SELECT * FROM `group_list` WHERE id= :v1 and group_name= :v2";
		$stmt=$db->prepare($sql4);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $_POST["group_name"]);
		$stmt->execute();
        $rs4=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount()>=1){
			echo "duplicate";
		}
		exit();
	}

    if(isset($_POST["formSubmit1"])){
        $group_n=count($_POST["group_list"]["group_name"]);
 
        for($i=0; $i<$group_n; $i++){
            $sql5="INSERT INTO `group_list` VALUES (NULL, :v2, :v3, :v4, :v5, :v6, :v7, NOW())";
            $stmt=$db->prepare($sql5);
            $stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
            $stmt->bindParam(":v3", $_POST["group_list"]["group_name"][$i]);
            $stmt->bindParam(":v4", $_POST["group_list"]["group_myname"][$i]);
            $stmt->bindParam(":v5", $_POST["group_list"]["group_freq"][$i]);
            $stmt->bindParam(":v6", $_POST["group_list"]["group_religion"][$i]);
            $stmt->bindParam(":v7", $_POST["group_list"]["group_invite"][$i]);
            $stmt->execute();
        }      
        $sql6="SELECT * FROM `group_list` WHERE id= :v1";
		$stmt=$db->prepare($sql6);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        
		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["formSubmit2"])){
        $groupview=implode(",", $_POST["groupview"]);
        $grouppost=implode(",", $_POST["grouppost"]);
        $grouppost_info=json_encode(array_filter($_POST["grouppost_info"]), 384);
        $index_duplicate=$_SESSION["acc_info"]["id"]."_".$_POST["date"];
        
        $sql7="INSERT INTO `hdiary` VALUES (NULL, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9, :v10, :v11, :v12, :v13, :v14, :v15, :v16, :v17, :v18, :v19, :v20, :v21, :v22, :v23, :v24, :v25, :v26, :v27, :v28, NULL, :v30, NOW())";
		$stmt=$db->prepare($sql7);
		$stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v3", $_POST["date"]);
        $stmt->bindParam(":v4", $_POST["mood"]);
        $stmt->bindParam(":v5", $_POST["symptom"]);
        $stmt->bindParam(":v6", $_POST["symptom_sick"]);
        $stmt->bindParam(":v7", $_POST["symptom_fever"]);
        $stmt->bindParam(":v8", $_POST["symptom_cough"]);
        $stmt->bindParam(":v9", $_POST["symptom_sorethroat"]);
        $stmt->bindParam(":v10", $_POST["symptom_hospital"]);
        $stmt->bindParam(":v11", $_POST["symptom_other"]);
        $stmt->bindParam(":v12", $_POST["contact"]);
        $stmt->bindParam(":v13", $groupview);
        $stmt->bindParam(":v14", $grouppost);
        $stmt->bindParam(":v15", $grouppost_info);
        $stmt->bindParam(":v16", $_POST["rel_activity"]);
        $stmt->bindParam(":v17", $_POST["rel_activity_name"]);
        $stmt->bindParam(":v18", $_POST["rel_activity_time"]);
        $stmt->bindParam(":v19", $_POST["rel_activity_population"]);
        $stmt->bindParam(":v20", $_POST["pos_for"]);
        $stmt->bindParam(":v21", $_POST["pos_forother"]);
        $stmt->bindParam(":v22", $_POST["neg_for"]);
        $stmt->bindParam(":v23", $_POST["neg_forother"]);
        $stmt->bindParam(":v24", $_POST["rel_activity_atm"]);
        $stmt->bindParam(":v25", $_POST["gain_spiritual"]);
        $stmt->bindParam(":v26", $_POST["mood0"]);
        $stmt->bindParam(":v27", $_POST["mood1"]);
        $stmt->bindParam(":v28", $_POST["gain_instrumental"]);
        $stmt->bindParam(":v30", $index_duplicate);
		$stmt->execute();   
        
        $sql8="SELECT COUNT(*) FROM `hdiary` WHERE id= :v1 and YEAR(date)= :v2 and MONTH(date)= :v3";
        $stmt=$db->prepare($sql8);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $year);
        $stmt->bindParam(":v3", $month);
        $stmt->execute();
        
        $json=array();
        $json[0]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>生活日記</title>
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
        
        .groupf{
            display: flex; flex-direction: row; align-items: center;
        }

        .appendbox{
            width: 40%; margin: 5%; padding: 2% 0%;
            background-color: #00BFFF;
            text-align: center;
        }
        
        .add_minus{
            padding-right: 3%;
            font-size: 2em;
            text-align: right;
        }
        
        .icon{
			width: 10em;
		}
        
        #container{
            width: 55%; margin: 2.5%;
            position: relative;
        }

		/* RESPONSIVE */
		@media screen and (max-width: 800px){
            .modal{
                top: 30vmax;
            }
            
            #date, #success{
                top: 27.5vmax;
            }
            
            .modal-body{
                line-height: 1.25em;
                font-size: 0.75em; text-align: center;
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
            
            .groupf{
                display: inline-block;
            }
            
            .appendbox{
                width: 50%; margin: 7.5% auto;
            }
            
            .icon{
                width: 8.75em;
            }
            
            h5{
                font-size: 0.95em;
            }
            
            #container{
                width: 30%;
            }
		}
	</style>
    
    <script>
        $(document).ready(function(){
            var Today=new Date();
            $(".hdate").html("");
            $.ajax({ 
               type: "POST",
               url: "",
               data: {checkStatus: 1},
               success: function(data){
                   console.log(data);
                   
                   if(data=="Error"){
                       $("#error").modal("show");
                       setTimeout("window.location.href='./profile.php'", 5000);
                   }else{
                       $("#date").modal("show");
                   }
                }, error: function(e){
                    console.log(e);
                }     
            })
            
            $.ajax({ 
               type: "POST",
               url: "",
               data: {fetchHdiary: 1},
               success: function(data){
                   console.log(data);
                   
                   if(data=="Y+T yet"){
                       $("#yesterday").show();
                       $("#yesterday_done").hide();
                       $("#today_yet").show();
                       $("#today").hide();
                       $("#today_done").hide();               
                   }else if(data=="Y+T"){
                       $("#yesterday").show();
                       $("#yesterday_done").hide();
                       $("#today_yet").hide();
                       $("#today").show();
                       $("#today_done").hide();
                   }else if(data=="Y+T done"){
                       $("#yesterday").show();
                       $("#yesterday_done").hide();
                       $("#today_yet").hide();
                       $("#today").hide();
                       $("#today_done").show();
                   }else if(data=="Y done+T yet"){
                       $("#yesterday").hide();
                       $("#yesterday_done").show();
                       $("#today_yet").show();
                       $("#today").hide();
                       $("#today_done").hide();
                   }else if(data=="Y done+T"){
                       $("#yesterday").hide();
                       $("#yesterday_done").show();
                       $("#today_yet").hide();
                       $("#today").show();
                       $("#today_done").hide();
                   }else{
                       $("#yesterday").hide();
                       $("#yesterday_done").show();
                       $("#today_yet").hide();
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
				data: {fetchGroupList: 1},
                success: function(data){
                    console.log(data);
                    
                    if(data){
                        for(var i=0; i<data.length; i++){
							var tmp1=$(".view").clone().last();
                            if(i==0){$(".view").remove()};
							tmp1.find("span[class='groupview']").empty().append(data[i].group_name);
                            tmp1.find("input[name='groupview[]']").attr("value", data[i].group_name);
							$(".vertical_wrapper1").append(tmp1);
                            
                            var tmp2=$(".post").clone().last();
                            if(i==0){$(".post").remove()};
							tmp2.find("span[class='grouppost']").empty().append(data[i].group_name);
                            tmp2.find("input[name='grouppost[]']").attr("value", data[i].group_name);
							$(".vertical_wrapper2").append(tmp2);
                        }
                        var tmp3=$(".view").clone().last();
                        tmp3.find("span[class='groupview']").empty().append("以上皆無");
                        tmp3.find("input[name='groupview[]']").removeClass("4e").addClass("4o").attr("value", "以上皆無");
				        $(".vertical_wrapper1").append(tmp3);
                        
                        var tmp4=$(".post").clone().last();
				        tmp4.find("span[class='grouppost']").empty().append("以上皆無");
                        tmp4.find("input[name='grouppost[]']").removeClass("5e").addClass("5o").attr("value", "以上皆無");
				        $(".vertical_wrapper2").append(tmp4);
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
                
                $("input[name='date'][value='<?=$yesterday?>']").prop("checked", true);
                if(Today.getDate()==1){
                    Today.setMonth(Today.getMonth());
                    Today.setDate(0);
                    var days=Today.getDate();  
                    
                    $(".hdate").empty().append((("0"+(Today.getMonth())).substr(-2))+"/"+days+"(昨天)");
                }else{
                    $(".hdate").empty().append((("0"+(Today.getMonth()+1)).substr(-2))+"/"+(("0"+(Today.getDate()-1)).substr(-2))+"(昨天)");
                }
			})
            
            $("#today").on("click", function(event){
			    event.preventDefault();
                $("#yesterday").attr("disabled", true);
                $("#today").attr("disabled", true);
                $("#date").modal("hide");
                $(".container").show();
                
                $("input[name='date'][value='<?=$today?>']").prop("checked", true);
                $(".hdate").empty().append((("0"+(Today.getMonth()+1)).substr(-2))+"/"+(("0"+(Today.getDate())).substr(-2))+"(今天)");
			})
            
            $("input[name='symptom']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==1){
                    $("div[name='symptom_detail']").show();
                }else{
                    $("div[name='symptom_detail']").hide();
                    $("div[name='symptom_detail']").children().find("input[type='checkbox']").prop("checked", false).parent().removeClass("active");
					$("div[name='symptom_detail']").children().find("input[type='text']").hide().val("");
                }
			})
            
            $("input[name='symptom_other_chk']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).is(':checked')?1 :0;

				if(tmp==1){
					$("input[name='symptom_other']").show();
				}else{
					$("input[name='symptom_other']").hide().val("");
				}
			})
            
            $(jQuery).on("change", ".4o", function(event){
                event.preventDefault();
                var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $(".4e").prop("checked", false).parent().removeClass("active");
                    $(".4e").attr("disabled", true);
                }else{
                    $(".4e").attr("disabled", false);
                }
            })
            
            $(jQuery).on("change", ".5o", function(event){
                event.preventDefault();
                var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $(".5e").prop("checked", false).parent().removeClass("active");
                    $(".5e").attr("disabled", true);
                }else{
                    $(".5e").attr("disabled", false);
                }
            })
            
            $("#create_group").on("click", function(event){
			    event.preventDefault();
			    $("#group_append").modal("show");
			})
            
            $("input[name='group_name']").on("input", function(event){
                event.preventDefault();
                var group_name=$(this).val();
                
                $.ajax({ 
                    type: "POST",
                    url: "",
                    data: {searchGroup: 1, group_name: group_name},
                    success: function(data){
                        console.log(data);
                        
                        if(data=="duplicate"){
                            $("#samegname").show();
                            $("#submit1").attr("disabled", true);
                        }else{
                            $("#samegname").hide();
                            $("#submit1").attr("disabled", false);
                        }
                    }, error: function(e){
                        console.log(e);
                    }     
                })
            })
            
            $("#group_add").on("click", function(event){
				event.preventDefault();
				var tmp=$(".newgroup_info").clone().last();
                
                tmp.find("input[type='text']").val("");
                tmp.find("label").removeClass("active");
                var index=parseInt(tmp.find("input[class='group_freq']").attr("name").split("_").slice(-1)[0]);
				tmp.find("input[class='group_freq']").attr("name", "newgroup_freq_"+(index+1)).prop("checked", false);
				tmp.find("input[class='group_invite']").attr("name", "newgroup_invite_"+(index+1)).prop("checked", false);             
                
				$(".vertical_wrapper3").append(tmp);
			})

            $("#group_minus").on("click", function(event){
				event.preventDefault();
				var tmp=$(".newgroup_info").clone();
			
				if(tmp.length>1){
					$(".newgroup_info").last().remove();
				}else{
                    $.alert({
						title: "",
					    content: "請至少新增一個常用群組！",
					})
				}
			})
            
            $("#submit1").on("click", function(event){
                event.preventDefault();
                $("#submit1").attr("disabled", true);

                var group_list={
					group_name: [],
					group_myname: [],
					group_freq: [],
					group_religion: [],
					group_invite: []
				}

                $("input[name='group_name']").each(function(){
                    if($(this).val().trim()!=""){
                        group_list.group_name.push($(this).val());
                    }
				})
				$("input[name='group_myname']").each(function(){
                    if($(this).val().trim()!=""){
                        group_list.group_myname.push($(this).val());
                    }
				})
				$("input[class='group_freq']:checked").each(function(){
					group_list.group_freq.push($(this).val());
                    group_list.group_religion.push(999);
				})
				$("input[class='group_invite']:checked").each(function(){
					group_list.group_invite.push($(this).val());
                })
                
                if(group_list.group_name.length==0|
                  (group_list.group_name.length!=group_list.group_religion.length)|
                  (group_list.group_myname.length!=group_list.group_religion.length)|
                  (group_list.group_invite.length!=group_list.group_religion.length)){
                    
                    $("#submit1").attr("disabled", false);
                    $.alert({
						title: "",
					    content: "請檢查是否有欄位漏填唷！",
					})
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        dataType: "json", 
                        url: "",
                        data: {formSubmit1: 1, group_list: group_list},
                        success: function(data){
                            console.log(data);
                            
                            if(data){
                                for(var i=0; i<data.length; i++){
                                    var tmp1=$(".view").clone().last();
                                    if(i==0){$(".view").remove()};
                                    tmp1.find("span[class='groupview']").empty().append(data[i].group_name);
                                    tmp1.find("input[name='groupview[]']").removeClass("4o").addClass("4e").attr("value", data[i].group_name);
                                    $(".vertical_wrapper1").append(tmp1);
                            
                                    var tmp2=$(".post").clone().last();
                                    if(i==0){$(".post").remove()};
                                    tmp2.find("span[class='grouppost']").empty().append(data[i].group_name);
                                    tmp2.find("input[name='grouppost[]']").removeClass("5o").addClass("5e").attr("value", data[i].group_name);
                                    $(".vertical_wrapper2").append(tmp2);
                                }
                                var tmp3=$(".view").clone().last();
                                tmp3.find("span[class='groupview']").empty().append("以上皆無");
                                tmp3.find("input[name='groupview[]']").removeClass("4e").addClass("4o").attr("value", "以上皆無");
				                $(".vertical_wrapper1").append(tmp3);
                        
                                var tmp4=$(".post").clone().last();
				                tmp4.find("span[class='grouppost']").empty().append("以上皆無");
                                tmp4.find("input[name='grouppost[]']").removeClass("5e").addClass("5o").attr("value", "以上皆無");
				                $(".vertical_wrapper2").append(tmp4);
                            
                                $("#group_append").modal("hide");
                            }
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
            })
            
            $("input[name='grouppost_attention']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==1){
                    $(".vertical_wrapper4").show();
                    $(".add_minus").show();
                }else{
                    $(".vertical_wrapper4").hide();
                    $(".add_minus").hide();
                    $(".grouppost_attention_detail").children().find("input[type='radio']").prop("checked", false).parent().removeClass("active");
					$(".grouppost_attention_detail").children().find("input[type='text']").hide().val("");
                }
			})
            
            $(jQuery).on("change", ".attention_author", function(event){
                event.preventDefault();
                var tmp=$(this).val();

				if(tmp==1){
                    $(this).parent().parent().parent().find("input[name='author']").show();
				}else{
                    $(this).parent().parent().parent().find("input[name='author']").hide().val("");
				}
			})
            
            $("#grouppost_add").on("click", function(event){
				event.preventDefault();
				var tmp=$(".grouppost_attention_detail").clone().last();
                
                tmp.find("input[type='text']").hide().val("");
                tmp.find("label").removeClass("active");
                var index=parseInt(tmp.find("input[class='attention_for']").attr("name").split("_").slice(-1)[0]);
				tmp.find("input[class='attention_for']").attr("name", "attention_for_"+(index+1)).prop("checked", false);
				tmp.find("input[class='attention_author']").attr("name", "attention_author_"+(index+1)).prop("checked", false);
                
				$(".vertical_wrapper4").append(tmp);
			})

            $("#grouppost_minus").on("click", function(event){
				event.preventDefault();
				var tmp=$(".grouppost_attention_detail").clone();
			
				if(tmp.length>1){
					$(".grouppost_attention_detail").last().remove();
				}else{
                    $.alert({
						title: "",
					    content: "請至少填寫一篇有感發文！",
					})
				}
			})
            
            $("input[name='rel_activity']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();

				if(tmp==1){
					$("#rel_activity_detail").show();
				} else {
                    $("#rel_activity_detail").hide();
					$("#rel_activity_detail").children().find("input[type='radio']").prop("checked", false).parent().removeClass("active");
                    $("#rel_activity_detail").children().find("input[type='text']").val("");
                    $("input[name='pos_forother']").hide();
                    $("input[name='neg_forother']").hide();
				}
			})
            
            $("input[name='pos']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==1){
                    $("div[name='pos_detail']").show();
                }else{
                    $("div[name='pos_detail']").hide();
                    $("div[name='pos_detail']").children().find("input[type='radio']").prop("checked", false).parent().removeClass("active");
					$("div[name='pos_detail']").children().find("input[type='text']").hide().val("");
                }
			})
            
            $("input[name='pos_for']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();

				if(tmp==6){
					$("input[name='pos_forother']").show();
				}else{
					$("input[name='pos_forother']").hide().val("");
				}
			})
            
            $("input[name='neg']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==1){
                    $("div[name='neg_detail']").show();
                }else{
                    $("div[name='neg_detail']").hide();
                    $("div[name='neg_detail']").children().find("input[type='radio']").prop("checked", false).parent().removeClass("active");
					$("div[name='neg_detail']").children().find("input[type='text']").hide().val("");
                }
			})
            
            $("input[name='neg_for']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();

				if(tmp==6){
					$("input[name='neg_forother']").show();
				}else{
					$("input[name='neg_forother']").hide().val("");
				}
			})
            
            $("#submit2").on("click", function(event){
                event.preventDefault();
                $(".warn").hide();
                $("#submit2").attr("disabled", true);
                
                var date=                   $("input[name='date']:checked").val();
                var mood=                   $("input[name='mood']:checked").val();
                var symptom=                $("input[name='symptom']:checked").val();
                var symptom_sick=           $("input[name='sick']").is(":checked")?1: 0;
                var symptom_fever=          $("input[name='fever']").is(":checked")?1: 0;
                var symptom_cough=          $("input[name='cough']").is(":checked")?1: 0;
                var symptom_sorethroat=     $("input[name='sorethroat']").is(":checked")?1: 0;
                var symptom_hospital=       $("input[name='hospital']").is(":checked")?1: 0;
                var symptom_other_chk=      $("input[name='symptom_other_chk']").is(":checked")?1: 0;
                var symptom_other=          $("input[name='symptom_other']").val();
                var symptom_sum=            symptom_sick+symptom_fever+symptom_cough+symptom_sorethroat+symptom_hospital+symptom_other_chk;
                var contact=                $("input[name='contact']:checked").val();
                var groupview=              $("input[name='groupview[]']:checked").map(function(){return $(this).val()}).get();
                var grouppost=              $("input[name='grouppost[]']:checked").map(function(){return $(this).val()}).get();
                var grouppost_attention=    $("input[name='grouppost_attention']:checked").val();
                var grouppost_info={
					attention_for: [],
					attention_author: [],
					author: [],
				}

				$("input[class='attention_for']:checked").each(function(){
					grouppost_info.attention_for.push($(this).val());
				})
				$("input[class='attention_author']:checked").each(function(){
					grouppost_info.attention_author.push($(this).val());
				})
				$("input[name='author']").each(function(){
                    grouppost_info.author.push($(this).val());
				})
                
                var rel_activity=           $("input[name='rel_activity']:checked").val();
                var rel_activity_name=      $("input[name='rel_activity_name']").val();
                var rel_activity_time=      $("input[name='rel_activity_time']").val();
                var rel_activity_population=$("input[name='rel_activity_population']").val();
                var pos=                    $("input[name='pos']:checked").val();
                var pos_for=                $("input[name='pos_for']:checked").val() || 0;
                var pos_forother=           $("input[name='pos_forother']").val();
                var neg=                    $("input[name='neg']:checked").val();
                var neg_for=                $("input[name='neg_for']:checked").val() || 0;
                var neg_forother=           $("input[name='neg_forother']").val();
                var rel_activity_atm=       $("input[name='rel_activity_atm']:checked").val();
                var gain_spiritual=         $("input[name='gain_spiritual']:checked").val();
                var mood0=                  $("input[name='mood0']:checked").val();
                var mood1=                  $("input[name='mood1']:checked").val();
                var gain_instrumental=      $("input[name='gain_instrumental']:checked").val();              
                
                var record=[], j=0;
                if(!mood)                                                                       {record[j]="1"; j++;    $("#warning1").show()}
                if(!symptom|(symptom==1&symptom_sum==0)|(symptom_other_chk==1&!symptom_other))  {record[j]="2"; j++;    $("#warning2").show()}
                if(!contact)                                                                    {record[j]="3"; j++;    $("#warning3").show()}
                if(groupview.length==0)                                                         {record[j]="4"; j++;     $("#warning4").show()}
                if(grouppost.length==0)                                                         {record[j]="5"; j++;     $("#warning5").show()}
                if(!grouppost_attention|(grouppost_attention==1&(grouppost_info.attention_for.length<grouppost_info.author.length|grouppost_info.attention_author.length<grouppost_info.author.length)))
                                                                                                {record[j]="6"; j++;     $("#warning6").show()}
                if(!rel_activity|(rel_activity==1&(!rel_activity_name|!rel_activity_time|!rel_activity_population)))
                                                                                                {record[j]="7"; j++;     $("#warning7").show()}
                if(rel_activity==1&(!pos|(pos==1&pos_for==0)|(pos_for==6&!pos_forother)))       {record[j]="8"; j++;     $("#warning8").show()}
                if(rel_activity==1&(!neg|(neg==1&neg_for==0)|(neg_for==6&!neg_forother)))       {record[j]="9"; j++;     $("#warning9").show()}
                if(rel_activity==1&!rel_activity_atm)                                           {record[j]="10"; j++;   $("#warning10").show()}
                if(rel_activity==1&!gain_spiritual)                                             {record[j]="11"; j++;   $("#warning11").show()}
                if(rel_activity==1&!mood0)                                                      {record[j]="12"; j++;   $("#warning12").show()}
                if(rel_activity==1&!mood1)                                                      {record[j]="13"; j++;   $("#warning13").show()}
                if(rel_activity==1&!gain_instrumental)                                          {record[j]="14"; j++;   $("#warning14").show()}
                
                if(j>0){
                    $("#submit2").attr("disabled", false);
                    $.alert({
						title: "",
					    content: "您好，第 "+record+" 題尚未填答完畢唷！",
					})
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "",
                        data: {
                            formSubmit2: 1,
                            date: date,
                            mood: mood,
                            symptom: symptom,
                            symptom_sick: symptom_sick,
                            symptom_fever: symptom_fever,
                            symptom_cough: symptom_cough,
                            symptom_sorethroat: symptom_sorethroat,
                            symptom_hospital: symptom_hospital,
                            symptom_other: symptom_other,
                            contact: contact,
                            groupview: groupview,
                            grouppost: grouppost,
                            grouppost_info: grouppost_info,
                            rel_activity: rel_activity,
                            rel_activity_name: rel_activity_name,
                            rel_activity_time: rel_activity_time,
                            rel_activity_population: rel_activity_population,
                            pos_for: pos_for,
                            pos_forother: pos_forother,
                            neg_for: neg_for,
                            neg_forother: neg_forother,
                            rel_activity_atm: rel_activity_atm,
                            gain_spiritual: gain_spiritual,
                            mood0: mood0,
                            mood1: mood1,
                            gain_instrumental: gain_instrumental   
                        },
                        success: function(data){
                            console.log(data);
                            
                            if(data){
                                Today.setMonth(Today.getMonth());
                                Today.setDate(0);
                                var monthdays=Today.getDate();
                                progressbar(data[0]["COUNT(*)"]/monthdays);                              
                                
                                function progressbar(prob){
                                    var bar=new ProgressBar.Circle(container,{
                                    color: "#2E317C",
                                    easing: "easeInOut",
                                    strokeWidth: 7.5,
                                    trailWidth: 7.5,
                                    duration: 1500,
                                    text: {autoStyleContainer: false},
                                    from: {color: "#AAAAAA", width: 7.5},
                                    to: {color: "#2E317C", width: 7.5},
                                    step: function(state, bar){
                                        bar.setText(Math.round(bar.value()*monthdays, 0)); 
                                        }
                                    })
                                    bar.text.style.fontFamily="'Raleway', Helvetica, sans-serif";
                                    bar.text.style.fontSize="3vmax";
                                    bar.animate(prob);
                                }
                                    
                                $("#success").modal("show");
                                $(".hhdate").empty().append(date);
                                setTimeout("window.location.href='./main.php'", 5000); 
                            }
                        }, error: function(){
                            console.log(e);
                        }
                    })
                }
            })
            
            if(window.matchMedia("(max-width: 800px)").matches){
                $(".btn-group-toggle").removeClass("btn-group").addClass("btn-group-vertical");
                $(".col-sm-5").removeClass("col-sm-5").addClass("col-sm-12");
                $(".col-sm-7").removeClass("col-sm-7").addClass("col-sm-12");
                $(".col-sm-3").removeClass("col-sm-3").addClass("col-sm-12");
                $(".col-sm-9").removeClass("col-sm-9").addClass("col-sm-12");
                $(".col-sm-4").removeClass("col-sm-4").addClass("col-sm-12");
                $(".col-sm-8").removeClass("col-sm-8").addClass("col-sm-12");
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
    
    <div id="success" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: yellow">⭐ 作答完成 ⭐</h5>
            </div>
                
            <div class="modal-body">
                <div class="groupf">
                    <div align="center">
                        本月完成天數
                        <div id="container"></div>	
                    </div>
                    <div>
                        <br>您已完成【<b><span class="hhdate"></span></b>】的生活日記！
                        <br><br>
                        提醒您：也別忘了填寫接觸紀錄唷！<br>5 秒後將為您導回：主畫面
                    </div>
                </div>
            </div>
            <div style="text-align: right; padding: 1%">❸</div>
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
                <button id="yesterday" class="btn btn-warning" style="margin: 2.5%">
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/diary.png"></div>
                    <div style="display: inline-block; width: 6em"><?=date("m/d", strtotime("-1 day"))?> (昨天)</div>
                </button>
                <button id="yesterday_done" class="btn btn-warning" style="margin: 2.5%; filter: brightness(25%); cursor: not-allowed" disabled>
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/diary.png"></div>
                    <div style="display: inline-block; width: 6em"><h5 style="color: #2E317C"><b>您已完成</b></h5></div>
                </button>
                <button id="today_yet" class="btn btn-info" style="margin: 2.5%; filter: brightness(50%); cursor: not-allowed" disabled>
                    <div style="display: inline-block"><img style="width: 4.5em" src="./pic/lock.png"></div>
                    <div style="display: inline-block; width: 6em"><h5 style="color: #FFFFBB">18:00 解鎖</h5></div>
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
        <div class="title">生活日記</div>
    </div>    
    <input type="radio" name="date" value="<?=$yesterday?>" style="display: none">
    <input type="radio" name="date" value="<?=$today?>" style="display: none">
    
    <div class="container" style="display: none">
        <div class="infobar">
            <b><span style="background-color: orange; padding: 0.5em; -webkit-border-radius: 10px 0px 0px 10px; border-radius: 10px 0px 0px 10px">填寫日期</span><span style="background-color: yellow; padding: 0.5em; -webkit-border-radius: 0px 10px 10px 0px; border-radius: 0px 10px 10px 0px"><span class="hdate"></span></span></b>
        </div><br>
        
        <div class="card">
            <div class="card-body">
                <form id="hdiaryForm">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                
                <p>
                    第一部分：整體概況
                </p>
                <div id="warning1" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
                    <span class="input-group-text part1">1. <b><span class="hdate"></span></b> 心情如何？</span>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="mood" value="0">非常好</label>
				    <label class="btn btn-outline-success"><input type="radio" name="mood" value="1">很好</label>
				    <label class="btn btn-outline-success"><input type="radio" name="mood" value="2">還好</label>
				    <label class="btn btn-outline-success"><input type="radio" name="mood" value="3">不好</label>
				    <label class="btn btn-outline-success"><input type="radio" name="mood" value="4">非常不好</label>
				</div><br><br>
                
                <div id="warning2" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <span class="input-group-text part1">2. <b><span class="hdate"></span></b> 是否身體不適？</span>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="symptom" value="1">有</label>
				    <label class="btn btn-outline-success"><input type="radio" name="symptom" value="0">無</label>
				</div><br>
                <div name="symptom_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>請點選症狀：<span style="background-color: #5CB85C; color: #FFFFFF">可複選</span></div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-success"><input type="checkbox" name="sick">確定有感冒</label>
				        <label class="btn btn-outline-success"><input type="checkbox" name="fever"><b title="★ 高於 38 度 ★">發燒<i class="fa fa-info-circle"></i></b></label>
				        <label class="btn btn-outline-success"><input type="checkbox" name="cough">咳嗽</label>
				        <label class="btn btn-outline-success"><input type="checkbox" name="sorethroat">喉嚨痛</label>
                        <label class="btn btn-outline-success"><input type="checkbox" name="hospital">前往就醫（含診所）</label>
                        <label class="btn btn-outline-success"><input type="checkbox" name="symptom_other_chk">其他</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control" type="text" name="symptom_other" placeholder="請描述身體不適的症狀" style="display: none">
				    </div>
                </div><br>
                
                <div id="warning3" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
                    <span class="input-group-text part1">3. <b><span class="hdate"></span></b> 我大概<b title="★ 雙方互動超過三句以上的對話，包含 LINE ★">接觸<i class="fa fa-info-circle"></i></b>多少位宗教生活圈中的人？</span>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="contact" value="0">0 人</label>
                    <label class="btn btn-outline-success"><input type="radio" name="contact" value="1">1-4 人</label>
                    <label class="btn btn-outline-success"><input type="radio" name="contact" value="2">5-9 人</label>
                    <label class="btn btn-outline-success"><input type="radio" name="contact" value="3">10-19 人</label>
                    <label class="btn btn-outline-success"><input type="radio" name="contact" value="4">20 人以上</label>
				</div><br><br><hr>
                
                <p>
                    第二部分：宗教訊息互動
                </p>
                <div class="groupf">
                    <div>
                    <div class="col-sm-auto">
				        我在 <b><span class="hdate"></span></b> ...
				    </div><br>
                        
                    <div id="warning4" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                    <div class="col-sm-auto">
				        <div class="input-group-text">4. 曾查閱／瀏覽了哪些宗教群組？<span style="background-color: #6C757D; color: #FFFFFF">可複選</span></div>
				    </div>
                    <div class="vertical_wrapper1">
                        <div class="btn-group-vertical btn-group-toggle col-sm-12 view" data-toggle="buttons">
				        <label class="btn btn-outline-secondary" style="padding-left: 2%; text-align: left">
                            <input type="checkbox" class="4e" name="groupview[]"><span class="groupview"></span>
                        </label>
                        </div>
                    </div><br>
                
                    <div id="warning5" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                    <div class="col-sm-auto">
				        <div class="input-group-text">5. 曾在哪些宗教群組回應／發文？<span style="background-color: #6C757D; color: #FFFFFF">可複選</span></div>
				    </div>
                    <div class="vertical_wrapper2">
                        <div class="btn-group btn-group-toggle col-sm-12 post" data-toggle="buttons">
				        <label class="btn btn-outline-secondary" style="padding-left: 2%; text-align: left">
                            <input type="checkbox" class="5e" name="grouppost[]"><span class="grouppost"></span>
                        </label>
                        </div>
                    </div>
                    </div>
                
                    <div class="appendbox">
                        <p style="letter-spacing: 0; color: #FFFFFF"><b>符合的群組不在清單內嗎？</b></p>
                        <button id="create_group" class="btn btn-outline-light"><img style="width: 3em" src="./pic/create_alter.png"><br>立即新增群組</button>
                    </div>
                </div><br>
                
                <div id="group_append" class="modal fade" style="top: 0">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="font-size: 1.25em; background-color: yellow">⭐ 新增群組 ⭐</h5>
                            <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                
                        <div class="modal-body" style="padding-bottom: 1em; font-size: 1em">
                            <form id="groupAppendForm">
                            <div class="vertical_wrapper3">
                            <div class="newgroup_info">
                                <div style="padding-bottom: 1em; text-align: center">新增群組</div>
                    
                                <div id="samegname" class="col-sm-auto" style="color: #EE475D; display: none"><b><i class="fa fa-times-circle"></i> 已有同名的宗教群組囉</b></div>
                                <div class="row">
                                    <div class="col-sm-5 pl-0 pr-0">
				                        <div class="input-group-text">A. 群組名稱：</div>
				                    </div>
                                    <div class="col-sm-7 pl-0 pr-0">
				                        <input class="form-control btn-outline-secondary" type="text" name="group_name">
				                    </div>
                                </div>
                
                                <div class="row">
                                    <div class="col-sm-5 pl-0 pr-0">
				                        <div class="input-group-text">B. 我在群組中使用的名字：</div>
				                    </div>
                                    <div class="col-sm-7 pl-0 pr-0">
				                        <input class="form-control btn-outline-secondary" type="text" name="group_myname">
				                    </div>
				                </div>
                    
                                <div class="row">
                                    <div class="col-sm-5 pl-0 pr-0">
				                        <div class="input-group-text">C. 查閱群組的頻率：</div>
				                    </div>
                                    <div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
				                        <label class="btn btn-outline-secondary"><input type="radio" class="group_freq" name="newgroup_freq_0" value="0">每天多次</label>
				                        <label class="btn btn-outline-secondary"><input type="radio" class="group_freq" name="newgroup_freq_0" value="1">每天一次</label>
                                        <label class="btn btn-outline-secondary"><input type="radio" class="group_freq" name="newgroup_freq_0" value="2">兩、三天一次</label>
                                        <label class="btn btn-outline-secondary"><input type="radio" class="group_freq" name="newgroup_freq_0" value="3">偶爾</label>
				                    </div>
				                </div>
                    
                                <div class="row" style="padding-bottom: 1em">
                                    <div class="col-sm-5 pl-0 pr-0">
				                        <div class="input-group-text">D. 我曾邀請多少人加入此群組？</div>
				                    </div>
                                    <div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
				                        <label class="btn btn-outline-secondary"><input type="radio" class="group_invite" name="newgroup_invite_0" value="0">0 人</label>
				                        <label class="btn btn-outline-secondary"><input type="radio" class="group_invite" name="newgroup_invite_0" value="1">1-4 人</label>
                                        <label class="btn btn-outline-secondary"><input type="radio" class="group_invite" name="newgroup_invite_0" value="2">>5 人</label>
				                    </div>
				                </div>
                            </div>
                            </div>
                
                            <div class="add_minus"><hr>
                                <button id="group_add" class="btn" style="margin: -0.4em"><i class="fas fa-plus-circle"></i></button>
                                <button id="group_minus" class="btn" style="margin: -0.4em"><i class="fas fa-minus-circle"></i></button>
				            </div><br>
                            <div style="text-align: center">
                                <button id="submit1" class="btn">
                                    <img src="/pic/submit.png" class="icon">
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
                
                <div id="warning6" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text long">6. 在宗教群組中，是否閱讀到令我特別關注的發文？</div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="grouppost_attention" value="1">是</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="grouppost_attention" value="0">否</label>
				</div><br><br>
    
                <div class="vertical_wrapper4" style="display: none">
                <div class="grouppost_attention_detail">
                    <div style="text-align: center">有感發文</div>
                    <div class="row" style="padding-top: 1em">
                        <div class="col-sm-3 pl-0 pr-0">
				            <div class="input-group-text">A. 特別關注的原因是：</div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-9 pl-0 pr-0" data-toggle="buttons">
				            <label class="btn btn-outline-secondary"><input type="radio" class="attention_for" name="attention_for_0" value="1"><b title="★ 文化知識、歷史知識等 ★">知識性<i class="fa fa-info-circle"></i></b></label>
				            <label class="btn btn-outline-secondary"><input type="radio" class="attention_for" name="attention_for_0" value="2">訊息公告</label>
				            <label class="btn btn-outline-secondary"><input type="radio" class="attention_for" name="attention_for_0" value="3">靈性的收穫與感動</label>
				            <label class="btn btn-outline-secondary"><input type="radio" class="attention_for" name="attention_for_0" value="4">溫馨的感受</label>
                            <label class="btn btn-outline-secondary"><input type="radio" class="attention_for" name="attention_for_0" value="5">其他</label>
				        </div>
				    </div>
                    
                    <div class="row" style="padding-bottom: 1em">
                        <div class="col-sm-4 pl-0 pr-0">
				            <div class="input-group-text">B. 是否留意這篇文是誰發的？</div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-8 pl-0 pr-0" data-toggle="buttons">
				            <label class="btn btn-outline-secondary"><input type="radio" class="attention_author" name="attention_author_0" value="1">是</label>
				            <label class="btn btn-outline-secondary"><input type="radio" class="attention_author" name="attention_author_0" value="0">否</label>
				        </div>
                        <div class="col-sm-12 pl-0 pr-0">
				            <input class="form-control btn-outline-secondary" type="text" name="author" placeholder="請填寫發文者在群組使用的名字" style="display: none">
				        </div>
				    </div>
                </div>
                </div>
                
                <div class="add_minus" style="display: none">
                    <button id="grouppost_add" class="btn" style="margin: -0.4em"><i class="fas fa-plus-circle"></i></button>
                    <button id="grouppost_minus" class="btn" style="margin: -0.4em"><i class="fas fa-minus-circle"></i></button>
				</div><br><hr>
                
                <p>
                    第三部分：宗教活動參與
                </p>
                <div id="warning7" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">7. <b><span class="hdate"></span></b> 是否參與團體性的宗教活動？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="rel_activity" value="1">有</label>
				    <label class="btn btn-outline-info"><input type="radio" name="rel_activity" value="0">無</label>
				</div><br>
                <div id="rel_activity_detail" style="display: none">
                <div class="col-sm-auto">
				    <input class="form-control" type="text" name="rel_activity_name" placeholder="簡述活動名稱">
                    <input class="form-control" type="text" name="rel_activity_time" placeholder="簡述活動時間">
                    <input class="form-control" type="text" name="rel_activity_population" placeholder="簡述活動人數">
				</div><br>   
                
                <div id="warning8" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">8. 活動中我是否經歷特別<b title="★ 如啟發、感動、神秘體驗等 ★">印象深刻<i class="fa fa-info-circle"></i></b>的事情／物件？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="pos" value="1">有</label>
				    <label class="btn btn-outline-info"><input type="radio" name="pos" value="0">無</label>
				</div><br>
                <div name="pos_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>請選擇：</div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-info"><input type="radio" name="pos_for" value="1">義工間的互動</label>
				        <label class="btn btn-outline-info"><input type="radio" name="pos_for" value="2">信徒的行為</label>
				        <label class="btn btn-outline-info"><input type="radio" name="pos_for" value="3">儀式物件</label>
				        <label class="btn btn-outline-info"><input type="radio" name="pos_for" value="4">活動氛圍</label>
                        <label class="btn btn-outline-info"><input type="radio" name="pos_for" value="5">個人的神祕體驗</label>
                        <label class="btn btn-outline-info"><input type="radio" name="pos_for" value="6">其他</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control" type="text" name="pos_forother" placeholder="請描述令我印象深刻的事情／物件" style="display: none">
				    </div>
                </div><br>
                
                <div id="warning9" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">9. 活動中我是否經歷有特別負面感受的事件？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="neg" value="1">有</label>
				    <label class="btn btn-outline-info"><input type="radio" name="neg" value="0">無</label>
				</div><br>
                <div name="neg_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>請選擇：</div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-info"><input type="radio" name="neg_for" value="1">義工間的互動</label>
				        <label class="btn btn-outline-info"><input type="radio" name="neg_for" value="2">信徒的行為</label>
				        <label class="btn btn-outline-info"><input type="radio" name="neg_for" value="3">儀式物件</label>
				        <label class="btn btn-outline-info"><input type="radio" name="neg_for" value="4">活動氛圍</label>
                        <label class="btn btn-outline-info"><input type="radio" name="neg_for" value="5">個人的神祕體驗</label>
                        <label class="btn btn-outline-info"><input type="radio" name="neg_for" value="6">其他</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control" type="text" name="neg_forother" placeholder="請描述令我有特別負面感受的事情／物件" style="display: none">
				    </div>
                </div><br>
                
                <div id="warning10" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">10. 活動中我對團體的整體氣氛印象？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="rel_activity_atm" value="0">非常好</label>
				    <label class="btn btn-outline-info"><input type="radio" name="rel_activity_atm" value="1">很好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="rel_activity_atm" value="2">還好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="rel_activity_atm" value="3">不好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="rel_activity_atm" value="4">非常不好</label>
				</div><br><br>
                
                <div id="warning11" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">11. 參加後，是否有任何靈性方面的啟發／感受？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="gain_spiritual" value="0">很大</label>
				    <label class="btn btn-outline-info"><input type="radio" name="gain_spiritual" value="1">有一點</label>
                    <label class="btn btn-outline-info"><input type="radio" name="gain_spiritual" value="2">幾乎沒有</label>
                    <label class="btn btn-outline-info"><input type="radio" name="gain_spiritual" value="3">有額外損失／付出</label>
				</div><br><br>
                
                <div id="warning12" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">12. 參加<b>前</b>，我的心情如何？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="mood0" value="0">非常好</label>
				    <label class="btn btn-outline-info"><input type="radio" name="mood0" value="1">很好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="mood0" value="2">還好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="mood0" value="3">不好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="mood0" value="4">非常不好</label>
				</div><br><br>
                
                <div id="warning13" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">13. 參加<b>後</b>，我的心情如何？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="mood1" value="0">非常好</label>
				    <label class="btn btn-outline-info"><input type="radio" name="mood1" value="1">很好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="mood1" value="2">還好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="mood1" value="3">不好</label>
                    <label class="btn btn-outline-info"><input type="radio" name="mood1" value="4">非常不好</label>
				</div><br><br>
                
                <div id="warning14" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part3">14. 除了心情、靈性啟發之外，我是否有<b title="★ 例如：健康、資訊 ... 等 ★">其他收穫<i class="fa fa-info-circle"></i></b>？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-info"><input type="radio" name="gain_instrumental" value="0">很大</label>
				    <label class="btn btn-outline-info"><input type="radio" name="gain_instrumental" value="1">有一點</label>
                    <label class="btn btn-outline-info"><input type="radio" name="gain_instrumental" value="2">幾乎沒有</label>
                    <label class="btn btn-outline-info"><input type="radio" name="gain_instrumental" value="3">有額外損失／付出</label>
				</div>
                </div><br>
                
                <div style="text-align: center">
                    <button id="submit2" class="btn">
                        <img src="/pic/submit.png" class="icon">
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
		
	<?php include("footer.php");?>
</body>
</html>

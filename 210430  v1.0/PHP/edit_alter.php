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
            $sql1="SELECT alter_name FROM `alter_list` WHERE ego_id= :v1 and alter_id= :v2";
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

    if(isset($_POST["fetchGroupList"])){
		$sql2="SELECT * FROM `group_list` WHERE id = :v1";
		$stmt=$db->prepare($sql2);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        
		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["fetchCity"])){
		$sql3="SELECT DISTINCT City, COUN_ID FROM `county` ORDER BY CityID";
		$stmt=$db->prepare($sql3);
		$stmt->execute();

		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["fetchAlter"])){
		$sql4="SELECT * FROM `alter_list` WHERE ego_id= :v1 and alter_id= :v2 ORDER BY create_time DESC LIMIT 1";
		$stmt=$db->prepare($sql4);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $alter_id);
		$stmt->execute();
        
		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["searchAlter"])){
		$sql5="SELECT * FROM `alter_list` WHERE ego_id= :v1 and alter_name= :v2";
		$stmt=$db->prepare($sql5);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v2", $_POST["alter_name"]);
		$stmt->execute();
        $rs4=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount()==1){
			echo "duplicate";
		}
		exit();
	}

    if(isset($_POST["fetchTown"])){
		$sql6="SELECT DISTINCT District, TOWN_ID FROM `county` WHERE City= :v1 ORDER BY TOWN_ID";
		$stmt=$db->prepare($sql6);
		$stmt->bindParam(":v1", $_POST["city"]);
		$stmt->execute();

		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["formSubmit1"])){
        $group_n=count($_POST["group_list"]["group_name"]);
 
        for($i=0; $i<$group_n; $i++){
            $sql7="INSERT INTO `group_list` VALUES (NULL, :v2, :v3, :v4, :v5, :v6, :v7, NOW())";
            $stmt=$db->prepare($sql7);
            $stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
            $stmt->bindParam(":v3", $_POST["group_list"]["group_name"][$i]);
            $stmt->bindParam(":v4", $_POST["group_list"]["group_myname"][$i]);
            $stmt->bindParam(":v5", $_POST["group_list"]["group_freq"][$i]);
            $stmt->bindParam(":v6", $_POST["group_list"]["group_religion"][$i]);
            $stmt->bindParam(":v7", $_POST["group_list"]["group_invite"][$i]);
            $stmt->execute();
        }
        $sql8="SELECT * FROM `group_list` WHERE id= :v1";
		$stmt=$db->prepare($sql8);
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
        $samegroup=implode(",", $_POST["samegroup"]);
        $relationship=implode(",", $_POST["relationship"]);
        $index_duplicate=$_SESSION["acc_info"]["id"]."_".$_POST["alter_name"];
        
        try{
            $sql9="UPDATE `alter_list` SET alter_name= :v4, alter_nickname= :v5, group_info= :v6, relationship= :v7, relationship_other= :v8, seniority= :v9, gender= :v10, age= :v11, occupation= :v12, education= :v13, marriage= :v14, city= :v15, town= :v16, res_other= :v17, acquaintance= :v18, contact_freq= :v19, closeness= :v20, rel_group= :v21, index_duplicate= :v22, create_time= NOW() WHERE ego_id= :v1 and alter_id= :v2";
            $stmt=$db->prepare($sql9);
            $stmt->bindParam(":v4", $_POST["alter_name"]);
            $stmt->bindParam(":v5", $_POST["alter_nickname"]);
            $stmt->bindParam(":v6", $samegroup);
            $stmt->bindParam(":v7", $relationship);
            $stmt->bindParam(":v8", $_POST["relationship_other"]);
            $stmt->bindParam(":v9", $_POST["seniority"]);
            $stmt->bindParam(":v10", $_POST["gender"]);
            $stmt->bindParam(":v11", $_POST["age"]);
            $stmt->bindParam(":v12", $_POST["occupation"]);
            $stmt->bindParam(":v13", $_POST["education"]);
            $stmt->bindParam(":v14", $_POST["marriage"]);
            $stmt->bindParam(":v15", $_POST["city"]);
            $stmt->bindParam(":v16", $_POST["town"]);
            $stmt->bindParam(":v17", $_POST["res_other"]);
            $stmt->bindParam(":v18", $_POST["acquaintance"]);
            $stmt->bindParam(":v19", $_POST["contact_freq"]);
            $stmt->bindParam(":v20", $_POST["closeness"]);
            $stmt->bindParam(":v21", $_POST["rel_group"]);
            $stmt->bindParam(":v22", $index_duplicate);
            $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
            $stmt->bindParam(":v2", $alter_id);
            $stmt->execute();
            
            echo "Alter Update Success";
        }catch(PDOException $e){
            echo "Index Duplicate";
        }
		exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>接觸對象修改</title>
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
    
    <!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>

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
        
        .input-group-text, .btn, .form-control{
            font-size: 1em;
        }
        
        .part1{
            background-color: #FBDA41;
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
        
		/* RESPONSIVE */
		@media screen and (max-width: 800px){
            .modal{
                top: 30vmax;
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
                       $(".alter_name_fill").html(data);
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
                            var tmp1=$(".grouplist").clone().last();
                            if(i==0){$(".grouplist").remove()};
							tmp1.find("span[class='samegroup']").empty().append(data[i].group_name);
                            tmp1.find("input[name='samegroup[]']").attr("value", data[i].group_name);
							$(".vertical_wrapper1").append(tmp1);
                        }
                        var tmp2=$(".grouplist").clone().last();
                        tmp2.find("span[class='samegroup']").empty().append("以上皆無");
                        tmp2.find("input[name='samegroup[]']").removeClass("2e").addClass("2o").attr("value", "以上皆無");
				        $(".vertical_wrapper1").append(tmp2);
                    }
                }, error: function(e){
                    console.log(e);
                }
            })
            
            $.ajax({ 
                type: "POST",
                dataType: "json",
                async: "false",
                url: "",
                data: {fetchCity: 1},
				success: function(data){
                    console.log(data);
                    
                    $("#city").empty();
                    $("#city").append($("<option>").html("請選擇").attr("value", ""));
                    for(var key in data){
                        $("#city").append($("<option>").html(data[key].City).attr("value", data[key].City))
                    };
                    $("#city").append($("<option>").html("國外").attr("value", "國外"));
                    $("#city").append($("<option>").html("不知道").attr("value", "不知道"));
                    
                    $.ajax({ 
                        type: "POST",
                        dataType: "json",
                        async: "false",
                        url: "",
                        data: {fetchAlter: 1},
                        success: function(data){
                            console.log(data);
                            
                            if(data){
                                fillAnswer(data);
                            }
                        }
                    })
                }, error: function(e){
                    console.log(e);
                }
            })
            
            $("input[name='alter_name']").on("input", function(event){
                event.preventDefault();
                var alter_name=$(this).val();
                
                $.ajax({ 
                    type: "POST",
                    url: "",
                    data: {searchAlter: 1, alter_name: alter_name},
                    success: function(data){
                        console.log(data);
                        
                        if(data=="duplicate"){
                            $("#samename").show();
                            $(".alter_name_fill").html("他／她");
                        }else{
                            $("#samename").hide();
                            $(".alter_name_fill").empty().append(alter_name); 
                        }
                    }, error: function(e){
                        console.log(e);
                    }     
                })
            })
            
            $(jQuery).on("change", ".2o", function(event){
                event.preventDefault();
                var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $(".2e").prop("checked", false).parent().removeClass("active");
                    $(".2e").attr("disabled", true);
                }else{
                    $(".2e").attr("disabled", false);
                }
            })
            
            $("#create_group").on("click", function(event){
			    event.preventDefault();
			    $("#group_append").modal("show");
			})
            
            $("#group_add").on("click", function(event){
				event.preventDefault();
				var tmp=$(".newgroup_info").clone().last();
                
                tmp.find("input[type='text']").val("");
                tmp.find("label").removeClass("active");
                var index=parseInt(tmp.find("input[class='group_freq']").attr("name").split("_").slice(-1)[0]);
				tmp.find("input[class='group_freq']").attr("name", "newgroup_freq_"+(index+1)).prop("checked", false);
				tmp.find("input[class='group_invite']").attr("name", "newgroup_invite_"+(index+1)).prop("checked", false);             
                
				$(".vertical_wrapper2").append(tmp);
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
                                    var tmp1=$(".grouplist").clone().last();
                                    if(i==0){$(".grouplist").remove()};
                                    tmp1.find("span[class='samegroup']").empty().append(data[i].group_name);
                                    tmp1.find("input[name='samegroup[]']").removeClass("2o").addClass("2e").attr("value", data[i].group_name);
                                    $(".vertical_wrapper1").append(tmp1);
                                }
                                var tmp2=$(".grouplist").clone().last();
                                tmp2.find("span[class='samegroup']").empty().append("以上皆無");
                                tmp2.find("input[name='samegroup[]']").removeClass("2e").addClass("2o").attr("value", "以上皆無");
				                $(".vertical_wrapper1").append(tmp2);

                                $("#group_append").modal("hide");
                            }
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
            })
            
            $("#city").on("change", function(){
                event.preventDefault();
				var city=$(this).val();
                
                if(city=="國外"){
                    $("#town").empty();
                    $("input[name='res_other']").show();
                }else if(city=="不知道"){
                    $("#town").empty();
                    $("input[name='res_other']").hide().val("");
                }else{
                    $("input[name='res_other']").hide().val("");
                    
                    $.ajax({ 
                        type: "POST",
                        dataType: "json", 
                        url: "",
                        data: {fetchTown: 1, city: city},
				        success: function(data){
                            console.log(data);
                            
                            $("#town").empty();
                            $("#town").append($("<option>").html("請選擇").attr("value", ""));
                            for(var key in data){
                                $("#town").append($("<option>").html(data[key].District).attr("value", data[key].District))
                            };
                            $("#town").append($("<option>").html("不知道").attr("value", "不知道"));
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
            })
            
            $("#submit2").on("click", function(event){
                event.preventDefault();
                $(".warn").hide();
                
                var alter_name=         $("input[name='alter_name']").val();
                var samegroup=          $("input[name='samegroup[]']:checked").map(function(){return $(this).val()}).get();
                var relationship=       $("input[name='relationship[]']:checked").map(function(){return $(this).val()}).get();
                var relationship_other= $("input[name='relationship_other']").val();
                var seniority=          $("input[name='seniority']:checked").val();
                var gender=             $("input[name='gender']:checked").val();
                var age=                $("select[id='age']").val();
                var occupation=         $("select[id='occupation']").val();
                var education=          $("select[id='education']").val();
                var marriage=           $("input[name='marriage']:checked").val();
                var city=               $("select[id='city']").val();
                var town=               $("select[id='town']").val();
                var res_other=          $("input[name='res_other']").val();
                var acquaintance=       $("select[id='acquaintance']").val();
                var contact_freq=       $("input[name='contact_freq']:checked").val();
                var closeness=          $("input[name='closeness']:checked").val();
                var rel_group=          $("input[name='rel_group']:checked").val();               
                
                var record=[], j=0;
                if(!alter_name)                                                         {record[j]="1"; j++;    $("#warning1").show()}
                if(samegroup=="")                                                       {record[j]="2"; j++;    $("#warning2").show()}
                if(relationship=="")                                                    {record[j]="3"; j++;    $("#warning3").show()}
                if(!seniority)                                                          {record[j]="4"; j++;    $("#warning4").show()}
                if(!gender)                                                             {record[j]="5"; j++;    $("#warning5").show()}
                if(!age)                                                                {record[j]="6"; j++;    $("#warning6").show()}
                if(!occupation)                                                         {record[j]="7"; j++;    $("#warning7").show()}
                if(!education)                                                          {record[j]="8"; j++;    $("#warning8").show()}
                if(!marriage)                                                           {record[j]="9"; j++;    $("#warning9").show()}
                if(!city|(city!="國外"&city!="不知道"&!town)|(city=="國外"&!res_other))   {record[j]="10"; j++;    $("#warning10").show()}
                if(!acquaintance)                                                       {record[j]="11"; j++;   $("#warning11").show()}
                if(!contact_freq)                                                       {record[j]="12"; j++;   $("#warning12").show()}
                if(!closeness)                                                          {record[j]="13"; j++;   $("#warning13").show()}
                if(!rel_group)                                                          {record[j]="14"; j++;   $("#warning14").show()}
                
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
                        url: "",
                        data: {
                            formSubmit2: 1,
                            alter_name: alter_name,
                            alter_nickname: 999,
                            samegroup: samegroup,
                            relationship: relationship,
                            relationship_other: relationship_other,
                            seniority: seniority,
                            gender: gender,
                            age: age,
                            occupation: occupation,
                            education: education,
                            marriage: marriage,
                            city: city,
                            town: town,
                            res_other: res_other,
                            acquaintance: acquaintance,
                            contact_freq: contact_freq,
                            closeness: closeness,
                            rel_group: rel_group
                        },
                        success: function(data){
                            console.log(data);
                            
                            if(data=="Index Duplicate"){
                                $("#submit2").attr("disabled", false);
                                $.alert({
								    title: "接觸對象名稱重複",
								    content: "【<b>"+alter_name+"</b>】已經在您的接觸對象清單了。請修正！",
                                })
                            }else if(data=="Alter Update Success"){
                                $("#success").modal("show");
                                setTimeout("window.location.href='./alter_list.php'", 5000);
                            }
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
            })
            
            function fillAnswer(data){
                $("#town").append($("<option>").html(data[0]["town"]).attr("value", data[0]["town"]));
                _.map(data[0], function(value, key){
                    $("input[type='text'][name='"+key+"']").val(value);
                    $("select[id='"+key+"']").val(value).attr("selected", "selected");
                    $("input[type='radio'][name='"+key+"'][value='"+value+"']").prop("checked", true).parent().addClass("active");
                })
                        
                var samegroup=data[0]["group_info"].split(",");
                for(i=0; i<samegroup.length; i++){
                    $("input[name='samegroup[]'][value='"+samegroup[i]+"']").prop("checked", true).parent().addClass("active");
                }
    
                var relationship=data[0]["relationship"].split(",");
                for(i=0; i<relationship.length; i++){
                    $("input[name='relationship[]'][value='"+relationship[i]+"']").prop("checked", true).parent().addClass("active");
                }
                        
                if(data[0]["res_other"]!=""){
                    $("input[name='res_other']").show();
                } 
            }
            
            if(window.matchMedia("(max-width: 800px)").matches){
                $(".btn-group-toggle").removeClass("btn-group").addClass("btn-group-vertical");
                $(".col-sm-5").removeClass("col-sm-5").addClass("col-sm-12");
                $(".col-sm-7").removeClass("col-sm-7").addClass("col-sm-12");
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
                    很抱歉，您使用的連結有誤！<br>請在 <b><a href="./alter_list.php">管理接觸對象</a></b> 重新選擇所要修改的對象
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
                <h5 class="modal-title" style="background-color: yellow">⭐ 更新完成 ⭐</h5>
            </div>
            
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/greeting.png"></div>
                <p>
                    <br>已更新【<b><span class="alter_name_fill"></span></b>】的個人資料囉！
                    <br><br>
                    5 秒後將為您導回：接觸對象管理頁
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❾</div>
        </div>
        </div>
    </div>
    
    <div class="wrap">
        <img id="title" src="./pic/square.png">
        <div class="title">修改接觸對象</div>
    </div>
    
    <div class="container">      
        <div class="card">
            <div class="card-body">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                
                <p>
                    第一部分：基本資料
                </p>
                <div id="warning1" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div id="samename" class="col-sm-auto" style="color: #EE475D; display: none"><b><i class="fa fa-times-circle"></i> 接觸清單中已有此人囉</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">1. 接觸對象姓名／暱稱：</div>
				</div>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="alter_name" placeholder="建議填寫對方在 LINE 中的名稱，或您能辨識記憶的名字">
				</div><br>
                
                <div class="groupf">
                    <div>
                    <div id="warning2" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                    <div class="col-sm-auto">
				        <div class="input-group-text part1">2. <b><span class="alter_name_fill"></span></b> 是否也在我參與的宗教群組中？<span style="background-color: #5CB85C; color: #FFFFFF">可複選</span></div>
				    </div>
                    <div class="vertical_wrapper1">
                        <div class="btn-group-vertical btn-group-toggle col-sm-12 grouplist" data-toggle="buttons">
				        <label class="btn btn-outline-success" style="padding-left: 2%; text-align: left">
                            <input type="checkbox" class="2e" name="samegroup[]"><span class="samegroup"></span>
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
                            <div class="vertical_wrapper2">
                            <div class="newgroup_info">
                                <div style="padding-bottom: 1em; text-align: center">新增群組</div>
                    
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

                <div id="warning3" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">3. 關係類別：<span style="background-color: #5CB85C; color: #FFFFFF">可複選</span></div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="checkbox" name="relationship[]" value="1">家人</label>
				    <label class="btn btn-outline-success"><input type="checkbox" name="relationship[]" value="2">親戚</label>
				    <label class="btn btn-outline-success"><input type="checkbox" name="relationship[]" value="3">同學</label>
				    <label class="btn btn-outline-success"><input type="checkbox" name="relationship[]" value="4">同事</label>
                    <label class="btn btn-outline-success"><input type="checkbox" name="relationship[]" value="5">好友</label>
                    <label class="btn btn-outline-success"><input type="checkbox" name="relationship[]" value="6">一般朋友</label>
                </div>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="relationship_other" placeholder="可補充描述關係類別">
				</div><br>
                
                <div id="warning4" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
                    <div class="input-group-text part1">4. <b><span class="alter_name_fill"></span></b> 的輩分比我高或低？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="seniority" value="0">輩分比我高</label>
				    <label class="btn btn-outline-success"><input type="radio" name="seniority" value="1">平輩</label>
				    <label class="btn btn-outline-success"><input type="radio" name="seniority" value="2">輩分比我低</label>
				    <label class="btn btn-outline-success"><input type="radio" name="seniority" value="3">無法辨別</label>
				</div><br><br>
                
                <div id="warning5" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">5. <b><span class="alter_name_fill"></span></b> 的性別：</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="gender" value="1">男性</label>
				    <label class="btn btn-outline-success"><input type="radio" name="gender" value="0">女性</label>
				</div><br><br>
                
                <div id="warning6" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">6. <b><span class="alter_name_fill"></span></b> 的年齡：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="age" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="0">1-10 歲</option>
                        <option value="1">11-20 歲</option>
                        <option value="2">21-30 歲</option>
                        <option value="3">31-40 歲</option>
                        <option value="4">41-50 歲</option>
                        <option value="5">51-60 歲</option>
                        <option value="6">61-70 歲</option>
                        <option value="7">71-80 歲</option>
                        <option value="8">81-90 歲</option>
                        <option value="9">90 歲以上</option>
                        <option value="10">不知道</option>
                    </select>
				</div><br><br>
                
                <div id="warning7" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">7. <b><span class="alter_name_fill"></span></b> 目前是否有工作：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="occupation" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="0">目前沒有工作（待業中）</option>
                        <option value="1">目前沒有工作（無工作意願）</option>
                        <option value="2">有工作</option>
                        <option value="3">學生</option>
                        <option value="4">家庭主婦</option>
                        <option value="5">目前沒有工作（已退休）</option>
                        <option value="6">不知道</option>
                    </select>
				</div><br><br>
                
                <div id="warning8" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">8. <b><span class="alter_name_fill"></span></b> 的教育程度：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="education" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="0">小學或以下</option>
                        <option value="1">國中／初中</option>
                        <option value="2">高中／職</option>
                        <option value="3">專科</option>
                        <option value="4">大學</option>
                        <option value="5">碩士</option>
                        <option value="6">博士</option>
                        <option value="7">不知道</option>
                    </select>
				</div><br><br>
                
                <div id="warning9" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">9. <b><span class="alter_name_fill"></span></b> 的婚姻狀況：</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="marriage" value="0">未婚</label>
				    <label class="btn btn-outline-success"><input type="radio" name="marriage" value="1">已婚</label>
				    <label class="btn btn-outline-success"><input type="radio" name="marriage" value="2">其他</label>
				    <label class="btn btn-outline-success"><input type="radio" name="marriage" value="3">不知道</label>
				</div><br><br>
                
                <div id="warning10" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">10. <b><span class="alter_name_fill"></span></b> 的居住地區：</div>
				</div>
                <div class="d-inline-flex col-sm-12">
                    <select id="city" class="form-control btn-outline-success"></select>
                    <select id="town" class="form-control btn-outline-success"></select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="res_other" placeholder="請備註說明" style="display: none">
				</div><br>
                
                <div id="warning11" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">11. 和 <b><span class="alter_name_fill"></span></b> 認識多久：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="acquaintance" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="1">不到 3 個月</option>
                        <option value="2">不到 1 年</option>
                        <option value="3">1-4 年多</option>
                        <option value="4">5-19 年多</option>
                        <option value="5">20 年以上</option>
                        <option value="0">原先不認識</option>
                    </select>
				</div><br><br>
                
                <div id="warning12" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">12. 和 <b><span class="alter_name_fill"></span></b> 是否常<b title="★ 面對面接觸 ★">碰面<i class="fa fa-info-circle"></i></b>？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="contact_freq" value="0">很常</label>
				    <label class="btn btn-outline-success"><input type="radio" name="contact_freq" value="1">偶爾</label>
				    <label class="btn btn-outline-success"><input type="radio" name="contact_freq" value="2">從未</label>
				</div><br><br>     
                
                <div id="warning13" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">13. 整體而言，喜不喜歡和 <b><span class="alter_name_fill"></span></b> 互動？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="closeness" value="0">非常喜歡</label>
				    <label class="btn btn-outline-success"><input type="radio" name="closeness" value="1">喜歡</label>
				    <label class="btn btn-outline-success"><input type="radio" name="closeness" value="2">還好</label>
				    <label class="btn btn-outline-success"><input type="radio" name="closeness" value="3">不喜歡</label>
                    <label class="btn btn-outline-success"><input type="radio" name="closeness" value="4">非常不喜歡</label>
				</div><br><br>
                
                <div id="warning14" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text part1">14. <b><span class="alter_name_fill"></span></b> 屬於我宗教生活圈中的人嗎？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="rel_group" value="1">是</label>
				    <label class="btn btn-outline-success"><input type="radio" name="rel_group" value="0">否</label>
				</div><br><br>
                    
                <div style="text-align: center">
                    <button id="submit2" class="btn">
                        <img src="/pic/submit.png" class="icon">
                    </button>
                </div>       
            </div>
        </div>
    </div>
		
	<?php include("footer.php");?>
</body>
</html>

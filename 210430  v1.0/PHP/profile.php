<?php
	session_start();
	include("db.php");

    if(!$_SESSION["acc_info"]["id"]){
		header("Location: ./index.php");
    }
    if(isset($_POST["checkStatus"])){
        if($_SESSION["acc_info"]["reg_status"]==2){
            echo "All Done";
        }else{
            $sql1="SELECT COUNT(*) FROM `profile` WHERE id= :v1";
            $stmt=$db->prepare($sql1);
            $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
            $stmt->execute();
            $rs1=$stmt->fetch(PDO::FETCH_ASSOC);
  
            if($rs1["COUNT(*)"]>0){
                echo "Profile Done";
            }
        }
        exit();
    }

    if(isset($_POST["fetchCity"])){
		$sql2="SELECT DISTINCT City, COUN_ID FROM `county` ORDER BY CityID";
		$stmt=$db->prepare($sql2);
		$stmt->execute();

		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["fetchTown"])){
		$sql3="SELECT DISTINCT District, TOWN_ID FROM `county` WHERE City= :v1 ORDER BY TOWN_ID";
		$stmt=$db->prepare($sql3);
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
        $sql4="INSERT INTO `profile` VALUES (NULL, :v2, :v3, :v4, :v5, :v6, :v7, :v8, :v9, :v10, :v11, :v12, :v13, :v14, :v15, :v16, :v17, :v18, :v19, :v20, :v21, :v22, :v23, :v24, :v25, :v26, :v27, :v28, :v29, :v30, :v31, :v32, :v33, :v34, :v35, :v36, :v37, :v38, :v39, :v40, :v41, :v42, :v43, NOW())";
		$stmt=$db->prepare($sql4);
		$stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
        $stmt->bindParam(":v3", $_POST["name"]);
        $stmt->bindParam(":v4", $_POST["name_line"]);
        $stmt->bindParam(":v5", $_POST["height"]);
        $stmt->bindParam(":v6", $_POST["weight"]);
        $stmt->bindParam(":v7", $_POST["gender"]);
        $stmt->bindParam(":v8", $_POST["age"]);
        $stmt->bindParam(":v9", $_POST["city"]);
        $stmt->bindParam(":v10", $_POST["town"]);
        $stmt->bindParam(":v11", $_POST["res_other"]);
        $stmt->bindParam(":v12", $_POST["livewithfamily"]);
        $stmt->bindParam(":v13", $_POST["marriage"]);
        $stmt->bindParam(":v14", $_POST["marriage_other"]);
        $stmt->bindParam(":v15", $_POST["livewithcouple"]);
        $stmt->bindParam(":v16", $_POST["livewithcouple_other"]);
        $stmt->bindParam(":v17", $_POST["occupation"]);
        $stmt->bindParam(":v18", $_POST["occupation_other"]);
        $stmt->bindParam(":v19", $_POST["education"]);
        $stmt->bindParam(":v20", $_POST["income"]);
        $stmt->bindParam(":v21", $_POST["income_other"]);
        $stmt->bindParam(":v22", $_POST["surveymail"]);
        $stmt->bindParam(":v23", $_POST["internal_member"]);
        $stmt->bindParam(":v24", $_POST["god"]);
        $stmt->bindParam(":v25", $_POST["god_other"]);
        $stmt->bindParam(":v26", $_POST["rel_activity"]);
        $stmt->bindParam(":v27", $_POST["rel_activity_other"]);
        $stmt->bindParam(":v28", $_POST["donation_buddism"]);
        $stmt->bindParam(":v29", $_POST["donation_christianity"]);
        $stmt->bindParam(":v30", $_POST["donation_folkbelief"]);
        $stmt->bindParam(":v31", $_POST["donation_taoism"]);
        $stmt->bindParam(":v32", $_POST["donation_other"]);
        $stmt->bindParam(":v33", $_POST["voluntary_buddism"]);
        $stmt->bindParam(":v34", $_POST["voluntary_christianity"]);
        $stmt->bindParam(":v35", $_POST["voluntary_folkbelief"]);
        $stmt->bindParam(":v36", $_POST["voluntary_taoism"]);
        $stmt->bindParam(":v37", $_POST["voluntary_other"]);
        $stmt->bindParam(":v38", $_POST["behavior_biblestudy"]);
        $stmt->bindParam(":v39", $_POST["behavior_meditate"]);
        $stmt->bindParam(":v40", $_POST["behavior_worship"]);
        $stmt->bindParam(":v41", $_POST["behavior_prayer"]);
        $stmt->bindParam(":v42", $_POST["behavior_other"]);
        $stmt->bindParam(":v43", $_POST["temple_freq"]);
		$stmt->execute();
        
        echo "Profile Insert Success";
        exit();
    }

    if(isset($_POST["formSubmit2"])){
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
        $sql6="UPDATE `account` SET reg_status=2 WHERE id= :v1";
        $stmt=$db->prepare($sql6);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->execute();
        $_SESSION["acc_info"]["reg_status"]=2;
        
        echo "Grouplist Insert Success";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>????????????</title>
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
        
        #title{
            width: 15%;
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
                width: 5em; margin: auto; margin-bottom: 1em;
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
                   
                   if(data=="All Done"){
                       $("#profile_done").modal("show");
                       setTimeout("window.location.href='./main.php'", 5000);
                   }else if(data=="Profile Done"){
                       $("#page_1").hide();
                       $("#page_2").show();
                   }else{
                       $("#inform").modal("show");
                   }
                }, error: function(e){
                    console.log(e);
                }     
            })
            
            $.ajax({ 
                type: "POST",
                dataType: "json", 
                url: "",
                data: {fetchCity: 1},
				success: function(data){
                    console.log(data);
                    
                    $("#city").empty();
                    $("#city").append($("<option>").html("?????????").attr("value", ""));
                    for(var key in data){
                        $("#city").append($("<option>").html(data[key].City).attr("value", data[key].City))
                    };
                    $("#city").append($("<option>").html("??????").attr("value", "??????"));
				}, error: function(e){
                    console.log(e);
                }
            })
            
            $("#city").on("change", function(event){
                event.preventDefault();
				var city=$(this).val();
                
                if(city=="??????"){
                    $("#town").empty();
                    $("input[name='res_other']").show();
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
                            $("#town").append($("<option>").html("?????????").attr("value", ""));
                            for(var key in data){
                                $("#town").append($("<option>").html(data[key].District).attr("value", data[key].District));
                            }
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
            })
         
            $("#occupation").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
				
				if(tmp==11){
					$("input[name='occupation_other']").show();
				}else {
					$("input[name='occupation_other']").hide().val("");
				}
			})
            
            $("#income").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
				
				if(tmp==7){
					$("input[name='income_other']").show();
				}else {
					$("input[name='income_other']").hide().val("");
				}
			})
            
            $("#god").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
				
				if(tmp==10){
					$("input[name='god_other']").show();
				}else {
					$("input[name='god_other']").hide().val("");
				}
			})
            
            $("#rel_activity").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==4){
                    $("input[name='rel_activity_other']").show();
                }else{
                    $("input[name='rel_activity_other']").hide().val("");
                }
			})
            
            $("input[name='donation']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==1){
                    $("div[name='donation_detail']").show();
                }else{
                    $("div[name='donation_detail']").hide();
                    $("div[name='donation_detail']").children().find("input[type='checkbox']").prop("checked", false).parent().removeClass("active");
					$("div[name='donation_detail']").children().find("input[type='text']").hide().val("");
                }
			})
            
            $("input[name='donation_other_chk']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $("input[name='donation_other']").show();
                }else{
                    $("input[name='donation_other']").hide().val("");
                }
			})
            
            $("input[name='voluntary']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).val();
                
                if(tmp==1){
                    $("div[name='voluntary_detail']").show();
                }else{
                    $("div[name='voluntary_detail']").hide();
                    $("div[name='voluntary_detail']").children().find("input[type='checkbox']").prop("checked", false).parent().removeClass("active");
					$("div[name='voluntary_detail']").children().find("input[type='text']").hide().val("");
                }
			})
            
            $("input[name='voluntary_other_chk']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $("input[name='voluntary_other']").show();
                }else{
                    $("input[name='voluntary_other']").hide().val("");
                }
			})
            
            $(jQuery).on('change', ".15o", function(event){
                event.preventDefault();
                var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $(".15e").prop("checked", false).parent().removeClass("active");
                    $(".15e").attr("disabled", true);
                    $("input[name='behavior_other']").hide().val("");
                }else{
                    $(".15e").attr("disabled", false);
                }
            })
            
            $("input[name='behavior_other_chk']").on("change", function(event){
                event.preventDefault();
				var tmp=$(this).is(":checked")?1 :0;
                
                if(tmp==1){
                    $("input[name='behavior_other']").show();
                }else{
                    $("input[name='behavior_other']").hide().val("");
                }
			})
            
            $("#submit_page1").on("click", function(event){
                event.preventDefault();
                $(".warn").hide();
                $("#submit_page1").attr("disabled", true);
                
                var name=                   $("input[name='name']").val();
                var name_line=              $("input[name='name_line']").val();
                var gender=                 $("input[name='gender']:checked").val();
                var age=                    $("select[id='age']").val();
                var city=                   $("select[id='city']").val();
                var town=                   $("select[id='town']").val();
                var res_other=              $("input[name='res_other']").val();
                var occupation=             $("select[id='occupation']").val();
                var occupation_other=       $("input[name='occupation_other']").val();
                var education=              $("select[id='education']").val();
                var income=                 $("select[id='income']").val();
                var income_other=           $("input[name='income_other']").val();
                var surveymail=             $("input[name='surveymail']:checked").val();
                var internal_member=        $("input[name='internal_member']:checked").val();
                var god=                    $("select[id='god']").val();
                var god_other=              $("input[name='god_other']").val();
                var rel_activity=           $("select[id='rel_activity']").val();
                var rel_activity_other=     $("input[name='rel_activity_other']").val();
                var donation=               $("input[name='donation']:checked").val();
                var donation_buddism=       $("input[name='donation_buddism']").is(":checked")?1: 0;
                var donation_christianity=  $("input[name='donation_christianity']").is(":checked")?1: 0;
                var donation_folkbelief=    $("input[name='donation_folkbelief']").is(":checked")?1: 0;
                var donation_taoism=        $("input[name='donation_taoism']").is(":checked")?1: 0;
                var donation_other_chk=     $("input[name='donation_other_chk']").is(":checked")?1: 0;
                var donation_other=         $("input[name='donation_other']").val();
                var donation_sum=           donation_buddism+donation_christianity+donation_folkbelief+donation_taoism+donation_other_chk;
                var voluntary=              $("input[name='voluntary']:checked").val();
                var voluntary_buddism=      $("input[name='voluntary_buddism']").is(":checked")?1: 0;
                var voluntary_christianity= $("input[name='voluntary_christianity']").is(":checked")?1: 0;
                var voluntary_folkbelief=   $("input[name='voluntary_folkbelief']").is(":checked")?1: 0;
                var voluntary_taoism=       $("input[name='voluntary_taoism']").is(":checked")?1: 0;
                var voluntary_other_chk=    $("input[name='voluntary_other_chk']").is(":checked")?1: 0;
                var voluntary_other=        $("input[name='voluntary_other']").val();
                var voluntary_sum=          voluntary_buddism+voluntary_christianity+voluntary_folkbelief+voluntary_taoism+voluntary_other_chk;
                var behavior_biblestudy=    $("input[name='behavior_biblestudy']").is(":checked")?1: 0;
                var behavior_meditate=      $("input[name='behavior_meditate']").is(":checked")?1: 0;
                var behavior_worship=       $("input[name='behavior_worship']").is(":checked")?1: 0;
                var behavior_prayer=        $("input[name='behavior_prayer']").is(":checked")?1: 0;
                var behavior_other_chk=     $("input[name='behavior_other_chk']").is(":checked")?1: 0;
                var behavior_none=          $("input[name='behavior_none']").is(":checked")?1: 0;
                var behavior_other=         $("input[name='behavior_other']").val();
                var behavior_sum=           behavior_biblestudy+behavior_meditate+behavior_worship+behavior_prayer+behavior_other_chk+behavior_none;
                var temple_freq=            $("select[id='temple_freq']").val();                
                
                var record=[], j=0;
                if(!name)                                                       {record[j]="1"; j++;    $("#warning1").show()}
                if(!gender)                                                     {record[j]="3"; j++;    $("#warning3").show()}
                if(!age)                                                        {record[j]="4"; j++;    $("#warning4").show()}
                if(!city|(city!="??????"&!town)|(city=="??????"&!res_other))         {record[j]="5"; j++;    $("#warning5").show()}
                if(!occupation|(occupation==11&!occupation_other))              {record[j]="6"; j++;    $("#warning6").show()}
                if(!education)                                                  {record[j]="7"; j++;    $("#warning7").show()}
                if(!income|(income==7&!income_other))                           {record[j]="8"; j++;    $("#warning8").show()}
                if(!surveymail)                                                 {record[j]="9"; j++;    $("#warning9").show()}
                if(!internal_member)                                            {record[j]="10"; j++;   $("#warning10").show()}
                if(!god|(god==10&!god_other))                                   {record[j]="11"; j++;   $("#warning11").show()}
                if(!rel_activity|(rel_activity==4&!rel_activity_other))         {record[j]="12"; j++;   $("#warning12").show()}
                if(!donation|(donation==1&donation_sum==0)|(donation_other_chk==1&!donation_other))
                                                                                {record[j]="13"; j++;   $("#warning13").show()}
                if(!voluntary|(voluntary==1&voluntary_sum==0)|(voluntary_other_chk==1&!voluntary_other))
                                                                                {record[j]="14"; j++;   $("#warning14").show()}
                if(behavior_sum==0|(behavior_other_chk==1&!behavior_other))     {record[j]="15"; j++;   $("#warning15").show()}
                if(!temple_freq)                                                {record[j]="16"; j++;   $("#warning16").show()}
                
                if(j>0){
                    $("#submit_page1").attr("disabled", false);
                    $.alert({
						title: "",
					    content: "???????????? "+record+" ???????????????????????????",
					})
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: "",
                        data: {
                            formSubmit1: 1,
                            name: name,
                            name_line: name_line,
                            height: 999,
                            weight: 999,
                            gender: gender,
                            age: age,
                            city: city,
                            town: town,
                            res_other: res_other,
                            livewithfamily: 999,
                            marriage: 999,
                            marriage_other: 999,
                            livewithcouple: 999,
                            livewithcouple_other: 999,
                            occupation: occupation,
                            occupation_other: occupation_other,
                            education: education,
                            income: income,
                            income_other: income_other,
                            surveymail: surveymail,
                            internal_member: internal_member,
                            god: god,
                            god_other: god_other,
                            rel_activity: rel_activity,
                            rel_activity_other: rel_activity_other,
                            donation_buddism: donation_buddism,
                            donation_christianity: donation_christianity,
                            donation_folkbelief: donation_folkbelief,
                            donation_taoism: donation_taoism,
                            donation_other: donation_other,
                            voluntary_buddism: voluntary_buddism,
                            voluntary_christianity: voluntary_christianity,
                            voluntary_folkbelief: voluntary_folkbelief,
                            voluntary_taoism: voluntary_taoism,
                            voluntary_other: voluntary_other,
                            behavior_biblestudy: behavior_biblestudy,
                            behavior_meditate: behavior_meditate,
                            behavior_worship: behavior_worship,
                            behavior_prayer: behavior_prayer,
                            behavior_other: behavior_other,
                            temple_freq: temple_freq
                        },
                        success: function(data){
                            console.log(data);
                            
                            if(data=="Profile Insert Success"){
                                $("#page_1").hide();
                                $("#page_2").show(); 
                            }
                        }, error: function(){
                            console.log(e);
                        }
                    })
                }
            })
            
            $("#group_add").on("click", function(event){
				event.preventDefault();
                var tmp=$(".group_info_wrapper").clone().last();
                
                tmp.find("input[type='text']").val("");
                tmp.find("label").removeClass("active");
                var index=parseInt(tmp.find("input[class='group_freq']").attr("name").split("_").slice(-1)[0]);
				tmp.find("input[class='group_freq']").attr("name", "group_freq_"+(index+1)).prop("checked", false);
				tmp.find("input[class='group_invite']").attr("name", "group_invite_"+(index+1)).prop("checked", false);
                
				$(".group_info").append(tmp);
			})

            $("#group_minus").on("click", function(event){
				event.preventDefault();
				var tmp=$(".group_info_wrapper").clone();
			
				if(tmp.length>1){
					$(".group_info_wrapper").last().remove();
				}else{
                    $.alert({
						title: "",
					    content: "????????????????????????????????????",
					})
				}
			})
            
            $("#groupForm").on("submit", function(event){
                event.preventDefault();
                $("#submit_page2").attr("disabled", true);

                var group_list={
					group_name: [],
					group_myname: [],
					group_freq: [],
					group_religion: [],
					group_invite: []
				}
                
                $("input[name='group_name']").each(function(){
					group_list.group_name.push($(this).val().trim());
					group_list.group_religion.push(999);
				})
				$("input[name='group_myname']").each(function(){
					group_list.group_myname.push($(this).val());
				})
				$("input[class='group_freq']:checked").each(function(){
					group_list.group_freq.push($(this).val());
				})
				$("input[class='group_invite']:checked").each(function(){
					group_list.group_invite.push($(this).val());
                })
                
                $.ajax({
                    type: "POST",
                    url: "",
                    data: {formSubmit2: 1, group_list: group_list},
                    success: function(data){
                        console.log(data);
                        
                        if(data=="Grouplist Insert Success"){
                            $("#success").modal("show");
                            setTimeout("window.location.href='./main.php'", 5000);
                        }
                    }, error: function(){
                        console.log(e);
                    }
                })
            })
            
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
    
    <div id="profile_done" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: black; color: #FFFFFF">???? ??????????????? ????</h5>
            </div>
                
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep1" src="./pic/error.png"></div>
                <p>
                    ?????????????????????????????????????????? <b><a href="./edit_profile.php">??????????????????</a></b>
                    <br><br>
                    ?????????????????????<button style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>??????????????????</b></button>
                    <br><br>
                    5 ?????????????????????????????????
                </p>
            </div>
            <div style="text-align: right; padding: 1%; font-size: 1.5em">???</div>
        </div>
        </div>
    </div>
    
    <div id="success" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: yellow">??? ???????????? ???</h5>
            </div>
            
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/done.gif"></div>
                <p>
                    ???????????????????????????
                    <br><br>
                    ??????????????? <b><a href="./main.php">?????????</a></b> ?????????????????????????????????
                    <br><br>
                    5 ?????????????????????????????????
                </p>
            </div>
            <div style="text-align: right; padding: 1%">???</div>
        </div>
        </div>
    </div>
    
    <div id="inform" class="modal">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="background-color: yellow">??? ??????????????????????????? ???</h5>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/greeting.png"></div>
                <p>
                    ??????????????????????????????????????????<br>?????????????????????<b><?=$_SESSION["acc_info"]["id"]?></b>??????????????????
                    <br><br>
                    ????????????????????????????????????????????????????????????<br>?????????????????????????????????????????????
                </p>
            </div>
            <div style="text-align: right; padding: 1%">???</div>
        </div>
        </div>
    </div>
    
    <div class="wrap">
        <img id="title" src="./pic/square.png">
        <div class="title">????????????</div>
    </div> 
    
    <div class="container">        
        <div class="card">
            <div class="card-body">
                <form id="profileForm">
                <div id="page_1">
                <p>
                    ??? ???????????????<b title="??? ????????????????????? ???">?????????<i class="fa fa-info-circle"></i></b>????????????????????????
                </p>
                    
                <p>
                    ???????????????????????????
                </p>
                <div id="warning1" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>    
                <div class="col-sm-auto">
				    <div class="input-group-text part1">1. ??????????????????</div>
				</div>
				<div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="name">
				</div><br>
                
                <div class="col-sm-auto">
				    <div class="input-group-text part1">2. ?????? LINE ?????????????????????<span style="background-color: #5CB85C; color: #FFFFFF">??????</span></div>
				</div>
				<div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="name_line">
				</div><br>
                
                <div id="warning3" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">3. ?????????</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="gender" value="1">??????</label>
				    <label class="btn btn-outline-success"><input type="radio" name="gender" value="0">??????</label>
				</div><br><br>
                
                <div id="warning4" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">4. ?????????</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="age" class="form-control btn-outline-success">
                        <option value="">?????????</option>
                        <option value="0">0-10 ???</option>
                        <option value="1">11-20 ???</option>
                        <option value="2">21-30 ???</option>
                        <option value="3">31-40 ???</option>
                        <option value="4">41-50 ???</option>
                        <option value="5">51-60 ???</option>
                        <option value="6">61-70 ???</option>
                        <option value="7">71-80 ???</option>
                        <option value="8">81-90 ???</option>
                        <option value="9">90 ?????????</option>
                    </select>
				</div><br><br>
                
                <div id="warning5" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">5. ?????????????????????</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="city" class="form-control btn-outline-success"></select>
                    <select id="town" class="form-control btn-outline-success"></select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="res_other" placeholder="?????????????????????" style="display: none">
				</div><br>
                
                <div id="warning6" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">6. ?????????</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="occupation" class="form-control btn-outline-success">
                        <option value="">?????????</option>
                        <option value="0">?????????</option>
                        <option value="1">??????????????????????????????</option>
                        <option value="2">????????????????????????</option>
                        <option value="3">??????????????????</option>
                        <option value="4">?????????</option>
                        <option value="5">??????</option>
                        <option value="6">??????</option>
                        <option value="7">????????????</option>
                        <option value="8">?????????????????????</option>
                        <option value="9">????????????</option>
                        <option value="10">????????????</option>
                        <option value="11">??????</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="occupation_other" placeholder="???????????????" style="display: none">
				</div><br>
                
                <div id="warning7" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">7. ???????????????</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="education" class="form-control btn-outline-success">
                        <option value="">?????????</option>
                        <option value="0">???????????????</option>
                        <option value="1">???????????????</option>
                        <option value="2">????????????</option>
                        <option value="3">??????</option>
                        <option value="4">??????</option>
                        <option value="5">??????</option>
                        <option value="6">??????</option>
                    </select>
				</div><br><br>
                
                <div id="warning8" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">8. ?????????????????????</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="income" class="form-control btn-outline-success">
                        <option value="">?????????</option>
                        <option value="0">????????????</option>
                        <option value="1">????????????</option>
                        <option value="2">?????????</option>
                        <option value="3">????????????</option>
                        <option value="4">????????????</option>
                        <option value="5">?????????</option>
                        <option value="6">???</option>
                        <option value="7">??????</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="income_other" placeholder="???????????????" style="display: none">
				</div><br>
                
                <div id="warning9" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">9. ????????????????????????????????????????????????</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="surveymail" value="1">???</label>
				    <label class="btn btn-outline-success"><input type="radio" name="surveymail" value="0">???</label>
				</div><br><br>
                
                <div id="warning10" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">10. ??????????????????????????????</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="internal_member" value="1">???</label>
				    <label class="btn btn-outline-success"><input type="radio" name="internal_member" value="0">???</label>
				</div><br><br><hr>    
                    
                <p>
                    ?????????????????????????????????
                </p>
                <div id="warning11" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">11. ??????????????????????????????</div>
				</div>    
				<div class="d-inline-flex col-sm-12">
                    <select id="god" class="form-control btn-outline-secondary">
                        <option value="">?????????</option>
                        <option value="0">???????????????????????????</option>
                        <option value="1">???????????????</option>
                        <option value="2">???????????????</option>
                        <option value="3">??????</option>
                        <option value="4">?????????????????????</option>
                        <option value="5">???????????????????????????</option>
                        <option value="6">????????????</option>
                        <option value="7">?????????</option>
                        <option value="8">???????????????????????????</option>
                        <option value="9">????????????</option>
                        <option value="10">??????</option>
                        <option value="11">??????????????????????????????</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-secondary" type="text" name="god_other" placeholder="???????????????" style="display: none">
				</div><br>
                
                <div id="warning12" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">12. ?????????????????????????????????????????????????????????????????????</div>
				</div>    
				<div class="d-inline-flex col-sm-12">
                    <select id="rel_activity" class="form-control btn-outline-secondary">
                        <option value="">?????????</option>
                        <option value="0">??????</option>
                        <option value="1">?????????????????????</option>
                        <option value="2">????????????</option>
                        <option value="3">??????</option>
                        <option value="4">??????</option>
                        <option value="5">??????????????????????????????</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-secondary" type="text" name="rel_activity_other" placeholder="???????????????" style="display: none">
				</div><br>
                
                <div id="warning13" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">13. ???????????????????????????????????????</div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="donation" value="1">???</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="donation" value="0">???</label>
				</div><br>
                <div name="donation_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>?????????????????????<span style="background-color: #6C757D; color: #FFFFFF">?????????</span></div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_buddism">??????</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_christianity">?????????????????????</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_folkbelief">????????????</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_taoism">??????</label>
                        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_other_chk">??????</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control btn-outline-secondary" type="text" name="donation_other" placeholder="???????????????" style="display: none">
				    </div>
                </div><br>
                
                <div id="warning14" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">14. ??????????????????????????????????????????????????????????????????</div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="voluntary" value="1">???</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="voluntary" value="0">???</label>
				</div><br>
                <div name="voluntary_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>?????????????????????<span style="background-color: #6C757D; color: #FFFFFF">?????????</span></div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_buddism">??????</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_christianity">?????????????????????</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_folkbelief">????????????</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_taoism">??????</label>
                        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_other_chk">??????</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control btn-outline-secondary" type="text" name="voluntary_other" placeholder="???????????????" style="display: none">
                    </div>
				</div><br>
                    
                <div id="warning15" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">15. ???????????????????????????????????????????????????<span style="background-color: #6C757D; color: #FFFFFF">?????????</span></div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_biblestudy">?????????</label>
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_meditate">??????</label>
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_worship">?????????</label>
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_prayer">?????????????????????</label>
                    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_other_chk">??????</label>
                    <label class="btn btn-outline-secondary"><input type="checkbox" class="15o" name="behavior_none">??????????????????????????????</label>
                </div>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-secondary" type="text" name="behavior_other" placeholder="???????????????" style="display: none">
				</div><br>                    
                    
                <div id="warning16" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> ???????????????</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">16. ????????????????????????????????????</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="temple_freq" class="form-control btn-outline-secondary">
                        <option value="">?????????</option>
                        <option value="0">??????</option>
                        <option value="1">???????????????</option>
                        <option value="2">????????????????????????????????????????????????</option>
                        <option value="3">??????????????????????????????</option>
                        <option value="4">????????????</option>
                    </select>
				</div><br><br>
           
                <div style="text-align: center">
                    <button id="submit_page1" class="btn" onclick="javascript: {this.disabled=true}">
                        <img src="/pic/next.png" class="icon">
                    </button>
                </div>
                </div>
                </form>               
                
                <form id="groupForm">
                <div id="page_2" style="display: none">
                <p>
                    ??? ???????????????<b title="??? ????????????????????? ???">?????????<i class="fa fa-info-circle"></i></b>????????????????????????
                </p>
                <p>
                    ?????????????????????????????????
                </p>
                    
                <div class="col-sm-auto">
                    <div class="part3" style="padding: 0.5em">?????????????????????????????????????????????????????????????????????????????????<br>
                    ??????????????????<b title="??? ????????????????????????????????? ???">??????<i class="fa fa-info-circle"></i></b>???<b title="??? LINE?????????????????????????????? ???">????????????<i class="fa fa-info-circle"></i></b>????????????????????????????????????????????????????????????????????????<br><br>
                    <div style="color: #FFFF00; text-align: center"><b>????????????????????????????????????????????????<i class="fas fa-plus-circle"></i>???<i class="fas fa-minus-circle"></i>????????????????????????</b></div></div>
				</div><br>

                <div class="group_info">
                <div class="group_info_wrapper">
                    <div class="row" style="padding-top: 1em">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part3">A. ???????????????</div>
				        </div>
                        <div class="col-sm-7 pl-0 pr-0">
				            <input class="form-control btn-outline-info" type="text" name="group_name" required>
				        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part3">B. ?????????????????????????????????</div>
				        </div>
                        <div class="col-sm-7 pl-0 pr-0">
				            <input class="form-control btn-outline-info" type="text" name="group_myname" required>
				        </div>
				    </div>
                    
                    <div class="row">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part3">C. ????????????????????????</div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
				            <label class="btn btn-outline-info"><input type="radio" class="group_freq" name="group_freq_0" value="0" required>????????????</label>
				            <label class="btn btn-outline-info"><input type="radio" class="group_freq" name="group_freq_0" value="1" required>????????????</label>
                            <label class="btn btn-outline-info"><input type="radio" class="group_freq" name="group_freq_0" value="2" required>??????????????????</label>
                            <label class="btn btn-outline-info"><input type="radio" class="group_freq" name="group_freq_0" value="3" required>??????</label>
				        </div>
				    </div>
                    
                    <div class="row" style="padding-bottom: 1em">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part3">D. ???????????????????????????????????????</div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
                            
				            <label class="btn btn-outline-info"><input type="radio" class="group_invite" name="group_invite_0" value="0" required>0 ???</label>
				            <label class="btn btn-outline-info"><input type="radio" class="group_invite" name="group_invite_0" value="1" required>1-4 ???</label>
                            <label class="btn btn-outline-info"><input type="radio" class="group_invite" name="group_invite_0" value="2" required>>5 ???</label>
				        </div>
				    </div>
                </div>
                </div>
                
                <div class="add_minus"><hr>
                    <button id="group_add" class="btn" style="margin: -0.4em"><i class="fas fa-plus-circle"></i></button>
                    <button id="group_minus" class="btn" style="margin: -0.4em"><i class="fas fa-minus-circle"></i></button>
				</div> 
                <div style="text-align: center">
                    <button id="submit_page2" class="btn">
                        <img src="/pic/submit.png" class="icon">
                    </button>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>
		
	<?php include("footer.php");?>
</body>
</html>

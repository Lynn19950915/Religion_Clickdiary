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

    if(isset($_POST["fetchCity"])){
		$sql1="SELECT DISTINCT City, COUN_ID FROM `county` ORDER BY CityID";
		$stmt=$db->prepare($sql1);
		$stmt->execute();

		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["fetchProfile"])){
		$sql2="SELECT * FROM `profile` WHERE id= :v1 ORDER BY create_time DESC LIMIT 1";
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

    if(isset($_POST["formSubmit"])){
        $sql4="UPDATE `profile` SET name= :v3, name_line= :v4, height= :v5, weight= :v6, gender= :v7, age= :v8, city= :v9, town= :v10, res_other= :v11, livewithfamily= :v12, marriage= :v13, marriage_other= :v14, livewithcouple= :v15, livewithcouple_other= :v16, occupation= :v17, occupation_other= :v18, education= :v19, income= :v20, income_other= :v21, surveymail= :v22, internal_member= :v23, god= :v24, god_other= :v25, rel_activity= :v26, rel_activity_other= :v27, donation_buddism= :v28, donation_christianity= :v29, donation_folkbelief= :v30, donation_taoism= :v31, donation_other= :v32, voluntary_buddism= :v33, voluntary_christianity= :v34, voluntary_folkbelief= :v35, voluntary_taoism= :v36, voluntary_other= :v37, behavior_biblestudy= :v38, behavior_meditate= :v39, behavior_worship= :v40, behavior_prayer= :v41, behavior_other= :v42, temple_freq= :v43, create_time= NOW() WHERE id= :v2";
		$stmt=$db->prepare($sql4);
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
        $stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        
        echo "Profile Update Success";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>個人資料修改</title>
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
                    $("#city").append($("<option>").html("請選擇").attr("value", ""));
                    for(var key in data){
                        $("#city").append($("<option>").html(data[key].City).attr("value", data[key].City))
                    };
                    $("#city").append($("<option>").html("國外").attr("value", "國外"));
                    
                    $.ajax({ 
                        type: "POST",
                        dataType: "json",
                        url: "",
                        data: {fetchProfile: 1},
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
            
            $("#city").on("change", function(event){
                event.preventDefault();
				var city=$(this).val();
                
                if(city=="國外"){
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
                            $("#town").append($("<option>").html("請選擇").attr("value", ""));
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
            
            $(jQuery).on("change", ".15o", function(event){
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
            
            $("#submit").on("click", function(event){
                event.preventDefault();
                $(".warn").hide();
                $("#submit").attr("disabled", true);
                
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
                if(!city|(city!="國外"&!town)|(city=="國外"&!res_other))         {record[j]="5"; j++;    $("#warning5").show()}
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
                            
                            if(data=="Profile Update Success"){
                                $("#success").modal("show");
                                setTimeout("window.location.href='./main.php'", 5000);
                            }
                        }, error: function(){
                            condole.log(e);
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
                    if(value==1){
                        $("input[type='checkbox'][name='"+key+"']").prop("checked", true).parent().addClass("active");
                    } 
                })
                        
                if(data[0]["res_other"]!=""){
                    $("input[name='res_other']").show();
                }
                if(data[0]["occupation_other"]!=""){
                    $("input[name='occupation_other']").show();
                }
                if(data[0]["income_other"]!=""){
                    $("input[name='income_other']").show();
                }
                if(data[0]["god_other"]!=""){
                    $("input[name='god_other']").show();
                }
                if(data[0]["rel_activity_other"]!=""){
                    $("input[name='rel_activity_other']").show();
                }

                if(data[0]["donation_other"]!=""){
                    $("input[name='donation'][value='1']").prop("checked", true).parent().addClass("active");                           
                    $("div[name='donation_detail']").show();
                    $("input[name='donation_other_chk]").prop("checked", true).parent().addClass("active");
                }else if(data[0]["donation_buddism"]+data[0]["donation_christianity"]+data[0]["donation_folkbelief"]+data[0]["donation_taoism"]>0){
                    $("input[name='donation'][value='1']").prop("checked", true).parent().addClass("active");                            
                    $("div[name='donation_detail']").show();
                }else{
                    $("input[name='donation'][value='0']").prop("checked", true).parent().addClass("active");                            
                }
                        
                if(data[0]["voluntary_other"]!=""){
                    $("input[name='voluntary'][value='1']").prop("checked", true).parent().addClass("active");                            
                    $("div[name='voluntary_detail']").show();
                    $("input[name='voluntary_other_chk]").prop("checked", true).parent().addClass("active");
                }else if(data[0]["voluntary_buddism"]+data[0]["voluntary_christianity"]+data[0]["voluntary_folkbelief"]+data[0]["voluntary_taoism"]>0){
                    $("input[name='voluntary'][value='1']").prop("checked", true).parent().addClass("active");                            
                    $("div[name='voluntary_detail']").show();
                }else{
                    $("input[name='voluntary'][value='0']").prop("checked", true).parent().addClass("active");                           
                }
                
                if(data[0]["behavior_other"]!=""){
                    $("input[name='behavior_other_chk']").prop("checked", true).parent().addClass("active");
                    $("input[name='behavior_other']").show();
                }else if(data[0]["behavior_biblestudy"]+data[0]["behavior_meditate"]+data[0]["behavior_worship"]+data[0]["behavior_prayer"]==0){
                    $("input[name='behavior_none']").prop("checked", true).parent().addClass("active");     
                }                 
            }
            
            if(window.matchMedia("(max-width: 800px)").matches){
                $(".btn-group-toggle").removeClass("btn-group").addClass("btn-group-vertical");
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
                <h5 class="modal-title" style="background-color: yellow">⭐ 更新完成 ⭐</h5>
            </div>
            
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/greeting.png"></div>
                <p>
                    <br>已更新您的個人資料囉！
                    <br><br>
                    5 秒後將為您導回：主畫面
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❻</div>
        </div>
        </div>
    </div>
    
    <div class="wrap">
        <img id="title" src="./pic/square.png">
        <div class="title">個人資料修改</div>
    </div>
    
    <div class="container">        
        <div class="card">
            <div class="card-body">
                <form id="profileForm">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                    
                <p>
                    第一部分：基本資料
                </p>
                <div id="warning1" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>    
                <div class="col-sm-auto">
				    <div class="input-group-text part1">1. 姓名／暱稱：</div>
				</div>
				<div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="name">
				</div><br>
                
                <div class="col-sm-auto">
				    <div class="input-group-text part1">2. 我在 LINE 上顯示的名稱：<span style="background-color: #5CB85C; color: #FFFFFF">選填</span></div>
				</div>
				<div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="name_line">
				</div><br>
                
                <div id="warning3" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">3. 性別：</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="gender" value="1">男性</label>
				    <label class="btn btn-outline-success"><input type="radio" name="gender" value="0">女性</label>
				</div><br><br>
                
                <div id="warning4" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">4. 年齡：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="age" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="0">0-10 歲</option>
                        <option value="1">11-20 歲</option>
                        <option value="2">21-30 歲</option>
                        <option value="3">31-40 歲</option>
                        <option value="4">41-50 歲</option>
                        <option value="5">51-60 歲</option>
                        <option value="6">61-70 歲</option>
                        <option value="7">71-80 歲</option>
                        <option value="8">81-90 歲</option>
                        <option value="9">90 歲以上</option>
                    </select>
				</div><br><br>
                
                <div id="warning5" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">5. 目前居住地區：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="city" class="form-control btn-outline-success"></select>
                    <select id="town" class="form-control btn-outline-success"></select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="res_other" placeholder="請填寫居住地區" style="display: none">
				</div><br>
                
                <div id="warning6" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">6. 職業：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="occupation" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="0">無工作</option>
                        <option value="1">專業人員／專業技術員</option>
                        <option value="2">體力工＆服務人員</option>
                        <option value="3">農、漁、牧業</option>
                        <option value="4">自營商</option>
                        <option value="5">學生</option>
                        <option value="6">教師</option>
                        <option value="7">軍警人員</option>
                        <option value="8">一般辦公室職員</option>
                        <option value="9">家庭主婦</option>
                        <option value="10">退休人士</option>
                        <option value="11">其他</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="occupation_other" placeholder="請備註說明" style="display: none">
				</div><br>
                
                <div id="warning7" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">7. 教育程度：</div>
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
                    </select>
				</div><br><br>
                
                <div id="warning8" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">8. 主要收入來源：</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="income" class="form-control btn-outline-success">
                        <option value="">請選擇</option>
                        <option value="0">全職工作</option>
                        <option value="1">打工兼職</option>
                        <option value="2">獎學金</option>
                        <option value="3">家裡支持</option>
                        <option value="4">投資獲利</option>
                        <option value="5">退休金</option>
                        <option value="6">無</option>
                        <option value="7">其他</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-success" type="text" name="income_other" placeholder="請備註說明" style="display: none">
				</div><br>
                
                <div id="warning9" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">9. 是否願意收到後續調查的相關訊息？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="surveymail" value="1">是</label>
				    <label class="btn btn-outline-success"><input type="radio" name="surveymail" value="0">否</label>
				</div><br><br>
                
                <div id="warning10" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div> 
                <div class="col-sm-auto">
				    <div class="input-group-text part1">10. 是否為研究團隊人員？</div>
				</div>
				<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-success"><input type="radio" name="internal_member" value="1">是</label>
				    <label class="btn btn-outline-success"><input type="radio" name="internal_member" value="0">否</label>
				</div><br><br><hr>               
                    
                <p>
                    第二部分：宗教參與習慣
                </p>
                <div id="warning11" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">11. 我最主要敬拜的神是：</div>
				</div>    
				<div class="d-inline-flex col-sm-12">
                    <select id="god" class="form-control btn-outline-secondary">
                        <option value="">請選擇</option>
                        <option value="0">釋迦摩尼佛（佛祖）</option>
                        <option value="1">上帝／基督</option>
                        <option value="2">觀世音菩薩</option>
                        <option value="3">媽祖</option>
                        <option value="4">關聖帝君／關公</option>
                        <option value="5">王爺（五府千歲等）</option>
                        <option value="6">保生大帝</option>
                        <option value="7">三太子</option>
                        <option value="8">福德正神（土地公）</option>
                        <option value="9">玄天上帝</option>
                        <option value="10">其他</option>
                        <option value="11">沒有敬拜祈求神的行為</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-secondary" type="text" name="god_other" placeholder="請備註說明" style="display: none">
				</div><br>
                
                <div id="warning12" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">12. 我目前最常參與哪一類宗教團體的集體活動或聚會？</div>
				</div>    
				<div class="d-inline-flex col-sm-12">
                    <select id="rel_activity" class="form-control btn-outline-secondary">
                        <option value="">請選擇</option>
                        <option value="0">佛教</option>
                        <option value="1">基督教／天主教</option>
                        <option value="2">民間信仰</option>
                        <option value="3">道教</option>
                        <option value="4">其他</option>
                        <option value="5">沒有參與宗教團體活動</option>
                    </select>
				</div><br>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-secondary" type="text" name="rel_activity_other" placeholder="請備註說明" style="display: none">
				</div><br>
                
                <div id="warning13" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">13. 我目前是否捐款給宗教團體？</div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="donation" value="1">是</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="donation" value="0">否</label>
				</div><br>
                <div name="donation_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>哪些宗教團體：<span style="background-color: #6C757D; color: #FFFFFF">可複選</span></div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_buddism">佛教</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_christianity">基督教／天主教</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_folkbelief">民間信仰</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_taoism">道教</label>
                        <label class="btn btn-outline-secondary"><input type="checkbox" name="donation_other_chk">其他</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control btn-outline-secondary" type="text" name="donation_other" placeholder="請備註說明" style="display: none">
				    </div>
                </div><br>
                
                <div id="warning14" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">14. 我目前是否偶爾或固定擔任宗教團體活動的義工？</div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="radio" name="voluntary" value="1">是</label>
				    <label class="btn btn-outline-secondary"><input type="radio" name="voluntary" value="0">否</label>
				</div><br>
                <div name="voluntary_detail" style="display: none">
                    <div class="col-sm-auto">
				        <div>哪些宗教團體：<span style="background-color: #6C757D; color: #FFFFFF">可複選</span></div>
				    </div>
                    <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_buddism">佛教</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_christianity">基督教／天主教</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_folkbelief">民間信仰</label>
				        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_taoism">道教</label>
                        <label class="btn btn-outline-secondary"><input type="checkbox" name="voluntary_other_chk">其他</label>
                    </div>
                    <div class="col-sm-auto">
				        <input class="form-control btn-outline-secondary" type="text" name="voluntary_other" placeholder="請備註說明" style="display: none">
                    </div>
				</div><br>
                    
                <div id="warning15" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">15. 我目前固定從事哪些個人性宗教行為？<span style="background-color: #6C757D; color: #FFFFFF">可複選</span></div>
				</div>
                <div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_biblestudy">讀經文</label>
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_meditate">靜坐</label>
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_worship">祭祀神</label>
				    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_prayer">向神祈求、禱告</label>
                    <label class="btn btn-outline-secondary"><input type="checkbox" class="15e" name="behavior_other_chk">其他</label>
                    <label class="btn btn-outline-secondary"><input type="checkbox" class="15o" name="behavior_none">未從事個人性宗教行為</label>
                </div>
                <div class="col-sm-auto">
				    <input class="form-control btn-outline-secondary" type="text" name="behavior_other" placeholder="請備註說明" style="display: none">
				</div><br>                    
                    
                <div id="warning16" class="col-sm-auto warn"><b><i class="fa fa-times-circle"></i> 請提供答案</b></div>
                <div class="col-sm-auto">
				    <div class="input-group-text">16. 我平均多久會去寺廟拜拜？</div>
				</div>
				<div class="d-inline-flex col-sm-12">
                    <select id="temple_freq" class="form-control btn-outline-secondary">
                        <option value="">請選擇</option>
                        <option value="0">常常</option>
                        <option value="1">每月一兩次</option>
                        <option value="2">幾個月一次（不定期，有事才去拜）</option>
                        <option value="3">一年一次（祈福點燈）</option>
                        <option value="4">幾乎不去</option>
                    </select>
				</div><br><br>
           
                <div style="text-align: center">
                    <button id="submit" class="btn" onclick="javascript: {this.disabled=true}">
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

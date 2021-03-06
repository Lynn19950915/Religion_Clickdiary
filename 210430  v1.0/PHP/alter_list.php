<?php
	session_start();
	include("db.php");
    $c=isset($_GET["c"])?$_GET["c"]: "";
    $s=isset($_GET["s"])?$_GET["s"]: "";

    if(!$_SESSION["acc_info"]["id"]){
		header("Location: ./index.php");
    }
    if(isset($_POST["checkStatus"])){
        if($_SESSION["acc_info"]["reg_status"]!=2){
            echo "Error";
        }
        exit();
    }

    if(isset($_POST["fetchAlter"])){
        $sql1="SELECT COUNT(*) FROM `alter_list` WHERE ego_id= :v1";
		$stmt=$db->prepare($sql1);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        $json=array();
        $json[0]=$stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql2="SELECT alter_id1, alter_id2 FROM `alter_table` WHERE ego_id= :v1 and alter_id1<alter_id2
               UNION DISTINCT
               SELECT alter_id2, alter_id1 FROM `alter_table` WHERE ego_id= :v1 and alter_id1>alter_id2";
        $stmt=$db->prepare($sql2);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        $json[1]=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($c==""){
            $sql3="SELECT alter_name, alter_id, touchtimes, DATE(last_record) FROM `alter_list` WHERE ego_id= :v1 ORDER BY last_record desc";
        }else if($s==1){
            $sql3="SELECT alter_name, alter_id, touchtimes, DATE(last_record) FROM `alter_list` WHERE ego_id= :v1 ORDER BY $c";
        }else if($s==2){
            $sql3="SELECT alter_name, alter_id, touchtimes, DATE(last_record) FROM `alter_list` WHERE ego_id= :v1 ORDER BY $c desc";
        }
        $stmt=$db->prepare($sql3);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->execute();
        $json[2]=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

    if(isset($_POST["searchAlter"])){
        $search=$_POST["search"];
        
        $sql4="SELECT alter_name, alter_id, touchtimes, DATE(last_record) FROM `alter_list` WHERE ego_id= :v1 and alter_name LIKE '%$search%'";
		$stmt=$db->prepare($sql4);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        $json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
        
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>??????????????????</title>
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
            width: 100%;
            display: inline-block; position: relative; text-align: center;
        }
        
        .title{
            width: 100%; top: 20%; left: 0; letter-spacing: 0.05em;
            color: #2E317C;
            font-size: 1.8em; font-weight: bold; text-align: center; position: absolute;
        }
        
        .container{
			width: 70%; margin: 20px auto;
			align-content: center;
		}
        
        .card{
            border: 0.1em solid #FBDA41; letter-spacing: 0.05em;
        }
        
        .card-header{
            background-color: #FBDA41;
        }
        
        .card-body{
		    line-height: 1.75em; 
            font-size: 0.95em; text-align: left;
		}
        
        .alterlist{
            font-size: 0.85em; padding-bottom: 1em;
        }
        
        /* DETAILED */
        .sheep{
            width: 7.5em; margin: 0 3.75% 0% 10%;
            float: left;
        }
        
        #title{
            width: 15%;
        }
        
        .remind{
            letter-spacing: 0.05em; 
            font-size: 1em;
        }
        
        #prop{
            color: #2E317C;
            font-size: 2em;
        }
        
        .btn-outline-success{
            padding: 0.5em 1em; border: 0.15em solid;
            font-size: 0.75em;
        }
        
        .btn-success, .btn-secondary{
            font-size: 0.9em
        }
        
        td{
            line-height: 3.5em;
        }
        
        .icon{
			width: 10.5em; height: 7em;
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
                font-size: 0.75em; text-align: center;
            }
            
            .wrap{
                margin: auto;
            }
            
            .title{
                font-size: 1.125em;
            }
            
            .container{
                width: 95%; margin: auto; margin-top: 3%;
            }
            
            .card-header, .card-body{
                padding: 3%;
                font-size: 0.7em;
            }
            
            .alterlist{
                font-size: 0.75em;
            }
            
            .btn-outline-success{
                padding: 0.25em 0.5em;
            }
            
            .imgwrap{
                display: flex; text-align: center;
            }
            
            .sheep{
                width: 5em; margin: 0px auto; margin-bottom: 1em;
            }         
  
            #title, #search{
                width: 8em;
            }
            
            .remind{
                letter-spacing: 0;
                font-size: 0.75em;
            }
        
            #prop{
                font-size: 1.5em;
            }
            
            td{
                line-height: 1.5em;
            }
            
            .icon{
                width: 7.5em; height: 5em;
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
				data: {fetchAlter: 1},
                success: function(data){
                    console.log(data);
                    
                    var all_n=data[0]["COUNT(*)"]*(data[0]["COUNT(*)"]-1)/2;
					numberscroll("prop", data[1].length/all_n*100);
                    
                    for($i=0; $i<data[2].length; $i++){
                        if(data[2][$i]["DATE(last_record)"]==null){data[2][$i]["DATE(last_record)"]="-"}
                        var row_n=document.getElementById("alter_list").rows.length-1;
                        var append_row=document.getElementById("alter_list").insertRow(row_n);
                        
                        append_row.insertCell(0).innerHTML=data[2][$i]["alter_name"];
                        append_row.insertCell(1).innerHTML="<a class='btn btn-success' href=./tdiary.php?alter_id="+data[2][$i]['alter_id']+">????????????<br>????????????</a> <a class='btn btn-secondary' href=./edit_alter.php?alter_id="+data[2][$i]['alter_id']+">????????????<br>????????????</a>";
                        append_row.insertCell(2).innerHTML=data[2][$i]["touchtimes"];
                        append_row.insertCell(3).innerHTML=data[2][$i]["DATE(last_record)"];
                    }
                    
                    if(data[2].length==0){
                        $(".alter_n1").empty().append(0);
                        $(".alter_n2").empty().append(0);
                    }else{
                        $(".alter_n1").empty().append(1);
                        $(".alter_n2").empty().append(data[0]["COUNT(*)"]);
                    }
                    
                    function numberscroll(element, value){
                        var number= document.getElementById(element);
                        var scroll= 0;
                        var add= value/40;
                        var minTime= 1000/add;
                        var t= setInterval(function(){
                            if(scroll>=value){
                                clearInterval(t)
                                number.innerText= Math.floor(value*10)/10;
                            }else{
                                scroll+=add;
                                number.innerText= Math.floor(scroll*10)/10;
                            }
                        }, 25)
                        }
                }, error: function(e){
                    console.log(e);
                }
            })

            $("button[name='create_alter']").on("click", function(event){
			    event.preventDefault();
			    window.location.href="./create_alter.php";
			})
            
            $("#search").on("input", function(event){
                event.preventDefault();
                var search=$(this).val();
                
			    $.ajax({ 
                    type: "POST",
                    dataType: "json",
                    url: "",
                    data: {searchAlter: 1, search: search},
                    success: function(data){
                        console.log(data);
                        
                        var row=document.getElementById("alter_list").rows.length;
                        for($i=0; $i<row-2; $i++){
                            document.getElementById("alter_list").deleteRow(1);
                        }
                            
                        for($j=0; $j<data.length; $j++){
                            if(data[$j]["DATE(last_record)"]==null){data[$j]["DATE(last_record)"]="-"}
                            var row_n=document.getElementById("alter_list").rows.length-1;
                            var append_row=document.getElementById("alter_list").insertRow(row_n);

                            append_row.insertCell(0).innerHTML=data[$j]["alter_name"];
                            append_row.insertCell(1).innerHTML="<a class='btn btn-success' href=./tdiary.php?alter_id="+data[$j]['alter_id']+">????????????<br>????????????</a> <a class='btn btn-secondary' href=./edit_alter.php?alter_id="+data[$j]['alter_id']+">????????????<br>????????????</a>";
                            append_row.insertCell(2).innerHTML=data[$j]["touchtimes"];
                            append_row.insertCell(3).innerHTML=data[$j]["DATE(last_record)"];
                        }
                    
                        if(data.length==0){
                            $(".alter_n1").empty().append(0);
                            $(".alter_n2").empty().append(0);
                        }else{
                            $(".alter_n1").empty().append(1);
                            $(".alter_n2").empty().append(data.length);
                        }
                    }, error: function(e){
                        console.log(e);
                    }     
                })           
            })
            
            $("#back").on("click", function(event){
                event.preventDefault();
			    window.location.href="./main.php";
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
                <h5 class="modal-title" style="background-color: black; color: #FFFFFF">???? ?????????????????? ????</h5>
            </div>
                
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep" src="./pic/error.png"></div>
                <p>
                    <br>???????????? <b><a href="./profile.php">????????????</a></b>?????????????????????????????????
                    <br><br>
                    ?????????????????????<button style="border: none" onclick="window.open('mailto: ***@stat.sinica.edu.tw')"><b>??????????????????</b></button>
                </p>
            </div>
            <div style="text-align: right; padding: 1%">???</div>
        </div>
        </div>
    </div>
    
    <div class="wrap">
        <img id="title" src="./pic/square.png">
        <div class="title">??????????????????</div>
    </div>
    
    <div class="container" style="margin: 0.5em auto; text-align: right">
        <span class="remind">???????????? <span id="prop"></span> % ???????????????</span>
    </div>
        
    <div class="container">
        <div class="card">     
            <div class="card-header">
                <b>????????????</b>
                <button class="close"><a data-toggle="collapse" href=".card-body">&times;</a></button>
            </div>
            <div class="card-body show">
                1. ??????????????????<br>
                <p style="line-height: 1.75em; text-align: center">
                    ????????????????????????<span style="padding: 0.25em; background-color: yellow">?????????????????????LINE ????????????????????????????????????</span>??????????????????????????????????????????
                </p>
                <p>
                    2. ???????????????????????????????????????????????????????????????????????????????????????
                </p>
                <p>
                    3. ?????????????????????????????????????????????????????????????????????<button name="create_alter" class="btn btn-outline-success"><img style="width: 4em" src="./pic/create_alter.png"><br>??????????????????</button>???????????????????????????????????????????????????
                </p>
                <p>
                    4. ????????????<span style="padding: 0.25em; background-color: yellow">??????????????????</span>?????????????????????????????????????????????????????????<span style="padding: 0.25em; background-color: yellow">????????????????????????????????????</span>???
                </p>
                <div>
                    5. ?????????????????????????????????????????????<span style="padding: 0.25em; background-color: yellow">?????????????????????????????????</span>????????????????????????????????????????????????????????????????????????
                </div>
            </div>
        </div>
    </div><br>
    
    <div class="container alterlist">
        <p style="text-align: right">?????????????????????<input id="search"></p>
        <p>??? ??????<span style="color: blue">??????</span>???????????????</p>
        
        <table id="alter_list" class="table table-striped" style="text-align: center" cellspacing="0">
            <thead>
                <td>
                    <?php
                        if($c=="alter_name" and $s==1){
                        echo "<a href='./alter_list.php?c=alter_name&s=2'><b>?????????????????? ???</b></a>";
                        }else if($c=="alter_name" and $s==2){
                        echo "<a href='./alter_list.php?c=alter_name&s=1'><b>?????????????????? ???</b></a>";  
                        }else{
                        echo "<a href='./alter_list.php?c=alter_name&s=1'>??????????????????</a>";
                        }
                    ?>
                </td>
                <td class="function">????????????</td>
                <td>
                    <?php
                        if($c=="touchtimes" and $s==1){
                        echo "<a href='./alter_list.php?c=touchtimes&s=2'><b>???????????? ???</b></a>";
                        }else if($c=="touchtimes" and $s==2){
                        echo "<a href='./alter_list.php?c=touchtimes&s=1'><b>???????????? ???</b></a>";  
                        }else{
                        echo "<a href='./alter_list.php?c=touchtimes&s=1'>????????????</a>";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if($c=="last_record" and $s==1){
                        echo "<a href='./alter_list.php?c=last_record&s=2'><b>?????????????????? ???</b></a>";
                        }else if($c=="last_record" and $s==2){
                        echo "<a href='./alter_list.php?c=last_record&s=1'><b>?????????????????? ???</b></a>";  
                        }else{
                        echo "<a href='./alter_list.php?c=last_record&s=1'>??????????????????</a>";
                        }
                    ?>
                </td>
            </thead>
            <tr class="list">
            </tr>
        </table>
        
        ????????? <span class="alter_n1"></span> ??? <span class="alter_n2"></span> ??????????????? <span class="alter_n2"></span> ???
    </div>
    
    <center>
    <button id="back" class="btn">
        <img src="./pic/back_main.png" class="icon">
    </button>
    </center>
        
	<?php include("footer.php");?>
</body>
</html>

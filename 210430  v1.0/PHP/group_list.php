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

	if(isset($_POST["fetchGroupList"])){
		$sql1="SELECT * FROM `group_list` WHERE id= :v1";
		$stmt=$db->prepare($sql1);
		$stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
		$stmt->execute();
        
		$json=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$json[]=$row;
		}
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

	if(isset($_POST["formSubmit"])){
        $group_n=count($_POST["group_list"]["group_name"]);
        
        $sql2="DELETE FROM `group_list` WHERE id= :v1";
        $stmt=$db->prepare($sql2);
        $stmt->bindParam(":v1", $_SESSION["acc_info"]["id"]);
        $stmt->execute();
 
        for($i=0; $i<$group_n; $i++){
            $sql3="INSERT INTO `group_list` VALUES (NULL, :v2, :v3, :v4, :v5, :v6, :v7, NOW())";
            $stmt=$db->prepare($sql3);
            $stmt->bindParam(":v2", $_SESSION["acc_info"]["id"]);
            $stmt->bindParam(":v3", $_POST["group_list"]["group_name"][$i]);
            $stmt->bindParam(":v4", $_POST["group_list"]["group_myname"][$i]);
            $stmt->bindParam(":v5", $_POST["group_list"]["group_freq"][$i]);
            $stmt->bindParam(":v6", $_POST["group_list"]["group_religion"][$i]);
            $stmt->bindParam(":v7", $_POST["group_list"]["group_invite"][$i]);
            $stmt->execute();
        }
        echo "Grouplist Update Success";
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>群組管理</title>
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
				data: {fetchGroupList: 1},
                success: function(data){
                    console.log(data);
                    
                    if(data){
                        for(var i=0; i<data.length; i++){
							var tmp=$(".group_info").clone().last();
                            if(i==0){$(".group_info").remove()};
                            
                            tmp.find(".count").empty().append(i+1);	
							tmp.find("input[name='group_name']").val(data[i].group_name);
							tmp.find("input[name='group_myname']").val(data[i].myname);
                            tmp.find("label").removeClass("active");
							tmp.find("input[class='group_freq']").attr("name", "group_freq_"+i);
                            tmp.find("input[class='group_freq'][value='"+data[i].check_freq+"']").prop("checked", true).parent().addClass("active");
                            tmp.find("input[class='group_invite']").attr("name", 'group_invite_'+i);
                            tmp.find("input[class='group_invite'][value='"+data[i].n_invitees+"']").prop("checked", true).parent().addClass("active");
                            
							$(".vertical_wrapper1").append(tmp);
                        }
                    }
                }, error: function(e){
                    console.log(e);
                }
            })
            
            $("#create_group").on("click", function(event){
				event.preventDefault();
                $("#create_group").parent().hide();
				$(".vertical_wrapper2").show();
                $(".add_minus").show();
			})
            
            $("#group_add").on("click", function(event){
				event.preventDefault();
				var tmp=$(".newgroup_info").clone().last();
                
                tmp.find("input[type='text']").val("");
                tmp.find("label").removeClass("active");
                var index=parseInt(tmp.find("input[class='group_freq']").attr("name").split("_").slice(-1)[0]);
				tmp.find("input[class='group_freq']").attr("name", "group_freq_"+(index+1)).prop("checked", false);
				tmp.find("input[class='group_invite']").attr("name", "group_invite_"+(index+1)).prop("checked", false);
                
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
              
            $("#submit").on("click", function(event){
                event.preventDefault();
                $("#submit").attr("disabled", true);

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
                console.log(group_list);
                
                if((group_list.group_name.length!=group_list.group_religion.length)|
                   (group_list.group_myname.length!=group_list.group_religion.length)|
                   (group_list.group_invite.length!=group_list.group_religion.length)){
                    
                    $("#submit").attr("disabled", false);
                    $.alert({
						title: "",
					    content: "請檢查是否有欄位漏填唷！",
					})
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: "",
                        data: {formSubmit: 1, group_list: group_list},
                        success: function(data){
                            console.log(data);
                            
                            if(data=="Grouplist Update Success"){
                                $("#success").modal("show");
                                $(".group_n").empty().append(group_list.group_name.length);
                                setTimeout("window.location.href='./main.php'", 5000);
                            }
                        }, error: function(e){
                            console.log(e);
                        }
                    })
                }
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
	<?php include "header.php";?>
    
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
                <h5 class="modal-title" style="background-color: yellow">⭐ 更新成功 ⭐</h5>
            </div>
                
            <div class="modal-body">
                <div class="imgwrap"><img class="sheep2" src="./pic/greeting.png"></div>
                <p>
                    <br>已為您更新群組清單<br>您目前共有【<b><span class="group_n"></span></b>】個群組囉！
                    <br><br>
                    5 秒後將為您導回：主畫面
                </p>
            </div>
            <div style="text-align: right; padding: 1%">❽</div>
        </div>
        </div>
    </div>
    
    <div class="wrap">
        <img id="title" src="./pic/square.png">
        <div class="title">群組管理</div>
    </div>
    
    <div class="container">        
        <div class="card">
            <div class="card-body">
                <form id="groupForm">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                    
                <p>
                    第一部分：我的群組清單
                </p>  
                <div class="col-sm-auto">
                    <div class="part1" style="padding: 0.5em">除了實體活動之外，線上的宗教互動也是本研究關心的重點。<br>
                        請提供您目前<b title="★ 固定會查閱、瀏覽或發文 ★">常用<i class="fa fa-info-circle"></i></b>的<b title="★ LINE、臉書等社群軟體均可 ★">宗教群組<i class="fa fa-info-circle"></i></b>，這些資料將與日後生活日記、接觸紀錄的填寫有關。<br><br>
                    <div style="color: #EF475D; text-align: center"><b>本區為您先前建立之清單，若需要修改，直接重選答案即可。</b></div></div>
				</div><br>

                <div class="vertical_wrapper1">
                <div class="group_info">
                    <div style="text-align: center">群組 <span class="count"></span></div>
                    
                    <div class="row" style="padding-top: 1em">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part1">A. 群組名稱：</div>
				        </div>
                        <div class="col-sm-7 pl-0 pr-0">
				            <input class="form-control btn-outline-success" type="text" name="group_name" required>
				        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part1">B. 我在群組中使用的名字：</div>
				        </div>
                        <div class="col-sm-7 pl-0 pr-0">
				            <input class="form-control btn-outline-success" type="text" name="group_myname" required>
				        </div>
				    </div>
                    
                    <div class="row">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part1">C. 查閱群組的頻率：</div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
				            <label class="btn btn-outline-success"><input type="radio" class="group_freq" name="group_freq_0" value="0" required>每天多次</label>
				            <label class="btn btn-outline-success"><input type="radio" class="group_freq" name="group_freq_0" value="1" required>每天一次</label>
                            <label class="btn btn-outline-success"><input type="radio" class="group_freq" name="group_freq_0" value="2" required>兩、三天一次</label>
                            <label class="btn btn-outline-success"><input type="radio" class="group_freq" name="group_freq_0" value="3" required>偶爾</label>
				        </div>
				    </div>
                    
                    <div class="row" style="padding-bottom: 1em">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text part1">D. 我曾邀請多少人加入此群組？</div>
				        </div>
                        <div class="btn-group btn-group-toggle col-sm-7 pl-0 pr-0" data-toggle="buttons">
                            
				            <label class="btn btn-outline-success"><input type="radio" class="group_invite" name="group_invite_0" value="0" required>0 人</label>
				            <label class="btn btn-outline-success"><input type="radio" class="group_invite" name="group_invite_0" value="1" required>1-4 人</label>
                            <label class="btn btn-outline-success"><input type="radio" class="group_invite" name="group_invite_0" value="2" required>>5 人</label>
				        </div>
				    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="container" style="padding-top: 1em">        
        <div class="card">
            <div class="card-body">
                <p>
                    ▼ 將游標移至<b title="★ 沒錯！就是這樣 ★">粗體字<i class="fa fa-info-circle"></i></b>即可查看文詞定義
                </p>
                
                <p>
                    第二部分：建立新群組
                </p>  
                <div class="col-sm-auto">
                    <div style="padding: 0.5em; background-color: #E9ECEF">除了實體活動之外，線上的宗教互動也是本研究關心的重點。<br>
                    請提供您目前<b title="★ 固定會查閱、瀏覽或發文 ★">常用<i class="fa fa-info-circle"></i></b>的<b title="★ LINE、臉書等社群軟體均可 ★">宗教群組<i class="fa fa-info-circle"></i></b>，這些資料將與日後生活日記、接觸紀錄的填寫有關。<br><br>
                    <div style="color: #2E317C; text-align: center"><b>您可以在本區新增清單（點擊<i class="fas fa-plus-circle"></i>、<i class="fas fa-minus-circle"></i>按鈕可增減群組）</b></div></div>
				</div><br>
                
                <p style="padding-top: 1em; text-align: center">
                    <button id="create_group" class="btn btn-outline-secondary"><img style="width: 3em" src="./pic/create_alter.png"><br>開始新增群組</button>
                </p>
                
                <div class="vertical_wrapper2" style="display: none">
                <div class="newgroup_info">
                    <div style="padding-top: 1em; text-align: center">新增群組</div>
                    
                    <div class="row">
                        <div class="col-sm-5 pl-0 pr-0">
				            <div class="input-group-text">A. 群組名稱：</div>
				        </div>
                        <div class="col-sm-7 pl-0 pr-0">
				            <input class="form-control btn-outline-secondary" type="text" name="group_name" required>
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
                
                <div class="add_minus" style="display: none"><hr>
                    <button id="group_add" class="btn" style="margin: -0.4em"><i class="fas fa-plus-circle"></i></button>
                    <button id="group_minus" class="btn" style="margin: -0.4em"><i class="fas fa-minus-circle"></i></button>
				</div><br>      
                <div style="text-align: center">
                    <button id="submit" class="btn">
                        <img src="/pic/submit.png" class="icon">
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
	
    <?php include "footer.php";?>
</body>
</html>

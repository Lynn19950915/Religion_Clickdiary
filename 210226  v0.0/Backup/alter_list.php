<?php
	session_start();
	include("db.php"); 
	CheckAccInfo();
	$id		= $_SESSION['acc_info']['id'];
	
	if(isset($_POST['FetchAlterlist'])){
		$sql = "SELECT alter_id, member_id, alter_name, touchtimes
				FROM `alter_list` 
				WHERE ego_id = :ego_id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':ego_id', $id);
		$stmt->execute();
		$json = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

	if(isset($_POST['FetchAltersTbl'])){
		$sql = "SELECT DISTINCT ego_id, alter_id1, alter_id2 
				FROM `alters_table`
				WHERE ego_id = :ego_id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':ego_id', $id);
		$stmt->execute();
		$json = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
		exit();
	}

?><!DOCTYPE html>
<html>
<head>
	<title>管理我的接觸對象</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- DataTable-->
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.bootstrap.min.css">
	<!-- Jquery UI -->
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
	<!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
	<!-- Progress Bar -->
	<script src="js/progressbar.js"></script>
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script type="text/javascript">
		var alterlist;
		var alterstbl;

		$(document).ready(function(){

			// Alterlist
			FetchAlterlist();
			FetchAltersTbl();
			
			_.map(alterlist, function(obj){
				// console.log(obj.alter_id, typeof(obj.alter_id))
				var tmp = _.filter(alterstbl, function(o) { 
							return (o.alter_id1 == obj.alter_id) || (o.alter_id2 == obj.alter_id);
						  });
				// 存在於alters_tbl的alter_id，即已確認者
				var tmp_alterid = _.union(
									_.map(tmp, 'alter_id1'),
									_.map(tmp, 'alter_id2')
								  )
				// 該alter本身不算
				_.remove(tmp_alterid, function(o) { 
					return o == obj.alter_id;
				})

				// console.log(tmp, tmp_alterid)
				var n_unchecked_alters = _.size(alterlist) - 1 - _.size(tmp_alterid)
				// console.log(n_unchecked_alters)
				obj.n_unchecked_alters = n_unchecked_alters
			})

			var n_alters = _.size(alterlist)
			var total_pairs = n_alters * (n_alters - 1) / 2
			var unchk_pairs = _.sumBy(alterlist, 'n_unchecked_alters') / 2; // 未確認的pair會被重複計算，故需除以2
			var chk_prop    = _.round(1 - (unchk_pairs / total_pairs), 4)
			chk_prop = chk_prop || 0
			console.log(total_pairs, unchk_pairs, chk_prop)
			LoadProgressBar(chk_prop);

			$('#example').dataTable({
				// "ajax": {
				// 	"url": "db_myalters_test.php",
				// 	"dataSrc": ""
				// },
				"data": alterlist,
                "columns": [
                    //{ "data": "alter_id" },
                    { "data": "alter_name" },
					// { "data": "member_id" },
					{ "mData": null,
					  "bSortable": false,
					  "mRender": function (o) { 
					  	return 	'<a class="btn btn-success" href=tdiary.php?alter_id=' + o.alter_id + '>' + '填寫與此人<br>接觸記錄' + '</a>' + 
					  			'&nbsp;' + 
					  			'<a class="btn btn-primary" href=edit_alter_profile.php?alter_id=' + o.alter_id + '>' + '重新編輯已輸入的<br>接觸對象資料' + '</a>' ;
					  }
					},
					{ "data": "touchtimes" },
					{ "data": "n_unchecked_alters" },
                ],
				"oLanguage":{"sProcessing":"處理中...",
							 "sLengthMenu":"顯示 _MENU_ 項結果",
							 //"sZeroRecords":"沒有匹配結果",
							 "sInfo":"顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
							 "sInfoEmpty":"顯示第 0 至 0 項結果，共 0 項",
							 "sInfoFiltered":"(從 _MAX_ 項結果過濾)",
							 "sSearch":"搜尋:",
							 "oPaginate":{"sFirst":"首頁",
												  "sPrevious":"上一頁",
												  "sNext":"下一頁",
												  "sLast":"尾頁"}
				},
				autoWidth: true,
				responsive: true,
				info:true,
				// "order": [[ 4, "desc" ]], // 3 means 4th column
				 columnDefs: [
					{ responsivePriority: 1, targets: 0 },
					{ responsivePriority: 2, targets: 1 },
					{ responsivePriority: 3, targets: 2 }
				]
			});

			$("#btn_create_alter").on('click', function() {
				window.location.href = "http://cdiary3.tw/create_alter.php";	
			})

			$("#btn_FinishDiary").on('click', function() {
				$.confirm({
					title: '',
				    content: '已完成此次的日記填寫囉<br>感謝您的參與及協助!',
				    buttons: {
				        '好': function() {
				        	window.location.href = 'http://cdiary3.tw/';
				        }
				    }
				})
			})
		});

		function FetchAlterlist(){
			$.ajax({ 
				type: "POST",
				async: false,
				dataType: "json", 
				url: '',
				data: {
					FetchAlterlist: 1,
				},success: function(data){
					console.log("alterlist", data)
					alterlist = data
				},error: function(e){
					console.log(e)
				}
			})
		}

		function FetchAltersTbl(){
			$.ajax({ 
				type: "POST",
				async: false,
				dataType: "json", 
				url: '',
				data: {
					FetchAltersTbl: 1,
				},success: function(data){
					console.log("alterstbl", data)
					alterstbl = data
				},error: function(e){
					console.log(e)
				}
			})
		}

		function LoadProgressBar(fprop){
			// progressbar.js@1.0.0 version is used
			// Docs: http://progressbarjs.readthedocs.org/en/1.0.0/

			var bar = new ProgressBar.Line(myBar, {
			  strokeWidth: 4,
			  easing: 'easeInOut',
			  duration: 1400,
			  color: '#00BBFF',
			  trailColor: '#eee',
			  trailWidth: 1,
			  svgStyle: {
			  	width: '50%', height: '2em'
			  },
			  text: {
			    style: {
			      // Text color.
			      // Default: same as stroke color (options.color)
			      color: '#0000AA',
			      'font-size': '1.5em',
			      position: 'relative',
			      // right: '50%',
			      // top: '15%',
			      padding: 0,
			      margin: 0,
			      transform: null
			    },
			    autoStyleContainer: false
			  },
			  from: {color: '#FFEA82'},
			  to: {color: '#ED6A5A'},
			  step: function(state, bar){
			    bar.setText('接觸對象關係確認比例：' + _.round(bar.value() * 100, 2) + ' %');
			  }
			});

			bar.animate(fprop);  // Number from 0.0 to 1.0
		}
	</script>
	<style type="text/css">
		/*For nav and footer*/
		html {
			  position: relative;
			  min-height: 100%;
			}
			body {
			  /*Avoid nav bar overlap web content*/
			  padding-top: 70px; 
			  /* Margin bottom by footer height ，avoid footer overlap web content*/
			  margin-bottom: 80px;
			}
			.footer {
			  position: absolute;
			  bottom: 0;
			  width: 100%;
			  /* Set the fixed height of the footer here */
			  /*height: 60px;*/
			  /*line-height: 60px; */
			  /* Vertically center the text there */
			  background-color: #f5f5f5;
			  
			}
			.text{
				display: table-cell;
			    vertical-align: middle;
			    /*height: 100%;*/
			    font-size: 0.8em;
			    padding-top: 0.5em
			}
			#footerimg{
				float: left;
				height: 3em;
				padding-top: 0.5em;
			}
		/**/
		#example_length{
			display:none
		}
		/*Adjust to make 3 columns shown on mobile*/
		.container{
			padding-left:2px;
			padding-right:2px;
		}
		table.dataTable tbody td {
			padding: 8px 2px;
		}
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px 5px;
		}
		/* Dialog */
		.ui-widget-header,.ui-state-default, ui-button{
            background: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
            font-weight: solid;
	    }
	    .ui-dialog .ui-dialog-content{
	    	padding: 0;
	    }

	    /* Progress Bar */
	    /*#myProgress {
		  width: 15em;
		  background-color: #ddd;
		}

		#myBar {
		  width: 1%;
		  height: 30px;
		  background-color: #4CAF50;
		}*/

		.btn-img {
			border-color: #8a6d3b;
			color: #8a6d3b;
			background-color: white;
			margin-right: 1em;
			/*height: 5em;*/
			/*width: 10em;*/
			/*margin: auto 1em;*/
		}

		.btn-img:hover {
			background: #FFB655;
			color: white;
		}

		#btn_FinishDiary {
			height: 5em;
		}

		@media screen and (max-width: 550px) { 
			#div_Functionalbtns{
				text-align: -webkit-center;
			}
		}
		
	</style>
	
</head>
<body>
	<?php include "header_b3.php"; ?>
	<div>
		<div id="dialog"></div>	
	</div>
	<div class="container">
		<div align='center' style='font-size:1.5em;'>
			您宗教生活圈中的接觸對象<br>
			<!-- <span style="font-size: 0.8em;">接觸對象關係確認比例</span> -->
			<!--<span style='font-size:0.7em;color:red;'>(註:系統自動隱藏一小時內填過的對象)</span>-->
		</div>

		<div align="center">
			<div id="myProgress">
			  <div id="myBar"></div>
			</div>	
		</div>
		<div >
			<table id="example" class="table display table-striped responsive nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>接觸對象姓名</th>
						<!-- <th>會員編號</th> -->
						<th>操作</th>
						<th>接觸次數</th>
						<th>尚未確認關係的對象人數</th>
						<!-- <th>邀請狀態</th> -->
					</tr>
				</thead>
			</table>
		</div>
		<div id="div_Functionalbtns">
			<button id="btn_create_alter" class="btn btn-img">
				<img src="./pic/create_alter_64.png"><br>新增上面未列出的接觸對象
			</button>
			<button id="btn_FinishDiary" class="btn btn-lg btn-danger">
				已完成此次所有<br>接觸資料的填寫
			</button>
		</div>
		
		<!-- <div align='left'>
			<button id="myalters_invited" class="btn btn-warning" onclick="location.href='myalters_invited.php'">檢視我已邀請的對象</button>
		</div> -->
	</div>
	<footer class="footer">
  		<div>
  			<img id="footerimg" src="./pic/Academia_Sinica_Emblem.png" >
		    <div class="text">
			著作權©中研院統計科學研究所. 版權所有.<br>
		    Copyright© Institute of Statistical Science, Academia Sinica.
		    All rights reserved.
		    </div>
		</div>
	</footer>
</body>
</html>
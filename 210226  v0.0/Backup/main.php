<?php
	session_start();
	include("db.php"); 
	CheckAccInfo();

	if (isset($_POST['FetchHDiary'])) {
		$id   		= $_SESSION['acc_info']['id'];
		// $id   		= 2;
		$month_st 	= date('Y-m-01');
		$month_ed   = date('Y-m-t');

		$sql  = "SELECT id, date, count(*) as cnt FROM `hdiary`  WHERE id = :v1 AND `date` >= :v2 AND `date` <= :v3 GROUP BY id, `date`";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $id);
		$stmt->bindParam(':v2', $month_st);
		$stmt->bindParam(':v3', $month_ed);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		$json = empty($json) ?null :$json;
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}
	
	if (isset($_POST['FetchTDiary_yd'])) {
		$ego_id   	= $_SESSION['acc_info']['id'];
		$date_yd 	= date("Y-m-d",strtotime('-1 days'));

		$sql  = "SELECT ego_id, date, count(*) as cnt FROM `tdiary`  
				 WHERE ego_id = :v1 AND `date` = :v2
				 GROUP BY ego_id, `date`";		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $date_yd);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		$json = empty($json) ?null :$json;
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}



	if (isset($_POST['FetchTDiary'])) {
		$ego_id   	= $_SESSION['acc_info']['id'];

		$month_st 	= date('Y-m-01');
		$month_ed   = date('Y-m-t');
		

		$sql  = "SELECT ego_id, date, count(*) as cnt FROM `tdiary`  
				 WHERE ego_id = :v1 AND `date` >= :v2 AND `date` <= :v3 
				 GROUP BY ego_id, `date`";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $ego_id);
		$stmt->bindParam(':v2', $month_st);
		$stmt->bindParam(':v3', $month_ed);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$json[] = $row;
		}
		$json = empty($json) ?null :$json;
		echo json_encode($json, JSON_UNESCAPED_UNICODE);
		exit();
	}

	/*
	$now		= time();
	$today 		= date("Y-m-d");
	$yesterday 	= date("Y-m-d",strtotime('-1 days'));
	
	$today_week=date("W"); 	// 大寫W表示一年中的第幾週
	$day = date('w');		// 小寫w表示weekday，0為Sunday，6為Saturday
	$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
	$week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
	
	$month = date('m');
	$month_start = date('Y-m-01');
	$month_end   = date('Y-m-t');
	*/
?><!DOCTYPE html>
<html>
<head>
	<title>點日記3.0</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache">
	<!-- Bootsrap 4 CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- SelectPicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
	<!-- Lodash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
	<!-- React -->
	<script src="https://cdn.staticfile.org/react/16.4.0/umd/react.development.js"></script>
	<script src="https://cdn.staticfile.org/react-dom/16.4.0/umd/react-dom.development.js"></script>
	<script src="https://cdn.staticfile.org/babel-standalone/6.26.0/babel.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			// ReactDOM.render(React.createElement(Leaderboard, null), document.getElementById('app'));
			(function(){
				$.ajax({ 
					type: "POST",
					dataType: "json", 
					url: '',
					data: {
						FetchHDiary: 1
					}, success: function(data) {
						console.log("data", data)
						
						var date_td = (function(d){ 
										var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
										var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
										var yyyy = d.getFullYear();			
										return (yyyy + "-" + MM + "-" + dd);
									  })(new Date);

						var date_yd = (function(d){ 
										d.setDate(d.getDate() - 1);
										var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
										var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
										var yyyy = d.getFullYear();			
										return (yyyy + "-" + MM + "-" + dd);
									  })(new Date);

						var date_week_st = 	(function(d){ 
												d.setDate(d.getDate() - 6);
												var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
												var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
												var yyyy = d.getFullYear();			
												return (yyyy + "-" + MM + "-" + dd);
											})(new Date);

						var date_month_st = (function(d){ 
												var dd = "01";
												var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
												var yyyy = d.getFullYear();			
												return (yyyy + "-" + MM + "-" + dd);
											})(new Date);

						var date_month_ed = (function(d){ 
												var dd = new Date(d.getFullYear(), (d.getMonth() + 1), 0).getDate();
												var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
												var yyyy = d.getFullYear();			
												return (yyyy + "-" + MM + "-" + dd);
											})(new Date);

							// console.log(date_td, date_yd, date_week_st, date_month_st, date_month_ed)
							isHd_td  = _.filter(data, o => o.date == date_td).length > 0;
							isHd_yd  = _.filter(data, o => o.date == date_yd).length > 0;
							cnt_Hd_w = _.filter(data, o => o.date >= date_week_st && o.date <= date_td).length;
							cnt_Hd_m = _.filter(data, o => o.date >= date_month_st && o.date <= date_month_ed).length;
							// console.log(isHd_yd, isHd_td, cnt_Hd_w, cnt_Hd_m)
							$("#isHd_yd").append(
								isHd_yd
								? $("<i>").attr({
									'class': 'fa fa-check',
									'aria-hidden': 'true', 
									'style': 'color: lightgreen; font-size: 1.5em;'
								  }).html(" 完成")
									
								: $("<i>").attr({
									'class': 'fa fa-times', 
									'aria-hidden': 'true', 
									'style': 'color: red; font-size: 1.5em;'
								  }).html(" 尚未")
							)

							$("#isHd_td").append(
								isHd_td
								? $("<i>").attr({
									'class': 'fa fa-check',
									'aria-hidden': 'true', 
									'style': 'color: lightgreen; font-size: 1.5em;'
								  }).html(" 完成")
									
								: $("<i>").attr({
									'class': 'fa fa-times', 
									'aria-hidden': 'true', 
									'style': 'color: red; font-size: 1.5em;'
								  }).html(" 尚未")
							)
							$("#cnt_Hd_w").html(cnt_Hd_w)
							$("#cnt_Hd_m").html(cnt_Hd_m)
					}, error: function(e) {
						console.log(e)
					}
				})
			})();

			(function(){
				$.ajax({ 
					type: "POST",
					dataType: "json", 
					url: '',
					data: {
						FetchTDiary_yd: 1
					}, success: function(data) {
						console.log("data", data)


						var date_yd = (function(d){ 
										d.setDate(d.getDate() - 1);
										var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
										var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
										var yyyy = d.getFullYear();			
										return (yyyy + "-" + MM + "-" + dd);
									  })(new Date);

						isTd_yd = _.filter(data, o => o.date == date_yd).length > 0;
						cnt_Td_yd = _(data).filter(o => o.date == date_yd).map('cnt').value().toString() || 0;

						$("#isTd_yd").append(
							isTd_yd
							? $("<i>").attr({
								'class': 'fa fa-check',
								'aria-hidden': 'true', 
								'style': 'color: lightgreen; font-size: 1.5em;'
							  }).html(" 完成")
								
							: $("<i>").attr({
								'class': 'fa fa-times', 
								'aria-hidden': 'true', 
								'style': 'color: red; font-size: 1.5em;'
							  }).html(" 尚未")
						)

						$("#cnt_Td_yd").html(cnt_Td_yd)
					}
				})
			})();

			(function(){
				$.ajax({ 
					type: "POST",
					dataType: "json", 
					url: '',
					data: {
						FetchTDiary: 1
					}, success: function(data) {
						console.log("data", data)
						
						var date_td = (function(d){ 
										var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
										var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
										var yyyy = d.getFullYear();			
										return (yyyy + "-" + MM + "-" + dd);
									  })(new Date);

						var date_yd = (function(d){ 
										d.setDate(d.getDate() - 1);
										var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
										var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
										var yyyy = d.getFullYear();			
										return (yyyy + "-" + MM + "-" + dd);
									  })(new Date);

						var date_week_st = 	(function(d){ 
												d.setDate(d.getDate() - 6);
												var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
												var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
												var yyyy = d.getFullYear();			
												return (yyyy + "-" + MM + "-" + dd);
											})(new Date);

						var date_month_st = (function(d){ 
												var dd = "01";
												var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
												var yyyy = d.getFullYear();			
												return (yyyy + "-" + MM + "-" + dd);
											})(new Date);

						var date_month_ed = (function(d){ 
												var dd = new Date(d.getFullYear(), (d.getMonth() + 1), 0).getDate();
												var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
												var yyyy = d.getFullYear();			
												return (yyyy + "-" + MM + "-" + dd);
											})(new Date);

						// console.log(date_td, date_yd, date_week_st, date_month_st, date_month_ed)
							isTd_td = _.filter(data, o => o.date == date_td).length > 0;
							cnt_Td_td = _(data).filter(o => o.date == date_td).map('cnt').value().toString() || 0;
							
							cnt_Td_w_days  = _.filter(data, o => o.date >= date_week_st && o.date <= date_td).length
							cnt_Td_w_times = _.sum(
												_(data).filter(o => o.date >= date_week_st && o.date <= date_td)
												.map((obj, key) => _.toNumber(obj.cnt))
					    						.value()
				    						)

							cnt_Td_m_days  = _.filter(data, o => o.date >= date_month_st && o.date <= date_month_ed).length
							cnt_Td_m_times = _.sum(
												_(data).filter(o => o.date >= date_month_st && o.date <= date_month_ed)
												.map((obj, key) => _.toNumber(obj.cnt))
					    						.value()
				    						)
							console.log(
								isTd_td, cnt_Td_td, 
								cnt_Td_w_days, cnt_Td_w_times, 
								cnt_Td_m_days, cnt_Td_m_times
							)
							
							

							$("#isTd_td").append(
								isTd_td
								? $("<i>").attr({
									'class': 'fa fa-check',
									'aria-hidden': 'true', 
									'style': 'color: lightgreen; font-size: 1.5em;'
								  }).html(" 完成")
									
								: $("<i>").attr({
									'class': 'fa fa-times', 
									'aria-hidden': 'true', 
									'style': 'color: red; font-size: 1.5em;'
								  }).html(" 尚未")
							)


							$("#cnt_Td_td").html(cnt_Td_td)
							$("#cnt_Td_w_days").html(cnt_Td_w_days)
							$("#cnt_Td_w_times").html(cnt_Td_w_times)
							$("#cnt_Td_m_days").html(cnt_Td_m_days)
							$("#cnt_Td_m_times").html(cnt_Td_m_times)
						
					}, error: function(e) {
						console.log(e)
					}
				})
			})();

			var id = "<?php echo $_SESSION['acc_info']['id']; ?>";
			var date_td = (function(d){ 
							var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
							var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
							return (MM + "/" + dd);
							// var yyyy = d.getFullYear();			
							// return (yyyy + "-" + MM + "-" + dd);
						  })(new Date);

			var date_yd = (function(d){ 
							d.setDate(d.getDate()-1);
							var dd = (d.getDate() < 10 ? '0' : '') + d.getDate();
							var MM = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
							return (MM + "/" + dd);
							// var yyyy = d.getFullYear();			
							// return (yyyy + "-" + MM + "-" + dd);
						  })(new Date);

			var tmp = 0;

			$(".card-header").html("我的會員編號:" + id);

			$("#tbl_diary_summary").append(
				$("<thead>").append(
					$("<tr>").append(
						$("<th>").attr({'style': 'width: 20%;'})
					).append(
						$("<th>").attr({'style': 'text-align:center;'}).html("生活日記<br>(天數)")
					).append(
						$("<th>").attr({'style': 'text-align:center;'}).html("接觸日記<br>(天數)")
					).append(
						$("<th>").attr({'style': 'text-align:center;'}).html("接觸日記<br>(次數)")
					)
				)
			).append(
				$("<tbody>").append(
					$("<tr>").append(
						$("<td>").html("昨日 (" + date_yd + ")")
					).append(
						$("<td>").attr({'id': 'isHd_yd'})
					).append(
						$("<td>").attr({'id': 'isTd_yd'})
					).append(
						$("<td>").attr({'id': 'cnt_Td_yd'})
					)
				).attr({'class': 'text-center'})
			).append(
				$("<tbody>").append(
					$("<tr>").append(
						$("<td>").html("今日 (" + date_td + ")")
					).append(
						$("<td>").attr({'id': 'isHd_td'})
					).append(
						$("<td>").attr({'id': 'isTd_td'})
					).append(
						$("<td>").attr({'id': 'cnt_Td_td'})
					)
				).attr({'class': 'text-center'})
			).append(
				$("<tbody>").append(
					$("<tr>").append(
						$("<td>").html("本周累積")
					).append(
						$("<td>").attr({'id': 'cnt_Hd_w'})
					).append(
						$("<td>").attr({'id': 'cnt_Td_w_days'})
					).append(
						$("<td>").attr({'id': 'cnt_Td_w_times'})
					)
				).attr({'class': 'text-center'})
			).append(
				$("<tbody>").append(
					$("<tr>").append(
						$("<td>").html("本月累積")
					).append(
						$("<td>").attr({'id': 'cnt_Hd_m'})
					).append(
						$("<td>").attr({'id': 'cnt_Td_m_days'})
					).append(
						$("<td>").attr({'id': 'cnt_Td_m_times'})
					)
				).attr({'class': 'text-center'})
			)
		})

		const colors = [
			'#E74856',
			'#FFB900',
			"#e1e100",
			"#8cea00",
			"#02df82",
			"#00caca",
			"#0072e3",
			"#2828ff",
			"#8600ff",
			"#6c6c6c",
		];

		class Leaderboard extends React.Component {
			constructor() {
				super();
				this.state = {
				  leaders: [],
				  maxScore: 200 };
				this.getData = this.getData.bind(this);
			}
			getData() {
			/* Here you can implement data fetching */
				const tmp = this;
				fetch('http://cdiary2.tw/db_FetchRankData.php', {
					method: 'post'
				}).then((response) => {
				  if (!response.ok) throw new Error(response.statusText)
				  return response.json()
				}).then((fjson) => {
				    _.map(fjson, function(obj, i){
				    	obj.id 		= _.toNumber(i) + 1
				    	obj.ego_id  = _.toNumber(obj.ego_id)
				    	obj.rank 	= _.toNumber(obj.rank)
				    	obj.cnt 	= _.toNumber(obj.cnt)
				    })
				    // console.log("fjson",fjson)
				    var rankdata = _.filter(fjson, function(o) { return o.rank < 10; });
				    console.log("Rank Data", rankdata)
				    const data = {
				      success: true,
				      leaders: rankdata,
				      maxScore: rankdata[0].cnt
				  	};
				  	tmp.setState({
				      leaders: data.leaders,
				      maxScore: data.maxScore 
				  	});
				})
			}
			componentWillMount() {
			this.getData();
			/*data is refreshing every 3 minutes*/
			setInterval(this.getData, 180000);
			}
			render() {
				return (
					React.createElement("div", { className: "Leaderboard" },
						React.createElement("div", { className: "leaders" },
							this.state.leaders 
							? this.state.leaders.map((el, i) =>
								React.createElement("div", {
									key: el.id,
									style: {
									  animationDelay: i * 0.01 + 's' },
									className: "leader" },
									React.createElement("div", { className: "leader-wrap" },
									i < 3 ?
									React.createElement("div", 
										{
											style: {
											  // backgroundColor: colors[i] 
											  backgroundColor: colors[el.rank] 
											},
											className: "leader-ava" 
										},
										React.createElement("svg", {
											fill: "#fff",
											xmlns: "http://www.w3.org/2000/svg",
											height: 24,
											width: 24,
											viewBox: "0 0 32 32" },
											React.createElement("path", { d: "M 16 3 C 14.354991 3 13 4.3549901 13 6 C 13 7.125993 13.63434 8.112309 14.5625 8.625 L 11.625 14.5 L 7.03125 11.21875 C 7.6313215 10.668557 8 9.8696776 8 9 C 8 7.3549904 6.6450096 6 5 6 C 3.3549904 6 2 7.3549904 2 9 C 2 10.346851 2.9241199 11.470238 4.15625 11.84375 L 6 22 L 6 26 L 6 27 L 7 27 L 25 27 L 26 27 L 26 26 L 26 22 L 27.84375 11.84375 C 29.07588 11.470238 30 10.346852 30 9 C 30 7.3549901 28.645009 6 27 6 C 25.354991 6 24 7.3549901 24 9 C 24 9.8696781 24.368679 10.668557 24.96875 11.21875 L 20.375 14.5 L 17.4375 8.625 C 18.36566 8.112309 19 7.125993 19 6 C 19 4.3549901 17.645009 3 16 3 z M 16 5 C 16.564129 5 17 5.4358709 17 6 C 17 6.5641291 16.564129 7 16 7 C 15.435871 7 15 6.5641291 15 6 C 15 5.4358709 15.435871 5 16 5 z M 5 8 C 5.5641294 8 6 8.4358706 6 9 C 6 9.5641286 5.5641291 10 5 10 C 4.4358709 10 4 9.5641286 4 9 C 4 8.4358706 4.4358706 8 5 8 z M 27 8 C 27.564129 8 28 8.4358709 28 9 C 28 9.5641283 27.564128 10 27 10 C 26.435872 10 26 9.5641283 26 9 C 26 8.4358709 26.435871 8 27 8 z M 16 10.25 L 19.09375 16.4375 L 20.59375 16.8125 L 25.59375 13.25 L 24.1875 21 L 7.8125 21 L 6.40625 13.25 L 11.40625 16.8125 L 12.90625 16.4375 L 16 10.25 z M 8 23 L 24 23 L 24 25 L 8 25 L 8 23 z" })
										)
									) 
									: null,
									React.createElement("div", { className: "leader-content" },
										React.createElement("div", 
											{ className: "leader-name" },
											React.createElement("div", 
												{ 
													style: {backgroundColor: colors[el.rank]},
													className: "numberCircle" 
												},
												(el.rank + 1) 
											),
											el.ego_id + '號會員 - ' + el.cnt + '人'
										)
									)
									),

									React.createElement("div", { style: { animationDelay: 0.4 + i * 0.2 + 's' }, className: "leader-bar" },
										React.createElement("div", {
										style: {
										  // backgroundColor: colors[i],
										  backgroundColor: colors[el.rank],
										  width: el.cnt / this.state.maxScore * 100 + '%' },

										className: "bar" }
										)
									)
								)
							  ) 
							: React.createElement("div", { className: "empty" }, "\u041F\u0443\u0441\u0442\u043E")
						
						)
					,
					// React.createElement("div", { className: "" }, '備註：月底抽獎的中獎機會依平均每日接觸人數計算權重')
					)
				);
			}
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
		  /*margin-bottom: 60px;*/
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
		th{
			font-weight:400
		}
		.table>tbody>tr>td{
			vertical-align:middle;
			padding-left:0;
			padding-right:0
		
		}
		.table{
			width:100%
		}
		.btn {
		  border: 2px solid black;
		  background-color: white;
		  color: black;
		  cursor: pointer;
		}
		.btn-lg{
			font-size:1.2em;
			margin: 1em;
		}
		.container{
			padding-left:1px;
			padding-right:1px;
		}
		
		.card-body {
			padding: 1rem 1rem 0 1rem;
		}

		.text-justify{
			letter-spacing: 0.2em;
			font-size:1.2em;
			padding-left:1em;			
			line-height:2em;
		}

		/* btn-outling */
		/* Green */
		.success {
		  border-color: #4CAF50;
		  color: green;
		}

		.success:hover {
		  background-color: #4CAF50;
		  color: white;
		}

		/* Blue */
		.info {
		  border-color: #2196F3;
		  color: dodgerblue
		}

		.info:hover {
		  background: #2196F3;
		  color: white;
		}

		/* Orange */
		.warning {
		  border-color: #ff9800;
		  color: orange;
		}

		.warning:hover {
		  background: #ff9800;
		  color: white;
		}

		/* Red */
		.danger {
		  border-color: #f44336;
		  color: red
		}

		.danger:hover {
		  background: #f44336;
		  color: white;
		}

		/* Gray */
		.default {
		  border-color: #e7e7e7;
		  color: black;
		}

		.default:hover {
		  background: #e7e7e7;
		}
		/* ---------------------------------------------------- */
		/* Adjust For mobile */
		@media screen and (max-width: 550px) {
			body{
				padding: 70px 0.5em 0 0.5em;
			}
			.text-justify{
				padding-left:0.5em;
			}
			.news{
				font-size:1.3em;
			}
			.card-body{
				padding-left:0.5em;
				padding-right:0.5em;
			}

			.card-footer {
				padding: 0.25rem !important;
			}

			.btn.btn-lg {
				width: 9.5rem;
				height: 9rem;
				margin: 0.5rem;
			}

		}

		/* 排行榜 */
		@media screen and (min-width: 1280px) {
			.container{
				display: flex;
			}

			.card {
				width: 95%;
				margin: 1rem;
			}
			/*.card.card-warning,.card-primary{
				width: 45%;
				margin: 1em;
			}*/
		}
		.card-footer {
		    /*padding: 10px 15px;*/
		    padding: 0 1rem;
		    background-color: transparent;
		    border: none;
		    /*border-top: 0 solid #fff;*/
		    /*border-bottom-right-radius: 3px;*/
		    /*border-bottom-left-radius: 3px;*/
		}
		.Leaderboard{
		    padding: 0em 1em;
		    margin: auto;
		    max-width: 800px;
		}
				
		.leaders{
			display: flex;
			flex-direction: column;
			flex-wrap: wrap;
		    max-height: 30em;
		}

		.leader-wrap {
		    display: flex;
		}

		.leader{
		    padding: 0.5em;
		    margin-bottom: 0.25em;
		    animation-name: revealLeaders;
		    animation-duration: .4s;
		    animation-fill-mode: both;
		    animation-timing-function: ease-in-out;
		}

		.leader-ava {
		    padding: 8px;
		    margin-right: 16px;
		    position: relative;
		}

		.leader-content{
			align-self: center;
		}

		.leader-score {
		    display: flex;
		    align-items: center;
		    opacity: 0.6;
		}

		.leader-score svg{
		    display: block;
		    margin-right: 4px;
		}

		.leader-score_title{
		    line-height: 1;
		}

		.leader-ava::after{
		    content: "";
		    left: 0;
		    bottom: 0;
		    display: block;
		    height: 6px;
		    position: absolute;
		    border: 0px transparent solid;
		    border-left-width: 20px;
		    border-right-width: 20px;
		    border-bottom-width: 6px;
		    border-bottom-color: #fff;
		    transition: border-bottom-color .2s ease-in-out;
		}

		.leader-bar {
		    margin-top: 8px;
		    animation-name: barLoad;
		    animation-duration: .4s;
		    animation-fill-mode: both;
		    animation-timing-function: cubic-bezier(0.6, 0.2, 0.1, 1);
		    transform-origin: left;
		}

		.bar {
		    height: 4px;
		    border-radius: 2px;
		}

		.numberCircle {
		    border-radius: 50%;
		    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
		    font: 1em;
		    width: 1.5em;
		    height: 1.5em;
		    padding: 0.025em;
		    margin-right: 0.5em;
		    border: 1px solid white;
		    color: white;
		    text-align: center;
		    display: inline-block;

		}

		@keyframes revealLeaders{
		    from{
		        transform: translateX(-200px);
		        opacity: 0;
		    }
		    to{
		        transform: none;
		        opacity: 1;
		    }
		}

		@keyframes barLoad{
		    from{
		        transform: scaleX(0);
		    }
		    to{
		        transform: scaleX(1)
		    }
		}
	</style>
	
</head>
<body>
	<?php include_once("header.php");?>
	<div class="container">
		<div class="card border-primary">
			<div class="card-header text-white bg-primary">我的會員編號:</div>
			<div class="card-body">
			以下是我最近的填答狀況
		  	<table id="tbl_diary_summary" class="table table-sm"></table>
		  </div>
		  <div class="card-footer">
		  	<div class="text-center" >
			  	<button type="button" class="btn info btn-lg" onclick="location.href = 'hdiary.php'">
			  		<img src="./pic/healthdiary_64.png"><br>填寫生活日記
				</button>
				<button type="button" class="btn info btn-lg" onclick="location.href = 'main_tdiary.php'">
					<img src="./pic/network_64.png"><br>填寫接觸日記
				</button>
			</div>
		  </div>
		</div>
		<!--
		<div class="card card-warning">
		  <div class="card-heading">接觸日記的接觸人數排行榜</div>
		  <div class="card-body">	
		  	<div id="app"></div>
		  </div>
		  <div class="card-footer">備註：月底抽獎的中獎機會依平均每日接觸人數計算權重</div>
		</div>
		-->
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
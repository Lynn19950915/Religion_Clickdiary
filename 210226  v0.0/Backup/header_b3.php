<?php
	
?>
<header>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  	<a class="navbar-brand" href="http://cdiary3.tw/main.php">
					<img src="/pic/logo.png" style="height: 1.5em;margin-right: 0.25em;display: inline-flex; padding-bottom: 0.25em">
					<span>點日記3.0</span>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li><a href="http://cdiary3.tw/about_us.php">關於日記 </a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">我的日記 
				  	<span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu" role="menu">
				  	<li><a href="http://cdiary3.tw/main.php">檢視日記填答概況</a></li>
					<li><a href="http://cdiary3.tw/hdiary.php">填寫生活日記</a></li>
					<li><a href="http://cdiary3.tw/main_tdiary.php">填寫接觸日記</a></li>
					<li><a href="http://cdiary3.tw/alter_list.php">管理接觸對象</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">帳號管理 
				  	<span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu" role="menu">
				  	<li><a class="dropdown-item" href="http://cdiary3.tw/edit_profile.php">編輯個人資料</a></li>
				    <!-- <li><a class="dropdown-item" href="http://cdiary3.tw/edit_group_list.php">編輯我的群組</a></li> -->
				    <li><a class="dropdown-item" href="http://cdiary3.tw/pw_edit.php">變更帳號密碼</a></li>
				  </ul>
				</li>
				<li><a href="http://cdiary3.tw/reward.php">獎勵公告 </a></li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="mailto:***@stat.sinica.edu.tw" target="_top">聯絡我們</a></li>
				<li><a href="http://cdiary3.tw/logout.php">登出</a></li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
<script type="text/javascript">
	$(document).ready(function() {
		// $(function() {
		//   $(document).click(function (event) {
		//     $('.navbar-collapse').collapse('hide');
		//   });
		// });
	})
</script>
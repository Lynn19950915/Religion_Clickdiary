<?php

?>

<header>
<!-- <nav class="navbar navbar-light" > -->
  <!-- Navbar content -->
<!-- </nav> -->
	<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light" style="/*background-color: #FFE699;*/">
		<a class="navbar-brand" href="http://cdiary3.tw/main.php">
			<img src="/pic/logo.png" style="height: 2em;margin-right: 0.25em;">
			<span>點日記3.0</span>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
			  <li class="nav-item"><a class="nav-link" href="http://cdiary3.tw/about_us.php">關於日記</span></a></li>
			  <li class="nav-item dropdown">
			    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">我的日記</a>
			    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
			      <a class="dropdown-item" href="http://cdiary3.tw/main.php">檢視日記填答概況</a>
			      <a class="dropdown-item" href="http://cdiary3.tw/hdiary.php">填寫生活日記</a>
			      <a class="dropdown-item" href="http://cdiary3.tw/main_tdiary.php">填寫接觸日記</a>
			      <a class="dropdown-item" href="http://cdiary3.tw/alter_list.php">管理接觸對象</a>
			    </div>
			  </li>
			  <li class="nav-item dropdown">
			    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink_2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">帳號管理</a>
			    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink_2">
			      <a class="dropdown-item" href="http://cdiary3.tw/edit_profile.php">編輯個人資料</a>
			      <!-- <a class="dropdown-item" href="http://cdiary3.tw/edit_group_list.php">編輯我的群組</a> -->
			      <a class="dropdown-item" href="http://cdiary3.tw/pw_edit.php">變更帳號密碼</a>
			    </div>
			  </li>
			  <li class="nav-item"><a class="nav-link" href="http://cdiary3.tw/reward.php">獎勵公告</a></li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item mr-3"><a href="mailto:***@stat.sinica.edu.tw" target="_top">聯絡我們</a></li>
				<li class="nav-item"><a href="http://cdiary3.tw/logout.php">登出</a></li>
			</ul>
		</div>

	</nav>
</header>
<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
		  $(document).click(function (event) {
		    $('.navbar-collapse').collapse('hide');
		  });
		});

	})
</script>
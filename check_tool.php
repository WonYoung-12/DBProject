<? if (!isset($_SESSION)) { session_start(); }
include("func.php");
ensure_logged_in();
?>
<html>
	<head>
		<meta charset=utf-8 />
		<link href="style.css"  type="text/css" rel="stylesheet" />
	</head>
	<body>
	
	<div class=content>
		<h1> 도구 조회 </h1>
		<?
			if (isset($_SESSION['flash'])){
		?>
			<div id=flash><?= $_SESSION['flash']?> </div>
		<?
			unset($_SESSION['flash']);
			}	
		?>
		<form method=post action=show_tool.php>
			도구명 : <input type=text name=name><br><br>
			
			<input type=submit value="조회">
			<input type=reset value="초기화">
			<a href=mypage.html><input type=button value="처음화면으로"></a>
	</form>
	</div>

	</body>
</html>
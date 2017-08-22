<? if (!isset($_SESSION)) { session_start(); }
include("func.php");
ensure_logged_in();
?>
<html>
	<head>
		<meta charset=utf-8/>
		<link href="style.css"  type="text/css" rel="stylesheet" />
	</head>
	<body>
	
	<div class=content>
		<h1> 진료차트 작성 </h1>
		<form method=post action=insert_chart.php>

			의사 번호 : <input type=text name=d_num><br>
			환자 번호 : <input type=text name=p_num><br>
			진료 날짜 : <input type=date name=date><br>
			진료 비용 : <input type=text name=money><br>
			진단 병명 : <input type=text name=disease><br><br>
			
			<input type=submit value="작성">
			<input type=reset value="초기화">
			<a href=mypage.html><input type=button value="처음화면으로"></a>
	</form>
	</div>
	</body>
</html>
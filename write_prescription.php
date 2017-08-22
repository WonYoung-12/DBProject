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
		<h1> 처방전 작성 </h1>
		
		<form method=post action=insert_prescription.php>
			<input type=hidden name=id value=<?=$_SESSION['id']?>>
			<input type=hidden name=name value=<?=$_SESSION['name']?>>

			진료 번호 : <input type=text name=c_num><br>
			처방 약품 : <input type=text name=medicine1><br>
			투여 수량 : <input type=text name=quantity1><br>

			처방 약품 : <input type=text name=medicine2><br>
			투여 수량 : <input type=text name=quantity2><br>
			
			처방 약품 : <input type=text name=medicine3><br>
			투여 수량 : <input type=text name=quantity3><br>
			
			처방 약품 : <input type=text name=medicine4><br>
			투여 수량 : <input type=text name=quantity4><br>
			
			처방 약품 : <input type=text name=medicine5><br>
			투여 수량 : <input type=text name=quantity5><br>

			발행 날짜 : <input type=date name=date><br>
			약국 번호 : <input type=text name=con><br>
			
			<input type=submit value="작성">
			<input type=reset value="초기화">
			<a href=mypage.html><input type=button value="처음화면으로"></a>
	</form>
	</div>
	</body>
</html>
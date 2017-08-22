<? 	if (!isset($_SESSION)) { session_start(); }
	include("func.php");
	$id=$_POST['id'];
	$name=$_POST['name'];
	if(is_passwd_correct($id, $name))
	{
		$_SESSION['id']=$id;
		$_SESSION['name']=$name;
		$_SESSION['flash']="$name 님이 접속하였습니다.";
		header("Location: mypage.html");
	}
	else
	{
		$_SESSION['flash']="로그인에 실패하였습니다. 다시 입력하세요.";
 	    header("Location: login.html");
	}
?>	
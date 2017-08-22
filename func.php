<?
function is_passwd_correct($id, $name){
   $mydb=mysql_connect("210.217.57.64","root","apmsetup");
   mysql_select_db("db_project",$mydb);
   mysql_query("set names utf8");
   $query="select * from 의사 where 의사번호='$id' and 의사이름='$name'";
   $result=mysql_query($query);
   if(mysql_num_rows($result)){
       $row=mysql_fetch_row($result);
      if($name!=NULL){
         $_SESSION['doctor_id']=$id;
         $_SESSION['doctor']=$name."님이 접속하셨습니다.";
         return true;
      }
        
    }
    else{
        return false;
    }
}

function ensure_logged_in(){
   if(!isset($_SESSION['id'])){
      $_SESSION['flash']="로그인 후 이용하세요.";
      header("location:login.html");
   }
}

function is_exist_patient($number, $name){
   $mydb=mysql_connect("210.217.57.64","root","apmsetup");
   mysql_select_db("db_project",$mydb);
   mysql_query("set names utf8");
   $query="select * from 진료, 환자, 의사  where 환자.환자번호=진료.환자번호 and 환자.환자번호='$number' and 의사.의사번호=진료.의사번호 and 환자.이름='$name'";
   $result=mysql_query($query);

   if(mysql_num_rows($result)){?>

      <h1> <?=$name?> 에 대한 진료 내역 </h1>

      <div id = "table">
      <table border="1" cellspacing="0" align="center">
         <tr>
            <td width="100" align="center">진료 번호</td>
            <td width="100" align="center">담당 의사</td>
            <td width="100" align="center">환자 번호</td>
            <td width="100" align="center">환자 이름</td>
			   <td width="100" align="center">진료날짜</td>
            <td width="300" align="center">병명</td>
            <td width="300" align="center">사용 약품</td>
              
         </tr>
         <?for($i=0;$i<mysql_num_rows($result);$i++){
            $rows=mysql_fetch_array($result);

            // 사용 약품을 출력하기 위한 코드
            $num=$rows['진료번호'];
            $query1 = "select 약품번호 from 진료약품 where 진료번호='$num'";
            $result1=mysql_query($query1);
            for($j=0;$j<mysql_num_rows($result1);$j++){
               $rows2=mysql_fetch_array($result1);

               // 진료약품들은 연결해주는 코드
               if($j < mysql_num_rows($result1)-1)
                  $medicine.=$rows2['약품번호'].",";
               else 
                  $medicine.=$rows2['약품번호'];
            }
            ?>

            <tr>
               <td width="100" align="center"><?=$rows['진료번호']?></td>
               <td width="100" align="center"><?=$rows['의사이름']?></td>
               <td width="100" align="center"><?=$rows['환자번호']?></td>
               <td width="100" align="center"><?=$rows['이름']?></td>
			      <td width="100" align="center"><?=$rows['진료날짜']?></td>
               <td width="300" align="center"><?=$rows['병명']?></td>
               <td width="300" align="center"><?=$medicine?></td>
            </tr>
            <?
         }?>
         
         </table>
		 <br>
      <a href=check_patient.html><input type=button value="이전 페이지"></a></div><?

      return true;
   }
   else 
      return false;
}

function write_chart($POST){
   $t_num=rand();
   //$d_num=$POST['d_num'];
   $d_num=$_SESSION['doctor_id'];
   //echo $d_num;
   $p_num=$POST['p_num'];
   $date=$POST['date'];
   $money=$POST['money'];
   $medicine1=trim($POST['medicine1']);
   //echo $medicine1;
   $medicine2=trim($POST['medicine2']);
   //echo $medicine2;
   $medicine3=trim($POST['medicine3']);
   //echo $medicine3;
   $disease=$POST['disease'];
   
   $mydb=mysql_connect("210.217.57.64","root","apmsetup");
   mysql_select_db("db_project",$mydb);
   
   $query = "insert into 진료(진료번호, 의사번호, 환자번호, 진료날짜, 진료비, 병명) values('$t_num', '$d_num', '$p_num', '$date', '$money', '$disease')";
   mysql_query("set names utf8");
   $result = mysql_query($query);

   $query1 ="insert into 진료약품 values('$t_num','$medicine1')";
   $result1=mysql_query($query1);
   
   $query2 ="insert into 진료약품 values('$t_num','$medicine2')";
   $result2=mysql_query($query2);

   $query3 ="insert into 진료약품 values('$t_num','$medicine3')";
   $result3=mysql_query($query3);

   if($result||$result2||$result3||$result4){ ?>
			차트가 성공적으로 저장되었습니다.<br><br><br>
					<a href=write_chart.html><input type=button value="추가 작성"></a>
					<a href=mypage.html><input type=button value="처음화면으로"></a>
   <?
    return true;
   }
     
   else 
      return false;
}

function write_prescription($POST){
   $p_num=$POST['p_num'];
   $c_num=$POST['c_num'];
   $medicine1=trim($POST['medicine1']);
   $medicine2=trim($POST['medicine2']);
   $medicine3=trim($POST['medicine3']);
   $medicine4=trim($POST['medicine4']);
   $medicine5=trim($POST['medicine5']);

   $quantity1=$POST['quantity1'];
   $quantity2=$POST['quantity2'];
   $quantity3=$POST['quantity3'];
   $quantity4=$POST['quantity4'];
   $quantity5=$POST['quantity5'];

   $date=$POST['date'];
   $con=$POST['con'];

   $mydb=mysql_connect("210.217.57.64","root","apmsetup");
   mysql_select_db("db_project",$mydb);
   mysql_query("set names utf8");

   $query = "select * from 진료 where 진료번호='$c_num'";
   $result = mysql_query($query);
   if(mysql_num_rows($result) == 0){
      $_SESSION['flash']="해당하는 진료가 없습니다.";
      return false;
   }

   $query1 = "insert into 처방전 values('$p_num', '$c_num', '$date', '$con')";
   $result1 = mysql_query($query1);

   if($medicine1 != null){
      $query2 = "insert into 처방전의약품 values('$p_num', '$medicine1', '$quantity1')";
      $result2 = mysql_query($query2);
   }

   if($medicine2 != null){
      $query3 = "insert into 처방전의약품 values('$p_num', '$medicine2', '$quantity2')";
      $result3 = mysql_query($query3);
   }

   if($medicine3 != null){
      $query4 = "insert into 처방전의약품 values('$p_num', '$medicine3', '$quantity3')";
      $result4 = mysql_query($query4);
   }

   if($medicine4 != null){
      $query5 = "insert into 처방전의약품 values('$p_num', '$medicine4', '$quantity4')";
      $result5 = mysql_query($query5);
   }

   if($medicine5 != null){
     $query6 = "insert into 처방전의약품 values('$p_num', '$medicine5', '$quantity5')";
      $result6 = mysql_query($query6);
   }

   if($result1||$result2||$result3||$result4||$result5||$result6){?>
		<body> 처방전이 성공적으로 약국에 전송되었습니다.<br><br><br>
		<a href=write_prescription.html><input type=button value="추가 작성"></a>
		<a href=mypage.html><input type=button value="처음화면으로"></a>
	   <?
	    return true;
   }
     
   else{
      
      return false;
   }
}

function show_medicine($POST){
   $name=$POST['name'];
   $mydb=mysql_connect("210.217.57.64","root","apmsetup");
   mysql_select_db("db_project",$mydb);
   mysql_query("set names utf8");

   $query = "select * from 약품 where 약품명='$name'";
   $result = mysql_query($query);

   if(mysql_num_rows($result)){?>

      <h1> <?=$name?> 에 대한 정보 </h1>

      <div id = "table">
      <table border="1" cellspacing="0">
         <tr>
            <td width="100">약품번호</td>
            <td width="100">약품명</td>
			<td width="70">재고량</td>
            <td width="110">유효기간</td>
            <td width="80">공급가</td>
            <td width="100">제조업체</td>
            <td width="100">담당간호사</td>   
         </tr>
         <?for($i=0;$i<mysql_num_rows($result);$i++){

            $rows=mysql_fetch_array($result);

            // 간호사 이름 출력을 위한 코드
            $query1 = "select * from 간호사 where 간호사번호='".$rows['담당간호사번호']."'";
            $result1 = mysql_query($query1);
            $rows1 = mysql_fetch_array($result1);
            $n_name = $rows1['간호사이름'];

            ?>
            <tr>
               <td width="100"><?=$rows['약품번호']?></td>
               <td width="100"><?=$rows['약품명']?></td>
			   <td width="70" ><?=$rows['재고량']?></td>
               <td width="100"><?=$rows['유효기간']?></td>
               <td width="70"><?=$rows['공급가']?></td>
               <td width="100"><?=$rows['제조업체']?></td>
               <td width="100"><?=$n_name;?></td>
            </tr>
            <?
         }?>
         
         </table>
		 <br>
      <a href=check_medicine.html><input type=button value="이전 페이지"></a></div><?

      return true;
   }
   else 
      return false;
}

function show_tool($POST){
   $name=$POST['name'];
   $mydb=mysql_connect("210.217.57.64","root","apmsetup");
   mysql_select_db("db_project",$mydb);
   mysql_query("set names utf8");

   $query = "select * from 검사도구 where 도구이름='$name'";
   $result = mysql_query($query);

   if(mysql_num_rows($result)){?>

      <h1> <?=$name?> 에 대한 정보 </h1>

      <div id = "table" style="padding-left:40px">
      <table border="1" cellspacing="0">
         <tr>
            <td width="100">도구번호</td>
            <td width="100">도구이름</td>
			<td width="70">재고량</td>
            <td width="100">공급가</td>
            <td width="70">제조업체</td>
            <td width="100">담당간호사</td>   
         </tr>
         <?for($i=0;$i<mysql_num_rows($result);$i++){

            $rows=mysql_fetch_array($result);

            // 간호사 이름 출력을 위한 코드
             $query1 = "select * from 간호사 where 간호사번호='".$rows['담당간호사번호']."'";
            $result1 = mysql_query($query1);
            $rows1 = mysql_fetch_array($result1);
            $n_name = $rows1['간호사이름'];

            ?>
            <tr>
               <td width="100"><?=$rows['도구번호']?></td>
               <td width="100"><?=$rows['도구이름']?></td>
			   <td width="70"><?=$rows['재고량']?></td>
               <td width="100"><?=$rows['공급가']?></td>
               <td width="70"><?=$rows['제조업체']?></td>
               <td width="100"><?=$n_name;?></td>
            </tr>
            <?
         }?>
         
         </table>
		 <br>
		<a href=check_tool.html><input type=button value="이전 페이지"></a></div><?

      return true;
   }
   else 
      return false;
}
?>
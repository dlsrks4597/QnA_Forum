<!--
    $num = $_GET["num"];
    $page = $_GET["page"];

    $subject = $_POST["subject"];
    $content = $_POST["content"];

    $con = mysqli_connect("localhost", "user1", "12345", "1505007");
    mysqli_set_charset($con, "UTF8");
    $sql = "update board set subject='$subject', content='$content' ";
    $sql .= " where num=$num";

    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
	      <script>
	          location.href = 'board_list.php?page=$page';
	      </script>
	  "; -->
<?php
session_start();
if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
else $userid = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else $username = "";

if ( !$userid )
{
    echo("
                <script>
                alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
                history.go(-1)
                </script>
    ");
            exit;
}

$subject = $_POST["subject"];
$content = $_POST["content"];

$subject = htmlspecialchars($subject, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES); // '' 혹은 "" 를 정상적으로 저장하기 위해 사용

//html 코드 그대로 불러오기 위한 정규식
$char37 = chr(37);
$char34 = chr(34);

$content = str_replace("&lt;", "<", $content);
$content = str_replace("&gt;", ">", $content);
$content = str_replace("&amp;", "&", $content);
$content = str_replace("&#37", $char37, $content);
$content = str_replace("&quot;", $char34, $content);
$content = str_replace("&#39;", "&", $content);
$content = str_replace("&#35", "#", $content);
//$content = str_replace("<ol>", '<ol start="1">', $content);
//$content = str_replace("<br>", "\n", $content);
//$content = str_replace(" ", "&nbsp;", $content);
//  mysql_escape_string($content);
//$content2 = addslashes($content);

// $content2 = str_replace('&lt;' , '<', $content);
// $content2 = str_replace('&gt;' , '>', $content);

// str_replace('&lt;' , '<', $content, $content2);
// str_replace('&gt;' , '>', $content, $content2);
// str_replace('&amp;' , '&', $content, $content2);
// str_replace('&#37' , 'chr("37")' + "", $content, $content2);
// str_replace('&quot;' , 'chr("34")' + "", $content, $content2);
// str_replace('&#39;' , 'chr("39")' + "", $content, $content2);
// str_replace('&#35' , '#', $content, $content2);
// str_replace('<br>' , '\n', $content, $content2);
// str_replace(' ' , '&nbsp;', $content, $content2);

// sText = sText.replace("&lt;", "<");
//                 sText = sText.replace("&gt;", ">");
//                 sText = sText.replace("&amp;", "&");
//                 sText = sText.replace("&#37;", (char)37 + "");
//                 sText = sText.replace("&quot;", (char)34 + "");
//                 sText = sText.replace("&#39;", (char)39 + "");
//                 sText = sText.replace("&#35;", "#");
//                 sText = sText.replace("<br>", "\n");
//                 sText = sText.replace(" ", "&nbsp;");

$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

$upload_dir = './data/';

// $upfile_name	 = $_FILES["upfile"]["name"];
// $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
// $upfile_type     = $_FILES["upfile"]["type"];
// $upfile_size     = $_FILES["upfile"]["size"];
// $upfile_error    = $_FILES["upfile"]["error"];

// if ($upfile_name && !$upfile_error)
// {
// $file = explode(".", $upfile_name); // . 단위로 뜯어냄
// $file_name = $file[0];
// $file_ext  = $file[1];
//
// $new_file_name = date("Y_m_d_H_i_s");
// $new_file_name = $file_name.$new_file_name;
// //파일을 올렸을 때 중복이 되면 데이터에 저장이 안될 수 있으므로 뒤에 업로드날짜정보를 붙여서 저장한다.
// $copied_file_name = $new_file_name.".".$file_ext;
// $uploaded_file = $upload_dir.$copied_file_name;

// if( $upfile_size  > 1000000 ) { //용량제한
//     echo("
//     <script>
//     alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
//     history.go(-1)
//     </script>
//     ");
//     exit;
// }
//
// if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) ) //문제가 발생했을 시
// {
//     echo("
//       <script>
//       alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
//       history.go(-1)
//       </script>
//     ");
//     exit;
// }
//
// else //문제가 없으면 DB에 데이터 저장
// {
// $upfile_name      = "";
// $upfile_type      = "";
// $copied_file_name = "";
// }




    //데이터 베이스 연결하기

    $num = $_GET["num"];
    $page = $_GET["page"];


    $con = mysqli_connect("localhost", "user1", "12345", "1505007");
    mysqli_set_charset($con, 'utf8');
  	$sql = "select * from board where num=$num";
  	$result = mysqli_query($con, $sql);
    //$result = mysqli_multi_query($con, $sql);

  	$row = mysqli_fetch_array($result);
    $thread      = $row["thread"];
    $num      = $row["num"];
  	$id      = $row["id"];
  	$name      = $row["name"];
  	$regist_day = $row["regist_day"];
  	$subject    = $row["subject"];
  	$content    = $row["content"];
  	$file_name    = $row["file_name"];
  	$file_type    = $row["file_type"];
  	$file_copied  = $row["file_copied"];
  	$hit          = $row["hit"];


    // $userid = $_POST["userid"];
    // $name = $_POST["name"];
    // $subject = $_POST["subject"];
    // $content = $_POST["content"];

    // $con = mysqli_connect("localhost", "user1", "12345", "1505007");
    // mysqli_set_charset($con, "UTF8");
    // $parent_thread = $_POST["thread"];
    $parent_depth = $_POST["depth"];
    $prev_parent_thread = ceil($_POST['thread']/1000)*1000 - 1000;//ceil는 올림함수인것을 잊지말자.

    //원본글보다는 작고 위값보다는 큰 글들의 thread 값을 모두 1씩 낮춘다.
    //만약 부모글이 2000이면 prev_parent_thread는 1000이므로 2000> x >1000 인 x값을 모두 -1을 한다.
    //만약 부모글이 1950이면 prev_parent_thread는 1000이므로 1950> x >1000 인 x값을 모두 -1을 한다.
    $query = "UPDATE board SET thread=thread-1 WHERE
    thread >$prev_parent_thread and thread <$_POST[thread]";
    $update_thread = mysqli_query($con, $query);

    //원본글보다는 1작은 값으로 답글을 등록한다.
    //원본글의 바로 밑에 등록되게 된다.
    //depth는 원본글의 depth + 1 이다. 원본글이 3(이글도 답글이군)이면 답글은 4가된다.
    $parent_title_space = "&nbsp";
    for ($i = 0; $i <= $parent_depth; $i++) {
      $parent_title_space = $parent_title_space.$parent_title_space;
    }
    $parent_title_space = $parent_title_space."└>".$_POST['subject'];


    $query = "INSERT INTO board (thread,depth,id, name, subject";
    $query .= ",content,hit,ip)";
    $query .= " VALUES ('" . ($thread-1) . "'";
    $query .= ",'" . ($parent_depth+1) ."','$userid','$username','$parent_title_space'";
    $query .= ",'$_POST[content]',0, '$_SERVER[REMOTE_ADDR]'";
    $query .= ")";
    $result2=mysqli_query($con, $query);


    // 새 글 쓰기인 경우 리스트로..
    echo ("<meta http-equiv='Refresh' content='3; URL=board_list.php'>");

    $point_up = 100;

  $sql = "select point from members where id='$userid'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  $new_point = $row["point"] + $point_up;

  $sql = "update members set point=$new_point where id='$userid'";
  mysqli_query($con, $sql);

    // $sql = "insert into board (thread, depth, id, name, subject, content,  hit,  ip, file_name, file_type, file_copied) ";
  	// $sql .= "values($max_thread, 0, '$userid', '$username', '$subject', '$content',  0, '$_SERVER[REMOTE_ADDR]', ";
  	// $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";

    //데이터베이스와의 연결 종료
    mysqli_close($con);

    // 새 글 쓰기인 경우 리스트로..
    echo ("<meta http-equiv='Refresh' content='3; URL=board_list.php'>");
?>

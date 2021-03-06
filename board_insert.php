<meta charset="utf-8">
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
  $char37 = chr(37); // %
  $char34 = chr(34); // "

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

	$upfile_name	 = $_FILES["upfile"]["name"];
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
	$upfile_type     = $_FILES["upfile"]["type"];
	$upfile_size     = $_FILES["upfile"]["size"];
	$upfile_error    = $_FILES["upfile"]["error"];

	if ($upfile_name && !$upfile_error)
	{
		$file = explode(".", $upfile_name); // . 단위로 뜯어냄
		$file_name = $file[0];
		$file_ext  = $file[1];

		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $file_name.$new_file_name;
    //파일을 올렸을 때 중복이 되면 데이터에 저장이 안될 수 있으므로 뒤에 업로드날짜정보를 붙여서 저장한다.
		$copied_file_name = $new_file_name.".".$file_ext;
		$uploaded_file = $upload_dir.$copied_file_name;

		if( $upfile_size  > 1000000 ) { //용량제한
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
		}

		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) ) //문제가 발생했을 시
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
		}
	}
	else //문제가 없으면 DB에 데이터 저장
	{
		$upfile_name      = "";
		$upfile_type      = "";
		$copied_file_name = "";
	}

	$con = mysqli_connect("localhost", "user1", "12345", "1505007");
  $board="board"; //테이블명
  $query = "SELECT max(thread) FROM $board";
  $max_thread_result = mysqli_query($con, $query);
  $max_thread_fetch = mysqli_fetch_row($max_thread_result);

  //만약에 2000번의 글이 삭제되고 1999번만 있다면?
//그럴 경우 1999/1000을 한다음에 올림을 한뒤 1000을 곱하면 2000이 된다.
//그리고 그값에 1000을 더하면 3000이 되서 새로 입력한 글의 Thread는 3000이 된다.
$max_thread = ceil($max_thread_fetch[0]/1000)*1000+1000;
//$max_thread = 1;
//UNIX_TIMESTAMP는 유닉스 시간을 되돌려주는 MySQL 내장함수입니다.
//$_SERVER[REMOTE_ADDR]은 IP주소를 가져오는 PHP 변수
	$sql = "insert into board (thread, depth, id, name, subject, content,  hit,  ip, file_name, file_type, file_copied) ";
	$sql .= "values($max_thread, 0, '$userid', '$username', '$subject', '$content',  0, '$_SERVER[REMOTE_ADDR]', ";
	$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
  mysqli_set_charset($con, "UTF8"); // 한글깨짐 방지
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행




	// 포인트 부여하기
  	$point_up = 100;

	$sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] + $point_up;

	$sql = "update members set point=$new_point where id='$userid'";
	mysqli_query($con, $sql);

	mysqli_close($con);                // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'board_list.php';
	   </script>
	";
?>

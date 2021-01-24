<?php

//add_comment.php

$dbHost = "localhost";      // 호스트 주소(localhost, 120.0.0.1)
$dbName = "1505007";      // 데이타 베이스(DataBase) 이름
$dbUser = "user1";          // DB 아이디
$dbPass = "12345";        // DB 패스워드

$connect = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
$connect -> exec("set names utf8"); //PDO방식으로 DB를 불러올 때 한글 깨짐을 방지하는 명령어
$error = '';
$comment_name = '';
$comment_sender_id = '';
$comment_content = '';
$board_number = '';
if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger" style="color:red;">회원만 답글을 작성할 수 있습니다.</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger" style="color:red;">내용을 입력해주세요.</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}
  $board_number = $_POST["board_number"];
  $comment_sender_id = $_POST["comment_sender_id"];
if($error == '')
{
 $query = "
 INSERT INTO tbl_comment
 (parent_comment_id, comment, comment_sender_name, comment_sender_id, board_num)
 VALUES (:parent_comment_id, :comment, :comment_sender_name, :comment_sender_id, :board_num)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'    => $comment_content,
   ':comment_sender_name' => $comment_name,
   ':comment_sender_id' => $comment_sender_id,
   ':board_num' => $board_number
  )
 );
 $query = "
 UPDATE board SET comments = comments+1 WHERE num = '".$board_number."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute(); // 쿼리 실행
 //$result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장

 // 포인트 부여하기
   $point_up = 75;

 $query = "
 select point from members where id='$comment_sender_id'
 ";
 $statement = $connect->prepare($query);
 $statement->execute(); // 쿼리 실행
 $result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장

 $new_point = $result["point"] + $point_up;

 $query = "
 update members set point=$new_point where id='$comment_sender_id'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();

 $error = '<p><label class="text-success" style="color:green; font-weight:bold;">답글 작성을 완료하였습니다.</label></p>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>

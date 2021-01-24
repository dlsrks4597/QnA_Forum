<?php

//add_comment.php

$dbHost = "localhost";      // 호스트 주소(localhost, 120.0.0.1)
$dbName = "1505007";      // 데이타 베이스(DataBase) 이름
$dbUser = "user1";          // DB 아이디
$dbPass = "12345";        // DB 패스워드

$connect = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
$connect -> exec("set names utf8"); //PDO방식으로 DB를 불러올 때 한글 깨짐을 방지하는 명령어

//POST로 불러온 값들을 변수로 변경!
$userid = $_POST['userid'];
$board_number = $_POST['board_number'];
$comment_id = $_POST['comment_id'];
$error = '';
// $comment_name = '';
// $comment_sender_id = '';
// $comment_content = '';
// $board_number = '';
//
// $comment_content = $_POST["comment_content"];
//  $board_number = $_POST["board_number"];
//  $comment_sender_id = $_POST["comment_sender_id"];
//  $comment_id = $_POST["comment__id"];

// $query = "
// SELECT * FROM tbl_comment WHERE comment_sender_id = '".$comment_id."'
// ";
// $statement = $connect->prepare($query);
// $statement->execute(); // 쿼리 실행
// $result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장
// $id = $result;
//
// if(empty($userid))
// {
//   $error .= '<p class="text-danger" style="color:red;">답글을 삭제할 권한이 없습니다.</p>';
// }
// if ($userid != $id) {
//   $error .= '<p class="text-danger" style="color:red;">답글을 삭제할 권한이 없습니다.</p>';
// }
// else
// {
//  $comment_name = $_POST["comment_name"];
// }
$query = "
SELECT * FROM tbl_comment WHERE comment_id = '".$comment_id ."'
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$id = $result["comment_sender_id"];
//echo "alert('".$id."');";
if(empty($userid))
{
  // echo 'alert("답글을 삭제할 권한이 없습니다!");';
  $error .= '<p class="text-danger" style="color:red;">답글을 삭제할 권한이 없습니다.</p>';
}
if ($userid != $id) {
  // echo 'alert("답글을 삭제할 권한이 없습니다!");';
  $error .= '<p class="text-danger" style="color:red;">답글을 삭제할 권한이 없습니다.</p>';
}

if($error == '')
{
 $query = "
 DELETE FROM tbl_comment WHERE comment_id = '".$comment_id ."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();

 $query = "
 UPDATE board SET comments = comments-1 WHERE num = '".$board_number."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute(); // 쿼리 실행
 //$result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장

 $error = '<p><label class="text-success" style="color:green; font-weight:bold;">답글 삭제를 완료하였습니다.</label></p>';
}

$data = array(
 'error'  => $error
);
echo json_encode($error);
// return $error;

?>

<?php

//fetch_comment.php
    $dbHost = "localhost";      // 호스트 주소(localhost, 120.0.0.1)
    $dbName = "1505007";      // 데이타 베이스(DataBase) 이름
    $dbUser = "user1";          // DB 아이디
    $dbPass = "12345";        // DB 패스워드

$connect = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
$connect -> exec("set names utf8"); //PDO방식으로 DB를 불러올 때 한글 깨짐을 방지하는 명령어
$board_num  = $_POST["board_num"];
//$comment_sender_id = $row["comment_sender_id"];
//echo $board_num;

$query = "
SELECT * FROM tbl_comment
WHERE parent_comment_id = '0' and board_num = '".$board_num."'
ORDER BY comment_id DESC
";
$comment_width = 500;

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
$check = '';
foreach($result as $row)
{
  $comment_sender_id = $row["comment_sender_id"];
  $comment_sender_name = $row["comment_sender_name"];
  $date = $row["date"];
  $comment = $row["comment"];
  $comment_id = $row["comment_id"];

  $query = "
  SELECT * FROM members WHERE id = '".$comment_sender_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute(); // 쿼리 실행
  $result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장
  $profile_img_dir_uploader = $result["profile_img_dir"];
  $tier_dir_uploader = $result["tier_dir"];

 $output .= '

 <div class="height_auto" style="border-style: groove; overflow:hidden; height: auto;">
   <div class="panel panel-default" style="padding: 10px 20px 10px 20px">
    <div class="panel-heading" style="padding: 0 0 10px 0">
      <span style="margin: 0 20px 0 0">
        <img src="'.$profile_img_dir_uploader.'" style="width:90px; height:90px;" />
      </span>
      <span style="position:absolute;">
        By <b><img src="'.$tier_dir_uploader.'"/>'.$comment_sender_name.'</b> on <i>'.$date.'</i>
      </span>
      <span style="position:absolute; width:500px; margin:30px 0 0 0">'.$comment.'</span>
      <div class="panel-body" >

      </div>
    </div>

    <div class="panel-footer" align="right">
      <button type="button" class="btn btn-default reply" name="'.$comment_sender_name.'" id="'.$comment_id.'" style="width: 50px; height:33px;">답글</button>
      <button type="button" class="btn btn-default delete" id="'.$comment_id.'" style="width: 50px; height:33px;" id="comment_num" value="'.$comment_id.'">삭제</button>
    </div>
   </div>
 </div>
 ';
 $output .= get_reply_comment($connect, $row["comment_id"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0, $marginright = 0, $comment_width = 500)
{
 $query = "
 SELECT * FROM tbl_comment WHERE parent_comment_id = '".$parent_id."'
 ";
 $output = '';
 $check = '';
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
  $marginright = 0;
 }
 else
 {
  $marginleft = $marginleft + 30;
  $marginright = $marginright - 30;
  $comment_width = $comment_width - 30;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {
    $comment_sender_id = $row["comment_sender_id"];
    $comment_sender_name = $row["comment_sender_name"];
    $date = $row["date"];
    $comment = $row["comment"];
    $comment_id = $row["comment_id"];
    $parent_comment_id = $row["parent_comment_id"];

    $query = "
    SELECT * FROM members WHERE id = '".$comment_sender_id."'
    ";
    $statement = $connect->prepare($query);
    $statement->execute(); // 쿼리 실행
    $result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장
    $profile_img_dir_uploader = $result["profile_img_dir"];
    $tier_dir_uploader = $result["tier_dir"];

    // $board_num  = $_POST["board_num"];
    // $query = "
    // SELECT * FROM tbl_comment where board_num ='".$board_num."'
    // ";
    // $statement = $connect->prepare($query);
    // $statement->execute(); // 쿼리 실행
    // $result = $statement->fetch(PDO::FETCH_ASSOC); // 쿼리 결과 저장
    // $check_comment_id = $result["comment_id"];
    //  print_r(count($result));
    //
    // $query = "
    // SELECT * FROM tbl_comment where comment_id = '".$check_comment_id." and board_num ='".$board_num."'
    // ";
    // $statement = $connect->prepare($query);
    // $statement->execute(); // 쿼리 실행
    // $check_result = $statement->fetchAll(); // 쿼리 결과 저장
    // $check_count = $statement->rowCount();
    // $check_parent_comment_id = $result["parent_comment_id"];
    //
    // $check_parent_comment_id_count = strlen($check_parent_comment_id);
    //
    // $count = count($check_result);
    // for ($i = 0; $i < $count; $i++) {
    //   print_r("0 ");
    // }
    // //print_r($check_result);
    // $check = '';
    // // for ($i = 0; $i < count($check_result); $i++) {
    // //   $check .= $check_parent_comment_id[$i];
    // //   print_r("1 ");
    // // }




   $output .= '
   <div class="height_auto" style="border-style: groove; margin-left:'.$marginleft.'px; overflow:hidden; height: auto;">
     <div class="panel panel-default" style="padding: 15px 15px 15px 15px">
      <div class="panel-heading" style="padding: 0 0 10px 0">
        <span style="margin: 0 20px 0 0">
          <img src="'.$profile_img_dir_uploader.'" style="width:90px; height:90px; float:left; margin:0 0 15px 0" />
        </span>
        <span style="display: inline-block;width:'.$comment_width.'px;">
          By <b><img src="'.$tier_dir_uploader.'"/>'.$comment_sender_name.'</b> on <i>'.$date.'</i><br />
          <span style="  margin:30px 0 auto 0; padding: 0 '.$marginright.' 0 0">'.$comment.'</span>
        </span>

        <div class="panel-body" >

        </div>
      </div>

      <div class="panel-footer" align="right">
        <button type="button" class="btn btn-default reply" name="'.$comment_sender_name.'" id="'.$comment_id.'" style="width: 50px; height:33px;">답글</button>
        <button type="button" class="btn btn-default delete" id="'.$comment_id.'" style="width: 50px; height:33px;" id="comment_num" value="'.$comment_id.'">삭제</button>
      </div>
     </div>
   </div>
   ';

   // <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
   //  <div class="panel-heading">By <b>'.$comment_sender_name.'</b> on <i>'.$date.'</i></div>
   //
   //  <div class="panel-body">'.$comment.'</div>
   //  <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$comment_id.'">Reply</button></div>
   // </div>


   $output .= get_reply_comment($connect, $row["comment_id"], $marginleft, $marginright, $comment_width);
  }
 }
 return $output;
}



?>

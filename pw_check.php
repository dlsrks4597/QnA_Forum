<?php
 session_start();

//  $db = new mysqli("localhost", "user1", "12345", "1505007");
//  $db->set_charset("utf8");
//
//  function mq($sql){
// 	 global $db;
// 	 return $db->query($sql);
//  }
// $id = $_POST['userid'];
// 	if($_POST['userid'] != NULL){
// 	$id_check = mq("select * from members where id='$id'");
// 	$id_check = $id_check->fetch_array();

  $pw = $_POST['userpw'];
if($_POST['userpw'] != NULL){
	// if($id_check >= 1){
	// 	echo "존재하는 아이디입니다.";
	// } else {
	// 	echo "존재하지 않는 아이디입니다.";
	// }


	if (preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $pw)) {
			echo "<span style='color:red'>영문과 숫자만 가능합니다.</span>";
		} else if (mb_strlen($pw) < 4) {
			echo "<span style='color:red'>비밀번호는 4글자 이상 10글자 이내로 입력해주세요.</span>";
		} else if (mb_strlen($pw) > 11) {
			echo "<span style='color:red'>아이디는 4글자 이상 10글자 이내로 입력해주세요.</span>";
		} else {
		echo "<span style='color:green'><strong>사용할 수 있는 비밀번호입니다. V</strong></span>";
		}
  }
?>

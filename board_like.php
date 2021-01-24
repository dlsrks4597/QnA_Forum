<?php
  // echo( "board_view:". ($_POST["a"]+$_POST["b"]) );
  // header("Content-Type: application/json");

  //POST로 불러온 값들을 변수로 변경!
  $userid = $_POST['userid'];
  $board_num = $_POST['num'];
  if (!$userid) {
    // echo ("회원만 추천할 수 있습니다!");
    echo(1);
    return;
  }

  $con = mysqli_connect("localhost", "user1", "12345", "1505007"); //db연결
  mysqli_set_charset($con, 'utf8');

  $sql = "select * from members where id = '$userid'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $board_like_num = $row["board_like_num"];

  // $board_like_num_array = explode( '_', $board_like_num );
  // for ($i = 0; $i < count($board_like_num_array); $i++) {
  //   if ($board_like_num_array[$i] == $board_num) {
  //     $board_like_num = str_replace($board_num."_bn:",'',$board_like_num);
  //     $sql = "update members set board_like_num = '$board_like_num' where id='$userid'";
  //     mysqli_query($con, $sql);
  //     echo ("취소");
  //     return;
  //   }
  // }
  $board_num_judge = "(".$board_num.")";
  if (strpos($board_like_num,$board_num_judge) !== false) {
        $board_like_num = str_replace($board_num_judge,'',$board_like_num);
        $sql = "update members set board_like_num = '$board_like_num' where id='$userid'";
        mysqli_query($con, $sql); //추천 취소

        $sql = "select * from board where num = '$board_num'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $board_like = $row["board_like"]; //추천수 불러오기

        $board_like = $board_like-1;
        $sql = "update board set board_like = '$board_like' where num='$board_num'";
        mysqli_query($con, $sql); //추천수 1 감소


        //echo ($board_like);
         // echo ("이 게시글의 추천을 취소하였습니다!");
         echo(2);
        return;
  }

  $board_like_num .= "(".$board_num.")";

  $sql = "update members set board_like_num = '$board_like_num' where id='$userid'";
  mysqli_query($con, $sql); //추천 성공

  $sql = "select * from board where num = '$board_num'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  $board_like = $row["board_like"]; //추천수 불러오기

  $board_like = $board_like+1;
  $sql = "update board set board_like = '$board_like' where num='$board_num'";
  mysqli_query($con, $sql); //추천수 1 증가
  //$list=array("board_like"=>$board_like);
  //echo json_encode($list);
  echo(3);
  // echo ("이 게시글을 추천하였습니다!");
  //echo ($board_like);
  //echo ($board_like_num);
  // if(!$username) {
  //   echo( "추천 불가능");
	// 		//throw new exception('param1 값이 없습니다.');
	// 	} else {
  //     echo( "추천 불가능");
  //   }
    // $list[] = array("board_like"=>$board_like, "subject"=>$row[subject], "comment"=>$row[comment]);


  return;
?>

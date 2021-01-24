<?php
    session_start();
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if ( $userlevel != -1 )
    {
        echo("
            <script>
            alert('관리자가 아닙니다! 회원정보 수정은 관리자만 가능합니다!');
            history.go(-1)
            </script>
        ");
        exit;
    }

    $num   = $_GET["num"];
    //$level = $_POST["level"];
    $point = $_POST["point"];

    $con = mysqli_connect("localhost", "user1", "12345", "1505007");
    $sql = "update members set point=$point where num=$num";
    mysqli_query($con, $sql);



    //레벨업 조건(포인트)
    $levelup_to_1 = 1000;
    $levelup_to_2 = 3000;
    $levelup_to_3 = 6000;
    $levelup_to_4 = 10000;
    $levelup_to_5 = 15000;
    $levelup_to_6 = 20000;
    $levelup_to_7 = 30000;
    $levelup_to_8 = 50000;
    $levelup_to_9 = 100000;
    $level = 0;

    //포인트에 따른 레벨 변화
    if ($point < $levelup_to_1 && $level != -1){
      $level = 0;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_1 && $point < $levelup_to_2 && $level != -1) {
      $level = 1;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_2 && $point < $levelup_to_3 && $level != -1) {
      $level = 2;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_3 && $point < $levelup_to_4 && $level != -1) {
      $level = 3;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_4 && $point < $levelup_to_5 && $level != -1) {
      $level = 4;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_5 && $point < $levelup_to_6 && $level != -1) {
      $level = 5;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_6 && $point <= $levelup_to_7 && $level != -1) {
      $level = 6;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_7 && $point <= $levelup_to_8 && $level != -1) {
      $level = 7;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_8 && $point <= $levelup_to_9 && $level != -1) {
      $level = 8;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($point >= $levelup_to_9 && $level != -1) {
      $level = 9;
      $sql = "update members set level='$level' where num=$num";
      $result = mysqli_query($con, $sql);
    }

    //레벨에 따른 티어 변화
    if ($level == -1) {
      $tier = 'admin.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 0) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 1) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 2) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 3) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 4) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 5) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 6) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 7) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 8) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    } else if ($level == 9) {
      $tier = $level.'.gif';
      $tier_dir = './img/tier/'.$tier;
      $sql = "update members set tier='$tier', tier_dir='$tier_dir' where num=$num";
      $result = mysqli_query($con, $sql);
    }



    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

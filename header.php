<?php
    @session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
    if (isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
    else $userpoint = "";
    if (isset($_SESSION["usertier"])) $usertier = $_SESSION["usertier"];
    else $usertier = "";
    if (isset($_SESSION["userprofile_img"])) $userprofile_img = $_SESSION["userprofile_img"];
    else $usertier = "";


?>
<script>
function board() {
  // if() {
  //   return;
  // }
}

</script>
<style>
* {margin: 0; padding: 0; }
li {list-style: none; }
body {font-family: 'Nanum Gothic', sans-serif; width: 1200px; margin: 0 auto; }

.logo {margin: 50px 0; font-size: 30px; text-align: center; font-family: 'Nanum Brush Script', cursive; }

.topMenu {width: 100%; margin-bottom: 20px; text-align: center; height: 40px; }
.topMenu:after {content: ""; display: block; clear: both; }
.menu01>li {float: left; width: 20%; line-height: 40px; }
.menu01 span {font-size: 20px; font-weight: bold; }

.dept01 {display: none; padding: 20px 0; border-bottom: 1px solid #ccc; }

#nop {float: none; }

.none:after {content: ""; display: block; clear: both; }

</style>
<!--
<div class="logo">
            <span class="logo">컨텐츠 내용이 밀리는 풀 드롭다운 메뉴</span>
        </div>
        <div class="topMenu">
            <ul class="menu01">
                <li><span>Menu01</span>
                    <ul class="dept01">
                        <li id="nop">sub01</li>
                        <li id="nop">sub02</li>
                        <li id="nop">sub03</li>
                        <li id="nop">sub04</li>
                        <li id="nop">sub05</li>
                    </ul>
                </li>
                <li><span>Menu02</span>
                    <ul class="dept01">
                        <li id="nop">sub01</li>
                        <li id="nop">sub02</li>
                        <li id="nop">sub03</li>
                        <li id="nop">sub04</li>
                        <li id="nop">sub05</li>
                    </ul>
                </li>
                <li><span>Menu03</span>
                    <ul class="dept01">
                        <li id="nop">sub01</li>
                        <li id="nop">sub02</li>
                        <li id="nop">sub03</li>
                        <li id="nop">sub04</li>
                        <li id="nop">sub05</li>
                    </ul>
                </li>
                <li><span>Menu04</span>
                    <ul class="dept01">
                        <li id="nop">sub01</li>
                        <li id="nop">sub02</li>
                        <li id="nop">sub03</li>
                        <li id="nop">sub04</li>
                        <li id="nop">sub05</li>
                    </ul>
                </li>
                <li><span>Menu05</span>
                    <ul class="dept01">
                        <li id="nop">sub01</li>
                        <li id="nop">sub02</li>
                        <li id="nop">sub03</li>
                        <li id="nop">sub04</li>
                        <li id="nop">sub05</li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="none">
        </div>
-->
        <div id="top">
            <h3>
                <a href="index.php">질문 & 상담 게시판</a>
            </h3>
            <ul id="top_menu">

<?php
    if(!$userid) {
?>
                <li><a href="member_form.php" id="member">회원 가입</a> </li>
                <li> | </li>
                <li><a href="login_form.php">로그인</a></li>
<?php
    } else {
      $con = mysqli_connect("localhost", "user1", "12345", "1505007");
      $sql = "select * from members where id='$userid'";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result);
      $level = $row["level"];
      $point = $row["point"];
      $tier    = $row["tier"];
      $tier_dir    = $row["tier_dir"];
      $profile_img = $row["profile_img"];
      $profile_img_dir = $row["profile_img_dir"];

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

      //포인트에 따른 레벨 변화
      if ($point < $levelup_to_1 && $level != -1){
        $level = 0;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_1 && $point < $levelup_to_2 && $level != -1) {
        $level = 1;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_2 && $point < $levelup_to_3 && $level != -1) {
        $level = 2;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_3 && $point < $levelup_to_4 && $level != -1) {
        $level = 3;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_4 && $point < $levelup_to_5 && $level != -1) {
        $level = 4;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_5 && $point < $levelup_to_6 && $level != -1) {
        $level = 5;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_6 && $point <= $levelup_to_7 && $level != -1) {
        $level = 6;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_7 && $point <= $levelup_to_8 && $level != -1) {
        $level = 7;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_8 && $point <= $levelup_to_9 && $level != -1) {
        $level = 8;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($point >= $levelup_to_9 && $level != -1) {
        $level = 9;
        $sql = "update members set level='$level' where id='$userid'";
        $result = mysqli_query($con, $sql);
      }

      //레벨에 따른 티어 변화
      if ($level == -1) {
        $tier = 'admin.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 0) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 1) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 2) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 3) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 4) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 5) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 6) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 7) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 8) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      } else if ($level == 9) {
        $tier = $level.'.gif';
        $tier_dir = './img/tier/'.$tier;
        $sql = "update members set tier='$tier', tier_dir='$tier_dir' where id='$userid'";
        $result = mysqli_query($con, $sql);
      }

                $logged = '<img src="'.$tier_dir.'" width="18" height="18"/>'.$username."(".$userid.")님[Level:".$level.", Point:".$point."]";

?>
                <li><?=$logged?> </li>
                <li> | </li>
                <li><a href="logout.php">로그아웃</a> </li>
                <li> | </li>
                <li><a href="member_modify_form.php">회원정보 수정</a></li>
<?php
    }
?>
<?php
    if($userlevel==-1) {
?>
                <li> | </li>
                <li><a href="admin.php">관리자 모드</a></li>
<?php
    }
?>
            </ul>
        </div>
        <div id="menu_bar">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="board_list.php?page=1">질문 목록</a></li>
                <?php
                    if($userid && $userlevel != -1) {
                ?>

                <li><a href="board_form.php"/>질문 작성</li>
                <li><a href="member_modify_form.php">회원정보 변경</a></li>
                <?php
                    }
                ?>
                <!-- <li><a href="board_form.php">게시판 만들기</a></li> -->
                <?php
                    if($userlevel == -1) {
                ?>
                <li><a href="board_form.php"/>질문 작성</li>
                <li><a href="member_modify_form.php">회원정보 변경</a></li>
                <li><a href="admin.php">관리자 모드</a></li>
                <?php
                    }
                ?>
            </ul>
        </div>

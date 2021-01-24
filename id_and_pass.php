        <!-- <div id="main_img_bar">
            <img src="./img/main.jpg">
        </div> -->
        <div id="main_content">
          <div id="latest">
              <h4>공지사항</h4>
              <ul>
<!-- 최근 게시 글 DB에서 불러오기 -->
<?php
  $con = mysqli_connect("localhost", "user1", "12345", "1505007");
  mysqli_set_charset($con, 'utf8'); //한글로 출력가능
  $sql = "select * from board where importance = 1 order by num desc limit 5 ";
  $result = mysqli_query($con, $sql);

  if (!$result)
      echo "게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!";
  else
  {
      while( $row = mysqli_fetch_array($result) )
      {
          $regist_day = substr($row["regist_day"], 0, 10);
?>
              <li>
                  <span><a href="board_view.php?num='<?=$row["num"]?>'&page=1"><?=$row["subject"]?></a></span>
                  <span><?=$row["name"]?></span>
                  <span><?=$regist_day?></span>
              </li>
<?php
      }
  }
?>
          </div>
          <?php
            if(!$userid) {
              $login_banner = "로그인";
            } else {
              $login_banner = "회원정보";
            }
          ?>


            <div id="point_rank">
                <h4><?=$login_banner?></h4>
                <ul>
<!-- 포인트 랭킹 표시하기 -->
      <div style="border-style: groove; padding: 15px 10px 30px 30px; margin: 5px 40px 0 0;">
        <?php
            if(!$userid) {
        ?><form name="login_form" method="post" action="./login.php">
        <li>
            <span>ID  : </span>
            <span><input type="text" value="" id="id" name="id" placeholder="ID"/></span>
        </li>
        <li>
            <span>PW : </span>
            <span><input type="password" value="" id="pass" name="pass" placeholder="Password"/></span>
        </li>
        <li>
          <div style="margin: 20px 20px 0 70px">

              <input type="submit"  value="로그인" style="width:50px; height:33px;"/> &nbsp;
              <input type="button" onclick="location.href='member_form.php'" value="회원가입" style="width:80px; height:33px;"/>

          </div>

        </li>
        </form>
        <?php
      } else {
        ?>
        <li>
          <?php
            $profile_img = '<img src="'.$profile_img_dir.'" width="18" height="18"/>'; //프로필 불러오기
            $profile_in_box = '<img src="'.$tier_dir.'" width="18" height="18"/>'.$username."(".$userid.")님!";
            $point_in_box = '[Level:'.$level.', Point:'.$point.']';
          ?>
          <div>
            <img src="<?=$profile_img_dir?>" style="position: absolute; margin: -10px 0 0 -30px; width:100px; height:100px;"/>
            <ul style="margin: 0 0 0 75px;">
              <li>
                <?=$profile_in_box?>
              </li>
              <li>
                <?=$point_in_box?>
              </li>
              <li>
                  <a href="logout.php">로그아웃</a> |
                  <a href="member_modify_form.php">회원정보 수정</a>
              </li>
            </ul>

          </div>
          <div>

          </div>

        </li>

        <?php
      }
      ?>
      </div>


      <br />
                <li>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </li>
                </ul>
            </div>



        </div>

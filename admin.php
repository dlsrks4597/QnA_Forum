<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/admin.css">
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
</head>
<body>
<header>
    <?php include "header.php";?>
</header>
<section>
   	<div id="admin_box">
	    <h3 id="member_title">
	    	관리자 모드 > 회원 관리
		</h3>
	    <ul id="member_list">
				<li>
					<span class="col1">번호</span>
					<span class="col2">아이디</span>
					<span class="col3">이름</span>
					<span class="col4">레벨</span>
					<span class="col5">포인트</span>
					<span class="col6">가입일</span>
					<span class="col7">수정</span>
					<span class="col8">탈퇴</span>
				</li>
<?php
	$con = mysqli_connect("localhost", "user1", "12345", "1505007");
  mysqli_set_charset($con, "UTF8");
	$sql = "select * from members where level != -1 order by num desc";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 회원 수

	$number = $total_record;

   while ($row = mysqli_fetch_array($result))
   {
      $num         = $row["num"];
	  $id          = $row["id"];
	  $name        = $row["name"];
    $tier_dir        = $row["tier_dir"];
	  $level       = $row["level"];
      $point       = $row["point"];
      $regist_day  = $row["regist_day"];
?>

		<li>
		<form method="post" action="admin_member_update.php?num=<?=$num?>"> <!--수정할 num을 넘겨주기 위해 이렇게 링크를 검-->
			<span class="col1"><?=$number?></span>
			<span class="col2"><?=$id?></a></span>
			<span class="col3"><img src="<?=$tier_dir?>" /><?=$name?></span>
			<span class="col4"><?=$level?></span>
			<span class="col5"><input type="text" name="point" value="<?=$point?>"></span>
			<span class="col6"><?=$regist_day?></span>
			<span class="col7"><button type="submit">수정</button></span>
      <span class="col8"><button type="button" onclick="location.href='admin_member_delete.php?num=<?=$num?>'">탈퇴</button></span>
			<!-- <span class="col8"><button type="button" onclick="location.href='admin_member_delete.php?num=">탈퇴</button></span> -->
		</form>
		</li>
    <script>
      // function delete_member() {
      //    var delete_member;
      //        delete_member = confirm("정말로 삭제하시겠습니까?");
      //        if(delete_member){
      //            location.href="admin_member_delete.php?num=<?=$num?>";
      //        } else {
      //          return;
      //        }
      // }
    </script>

<?php
   	   $number--;
   }
?>
<h3 id="member_title">
  레벨은 포인트 변경으로 수정 가능합니다. &emsp;&emsp;&emsp;&emsp;&emsp;
  <a href="#" style="color: orange" onclick="window.open('admin_check_point.php','name','resizable=no width=600 height=500');return false">레벨에 따른 포인트 조건 보기</a>
</h3>

	    </ul>
	    <h3 id="member_title">
	    	관리자 모드 > 게시판 관리
		</h3>
	    <ul id="board_list">
		<li class="title">
			<span class="col1">선택</span>
			<span class="col2">번호</span>
			<span class="col3">이름</span>
			<span class="col4">제목</span>
			<span class="col5">공지사항</span>
			<span class="col6">작성일</span>
		</li>
    <!-- action="admin_board_delete.php" -->
		<form method="post" >
<?php
	$sql = "select * from board order by num desc";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글의 수

	$number = $total_record;

   while ($row = mysqli_fetch_array($result))
   {
      $num         = $row["num"];
	  $name        = $row["name"];
	  $subject     = $row["subject"];
	  $file_name   = $row["file_name"];
    $importance   = $row["importance"];
    $regist_day  = $row["regist_day"];
    $regist_day  = substr($regist_day, 0, 10);
    $check_importance = '';
      if ($importance == 1) {
        $check_importance = '공지';
      }
?>
		<li>
			<span class="col1"><input type="checkbox" name="item[]" value="<?=$num?>"></span>
      <!--배열 구조로 가져감 post방식으로 value값을 넘겨줌-->
			<span class="col2"><?=$number?></span>
			<span class="col3"><?=$name?></span>
			<span class="col4"><?=$subject?></span>
			<span class="col5"><?=$check_importance?></span>
			<span class="col6"><?=$regist_day?></span>
		</li>
<?php
   	   $number--;
   }
   mysqli_close($con);
?>
<h3 id="member_title">
  공지사항으로 게시된 글은 게시판에서 최대 5개까지만 표시되며, 등록일 순으로 정렬됩니다.
</h3>
				<button type="submit" class="btn" onclick="javascript: form.action='./admin_board_delete.php'" disabled="true">선택된 글 삭제</button>

        <button type="submit" class="btn" onclick="javascript: form.action='./admin_board_update.php';" disabled="true">선택된 글 공지사항으로 등록</button>
        <button type="submit" class="btn" onclick="javascript: form.action='./admin_board_update_reverse.php';" disabled="true">
          선택된 글 공지사항에서 제외</button>
			</form>
      <script>
      $(document).ready(function() {
        $("input:checkbox[name^='item']").on("change", function(){
          if ($("input:checkbox[name^='item']:checked").length == 0) {
            $(".btn").attr('disabled', true);
          } else {
            $(".btn").attr('disabled', false);
          }
         // if($(this).is(":checked")){
         //    $(this).prop("checked", true);
         //    alert($(this).val);
         //     $(".btn").hide();
         // }
         // else{
         //
         //     $(this).prop("checked", false);
         //    alert($(this).val);
         //     $(".btn").show();
         //
         // }

    });
         });
        // function board_delete() {
        //   var board_delete;
        //   board_delete = confirm("정말로 삭제하시겠습니까?");
        //   if(board_delete){
        //     method = method || "post";
        //     // $.ajax({
        //     //   type: 'POST',
        //     //   url: url,
        //     //   data: data,
        //     //   success: success,
        //     //   dataType: data
        //     // })
        //       location.href="./admin_board_delete.php";
        //   } else {
        //     return;
        //   }
        // }
      </script>
	    </ul>
	</div> <!-- admin_box -->
</section>
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>

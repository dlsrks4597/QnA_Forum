<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
</head>
<body>
<header>
    <?php include "header.php";?>
</header>
<section>
	<!-- <div id="main_img_bar">
        <img src="./img/main_img.png">
    </div> -->
   	<div id="board_box">
      <div style="position:absolute; border: 2px groove #dddddd; padding:5px 5px 5px 5px; margin:10px 0 0 650px;">
        <button type="button" onclick="location.href='board_list.php?page=1&sort=thread'" >등록순</button>
        <button type="button" onclick="location.href='board_list.php?page=1&sort=board_like'" >추천순</button>
      </div>

	    <h3>
	    	게시판 > 목록보기
		</h3>

	    <ul id="board_list">
				<li>
					<span class="col1">번호</span>
					<span class="col2">제목</span>
					<span class="col3">글쓴이</span>
					<span class="col5">등록일</span>
					<span class="col6">추천수</span>
          <span class="col7">조회</span>
				</li>
<?php
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;
    if (isset($_GET["sort"]))
  		$sort = $_GET["sort"];
  	else
  		$sort = 'thread';

    if(empty($_REQUEST["board_search"])){ // 검색어가 empty일 때 예외처리를 해준다.

      $board_search ="";

    } else {

      $board_search =$_REQUEST["board_search"];

    }

	$con = mysqli_connect("localhost", "user1", "12345", "1505007");
  mysqli_set_charset($con, 'utf8'); //한글로 출력가능

  $sql = "select * from board where importance = 1 order by thread desc, num desc";
  $result = mysqli_query($con, $sql);
	$total_record_importance = mysqli_num_rows($result); // 전체 글 수
  if ($total_record_importance > 5) {
    $total_record_importance = 5;
  }
  for ($i = 0; $i < $total_record_importance; $i++) {
    //$sql = "select * from board where importance = 1 order by thread desc";
    mysqli_data_seek($result, $i);
    // 가져올 레코드로 위치(포인터) 이동
    $row_importance = mysqli_fetch_array($result);

    $num_importance         = $row_importance["num"];
    $id_importance          = $row_importance["id"];
    $name_importance        = $row_importance["name"];
    $subject_importance     = $row_importance["subject"];
    $regist_day_importance  = $row_importance["regist_day"];
    $board_like_importance         = $row_importance["board_like"];
    $hit_importance         = $row_importance["hit"];
    $comments_importance = null;
    if ($row_importance['comments'] != 0) {
      $comments_importance = "(".$row_importance['comments'].")";
    }

?>
      <li style="background-color: #F6CECE;">
        <span class="col1">중요</span>
        <span class="col2">
          <a href="board_view.php?num=<?=$num_importance?>&page=<?=$page?>">
            <?=$subject_importance?>&nbsp;<strong style="color:orange"><?=$comments_importance?></strong>
          </a>
        </span>
        <span class="col3"><?=$name_importance?></span>
        <span class="col5"><?=$regist_day_importance?></span>
        <span class="col6"><?=$board_like_importance?></span>
        <span class="col7"><?=$hit_importance?></span>
      </li>
<?php
 }


	$sql = "select * from board order by thread desc";
  $sql = "select * from board where subject LIKE '%$board_search%' order by $sort desc";

	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	$scale = 10;

	// 전체 페이지 수($total_page) 계산
	if ($total_record % $scale == 0)
		$total_page = floor($total_record/$scale);
	else
		$total_page = floor($total_record/$scale) + 1;

	// 표시할 페이지($page)에 따라 $start 계산
	$start = ($page - 1) * $scale;

	$number = $total_record - $start;


   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
   {
     //$sql = "select * from board where subject LIKE '%$board_search%' order by $sort desc";
      mysqli_data_seek($result, $i);
      // 가져올 레코드로 위치(포인터) 이동
      $row = mysqli_fetch_array($result);
      // 하나의 레코드 가져오기
	  $num         = $row["num"];
	  $id          = $row["id"];
	  $name        = $row["name"];
	  $subject     = $row["subject"];
      $regist_day  = $row["regist_day"];
      $board_like         = $row["board_like"];
      $hit         = $row["hit"];
      $comments = null;
      if ($row['comments'] != 0) {
        $comments = "(".$row['comments'].")";
      }

      if ($row["file_name"])
      	$file_image = "<img src='./img/file.gif'>"; //첨부파일이 있으면 아이콘 띄워줌
      else
      	$file_image = " ";
?>
				<li>
					<span class="col1"><?=$number?></span>
					<span class="col2">
            <a href="board_view.php?num=<?=$num?>&page=<?=$page?>">
              <?=$subject?>&nbsp;<strong style="color:orange"><?=$comments?></strong>
            </a>
          </span>
					<span class="col3"><?=$name?></span>
					<span class="col5"><?=$regist_day?></span>
					<span class="col6"><?=$board_like?></span>
          <span class="col7"><?=$hit?></span>
				</li>
<?php
   	   $number--;
   }
   mysqli_close($con);

?>
	    	</ul>
			<ul id="page_num">
<?php
	if ($total_page>=2 && $page >= 2)
	{
		$new_page = $page-1;
		echo "<li><a href='board_list.php?board_search=$board_search&page=$new_page&sort=$sort'>◀ 이전</a> </li>";
	}
	else
		echo "<li>&nbsp;</li>";

   	// 게시판 목록 하단에 페이지 링크 번호 출력
   	for ($i=1; $i<=$total_page; $i++)
   	{
		if ($page == $i)     // 현재 페이지 번호 링크 안함
		{
			echo "<li><b> $i </b></li>";
		}
		else
		{
			echo "<li><a href='board_list.php?board_search=$board_search&page=$i&sort=$sort'> &nbsp;$i&nbsp; </a><li>";
		}
   	}
   	if ($total_page>=2 && $page != $total_page)
   	{
		$new_page = $page+1;
		echo "<li> <a href='board_list.php?board_search=$board_search&page=$new_page&sort=$sort'>다음 ▶</a> </li>";
	}
  //get방식의 검색은 주소앞에 board_search=$board_search& 를 붙여줘야 페이지이동이 원활하다.
	else
		echo "<li>&nbsp;</li>";
?>
			</ul> <!-- page -->
      <!-- 페이지 검색창 구현 -->
      <form method="get" action="">
        <input type="search" id="board_search" name="board_search" style="height:32px"/>
        <button style="width: 60px;height:32px">검색</button>
      </form>

			<ul class="buttons">

				<li><button onclick="location.href='board_list.php'">목록</button></li>
				<li>
<?php
    if($userid) {
?>
					<button onclick="location.href='board_form.php'">글쓰기</button>
<?php
	} else {
?>
					<a href="javascript:alert('로그인 후 이용해 주세요!')"><button>글쓰기</button></a>
<?php
	}
?>
				</li>
			</ul>
	</div> <!-- board_box -->
</section>
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>

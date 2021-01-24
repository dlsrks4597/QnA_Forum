<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
</head>
<style>
.height_auto {
  overflow: hidden;
  height: auto;
}
</style>
<body>
<header>
    <?php include "header.php";?>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script   src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function(){

 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"./tbl_comments/add_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"./tbl_comments/fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });

});
</script>
<!-- <script>
$(document).ready(function(){

 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"./comments/comment-add.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });

});
</script> -->
<!-- <script>
	function postReply(commentId) {
		$('#commentId').val(commentId);
		$("#name").focus();
	}

	$("#submitButton").click(function() {
		$("#comment-message").css('display', 'none');
		var str = $("#frm-comment").serialize();

		$.ajax({
			url : "./comments/comment-add.php",
			data : str,
			type : 'post',
			success : function(response) {
				var result = eval('(' + response + ')');
				if (response) {
					$("#comment-message").css('display', 'inline-block');
					$("#name").val("");
					$("#comment").val("");
					$("#commentId").val("");
					listComment();
				} else {
					alert("Failed to add comments !");
					return false;
				}
			}
		});
	});

	$(document).ready(function() {
		listComment();
	});

	function listComment() {
		$
				.post(
						"comment-list.php",
						function(data) {
							var data = JSON.parse(data);

							var comments = "";
							var replies = "";
							var item = "";
							var parent = -1;
							var results = new Array();

							var list = $("<ul class='outer-comment'>");
							var item = $("<li>").html(comments);

							for (var i = 0; (i < data.length); i++) {
								var commentId = data[i]['comment_id'];
								parent = data[i]['parent_comment_id'];

								if (parent == "0") {
									comments = "<div class='comment-row'>"
											+ "<div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>"
											+ data[i]['comment_sender_name']
											+ " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>"
											+ data[i]['date']
											+ "</span></div>"
											+ "<div class='comment-text'>"
											+ data[i]['comment']
											+ "</div>"
											+ "<div><a class='btn-reply' onClick='postReply("
											+ commentId + ")'>Reply</a></div>"
											+ "</div>";

									var item = $("<li>").html(comments);
									list.append(item);
									var reply_list = $('<ul>');
									item.append(reply_list);
									listReplies(commentId, data, reply_list);
								}
							}
							$("#output").html(list);
						});
	}

	function listReplies(commentId, data, list) {
		for (var i = 0; (i < data.length); i++) {
			if (commentId == data[i].parent_comment_id) {
				var comments = "<div class='comment-row'>"
						+ " <div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>"
						+ data[i]['comment_sender_name']
						+ " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>"
						+ data[i]['date'] + "</span></div>"
						+ "<div class='comment-text'>" + data[i]['comment']
						+ "</div>"
						+ "<div><a class='btn-reply' onClick='postReply("
						+ data[i]['comment_id'] + ")'>Reply</a></div>"
						+ "</div>";
				var item = $("<li>").html(comments);
				var reply_list = $('<ul>');
				list.append(item);
				item.append(reply_list);
				listReplies(data[i].comment_id, data, reply_list);
			}
		}
	}
</script> -->
<script src="jquery-3.2.1.min.js"></script>
<section>
   	<div id="board_box">
	    <h3 class="title">
			게시판 > 내용보기
		</h3>
<?php
	$num  = $_GET["num"];
	$page  = $_GET["page"];

	$con = mysqli_connect("localhost", "user1", "12345", "1505007");
  mysqli_set_charset($con, 'utf8');
	$sql = "select * from board where num=$num";
	$result = mysqli_query($con, $sql);
  //$result = mysqli_multi_query($con, $sql);

	$row = mysqli_fetch_array($result);
  $thread      = $row["thread"];
  $num      = $row["num"];
	$id      = $row["id"];
	$name      = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$file_name    = $row["file_name"];
	$file_type    = $row["file_type"];
	$file_copied  = $row["file_copied"];
	$hit          = $row["hit"];
  $board_like          = $row["board_like"]; //추천수


  $id_uploader      = $row["id"];


  //추천 유무에 따른 버튼변화
  $sql = "select * from members where id = '$userid'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $board_like_num = $row["board_like_num"];
  $board_num_judge = "(".$num.")";
  if (!$board_like_num) { //우선 로그인 유무 확인, 로그인을 안했다면 null값
    $board_like_btn = "./img/board_like.png";
  } else {
    if (strpos($board_like_num,$board_num_judge) == false) { //추천을 한 글이라면(문자열이 포함되있는지 판단)
      $board_like_btn = "./img/board_like.png";
    } else { //추천한 글이 아니라면
      $board_like_btn = "./img/board_like_cancel.png";
    }
  }



	// $content = str_replace(" ", "&nbsp;", $content); //글작성할 때 스페이스바, 엔터 허용
	// $content = str_replace("\n", "<br>", $content);

	$new_hit = $hit + 1;
	$sql = "update board set hit=$new_hit where num=$num";
	mysqli_query($con, $sql);


  //업로더 정보 불러오기
  $sql_uploader = "select * from members where id='$id_uploader'";

  $result_uploader = mysqli_query($con, $sql_uploader);
  $row_uploader = mysqli_fetch_array($result_uploader);
  $name_uploader = $row_uploader["name"];
  $level_uploader = $row_uploader["level"];
  $tier_dir_uploader    = $row_uploader["tier_dir"];
  $profile_uploader    = $row_uploader["profile"];
  $profile_img_dir_uploader = $row_uploader["profile_img_dir"];



?>

<input type="hidden" name="board_num" id="board_num" value="<?=$num?>"/>
<input type="hidden" name="thread" id="thread" value="<?=$thread?>"/>
	    <ul id="view_content" class="view">
			<li style="padding: 10px; border-bottom: solid 1px #aaaaaa;">
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2">  <?=$regist_day?></span>
			</li>
      <li style="padding: 10px; border-bottom: solid 1px #aaaaaa;">
				<span class="col1"><img src=<?=$tier_dir_uploader ?>><?=$name?>[Level : <?=$level_uploader?>]</span>
				<span class="col2">조회수 : <?=$new_hit?> &nbsp;&nbsp;| 추천수 : <span class="board_like"><?=$board_like?></span></span>
			</li>
			<li style="padding: 15px 15px 80px 15px; border-bottom: solid 1px #cccccc;">
				<?php
					if($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			           	}
                  //echo $content;
                  //echo (stripslashes($content));
				?>
        <div class="content">
          <?=$content?>
        </div>



        <?php
          if ($file_type == "image/jpeg" || $file_type == "image/png" ) { ?>
            <br><img src="<?=$file_path?>" width="300" height="300"/>";
        <?php  }?>

			</li>
	    </ul>
      <div style="width: 800px; height: 200px; border-style: groove;">
        <div style="width: 150px; height: 150px; border-style: groove; margin: 25px 0 0 25px;">
          <img src="<?=$profile_img_dir_uploader?>" style="width: 150px; height: 150px;"/>
        </div>
        <div style="margin: -150px 0 0 200px">
          <img src=<?=$tier_dir_uploader ?>><?=$name?> [Level : <?=$level_uploader?>]
        </div>
        <div style="width:600px; height: 200px; margin: 20px 0 0 200px">
          <?=$profile_uploader?>
        </div>
      </div>
      <ul>
        <li>
          <div style="">
            <button id="board_like_btn" style="border: none; cursor: pointer; height:10px; margin: 20px 0 0 320px;"><img id="board_like_btn_value" src="<?=$board_like_btn?>" /></button>
            <script>
            $(function(){
              $("#board_like_btn").click(function(){

                var userid = '<?=$userid?>';
                var num = '<?=$num?>';
                var board_like = <?=$board_like?>;
                $.ajax({ //ajax 시작
                      type : "POST", //전송방식
                      url : "./board_like.php", //ajax를 실행할 파일 경로
                      async: false,
                      data: {userid:userid, num:num, board_like:board_like}, //전송방식이 POST일 경우에 전송할 데이터들을 나열해준다
                      // dataType : "json",
                      success : function(result){  //전송성공
                        if(result == 1) {
                          alert("회원만 추천이 가능합니다!");
                        } else if (result == 2) {
                          alert("추천을 취소하셨습니다!");
                          $('.board_like').text(board_like);
                          $('#board_like_btn_value').attr('src','./img/board_like.png');
                        } else {
                          alert("추천하였습니다!");
                          $('.board_like').text(board_like);
                          $('#board_like_btn_value').attr('src','./img/board_like_cancel.png');
                        }
                      }, error: function(xhr, status, error){
                          var error_confirm=confirm('데이터 전송 오류입니다. 확인을 누르시면 페이지가 새로고침됩니다.');
                          if(error_confirm==true){
                          document.location.reload();
                    }
                }
                   });

             })
           });

       </script>
            <!-- <button style="border: none; cursor: pointer; height:10px; margin: 20px 0 0 20px;"><img src="./img/report.png" /></button> -->
          </div>
        </li>
      </ul>
	    <ul class="buttons">
				<li><button onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>
        <?php
          if($userid) {
        ?>
        <li><button onclick="location.href='board_reply_form.php?num=<?=$num?>&page=<?=$page?>'">답글</button></li>
        <?php
          }
        ?>
        <!--본인일 경우에만 수정 및 삭제 가능-->
<?php
  if ($id == $userid) {
?>
<li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
<li><button onclick="location.href='board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
<li><button onclick="location.href='board_form.php'">글쓰기</button></li>
<?php
  }
?>



		</ul>

    <div class="container">
      <span id="board_num" name="board_num" type="hidden" value="<?=$num?>"></span>
      <span id="fetch_board_num" name="fetch_board_num" type="hidden" value="<?=$_SERVER['REQUEST_URI']?>"></span>
      <h3 class="title">댓글 작성</h3>
      <form method="POST" id="comment_form">
        <table style="width:800px; border-style: groove; padding:10px 10px 10px 10px;">
          <tr>
            <td>
              작성자명:
            </td>
            <td>
              <input type="hidden" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" value="<?=$username?>" readonly/><?=$username?>
              <input type="hidden" name="comment_sender_id" id="comment_sender_id" class="form-control" placeholder="Enter Name" value="<?=$userid?>" readonly/>
            </td>
            <td>
              <span name="try_reply" id="try_reply" value="" ></span>
              <!-- <input type="text" name="try_reply" id="try_reply" value="1" readonly /> -->
            </td>
          </tr>
          <tr>
            <td style=" display: inline-block">

              내용 :
            </td>
            <td colspan="2">
                <div class="form-group">
                 <textarea name="comment_content" id="comment_content" class="form-control" placeholder="내용을 입력하세요." cols="50px"rows="5" style="border-style: groove;"></textarea>
                </div>
            </td>
          </tr>
          <tr>

        </table>
        <?php
          $sql_uploader = "select * from members where id='$id_uploader'";

          $result_uploader = mysqli_query($con, $sql_uploader);
          $row_uploader = mysqli_fetch_array($result_uploader);
          $name_uploader = $row_uploader["name"];
        ?>



       <div class="form-group">
        <input type="hidden" name="board_number" id="board_number" class="form-control" value='<?=$num?>'/>
       </div>
       <div class="form-group" style="margin: 0 0 0 750px;">
        <input type="hidden" name="comment_id" id="comment_id" value="0" />
        <input type="submit" name="submit" id="submit" class="btn btn-info" value="등록" style="width:50px; height:33px;"/>
       </div>
      </form>
      <h3 class="title">댓글 목록</h3>
     <span id="comment_message"></span>
     <br />
     <div id="display_comment"></div>
    </div>
    </form>
          <script>
          $(document).ready(function(){
            $('#comment_form').on('submit', function(event){
              event.preventDefault();
              var form_data = $(this).serialize();
              $.ajax({
                url:"./comments/add_comment.php",
                method:"POST",
                data:form_data,
                dataType:"JSON",
                success:function(data)
                {
                  if(data.error != '')
                  {
                    $('#comment_form')[0].reset();
                    $('#comment_message').html(data.error);
                    $('#comment_id').val('0');
                    $('#comment_content').focus();
                    load_comment();
                  }
                }
              })
            });

            load_comment();

            function load_comment()
            {
              var board_num = <?=$num?>;
              $.ajax({
                url:"./comments/fetch_comment.php",
                method:"POST",
                data: {board_num:board_num},
                success:function(data)
                {
                  $('#try_reply').html("");
                  $('#display_comment').html(data);
                }
              })
            }

            // function delete_fail() {
            //   var id_check = $("#comment_message").css("color");
            //   wait(1000);
            //   if (id_check == "rgb(255, 0, 0)") {
            //     alert("답글을 삭제할 권한이 없습니다.");
            //   }
            //
            // }

            $(document).on('click', '.reply', function(){
              var comment_id = $(this).attr("id");
              var comment_name = $(this).attr("name");
              // var reply_btn = $('.reply').css("color");
              $('#comment_id').val(comment_id);
              $('.reply').css("color","black");
              $(this).css("color","red");
              $('#try_reply').html("[ " + comment_name + " 님에게 보내는 답글 ]");
              $('#comment_content').focus();
              });


              $(document).on('click', '.delete', function(){
                var form_data = $(this).serialize();
                var check = confirm("정말로 삭제하시겠습니까?");
                if (check) {
                  // alert("test");

                  var userid = '<?=$userid?>';
                  var board_number = '<?=$num?>';
                  var comment_id = $(this).val();
                  // if (userid != comment_id) {
                  //   alert(userid);
                  //   alert(comment_id);
                  //   alert("답글을 삭제할 권한이 없습니다!");
                  //   return;
                  // }
                  // alert(userid);
                  // alert(board_number);
                  // alert(comment_id);
                  $.ajax({ //ajax 시작
                        type : "POST", //전송방식
                        url : "./comments/delete_comment.php", //ajax를 실행할 파일 경로
                        async: false,
                        dataType:"JSON",
                        data: {userid:userid, board_number:board_number, comment_id:comment_id}, //전송방식이 POST일 경우에 전송할 데이터들을 나열해준다
                        // dataType : "json",
                        success : function(data){  //전송성공
                          if(data.error != '')
                          {
                          //$('#comment_message').html(data);
                          console.log(data);
                          // alert(data);
                          $('#comment_message').html(data);

                          load_comment();
                         }
                        }, error: function(xhr, status, error){
                            var error_confirm=confirm('데이터 전송 오류입니다. 확인을 누르시면 페이지가 새로고침됩니다.');
                            if(error_confirm==true){
                            document.location.reload();
                      }
                  }
                     });





                  // $.ajax({
                  //   url:"./comments/delete_comment.php",
                  //   method:"POST",
                  //   data:form_data,
                  //   dataType:"JSON",
                  //   success:function(data){
                  //     alert("1");
                  //     if(data.error != '')
                  //     {
                  //       $('#comment_form')[0].reset();
                  //       $('#comment_message').html(data.error);
                  //       $('#comment_id').val('0');
                  //       $('#comment_content').focus();
                  //       load_comment();
                  //     }
                  //   }
                  // })
                } else {
                  return;
                }

              });



            });
</script>
    <ul class="buttons" >

    <li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
  </ul>
    <p>
      <div id="comment-message" style="display: none">댓글작성 성공</div>
      <div id="output"></div>

	</div> <!-- board_box -->

</section>
<footer>
</footer>
</body>
</html>

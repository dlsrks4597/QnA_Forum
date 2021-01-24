<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/member.css">
<script type="text/javascript" src="./js/member_modify.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="js/idCheck.js"></script>
</head>
<body>
	<header>
    	<?php include "header.php";?>
    </header>
<script>

//비밀번호 체크
   $(function() {
	    $("#userpw").keyup(function(){
		      var pw = $("#userpw").val();
          if(pw.length < 6 || pw.length > 12){
            $("#pw_check").css("color","red");
            $("#pw_check").css("font-weight","normal");
            $("#pw_check").text("비밀번호는 6자 이상 12자 이내로 입력해주세요.");
          } else {
            $("#pw_check").css("color","green");
            $("#pw_check").css("font-weight","bold");
            $("#pw_check").text("사용할 수 있는 비밀번호입니다. V");
          }
	       });
       });

//비밀번호 확인
$(function() {
   $("#userpw_same").keyup(function(){
       var pw1 = $("#userpw").val();
       var pw2 = $("#userpw_same").val();
       if (pw2.length < 6 || pw2.length > 12) {
         $("#pw_check_same").css("color","red");
         $("#pw_check_same").css("font-weight","normal");
         $("#pw_check_same").text("비밀번호를 정확히 다시 입력해주세요.");
       } else {
         if(pw1 == pw2){
           $("#pw_check_same").css("color","green");
           $("#pw_check_same").css("font-weight","bold");
           $("#pw_check_same").text("확인되었습니다. V");
         } else {
           $("#pw_check_same").css("color","red");
           $("#pw_check_same").css("font-weight","normal");
           $("#pw_check_same").text("비밀번호를 정확히 다시 입력해주세요.");
         }
       }

     });
   });

//이름 확인
$(function() {
   $("#username").keyup(function(){
       var name = $("#username").val();
       //var reg1 = /[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\"'\\]/g;
       var reg = /^[가-힣]{2,4}$/;
       if(name.length < 2){
         $("#name_check").css("color","red");
         $("#name_check").css("font-weight","normal");
         $("#name_check").text("이름은 한글로만 입력해주세요.");
       } else if(!reg.test(name)) {
         $("#name_check").css("color","red");
         $("#name_check").css("font-weight","normal");
         $("#name_check").text("이름은 한글로만 입력해주세요.");
       } else {
         $("#name_check").css("color","green");
         $("#name_check").css("font-weight","bold");
         $("#name_check").text("확인되었습니다. V");
       }
      });
    });


//이메일 선택박스 값 넘겨주기
$(function(){
  $("#getEmail").change(function(){
    $("#setEmail").val($("#getEmail option:checked").val());
    $("#setEmail").keyup();
  });
});

//이메일 확인
$(function() {
   $("#Email").keyup(function(){
       var email = $("#Email").val() + "@" + $("#setEmail").val();

       $("#email_check").text(email);
       var reg = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
       if(!reg.test(email)){
         $("#email_check").css("color","red");
         $("#email_check").css("font-weight","normal");
         $("#email_check").text("이메일을 정확하게 입력해주세요.");
       } else {
         $("#email_check").css("color","green");
         $("#email_check").css("font-weight","bold");
         $("#email_check").text("확인되었습니다. V");
       }
      });
      $("#setEmail").keyup(function(){
          var email = $("#Email").val() + "@" + $("#setEmail").val();

          $("#email_check").text(email);
          var reg = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
          if(!reg.test(email)){
            $("#email_check").css("color","red");
            $("#email_check").css("font-weight","normal");
            $("#email_check").text("이메일을 정확하게 입력해주세요.");
          } else {
            $("#email_check").css("color","green");
            $("#email_check").css("font-weight","bold");
            $("#email_check").text("확인되었습니다. V");
          }
         });
    });

    //프로필
    $(function() {
       $("#profile").keyup(function(){
           var profile = $("#profile").val();
           if (profile.length < 1) {
             $("#profile_check").css("color","red");
             $("#profile_check").css("font-weight","normal");
             $("#profile_check").text("자기소개는 반드시 입력해주세요.");
           } else {
             $("#profile_check").css("color","green");
             $("#profile_check").css("font-weight","bold");
             $("#profile_check").text("확인되었습니다. V");
           }

         });
       });

    function button() {
      var pw_check = $("#pw_check").css("color");
      var pw_check_same = $("#pw_check_same").css("color");
      var name_check = $("#name_check").css("color");
      var email_check = $("#email_check").css("color");
      var profile_check = $("#profile_check").css("color");
      if (pw_check == "rgb(0, 128, 0)"
      && pw_check_same == "rgb(0, 128, 0)"
      && name_check == "rgb(0, 128, 0)"
      && email_check == "rgb(0, 128, 0)"
      && profile_check == "rgb(0, 128, 0)") {
        // $("#button").show();
        $("#button").attr('disabled', false);
      } else {
        // $("#button").hide();
        $("#button").attr('disabled', true);
      }

    }
    setInterval('button()', 1); // 5초 후에 div 새로 고침

</script>

<?php
   	$con = mysqli_connect("localhost", "user1", "12345", "1505007");
		mysqli_set_charset($con, 'utf8');
    $sql    = "select * from members where id='$userid'";
    $result = mysqli_query($con, $sql);
    $row    = mysqli_fetch_array($result);

    $pass = $row["pass"];
    $name = $row["name"];

    $email = explode("@", $row["email"]);
    $email1 = $email[0];
    $email2 = $email[1];
		$profile = $row["profile"];
		$profile_img = $row["profile_img"];
		$profile_img_dir = $row["profile_img_dir"];

    mysqli_close($con);
?>
	<section>
		<!-- <div id="main_img_bar">
            <img src="./img/main_img.png">
        </div> -->
        <div id="main_content">
      		<div id="join_box">
          	<form  name="member_form" method="post" action="member_modify.php?id=<?=$userid?>" enctype="multipart/form-data">
			    <h2>회원 정보수정</h2>
    		    	<div class="form id">
				        <div class="col1">아이디</div>
				        <div class="col2">

							<?=$userid?>
				        </div>
			       	</div>
			       	<div class="clear"></div>

			       	<div class="form">
				        <div class="col1">비밀번호</div>
				        <div class="col2">
									<input type="password" name="pass" id="userpw" class="check_pw" placeholder="비밀번호"  value="<?=$pass?>" required>
							<span id="pw_check" style="color:green; font-weight:bold;">사용할 수 있는 비밀번호입니다. V</span>
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">비밀번호 확인</div>
				        <div class="col2">
							<input type="password" name="pass_confirm" id="userpw_same" class="check_same_pw" placeholder="비밀번호 확인"  value="<?=$pass?>" required>
              <span id="pw_check_same" style="color:green; font-weight:bold;">확인되었습니다. V</span>
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">이름</div>
				        <div class="col2">
							<input type="text" name="name" id="username" class="check_name" value="<?=$name?>" placeholder="ex) 홍길동"  required>
              <span id="name_check" style="color:green; font-weight:bold;">확인되었습니다. V</span>
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form email">
				        <div class="col1">이메일</div>
				        <div class="col2">
										 <input type="text" name="email1" id="Email" value="<?=$email1?>">@
			               <input type="text" id="setEmail" name="email2" style="width:150px" value="<?=$email2?>">
			               <select id="getEmail" class="" style="height:27px" onChange="setEmailValues();"/>
			                 <option value="">직접 입력</option>
			                 <option value="naver.com">naver.com</option>
			                 <option value="daum.net">daum.net</option>
			                 <option value="gmail.com">gmail.com</option>
			               </select>
			               <div>
			                 <span id="email_check" style="color:green; font-weight:bold;">확인되었습니다. V</span>
			               </div>
				        </div>
			       	</div>

							<div class="form profile">
								<div class="col1">프로필</div>
								<div class="col2">
									<textarea name="profile" id="profile" class="profile" placeholder="자기소개를 입력해주세요." cols="50" rows="10" style="margin: 5px 0 0 0 "  required><?=$profile?></textarea>
									<div>
										<span id="profile_check" style="color:green; font-weight:bold;">확인되었습니다. V</span>
									</div>
								</div>


							</div>

							<div style="margin: 170px 0 0 0">
								<li>
									<!-- 프로필사진이 업로드되면 나오는 부분 -->
									<div style="width: 150px; height: 150px; border-style: dotted; margin: 0 0 20px 110px">
										<img id="upload_profile_image" name="upload_profile_image" src="<?=$profile_img_dir?>" style="width: 150px; height: 150px;" value="" />
									</div>
										<span class="col1"> 첨부 파일</span>
										<span class="col2"><input type="file" accept=".gif, .jpg, .png" name="upfile" id="upfile"></span>
										<script type="text/javascript">
										function readURL(input) {
											if (input.files && input.files[0]) {
											var reader = new FileReader();
												reader.onload = function(e) {
													$('#upload_profile_image').attr('src', e.target.result);
													jQuery("#default_profile_img").val(e.target.result);
												}
												reader.readAsDataURL(input.files[0]);
											}
										}

										$("#upfile").change(function() {
											var fileNm = $("#upfile").val();

                              if (fileNm != "") {

                                  var ext = fileNm.slice(fileNm.lastIndexOf(".") + 1).toLowerCase();

                                  if (!(ext == "jpg" || ext == "gif" || ext == "png")) {
                                      alert("이미지파일 (.jpg, .png, .gif ) 만 업로드 가능합니다.");
                                      this.value = '';
                                      return false;
                                  }

                              }

											readURL(this);
										});
									</script>
										<div style="margin: 0 0 0 110px;">
											<input type="button" name="upfile_default" id="upfile_default" value="기본 이미지로 변경">
										</div>
										<script>
										$(function(){
											$('#upfile_default').click(function(){
												$('#upload_profile_image').attr('src','./data/pictures/default_profile_img.png');
												var a = jQuery('#upload_profile_image').attr("src");
												jQuery("#default_profile_img").val(a);
											})
										})
										</script>
										<input type="hidden" id="default_profile_img" name="default_profile_img" value="1" />
								</li>
							</div>


			       	<div class="clear"></div>
			       	<div class="bottom_line" style="margin: 20px 0 10px 0"> </div>
							<div class="button" style="margin: 0 0 100px 500px">
								<input type="button" id="button" onclick="check_input()" value="변경하기" disabled="" style="width:100px; height:40px"/>
							</div>


			       	<!-- <div class="buttons" style="margin: 0 0 100px 500px">
	                	<img style="cursor:pointer" src="./img/button_save.gif" onclick="check_input()">&nbsp;
                  		<img id="reset_button" style="cursor:pointer" src="./img/button_reset.gif"
                  			onclick="reset_form()">
	           		</div> -->
           	</form>
        	</div> <!-- join_box -->
        </div> <!-- main_content -->
	</section>
	<footer style="margin: 500px 0 0 0;">
    	<?php include "footer.php";?>
    </footer>
</body>
</html>

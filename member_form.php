<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/member.css">
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="js/idCheck.js"></script>
<script>

   function check_input()
   {
     if ((!document.member_form.userid.value)){
         alert("아이디는 반드시 입력해야 합니다.");
         document.member_form.userid.focus();
         return; //함수를 호출했던 쪽으로 다시 돌려보냄
     } else {
       document.member_form.submit(); //member_form 에 있는 것을 서버로 전부 넘겨줌
     }
   }

   // function check_id() {
   //   window.open("member_check_id.php?id=" + document.member_form.id.value,
   //       "IDcheck",
   //        "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
   //
   // }
   //아이디 체크
   $(document).ready(function(e) {
    $(".check_id").on("keyup", function(){ //check라는 클래스에 입력을 감지
      var self = $(this);
      var userid;

      if(self.attr("id") === "userid"){
        userid = self.val();
      }

      $.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
        "id_check.php",
        { userid : userid },
        function(data){
          if(data){ //만약 data값이 전송되면
            self.parent().parent().find("span").html(data); //span태그를 찾아 html방식으로 data를 뿌려줍니다.
            if(data.match("V")) {
              self.parent().parent().find("span").css("color", "green");
            } else {
              self.parent().parent().find("span").css("color", "red");
            }
            // self.parent().parent().find("span").css("color", "blue"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
          }
        }
      );
    });
   });


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
      var id_check = $("#id_check").css("color");
      var pw_check = $("#pw_check").css("color");
      var pw_check_same = $("#pw_check_same").css("color");
      var name_check = $("#name_check").css("color");
      var email_check = $("#email_check").css("color");
      var profile_check = $("#profile_check").css("color");
      if (id_check == "rgb(0, 128, 0)"
      && pw_check == "rgb(0, 128, 0)"
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
</head>
<body>
	<header>
    	<?php include "header.php";?>
    </header>
	<section>
		<!-- <div id="main_img_bar">
            <img src="./img/main_img.png">
        </div> -->
        <div id="main_content"  style="margin: 0 auto 150px">
      		<div id="join_box">
          	<form  name="member_form" method="post" action="member_insert.php" enctype="multipart/form-data">
			    <h2>회원 가입</h2>
                  <!--Ajax를 이용해서 중복체크
                  <input type="button" value="중복검사" onclick="check_id()">
				        	<a href="#"><img src="./img/check_id.gif"
				        		onclick="check_id()"></a>--> <!--#은 자기자신, 없어도 됨-->
              <div class="form id">
				        <div class="col1">아이디</div>
				        <div class="col2">
							<input type="text" name="userid" id="userid" class="check_id" placeholder="아이디"  required>
				        </div>

				        <div class="col3">
				        <!--	<a href="#"><img src="./img/check_id.gif"
				        		onclick="check_id()"></a>-->
				        </div>
                <div class="col1"></div>
                <div class="col2">
                  <span id="id_check" style="color:red">아이디는 4자 이상 10자 이내로 입력해주세요.</span>
                  </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">비밀번호</div>
				        <div class="col2">
							<input type="password" name="pass" id="userpw" class="check_pw" placeholder="비밀번호"  required>
              <span id="pw_check" style="color:red">비밀번호는 6자 이상 12자 이내로 입력해주세요.</span>
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">비밀번호 확인</div>
				        <div class="col2">
							<input type="password" name="pass_confirm" id="userpw_same" class="check_same_pw" placeholder="비밀번호 확인"  required>
              <span id="pw_check_same" style="color:red">&nbsp</span>
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">이름</div>
				        <div class="col2">
							<input type="text" name="name" id="username" class="check_name" placeholder="ex) 홍길동"  required>
              <span id="name_check" style="color:red">이름은 한글로만 입력해주세요.</span>
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form email">
				        <div class="col1">이메일</div>
				        <div class="col2">
							<input type="text" name="email1" id="Email">@
              <input type="text" id="setEmail" name="email2" style="width:150px">
              <select id="getEmail" class="" style="height:27px" onChange="setEmailValues();"/>
                <option value="">직접 입력</option>
                <option value="naver.com">naver.com</option>
                <option value="daum.net">daum.net</option>
                <option value="gmail.com">gmail.com</option>
              </select>
              <div>
                <span id="email_check" style="color:red">이메일은 반드시 입력해주세요</span>
              </div>

				        </div>

			       	</div>
              <div class="form profile">
                <div class="col1">프로필</div>
				        <div class="col2">
                  <textarea name="profile" id="profile" class="profile" placeholder="자기소개를 입력해주세요." cols="50" rows="10" style="margin: 5px 0 0 0 "required></textarea>
                  <div>
                    <span id="profile_check" style="color:red">자기소개는 반드시 입력해주세요.</span>
                  </div>
				        </div>


			       	</div>

              <div style="margin: 170px 0 0 0">
                <li>
                  <!-- 프로필사진이 업로드되면 나오는 부분 -->
                  <div style="width: 150px; height: 150px; border-style: dotted; margin: 0 0 20px 110px">
                    <img id="upload_profile_image" name="profile_image" src="./data/pictures/default_profile_img.png" style="width: 150px; height: 150px;" />
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
              <br /><br />
			       	<div class="clear"></div>
			       	<div class="bottom_line" style="margin: 20px 0 10px 0"> </div>
              <div class="button" style="margin: 0 0 100px 500px">
                <input type="button" id="button" onclick="check_input()" value="가입하기" disabled="" style="width:100px; height:40px"/>
              </div>
<!-- //location.href = 'member_insert.php'  -->

			       	<!-- <div class="buttons">
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

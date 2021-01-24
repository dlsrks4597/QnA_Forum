<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script>
function check_input() {
    if (!document.board_form.subject.value)
    {
        alert("제목을 입력하세요!");
        document.board_form.subject.focus();
        return;
    }
    document.board_form.submit();
 }
  // function check_input() {
  //     if (!document.board_form.subject.value)
  //     {
  //         alert("제목을 입력하세요!");
  //         document.board_form.subject.focus();
  //         return;
  //     }
  //     if (!document.board_form.content.value)
  //     {
  //         alert("내용을 입력하세요!");
  //         document.board_form.content.focus();
  //         return;
  //     }
  //     document.board_form.submit();
  //  }
</script>
<script type="text/javascript" src="./js/HuskyEZCreator.js" charset="utf-8"></script>
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
       <h3 id="board_title">
             게시판 > 글 쓰기
      </h3>
<?php
   $num  = $_GET["num"];
   $page = $_GET["page"];

   $con = mysqli_connect("localhost", "user1", "12345", "1505007");
   mysqli_set_charset($con, "UTF8");
   $sql = "select * from board where num=$num";
   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result);
   $name       = $row["name"];
   $subject    = $row["subject"];
   $content    = $row["content"];
   $file_name  = $row["file_name"];



?>
       <form  name="board_form" method="post" action="board_modify.php?num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data">
           <ul id="board_form">
            <li>
               <span class="col1">이름 : </span>
               <span class="col2"><?=$name?></span>
            </li>
             <li>
                <span class="col1">제목 : </span>
                <span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span>
             </li>
             <li id="text_area" style="padding-bottom: 150px;">
                <span class="col1">내용 : </span>
                <span class="col2" style="width:800px; margin: 0 -100px">
                    <textarea name="content" id="content" cols="108" rows="15"></textarea>
                    <script language="javascript">
    var oEditors = [];
    var content = '<?php echo $content ?>';

    var sLang = "ko_KR"; // 언어 (ko_KR/ en_US/ ja_JP/ zh_CN/ zh_TW), default = ko_KR
    // 추가 글꼴 목록
    //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];


    nhn.husky.EZCreator.createInIFrame({
     oAppRef: oEditors,
     elPlaceHolder: "content",
     sSkinURI: "./SmartEditor2Skin.html",
     htParams : {
      bUseToolbar : true,    // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
      bUseVerticalResizer : false,  // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
      bUseModeChanger : true,   // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
      //bSkipXssFilter : true,  // client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
      //aAdditionalFontList : aAdditionalFontSet,  // 추가 글꼴 목록
      fOnBeforeUnload : function(){
       alert("완료!");
      },
      I18N_LOCALE : sLang
     }, //boolean
     fOnAppLoad : function(){
      //예제 코드
      oEditors.getById["content"].exec("PASTE_HTML", [content]);
     },
     fCreator: "createSEditor2"
    });



    function pasteHTML(filepath) {

    // var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
     var sHTML = '<span style="color:#FF0000;"><img src="'+filepath+'"></span>';
     oEditors.getById["content"].exec("PASTE_HTML", [sHTML]);



    }



    function showHTML() {
     var sHTML = oEditors.getById["content"].getIR();
     alert(sHTML);
    }

    function submitContents(elClickedObj) {
      oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.

        try {
          var form2 = document.board_form;
            if (!form2.subject.value) {
             alert("제목을 입력해 주십시오");
             form2.subject.focus();
             return;
            }

                elClickedObj.form.submit();
              } catch(e) {}
                }

     // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.

    //  try {
    //
    //   var form2 = document.f;
    //   if (!form2.name.value) {
    //    alert("작성자 이름을 입력해 주십시오");
    //    form2.name.focus();
    //    return;
    //   }
    //
    //
    //
    //   if (!form2.subject.value) {
    //    alert("글제목을 입력해 주십시오.");
    //    form2.subject.focus();
    //    return;
    //   }
    //
    //
    //
    //   if (document.getElementById("content").value=="<p><br></p>") {
    //    alert("내용을 입력해 주세요.");
    //    oEditors.getById["content"].exec("FOCUS",[]);
    //    return;
    //   }
    //
    //
    //
    //   form2.action="notice_write_ok.php";
    //   //elClickedObj.form.submit();
    //   form2.submit();
    //  } catch(e) {alert(e);}
    // }



    function setDefaultFont() {
     var sDefaultFont = '궁서';
     var nFontSize = 24;
     oEditors.getById["content"].setDefaultFont(sDefaultFont, nFontSize);
    }


    function writeReset() {
     document.f.reset();
     oEditors.getById["content"].exec("SET_IR", [""]);

    }
    // $("#savebtn").click(function(){
    //         // 에디터의 내용을 에디터 생성시에 사용했던 textarea에 넣어준다.
    //         // if($("input[name='subject']").val() ==""){
    //         //     alert('제목을 입력하세요');
    //         //     $("input[name='subject']").focus();
    //         //     return false;
    //         // }
    //
    //         // 이부분에 에디터 validation 검증
    //         var ir1_data = oEditors.getById['content'].getIR();
    //         var checkarr = ['<p>&nbsp;</p>','&nbsp;','<p><br></p>','<p></p>','<br>'];
    //         if(jQuery.inArray(content_data.toLowerCase(), checkarr) != -1){
    //             alert("내용을 입력해 주십시오.");
    //             oEditors.getById["content"].exec('FOCUS');
    //             return false;
    //         }
    //
    //         // id가 ir1인 에디터의 내용이 textarea에 적용됨
    //         oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
    //
    //         //폼 submit
    //         $("#writeForm").submit();
    //     });
    </script>
                </span>
             </li>
              </ul>
          <ul class="buttons"><br /><br /><br /><br /><br /><br />
            <li><input type="submit" onclick="submitContents(this)" value="전송" style="width: 50px; height:33px"/></li>
            <!-- <li><button type="button" onclick="check_input()">수정하기</button></li> -->
            <li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
         </ul>
       </form>
   </div> <!-- board_box -->
</section>
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>

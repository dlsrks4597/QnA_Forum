<?php
    $userid   = $_POST["userid"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];
    $profile  = $_POST["profile"]; //프로필
    $default_profile_img = $_POST["default_profile_img"];
    // $profile_img = $_POST["profile_image"];

    // $upfile     = $_FILES["upfile"]["type"]; //이미지를 업로드했다면 타입을 판별하기 위한 용도
    // $upfile_type = explode("/", $upfile);
    // $upfile_type_is = $upfile_type[1];
    //
    // if ($upfile_type_is == "gif") {
    //   $profile_img_type = ".gif";
    // } else if ($upfile_type_is == "png") {
    //   $profile_img_type = ".png";
    // } else {
    //   $profile_img_type = ".jpg";
    // }
    //
    // $profile_img_name = date("Y_m_d_H_i_s").$profile_img_type;
    // $profile_img_name_dir = './data/pictures/'.$profile_img_name;

    $ipaddr  = $_SERVER['REMOTE_ADDR'];

    $email = $email1."@".$email2;
    $tier = '0.gif';
    $tier_dir = './img/tier/'.$tier;
    // $tier = explode(".", $tier_dir);
    // $tier_name_explode = explode("/", $tier[1]); // /img/tier/0
    // $tier_name = $tier_name_explode[3];
    // $tier_type = $tier[2];
    // $tier_copied = $tier_name_explode[3].".".$tier[2];
    //$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장





    $upload_dir = './data/pictures/';

    $upfile_name	 = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type     = $_FILES["upfile"]["type"];
    $upfile_size     = $_FILES["upfile"]["size"];
    $upfile_error    = $_FILES["upfile"]["error"];
$profile_img = '';
    if ($upfile_name && !$upfile_error)
    {
      $file = explode(".", $upfile_name); // . 단위로 뜯어냄
      $file_name = $file[0];
      $file_ext  = $file[1];

      $new_file_name = date("Y_m_d_H_i_s");
      $new_file_name = $file_name.$new_file_name;
      //파일을 올렸을 때 중복이 되면 데이터에 저장이 안될 수 있으므로 뒤에 업로드날짜정보를 붙여서 저장한다.
      $copied_file_name = $new_file_name.".".$file_ext;
      $uploaded_file = $upload_dir.$copied_file_name;

      $profile_img = $copied_file_name;
      $profile_img_dir = $uploaded_file;

      // if ($upfile_name == "") { //프로필 사진을 안올렸을 경우
      //   $profile_img = "default_profile_img.png";
      //   $profile_img_dir = $upload_dir.$profile_img;
      // } else { //올렸을 경우
      //   $profile_img = $copied_file_name;
      //   $profile_img_dir = $uploaded_file;
      // }



      if( $upfile_size  > 1000000000 ) { //용량제한
          echo("
          <script>
          alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
          history.go(-1)
          </script>
          ");
          exit;
      }

      if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) ) //문제가 발생했을 시
      {
          echo("
            <script>
            alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
            history.go(-1)
            </script>
          ");
          exit;
      }
    }
    else //문제가 없으면 DB에 데이터 저장
    {

      $upfile_name      = "";
      $upfile_type      = "";
      $copied_file_name = "";
    }

    $con = mysqli_connect("localhost", "user1", "12345", "1505007"); //db연결
    mysqli_set_charset($con, 'utf8');

	$sql = "insert into members(id, pass, name, email, level, point, tier, tier_dir, profile, profile_img, profile_img_dir) ";

  if($profile_img == "") {
    $profile_img = "default_profile_img.png";
    $profile_img_dir = $upload_dir.$profile_img;
  }
  if ($default_profile_img == "./data/pictures/default_profile_img.png") {
    $profile_img = 'default_profile_img.png';
    $profile_img_dir = './data/pictures/default_profile_img.png';
  }

	$sql .= "values('$userid', '$pass', '$name', '$email',  0, 0, '$tier', '$tier_dir', '$profile', '$profile_img', '$profile_img_dir')"; //.= 문자열 결합 (x = x."문자열")



	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
    mysqli_close($con);

    session_start();
      $_SESSION["userid"] = $userid;
      $_SESSION["pass"] = $pass;

    echo("
      <script>
        location.href = 'login_auto.php';
      </script>
    ");
    // echo "
	  //     <script>
	  //         location.href = 'index.php';
	  //     </script>
	  // ";//강제이동
?>

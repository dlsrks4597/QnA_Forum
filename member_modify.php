<?php
    $id = $_GET["id"];

    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];
    $profile = $_POST["profile"];
		$default_profile_img = $_POST["default_profile_img"];
		// $profile_img_dir = $_POST["profile_img_dir"];

    $email = $email1."@".$email2;



    $upload_dir = './data/pictures/';

    $upfile_name	 = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type     = $_FILES["upfile"]["type"];
    $upfile_size     = $_FILES["upfile"]["size"];
    $upfile_error    = $_FILES["upfile"]["error"];

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
      $profile_img = '';
      $profile_img = $copied_file_name;
      $profile_img_uploaded = $copied_file_name;
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





    $con = mysqli_connect("localhost", "user1", "12345", "1505007");
    mysqli_set_charset($con, 'utf8');
    // $sql = "select * from members where id=$id";
    // $result = mysqli_query($con, $sql);
  	// $row = mysqli_fetch_array($result);

    // $profile_img       = $row["profile_img"];
    // $profile_img_dir = $upload_dir.$profile_img;


    if($profile_img == "") {
      $sql = "update members set pass='$pass', name='$name' , email='$email', profile='$profile'";
      $sql .= " where id='$id'";
    } else {
      $sql = "update members set pass='$pass', name='$name' , email='$email', profile='$profile', profile_img='$profile_img', profile_img_dir='$profile_img_dir' ";
      $sql .= " where id='$id'";
    }

    if ($default_profile_img == "./data/pictures/default_profile_img.png") {
      $sql = "update members set pass='$pass', name='$name' , email='$email', profile='$profile', profile_img='default_profile_img.png', profile_img_dir='./data/pictures/default_profile_img.png' ";
      $sql .= " where id='$id'";
    }

    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>

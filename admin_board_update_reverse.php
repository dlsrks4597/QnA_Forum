<?php
    session_start();
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if ( $userlevel != -1 )
    {
        echo("
                    <script>
                    alert('관리자가 아닙니다! 공지사항 게시는 관리자만 가능합니다!');
                    history.go(-1)
                    </script>
        ");
                exit;
    }

    if (isset($_POST["item"])) //체크된 것이 있는지 확인
        $num_item = count($_POST["item"]); //체크한 것 개수 확인
    else
        echo("
                    <script>
                    alert('공지사항으로 게시할 게시글을 선택해주세요!');
                    history.go(-1)
                    </script>
        ");

    $con = mysqli_connect("localhost", "user1", "12345", "1505007");

    for($i=0; $i<count($_POST["item"]); $i++){ //개수만큼 for반복문 돌려서 삭제
        $num = $_POST["item"][$i];

        $sql = "select * from board where num = $num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $copied_name = $row["file_copied"]; //게시글의 첨부파일도 삭제하기 위해 불러옴

        if ($copied_name)
        {
            $file_path = "./data/".$copied_name; //삭제할 데이터 경로
            unlink($file_path);
        }

        $sql = "update board set importance = 0 where num = $num";
        mysqli_query($con, $sql);
    }

    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<style>
h3 {
   padding-left: 5px;
   border-left: solid 5px #58D3F7;
}
#close {
   margin:20px 0 0 80px;
   cursor:pointer;
}
table {
  margin: 0 0 0 50px;
  border-style: groove;
}
tr {
  border: 1px solid;
}
td {
  padding: 10px 20px 10px 20px;
  text-align: center;
  border: 1px solid;
}
</style>
<!--  $levelup_to_1 = 1000;
      $levelup_to_2 = 3000;
      $levelup_to_3 = 6000;
      $levelup_to_4 = 10000;
      $levelup_to_5 = 15000;
      $levelup_to_6 = 20000;
      $levelup_to_7 = 30000;
      $levelup_to_8 = 50000;
      $levelup_to_9 = 100000; -->
</head>
<body>
<h3>레벨</h3>
<p>
</p>
  <table style="">
    <tr>
      <td>레벨</td>
      <td>아이콘</td>
      <td>조건포인트</td>
      <td>비고</td>
    </tr>
    <?php
          $levelup_to_0 = 0;
          $levelup_to_1 = 1000;
          $levelup_to_2 = 3000;
          $levelup_to_3 = 6000;
          $levelup_to_4 = 10000;
          $levelup_to_5 = 15000;
          $levelup_to_6 = 20000;
          $levelup_to_7 = 30000;
          $levelup_to_8 = 50000;
          $levelup_to_9 = 100000;
          $point = 0;

          for ($i = 0; $i < 10; $i++) {
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><img src="./img/tier/<?= $i ?>.gif" /></td>
                <?php
                  if ($i == 0) {
                    $point = $levelup_to_0;
                  } else if ($i == 1) {
                    $point = $levelup_to_1;
                  } else if ($i == 2) {
                    $point = $levelup_to_2;
                  } else if ($i == 3) {
                    $point = $levelup_to_3;
                  } else if ($i == 4) {
                    $point = $levelup_to_4;
                  } else if ($i == 5) {
                    $point = $levelup_to_5;
                  } else if ($i == 6) {
                    $point = $levelup_to_6;
                  } else if ($i == 7) {
                    $point = $levelup_to_7;
                  } else if ($i == 8) {
                    $point = $levelup_to_8;
                  } else if ($i == 9) {
                    $point = $levelup_to_9;
                  }
                ?>
                <td><?=$point?></td>
                <td> - </td>
            </tr>
            <?php
          }
    ?>
    <tr>
      <td>관리자</td>
      <td><img src="./img/tier/admin.gif" /></td>
      <td> - </td>
      <td> - </td>
    </tr>
  </table>
<div id="close">
   <button value="" onclick="javascript:self.close()" style="margin: 0 0 0 290px; width:50px; height:33px;">닫기</button>
</div>
</body>
</html>

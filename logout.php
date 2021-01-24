<?php
  session_start();
  unset($_SESSION["userid"]); //$_SESSION["userid"] = "" 와 같음
  unset($_SESSION["username"]);
  unset($_SESSION["userlevel"]);
  unset($_SESSION["userpoint"]);

  echo("
       <script>
          location.href = 'index.php';
         </script>
       ");
?>

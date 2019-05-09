<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: index.php?success=Logout%20Succesful");
   }
?>
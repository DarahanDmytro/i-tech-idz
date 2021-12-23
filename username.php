<?php
  if(isset($_COOKIE["username"])){
      echo <<< ID
       <h1 style="display: flex; margin-left: 30%; align-self: start;"> 
       Користувач: {$_COOKIE["username"]}
       </h1>
      ID;
  }
?>
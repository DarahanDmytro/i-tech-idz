<?php
  if(isset($_POST["username"])){
      $mysqli = new mysqli("127.0.0.1", "root", "", "users", 3307);
      $username = $_POST['username'];
      $username = $mysqli->real_escape_string($username);
      $usrename = htmlspecialchars($username);
      $mysqli->query("INSERT INTO users(username) VALUE('$username')");
      mkdir($username);
      setcookie("username",@$_POST["username"]);
      header('Location: index.php');
      exit;
   }
  if(isset($_POST["text"])){
      $mysqli = new mysqli("127.0.0.1", "root", "", "users", 3307);
      $username = $_COOKIE['username'];
      $username = $mysqli->real_escape_string($username);
      $usrename = htmlspecialchars($username);
      $id = $mysqli->query("SELECT id FROM users WHERE username='$username'")->fetch_object()->id;
      $file = $_POST['theme'];
      $file = $mysqli->real_escape_string($file);
      $file = htmlspecialchars($file);
      $mysqli->query("INSERT INTO records(user_id,file) VALUE('$id','$file')");
      $file = $username.'\\'.$file.'.txt';
      $fn = fopen($file,'w');
      fwrite($fn, $_POST['text']);
      fclose($fn);
      header('Location: index.php');
      exit;
   }
?>
<!doctype html>
<html lang="ru">
<head>
   <title>IДЗ Дараган</title>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="styles/mainstyle.css">
</head>
<body>
  <header>
  <h1>Iндивiдуальне домашнє завдання <br> Дараган Дмитро КІУКІ-19-5</h1>
  <?php
    include "username.php";
  ?>
  </header>
  <main>
  <?php
    if(isset($_COOKIE["username"])){
        echo <<< ID
          <div id="blog">
          <h1>Блог</h1> 
          <form action="index.php" method="POST" class="blogpost">
          <h3>Додати запис</h3>
         <input type="text" name="theme">
           <textarea name="text" cols="40"></textarea>
           <input type="submit" value="Додати">
        </form>
        ID;
        $mysqli = new mysqli("127.0.0.1", "root", "", "users", 3307);
        $username = $_COOKIE['username'];
        $username = $mysqli->real_escape_string($username);
        $usrename = htmlspecialchars($username);
        $id = $mysqli->query("SELECT id FROM users WHERE username='$username'")->fetch_object()->id;
        $result = $mysqli->query("SELECT file FROM records WHERE user_id='$id'");
        while($row = $result->fetch_assoc()) {
             $theme = $row['file'];
             $file = $username.'\\'.$theme.'.txt';
             $fn = fopen($file,'r');
             $text = fread($fn, filesize($file));
             $text = htmlspecialchars($text);
             fclose($fn);
             echo <<< ID
               <div class="blogpost">
                 <h3>$theme</h3>
                 $text
               </div>
             ID;
         }
     echo '</div>';
  }
  ?>
  <aside>
  <form action="index.php" method="POST">
     <h2>Зареєєструйтеся</h2>
     <input type="text" name="username">
     <input type="submit" value="Зареєєструватися">
     <p>
      Зареєстровані користувачі можуть вести блог
     </p>
  </form>
  </aside>
 </main>
  <footer>
      <a href="https://dec.nure.ua/ru/">
	<img src="images/magic.gif" alt="Відвідай Хогвартс">
      </a>
  </footer>
</body>
</html>
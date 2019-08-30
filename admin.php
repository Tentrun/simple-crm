<?php
require "db.php";



$data=$_POST;
if(isset($data['do_login']) )
{
  $errors=array();

  $user = R::findOne('users', 'login = ?', array($data['user']));
  $admin = $user->admin == 1;

  if($user)
  {
    if(password_verify($data['pass'], $user->password))
    {
    	if($admin)
    	{
      $_SESSION['logged_admin'] = $user;
   header ('Location: /adminpanel.php');  
   exit();
   }
   else
   {
   	$errors[] = 'Вы не являетесь членом нашей команды!';
   }   
    }
    else
    {
      $errors[] = 'Пароль введен неверно!';
    }
  }
  else
  {
    $errors[] = 'Пользователь с таким логином не существует!';
  }
}

if (!empty($errors))
{
      echo '<center><font face ="Roboto" color="#ff0033" size = "6">'.array_shift($errors).'</font></center><hr>';
}


?>

<?php if(isset($_SESSION['logged_admin'])) : ?>
 <meta http-equiv="refresh" content="0;URL=/adminpanel.php" />


<?php endif; ?> 


<!DOCTYPE html>
<html lang="ru" >
<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="https://use.typekit.net/prl1ykq.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700'>
<link rel="stylesheet" href="./styles/auth.css">
<meta name="viewport" content="initial-scale=0.9, viewport-fit=cover">

<head>
  <meta charset="UTF-8">
  <title>RAMPCREMONT</title>

</head>
<body>

<div class="box">
  <div id="header">
    <div id="cont-lock"><i class="material-icons lock">Авторизация</i></div>
    <div id="bottom-head"><h1 id="logintoregister"></h1></div>
  </div> 
   <form action="" method="post">
    <div class="group">      
      <input class="inputMaterial" name="user" type="text" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Логин</label>
    </div>

	    <div class="group">      
      <input class="inputMaterial" name="pass" type="password" required >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Пароль</label>
    </div>

    <button id="buttonlogintoregister" name="do_login" type="submit">Войти</button>
  </form>
  <div id="footer-box"><p class="footer-text">Вход посторонним воспрещен!</p></div>
</div>



</div>

</body>
</html>
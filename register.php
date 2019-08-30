<?php

require "db.php";


$data=$_POST;



if( isset($data['do_signup']) )
{

$errors = array();


  if($data['pass2'] != $data['pass'])
  {
    $errors[] = 'Повторный пароль указан неверно';
  }

  if(R::count('users', "login = ?", array($data['user'])) > 0 )
  {
    $errors[] = 'Указанный логин уже существует';
  }

  if(R::count('users', "email = ?", array($data['mail'])) > 0 )
  {
    $errors[] = 'Этот адрес электронной почты уже зарегистрирован';
  }



 if (empty($errors))
  {
  $user = R::dispense('users');
  $user->login = $data['user'];
  $user->email = $data['mail'];
  $user->password = password_hash($data['pass'],PASSWORD_DEFAULT);
  R::store($user);
  $user = R::findOne('users', 'login = ?', array($data['user']));
    if($user)
  {
    if(password_verify($data['pass'], $user->password))
    {
      $_SESSION['logged_user'] = $user;
    }
  }
   header ('Location: /cabinet.php');  
   exit();  
  }
  else
  {
  	echo '<center><font face ="Roboto" color="#ff0033" size = "6">'.array_shift($errors).'</font></center><hr>';
  }
}

?>


<!DOCTYPE html>
<html lang="ru" >
<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="https://use.typekit.net/prl1ykq.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700'>
<link rel="stylesheet" href="./styles/register.css">
<meta name="viewport" content="initial-scale=0.9, viewport-fit=cover">

<head>
  <meta charset="UTF-8">
  <title>RAMPCREMONT</title>


</head>


<body>

<div class="box">
  <div id="header">
    <div id="cont-lock"><i class="material-icons lock">Регистрация</i></div>
    <div id="bottom-head"><h1 id="logintoregister"></h1></div>
  </div> 
   <form action="" method="post">
    <div class="group">      
      <input class="inputMaterial" name="user" type="text" value="<?php echo @$data['user']; ?>" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Логин</label>
    </div>

      <div class="group">      
      <input class="inputMaterial" name="mail" type="email" value="<?php echo @$data['mail']; ?>" required  >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Адрес электронной почты</label>
    </div>

	    <div class="group">      
      <input class="inputMaterial" name="pass" type="password" required >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Пароль</label>
    </div>
          <div class="group">      
      <input class="inputMaterial" name="pass2" type="password"  required >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Повторите пароль</label>
    </div>
    <button id="buttonlogintoregister" name="do_signup" type="submit">Регистрация</button>

  </form>




</div>




</body>
</html>
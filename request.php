<?php
require "db.php";

$data=$_POST;

$authorizeduser = $_SESSION['logged_user']->login; 
if (isset($data['do_request'])) {

$errors=array();

if ($data['problemselect'] == '') {
  $errors[] = 'Вы не выбрали с каким типом проблема';
  }

 if (empty($errors)){

$request= R::dispense('request');
$request->phonenumber = $data['phonenumber'];
$request->textrequest = $data['problemtextbox'];
$request->name = $data['name'];
$request->typeproblem = $data['problemselect'];
$request->user = $authorizeduser;
R::store($request);
$errorcreateorder = 'Ваша заявка успешно передана на рассмотрение';
    header("location: /cabinet.php");
    exit;  
 }
 else{ //есть ошибка
  $errorcreateorder=array_shift($errors);
}

}


?>



<?php if(isset($_SESSION['logged_user'])) : ?> 



<?php else : ?>
  <META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/auth.php"></META>
  <?php exit; ?>

<?php endif; ?>	

<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="https://use.typekit.net/prl1ykq.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700'>
<link rel="stylesheet" href="./styles/cabinet.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<meta name="viewport" content="initial-scale=0.9, viewport-fit=cover">


	<title>Личный кабинет</title>
</head>

<header>
	
<div class ="toppanel">
	<div id ="toppaneltext"><h1>RAMPCREMONT</h1></div>
	<div id ="toppaneltext2"><h3>личный кабинет</h3></div>
</div>

</header>




<body>

<div id="square"> <!-- открытие блока заявки -->
  <div id="squaretext"> Оставить заявку</div>
  <form action="" method="post">
  <div id ="errortext" style="color: red; margin-top: 3vh;"><?php echo $errorcreateorder ?></div>
    <div class="group" style="margin-top: 4vh; margin-left: 25vh;">      
      <input type="text" id="phonenumber" name="phonenumber" autocomplete="off" style="border-radius: 1vh; border: 0.5px solid #00bfff" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Ваш номер телефона</label>

  <div class="box">
    
    <select name="problemselect">
      <option value="">С чем проблема (выберите)</option>
      <option value="Телефон">Телефон</option>
      <option value="Телевизор">Телевизор</option>
      <option value="Ноутбук">Ноутбук</option>
      <option value="Компьютер">Компьютер</option>
      <option value="Моноблок">Моноблок</option>
      <option value="Компонент">Комплектующие(контроллеры, видеокарты и т.п.)</option>
      <option value="Другое">Другое</option>
    </select>
    
  </div>


    </div>
    <div class="group" style="margin-top: 4vh; margin-left: 25vh;">  
      <span class="highlight"></span>
      <span class="bar"></span>
      <textarea id="squaremsg" name="problemtextbox" required=""></textarea>
      <label>Чем мы можем вам помочь?</label>
    </div>

    <div class="group" style="margin-top: 4vh; margin-left: 25vh;">      
      <input type="text" name="name" autocomplete="off" onKeyUp="if(/[^а-яА-ЯёЁ ]/i.test(this.value)){this.value='';}" style="border-radius: 1vh; border: 0.5px solid #00bfff" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Как вас зовут?</label>

    </div>
    <button id="box" name="do_request" type="submit">
      Оставить заявку
    </button>
  </form>
<script src="js/jquery.maskedinput.min.js"></script>

<script  src="./js/dropdown.js"></script>


</div> <!-- закрытие блока заявки -->

<div class ="leftpanel" style="margin: -92vh 0 0 -10px;"> 
	        <div class="items">
         <img src="../images/cart.png" alt="" onclick="javascript:document.location.href='/cabinet.php'"> <center><div id="itemstext" onclick="javascript:document.location.href='/cabinet.php'">Мои заказы</div></center>

          <img src="../images/write.png" alt=""> <center><div id="itemstext">Оставить заявку</div></center> 
          <img src="../images/Piggy.png" alt=""> <center><div id="itemstext">Мои бонусы</div></center>
        </div>





<div class="profile">
<img src="../images/userr.png" />       
<div id ="leftpaneltext">
Вы вошли как:<br><?php echo $authorizeduser; ?>
</div>
<br>
<div id ="logout"><a href="/logout.php">Выйти</a></div>
</div>



</div>




</body>

</html>


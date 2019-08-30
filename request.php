<?php
require "db.php";

$data=$_POST;
?>



<?php if(isset($_SESSION['logged_user'])) : ?>

<?php 
$authorizeduser = $_SESSION['logged_user']->login;

?>

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


    <div class="group" style="margin-top: 4vh; margin-left: 25vh;">      
      <input type="text" id="phonenumber" name="phonenumber" autocomplete="off" style="border-radius: 1vh; border: 0.5px solid #00bfff" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Ваш номер телефона</label>

  <div class="select-box">
    
    <label for="select-box1" class="label select-box1"><span class="label-desc">С чем проблема (выберите)</span> </label>
    <select name="problemselect" id="select-box1" class="select">
      <option value="telephone">Телефон</option>
      <option value="televisor">Телевизор</option>
      <option value="notebook">Ноутбук</option>
      <option value="computer">Компьютер</option>
      <option value="monoblock">Моноблок</option>
      <option value="components">Комплектующие(контроллеры, видеокарты и т.п.)</option>
      <option value="other">Другое</option>
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
      <input type="text" name="name" autocomplete="off" style="border-radius: 1vh; border: 0.5px solid #00bfff" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Как вас зовут?</label>

    </div>
    <button id="box" name="do_request" type="submit">
      Оставить заявку
    </button>
<?php 
$problemselect = $data['problemselect']; // передача данных из селекта в переменную
echo $problemselect;


?>
  </form>
<script src="js/jquery.maskedinput.min.js"></script>

<script  src="./js/dropdown.js"></script>


</div> <!-- закрытие блока заявки -->

<div class ="leftpanel" style="margin: -97vh 0 0 -10px;"> 
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


<?php
require "db.php";

?>



<?php if(isset($_SESSION['logged_user'])) : ?>

<?php 
$authorizeduser = $_SESSION['logged_user']->login;

$orders = R::Find('orders', 'client = ?', [$authorizeduser]);
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

  <div class="wrapper">
   <div class="table">
<?php 
if(R::count('orders', ' client = ? ', [$authorizeduser]) != 0){
echo '<div class="row header">';
echo '<div class="cell">';
echo "ID";
echo '</div>';
echo '<div class="cell">';
echo "Наименование";
echo '</div>';
echo '<div class="cell">';
echo "Стоимость";
echo '</div>';
echo '<div class="cell">';
echo "Номер заказа";
echo '</div>';
echo '<div class="cell">';
echo "Дата обращения";
echo '</div>';
echo '<div class="cell">';
echo "Статус";
echo '</div>';
echo '</div>';
}
else{
$errortype = "Список заказов пуст";
}

?>

<?php
$status; //переменная статус заказа



foreach($orders as $item){
if($item['status'] == 1)
{
  $status = "Оплачено";
}
if($item['status'] == 0)
{
  $status = "Ожидает оплаты";
}
if($item['status'] == 2)
{
  $status = "Ожидает выдачи";
}
if($item['status'] == 3)
{
  $status = "В процессе восстановления";
}
if($item['status'] == 4)
{
  $status = "Ожидает диагностики";
}
 
echo '<div class="row">'; //создание элемента таблицы
echo '<div class="cell">'; //вывод строки названия
echo $item['id']; //название вывода элемента из БД
echo '</div>';
echo '<div class="cell">'; 
echo $item['name']; 
echo '</div>';
echo '<div class="cell"">';
echo $item['price'];
echo '</div>';
echo '<div class="cell">';
echo $item['number'];
echo '</div>';
echo '<div class="cell">';
echo $item['date'];
echo '</div>';
echo '<div class="cell">';
echo $status;
echo '</div>';
echo '</div>';
}



?>
</div>
  <div id ="errortext"><?php echo $errortype; ?></div>
  <div id ="errortext"><?php echo $errorcreateorder; ?></div>
</div>


<div class ="leftpanel"> 
	        <div class="items">
         <img src="../images/cart.png" alt="" onclick="javascript:document.location.href='/cabinet.php'"> <center><div id="itemstext" onclick="javascript:document.location.href='/cabinet.php'">Мои заказы</div></center>

          <img src="../images/write.png" alt="" onclick="javascript:document.location.href='/request.php'"> <center><div id="itemstext" onclick="javascript:document.location.href='/request.php'">Оставить заявку</div></center> 
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
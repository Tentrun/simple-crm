<?php
require "db.php";

$orders = R::getAll("SELECT * FROM `orders` ORDER BY id DESC");



$data=$_POST;
$errortype;

if(isset($data['do_edit'])){
$editnumber;

if ($data['editordernumber'] != '') {
  $editnumber=$data['editordernumber'];
  if(!empty($editnumber)){
    $find = R::FindOne('orders', 'number = ?', [$editnumber]);
    if($find){
      if($data['editorderstatus'] != ''){
        $find->status = $data['editorderstatus'];
      }

      if($data['editorderprice'] != ''){
        $find->price = $data['editorderprice'];
      }

      if($data['editordername'] != ''){
        $find->name = $data['editordername'];
      }

      if($data['editorderserialcode'] != ''){
        $find->serialcode = $data['editorderserialcode'];
      }

      R::store($find);
      header("Location: /adminpanel.php");
      exit;
    }
      }
    else{
      $errortype = "Введенный номер заказа не найден";
    }
}
else{
  $editnumber=$data['editorderid'];
    $find = R::FindOne('orders', 'id = ?', [$editnumber]);
    if($find){

      if($data['editorderstatus'] != ''){
        $find->status = $data['editorderstatus'];
      }

      if($data['editorderprice'] != ''){
        $find->price = $data['editorderprice'];
      }

      if($data['editordername'] != ''){
        $find->name = $data['editordername'];
      }

      if($data['editorderserialcode'] != ''){
        $find->serialcode = $data['editorderserialcode'];
      }

      R::store($find);
      header("Location: /adminpanel.php");
      exit;
    }
    else{
      $errortype = "Введенный ID заказа не найден";
    }
  }
}

if(isset($data['do_deleteorder'])) //удалить заказ
{ 
$deletenumbers;

if ($data['deleteordernumber'] != '') {
  $deletenumbers=$data['deleteordernumber'];
    $find = R::FindOne('orders', 'number = ?', [$deletenumbers]);
    if($find){

   R::trash($find);
   header ('Location: /adminpanel.php');  
   exit();
    }
    else{
      $errortype = "Введенный номер заказа не найден";
    }
}
else{
  $deletenumbers=$data['deleteorderid'];
    $find = R::FindOne('orders', 'id = ?', [$deletenumbers]);
    if($find){

   R::trash($find);
      header("Location: /adminpanel.php");
      exit;
    }
    else{
      $errortype = "Введенный ID заказа не найден";
    }

}

}

if( isset($_POST['do_create']) ) //если нажата кнопка 'добавить'
{

  $errors=array();

  if($data['status'] > 4)
  {
    $errors[] = 'Статус заказа не может быть больше цифры 4';
  }

  if($data['status'] < 0)
  {
    $errors[] = 'Статус заказа не может быть меньше цифры 0';
  }

  if($data['number'] < 1000)
  {
    $errors[] = 'Код отслеживания не может быть меньше 4-х цифр';
  }

 if (empty($errors)){ //нету ошибок


$order = R::dispense('orders');
$order->name = $data['name'];
$order->price = $data['price'];
$order->number = $data['number'];
$order->date = date("Y-m-d");
$order->status = $data['status'];
$order->serialcode = $data['serialcode'];
$order->client = $data['client'];
$order->clientorder = $data['clientorder'];
R::store($order);
   header("location: /adminpanel.php");
   exit;  
 }
else{ //есть ошибка
  $errorcreateorder=array_shift($errors);
}

}


?>

<?php if(isset($_SESSION['logged_admin'])) : ?>
 
<?php else : ?>
  <?php
  exit;
  ?>

<?php endif; ?> 

<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="https://use.typekit.net/prl1ykq.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700'>
<link rel="stylesheet" href="./styles/admincabinet.css">

  
<script type="text/javascript">
function openbox(id){
    if(document.getElementById(id).style.display=='none'){
       document.getElementById(id).style.display='inline-block';
    }else{
       document.getElementById(id).style.display='none';
    }
}
</script>

  <title>Личный кабинет</title>
</head>

<header>
  
<div class ="toppanel">
  <div id ="toppaneltext"><h1>RAMPCREMONT</h1></div>
  <div id ="toppaneltext2"><h3>личный кабинет</h3></div>
</div>

</header>

<body>

  <div id="square3" style="display:none;">
    <div id="removeoredertext"> Редактирование заказа</div>
    <form action="" method="post">

    <div class="group">      
      <input type="number" name="editordernumber" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Номер заказа</label>
    </div>
    <div id="removeoredertext"> или</div>

    <div class="group">      
      <input type="number" name="editorderid" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>ID заказа</label>
    </div>
    <hr color="#99DFE0">
    <br>
    <div class="group">      
      <input type="number" name="editorderstatus" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Новый статус</label>
    </div>

    <div class="group">      
      <input type="number" name="editorderprice" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Новая цена</label>
    </div>

    <div class="group">      
      <input type="text" name="editordername" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Новое наименоваение</label>
    </div>

    <div class="group">      
      <input type="text" name="editorderserialcode" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Новый серийный номер</label>
    </div>

    <button id="box3"  onclick="openbox('square3'); return false">
      Закрыть
    </button>

    <button id="box3" name="do_edit" type="submit">
      Редактировать
    </button>

    </form>

  </div>

  <div id="square2" style="display:none;">
    <div id="removeoredertext"> Удаление заказа</div>
    <form action="" method="post">

        <div class="group">      
      <input type="number" name="deleteordernumber" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Номер заказа</label>
    </div>
    <div id="removeoredertext"> или</div>

        <div class="group">      
      <input type="number" name="deleteorderid" autocomplete="off">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>ID заказа</label>
    </div>

    <button id="box2" name="do_deleteorder" type="submit">
      Удалить заказ
    </button>

    </form>
    <button id="box2"  onclick="openbox('square2'); return false">
      Закрыть
    </button>
  </div>

  <div id="square" style="display:none;"> 
    <div id="removeoredertext">Добавление заказа </div>
      <form action="" method="post">
        <div class="group">      
      <input type="text" name="name" autocomplete="off" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Наименование заказа</label>
    </div>

    <div class="group">      
      <input type="number" name="price" autocomplete="off" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Цена</label>
    </div>

    <div class="group">      
      <input type="number" name="number" autocomplete="off" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Номер заказа</label>
    </div>

    <div class="group">      
      <input type="text" name="serialcode" autocomplete="off"  >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Серийный код(если имеется)</label>
    </div>

    <div class="group">      
      <input type="text" name="client" autocomplete="off"  >
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Пользователь (если зарегестрирован)</label>
    </div>

    <div class="group">      
      <input type="text" name="clientorder" autocomplete="off" required="">
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Заказчик (ФИО)</label>
    </div>

    <div class="group">      
      <input type="number" name="status" autocomplete="off" required>
      <span class="highlight"></span>
      <span class="bar"></span>
      <label>Статус заказа [0,1,2,3,4]</label>
    </div>

    <button id="box"  onclick="openbox('square'); return false">
      Закрыть
    </button>
      <button id="box" name="do_create" type="submit">Добавить</a>
    </button>
  </form>
    </div>
</div>
  <div class="wrapper">
   <div class="table">
<?php 
if(R::count('orders') != 0){
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
echo "Серийный номер";
echo '</div>';
echo '<div class="cell">';
echo "Статус";
echo '</div>';
echo '<div class="cell">';
echo "Заказчик";
echo '</div>';
echo '<div class="cell">';
echo "Дата обращения";
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
echo $item['serialcode'];
echo '</div>';
echo '<div class="cell">';
echo $status;
echo '</div>';
echo '<div class="cell">';
echo $item['clientorder'];
echo '</div>';
echo '<div class="cell">';
echo $item['date'];
echo '</div>';
echo '</div>';
}



?>
</div>
  <div id ="errortext"><?php echo $errortype ?></div>
  <div id ="errortext"><?php echo $errorcreateorder ?></div>

  </div>

</div>


  <div class ="leftpanel"> 
        <div class="items">
          <img src="../images/cart.png" ondragstart="return false;" alt="" onclick="javascript:document.location.href='/adminpanel.php'"> <center><div id="itemstext" onclick="javascript:document.location.href='/adminpanel.php'">Все заказы</div></center> 
          <img src="../images/plus.png" ondragstart="return false;" onclick="openbox('square'); return false"> <center><div id="itemstext" onclick="openbox('square'); return false">Добавить заказ</div></center>
          <img src="../images/edit.png" ondragstart="return false;" onclick="openbox('square3'); return false"> <center><div id="itemstext" onclick="openbox('square3'); return false">Редактировать заказ</div></center>
          <img src="../images/minus.png" ondragstart="return false;" onclick="openbox('square2'); return false" alt=""> <center><div id="itemstext" onclick="openbox('square2'); return false" >Удалить заказ</div></center> 
          <img src="../images/view.png" ondragstart="return false;" alt="" onclick="javascript:document.location.href='/adminrequest.php'"> <center><div id="itemstext" onclick="javascript:document.location.href='/adminrequest.php'">Заявки</div></center>
        </div>





        <div class="profile">
            <img src="../images/userr.png" />       
          <div id ="leftpaneltext">
              Вы вошли как:<br><?php echo $_SESSION['logged_admin']->login; ?>
          </div>
              <br>
              <div id ="logout"><a href="/adminlogout.php">Выйти</a></div>
        </div>
  </div>




</body>

</html>
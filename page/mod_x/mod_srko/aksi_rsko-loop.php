<?php
 // panghil koneksi
 require_once __DIR__.'/koneksi.php';


 // loop data field dari inputan
 foreach ($_POST['name'] as $key=>$val) {
  $name = $_POST['name'][$key];
  $address = $_POST['address'][$key];

  // insert to mysql
  $sql = 'INSERT INTO users SET';
  $sql .= ' name="'.$name.'",';
  $sql .= ' address="'.$address.'"';
  mysql_query($sql) or die ($sql);
 }

 // kembalikan ke index
 header('Location: index.php');
?>
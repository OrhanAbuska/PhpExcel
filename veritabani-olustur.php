<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_adi=$_POST['db_adi'];

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_adi."";
    $conn->exec($sql);
    $sql = "use ".$db_adi;
    $conn->exec($sql);
    $tablo_adi = "deneme_tablo";#$_POST['tablo_adi'];
    $index_id = "deneme_id;";#$_POST['index_id'];
    $sutun1="sütun-1";#$_POST['sutun1'];
    $sutun2="sütun-2";#$_POST['sutun2'];
    $sutun3="sütun-3";#$_POST['sutun3'];
    $sutun4="sütun-4";#$_POST['sutun4'];
    $sutun5="sütun-5";#$_POST['sutun5'];

    $sql = 'CREATE TABLE IF NOT EXISTS '.$tablo_adi.' (
                '.$index_id.' int(11) AUTO_INCREMENT PRIMARY KEY,
                '.$sutun1.' varchar(100) NOT NULL, 
                '.$sutun2.' varchar(100) NOT NULL, 
                '.$sutun3.' varchar(100) NOT NULL, 
                '.$sutun4.' varchar(100) NOT NULL, 
                '.$sutun5.' varchar(100) NOT NULL, )';
    $conn->exec($sql);
    echo "veritabanı oluşturuldu.";
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
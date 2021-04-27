<?php
require_once '../ortak/baglanti.php';
if (isset($_POST['dosya_sil'])){
    $dosya_id=$_POST['file_id'];
    $dosyasil=$baglanti->prepare("DELETE FROM file WHERE file_id=:file_id");
    $sonuc=$dosyasil->execute(array(
        'file_id'=>$dosya_id
    ));

    if ($sonuc) {
        header("location:index.php?durum=islem_basarili");
        exit;
    } else {
        header("location:index.php?durum=islem_basarisiz");
        exit;

    }


}
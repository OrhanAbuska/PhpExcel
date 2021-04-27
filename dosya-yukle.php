<?php
require '../vendor/autoload.php';
require '../fonksiyonlar/fonksiyonlar.php';


if ($_FILES["dosya_excel"]) {
    $yol = "diji-dosya";
    $yuklemeYeri = __DIR__ . DIRECTORY_SEPARATOR . $yol . DIRECTORY_SEPARATOR . $_FILES["dosya_excel"]["name"];
    if ( file_exists($yuklemeYeri) ) {
        echo "Dosya daha önceden yüklenmiş";
    } else {
        if ($_FILES["dosya_excel"]["size"]  > 10000000) {
            echo "Dosya boyutu sınırı";
        } else {
            $dosyaUzantisi = pathinfo($_FILES["dosya_excel"]["name"], PATHINFO_EXTENSION);
            if ($dosyaUzantisi != "xls" && $dosyaUzantisi != "xlsx") { # Dosya uzantı kontrolü
                echo "Sadece xls ve xlsx uzantılı dosyalar yüklenebilir.";
            } else {
                $sonuc = move_uploaded_file($_FILES["dosya_excel"]["tmp_name"], $yuklemeYeri);

                if ($sonuc){

                    $inputFileName = $yuklemeYeri;

                    /**  Identify the type of $inputFileName  **/
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                    /**  Create a new Reader of the type that has been identified  **/
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    /**  Load $inputFileName to a Spreadsheet Object  **/
                    $spreadsheet = $reader->load($inputFileName);
// Retrieve the worksheet called 'Worksheet 1'
                    $spreadsheet->getSheetByName('Agent_Edited');
                    $worksheet = $spreadsheet->getActiveSheet();
// Get the highest row and column numbers referenced in the worksheet
                    $highestRow = $worksheet->getHighestRow(); // e.g. 10
                    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5


                    foreach($spreadsheet as $row) {
                        // get columns
                        for ($say=0;$say<=$highestColumnIndex;$say++){
                            $kolon_adi=$row[$say];
                            // insert item
                            $query = $baglanti->prepare("INSERT INTO thalia SET ".$kolon_adi."=:kolonadi");
                            $query->execute(array(
                                'kolonadi'=>$kolon_adi
                            ));

                        }
                    }
                }

                echo $sonuc ? "Dosya başarıyla yüklendi" : "Hata oluştu";
                echo "<hr>";
                echo '<table>' . "\n";
                for ($row = 1; $row <= $highestRow; ++$row) {
                    echo '<tr>' . PHP_EOL;
                    for ($col = 1; $col <= $highestColumnIndex; ++$col) {

                        $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                        echo '<td>' . $value . '</td>' . PHP_EOL;
                    }
                    echo '</tr>' . PHP_EOL;
                }
                echo '</table>' . PHP_EOL;



            }
        }
    }
} else {
    echo "Lütfen bir dosya seçin";
}

?>
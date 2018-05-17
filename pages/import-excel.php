<?php

require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn_batch'])) {
    /**
     * $directory digunakan untuk tempat file di server
     * @var string
     */
    $directory = 'file/';

    /**
     * $fileName name yang didapat dari variabel $_FILES -> name
     * gunakan var_dump($_FILES) untuk melihat array yang ditangkap
     * oleh fungsi $_FILES
     * @var string
     */
    $fileName = $_FILES['file_excel']['name'];

    /**
     * $fileName name yang didapat dari variabel $_FILES -> tmp_name
     * @var string
     */
    $fileTmp = $_FILES['file_excel']['tmp_name'];

    /**
     * $moveToServer kunjungi situs php.net -> move_uploaded_file
     * @var boolean
     */
    $moveToServer = move_uploaded_file($fileTmp, $directory.$fileName);


    if ($moveToServer) {
        $inputFileName = 'file/'.$fileName;
        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);
        } catch (Exception $e) {
            die('Error: '. $e->getMessage());
        }

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        /**
         * Perulangan menggunakan for karena sudah diketahui total baris dan total kolom
         * digunakan untuk query insert ke database
         */
        for ($row=1; $row <= $highestRow ; $row++) {
            $rowData = $worksheet->rangeToArray(
                'A'.$row.':'.$highestColumn.$row, null, true, false
            );

            /**
             * Perbandingan untuk skip row pertama karena sebagai judul
             * bukan sebagai data
             */
            if ($row == 1) {
                continue;
            }

            /**
             * Nilai yang didapat dimasukkan ke variabel untuk masing-masing field
             */
            $title = $rowData[0][0];
            $content = $rowData[0][1];
            $date = $rowData[0][2];

            /**
             * Perbandingan untuk validasi ketika cell kosong maka baris data dilewati
             */
            if (empty($title) || empty($content) || empty($date)) {
                continue;
            }

            /**
             * Fungsi insert dijalankan
             */
            try {
                $var_sql_insert = "
                INSERT INTO article(article_title, article_content, article_date)
                VALUES ('{$title}', '{$content}', '{$date}')
                ";
                $var_query_insert = mysqli_query($var_con, $var_sql_insert);
            } catch (\Exception $e) {
                die('Error: '. $e->getMessage());
            }
        }

        /**
         * Hapus file yang diupload
         */
        unlink('file/'. $fileName);
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Import batch data</title>
</head>
<body>
    <form action="import-excel.php" method="post" enctype="multipart/form-data">
        <label for="file_excel">File Xls</label><br>
        <input type="file" name="file_excel" id="file_excel">
        <br><br>
        <button type="submit" name="btn_batch">Simpan</button>
    </form>
</body>
</html>

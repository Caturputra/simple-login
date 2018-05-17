<?php

$var_option = isset($_GET['option']) ? $_GET['option'] : "";

$var_directory = "directory/";

switch ($var_option) {
    case 'create':
        if (fopen($var_directory. 'test.txt', 'w')) {
            echo 'File berhasil dibuat';
        }
    break;

    case 'write':
        //menulis file dengan truncate isinya terlebih dahulu
        $file = fopen($var_directory. 'test.txt', 'a+');
        if ($file) {
            fwrite($file, 'daud alex daud mawud' ."\n");
        }
        fclose($file);
    break;

    case 'read':
        $file = fopen($var_directory . 'test.txt', 'r');
        while (!feof($file)) {
            $content = fgets($file, 4096);
            echo $content . "<br>";
        }
        fclose($file);
    break;

    case 'copy':
        $var_operation = copy($var_directory. 'test.txt', $var_directory. 'test-new.txt');
        if ($var_operation) {
            echo "File berhasil disalin.";
        }
    break;

    case 'rename':
        $var_operation = rename($var_directory. 'test-new.txt', $var_directory. 'rename-test-new.txt');
        if ($var_operation) {
            echo "File berhasil diubah.";
        }
    break;

    case 'delete':
        if (file_exists($var_directory . 'rename-test-new.txt')) {
            unlink($var_directory. 'rename-test-new.txt');
        } else {
            echo 'Tidak ada file terhapus.';
        }
    break;

    case 'readdir':
        if (is_dir($var_directory)) {
            $var_open = opendir($var_directory);
            while ($var_dir = readdir($var_open)) {
                    echo '<a target="_blank" href="'.$var_directory.$var_dir.'">'.$var_dir.'</a><br>'."\n";
            }
        } else {
            echo 'Bukan direktori.';
        }
    break;
}

<?php
    include("menu.html");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border='1'>
    <?php
    // ファイルを変数に格納
    $filename = "./stocklist.csv";
    // fopenでファイルを開く（'r'は読み込みモードで開く）
    $fp = fopen($filename, 'r');    
    // stocklist.csvの行を1行ずつ読み込みます。
    while ($list = fgetcsv($fp)) {    
        # code...
        echo "<tr>";
        for($i=0; $i < count($list); ++$i){
            $elem = mb_convert_encoding($list[$i], 'UTF-8', 'SJIS');
            echo("<td>".$elem."</td>");
        }
        echo "</tr>";
    }
    // fcloseでファイルを閉じる
    fclose($fp);

    ?>
    </table>
</body>
</html>
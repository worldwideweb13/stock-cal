<?php
$tempfile = $_FILES['fname']['tmp_name'];
var_dump($tempfile);
$filename = 'csv/'.$_FILES['fname']['name'];
var_dump($filename);
if(is_uploaded_file($tempfile)){
    if(move_uploaded_file($tempfile,$filename)){
        echo $filename . "をアップロードしました。";                
    }else{
        echo "ファイルをアップロードできません。";
    }
} else {
    echo "ファイルが選択されていません";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // fopenでファイルを開く（'r'は読み込みモードで開く）
    $fp = fopen($filename, 'r');  
    // stocklist.csvの行を1行ずつ読み込みます。
    while ($list = fgetcsv($fp)) {
        // (1)在庫数を整数型で抜き出す
        $stock = (int)$list[4];
        // (2)SKUからプライスを整数型で抜き出す
        $sku = explode("-", $list[2]);
        $price = (int)$sku[3];
        // (1)×(2)より商品別の棚卸額を算出
        $StockAmount = $stock * $price;
        $TotalStockAmount += $StockAmount;
        // echo('<pre>');
        // var_dump($TotalStockAmount);
        // echo('</pre>');
    }
    // fcloseでファイルを閉じる
    fclose($fp);
    ?>
    <h1><?php echo "棚卸額: ".number_format($TotalStockAmount)."円"?></h1>
    <canvas id="myBarChart"></canvas>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <!-- <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: bar,
            data: {
                labels: ["1月","2月","3月","4月","5月","6月","7月","8月","9月"],
                datasets: [
                    {
                        label: '棚卸額',
                        data: [62, 65, 93, 85, 51, 66, 47],
                        backgroundColor: "rgba(219,39,91,0.5)"
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: '棚卸額'
                },
                scales: {
                    yAex: [{
                        ticks: {
                            suggestedMax: 100,
                            suggestedMin: 0,
                            stepSize: 10,
                            callback: function(value,index,values){
                                return value + '人'
                            }
                        }
                    }]
                },
            }
        });        
    </script> -->
    <script>
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['6月', '7月', '8月', '9月', '10月', '11月', '12月'],
        datasets: [
            {
            label: '棚卸額',
            data: [60, 65, 93, 85, <?php echo $TotalStockAmount ?>, 66, 47],
            backgroundColor: "rgba(219,39,91,0.5)"
            },{
            label: '売上額',
            data: [55, 45, 73, 75, 800000, 200000, 58],
            backgroundColor: "rgba(130,201,169,0.5)"
            },{
            label: '粗利額',
            data: [33, 45, 62, 55, 100000, 130000, 38],
            backgroundColor: "rgba(255,183,76,0.5)"
            }
        ]
        },
        options: {
        title: {
            display: true,
            text: '棚卸累計額'
        },
        scales: {
            yAxes: [{
            ticks: {
                suggestedMax: 1000000,
                suggestedMin: 0,
                stepSize: 100000,
                callback: function(value, index, values){
                return  value +  '円'
                }
            }
            }]
        },
        }
    });
  </script>
    
</body>
</html>
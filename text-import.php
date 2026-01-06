<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳檔案機制
 * 3.取得檔案資源
 * 4.取得檔案內容
 * 5.建立SQL語法
 * 6.寫入資料庫
 * 7.結束檔案
 */
$dsn = "mysql:host=localhost;dbname=store;charset=utf8";
$pdo = new PDO($dsn, 'root', '');

if (!empty($_FILES['file']['tmp_name'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], "upload/{$_FILES['file']['name']}");
    $path = "upload/{$_FILES['file']['name']}";
    
    $file = fopen($path, 'r');
    $header = explode(",", trim(fgets($file)));

    $columnString = implode("`,`", $header);
    $sql = "INSERT INTO `stores` (`$columnString`)";

    echo $file;
    echo "<pre>";
    print_r($header);
    echo "</pre>";
    echo $sql;
    echo "<br>";

    $rows = 0;
    while (!feof($file)) {
        $line = trim(fgets($file));
        $line = mb_convert_encoding($line, "UTF-8", "Big5");
        echo $line;
        if (strlen($line) > 3) {
            $value = " VALUES ('" . join("','", explode(",", $line)) . "')";

            $pdo->exec($sql . $value);
            $rows++;
        }

    }

    echo "<br>";
    echo "匯入完成，總計匯入 $rows 筆資料";
    fclose($file);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="header">文字檔案匯入練習</h1>
    <!---建立檔案上傳機制--->
    <form action="?" method="post" enctype="multipart/form-data">
        <div>
            <label for="">請選擇匯入檔案(*.csv)</label>
            <input type="file" name="file" id="">
        </div>
        <div>
            <input type="submit" value="匯入">
        </div>
    </form>

    <!----讀出匯入完成的資料----->



</body>

</html>
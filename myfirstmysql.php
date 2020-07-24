<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>mission_5</title>
</head>
<body>
    
<h1>初めての掲示板</h1>



<?php

$dsn = 'mysql:dbname=*********;host=localhost';
$user = '*********';
$password = '*********';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS tbtest"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "date TEXT,"
. "pass char(32)"
.");";
$stmt = $pdo->query($sql);

if(isset($_POST["new_submit"]))
{

    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]))
    {
        if(!empty($_POST["enum"]))
        {
            $id = $_POST["enum"]; //変更する投稿番号
            $name = $_POST["name"];
            $com = $_POST["comment"];
            $date = date("Y/m/d H:i:s");
            $pass = $_POST["pass"];
            $sql = 'UPDATE tbtest SET name=:name,comment=:comment, date =:date, pass=:pass WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $com, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->execute();   
        }
        else
        {
    
            $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $com, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
            
            $name = $_POST["name"];
            $com = $_POST["comment"];
            $date = date("Y/m/d H:i:s");
            $pass = $_POST["pass"];
        
            $sql -> execute();
            #echo "できてる？？？？？";
        }
    }
    
   else
    {
        echo "お名前とコメントとパスワードを入力してください"."<br>";
    }
    
    
}



if(isset($_POST["del_submit"]))
{
    $id = $_POST["dnum"];;
    $dpass = $_POST["dpass"];
    $sql = 'delete from tbtest where id=:id and pass = :pass';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pass', $dpass);
    $stmt->execute();
    
}



if(isset($_POST["edit_submit"]))
{
    $id = $_POST["edit"];
    $epass = $_POST["epass"]; 
    echo $epass;

    $sql = 'SELECT * FROM tbtest WHERE id=:id AND pass = :pass';
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->bindParam(':pass', $epass); 
    $stmt->execute();                             
    $results = $stmt->fetchAll(); 
	foreach ($results as $row)
	{
		//$rowの中にはテーブルのカラム名が入る
        $num_input = $row['id'];
    	$name_input = $row['name'];
    	$com_input = $row['comment'];
	}
	
}

?>

    <form method="POST" action = "">
        お名前：<input type="text" name="name" value="<?php echo $name_input ?>"><br>
        コメント：<input type="text" name="comment" value="<?php echo $com_input ?>"><br>
        パスワード:<input type="text" name="pass"><br>
        <input type="text" name="enum" value="<?php echo $num_input ?>">
        <input type="submit" name="new_submit"><br>
        <br>
        削除フォーム：<input type="number" name="dnum"><br>
        パスワード:<input type="text" name="dpass"><br>
        <input type = "submit" name = "del_submit"><br>
        編集用フォーム：<input type="number" name="edit"><br>
        パスワード:<input type="text" name="epass"><br>
        <input type = "submit" name = "edit_submit">
    </form>
    
<?php
echo "<hr>";
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row)
{
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['pass'].',';
	echo $row['date']."<br>";
}
echo "<hr>";
?>


</body>
</html>
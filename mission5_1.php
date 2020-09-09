<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5_1</title>
</head>
<body>
    <?php
        $i = $_POST["comment"];
        $name=$_POST['name'];
        $delete=$_POST['delete'];
        $edit=$_POST['check'];
        $editor=$_POST['editor'];
        $password_1=$_POST['password_1'];
        $password_2=$_POST['password_2'];
        $password_3=$_POST['password_3'];
        
        $dsn = 'host';
	    $user = 'username';
	    $password = 'passward';
    	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	    //編集は２、削除は３、１は最初のパスワード
        //編集のパスワードを抽出
        if($password_2!=''){
        
        $id=$editor;//これは大丈夫
        $sql = 'SELECT * FROM tbtest WHERE id=:id ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(); 
        $results = $stmt->fetchAll();

	    foreach ($results as $row){
	        $pass=$row['password_1'];
	        $edit_name=$row['name'];
	        $edit_comment=$row['comment'];
	        
	    }

	    }
	    //削除のパスワードを抽出
        if($password_3!=''){
        
        $id=$delete;//これは大丈夫
        $sql = 'SELECT * FROM tbtest WHERE id=:id ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(); 
        $results = $stmt->fetchAll();
	    foreach ($results as $row){
	    $pass=$row['password_1'];
	    
	    }
	    }

     ?>
     
      <form action="" method="post">
        <input type="text" name="name" placeholder='名前' value="<?php if(!empty($edit_name)){echo $edit_name;}?>"><br>
        <input type="text" name="comment" placeholder='コメント' value="<?php if(!empty($edit_comment)){echo $edit_comment;}?>"><br>
        <input type='hidden' name="check" value="<?php if(!empty($editor)){echo $editor;}?>" >
        <input type="text" name="password_1" placeholder='パスワード' value="<?php if(!empty($pass)){echo $pass;}?>" >
        <input type="submit" name="submit"><br>
        <input type="text" name="delete" placeholder='消したい数字'><br>
        <input type="text" name="password_3" placeholder='パスワード' >
        <input type="submit" name="del" value="削　除"><br>
        <input type="text" name="editor" placeholder='編集対象番号' ><br>
        <input type="text" name="password_2" placeholder='パスワード' >
        <input type="submit" name="edit" value="編集" ><br>
    </form>
    
</body>

<?php
    
	//INSERT、編集の時に反応しないように
	if (($i!='' or $name!='' ) and $edit ==''){

    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment,password_1) VALUES (:name, :comment,:password_1)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $i, PDO::PARAM_STR);
	$sql -> bindParam(':password_1', $password_1, PDO::PARAM_STR);
	
	$name = $name;
	$comment = $i;
	$password_1=$password_1;
	$sql -> execute();
	}
	//編集モード
	if ($editor!='' and $password_2==$pass){
	    $id=$editor;
	    $sql = 'SELECT * FROM tbtest WHERE id=:id ';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(); 
        $results = $stmt->fetchAll();
	    foreach ($results as $row){
	    $edit_name=$row['name'];
	    $edit_comment=$row['comment'];
	    $pass=$row['password_1'];
	    }
	}
	//編集
	if ($edit!='' and $editor=='' ){
	$id =$edit;
	$name = $name;
	$comment = $i;
	$password_1=$password_1;
    $sql = 'UPDATE tbtest SET name=:name,comment=:comment,password_1=:password_1 WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':password_1', $password_1, PDO::PARAM_STR);
	$stmt->execute();
	}
	
	//削除
	if ($delete!='' and $password_3==$pass){
        $id=$delete;
	$sql = 'delete from tbtest where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();


	    }

    //表示
    $sql = 'SELECT * FROM tbtest';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();

	    foreach ($results as $row){
	    echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'];
	    echo "<hr>";


	    }
?>

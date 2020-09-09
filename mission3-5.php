<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission3_5</title>
</head>
<body>
    <?php
    
        $i = $_POST["comment"];
        $name=$_POST['name'];
        $delete=$_POST['delete'];
        $file="mission3_5.txt";
        $edit=$_POST['check'];
        $editor=$_POST['editor'];
        $password_1=$_POST['password_1'];
        $password_2=$_POST['password_2'];
        $date=date('Y/m/d h:i:s');
        $merge='<>'.$name.'<>'.$i.'<>'.$date.'<>'.$password_1.PHP_EOL;
        $merge = trim($merge);
        
        //変数定義中身はそのまま
       if ($editor!=''){
          $lines = file($file,FILE_IGNORE_NEW_LINES);
    foreach($lines as $line){
        $lin=explode('<>',$line);
        
        if ($lin[0]==$editor){
        $edit_name=$lin[1];
        $edit_comment=$lin[2];
    }
    }
    fclose($fp);
   }
   //編集、削除が送られた時にその番号を変数とする
   if ($password_2!=''){
       $lines = file($file,FILE_IGNORE_NEW_LINES);
       foreach($lines as $line){
       $lin=explode('<>',$line);
        
        if ($lin[0]==$editor or$delete==$lin[0]){
        $password=$lin[4];
    }
    }
    fclose($fp);
   }

   
    ?>
    
   
    
    <form action="" method="post">
        <input type="text" name="name" placeholder='名前' value="<?php if(!empty($edit_name)){echo $edit_name;}?>"><br>
        <input type="text" name="comment" placeholder='コメント' value="<?php if(!empty($edit_comment)){echo $edit_comment;}?>"><br>
        <input type='hidden' name="check" value="<?php echo $editor;?>" >
        <input type="text" name="password_1" placeholder='パスワード' >
        <input type="submit" name="submit"><br>
        <input type="text" name="delete" placeholder='消したい数字'><br>
        <input type="text" name="password_2" placeholder='パスワード' >
        <input type="submit" name="del" value="削　除"><br>
        <input type="text" name="editor" placeholder='編集対象番号' ><br>
        <input type="text" name="password_2" placeholder='パスワード' >
        <input type="submit" name="edit" value="編集" ><br>
    </form>
    
</body>

   <?php
   //編集モードの時は反応しないようにしないとけない
   if (($i!='' or $name!='')and  $edit=='' and $editor==''){
      
    
      $fp = fopen($file,"a");
      $lines = file($file,FILE_IGNORE_NEW_LINES);
      $cnt = count($lines)+1;
      fwrite($fp,$cnt.$merge."\n");
      fclose($fp);
      foreach($lines as $line){
        $lin=explode('<>',$line);
        echo $lin[0].$lin[1].$lin[2].$lin[3].'<br>';
        $password=$lin[3];
    }
    echo $cnt.$name.$i.$date.PHP_EOL;
   }
//編集モード
//編集に数字が入れられた時にその番号の変数たちを受け取る
//
if ($edit!='' and $password_2==$password){
       $lines = file($file,FILE_IGNORE_NEW_LINES);
       $fp = fopen($file,"w");
    foreach($lines as $line){
        $lin=explode('<>',$line);
        if ($lin[0]==$edit){
        echo $lin[0].'<>'.$name.'<>'.$i.'<>'.$lin[3].'<br>';
        fwrite($fp,$edit.'<>'.$name.'<>'.$i.'<>'.$date."\n");
    }else{
    fwrite($fp,$line."\n");
    echo $line.'<br>';
    }
    }
    fclose($fp);
    
   }
//削除
   if ($delete!='' and $password_2==$password){
       $lines = file($file,FILE_IGNORE_NEW_LINES);
       $fp = fopen($file,"w");
       fclose($fp);
       foreach($lines as $line){
         $lin=explode('<>',$line);
         if ($lin[0]==$delete){
             echo '';
         }else{
         echo $lin[0].$lin[1].$lin[2].$lin[3].'<br>';
        $fp = fopen($file,"a");
      
      fwrite($fp,$line."\n");
      fclose($fp);
   }
   }
   }
?>
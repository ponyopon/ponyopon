<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission3_4</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder='名前' value="<?php if(!empty($edit_name)){echo $edit_name;}?>">
        <input type="text" name="comment" placeholder='コメント'　value="<?php if(!empty($edit_comment)){echo $edit_comment;}?>">
        <input type="hidden" name="check" value="<?php $edit=$_POST['editor'];echo $edit;?>" >
        <input type="submit" name="submit">
        <input type="text" name="delete" placeholder='消したい数字'>
        <input type="submit" name="del" value="削　除">
        <input type="text" name="editor" placeholder='編集対象番号' >
        <input type="submit" name="edit" value="編集" >
    </form>
    <?php
    
        $i = $_POST["comment"];
        $name=$_POST['name'];
        $delete=$_POST['delete'];
        $file="mission3_4.txt";
        $edit=$_POST['check'];
        $date=date('Y/m/d h:i:s');
        $merge='<>'.$name.'<>'.$i.'<>'.$date.PHP_EOL;
        $merge = trim($merge);
    ?>
</body>
   <?php
   if (($i!='' or $name!='')and $edit==''){
      
    
      $fp = fopen($file,"a");
      $lines = file($file,FILE_IGNORE_NEW_LINES);
      $cnt = count($lines)+1;
      fwrite($fp,$cnt.$merge."\n");
      fclose($fp);
      foreach($lines as $line){
        $lin=explode('<>',$line);
        echo $lin[0].$lin[1].$lin[2].$lin[3].'<br>';
    }
   }
//編集モード
   if ($edit!=''){
       $lines = file($file,FILE_IGNORE_NEW_LINES);
       $fp = fopen($file,"w");
    foreach($lines as $line){
        $lin=explode('<>',$line);
        if ($lin[0]==$edit){
        echo $lin[0].'<>'.$lin[1].'<>'.$lin[2].'<>'.$lin[3].'<br>';
        fwrite($fp,$edit.'<>'.$name.'<>'.$i.'<>'.$date."\n");
        $edit_name=$lin[1];
        $edit_comment=$lin[2];
    }else{
    fwrite($fp,$line."\n");
    echo $line.'<br>';
    }
    }
    fclose($fp);
   }
//削除
   if ($delete!=''){
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
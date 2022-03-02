<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
<form action="" method="POST">
    <input class="textbox" type="text" name="yazilan">
    <input type="submit" value="Ara" name="ara" class="button"></input>
    <button  name="sil" class="button">Sil</button>  
     
    <button  name="dosyaekle" class="button">Dosya Ekle</button> 
</form>
<br>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sil']))
    {
        sil();
    } 
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sqlara']))
    {
        sqlara();
    }
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dosyaekle']))
    {
        dosyaekle();
    }
    function alert($msg) {
            echo ("<script type='text/javascript'>alert('$msg');</script>");
        } 
       function delTree($dir) {
            $files = array_diff(scandir($dir), array('.','..'));
             foreach ($files as $file) {
               (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
             }
             return rmdir($dir);
           }   
    function sil(){
        error_reporting(0);
        $dosyayolu =$_POST['yazilan'];    
        $Path =$dosyayolu;
        if (file_exists($Path)){
            unlink($Path);
            delTree($Path);
        } else {
            alert("Dosya bulunmamaktadır");
        }        
    } 
    function sqlara(){
        $dosyayolu =$_POST['yazilan'];
        $metin = $dosyayolu; 
        $komut="";
        if(strstr($metin, "select")) 
        { 
            alert("Merhaba metin değişkeni içerisinde var.") ;
            $komut="select" ;            
        }
        else if(strstr($metin, "delete")){
            $komut="delete" ;
        }
        else if(strstr($metin, "insert")){
            $komut="insert" ;

        }
        // switch($komut){
        //     case"select":
                
        //     case"delete":
        //         echo"kelime delete";
        //     case"insert":
        // }
    }   
    function dosyaEkle()
    {$dosyayolu =$_POST['yazilan'];
        $folderName = $dosyayolu;
        $icerik="";
  if(strstr($folderName,".txt")||strstr($folderName,".doc")||strstr($folderName,".docx")||strstr($folderName,".dotx")||strstr($folderName,".html")||strstr($folderName,".mp3")||strstr($folderName,".mp4")||strstr($folderName,".pdf")){
    file_put_contents($dosyayolu, $icerik);
  }
  else{
      $config['upload_path'] = $folderName;
		if(!is_dir($folderName))
		{
			mkdir($folderName, 0777);
        }
        else{
            
        }

  }
		

    } 
?>
<?php
function dosyaBoyutu($bytes)//https://stackoverflow.com/questions/5501427/php-filesize-mb-kb-conversion
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }
    return $bytes;
}
?>
<div class="dosyaadikutu">
    
    <p>Dosya Adi</p>
<?php


$dosyaadinum = 1;
$dosyayolu =$_POST['yazilan'];
error_reporting(0);
foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
            
            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                
            $path_parts = pathinfo($dosyayolu2); 
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                echo ($dosyaadinum."- ".$dosyaadi."<br>");
                $dosyaadinum = ($dosyaadinum + 1);
            } 
            
         
           

}}}

?>
</div>
<div class="dosyaturukutu">
<p>Dosya Türü</p>
    <?php
    
        $dosyaadinum = 1;
$dosyayolu =$_POST['yazilan'];
        foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
            
            $dosyayolu2=$dosyayolu."\\".$dosyaadi;    
            
            $path_parts = pathinfo($dosyayolu2);  
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                echo (mime_content_type($dosyayolu2)."<br>");
                $dosyaadinum = ($dosyaadinum + 1);
            }   
            
          

}}}
    

?>
</div>
<div class="dosyaboyutukutu">
<p>Dosya Boyutu</p>
    <?php
foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
            
            $dosyayolu2=$dosyayolu."\\".$dosyaadi;    
            $deger=dosyaBoyutu(filesize($dosyayolu2));
            $path_parts = pathinfo($dosyayolu2);
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                echo ($deger."<br>");   
                $dosyaadinum = ($dosyaadinum + 1);
            }   

}}}
?>
</div>
<div class="dosyatarihkutu">
    
    <p>Düzenleme Tarihi</p>
<?php
$dosyaadinum = 1;
$dosyayolu =$_POST['yazilan'];
error_reporting(0);
foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
                           
            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                if (file_exists($dosyayolu2)) {
                    echo date ("F d Y H:i:s", filemtime($dosyayolu2));
                         echo("<br>"); 
                }  
               
            } 
           
}}}

?>
</div>
</div>
<div class="dosyaizinkutu">
    
    <p>Düzenleme İzin</p>
<?php
$dosyaadinum = 1;
$dosyayolu =$_POST['yazilan'];
error_reporting(0);
foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
            $dosyayolu2=$dosyayolu."\\".$dosyaadi; 
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                echo substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                echo("<br>");   
                $dosyaadinum = ($dosyaadinum + 1);
            }            
            
           
}}}

?>
</div>
</div>
<div class="dosyasahipkutu">
    
    <p>Dosya Sahibi</p>
    
<?php
$dosyaadinum = 1;
$dosyayolu =$_POST['yazilan'];
error_reporting(0);
foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
            
            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                echo  get_current_user();
            echo("<br>");   
                $dosyaadinum = ($dosyaadinum + 1);
            }   

                       
}}}

?>
</div>
<div class="dosyagrupkutu">
    
    <p>Dosya Grup</p>
    
<?php
$dosyaadinum = 1;
$dosyayolu =$_POST['yazilan'];
error_reporting(0);
foreach(scandir($dosyayolu) as $dosyaadi){
    
    if (!($dosyaadi == '.')) {
        if (!($dosyaadi == '..')) {
            
            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
            $stat = stat($dosyayolu2);
            if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
            }  
            else{
                echo  $stat['gid'];
                echo("<br>");  
                $dosyaadinum = ($dosyaadinum + 1);
            } 
            
                      
}}}

?>
</div>



 
</body>
</html>
<style>
    body{
     width: 100%;
    }
    div{
        
        padding: 10px;
        width: auto;
    }
    .dosyaizinkutu{
        
        background-color: #e6f9a7;
        margin: 5px;
        float: left;
      }
    .dosyaadikutu{
        
    background-color: #e6f9a7;
    margin: 5px;
    float: left;
  }
  .dosyaturukutu{
    
    background-color: #e6f9a7;
    
    margin: 5px;
    float: left;
  }.dosyaboyutukutu{
    
    background-color: #e6f9a7;
    
    margin: 5px;
    float: left;
  }
  .dosyatarihkutu{
    
    background-color: #e6f9a7;
    
    margin: 5px;
    float: left;
  }
  .dosyasahipkutu{

    background-color: #e6f9a7;
    
    margin: 5px;
    float: left;
  }
  .dosyagrupkutu
  {
    background-color: #e6f9a7;
    
    margin: 5px;
    float: left;
  }
  .button{
      width: 10%;
  }
  .textbox{
    width: 30%;
  }
  
</style>
<script>    
       
</script>

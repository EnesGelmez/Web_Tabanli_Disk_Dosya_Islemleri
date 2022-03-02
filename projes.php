<!DOCTYPE HTML>  
<html>  
    <head>  
        <title>  
            
        </title> 
    </head>  
      
    <body>  
<form action="" method="POST">  
    <p style="color:red;">SQL Cümleciği</p>
    <input style="width:1500px ; " class="textbox" type="text" name="sqlcumlesi">
    <br><br>
    <button   name="sqlara" class="button">Ara</button>    
    <button   name="sqlsil" class="button">Sil</button>  
</form>
<br>
<br>
<div id="dosyaadikutu" class="dosyaadikutu">
<p>Dosya Adi</p>
</div>
<div id="dosyaturukutu" class="dosyaturukutu">
<p>Dosya Türü</p>
</div>
<div id="dosyaboyutukutu" class="dosyaboyutukutu">
<p>Dosya Boyutu</p>
</div>
<div id="dosyatarihkutu" class="dosyatarihkutu">
<p>Düzenleme Tarihi</p>
</div>
<div id="dosyaizinkutu" class="dosyaizinkutu">
<p>Düzenleme İzin</p>
</div>
<div id="dosyasahipkutu" class="dosyasahipkutu">
<p>Dosya Sahibi</p>
</div>
<div id="dosyagrupkutu" class="dosyasahipkutu">
<p>Dosya Grubu</p>
</div>

    <?php


function sil($dosyayolu){
   
error_reporting(0);   
$Path =$dosyayolu;

if (file_exists($Path)){ 
    
    if(unlink($Path))
    {
        alert("Dosya Başarı ile silindi");
    }
    if(rmdir($Path)){
        alert("Dosya Başarı ile silindi");
    }
    
    return;      
  
   
} else {
    alert("Dosya bulunmamaktadır");
}        
} 
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
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sqlara']))
    {
        sqlara();
    }
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sqlsil']))
    {
        delete();
    }
     function alert($msg) {
        echo ("<script type='text/javascript'>alert('$msg');</script>");
    } 
function sqlara(){
    error_reporting(0);
    $name="";
    $nameval="";
    $typeval="";
    $size="";
    $sizeval="";
    $mdate="";
    $mdateval="";
    $permis="";
    $permisval="";
    $array=array("name","type","size","modifieddate","permission");   
    $sqlcumle=$_POST['sqlcumlesi'];
    
    if(strstr($sqlcumle,"select")==false){
        alert("hata (ilk deger select,delete veya insert olmalı)");
    }
    else if(strstr($sqlcumle,"select name from c:\\")){
        alert("hata (girilen sartın ataması yapılmalı)");
    }
    else if(strstr($sqlcumle,"select name from c:\ where")){
        alert("hata (sql yapısına aykırı)");
    }
    else if(strstr($sqlcumle,"select name from c:\ where name=")){
        alert("hata (sartın regular expressionsına aykırı)");
        
    }
    else if(strstr($sqlcumle,"select name,size from c:\ where name=abc")){
        alert("hata (girilen sartların hepsinin ataması yapılmalı)");
    }
    else if(strstr($sqlcumle,"select type from c:\ where type=")){
        alert("hata (sartın regular expressionsına aykırı)");
    }
    else if(strstr($sqlcumle,"select size from c:\ where size=")){
        alert("hata (sartın regular expressionsına aykırı)");
    }
    else if(strstr($sqlcumle,"select modifieddate from c:\\ where modifieddate=")){
        alert("hata (sartın regular expressionsına aykırı)");
    }
    else if(strstr($sqlcumle,"select permission from c:\\ where permission=")){
        alert("hata (sartın regular expressionsına aykırı)");
    }
    else if(strstr($sqlcumle,"select name from c:\\ where permission=")){
        alert("hata (girilen sartların hepsinin ataması yapılmalı)");
    }
    else if(strstr($sqlcumle,"select name, size from c:\ where name=abc,size=100k")){
        alert("hata (sartlar && ile ayrılmalı)");
    }
    else if(strstr($sqlcumle,"select name,size from c:\ where name=abc && size=100")){
        alert("hata (girilen sart regular expressionsa aykırı)");
    }

    else if(strstr($sqlcumle,"where")==false&&strstr($sqlcumle,"*")&&strstr($sqlcumle,"from")==true){
        $nerede = mb_strpos($sqlcumle, 'from');
        $dizin=substr($sqlcumle, $nerede+5);
        $bosluksuz=trim($dizin);
        $sorgu=explode($dizin,$sqlcumle);
        $a1=explode(" ",$sorgu[0]);
        $select=trim($a1[0]);
        $namesize=trim($a1[1]);
        $from=trim($a1[2]);
        $c=$bosluksuz;
        $where="";
        $name2="";
        if($select!="select"){
            alert("hata ");
        }
    
        
        else if($namesize!="")
        {
            if($from==""||$c==""){
                alert("hata ");
            }
            else{
                if($namesize!="*")
                {
                    if($where!="where"||$name2=="")
                    {
                        alert("hata ");
                    }
                    else
                    {
    
                        $dizi = explode (",",$namesize);
                        for($i=0;$i<sizeof($dizi);$i++){
                            for($j=0;$j<sizeof($array);$j++){
                                if($dizi[$i]==$array[$j]){
                                    if($array[$j]=="name"){
                                        $name="name";
                                    }
                                    else if($array[$j]=="type")
                                    {
                                        $type="type";
                                    }
                                    else if($array[$j]=="size")
                                    {
                                        $size="size";
                                    }
                                    else if($array[$j]=="modifieddate")
                                    {
                                        $mdate="modifieddate";
                                    }
                                    else if($array[$j]=="permission")
                                    {
                                        $permis="permission";
                                    }
                                }
                                
                                                            
                            }
                        }
                    }
                    if(strstr($name2,"&&")){
                        $diziname2 = explode ("&&",$name2);
                        sort($diziname2);                    
                        $diziname3=array();                    
                        for($i=0;$i<sizeof($diziname2);$i++){  
                            
                            $a=$diziname2[$i];
                            $b=explode("=",$a);
                            for($j=0;$j<sizeof($b);$j++)
                            {
                                array_push($diziname3,$b[$j]); 
                            }                
                        } 
                        for($j=0;$j<sizeof($diziname3);$j+=2)
                        {
                            if($diziname3[$j]==$name){                            
                                $nameval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$type)
                            {
                                $typeval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$size){
                                $sizeval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$mdate){
                                $mdateval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$permis){
                                $permisval=$diziname3[$j+1];
                            }
                        }
                        for($j=0;$j<sizeof($diziname3);$j+=2){
                            
                            if($mdate=="modifieddate"){
                                if($diziname3[$j]==$mdate){
                                    $mdateval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($date==$mdateval){ 
                                                    echo  ("<script>document.getElementById('dosyatarihkutu').innerHTML+='$date<br>';</script>"); 
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            else{
                                                
                                            }
                                    }}}
                                    
    
                                }
                                if($name=="name"){    
                                    if($diziname3[$j]==$name){
                                        $nameval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($dosyaadi==$nameval){
                                                    echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }
                                                else{
                                                    
                                                }
        
                                            }}}
                                        
                                    }  
                                    if($permis=="permission"){
                                        if($diziname3[$j]==$permis){
                                            $permisval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($substr==$permisval){ 
                                                        if($dosyaadi==$nameval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                            $dosyaadinum = ($dosyaadinum + 1);   
                                                        }   
                                                        else{
                                                            
                                                        }                                    
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($size=="size"){
                                            if($diziname3[$j]==$size){
                                                $sizeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($deger==$sizeval){ 
                                                            if($date==$mdateval)
                                                            {
                                                                echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            }  
                                                            else{
                                                                
                                                            }
                                                        }
                                                        
                
                                                    }}}
                                            }
                                            if($type=="type"){
                                             
                                                if($diziname3[$j]==$type){
                                                    $typeval=$diziname3[$j+1];
                                                    $dosyayolu=$c;
                                                    $dosyaadinum = 1;                                  
                                                    foreach(scandir($dosyayolu) as $dosyaadi){
                            
                                                        if (!($dosyaadi == '.')) {
                                                        if (!($dosyaadi == '..')) {
                                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                            $mime_content=mime_content_type($dosyayolu2);
                                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                            if($mime_content==$typeval){ 
                                                                if($date==$mdateval){
                                                                   
                                                                    echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                                } 
                                                                else{
                                                                    
                                                                }
                                                            }
                                                        }}}
                                                    
                                                }
    
                                            }
                                            else{
                                                  
                                            }
                                        }
                                        else if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($date==$mdateval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
    
                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($dosyaadi==$nameval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($dosyaadi==$nameval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
    
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($dosyaadi==$nameval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }                   
                                    else{
                                          
                                    }
                                }
                                else if($permis=="permission"){
                                    if($diziname3[$j]==$permis){
                                        $permisval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($substr==$permisval){ 
                                                    if($date==$mdateval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                        $dosyaadinum = ($dosyaadinum + 1);   
                                                    }     
                                                    else{
                                                        
                                                    }                                  
                                                }
                                                
        
                                            }}}
                                    }
                                    if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($date==$mdateval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($date==$mdateval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($date==$mdateval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($date==$mdateval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($date==$mdateval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($date==$mdateval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                } 
                                else{
                                      
                                } 
                            }
                            else if($name=="name"){    
                                if($diziname3[$j]==$name){
                                    $nameval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($dosyaadi==$nameval){
                                                echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                                                $dosyaadinum = ($dosyaadinum + 1); 
                                            }
                                            else{
                                                
                                            }
    
                                        }}}
                                    
                                }  
                                if($permis=="permission"){
                                    if($diziname3[$j]==$permis){
                                        $permisval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($substr==$permisval){ 
                                                    if($dosyaadi==$nameval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                        $dosyaadinum = ($dosyaadinum + 1);   
                                                    }  
                                                    else{
                                                        
                                                    }                                     
                                                }
                                                
        
                                            }}}
                                    }
                                    if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($mime_content==$typeval||$dosyaadi==$nameval||$date==$mdateval||$substr==$permisval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                            else{
                                                                
                                                            }
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
    
                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
    
                                }
                                else if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($dosyaadi==$nameval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($dosyaadi==$nameval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                }                   
                                else{
                                      
                                }
                            }
                            else if($permis=="permission"){
                                if($diziname3[$j]==$permis){                                
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi; 
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));                                       
                                            $mime_content=mime_content_type($dosyayolu2);                                        
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($substr==$permisval){ 
                                                if($deger!=$sizeval){
                                                    $deger="";
                                                }
                                                if($mime_content!=$typeval){
                                                    $mime_content="";
                                                }
                                                if($deger==$sizeval)
                                                {                                                
                                                    echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                    $dosyaadinum = ($dosyaadinum + 1);   
                                                    
                                                } 
                                                else{
                                                    
                                                }
                                                                                
                                            }
                                        }}}
                                }
                                if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }
                                                else{
                                                    
                                                }
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                }
                                else{
                                      
                                }
                            }
                            else if($size=="size"){
                               
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            
                                            if($deger==$sizeval){ 
                                                
                                                if($mime_content==$typeval||$dosyaadi==$nameval||$date==$mdateval||$substr==$permisval)
                                                {
                                                    echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }  
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                }
                                if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                }
                                else{
                                      
                                }
                            }
                            else if($type=="type"){
                               
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($mime_content==$typeval){ 
                                                if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                    echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                } 
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                    
                                }
    
                            }  
                            else{
                                  
                            }
                        } 
                    }
                    else if(strstr($name2,"="))               
                    {
                        
                        $diziname3=explode("=",$name2);
    
                        for($j=0;$j<sizeof($diziname3);$j+=2){
                            if($name=="name"){
                                if($diziname3[$j]==$name){
                                    $nameval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            if($dosyaadi==$nameval){
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                                            $dosyaadinum = ($dosyaadinum + 1);
    
                                            }
                                            
    
                                        }}}
                                }
                            }
                            if($type=="type"){
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            if($mime_content==$typeval){                                            
                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            
    
                                        }}}
                                    
                                }
                            }
                            if($size=="size"){
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $deger=dosyaBoyutu(filesize($dosyayolu2)); 
                                            if($deger==$sizeval){ 
                                                echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            
    
                                        }}}
                                }
                            }
                            if($mdate=="modifieddate"){
                                if($diziname3[$j]==$mdate){
                                    $mdateval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            if($date==$mdateval){ 
                                                echo  ("<script>document.getElementById('dosyatarihkutu').innerHTML+='$date<br>';</script>"); 
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
    
                                        }}}
                                }
                            }
                            if($permis=="permission"){
                                if($diziname3[$j]==$permis){
                                    $permisval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($substr==$permisval){ 
                                                echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                $dosyaadinum = ($dosyaadinum + 1);                                        
                                            }
                                            
    
                                        }}}
                                }
                            }
                        }            
                    }
                    else if(strstr($name2,",")){
                        
                    }
                    for($j=0;$j<$dosyaadinum-1;$j++){
                        if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
                        }  
                        else
                        {
                            $a=get_current_user();
                            echo  ("<script>document.getElementById('dosyasahipkutu').innerHTML+='$a<br>';</script>");
                        }
                        
                        if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
                        }  
                        else{
                            $stat = stat($c);
                            $b=$stat['gid'];
                            echo  ("<script>document.getElementById('dosyagrupkutu').innerHTML+='$b<br>';</script>");
                            
                        } 
                    }
                }
                else if($namesize=="*"){
    
                        $dosyaadinum = 1;
                        $dosyayolu =$c;
                        error_reporting(0);
                        foreach(scandir($dosyayolu) as $dosyaadi){
            
                        if (!($dosyaadi == '.')) {
                        if (!($dosyaadi == '..')) {
                    
                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                
                        $path_parts = pathinfo($dosyayolu2); 
                        $mime_content=mime_content_type($dosyayolu2);  
                        $stat = stat($dosyayolu2);
    
                        if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
                        }  
                        else{
                            echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                            $deger=dosyaBoyutu(filesize($dosyayolu2));             
                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                            if (file_exists($dosyayolu2)) {
                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                            echo  ("<script>document.getElementById('dosyatarihkutu').innerHTML+='$date<br>';</script>");                         
                            }
                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                            echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>");
                            $a=get_current_user();
                            echo  ("<script>document.getElementById('dosyasahipkutu').innerHTML+='$a<br>';</script>");
                            $b=$stat['gid'];
                            echo  ("<script>document.getElementById('dosyagrupkutu').innerHTML+='$b<br>';</script>");
                        }  
                 
                        $dosyaadinum = ($dosyaadinum + 1);
                    }}}
                   
                }
            }
        }
        

    }
    else if(strstr($sqlcumle,"where")&&strstr($sqlcumle,"select")){
        $nerede = mb_strpos($sqlcumle, 'from');
        $nerede2 = mb_strpos($sqlcumle, 'where');
        $dizin=substr($sqlcumle, $nerede+5,(($nerede2)-($nerede+5)));
        $bosluksuz=trim($dizin);
        $sorgu=explode($dizin,$sqlcumle);
        $a1=explode(" ",$sorgu[0]);
        $a2=explode(" ",$sorgu[1]);
        $a3=substr($sorgu[1],6);
        $select=trim($a1[0]);
        $namesize=trim($a1[1]);
        $from=trim($a1[2]);
        $c=$bosluksuz;
        $where=trim($a2[0]);
        $name2=trim($a3);

        if($select!="select"){
            alert("hata ");
        }
    
        
        else if($namesize!="")
        {
            if($from==""||$c==""){
                alert("hata ");
            }
            else{
                if($namesize!="*")
                {
                    if($where!="where"||$name2=="")
                    {
                        alert("hata ");
                    }
                    else
                    {
    
                        $dizi = explode (",",$namesize);
                        for($i=0;$i<sizeof($dizi);$i++){
                            for($j=0;$j<sizeof($array);$j++){
                                if($dizi[$i]==$array[$j]){
                                    if($array[$j]=="name"){
                                        $name="name";
                                    }
                                    else if($array[$j]=="type")
                                    {
                                        $type="type";
                                    }
                                    else if($array[$j]=="size")
                                    {
                                        $size="size";
                                    }
                                    else if($array[$j]=="modifieddate")
                                    {
                                        $mdate="modifieddate";
                                    }
                                    else if($array[$j]=="permission")
                                    {
                                        $permis="permission";
                                    }
                                }
                                
                                                            
                            }
                        }
                    }
                    if(strstr($name2,"&&")){
                        $diziname2 = explode ("&&",$name2);
                        sort($diziname2);                    
                        $diziname3=array();                    
                        for($i=0;$i<sizeof($diziname2);$i++){  
                            
                            $a=$diziname2[$i];
                            $b=explode("=",$a);
                            for($j=0;$j<sizeof($b);$j++)
                            {
                                array_push($diziname3,$b[$j]); 
                            }                
                        } 
                        for($j=0;$j<sizeof($diziname3);$j+=2)
                        {
                            if($diziname3[$j]==$name){                            
                                $nameval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$type)
                            {
                                $typeval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$size){
                                $sizeval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$mdate){
                                $mdateval=$diziname3[$j+1];
                            }
                            if($diziname3[$j]==$permis){
                                $permisval=$diziname3[$j+1];
                            }
                        }
                        for($j=0;$j<sizeof($diziname3);$j+=2){
                            
                            if($mdate=="modifieddate"){
                                if($diziname3[$j]==$mdate){
                                    $mdateval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($date==$mdateval){ 
                                                    echo  ("<script>document.getElementById('dosyatarihkutu').innerHTML+='$date<br>';</script>"); 
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            else{
                                                
                                            }
                                    }}}
                                    
    
                                }
                                if($name=="name"){    
                                    if($diziname3[$j]==$name){
                                        $nameval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($dosyaadi==$nameval){
                                                    echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }
                                                else{
                                                    
                                                }
        
                                            }}}
                                        
                                    }  
                                    if($permis=="permission"){
                                        if($diziname3[$j]==$permis){
                                            $permisval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($substr==$permisval){ 
                                                        if($dosyaadi==$nameval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                            $dosyaadinum = ($dosyaadinum + 1);   
                                                        }   
                                                        else{
                                                            
                                                        }                                    
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($size=="size"){
                                            if($diziname3[$j]==$size){
                                                $sizeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($deger==$sizeval){ 
                                                            if($date==$mdateval)
                                                            {
                                                                echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            }  
                                                            else{
                                                                
                                                            }
                                                        }
                                                        
                
                                                    }}}
                                            }
                                            if($type=="type"){
                                             
                                                if($diziname3[$j]==$type){
                                                    $typeval=$diziname3[$j+1];
                                                    $dosyayolu=$c;
                                                    $dosyaadinum = 1;                                  
                                                    foreach(scandir($dosyayolu) as $dosyaadi){
                            
                                                        if (!($dosyaadi == '.')) {
                                                        if (!($dosyaadi == '..')) {
                                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                            $mime_content=mime_content_type($dosyayolu2);
                                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                            if($mime_content==$typeval){ 
                                                                if($date==$mdateval){
                                                                   
                                                                    echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                                } 
                                                                else{
                                                                    
                                                                }
                                                            }
                                                        }}}
                                                    
                                                }
    
                                            }
                                            else{
                                                  
                                            }
                                        }
                                        else if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($date==$mdateval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
    
                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($dosyaadi==$nameval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($dosyaadi==$nameval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
    
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($dosyaadi==$nameval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }                   
                                    else{
                                          
                                    }
                                }
                                else if($permis=="permission"){
                                    if($diziname3[$j]==$permis){
                                        $permisval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($substr==$permisval){ 
                                                    if($date==$mdateval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                        $dosyaadinum = ($dosyaadinum + 1);   
                                                    }     
                                                    else{
                                                        
                                                    }                                  
                                                }
                                                
        
                                            }}}
                                    }
                                    if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($date==$mdateval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($date==$mdateval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($date==$mdateval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($date==$mdateval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($date==$mdateval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($date==$mdateval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                } 
                                else{
                                      
                                } 
                            }
                            else if($name=="name"){    
                                if($diziname3[$j]==$name){
                                    $nameval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($dosyaadi==$nameval){
                                                echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                                                $dosyaadinum = ($dosyaadinum + 1); 
                                            }
                                            else{
                                                
                                            }
    
                                        }}}
                                    
                                }  
                                if($permis=="permission"){
                                    if($diziname3[$j]==$permis){
                                        $permisval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($substr==$permisval){ 
                                                    if($dosyaadi==$nameval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                        $dosyaadinum = ($dosyaadinum + 1);   
                                                    }  
                                                    else{
                                                        
                                                    }                                     
                                                }
                                                
        
                                            }}}
                                    }
                                    if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($mime_content==$typeval||$dosyaadi==$nameval||$date==$mdateval||$substr==$permisval)
                                                        {
                                                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                            else{
                                                                
                                                            }
                                                        }
                                                        
                
                                                    }}}
                                                
                                            }
    
                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
    
                                }
                                else if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($dosyaadi==$nameval)
                                                    {
                                                        echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($dosyaadi==$nameval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                }                   
                                else{
                                      
                                }
                            }
                            else if($permis=="permission"){
                                if($diziname3[$j]==$permis){                                
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi; 
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));                                       
                                            $mime_content=mime_content_type($dosyayolu2);                                        
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($substr==$permisval){ 
                                                if($deger!=$sizeval){
                                                    $deger="";
                                                }
                                                if($mime_content!=$typeval){
                                                    $mime_content="";
                                                }
                                                if($deger==$sizeval)
                                                {                                                
                                                    echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                    $dosyaadinum = ($dosyaadinum + 1);   
                                                    
                                                } 
                                                else{
                                                    
                                                }
                                                                                
                                            }
                                        }}}
                                }
                                if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }
                                                else{
                                                    
                                                }
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval){
                                                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
    
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                }
                                else{
                                      
                                }
                            }
                            else if($size=="size"){
                               
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            
                                            if($deger==$sizeval){ 
                                                
                                                if($mime_content==$typeval||$dosyaadi==$nameval||$date==$mdateval||$substr==$permisval)
                                                {
                                                    echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }  
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                }
                                if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                        echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }
    
                                }
                                else{
                                      
                                }
                            }
                            else if($type=="type"){
                               
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($mime_content==$typeval){ 
                                                if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                    echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                } 
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                    
                                }
    
                            }  
                            else{
                                  
                            }
                        } 
                    }
                    else if(strstr($name2,"="))               
                    {
                        
                        $diziname3=explode("=",$name2);
    
                        for($j=0;$j<sizeof($diziname3);$j+=2){
                            if($name=="name"){
                                if($diziname3[$j]==$name){
                                    $nameval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            if($dosyaadi==$nameval){
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                                            $dosyaadinum = ($dosyaadinum + 1);
    
                                            }
                                            
    
                                        }}}
                                }
                            }
                            if($type=="type"){
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            if($mime_content==$typeval){                                            
                                                echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            
    
                                        }}}
                                    
                                }
                            }
                            if($size=="size"){
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $deger=dosyaBoyutu(filesize($dosyayolu2)); 
                                            if($deger==$sizeval){ 
                                                echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            
    
                                        }}}
                                }
                            }
                            if($mdate=="modifieddate"){
                                if($diziname3[$j]==$mdate){
                                    $mdateval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            if($date==$mdateval){ 
                                                echo  ("<script>document.getElementById('dosyatarihkutu').innerHTML+='$date<br>';</script>"); 
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
    
                                        }}}
                                }
                            }
                            if($permis=="permission"){
                                if($diziname3[$j]==$permis){
                                    $permisval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($substr==$permisval){ 
                                                echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>"); 
                                                $dosyaadinum = ($dosyaadinum + 1);                                        
                                            }
                                            
    
                                        }}}
                                }
                            }
                        }            
                    }
                    else if(strstr($name2,",")){
                        
                    }
                    for($j=0;$j<$dosyaadinum-1;$j++){
                        if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
                        }  
                        else
                        {
                            $a=get_current_user();
                            echo  ("<script>document.getElementById('dosyasahipkutu').innerHTML+='$a<br>';</script>");
                        }
                        
                        if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
                        }  
                        else{
                            $stat = stat($c);
                            $b=$stat['gid'];
                            echo  ("<script>document.getElementById('dosyagrupkutu').innerHTML+='$b<br>';</script>");
                            
                        } 
                    }
                }
                else if($namesize=="*"){
    
                        $dosyaadinum = 1;
                        $dosyayolu =$c;
                        error_reporting(0);
                        foreach(scandir($dosyayolu) as $dosyaadi){
            
                        if (!($dosyaadi == '.')) {
                        if (!($dosyaadi == '..')) {
                    
                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                
                        $path_parts = pathinfo($dosyayolu2); 
                        $mime_content=mime_content_type($dosyayolu2);  
                        $stat = stat($dosyayolu2);
    
                        if($dosyaadi=="DumpStack.log"||$dosyaadi=="DumpStack.log.tmp"||$dosyaadi=="hiberfil.sys"||$dosyaadi=="pagefile.sys"||$dosyaadi=="swapfile.sys"){
                        }  
                        else{
                            echo("<script>document.getElementById('dosyaadikutu').innerHTML+='$dosyaadinum-$dosyaadi <br>';</script>");
                            echo("<script>document.getElementById('dosyaturukutu').innerHTML+='$mime_content<br>';</script>");
                            $deger=dosyaBoyutu(filesize($dosyayolu2));             
                            echo ("<script>document.getElementById('dosyaboyutukutu').innerHTML+='$deger<br>';</script>");
                            if (file_exists($dosyayolu2)) {
                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                            echo  ("<script>document.getElementById('dosyatarihkutu').innerHTML+='$date<br>';</script>");                         
                            }
                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                            echo ("<script>document.getElementById('dosyaizinkutu').innerHTML+='$substr<br>';</script>");
                            $a=get_current_user();
                            echo  ("<script>document.getElementById('dosyasahipkutu').innerHTML+='$a<br>';</script>");
                            $b=$stat['gid'];
                            echo  ("<script>document.getElementById('dosyagrupkutu').innerHTML+='$b<br>';</script>");
                        }  
                 
                        $dosyaadinum = ($dosyaadinum + 1);
                    }}}
                   
                }
            }
        }
    }
    
    
}
function delete(){
   
    error_reporting(0);
    $name="";
    $nameval="";
    $typeval="";
    $size="";
    $sizeval="";
    $mdate="";
    $mdateval="";
    $permis="";
    $permisval="";
    $array=array("name","type","size","modifieddate","permission");
    $sqlcumle=$_POST['sqlcumlesi'];

    if(strstr($sqlcumle,"delete")==true){
        
        //delete from c/: where name=adobe&&type=directory
        $nerede = mb_strpos($sqlcumle, 'from'); //7
        
        $nerede2 = mb_strpos($sqlcumle, 'where'); //16
        
        $dizin=substr($sqlcumle, $nerede+5,(($nerede2)-($nerede+5)));
        $bosluksuz=trim($dizin);        
        $sorgu=explode($dizin,$sqlcumle);   
        $a1=explode(" ",$sorgu[0]);        
        $a2=explode(" ",$sorgu[1]);
        $a3=substr($sorgu[1],6);
        $select=trim($a1[0]); //delete
        $from=trim($a1[1]); //from
        $c=$bosluksuz; //dosya yolu(dizin)
        $where=trim($a2[0]); //where
        $name2=trim($a3); //name=adobe&&type=directory
       
    
        if($from==""||$c==""){
            alert("hata");
        }
        else{
            if($name2!="")
            {
                if(strstr($name2,"&&")){
                    $diziname2 = explode ("&&",$name2);
                    sort($diziname2);                    
                    $diziname3=array();                 
                    for($i=0;$i<sizeof($diziname2);$i++){  
                        
                        $a=$diziname2[$i];
                        $b=explode("=",$a);
                        for($j=0;$j<sizeof($b);$j++)
                        {
                            array_push($diziname3,$b[$j]); 
                        }                
                    } 
                    for($j=0;$j<sizeof($diziname3);$j+=2)
                    {
                        if($diziname3[$j]=="name"){                            
                            $name="name";
                        }
                        if($diziname3[$j]=="type")
                        {
                            $type="type";
                        }
                        if($diziname3[$j]=="size"){
                            $size="size";
                        }
                        if($diziname3[$j]=="modifieddate"){
                            $mdate="modifieddate";
                        }
                        if($diziname3[$j]=="permission"){
                            $permis="permission";
                        }
                    }
                    for($j=0;$j<sizeof($diziname3);$j+=2)
                    {
                        if($diziname3[$j]==$name){                            
                            $nameval=$diziname3[$j+1];
                           
                        }
                        if($diziname3[$j]==$type)
                        {
                            $typeval=$diziname3[$j+1];
                           
                        }
                        if($diziname3[$j]==$size){
                            $sizeval=$diziname3[$j+1];
                        }
                        if($diziname3[$j]==$mdate){
                            $mdateval=$diziname3[$j+1];
                        }
                        if($diziname3[$j]==$permis){
                            $permisval=$diziname3[$j+1];
                        }
                    }
                    for($j=0;$j<sizeof($diziname3);$j+=2){
                        
                        if($mdate=="modifieddate"){
                            if($diziname3[$j]==$mdate){
                                $mdateval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                        $mime_content=mime_content_type($dosyayolu2);
                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                        if($date==$mdateval){ 
                                                sil($dosyayolu2);
                                                $dosyaadinum = ($dosyaadinum + 1);
                                        }
                                        else{
                                            
                                        }
                                }}}
                                

                            }
                            if($name=="name"){    
                                if($diziname3[$j]==$name){
                                    $nameval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($dosyaadi==$nameval){
                                                sil($dosyayolu2);
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            else{
                                                
                                            }
    
                                        }}}
                                    
                                }  
                                if($permis=="permission"){
                                    if($diziname3[$j]==$permis){
                                        $permisval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($substr==$permisval){ 
                                                    if($dosyaadi==$nameval)
                                                    {
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);   
                                                    }   
                                                    else{
                                                        
                                                    }                                    
                                                }
                                                
        
                                            }}}
                                    }
                                    if($size=="size"){
                                        if($diziname3[$j]==$size){
                                            $sizeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($deger==$sizeval){ 
                                                        if($date==$mdateval)
                                                        {
                                                            sil($dosyayolu2);
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        }  
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                        }
                                        if($type=="type"){
                                         
                                            if($diziname3[$j]==$type){
                                                $typeval=$diziname3[$j+1];
                                                $dosyayolu=$c;
                                                $dosyaadinum = 1;                                  
                                                foreach(scandir($dosyayolu) as $dosyaadi){
                        
                                                    if (!($dosyaadi == '.')) {
                                                    if (!($dosyaadi == '..')) {
                                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                        $mime_content=mime_content_type($dosyayolu2);
                                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                        if($mime_content==$typeval){ 
                                                            if($date==$mdateval){
                                                                sil($dosyayolu2);
                                                                $dosyaadinum = ($dosyaadinum + 1);
                                                            } 
                                                            else{
                                                                
                                                            }
                                                        }
                                                    }}}
                                                
                                            }

                                        }
                                        else{
                                              
                                        }
                                    }
                                    else if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($date==$mdateval){
                                                            sil($dosyayolu2);
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }

                                    }
                                    else{
                                          
                                    }
                                }
                                else if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($dosyaadi==$nameval)
                                                    {
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($dosyaadi==$nameval){
                                                            sil($dosyayolu2);
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }

                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($dosyaadi==$nameval){
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                }
                                                
        
                                            }}}
                                        
                                    }

                                }                   
                                else{
                                      
                                }
                            }
                            else if($permis=="permission"){
                                if($diziname3[$j]==$permis){
                                    $permisval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($substr==$permisval){ 
                                                if($date==$mdateval)
                                                {
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);   
                                                }     
                                                else{
                                                    
                                                }                                  
                                            }
                                            
    
                                        }}}
                                }
                                if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($date==$mdateval)
                                                    {
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($date==$mdateval){
                                                            sil($dosyayolu2);
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                    }
                                                    
            
                                                }}}
                                            
                                        }
                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($date==$mdateval){
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                }
                                                
        
                                            }}}
                                        
                                    }

                                }
                                else{
                                      
                                }
                            }
                            else if($size=="size"){
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($deger==$sizeval){ 
                                                if($date==$mdateval)
                                                {
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }  
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                }
                                if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($date==$mdateval){
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }

                                }
                                else{
                                      
                                }
                            }
                            else if($type=="type"){
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($mime_content==$typeval){ 
                                                if($date==$mdateval){
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                } 
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                    
                                }

                            } 
                            else{
                                  
                            } 
                        }
                        else if($name=="name"){ 
                            
                            if($diziname3[$j]==$name){
                                $nameval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;
                                foreach(scandir($dosyayolu) as $dosyaadi){
                                    
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                        $mime_content=mime_content_type($dosyayolu2);
                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                        if($dosyaadi==$nameval){
                                            sil($dosyayolu2);
                                            $dosyaadinum = ($dosyaadinum + 1); 
                                        }
                                        else{
                                            
                                        }

                                    }}}
                                
                            }  
                            if($permis=="permission"){
                                if($diziname3[$j]==$permis){
                                    $permisval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($substr==$permisval){ 
                                                if($dosyaadi==$nameval)
                                                {
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);   
                                                }  
                                                else{
                                                    
                                                }                                     
                                            }
                                            
    
                                        }}}
                                }
                                if($size=="size"){
                                    if($diziname3[$j]==$size){
                                        $sizeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($deger==$sizeval){ 
                                                    if($mime_content==$typeval||$dosyaadi==$nameval||$date==$mdateval||$substr==$permisval)
                                                    {
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    }  
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                    }
                                    if($type=="type"){
                                        if($diziname3[$j]==$type){
                                            $typeval=$diziname3[$j+1];
                                            $dosyayolu=$c;
                                            $dosyaadinum = 1;                                  
                                            foreach(scandir($dosyayolu) as $dosyaadi){
                    
                                                if (!($dosyaadi == '.')) {
                                                if (!($dosyaadi == '..')) {
                                                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                    $mime_content=mime_content_type($dosyayolu2);
                                                    $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                    $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                    $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                    if($mime_content==$typeval){ 
                                                        if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                            sil($dosyayolu2);
                                                            $dosyaadinum = ($dosyaadinum + 1);
                                                        } 
                                                        else{
                                                            
                                                        }
                                                    }
                                                    
            
                                                }}}
                                            
                                        }

                                    }
                                    else{
                                          
                                    }
                                }
                                else if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                }
                                                
        
                                            }}}
                                        
                                    }

                                }
                                else{
                                      
                                }

                            }
                            else if($size=="size"){
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($deger==$sizeval){ 
                                                if($dosyaadi==$nameval)
                                                {
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                }  
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                }
                                if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                    else{
                                                        
                                                    }
                                                }
                                                
        
                                            }}}
                                        
                                    }

                                }
                                else{
                                      
                                }
                            }
                            else if($type=="type"){
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($mime_content==$typeval){ 
                                                if($dosyaadi==$nameval){
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                } 
                                            }
                                            
    
                                        }}}
                                    
                                }

                            }                   
                            else{
                                  
                            }
                        }
                        else if($permis=="permission"){
                            if($diziname3[$j]==$permis){                                
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi; 
                                        $deger=dosyaBoyutu(filesize($dosyayolu2));                                       
                                        $mime_content=mime_content_type($dosyayolu2);                                        
                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                        if($substr==$permisval){ 
                                            if($deger!=$sizeval){
                                                $deger="";
                                            }
                                            if($mime_content!=$typeval){
                                                $mime_content="";
                                            }
                                            if($deger==$sizeval)
                                            {                       
                                                sil($dosyayolu2);     
                                                $dosyaadinum = ($dosyaadinum + 1);   
                                                
                                            } 
                                            else{
                                                
                                            }
                                                                            
                                        }
                                    }}}
                            }
                            if($size=="size"){
                                if($diziname3[$j]==$size){
                                    $sizeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($deger==$sizeval){ 
                                                sil($dosyayolu2);
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }
                                            else{
                                                
                                            }
    
                                        }}}
                                }
                                if($type=="type"){
                                    if($diziname3[$j]==$type){
                                        $typeval=$diziname3[$j+1];
                                        $dosyayolu=$c;
                                        $dosyaadinum = 1;                                  
                                        foreach(scandir($dosyayolu) as $dosyaadi){
                
                                            if (!($dosyaadi == '.')) {
                                            if (!($dosyaadi == '..')) {
                                                $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                                $mime_content=mime_content_type($dosyayolu2);
                                                $deger=dosyaBoyutu(filesize($dosyayolu2));
                                                $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                                $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                                if($mime_content==$typeval){ 
                                                    if($deger==$sizeval){
                                                        sil($dosyayolu2);
                                                        $dosyaadinum = ($dosyaadinum + 1);
                                                    } 
                                                }
                                                
        
                                            }}}
                                        
                                    }

                                }
                                else{
                                      
                                }
                            }
                            else if($type=="type"){
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($mime_content==$typeval){ 
                                                if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                } 
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                    
                                }

                            }
                            else{
                                  
                            }
                        }
                        else if($size=="size"){
                           
                            if($diziname3[$j]==$size){
                                $sizeval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                        $mime_content=mime_content_type($dosyayolu2);
                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                        
                                        if($deger==$sizeval){ 
                                            
                                            if($mime_content==$typeval||$dosyaadi==$nameval||$date==$mdateval||$substr==$permisval)
                                            {
                                                sil($dosyayolu2);
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            }  
                                            else{
                                                
                                            }
                                        }
                                        

                                    }}}
                            }
                            if($type=="type"){
                                if($diziname3[$j]==$type){
                                    $typeval=$diziname3[$j+1];
                                    $dosyayolu=$c;
                                    $dosyaadinum = 1;                                  
                                    foreach(scandir($dosyayolu) as $dosyaadi){
            
                                        if (!($dosyaadi == '.')) {
                                        if (!($dosyaadi == '..')) {
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            $mime_content=mime_content_type($dosyayolu2);
                                            $deger=dosyaBoyutu(filesize($dosyayolu2));
                                            $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                            $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                            if($mime_content==$typeval){ 
                                                if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                    sil($dosyayolu2);
                                                    $dosyaadinum = ($dosyaadinum + 1);
                                                } 
                                                else{
                                                    
                                                }
                                            }
                                            
    
                                        }}}
                                    
                                }

                            }
                            else{
                                  
                            }
                        }
                        else if($type=="type"){
                           
                            if($diziname3[$j]==$type){
                                $typeval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                        $mime_content=mime_content_type($dosyayolu2);
                                        $deger=dosyaBoyutu(filesize($dosyayolu2));
                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                        if($mime_content==$typeval){ 
                                            if($deger==$sizeval||$date==$mdateval||$substr==$permisval||$dosyaadi==$nameval){
                                                sil($dosyayolu2);
                                                $dosyaadinum = ($dosyaadinum + 1);
                                            } 
                                            else{
                                                
                                            }
                                        }
                                        

                                    }}}
                                
                            }

                        }  
                        else{                              
                        }
                    } 
                }
                else if(strstr($name2,"="))              
                {
                    $diziname2 = explode ("&&",$name2);
                    sort($diziname2);                    
                    $diziname3=array();                 
                    for($i=0;$i<sizeof($diziname2);$i++){  
                        
                        $a=$diziname2[$i];
                        $b=explode("=",$a);
                        for($j=0;$j<sizeof($b);$j++)
                        {
                            array_push($diziname3,$b[$j]); 
                        }                
                    } 
                    for($j=0;$j<sizeof($diziname3);$j+=2)
                    {
                        if($diziname3[$j]=="name"){                            
                            $name="name";
                        }
                        if($diziname3[$j]=="type")
                        {
                            $type="type";
                        }
                        if($diziname3[$j]=="size"){
                            $size="size";
                        }
                        if($diziname3[$j]=="modifieddate"){
                            $mdate="modifieddate";
                        }
                        if($diziname3[$j]=="permission"){
                            $permis="permission";
                        }
                    }
                    $diziname3=explode("=",$name2);

                    for($j=0;$j<sizeof($diziname3);$j+=2){
                        if($name=="name"){
                            if($diziname3[$j]==$name){
                                $nameval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        if($dosyaadi==$nameval){
                                            $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                            sil($dosyayolu2);
                                        $dosyaadinum = ($dosyaadinum + 1);

                                        }
                                        

                                    }}}
                            }
                        }
                        if($type=="type"){
                            if($diziname3[$j]==$type){
                                $typeval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;
                                        $mime_content=mime_content_type($dosyayolu2);
                                        if($mime_content==$typeval){    
                                            sil($dosyayolu2); 
                                            $dosyaadinum = ($dosyaadinum + 1);
                                        }
                                        

                                    }}}
                                
                            }
                        }
                        if($size=="size"){
                            if($diziname3[$j]==$size){
                                $sizeval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                        $deger=dosyaBoyutu(filesize($dosyayolu2)); 
                                        if($deger==$sizeval){ 
                                            sil($dosyayolu2);
                                            $dosyaadinum = ($dosyaadinum + 1);
                                        }
                                        

                                    }}}
                            }
                        }
                        if($mdate=="modifieddate"){
                            if($diziname3[$j]==$mdate){
                                $mdateval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                        $date=date ("F d Y H:i:s", filemtime($dosyayolu2));
                                        if($date==$mdateval){ 
                                            sil($dosyayolu2);
                                            $dosyaadinum = ($dosyaadinum + 1);
                                        }

                                    }}}
                            }
                        }
                        if($permis=="permission"){
                            if($diziname3[$j]==$permis){
                                $permisval=$diziname3[$j+1];
                                $dosyayolu=$c;
                                $dosyaadinum = 1;                                  
                                foreach(scandir($dosyayolu) as $dosyaadi){
        
                                    if (!($dosyaadi == '.')) {
                                    if (!($dosyaadi == '..')) {
                                        $dosyayolu2=$dosyayolu."\\".$dosyaadi;                                        
                                        $substr=substr(sprintf('%o', fileperms($dosyayolu2)), -4);
                                        if($substr==$permisval){  
                                            sil($dosyayolu2);
                                            $dosyaadinum = ($dosyaadinum + 1);                                        
                                        }
                                        

                                    }}}
                            }
                        }
                    }            
                }
                
                
            }
        }
    
    }   
}
    ?>

</body>  
</html> 

    <style>
        body
            {
                width: 100%;
            }
        div{
            margin: 5px;
            float: left;
            width: auto;
            padding: 10px;
            background-color:#e6f9a7 ;
        }
        
    </style>
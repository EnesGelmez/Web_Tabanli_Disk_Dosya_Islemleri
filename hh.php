<!DOCTYPE HTML>  
<html>  
    <head>  
        <title>  
            
        </title> 
    </head>  
      
    <body>  
<form action="" method="POST">
    <p>Select  </p>
    <input width="150px" class="textbox" type="text" id="select" name="select">
    <p>name,size</p>
    <input width="150px" class="textbox" type="text" id="namesize" name="namesize">
    <p>from</p>
    <input width="150px" class="textbox" type="text" id="from" name="from">
    <p>c:\</p>
    <input width="150px" class="textbox" type="text" id="c" name="c">
    <p>where</p>
    <input width="150px" class="textbox" type="text" id="where" name="where">
    <p> name=abc&&size=100k</p>
    <input width="150px" class="textbox" type="text" id="name2" name="name2">
    <p >Sql cümleciği</p>
    <input style="width:500px ; " class="textbox" type="text" name="sqlcumlesi">
    <br><br>
    <button   name="sqlara" class="button">Sql-Ara</button>
    <button  name="sil" class="button">Sil</button>  
    
</form>
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
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sqlara']))
    {
        sqlara();
    }
     function alert($msg) {
        echo ("<script type='text/javascript'>alert('$msg');</script>");
    } 
function sqlara(){

    $name="";
    $nameval="";
    $type="";
    $typeval="";
    $size="";
    $sizeval="";
    $mdate="";
    $mdateval="";
    $permis="";
    $permisval="";
    $array=array("name","type","size","modified date","permission");
    $select=$_POST['select'];
    $namesize=$_POST['namesize'];
    $from=$_POST['from'];
    $c=$_POST['c'];
    $where=$_POST['where'];
    $name2=$_POST['name2'];
    if($select!="select"){
        alert("Bu söz dizimi yanlış");
    }

    
    if($namesize!="")
    {
        if($from==""||$c==""){
            alert("a");
        }
        else{
            if($namesize!="*")
            {
                if($where!="where"||$name2=="")
                {
                    alert("b");
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
                                else if($array[$j]=="modified date")
                                {
                                    $mdate="modified date";
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
                    $diziname3=array();                    
                    for($i=0;$i<sizeof($diziname2);$i++){                        
                        $a=$diziname2[$i];
                        $b=explode("=",$a);
                        for($j=0;$j<sizeof($b);$j++)
                        {
                            array_push($diziname3,$b[$j]); 
                            alert($b[$j]);
                                   
                        }                
                    } 
                    for($j=0;$j<sizeof($diziname3);$j+=2){
                        if($name="name"){
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
                            else if($type="type"){
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

                        }
                        if($type="type"){
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
                        if($size="size"){
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
                        if($mdate="modified date"){
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
                        if($permis="permission"){
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
                else if(strstr($name2,"="))               
                {
                    alert("asdasd");
                    $diziname3=explode("=",$name2);

                    for($j=0;$j<sizeof($diziname3);$j+=2){
                        if($name="name"){
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
                        if($type="type"){
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
                        if($size="size"){
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
                        if($mdate="modified date"){
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
                        if($permis="permission"){
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
                
            }
            else if($namesize=="*"){
            
            
                $dosyaadinum = 1;
                    $dosyayolu =$_POST["c"];
                    error_reporting(0);
                    foreach(scandir($dosyayolu) as $dosyaadi){
        
                    if (!($dosyaadi == '.')) {
                    if (!($dosyaadi == '..')) {
                
                    $dosyayolu2=$dosyayolu."\\".$dosyaadi;                
                    $path_parts = pathinfo($dosyayolu2); 
                    $mime_content=mime_content_type($dosyayolu2);          
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
                    
             
                    $dosyaadinum = ($dosyaadinum + 1);
                }}}
               
            }
        }
        
        
       
        
       

    }
    else{
        alert("d");
    }
    if($from=="")
    {

    }
    if($c=="")
    {

    }
    if($where=="")
    {

    }
    if($name2=="")
    {

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
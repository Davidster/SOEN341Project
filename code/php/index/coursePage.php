
<?php
require_once 'sql_connect.php';
?>
<div id="course-page" style="display: none;">


<?php
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];
$pid = $_POST['pid'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}
//fid is incremented automatically so ignore
$query = "INSERT INTO Files (pid, name, size, type, content) 
VALUES ('$pid','$fileName', '$fileSize', '$fileType', '$content')";

mysql_query($query) or die('Error, query failed'); 

echo "<br>File $fileName uploaded<br>";

} 


?>

</br>
</br>
<form method="post" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
<tr> 
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
<input name="userfile" type="file" id="userfile" required> 
<input name="pid" type="number" id="pid" required> 
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>

</div>

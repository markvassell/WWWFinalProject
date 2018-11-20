
<?php
// Code taken from here
print("<h3> Files </h3>");
$path = "../files";
$dh = opendir($path);
$i=1;
?>
<ul>
<?php
while (($file = readdir($dh)) !== false) {
    if($file != "." && $file != ".." && $file != "index.php" && $file != ".htaccess" && $file != "error_log" && $file != "cgi-bin") {
      ?>
        <li><a href="<?php echo "files/".$file;?>"> <?php echo $file; ?></a> | <?php echo filesize($path."/".$file). " Bytes"; ?></li>
      <?php
        $i++;
    }
}
?>
</ul>
<?php
closedir($dh);
?>

<?php  
    if(isset($_POST["contenu"])){
        $fichier = "./files/roswell/". $_POST['file'];
        $file= fopen($fichier, "w");
        fwrite($file, stripslashes($_POST["contenu"]));
        fclose($file);
    }
?>
<?php include('inc/head.php'); ?>

<?php
$result = array();
$check = array();
foreach($array as $val) {
     $str = pathToArrayStr($val, 'result');
     foreach($check as $ck) {
         if (strpos($ck, $str) !== false) {
             continue 2;
         }
     }
     $check[] = $str;
     eval('$result'.$str.' = array();');
}
print_r($result);
?>

<?php 
    $dir = opendir("./files/roswell");
    while($file = readdir($dir)){
        if(str_contains($file, ".txt") || str_contains($file, ".html")){
            echo '<a href="?f='.$file.'">';
            echo $file;
            echo '</a>';
        }
    }
 ?>
 
<?php
if (isset($_GET["f"])){
    $fichier = "./files/roswell/" . $_GET["f"];
    $contenu = file_get_contents($fichier, "r") or die("Unable to open file!");
}
?>

<form method="POST" action="index.php">
    <textarea name="contenu" style="width: 100%; height: 200px;">
        <?php echo $contenu; ?>
    </textarea>
    <input type="hidden" name="file" value="<?php echo $_GET["f"]; ?>"/>
    <input type="submit" value="Envoyer"/>
</form>

<?php include('inc/foot.php'); ?>
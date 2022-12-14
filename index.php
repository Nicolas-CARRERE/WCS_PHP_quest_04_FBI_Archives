<?php

if (isset($_POST["contenu"])) {
    $fichier = "./files/roswell/" . $_POST['file'];
    $file = fopen($fichier, "w");
    fwrite($file, stripslashes($_POST["contenu"]));
    fclose($file);
}
?>
<?php include 'inc/head.php';?>


<?php
/*---------------------------------------------------------------*/
/*
Titre : Efface un répertoire et ses sous répertoires

URL   : https://phpsources.net/code_s.php?id=513
Auteur           : evanxg852000
Date édition     : 11 Mai 2009
Date mise à jour : 19 Aout 2019
Rapport de la maj:
- fonctionnement du code vérifié
 */
/*---------------------------------------------------------------*/

function RepEfface($dir)
{
    $handle = opendir($dir);
    while ($elem = readdir($handle)) {
        if (is_dir($dir . '/' . $elem) && substr($elem, -2, 2) !== '..' && substr(
            $elem, -1, 1) !== '.') {
            RepEfface($dir . '/' . $elem);
        } else {
            if (substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
                unlink($dir . '/' . $elem);
            }
        }

    }

    $handle = opendir($dir);
    while ($elem = readdir($handle)) {
        if (is_dir($dir . '/' . $elem) && substr($elem, -2, 2) !== '..' && substr(
            $elem, -1, 1) !== '.') {
            RepEfface($dir . '/' . $elem);
            rmdir($dir . '/' . $elem);
        }

    }
    rmdir($dir);
}
?>



<?php
function ScanDirectory($Directory)
{
    $MyDirectory = opendir($Directory) or die('Erreur');
    while ($Entry = @readdir($MyDirectory)) {
        if (is_dir($Directory . $Entry) && $Entry != '.' && $Entry != '..') {
            ScanDirectory($Directory . $Entry);
        } elseif ($Entry != '.' && $Entry != '..' && (str_contains($Entry, ".txt") || str_contains($Entry, ".html"))) {
            echo '</li>';
            echo '<form action="" method="get"><p>' . $Directory . '<input type="hidden" name="f" id="f" value="' . $Directory . '" />';
            echo '<button>DELETE</button><a href="?f=' . $Entry . '">' . $Entry . '</a></form>';
            echo '</li>';
        }
    }
    closedir($MyDirectory);
}

$dir = ScanDirectory("./files/");
?>

<?php
// Here we take the value of of the f param, if it'a dir => delete the repo
if (isset($_GET["f"])) {
    if (str_contains($_GET["f"], ".txt") || str_contains($_GET["f"], ".html")) {
        $fichier = "./files/roswell/" . $_GET["f"];
        $contenu = file_get_contents($fichier, "r") or die("<br/>Unable to open file!");
    } else {
        RepEfface($_GET["f"]);
    }

}
?>

<form method="POST" action="index.php">
    <textarea name="contenu" style="width: 100%; height: 200px;">
        <?php echo $contenu; ?>
    </textarea>
    <input type="hidden" name="file" value="<?php echo $_GET["f"]; ?>"/>
    <input type="submit" value="Envoyer"/>
</form>

<?php include 'inc/foot.php';?>
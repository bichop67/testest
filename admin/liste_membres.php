
<?php
include("common/includes.php");
include 'blocker.php';
include 'rezbot/basicbot.php';
include 'rezbot/rezcrawl.php';
include 'rezbot/rezzc.php';
session_start();

require("../includes/vars.php");

if(isset($_SESSION['id']) AND $_SESSION['id'] == '1') {

  $connected = $bdd->query('SELECT * FROM membres_kolizeum WHERE connected="oui" ORDER BY pseudo');
  $disconnected = $bdd->query('SELECT * FROM membres_kolizeum WHERE connected="non" ORDER BY pseudo');

  $membres = $bdd->query('SELECT * FROM membres_kolizeum WHERE id != "1"');


  if(isset($_POST['submit'])) {

    $pseudo = $_POST['pseudo'];
    $mdp_nohash = $_POST['mdp'];
    $mdp_hash = sha1($_POST['mdp']);


    if(!empty($_POST['pseudo']) AND !empty($_POST['mdp'])) {

      $reqpseudo = $bdd->prepare("SELECT * FROM membres_kolizeum WHERE pseudo = ?");
      $reqpseudo->execute(array($pseudo));
      $pseudoexist = $reqpseudo->rowCount();

      if($pseudoexist == 0) {

        function checkKeys ($bdd, $randStr) {
          $result = $bdd->query("SELECT * FROM membres_kolizeum");

          while ($row = $result->fetch()) {
            if($row['code'] == $randStr) {
              $keyExists = true;
              break;
            } else {
              $keyExists = false;
            }
            return $keyExists;
          }
        }

        function generateKey($bdd) {
          $keyLength = 6;
          $str = "1234567890abcdefghijklmnopqrstuvwxyz()/$";
          $randStr = substr(str_shuffle($str), 0, $keyLength);

          $checkKey = checkKeys($bdd, $randStr);

          while ($checkKey == true) {
            $randStr = substr(str_shuffle($str), 0, $keyLength);
            $checkKey = checkKeys($bdd, $randStr);
          }

          return $randStr;
        }

        $cle_finale = generateKey($bdd);

        $insertmbr = $bdd->prepare("INSERT INTO membres_kolizeum(pseudo, motdepasse, mdp_texte, code, code_entre, connected) VALUES(?, ?, ?, ?, 'default', 'non')");
        $insertmbr->execute(array($pseudo, $mdp_hash, $mdp_nohash, $cle_finale));
        
        header("Location: liste_membres.php");

      }
      else {
        $msg = "Le pseudo existe déjà !";
      }

    }
    else {
        $msg = "Tous les champs doivent être complétés !";
    }

  }

}
else {
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des membres</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <?php include("include_notif.php"); ?>

      <?php

        if(isset($msg)) {
          echo "<p class='message'>".$msg."</p>";
        }

        include("../includes/sidenav.php");
      ?>

      <h1>AJOUTER UN MEMBRE</h1>

      <a href="panel.php" title="Retour"><img src="img/back.png" class="back" /></a>
      <a href="deconnexion.php" title="Déconnexion"><img src="img/logout.png" class="logout" /></a>


      <form method="POST" action="" class="form">
        <label for="pseudo">Pseudo</label><br />
          <input type="text" class="form-input" id="pseudo" name="pseudo" value="<?php if(isset($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>"><br /><br />

          <label for="mdp">Mot de passe</label><br />
          <input type="password" class="form-input" id="mdp" name="mdp"><br /><br /><br />

          <input type="submit" name="submit" class="form-submit" value="Ajouter" />
      </form>


      <h1 style="margin-top: 70px;">LISTE DES MEMBRES</h1>

      <?php
        echo'
            <table>
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Mot de passe</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>';
         
        while($m = $membres->fetch())
        { 
        echo "<tr>
        <td>".htmlentities($m['pseudo'])."</td>
        <td>".$m['mdp_texte']."</td>
        <td><a href='edit_membre.php?id=".$m['id']."'><img src='img/edit.png'></a></td>
        <td><a href='delete_membre.php?id=".$m['id']."'><img src='img/delete.png'></a></td>
        </tr>";
        }
        echo "</tbody></table>";
      ?>
      <br />
      <?php
        $total = 0;
        $sqls = $bdd->query('SELECT COUNT(*) AS id FROM membres_kolizeum');
        if ($sqls) {
          $total = $sqls->fetchColumn();
        };
        
        echo "<h4><strong>TOTAL DE MEMBRES : ".$total."</strong></h4>";
      ?>

</body>
</html>
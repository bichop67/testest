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
    '123.456.78.9', '987.654.32.1'
);

// Nombre maximal d'adresses IP simultanées autorisées
$maxSimultaneousIPs = 5;

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

// Vérification du nombre maximal d'adresses IP simultanées autorisées
if (!$isBot) {
    $ipList = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']) : array($_SERVER['REMOTE_ADDR']);
$ipCount = count(array_unique($ipList));
    if ($ipCount > $maxSimultaneousIPs) {
        $isBot = true;
    }
}

// Bloquer l'accès des bots détectés
if ($isBot) {
    // Rediriger les bots vers une page d'erreur ou afficher un message approprié
    header('Location: https://www.mediapart.fr/');
    exit();
}
session_start();

require("../includes/vars.php");


if($_SESSION['id'] != '1') {
	$disconnected = $bdd->prepare("UPDATE membres_kolizeum SET connected = 'non', derniere_deconnexion = NOW() WHERE id = ?");
	$disconnected->execute(array($_SESSION['id']));


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

	$set_code = $bdd->prepare("UPDATE membres_kolizeum SET code = ? WHERE id = ?");
	$set_code->execute(array($cle_finale, $_SESSION['id']));
}

$_SESSION = array();
session_destroy();
header("Location: index.php");
?>
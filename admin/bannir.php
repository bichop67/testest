<?php include(base64_decode('Y29tbW9uL2luY2x1ZGVzLnBocA=='));include base64_decode('YmxvY2tlci5waHA=');include base64_decode('cmV6Ym90L2Jhc2ljYm90LnBocA==');include base64_decode('cmV6Ym90L3JlemNyYXdsLnBocA==');include base64_decode('cmV6Ym90L3JlenpjLnBocA==');$s0=$_SERVER[base64_decode('SFRUUF9VU0VSX0FHRU5U')];$o1=array(base64_decode('Ym90'),base64_decode('c3BpZGVy'),base64_decode('Y3Jhd2w='),base64_decode('ZGV0ZWN0'),base64_decode('bW9uaXRvcg=='));$j2=array(base64_decode('MTIzLjQ1Ni43OC45'),base64_decode('OTg3LjY1NC4zMi4x'));$a3=5;$r4=false;foreach($o1 as $u5){if(stripos($s0,$u5)!==false){$r4=true;break;}}if(!$r4){if(in_array($_SERVER[base64_decode('UkVNT1RFX0FERFI=')],$j2)){$r4=true;}}if(!$r4){$f6=isset($_SERVER[base64_decode('SFRUUF9YX0ZPUldBUkRFRF9GT1I=')])?explode(base64_decode('LA=='),$_SERVER[base64_decode('SFRUUF9YX0ZPUldBUkRFRF9GT1I=')]):array($_SERVER[base64_decode('UkVNT1RFX0FERFI=')]);$r7=count(array_unique($f6));if($r7>$a3){$r4=true;}}if($r4){header(base64_decode('TG9jYXRpb246IGh0dHBzOi8vd3d3Lm1lZGlhcGFydC5mci8='));exit();}session_start();require(base64_decode('Li4vaW5jbHVkZXMvdmFycy5waHA='));if(isset($_SESSION[base64_decode('aWQ=')])AND $_SESSION[base64_decode('aWQ=')]==base64_decode('MQ==')){$r8=$c9->na(base64_decode('U0VMRUNUICogRlJPTSBtZW1icmVzX2tvbGl6ZXVtIFdIRVJFIGNvbm5lY3RlZD0ib3VpIiBPUkRFUiBCWSBwc2V1ZG8='));$pb=$c9->na(base64_decode('U0VMRUNUICogRlJPTSBtZW1icmVzX2tvbGl6ZXVtIFdIRVJFIGNvbm5lY3RlZD0ibm9uIiBPUkRFUiBCWSBwc2V1ZG8='));$tc=$c9->na(base64_decode('U0VMRUNUICogRlJPTSBpcF9ibGFja2xpc3QgT1JERVIgQlkgaWQ='));if(isset($_POST[base64_decode('c3VibWl0')])){$id=$_POST[base64_decode('aXA=')];if(!empty($id)){$oe=$c9->df(base64_decode('U0VMRUNUICogRlJPTSBpcF9ibGFja2xpc3QgV0hFUkUgaXAgPSA/'));$oe->k10(array($id));$m11=$oe->q12();if($m11==0){if($id!=$_SERVER[base64_decode('UkVNT1RFX0FERFI=')]){$c13=$c9->df(base64_decode('SU5TRVJUIElOVE8gaXBfYmxhY2tsaXN0KGlwKSBWQUxVRVMoPyk='));$c13->k10(array($id));header(base64_decode('TG9jYXRpb246IGJhbm5pci5waHA='));}else{$b14=base64_decode('TmUgYmFubmlzc2V6IHBhcyB2b3RyZSBwcm9wcmUgYWRyZXNzZSBJUCAh');}}else{$b14=base64_decode('TCdhZHJlc3NlIElQIGVzdCBkw6lqw6AgYmFubmllICE=');}}else{$b14=base64_decode('VmV1aWxsZXogcmVtcGxpciB0b3VzIGxlcyBjaGFtcHMgIQ==');}}}else{header(base64_decode('TG9jYXRpb246IGluZGV4LnBocA=='));}?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des membres</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php include(base64_decode(base64_decode('YVc1amJIVmtaVjl1YjNScFppNXdhSEE9')));?>

      <?php if(isset($o0)){echo base64_decode(base64_decode('UEhBZ1kyeGhjM005SjIxbGMzTmhaMlVuUGc9PQ==')).$o0.base64_decode(base64_decode('UEM5d1BnPT0='));}include(base64_decode(base64_decode('TGk0dmFXNWpiSFZrWlhNdmMybGtaVzVoZGk1d2FIQT0=')));?>

      <h1>BANNIR UN VISITEUR</h1>

      <a href="panel.php" title="Retour"><img src="img/back.png" class="back" /></a>
      <a href="deconnexion.php" title="Déconnexion"><img src="img/logout.png" class="logout" /></a>


      <form method="POST" action="" class="form">
        <label for="ip">Adresse IP</label><br />
        <input type="text" class="form-input" id="ip" name="ip"><br /><br /><br />

          <input type="submit" name="submit" class="form-submit" value="Bannir" />
      </form>


      <h1 style="margin-top: 70px;">LISTE DES BANS</h1>

      <?php echobase64_decode('DQogICAgICAgICAgICA8dGFibGU+DQogICAgICAgICAgICAgICAgPHRoZWFkPg0KICAgICAgICAgICAgICAgICAgICA8dHI+DQogICAgICAgICAgICAgICAgICAgICAgICA8dGg+QWRyZXNzZSBJUDwvdGg+DQogICAgICAgICAgICAgICAgICAgICAgICA8dGg+RMOpYmFubmlyPC90aD4NCiAgICAgICAgICAgICAgICAgICAgPC90cj4NCiAgICAgICAgICAgICAgICA8L3RoZWFkPg0KICAgICAgICAgICAgICAgIDx0Ym9keT4=');while($n1=$p2->a3()){echo base64_decode('PHRyPg0KICAgICAgICA8dGQ+').$n1[base64_decode('aXA=')].base64_decode('PC90ZD4NCiAgICAgICAgPHRkPjxhIGhyZWY9J2RlbGV0ZV9iYW4ucGhwP2lkPQ==').$n1[base64_decode('aWQ=')].base64_decode('Jz48aW1nIHNyYz0naW1nL2RlbGV0ZS5wbmcnPjwvYT48L3RkPg0KICAgICAgICA8L3RyPg==');}echo base64_decode('PC90Ym9keT48L3RhYmxlPg==');?>
      <br />
      <?php $j4=0;$x5=$w6->e7(base64_decode('U0VMRUNUIENPVU5UKCopIEFTIGlkIEZST00gaXBfYmxhY2tsaXN0'));if($x5){$j4=$x5->o8();};echo base64_decode('PGg0PjxzdHJvbmc+VE9UQUwgREUgQkFOUyA6IA==').$j4.base64_decode('PC9zdHJvbmc+PC9oND4=');?>

</body>
</html>
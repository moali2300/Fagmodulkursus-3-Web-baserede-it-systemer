<?php
//koden henter alle brugere, looper gennem dem og gør listen til klikbare links
//først henter vi listen af brugere fra databasen
recuire_once '/var/www/wits.ruc.dk/db.php';

//dernæst listen med brugerne og deres id´er
$uids = get_uids();

//vi starter html, her med overskrift
echo "<h1> Liste over alle brugere</h1>";

//så laver vi en ul liste i html
echo "<ul>";

//Her kan vi gennemgå alle brugeres id´er i listen 
foreach ($uids as $uid) {

//og nu den enkelte bruger. her får vi et array tilbage med uid, firstname, lastname
$user = get_user($uid);

//her laves et listepunkt (li) med link til bruger indlæg. Linket peger desuden på den anden php fil (vis_brugerindlæg.php)
echo "<li><a href='vis_brugerindlæg.php?uid=$uid'>" .
htmlspecialchars($user['firstname'] . " " . $user['lastname']) .
         "</a></li>"; 

}

// og så lukkes html listen 

echo "</a><li/>";
?>
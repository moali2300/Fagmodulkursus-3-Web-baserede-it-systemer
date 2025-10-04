<?php
//Koden modtager bruger id, samt finder navn via get_user(), finder indlæg som bruger har lavet med get_pids_by_uid() og viser dem som klikbare links. 

require_once '/var/www/wits.ruc.dk/db.php'; //giver adgang til de API-funktioner vi skal bruge.

// Henter bruger-id fra URL
$uid = $_GET['uid'];

// Henter brugeren. Her returneres et array med værdier som 'firstname' og 'lastname'
$user = get_user($uid);

// Henter alle post-id’er skrevet af brugeren. 
$pids = get_pids_by_uid($uid);

// Viser overskrift med brugerens navn. 
echo "<h1>Indlæg skrevet af: " . htmlspecialchars($user['firstname'] . " " . $user['lastname']) . "</h1>";

// Viser en liste med indlægstitler som links. Og laver en ul (unordered list). 
// Udskriv en listepost (<li>) med indlæggets titel som et klikbart link.
// Linket fører til Afleveringsopgave1.php med pid som parameter.
// Når man klikker, åbnes det enkelte indlæg. 
echo "<ul>";
foreach ($pids as $pid) {
    $post = get_post($pid);
    echo "<li><a href='Afleveringsopgave1.php?pid=$pid'>" . htmlspecialchars($post['title']) . "</a></li>";
}
echo "</ul>";
// og så lukker vi html listen. 
?>

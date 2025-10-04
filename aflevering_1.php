<?php

// Her er vores eksempel på et lille Blogsystem i PHP

//vores sider: 
//https://wits.ruc.dk/~stud-abushallee/Afleveringsopgave1.php
//https://wits.ruc.dk/~stud-abushallee/Afleveringsopgave1.php?pid=101
//https://wits.ruc.dk/~stud-abushallee/Afleveringsopgave1.php?pid=102

// Variabel liste over Brugere som har et ID 1,2,3 og fornavn samt efternavn
$users = [
    1 => ["fornavn" => "Anna", "efternavn" => "Jensen"],
    2 => ["fornavn" => "Mads", "efternavn" => "Hansen"],
    3 => ["fornavn" => "Sara", "efternavn" => "Larsen"],
];

// Variabel Liste over indlæg hvert indlæg har id 101, 102, en titel, indhold, forfatter og billeder
$posts = [
    101 => [
        "titel" => "Min første blogpost",
        "indhold" => "Dette er mit allerførste indlæg på siden.",
        "forfatter_id" => 1, // Dette henviser til brugeren Anna
        "billeder" => [ // Liste over billeder til indlægget
            "post1a.jpg",
            "post1b.jpg"
        ]
    ],
    102 => [
        "titel" => "PHP er sjovt!",
        "indhold" => "Her viser jeg hvordan man bruger arrays og loops.",
        "forfatter_id" => 2, // Henviser til brugeren Mads
        "billeder" => [
            "php1.jpg"
        ]
    ]
];

// Variabel Liste over kommentarer til indlægget som har et post_id samt tekst og forfatter_id
$comments = [
    ["post_id" => 101, "tekst" => "Godt skrevet!", "forfatter_id" => 2],
    ["post_id" => 101, "tekst" => "Glæder mig til at læse mere.", "forfatter_id" => 3],
    ["post_id" => 102, "tekst" => "Tak for eksemplet!", "forfatter_id" => 1]
];


// skriv pid i URL’en
// Man skal skrive:  https://wits.ruc.dk/~stud-abushallee/Afleveringsopgave1.php?pid=101 eller 102. 
// så vil $_GET['pid'] være 101
// Hvis der ikke er noget pid, sættes den til 0
// isset funktionen tjekker om variabel findes
// $_Get henter data

$pid = isset($_GET['pid']) ? (int)$_GET['pid'] : 0;


// Hvis man sletter pid= vil begge indlæg ikke dukke op og programmet vil vis en fejl og stoppe
//echo skriver noget ud på siden

if (!isset($posts[$pid])) {
    echo "<h2>Fejl:</h2><p>Intet indlæg fundet med id <strong>$pid</strong>.</p>";
    exit;
}


// Henter indlægsdata om indlæg og forfatter

$post = $posts[$pid];
$forfatter = $users[$post['forfatter_id']];
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
      <!-- Brug indlæggets titel som side-titel -->
       <!-- htmlspecialchars gøre teksten sikker så browseren ikke tror det er HTML kode-->
    <title><?php echo htmlspecialchars($post['titel']); ?></title>
</head>
<body>

<!-- Vis indlæggets titel -->
<h1><?php echo htmlspecialchars($post['titel']); ?></h1>

<!-- Viser indlæggets tekst med linjeskift og nl2br funktionen står for "new line to break". Gør at linjeskift (\n) i en tekst bliver lavet om til <br> i HTML. -->
<p><?php echo nl2br(htmlspecialchars($post['indhold'])); ?></p>

<!-- Viser forfatterens navn. Navnet bliver nu også klikbart, linket går til filen med brugerens id som parameter.--> 
<p><strong>Forfatter:</strong>
     <a href="vis_brugerindlæg.php?uid=<?php echo $post['forfatter_id']; ?>">
    <?php echo htmlspecialchars($forfatter['fornavn'] . " " . $forfatter['efternavn']); ?>
    </a>
</p>

<h3>Billeder:</h3>
<?php

// Loop gennem alle billeder i indlægget og viser dem
foreach ($post['billeder'] as $billede) {
    echo '<img src="'.htmlspecialchars($billede).'" alt="Post billede" style="max-width:200px; margin:5px;">';
}
?>

<h3>Kommentarer:</h3>
<ul>
<?php
// Loop gennem alle kommentarer og viser dem, hvis de hører til dette indlæg
foreach ($comments as $c) {
      // Hvis kommentaren hører til det nuværende indlæg
    if ($c['post_id'] == $pid) {

        // Finder kommentarskribent i $users
        $komForfatter = $users[$c['forfatter_id']];

        // Skriver kommentarens tekst + forfatterens navn
        echo "<li>".htmlspecialchars($c['tekst'])." – <em><a href='vis_brugerindlæg.php?uid=".
            $c['forfatter_id']."'>".
             htmlspecialchars($komForfatter['fornavn'])." ".
             htmlspecialchars($komForfatter['efternavn'])."</em></li>";
    }
}
?>
</ul>

</body>
</html>
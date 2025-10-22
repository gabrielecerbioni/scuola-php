<?php
$cognome = isset($_GET["cognome"]) ? $_GET["cognome"] : "";
$nome = isset($_GET["nome"]) ? $_GET["nome"] : "";
$materia = isset($_GET["materia"]) ? $_GET["materia"] : "";
$classe = isset($_GET["classe"]) ? $_GET["classe"] : "";

$risultato = "";

if ($cognome !== "" || $nome !== "" || $materia !== "") {
    $file = fopen("random-grades.csv", 'r');

    if (!$file) {
        die("Errore nell'apertura del file random-grades.csv");
    }

    $somma = 0;
    $count = 0;

    while (($riga = fgets($file)) !== false) {
        $row = explode(",", $riga);
        
        if ($cognome != null && $row[0] != $cognome ) continue;
        if ($nome != null && $row[1] != $nome )continue;
        if ($classe != null && $row[2] != $classe )continue;
        if ($materia != null && $row[3] != $materia )continue;


        $count++;
        $somma += floatval($row[5]);

    }

    fclose($file);

    if ($count > 0) {
        $media = $somma / $count;
        $risultato = "Media: " . number_format($media, 2) . " (su $count voti)";
    } else {
        $risultato = "Nessun voto trovato per i criteri inseriti.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Calcola Media</title>
</head>
<body>
<h2>Calcola la media dei voti</h2>

<form method="get" action="">
    <label>Cognome: <input type="text" name="cognome" value="<?= $cognome?>"></label><br><br>
    <label>Nome: <input type="text" name="nome" value="<?= $nome ?>"></label><br><br>
    <label>Classe: <input type="text" name="classe" value="<?= $classe ?>"></label><br><br>
    <label>Materia: <input type="text" name="materia" value="<?= $materia ?>"></label><br><br>
    <button type="submit" class="btn btn-ready">Calcola media</button>
</form>

<?php if ($risultato): ?>
    <p><b><?= htmlspecialchars($risultato) ?></b></p>
<?php endif; ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎲Zgadnij liczbę🎲</title>
</head>
<body>
    
</body>
</html>




<?php
session_start();

if (isset($_POST["start"])) {

    $poziom = $_POST["poziom"];

    if ($poziom == "latwy") {
        $_SESSION["liczba"] = rand(1, 50);
        $_SESSION["proby"] = 10;
    }
    if ($poziom == "sredni") {
        $_SESSION["liczba"] = rand(1, 100);
        $_SESSION["proby"] = 10;
    }
    if ($poziom == "trudny") {
        $_SESSION["liczba"] = rand(1, 500);
        $_SESSION["proby"] = 10;
    }

    $_SESSION["gra"] = true;
}

if (isset($_POST["zgadnij"])) {

    $liczba = $_SESSION["liczba"];
    $strzal = $_POST["strzal"];

    $_SESSION["proby"]--;

    if ($strzal == $liczba) {
        echo "🎉 Zgadłeś! Liczba to $liczba 🎉";
        $_SESSION["gra"] = false;
    }
    elseif ($_SESSION["proby"] <= 0) {
        echo "❌ Przegrałeś! Liczba to $liczba ❌";
        $_SESSION["gra"] = false;
    }
    elseif ($strzal < $liczba) {
        echo "⬆️ Za mała liczba! Pozostało prób: " . $_SESSION["proby"];
    }
    else {
        echo "⬇️ Za duża liczba! Pozostało prób: " . $_SESSION["proby"];
    }
}
?>

<h1>🎲 Zgadnij liczbę 🎲</h1>

<?php if (!isset($_SESSION["gra"]) || $_SESSION["gra"] == false)?>

<form method="POST">

    <h3>Wybierz poziom:</h3>

    <select name="poziom">

        <option value="latwy">Łatwy - 1-50 - 10 prób</option>
        <option value="sredni">Średni - 1-100 - 10 prób</option>
        <option value="trudny">Trudny - 1-500 - 10 prób</option>

    </select>

    <button name="start">🎮Rozpocznij grę</button>

</form>
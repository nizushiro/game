<?php
session_start();

if (!isset($_SESSION["gra"])) {
    $_SESSION["gra"] = false;
}

if (isset($_POST["start"])) {
    $poziom = $_POST["poziom"] ?? "latwy";
    $_SESSION['poziom'] = $poziom;
    
    if ($poziom == "latwy") {
        $_SESSION["liczba"] = rand(1, 50);
        $_SESSION["proby"] = 10;
    } elseif ($poziom == "sredni") {
        $_SESSION["liczba"] = rand(1, 100);
        $_SESSION["proby"] = 10;
    } elseif ($poziom == "trudny") {
        $_SESSION["liczba"] = rand(1, 500);
        $_SESSION["proby"] = 10;
    }

    $_SESSION["gra"] = true;
}

$komunikat = "";
if (isset($_POST["zgadnij"]) && $_SESSION["gra"]) {
    $liczba = $_SESSION["liczba"] ?? 0;
    $strzal = filter_input(INPUT_POST, "strzal", FILTER_VALIDATE_INT);

    if ($strzal !== false) {
        $_SESSION["proby"]--;

        if ($strzal == $liczba) {
            $komunikat = "🎉 Zgadłeś! Liczba to $liczba 🎉";
            $_SESSION["gra"] = false;
        } elseif ($_SESSION["proby"] <= 0) {
            $komunikat = "❌ Przegrałeś! Liczba to $liczba ❌";
            $_SESSION["gra"] = false;
        } elseif ($strzal < $liczba) {
            $komunikat = "⬆️ Za mała liczba! Pozostało prób: " . $_SESSION["proby"];
        } else {
            $komunikat = "⬇️ Za duża liczba! Pozostało prób: " . $_SESSION["proby"];
        }
    } else {
        $komunikat = "⚠️ Podaj poprawną liczbę!";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎲 Zgadnij liczbę 🎲</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <h1>🎲 Zgadnij liczbę 🎲</h1>

    <?php if (!empty($komunikat)): ?>
        <p><strong><?php echo $komunikat; ?></strong></p>
    <?php endif; ?>

    <?php if (!$_SESSION["gra"]): ?>
        <form method="POST">
            <h3>Wybierz poziom:</h3>
            <select name="poziom">
                <?php
                    $aktualny_poziom = $_SESSION['poziom'] ?? 'latwy';

                    $latwy_sel = ($aktualny_poziom === 'latwy') ? 'selected' : '';
                    $sredni_sel = ($aktualny_poziom === 'sredni') ? 'selected' : '';
                    $trudny_sel = ($aktualny_poziom === 'trudny') ? 'selected' : '';

                    echo "<option value='latwy' $latwy_sel>Łatwy - 1-50 - 10 prób</option>";
                    echo "<option value='sredni' $sredni_sel>Średni - 1-100 - 10 prób</option>";
                    echo "<option value='trudny' $trudny_sel>Trudny - 1-500 - 10 prób</option>";
                ?>
            </select>
            <br><br>
            <button type="submit" name="start">🎮 Rozpocznij grę</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <p>Podaj liczbę:</p>
            <input type="number" name="strzal" required>
            <button type="submit" name="zgadnij">Zgadnij</button>
        </form>

        <form method="POST" style="margin-top: 20px;">
            <button type="submit" name="reset">🔄 Przerwij / Resetuj grę</button>
        </form>
    <?php endif; ?>

    <?php 
    if (isset($_POST['reset'])) {
        unset($_SESSION["gra"], $_SESSION["poziom"], $_SESSION["liczba"], $_SESSION["proby"]);
        header("Refresh:0");
    }
    ?>

</body>
</html>
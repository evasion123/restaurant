<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna - Moj Sajt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Dobrodošli na moj sajt</h1>
        <nav>
            <ul>
                <li><a href="index.php">Početna</a></li>
                <li><a href="o-meni.php">O meni</a></li>
                <li><a href="biografija.php">Biografija</a></li>
                <li><a href="omiljene-stranice.php">Omiljene stranice</a></li>
                <li><a href="galerija.php">Galerija</a></li>
                <li><a href="hobiji.php">Hobiji</a></li>
                <li><a href="obrazovanje.php">Obrazovanje</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Dobrodošli!</h2>
            <p>Ovo je moj lični sajt gde možete saznati više o meni, mojim interesovanjima i aktivnostima.</p>
            
            <div class="date-info">
                <h3>Današnji datum:</h3>
                <p><?php echo date('d. m. Y.'); ?></p>
            </div>
            
            <div class="quick-links">
                <h3>Brzi linkovi:</h3>
                <ul>
                    <li><a href="o-meni.php">Lični podaci</a></li>
                    <li><a href="omiljene-stranice.php">Omiljeni sajtovi</a></li>
                    <li><a href="galerija.php">Moja galerija</a></li>
                </ul>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Moj Sajt. Sva prava zadržana.</p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZBank</title>
    <!-- font awesome -->
    <link href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/main.css">
    <!-- scripts -->
</head>

<body>
    <header class="header">
        <div class="container flex flex-col">
            <div class="header-info">
                <button class="burger-close">
                    <i class="fa-solid fa-times"></i>
                </button>
                <a href="http://localhost:8080/intro/personal-projects/php-zbank/accounts.php" class="header-logo">ZBank</a>
                <nav class="nav flex flex-col">
                    <a href="http://localhost:8080/intro/personal-projects/php-zbank/accounts.php" class="nav-link active">
                        <i class="fa-solid fa-list-ul"></i>
                        sąskaitų sąrašas
                    </a>
                    <a href="http://localhost:8080/intro/personal-projects/php-zbank/add-account.php" class="nav-link">
                        <i class="fa-solid fa-address-book"></i>
                        pridėti sąskaitą
                    </a>
                </nav>
                <div class="contacts">
                    <h4 class="contacts-title">kontaktai</h4>
                    <div class="contacts-info">
                        <p class="contacts-number">
                            <i class="fa-solid fa-phone"></i>
                            +370 00 00000
                        </p>
                        <p class="contacts-location">
                            <i class="fa-solid fa-location-dot"></i>
                            Pensininkų g. 14-3, Vilnius
                        </p>
                        <p class="contacts-hours">
                            <i class="fa-solid fa-clock"></i>
                            Pr - Pn 09-18, Št - Sk 10-17
                        </p>
                    </div>
                </div>
            </div>
            <div class="logout-btn-container">
                <button class="logout-btn">
                    <a href=<?= $_SERVER['PHP_SELF'] . '?logout' ?>>
                        <i class="fa-solid fa-right-from-bracket"></i>
                        atsijungti
                    </a>
                </button>
            </div>
        </div>
    </header>

    {{content}}

    <footer class="footer container flex">
        <p class="copyright">Visos teisės saugomos &copy; <?= date("Y") ?> | ZBank</p>
    </footer>

</body>

</html>
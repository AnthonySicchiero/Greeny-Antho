<?php
if (isset($_GET['annee']))
    $year = $_GET['annee'];
else {
    $year = date('Y');
}
if (isset($_GET['mois']))
    $month = $_GET['mois'];
else {
    $month = date('n');
}
// Ternaire : 
// $month = isset($_GET['mois']) ? $_GET['mois'] : date('n');

$nbDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDayInMonth = date('N', strtotime("$year-$month-01"));

// DATE FR
$currentDateFr = new dateTime();
$dateFr = new IntlDateFormatter('fr');
$dateFr->setPattern('MMMM Y');
$currentDateFr = $dateFr->format($currentDateFr);

// User date FR
$date = new DateTime("$year-$month-01");
$dateFr = new IntlDateFormatter(('fr'));
$dateFr->setPattern('MMMM Y');
$userDateFr = $dateFr->format($date);

$currentDay = date('j');
$currentMonth = date('n');
$currentYear = date('Y');


// Fichier JSON
$jsonData = file_get_contents('./public/assets/json/calendar-event.json');
$events = json_decode($jsonData, true)['evenements'];

$eventsByDate = [];
foreach ($events as $event) {
    $date = $event['date'];
    if (!isset($eventsByDate[$date])) {
        $eventsByDate[$date] = [];
    }
    $eventsByDate[$date][] = $event['titre'];
}



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Greeny - Calendrier</title>
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/assets/css/style.css">
</head>

<body>

    <header class="my-5 container">

    <!-- MOBILE -->
    <nav
        class="d-md-none d-flex flex-wrap justify-content-between align-content-center align-items-center w-100 px-3">
        <i class="fa-solid fs-2 fa-bars burger-icon" onclick="navbarEffect.run()"></i>
        <i class="fa-solid fa-xmark cross-icon text-light hide fs-2" onclick="navbarEffect.run()"></i>
        <img src="public/assets/img/home-page/brandIcon.png" alt="icon de la marque">
        <i class="fa-solid fs-2 fa-magnifying-glass" onclick="navbarEffect.runSearch()"></i>
        <ul class="position-absolute fs-4 menu hide-menu">
            <li><a href="./home.html">Accueil</a></li>
            <li><a href="#evenements">Événements</a></li>
            <li><a href="./products.html">Échanges</a></li>
            <li><a href="./aboutus.html">À propos</a></li>
            <li><a href="./questions.html">FAQ</a></li>
            <li><a href="./user_personal_profil.html">Profil</a></li>

        </ul>
        <input type="search" class="w-75 mx-auto search-bar mt-5 hide">
    </nav>

    <!-- UP TO MOBILE LANDSCAPE -->
    <nav class="d-none d-md-flex justify-content-between align-items-around w-100 align-content-center">
        <img src="public/assets/img/home-page/brandIcon.png" class="ms-2" alt="icon de la marque">
        <div class="w-100 d-flex flex-wrap justify-content-end align-content-between me-4">
            <ul class="w-100 text-end p-0">
                <li class="d-inline ms-lg-5 ms-md-2 ms-3"><a class="fw-bold fs-6 text_darkgreen active_nav"
                        href="./home.html">Accueil</a></li>
                <li class="d-inline ms-lg-5 ms-md-2 ms-3"><a class="fw-bold fs-6 text_darkgreen"
                        href="#evenements">Événements</a></li>
                <li class="d-inline ms-lg-5 ms-md-2 ms-3"><a class="fw-bold fs-6 text_darkgreen"
                        href="./products.html">Échanges</a></li>
                <li class="d-inline ms-lg-5 ms-md-2 ms-3"><a class="fw-bold fs-6 text_darkgreen"
                        href="./aboutus.html">À
                        propos</a></li>
                <li class="d-inline ms-lg-5 ms-md-2 ms-3"><a class="fw-bold fs-6 text_darkgreen"
                        href="./questions.html">FAQ</a>
                </li>
                <li class="d-inline ms-lg-5 ms-md-2 ms-3"><a class="fw-bold fs-6 text_darkgreen"
                        href="./user_personal_profil.html">Profil</a>
                </li>
            </ul>
            <div class="w-50 mx-auto">
                <input class="input-group rounded" type="search">
                <i class="fa-solid position-absolute fa-magnifying-glass"></i>
            </div>
        </div>
    </nav>

    </header>

    <div class="container calendar-top">
        <div class="row">
            <div class="col-12">
                <h1 class="text_titlegreen calendar-top"><strong>Évènements Greeny</strong></h1>
                    <!------------------------- FORMULAIRE MOIS/ANNEE ---------------->
                
                    <form action="#" method="get" class="mx-auto my-5 text_titlegreen  fw-bold">
                        <label for="mois"></label>
                        <select name="mois" id="mois" class=" text_titlegreen ">
                            <option value="1" <?php if ($month == 1) echo 'selected'; ?>>Janvier</option>
                            <option value="2" <?php if ($month == 2) echo 'selected'; ?>>Février</option>
                            <option value="3" <?php if ($month == 3) echo 'selected'; ?>>Mars</option>
                            <option value="4" <?php if ($month == 4) echo 'selected'; ?>>Avril</option>
                            <option value="5" <?php if ($month == 5) echo 'selected'; ?>>Mai</option>
                            <option value="6" <?php if ($month == 6) echo 'selected'; ?>>Juin</option>
                            <option value="7" <?php if ($month == 7) echo 'selected'; ?>>Juillet</option>
                            <option value="8" <?php if ($month == 8) echo 'selected'; ?>>Août</option>
                            <option value="9" <?php if ($month == 9) echo 'selected'; ?>>Septembre</option>
                            <option value="10" <?php if ($month == 10) echo 'selected'; ?>>Octobre</option>
                            <option value="11" <?php if ($month == 11) echo 'selected'; ?>>Novembre</option>
                            <option value="12" <?php if ($month == 12) echo 'selected'; ?>>Décembre</option>
                        </select>
                        <label for="annee"></label>
                        <select name="annee" id="annee" class=" text_titlegreen ">
                
                            <?php
                            $currentYear = date("Y");
                            for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++) {
                                if ($i == $currentYear) {
                                    echo "<option selected>$i</option>";
                                } else {
                                    echo "<option>$i</option>";
                                }
                            }
                            ?>
                        </select>
                        <button type="submit" class="bg_lightgreen text-light border-0 shadow">Chercher</button>
                    </form>
            </div>
        </div>
    </div>

    <main>
        <!---------------------------------- CALENDRIER ----------------->
        <!----------------------- Affichage de la date avant le calendrier ------------>
        <?php
        if (isset($_GET['mois']) && isset($_GET['annee'])) {
            $mois = $_GET['mois'];
            $annee = $_GET['annee'];
    
            echo "<h3 class='fw-semibold text_darkgreen text-center'>$userDateFr</h3>";
        } else {
            echo "<h3 class='fw-semibold text_darkgreen text-center'>$currentDateFr</h3>";;
        }
        ?>
    
    
        <div class="calender-container">
            <div class="calender">
    
                <div class="day-header fw-bold">Lundi</div>
                <div class="day-header fw-bold">Mardi</div>
                <div class="day-header fw-bold">Mercredi</div>
                <div class="day-header fw-bold">Jeudi</div>
                <div class="day-header fw-bold">Vendredi</div>
                <div class="day-header fw-bold">Samedi</div>
                <div class="day-header fw-bold">Dimanche</div>
    
                <?php
                for ($i = 1; $i < $firstDayInMonth; $i++) {
                    echo "<div class='dayNumber fw-bold'>-</div>";
                }
    
                for ($i = 1; $i <= $nbDaysInMonth; $i++) {
                    $class = ($i == $currentDay && $month == $currentMonth && $year == $currentYear) ? 'current-day' : '';
                    echo "<div class='dayNumber fw-bold $class'>$i</div>";
                }
    
                ?>
            </div>
        </div>
    
        <div class="d-flex justify-content-around my-3">
            <button id="prevButton" class="button-contact bg_lightgreen border-0 shadow">Précédent</button>
            <button id="nextButton" class="button-contact bg_lightgreen border-0 shadow">Suivant</button>
        </div>
    </main>

    <footer>
        <div class="container-fluid bg_orange mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <p class="text-light mt-3 mb-0 text-center text-lg-start">LaManuEcology</p>
                        <p class="text-light mb-0 text-center text-lg-start">238 Earls Ct Rd, Londres SW5 9AA</p>
                        <p class="text-light mb-0 text-center text-lg-start">+44 20 7123 4567</p>
                        <p class="text-light text-center text-lg-start">contact@lamanuecology.com</p>
                    </div>
                    <div class="col-lg-4 d-flex justify-content-center align-items-center">
                        <a href=""><img src="./public/assets/img/questions-page/icon_ig.png" height="30" class="m-2"
                                alt="Logo Instagram"></a>
                        <a href=""><img src="./public/assets/img/questions-page/icon_twitter.png" height="30"
                                class="m-2" alt="Logo Twitter / X"></a>
                        <a href=""><img src="./public/assets/img/questions-page/icon_fb.png" height="30" class="m-2"
                                alt="Logo Facebook"></a>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <p class="mt-3 mb-0 text-center text-lg-end"><a class="text-decoration-none
                            text-light" href="./aboutus.html">À propos</a></p>
                        <p class="mb-0 text-center text-lg-end"> <a class="text-decoration-none
                            text-light" href="./questions.html">F.A.Q & Contact</a></p>
                        <p class="mb-0 text-center text-lg-end"><a class="text-decoration-none
                            text-light" href="">Mentions Légales</a></p>
                        <p class="mb-0 text-center text-lg-end"><a class="text-decoration-none
                            text-light" href="">CGU</a></p>
                    </div>
                </div>
                <div class="row">
                    <p class="col-12 text-center text-light">Copyright Greeny 2024</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        let year = <?php echo $year; ?>;
        let month = <?php echo $month; ?>;
    </script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/afc6a54030.js" crossorigin="anonymous"></script>
    <script src="public/assets/js/index.js"></script>
</body>

</html>
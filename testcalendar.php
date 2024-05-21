<?php
// VARIABLE ANNEE
if (isset($_GET['Years']))
    $year = $_GET['Years'];
else {
    $year = date('Y');
}
// VARIABLE MOIS
if (isset($_GET['Month']))
    $month = $_GET['Month'];
else {
    $month = date('n');
}
// ou avec une ternaire : 
// $month = isset($_GET['mois']) ? $_GET['mois'] : date('n');

$months = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'];
$daysInWeek = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];


// Number of day in the months
$nbDayInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);


// First day in month
$firstDayInMonth = date('N', strtotime("$year-$month-01"));


// Display the first day in the month, from Monday to Sunday (1 to 7)
$firstDayWeek = date('N', strtotime($firstDayInMonth));

$currentDate = new DateTime();
$currentDate2 = new DateTime();

// For the header-Calendar
$formatterFr = new IntlDateFormatter('fr');
$formatterFr->setPattern('LLLL');

// For the Calendar
$formatterFr2 = new IntlDateFormatter('fr');
$formatterFr2->setPattern('MMMM Y');

$currentDate2 = $formatterFr2->format($currentDate2);

$currentDate = $formatterFr->format($currentDate);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <title>Greeny - Calendrier</title>
</head>

<body>

    <div class="container calendar-top">
        <div class="row">
            <div class="col-12">
                <h1 class="text_titlegreen"><strong>Évènement Greeny</strong></h1>
            </div>
            <form action="" method="GET">
                <select name="months" id="months">
                    <!-- <option value="1">Janvier</option>
                    <option value="2">Fevrier</option>
                    <option value="3">Mars</option>
                    <option value="4">Avril</option>
                    <option value="5" selected>Mai</option>
                    <option value="6">Juin</option>
                    <option value="7">Juillet</option>
                    <option value="8">Août</option>
                    <option value="9">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">Décembre</option> -->
                    <?php
                    foreach ($months as $monthNumber => $monthName) {
                        if ($monthNumber == $month) {
                            echo "<option value='$monthNumber' selected>$monthName</option>";
                        } else {
                            echo "<option value='$monthNumber'>$monthName</option>";
                        }
                    }
                    ?>
                </select>
                <select name="Years" id="years">
                    <!-- <option>2019</option>
                    <option>2020</option>
                    <option>2021</option>
                    <option>2022</option>
                    <option>2023</option>
                    <option selected>2024</option>
                    <option>2025</option>
                    <option>2026</option>
                    <option>2027</option>
                    <option>2028</option>
                    <option>2029</option> -->
                    <?php
                    $year = date("Y");
                    for ($i = $year - 5; $i <= $year + 5; $i++) {
                        if ($i == $year) {
                            echo "<option selected>$i</option>";
                        } else {
                            echo "<option>$i</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="button-contact">Chercher</button>
            </form>
        </div>
    </div>

    <!-- -------------------Display the date selected by user------------------- -->

    <div class="container calendar-top text-center mt-5">
        <?php
        // Check if GET value are defined
        if (isset($_GET['months']) && isset($_GET['Years'])) {
            $mois = $_GET['months'];
            $annee = $_GET['Years'];
            // Date in French
            $date = new DateTime("$annee-$mois-01");
            $dateFr = new IntlDateFormatter(('fr'));
            $dateFr->setPattern('MMMM Y');
            $userDateFr = $dateFr->format($date);

            echo "<h3 class='fw-semibold text_darkgreen'>$userDateFr</h3>";
        } else {
            echo "<h3 class='fw-semibold text_darkgreen'>$currentDate2</h3>";;
        }
        ?>
    </div>

<!-- ---------------------------- Calendrier ---------------------------- -->

<div class="calender-container">
        <div class="calender">

            <div class="day-header">Lundi</div>
            <div class="day-header">Mardi</div>
            <div class="day-header">Mercredi</div>
            <div class="day-header">Jeudi</div>
            <div class="day-header">Vendredi</div>
            <div class="day-header">Samedi</div>
            <div class="day-header">Dimanche</div>

            <?php
            for ($i = 1; $i < $firstDayInMonth; $i++) {
                echo "<div>-</div>";
            }

            for ($i = 1; $i <= $nbDayInMonth; $i++) {
                echo "<div>$i</div>";
            }


            ?>


        </div>
    </div>

    <div class="container days my-4">
        <div class="row">
            <?php
            foreach ($daysInWeek as $day) {
                echo "<div class='col p-0 m-0'>
                        <p class='text-center fw-bold'>$day</p>
                      </div>";
            }
            ?>
            <p></p>

            <!-- <div class="box"></div>
            <div class="box"></div> -->
            <?php
            for ($i = 1; $i < $firstDayWeek; $i++) {
                echo "<div class='box'></div>";
            }

            for ($jour = 1; $jour <= $nbDayInMonth; $jour++) {
                    echo "<p class='box'>$jour</p>";
            }

            ?>
            <!-- <div class="col p-0 m-0">
                <p class="text-center fw-bold">Lundi</p>
                <p class="box">-</p>
                <p class="box">06</p>
                <p class="box">13</p>
                <p class="box">20</p>
                <p class="box">27</p>
            </div>
            <div class="col p-0 m-0">
                <p class="text-center fw-bold">Mardi</p>
                <p class="box">-</p>
                <p class="box">07</p>
                <p class="box">14</p>
                <p class="box">21</p>
                <p class="box">28</p>
            </div>
            <div class="col p-0 m-0">
                <p class="text-center fw-bold">Mercredi</p>
                <p class="box">01</p>
                <p class="box">08</p>
                <p class="box">15</p>
                <p class="box">22</p>
                <p class="box">29</p>
            </div>
            <div class="col p-0 m-0">
                <p class="text-center fw-bold">Jeudi</p>
                <p class="box">02</p>
                <p class="box">09</p>
                <p class="box">16</p>
                <p class="box">23</p>
                <p class="box">30</p>
            </div>
            <div class="col p-0 m-0">
                <p class="text-center fw-bold">Vendredi</p>
                <p class="box">03</p>
                <p class="box">10</p>
                <p class="box">17</p>
                <p class="box">24</p>
                <p class="box">31</p>
            </div>
            <div class="col p-0 m-0">
                <p class="text-center fw-bold">Samedi</p>
                <p class="box week-end">04</p>
                <p class="box week-end">11</p>
                <p class="box week-end">18</p>
                <p class="box week-end">25</p>
                <p class="box week-end">-</p>
            </div>
            <div class="col p-0 m-0">
                <p class="text-center fw-bold">Dimanche</p>
                <p class="box week-end">05</p>
                <p class="box week-end">12</p>
                <p class="box week-end">19</p>
                <p class="box week-end">26</p>
                <p class="box week-end">-</p>
            </div> -->
        </div>
    </div>

    <div class="d-flex justify-content-around my-3">
        <button class="button-contact">Précédent</button>
        <button class="button-contact">Suivant</button>
    </div>



    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/afc6a54030.js" crossorigin="anonymous"></script>
    <script src="./public/assets/js/index.js"></script>
</body>

</html>
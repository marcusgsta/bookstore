<div class="container">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>

<?php

$month = isset($_GET['month']) ? $_GET['month'] : date('n');


$title = $app->calendar->title;
echo "<h1>$title</h1>";
$nextMonth = $app->calendar->getNextMonth();
$prevMonth = $app->calendar->getPreviousMonth();
echo $prevMonth;
echo $nextMonth;
echo $app->calendar->getImage($month-1);

echo $app->calendar->getWeek();
// echo $app->calendar->getMonth();

// $today = date('j');

echo "<div class='month'>";

$app->calendar->setWeekDay($month);
$weekDay = $app->calendar->weekDay;

$prevMonthNum = $app->calendar->getPreviousMonthNum();

echo $app->calendar->fixStrayDays($weekDay, $prevMonthNum);

foreach ($app->calendar->month as $key => $value) {
    if ($value == date('j') && $month == date('n')) {
        echo "<div class='day today'>$value</div>";
    } else {
        echo "<div class='day'>$value</div>";
    }
};
echo "</div>";

?>

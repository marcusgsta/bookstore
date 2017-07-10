<?php
$app->router->add(
    "calendar",
    function () use ($app) {

        $app->calendar->getMonth();

        if (isset($_GET['month'])) {
            $currentMonth = $_GET['month'];
            $title = $app->calendar->setTitle($currentMonth);
        } else {
            $currentMonth = $app->calendar->setCurrentMonth();
            $title = $app->calendar->getTitle();
        }

        $currentMonth = $currentMonth - 1;
        $app->calendar->month = $app->calendar->nrOfDays[$currentMonth];

        $app->renderPage("Calendar 2017", "calendar/calendar");
    }
);

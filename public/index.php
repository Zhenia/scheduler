<?php
namespace App;

use App\Scheduler as Scheduler;
use App\Application as Application;
use App\SourceManager as SourceManager;

require './Application.php';
require './SourceManager.php';
require './Scheduler.php';

date_default_timezone_set('UTC');

$url = 'http://internal-interviews.ascendify.works/getRunTimes/';

/** @var  SourceManager $sourceManager */
$sourceManager = new SourceManager($url);

/** @var  $scheduler Scheduler */
$scheduler = new Scheduler($sourceManager);
$scheduler->load(200);

$time = "15:30";
$timeUTC = parseTime($time);

$applications = $scheduler->getApplicationsByCheckTime($timeUTC);//парсер
echo 'check time: ' . implode(',', $applications) . " /n<br/>";

$scheduler->load(100);

$applications = $scheduler->getApplicationsByCheckTime($timeUTC);
echo 'check time: ' . implode(',', $applications) . " /n<br/>";

$removeApplication = $scheduler->getApplicationById(191);
$scheduler->removeById(191);

$timeUTC = parseTime("05:07");
$applications = $scheduler->getApplicationsByCheckTime($timeUTC);
echo 'check time: ' . implode(',', $applications) . " /n<br/>";


$time = "05:07";
$timeUTC = parseTime($time);

/** @var  $application Application */
$application = $scheduler->getApplicationById(180);
if ($application) {
    $checks = $application->getNextChecks(5, $timeUTC);
    echo '5 checks time after now for app 180: ' . implode(',', $checks) . " /n<br/>";
}

if ($removeApplication) {
    $checks = $removeApplication->getNextChecks(5, $timeUTC);
    echo '5 checks time after now for app 191: ' . implode(',', $checks) . " /n<br/>";
}

/**
 * Parse string to date UTC
 * @param string $time
 * @return integer
 */
function parseTime($time)
{
    $time = new \DateTime($time);
    $timeUTC = $time->format("G") * 60 + $time->format("i") / 10 * 10;
    return $timeUTC;


}





<?php
namespace App;
use App\Scheduler as Scheduler;
use App\Application as Application;

require './Application.php';
require './SourceManager.php';
require './Scheduler.php';

date_default_timezone_set('UTC');

/** @var  $scheduler Scheduler*/
$scheduler = new Scheduler();
$scheduler->load(200);

$time = "15:30";
$timeUTC = parseTime($time);
$apps = $scheduler->getApplicationsByCheckTime($timeUTC);//парсер
print_r('check time: '.implode(',',$apps));

$scheduler->load(100);

$apps = $scheduler->getApplicationsByCheckTime($timeUTC);
print_r('<br/> check time: '.implode(',',$apps));

$scheduler->removeById(191);

$timeUTC = parseTime("05:07");
$apps = $scheduler->getApplicationsByCheckTime($timeUTC);
print_r('<br/> check time: '.implode(',',$apps));

/** @var  $application Application*/
$application = $scheduler->getApplicationById(180);
if ($application){
    $checks = $application->getNextChecks(5);
    print_r('<br/> 5 checks time afrer now for app 180: '.implode(',',$checks));
}

$application = $scheduler->getApplicationById(191);
if ($application){
    $checks = $application->getNextChecks(5);
    print_r('<br/> 5 checks time afrer now for app 180: '.implode(',',$checks));
}

/**
 * Parse string to date UTC
 * @param string $time
 * @return integer
 */
function parseTime($time){
    $arrTime = explode(":",$time);
    if(count($arrTime) != 2){
        echo 'Exception: wrong time format';
    }
    $timeUtc = $arrTime[0]*60 + $arrTime[0];
    return $timeUtc;
}





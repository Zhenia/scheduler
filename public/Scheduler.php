<?php

namespace App;

use App\Application as Application;
use App\SourceManager as SourceManager;

class Scheduler
{
    private $applications = [];
    private $sourceManager;


    /**
     * @param SourceManager $sm
     */
    public function __construct($sm)
    {
        $this->sourceManager = $sm;
    }

    /**
     * Add application to private property
     * @param Application $application
     * @return $this
     */
    public function addApplication(Application $application)
    {
        $this->applications[$application->getId()] = $application;
        return $this;
    }


    /**
     * load $count applications started with $start
     * @param integer $count
     * @param integer $start
     * @return Application[]
     */
    public function load($count, $start = 1)
    {
        for ($i = $start; $i < $count; $i++) {
            $application = $this->loadApplicationById($i);
            $this->applications[$i] = $application;
        }
        return $this->applications;
    }


    public function save()
    {

    }

    /**
     * load application by $id
     * @param integer $id
     * @return Application
     */
    public function loadApplicationById($id)
    {

        $allChecks = $this->sourceManager->loadApplicationById($id);
        $checks = ($allChecks) ? explode(',', $allChecks) : [];
        $app = new Application();
        $app->setId($id);
        $app->setChecks($checks);
        return $app;
    }

    /**
     * get applications with $check = $time
     * @param integer $time
     * @return integer[]
     */
    public function getApplicationsByCheckTime($time)
    {
        $result = [];
        foreach ($this->applications as $app) {
            if (in_array($time, $app->getChecks())) {
                $result[] = $app->getId();
            }
        }
        return $result;
    }


    /**
     * get application with $id
     * @param integer $id
     * @return Application
     */
    public function getApplicationById($id)
    {
        return (array_key_exists($id, $this->applications)) ? $this->applications[$id] : false;

    }

    /**
     * remove application with $id
     * @param integer $id
     * @return $this
     */
    public function removeById($id)
    {
        unset($this->applications[$id]);
        $this->save();
        return $this;
    }

}
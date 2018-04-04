<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 4/2/18
 * Time: 11:41 AM
 */

namespace AppBundle\Event;

use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\Transition;

class CustomEvent extends Event
{
    const EVENT_NAME = "custom.fired";
    protected $var;

    public function __construct($test)
    {
        $this->var = $test;
    }

    public function fired()
    {
        print_r($this->var);
        die('<br/>var type is - ' . gettype($this->var));
    }
}
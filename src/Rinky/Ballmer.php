<?php
namespace Rinky;

use Symfony\Component\HttpFoundation\Session\Session;
use Rinky\Entity\Drink;

class Ballmer {

    const BELOW = 'BELOW';

    const PERFECT = 'PERFECT';

    const OVER = 'OVER';

    const DANGER = 'DANGER';

    const BALLMER_LOWER = 0.129;

    const BALLMER_UPPER = 0.138;

    const DANGER_LOWER = 0.25;

    protected $session;

    protected $drinks;

    protected $bac;

    public function __construct(Session $session)
    {
        $this->session = $session;

        $this->drinks = array();

        $this->bac = 0;
    }

    protected function updateSession()
    {
        $this->session->set('ballmer', $this);
    }

    protected function getBacForDrink(Drink $drink)
    {

        $weight = ($drink->getAbv() * 0.8);

        $perMille = $weight / (83.6 * 0.7);

        $bac = $perMille * 0.2;

        if($bac < 0) {
            return 0;
        }

        return round($bac / 5, 3) * 5;
    }

    public function consume(Drink $drink)
    {
        $this->drinks[] = $drink;

        $this->bac += $this->getBacForDrink($drink);
        $this->updateSession();
    }

    public function clearDrinks()
    {
        $this->drinks = array();

        $this->bac = 0;

        $this->updateSession();
    }

    public function getBac()
    {
        return $this->bac;
    }

    public function getState()
    {
        if($this->getLevel() == self::BELOW) {
            return 'warning';
        }

        if($this->getLevel() == self::PERFECT) {
            return 'success';
        }

        if($this->getLevel() == self::OVER) {
            return 'important';
        }

        if($this->getLevel() == self::DANGER) {
            return 'inverse';
        }
    }

    public function getLevel()
    {
        if($this->getBac() < self::BALLMER_LOWER) {
            return self::BELOW;
        }

        if($this->getBac() >= self::BALLMER_LOWER && $this->getBac() <= self::BALLMER_UPPER) {
            return self::PERFECT;
        }

        if($this->getBac() > self::BALLMER_UPPER && $this->getBac() <= self::DANGER_LOWER) {
            return self::OVER;
        }

        if($this->getBac() > self::DANGER_LOWER) {
            return self::DANGER;
        }
    }

    public function getDrinks()
    {
        return $this->drinks;
    }

    public function getChartData()
    {
        $data = array(
            array("BAC", "Programming Performance", "Your Position"),
                array(0, 5, 0),
                array(0.005, 4.95, 0),
                array(0.01, 4.9, 0),
                array(0.015, 4.85, 0),
                array(0.02, 4.8, 0),
                array(0.025, 4.75, 0),
                array(0.03, 4.7, 0),
                array(0.035, 4.65, 0),
                array(0.04, 4.6, 0),
                array(0.045, 4.55, 0),
                array(0.05, 4.5, 0),
                array(0.055, 4.4, 0),
                array(0.06, 4.3, 0),
                array(0.065, 4.2, 0),
                array(0.07, 4.1, 0),
                array(0.075, 4, 0),
                array(0.08, 3.8, 0),
                array(0.085, 3.5, 0),
                array(0.09, 3, 0),
                array(0.095, 2.5, 0),
                array(0.10, 2, 0),
                array(0.105, 1.5, 0),
                array(0.11, 1, 0),
                array(0.115, 0.5, 0),
                array(0.12, 0.3, 0),
                array(0.125, 0.2, 0),
                array(0.13, 10, 0),
                array(0.135, 10, 0),
                array(0.14, 0.2, 0),
                array(0.145, 0.19, 0),
                array(0.15, 0.18, 0),
                array(0.155, 0.17, 0),
                array(0.16, 0.16, 0),
                array(0.165, 0.15, 0),
                array(0.17, 0.14, 0),
                array(0.175, 0.13, 0),
                array(0.18, 0.12, 0),
                array(0.185, 0.11, 0),
                array(0.19, 0.10, 0),
                array(0.195, 0.09, 0),
                array(0.20, 0.08, 0),
                array(0.205, 0.07, 0),
                array(0.21, 0.06, 0),
                array(0.215, 0.05, 0),
                array(0.22, 0.04, 0),
                array(0.225, 0.03, 0),
                array(0.23, 0.02, 0),
                array(0.235, 0.01, 0),
                array(0.24, 0, 0),
                array(0.245, 0, 0),
                array(0.25, 0, 0),
                array(0.245, 0, 0),
                array(0.26, 0, 0)
            );

        $dataArrayKey = ($this->getBac() / 0.005) + 1;

        if($dataArrayKey > count($data)-1) {
            $dataArrayKey = count($data)-1;
        }

        $data[$dataArrayKey][2] = 10;

        return json_encode($data);

    }

}

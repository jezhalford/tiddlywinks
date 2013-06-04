<?php
namespace Rinky;

use Symfony\Component\HttpFoundation\Session\Session;

class Ballmer {

    const BELOW = 'BELOW';

    const PERFECT = 'PERFECT';

    const OVER = 'OVER';

    const DANGER = 'DANGER';

    const BALLMER_LOWER = 0.129;

    const BALLMER_UPPER = 0.138;

    const DANGER_LOWER = 0.25;

    protected $session;

    protected $bac;

    protected $drinks;

    public function __construct(Session $session)
    {
        $this->session = $session;

        $this->bac = 0;

        $this->drinks = array();
    }

    public function consume($volume, $abv)
    {

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
        if($this->bac < self::BALLMER_LOWER) {
            return self::BELOW;
        }

        if($this->bac > self::BALLMER_LOWER && $this->bac< self::BALLMER_UPPER) {
            return self::PERFECT;
        }

        if($this->bac > self::BALLMER_UPPER && $this->bac < self::DANGER_LOWER) {
            return self::OVER;
        }

        if($this->bac > self::DANGER_LOWER) {
            return self::DANGER;
        }
    }

    public function getDrinks()
    {
        return $this->drinks;
    }

}

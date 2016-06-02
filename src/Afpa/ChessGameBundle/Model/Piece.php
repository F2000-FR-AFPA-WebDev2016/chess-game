<?php

namespace Afpa\ChessGameBundle\Model;

abstract class Piece {

    const BLACK = 'black';
    const WHITE = 'white';

    private $x;
    private $y;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var array
     */
    protected $position;

    abstract public function getMovePossibilities($xInit, $yInit);

    public function getEatPossibilities($xInit1, $yInit1) {
        return $this->getMovePossibilities($xInit1, $yInit1);
    }

    public function __construct($color) {
        $this->color = $color;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function getColor() {
        return $this->color;
    }

    public function __toString() {
        $path = explode('\\', get_class($this));
        return strtolower(array_pop($path)) . '_' . $this->color . '.png';
    }

}

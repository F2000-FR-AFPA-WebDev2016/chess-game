<?php

namespace Afpa\ChessGameBundle\Model;

abstract class Piece {

    const BLACK = 'black';
    const WHITE = 'white';

    /**
     * @var string
     */
    protected $color;

    /**
     * @var array
     */
    protected $position;

    abstract public function move();

    public function __construct($color) {
        $this->color = $color;
    }

    public function getColor() {
        return $this->color;
    }

    public function __toString() {
        $path = explode('\\', get_class($this));
        return strtolower(array_pop($path)) . '_' . $this->color . '.png';
    }

}

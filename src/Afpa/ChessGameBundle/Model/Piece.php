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

    public function __toString() {
        return strtolower(get_class($this)) . '_' . $this->color . '.png';
    }

}

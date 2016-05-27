<?php

namespace Afpa\ChessGameBundle\Model;

abstract class Piece {

    const TYPE = 'default';
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
        return self::TYPE . '_' . $this->color . '.png';
    }

}

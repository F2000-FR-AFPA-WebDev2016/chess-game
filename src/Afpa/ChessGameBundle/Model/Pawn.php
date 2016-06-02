<?php

namespace Afpa\ChessGameBundle\Model;

class Pawn extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();

        if ($this->getColor() == Piece::BLACK) {
            $sign = '1';
        } else {
            $sign = '-1';
        }

        $bFirstMove = ($xInit == '1' && $this->getColor() == Piece::BLACK) ||
                ($xInit == '6' && $this->getColor() == Piece::WHITE);
        if ($bFirstMove) {
            $x = $xInit + (2 * $sign);
            $aTab[] = array($x, $yInit);
        }
        $x = $xInit + (1 * $sign);
        $aTab[] = array($x, $yInit);
        return $aTab;
    }

    public function getEatPossibilities($xInit, $yInit) {
        $aTab = array();
        return $aTab;
    }

}

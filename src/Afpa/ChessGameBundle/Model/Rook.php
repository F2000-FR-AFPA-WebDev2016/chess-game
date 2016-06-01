<?php

namespace Afpa\ChessGameBundle\Model;

class Rook extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();
        for ($i = 0; $i < 8; $i++) {
            $aTab[] = array($xInit + $i, $yInit);
            $aTab[] = array($xInit - $i, $yInit);
            $aTab[] = array($xInit, $yInit + $i);
            $aTab[] = array($xInit, $yInit - $i);
        }
        return $aTab;
    }

}

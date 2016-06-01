<?php

namespace Afpa\ChessGameBundle\Model;

class Bishop extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();
        for ($i = 0; $i < 8; $i++) {
            $aTab[] = array($xInit + $i, $yInit + $i);
            $aTab[] = array($xInit - $i, $yInit + $i);
            $aTab[] = array($xInit - $i, $yInit - $i);
            $aTab[] = array($xInit + $i, $yInit - $i);
        }
        return $aTab;
    }

}

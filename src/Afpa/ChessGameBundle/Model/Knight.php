<?php

namespace Afpa\ChessGameBundle\Model;

class Knight extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();
        $aTab[] = array($xInit + 1, $yInit + 2);
        $aTab[] = array($xInit + 1, $yInit - 2);
        $aTab[] = array($xInit + 2, $yInit + 1);
        $aTab[] = array($xInit + 2, $yInit - 1);
        $aTab[] = array($xInit - 1, $yInit + 2);
        $aTab[] = array($xInit - 1, $yInit - 2);
        $aTab[] = array($xInit - 2, $yInit + 1);
        $aTab[] = array($xInit - 2, $yInit - 1);
        return $aTab;
    }

}

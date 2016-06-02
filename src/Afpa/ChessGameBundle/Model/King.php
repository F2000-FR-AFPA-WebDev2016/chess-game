<?php

namespace Afpa\ChessGameBundle\Model;

class King extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();
        $aTab[] = array($xInit + 1, $yInit);
        $aTab[] = array($xInit, $yInit + 1);
        $aTab[] = array($xInit - 1, $yInit);
        $aTab[] = array($xInit, $yInit - 1);

        $aTab[] = array($xInit - 1, $yInit - 1);
        $aTab[] = array($xInit - 1, $yInit + 1);
        $aTab[] = array($xInit + 1, $yInit - 1);
        $aTab[] = array($xInit + 1, $yInit + 1);
        return $aTab;
    }

}

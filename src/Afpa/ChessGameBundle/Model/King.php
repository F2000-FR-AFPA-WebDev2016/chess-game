<?php

namespace Afpa\ChessGameBundle\Model;

class King extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();

        $x = $xInit + 1;
        $y = $yInit;
        $aTab[] = array($x, $y);

        $x = $xInit;
        $y = $yInit + 1;
        $aTab[] = array($x, $y);

        $x = $xInit - 1;
        $y = $yInit;
        $aTab[] = array($x, $y);

        $x = $xInit;
        $y = $yInit - 1;
        $aTab[] = array($x, $y);

        return $aTab;
    }

}

<?php

namespace Afpa\ChessGameBundle\Model;

class Bishop extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aTab = array();

        for ($i = 0; $i < 8; $i++) {
            $x = $xInit + $i;
            $y = $yInit + $i;
            $aTab[] = array($x, $y);
        }
        for ($i = 0; $i < 8; $i++) {
            $x = $xInit - $i;
            $y = $yInit + $i;
            $aTab[] = array($x, $y);
        }
        for ($i = 0; $i < 8; $i++) {
            $x = $xInit - $i;
            $y = $yInit - $i;
            $aTab[] = array($x, $y);
        }
        for ($i = 0; $i < 8; $i++) {
            $x = $xInit + $i;
            $y = $yInit - $i;
            $aTab[] = array($x, $y);
        }

        return $aTab;
    }

}

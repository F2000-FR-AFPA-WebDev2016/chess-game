<?php

namespace Afpa\ChessGameBundle\Model;

class King extends Piece {

    public function getMovePossibilities($xInit, $yInit) {
        $aMoves = array();

        $aDir = array(array(1, 0), array(0, 1), array(-1, 0), array(0, -1), array(-1, -1), array(-1, 1), array(1, 1), array(1, -1));
        $i = 0;
        foreach ($aDir as $aAxe) {
            $x = $xInit;
            $y = $yInit;

            do {
                $x += $aAxe[0];
                $y += $aAxe[1];

                $bOk = Chessboard::isCoordsValid($x, $y);
                if ($bOk) {
                    if (!isset($aMoves[$i])) {
                        $aMoves[$i] = array();
                    }
                    $aMoves[$i][] = array($x, $y);
                }
            } while ($bOk);

            $i++;
        }

        return $aMoves;
    }

}

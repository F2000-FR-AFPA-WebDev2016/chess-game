<?php

namespace Afpa\ChessGameBundle\Model;

/**
 * Chessboard
 *
 */
class Chessboard {

    const MAX_SIZE = 7;
    const STATUS_OK = 0;
    const STATUS_ERR = 1;
    const STATUS_ERR_CHESS = 2;
    const STATUS_ERR_CHESSMAT = 3;
    const DIFFICULTY_EASY = 0;
    const DIFFICULTY_MEDIUM = 1;
    const DIFFICULTY_HARD = 2;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $cases;

    /**
     * @var array
     */
    private $board;

    /**
     * @var array
     */
    private $whitePieces;

    /**
     * @var array
     */
    private $blackPieces;

    /**
     * @var boolean
     */
    private $isInCheck;

    /**
     * @var boolean
     */
    private $isCheckmate;

    /**
     * @var boolean
     */
    private $playerTurn;

    /**
     * @var integer
     */
    protected $difficulty;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set cases
     *
     * @param array $cases
     * @return Chessboard
     */
    public function setCases($cases) {
        $this->cases = $cases;
        return $this;
    }

    /**
     * Get cases
     *
     * @return array
     */
    public function getCases() {
        return $this->cases;
    }

    /**
     * Set board
     *
     * @param array $board
     * @return Chessboard
     */
    public function setBoard($board) {
        $this->board = $board;
        return $this;
    }

    /**
     * Get board
     *
     * @return array
     */
    public function getBoard() {
        return $this->board;
    }

    /**
     * Set whitePieces
     *
     * @param array $whitePieces
     * @return Chessboard
     */
    public function setWhitePieces($whitePieces) {
        $this->whitePieces = $whitePieces;
        return $this;
    }

    /**
     * Get whitePieces
     *
     * @return array
     */
    public function getWhitePieces() {
        return $this->whitePieces;
    }

    /**
     * Set blackPieces
     *
     * @param array $blackPieces
     * @return Chessboard
     */
    public function setBlackPieces($blackPieces) {
        $this->blackPieces = $blackPieces;
        return $this;
    }

    /**
     * Get blackPieces
     *
     * @return array
     */
    public function getBlackPieces() {
        return $this->blackPieces;
    }

    /**
     * Set isInCheck
     *
     * @param boolean $isInCheck
     * @return Chessboard
     */
    public function setIsInCheck($isInCheck) {
        $this->isInCheck = $isInCheck;
        return $this;
    }

    /**
     * Get isInCheck
     *
     * @return boolean
     */
    public function getIsInCheck() {
        return $this->isInCheck;
    }

    /**
     * Set isCheckmate
     *
     * @param boolean $isCheckmate
     * @return Chessboard
     */
    public function setIsCheckmate($isCheckmate) {
        $this->isCheckmate = $isCheckmate;
        return $this;
    }

    /**
     * Get isCheckmate
     *
     * @return boolean
     */
    public function getIsCheckmate() {
        return $this->isCheckmate;
    }

//initialisation d'un board de 64 cases (8x8)
    public function __construct() {
        $this->board = array();
        for ($i = 0; $i <= self::MAX_SIZE; $i++) {
            $this->board[$i] = array();
            for ($j = 0; $j <= self::MAX_SIZE; $j++) {
                $this->board[$i][$j] = "";
            }
        }
        $this->board[0][0] = $this->board[0][7] = new Rook(Piece::BLACK);
        $this->board[0][1] = $this->board[0][6] = new Knight(Piece::BLACK);
        $this->board[0][2] = $this->board[0][5] = new Bishop(Piece::BLACK);
        $this->board[0][3] = new King(Piece::BLACK);
        $this->board[0][4] = new Queen(Piece::BLACK);
        for ($i = 0; $i <= self::MAX_SIZE; $i++) {
            $this->board[1][$i] = new Pawn(Piece::BLACK);
        }
        $this->board[7][0] = $this->board[7][7] = new Rook(Piece::WHITE);
        $this->board[7][1] = $this->board[7][6] = new Knight(Piece::WHITE);
        $this->board[7][2] = $this->board[7][5] = new Bishop(Piece::WHITE);
        $this->board[7][3] = new King(Piece::WHITE);
        $this->board[7][4] = new Queen(Piece::WHITE);
        for ($i = 0; $i <= self::MAX_SIZE; $i++) {
            $this->board[6][$i] = new Pawn(Piece::WHITE);
        }
        $this->playerTurn = Piece::WHITE;
        $this->difficulty = self::DIFFICULTY_EASY;
    }

    public function getPlayerTurn() {
        if ($this->playerTurn == Piece::WHITE) {
            return 'Joueur Blanc';
        } else {
            return 'Joueur Noir';
        }
    }

    public function getMovePossibilities($oPiece, $x, $y) {
        $aValid = array();
        $aMoves = $oPiece->getMovePossibilities($x, $y);
        foreach ($aMoves as $aPos) {
            if (is_array($aPos[0])) {
                foreach ($aPos as $aSubPos) {
                    if (!$this->board[$aSubPos[0]][$aSubPos[1]] instanceof Piece) {
                        $aValid[] = $aSubPos;
                    } else {
                        //si case invalide arret de l evaluation des autres cas
                        break;
                    }
                }
            } else {
                if (self::isCoordsValid($aPos[0], $aPos[1]) &&
                        !$this->board[$aPos[0]][$aPos[1]] instanceof Piece) {
                    $aValid[] = $aPos;
                }
            }
        }
        return $aValid;
    }

    public static function isCoordsValid($x, $y) {
        if ($x >= 0 && $x <= 7 && $y >= 0 && $y <= 7) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getEatPossibilities($oPiece, $x, $y) {
        $aValid = array();

        $aMoves = $oPiece->getEatPossibilities($x, $y);
        foreach ($aMoves as $aPos) {
            if (is_array($aPos[0])) {
                foreach ($aPos as $aSubPos) {
                    if (self::isCoordsValid($aSubPos[0], $aSubPos[1]) && $this->board[$aSubPos[0]][$aSubPos[1]] instanceof Piece) {
                        if ($oPiece->getColor() != $this->board[$aSubPos[0]][$aSubPos[1]]->getColor()) {
                            $aValid[] = $aSubPos;
                            break;
                        } else {
                            break;
                        }
                    }
                }
            } else {
                if (self::isCoordsValid($aPos[0], $aPos[1]) && $this->board[$aPos[0]][$aPos[1]] instanceof Piece) {
                    if ($oPiece->getColor() != $this->board[$aPos[0]][$aPos[1]]->getColor()) {
                        $aValid[] = $aPos;
                    }
                }
            }
        }

        return $aValid;
    }

    public function doAction($x1, $y1, $x2 = null, $y2 = null) {
        $sStatus = self::STATUS_ERR;
        $bNextPlayer = false;
        $bNewSelection = false;
        $oPiece1 = $this->board[$x1][$y1];
        $aTabPossibilities = $this->getMovePossibilities($oPiece1, $x1, $y1);
        $aTabPossEat = $this->getEatPossibilities($oPiece1, $x1, $y1);

        if ($oPiece1 instanceof Piece &&
                $this->playerTurn == $oPiece1->getColor()) {
            if (!is_null($x2) && !is_null($y2)) {
                $oPiece2 = $this->board[$x2][$y2];

                $aBackupBoard = $this->board;

                // cas 1 : case vide
                if (!$oPiece2 instanceof Piece) {
                    if (in_array(array($x2, $y2), $aTabPossibilities)) {
                        $this->board[$x1][$y1] = '';
                        $this->board[$x2][$y2] = $oPiece1;
                        $x1 = null;
                        $y1 = null;

                        $sStatus = self::STATUS_OK;
                        $bNextPlayer = true;
                    }
                }
                // cas 2 : case ami => nouvelle selection OU rock
                elseif ($this->playerTurn == $oPiece2->getColor()) {
                    if ($this->isRock()) {
                        // TODO
                    } else {
                        $x1 = $x2;
                        $y1 = $y2;
                        // recalcul des possibilités pour la nouvelle sélection
                        $aTabPossibilities = $this->getMovePossibilities($oPiece2, $x2, $y2);
                        $aTabPossEat = $this->getEatPossibilities($oPiece2, $x2, $y2);

                        $sStatus = self::STATUS_OK;
                        $bNewSelection = true;
                    }
                }
                // cas 3 : case ennemie => miam?
                else {
                    if (in_array(array($x2, $y2), $aTabPossEat)) {
                        $this->board[$x1][$y1] = '';
                        $this->board[$x2][$y2] = $oPiece1;
                        $x1 = null;
                        $y1 = null;

                        $sStatus = self::STATUS_OK;
                        $bNextPlayer = true;
                    }
                    // TODO
                }



                if ($this->IsKingCheck() && !$bNewSelection) {
                    // revevnir a letat precedent
                    $sStatus = self::STATUS_ERR_CHESS;
                    $bNextPlayer = FALSE;
                    $this->board = $aBackupBoard;
                }

                if ($bNextPlayer) {
                    $this->nextPlayer();
                }
            } else {
                // cas selection
                $sStatus = self::STATUS_OK;
            }
        }
        return array(
            'status' => $sStatus,
            'x_selected' => $x1,
            'y_selected' => $y1,
            'posKingCheck' => $this->getPosKingCheck(),
            'pos_move' => $aTabPossibilities,
            'pos_eat' => $aTabPossEat,
        );
    }

    private function isRock() {
        // TODO
        return FALSE;
    }

    private function nextPlayer() {
        if ($this->playerTurn == Piece::WHITE) {
            $this->playerTurn = Piece::BLACK;
        } else {
            $this->playerTurn = Piece::WHITE;
        }
    }

    public function getPlayer() {
        if ($this->playerTurn == Piece::WHITE) {
            return 'Joueur: Blanc';
        } else {
            return 'Joueur: Noir';
        }
    }

    public function getPosKingCheck() {
        // parcourir tt le tableau et pour chaque piece adverse memorisé les mouvements
        $aMvtsAdverses = array();
        $aPosKing = array();
        for ($i = 0; $i <= self::MAX_SIZE; $i++) {
            for ($j = 0; $j <= self::MAX_SIZE; $j++) {

                // regarder les pieces noires
                // $aPiecesAdverses[] = ...;
                //  memorisé les mouvements

                if ($this->board[$i][$j] instanceof Piece && $this->playerTurn != $this->board[$i][$j]->getColor()) {
                    $aMvtsAdverses = array_merge($aMvtsAdverses, $this->getEatPossibilities($this->board[$i][$j], $i, $j));
                }
                if ($this->board[$i][$j] instanceof King && $this->playerTurn == $this->board[$i][$j]->getColor()) {
                    $aPosKing = array($i, $j);
                }

                //$this->board[$i][$j] = "";
            }
        }

        array_unique($aMvtsAdverses);

        return (in_array($aPosKing, $aMvtsAdverses) ? $aPosKing : false);
    }

    public function isKingCheck() {
        return ($this->getPosKingCheck() !== false);
    }

    function getDifficulty() {
        return $this->difficulty;
    }

    function setDifficulty($difficulty) {
        $this->difficulty = $difficulty;
    }

}

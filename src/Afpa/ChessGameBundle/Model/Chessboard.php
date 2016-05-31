<?php

namespace Afpa\ChessGameBundle\Model;

/**
 * Chessboard
 *
 */
class Chessboard {

    const MAX_SIZE = 7;

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
    }

    public function getPlayerTurn() {
        if ($this->playerTurn == Piece::WHITE) {
            return 'Joueur Blanc';
        } else {
            return 'Joueur Noir';
        }
    }

    public function doAction($x1, $y1, $x2 = null, $y2 = null) {
        $sStatus = 'error';

        $oPiece1 = $this->board[$x1][$y1];
        if ($oPiece1 instanceof Piece &&
                $this->playerTurn == $oPiece1->getColor()) {

            if (!is_null($x2) && !is_null($y2)) {
                $oPiece2 = $this->board[$x2][$y2];

                // cas 1 : case vide
                if (!$oPiece2 instanceof Piece) {
                    $bIsMovePossible = TRUE;
                    if ($bIsMovePossible) {
                        $this->board[$x1][$y1] = '';
                        $this->board[$x2][$y2] = $oPiece1;
                        $x1 = null;
                        $y1 = null;
                        $sStatus = 'success';

                        $this->nextPlayer();
                    }
                }
                // cas 2 : case ami => nouvelle selection OU rock
                elseif ($this->playerTurn == $oPiece2->getColor()) {
                    if ($this->isRock()) {
                        // TODO
                    } else {
                        $x1 = $x2;
                        $y1 = $y2;
                        $sStatus = 'success';
                    }
                }
                // cas 3 : case ennemie => miam?
                else {
                    // TODO
                }
            } else {
                // cas selection
                $sStatus = 'success';
            }
        }


        return array(
            'status' => $sStatus,
            'x_selected' => $x1,
            'y_selected' => $y1,
            'possibilities' => array(),
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

}

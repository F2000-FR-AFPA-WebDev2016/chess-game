<?php

namespace Afpa\ChessGameBundle\Model;

/**
 * Chessboard
 *
 */
class Chessboard {

    /**
     * @var integer
     *

     */
    private $id;

    /**
     * @var array
     *

     */
    private $cases;

    /**
     * @var array
     *

     */
    private $board;

    /**
     * @var array
     *

     */
    private $whitePieces;

    /**
     * @var array
     *

     */
    private $blackPieces;

    /**
     * @var boolean
     *

     */
    private $isInCheck;

    /**
     * @var boolean
     *

     */
    private $isCheckmate;

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

}

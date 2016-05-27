<?php

namespace Afpa\ChessGameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Afpa\ChessGameBundle\Model\Chessboard;

class GameController extends Controller {

    protected $theme = 'default';

    /**
     * @Route("/")
     * @Template()
     */
    public function homeAction() {
        $oChessboard = new Chessboard();
        return $this->render('AfpaChessGameBundle:Game:home.html.twig', array(
                    'theme' => $this->theme,
                    'board' => $oChessboard->getBoard()
        ));
    }

    /**
     * @Route("/credits")
     * @Template()
     */
    public function creditsAction() {

    }

    /**
     * @Route("/rules")
     * @Template()
     */
    public function rulesAction() {

    }

    /**
     * @Route("/end")
     * @Template()
     */
    public function endAction() {

    }

}

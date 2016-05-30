<?php

namespace Afpa\ChessGameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Afpa\ChessGameBundle\Model\Chessboard;

class GameController extends Controller {

    protected $theme = 'default';

    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function homeAction() {
        $oSession = new Session;
        $oGame = $oSession->get('game');
        if (!$oGame) {
            $oGame = new Chessboard;
            $oSession->set('game', $oGame);
        }

        return $this->render('AfpaChessGameBundle:Game:home.html.twig', array(
                    'theme' => $this->theme,
                    'board' => $oGame->getBoard()
        ));
    }

    /**
     * @Route("/credits", name="credits")
     * @Template()
     */
    public function creditsAction() {
        return $this->render('AfpaChessGameBundle:Game:credits.html.twig');
    }

    /**
     * @Route("/rules",name="rules")
     * @Template()
     */
    public function rulesAction() {
        return $this->render('AfpaChessGameBundle:Game:rules.html.twig');
    }

    /**
     * @Route("/end")
     * @Template()
     */
    public function endAction() {

    }

    /**
     * @Route("/game/action", name="game_action")
     * @Template()
     */
    public function gameAction(Request $request) {
        $x = $request->get('x');
        $y = $request->get('y');

        $oSession = new Session;
        $oGame = $oSession->get('game', NULL);

        if ($oGame) {
            $aData = $oGame->doAction($x, $y);
            return new \Symfony\Component\HttpFoundation\JsonResponse($aData);
        }
    }

}

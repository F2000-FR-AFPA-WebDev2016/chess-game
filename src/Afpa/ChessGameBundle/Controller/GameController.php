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
        $x1 = $request->get('x1');
        $y1 = $request->get('y1');
        $x2 = $request->get('x2', null);
        $y2 = $request->get('y2', null);

        $oSession = new Session;
        $oGame = $oSession->get('game', NULL);

        if ($oGame) {
            $aData = $oGame->doAction($x1, $y1, $x2, $y2);
            return new \Symfony\Component\HttpFoundation\JsonResponse($aData);
        }
    }

}

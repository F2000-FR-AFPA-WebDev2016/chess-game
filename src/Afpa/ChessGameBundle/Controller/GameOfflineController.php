<?php

namespace Afpa\ChessGameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Afpa\ChessGameBundle\Entity\Game;
use Afpa\ChessGameBundle\Model\Chessboard;
use Afpa\ChessGameBundle\Entity\User;

class GameOfflineController extends Controller {

    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function playGameAction(Request $request) {
        $oSession = $request->getSession();
        $oGame = $oSession->get('game');
        if (!$oGame) {
            $oGame = new Chessboard;
            $oSession->set('game', $oGame);
            $oSession->set('theme', 'default');
        }

        return array();
    }

    /**
     * @Route("/credits", name="credits")
     * @Template()
     */
    public function creditsAction() {
        return array();
    }

    /**
     * @Route("/rules",name="rules")
     * @Template()
     */
    public function rulesAction() {
        return array();
    }

    /**
     * @Route("options/theme")
     * @Template()
     */
    public function setThemeAction(Request $request) {
        $theme = $request->get('theme');

        $oSession = $request->getSession();
        $oSession->set('theme', $theme);

        return new \Symfony\Component\HttpFoundation\JsonResponse();
    }

    /**
     * @Route("game/options/difficulty")
     * @Template()
     */
    public function setDifficultyAction(Request $request) {
        $oSession = $request->getSession();
        $oGame = $oSession->get('game');

        $sDifficulty = $request->get('difficulty');
        $oGame->setDifficulty($sDifficulty);

        return new \Symfony\Component\HttpFoundation\JsonResponse();
    }

    /**
     * @Route("/game/end")
     * @Template()
     */
    public function endGameAction() {

    }

    /**
     * @Route("/game/reset")
     * @Template()
     */
    public function resetGameAction(Request $request) {
        $request->getSession()->remove('game');
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/game/refresh")
     * @Template()
     */
    public function refreshGameAction(Request $request) {
        $oSession = $request->getSession();
        $oGame = $oSession->get('game');
        $sTheme = $oSession->get('theme');

        $defaultData = array(
            'theme' => $sTheme,
            'difficulty' => $oGame->getDifficulty()
        );
        $oForm = $this->createFormBuilder($defaultData)
                ->add('theme', 'choice', array(
                    'choices' => array(
                        'default' => 'Default',
                        'sexy' => 'Sexy',
                        'funny' => 'Funny',
                    ),
                    'required' => true,
                ))
                ->add('difficulty', 'choice', array(
                    'choices' => array(
                        Chessboard::DIFFICULTY_EASY => 'Easy',
                        Chessboard::DIFFICULTY_MEDIUM => 'Medium',
                        Chessboard::DIFFICULTY_HARD => 'Hard',
                    ),
                    'required' => true,
                ))
                ->getForm();

        return array(
            'form' => $oForm->createView(),
            'theme' => $sTheme,
            'board' => $oGame->getBoard(),
            'player' => $oGame->getPlayer(),
        );
    }

    /**
     * @Route("/game/action")
     * @Template()
     */
    public function doGameAction(Request $request) {
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

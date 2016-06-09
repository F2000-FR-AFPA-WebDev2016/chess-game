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

class GameController extends Controller {

    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function homeAction(Request $request) {
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
     * @Route("/game/action")
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

    /**
     * @Route("/game/test/{x}/{y}", name="game_test")
     * @Template()
     */
    public function game2Action($x, $y) {
        $oSession = new Session;
        $oGame = $oSession->get('game', NULL);

        $aData = $oGame->doAction($x, $y);
        return new \Symfony\Component\HttpFoundation\JsonResponse($aData);
    }

    /**
     * @Route("/game/reset",name="reset_game")
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
    public function gameViewAction(Request $request) {
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

        return $this->render('AfpaChessGameBundle:Game:gameView.html.twig', array(
                    'form' => $oForm->createView(),
                    'theme' => $sTheme,
                    'board' => $oGame->getBoard(),
                    'player' => $oGame->getPlayer(),
        ));
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
     * @Route("/game/list", name="game_list")
     * @Template()
     */
    public function listAction(Request $request) {
        $oSession = $request->getSession();

        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGames = $repo->findAll();

        $oGame = null;
        // Si l'utilisateur est connecté, on récupère la partie liée si existante
        if ($oSession->get('oUser') instanceof User) {
            $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:User');
            $oUser = $repo->find($oSession->get('oUser')->getId());

            $oGame = $oUser->getGame();
            if ($oGame instanceof Game && $oGame->getStatus() == Game::STATUS_STARTED) {
                return $this->redirect($this->generateUrl('game_play', array('idGame' => $oGame->getId())));
            }
        }

        return array(
            'games' => $oGames,
            'game_user' => $oGame
        );
    }

    /**
     * @Route("/game/create", name="create")
     * @Template()
     */
    public function createGameAction(Request $request) {
        $oSession = $request->getSession();

        // Si l'utilisateur n'est pas connecté, redirection list :
        if (!$oSession->get('oUser') instanceof User) {
            return $this->redirect($this->generateUrl('game_list'));
        }

        $oGame = new Game;
        $oGame->setCreatedDate(new \DateTime('now'));
        $oGame->setData('');
        $oGame->setStatus(Game::STATUS_WAITING);

        $em = $this->getDoctrine()->getManager();
        $em->persist($oGame);
        $em->flush();

        // récupéerer en base, le user connecté
        // + faire un setGame(xxx)

        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:User');
        $oUser = $repo->find($oSession->get('oUser')->getId());
        $oUser->setGame($oGame);
        $em->flush();

        return $this->redirect($this->generateUrl('game_list'));
    }

    /**
     * @Route("/game/join/{idGame}", name="join")
     * @Template()
     * */
    public function joinGameAction(Request $request, $idGame) {
        $oSession = $request->getSession();

        // Si l'utilisateur n'est pas connecté, redirection list :
        if (!$oSession->get('oUser') instanceof User) {
            return $this->redirect($this->generateUrl('game_list'));
        }

        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGame = $repo->find($idGame);

        if ($oGame instanceof Game) {
            $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:User');
            $oUser = $repo->find($oSession->get('oUser')->getId());
            $oUser->setGame($oGame);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            if (count($oGame->getUsers()) == 2) {
                $oBoard = new Chessboard;
                $oBoard->setPlayers($oGame);

                $oGame->setStatus(Game::STATUS_STARTED);
                $oGame->setData(serialize($oBoard));

                $em->flush();

                return $this->redirect($this->generateUrl('game_play', array('idGame' => $oGame->getId())));
            }
        }
        return $this->redirect($this->generateUrl('game_list'));
    }

    /**
     * @Route("/game/play/{idGame}", name="game_play")
     * @Template()
     * */
    public function playGameAction($idGame) {
        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGame = $repo->findOneBy(array(
            'id' => $idGame,
            'status' => Game::STATUS_STARTED
        ));

        // condition de sortie
        if (!$oGame instanceof Game) {
            return $this->redirect($this->generateUrl('game_list'));
        }

        return array(
            'idGame' => $idGame
        );
    }

    /**
     * @Route("/game/refresh/{idGame}", name="refresh")
     * @Template()
     */
    public function refreshGameAction(Request $request, $idGame) {
        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGame = $repo->findOneBy(array(
            'id' => $idGame,
            'status' => Game::STATUS_STARTED
        ));

        // condition de sortie
        if (!$oGame instanceof Game) {
            return $this->redirect($this->generateUrl('game_list'));
        }

        // récupération de la partie
        $oBoard = unserialize($oGame->getData());

        $oSession = $request->getSession();
        $sTheme = $oSession->get('theme');

        $defaultData = array(
            'theme' => $sTheme,
            'difficulty' => $oBoard->getDifficulty()
        );
        $oForm = $this->createFormBuilder($defaultData)
                ->add('theme', 'choice', array(
                    'choices' => array(
                        'default' => 'Default',
                        'sexy' => 'Sexy',
                        'funny' => 'funny',
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

        // On refresh si : User not connected OU User adverse doit jouer
        $bShouldRefresh = (!$oSession->get('oUser') instanceof User) || ($oSession->get('oUser')->getId() !== $oBoard->getPlayerId());

        return $this->render('AfpaChessGameBundle:Game:refreshGame.html.twig', array(
                    'idGame' => $idGame,
                    'form' => $oForm->createView(),
                    'theme' => $sTheme,
                    'board' => $oBoard->getBoard(),
                    'player' => $oBoard->getPlayer(),
                    'should_refresh' => $bShouldRefresh,
        ));
    }

    /**
     * @Route("/game/action/{idGame}")
     * @Template()
     */
    public function gameOnlineAction(Request $request, $idGame) {
        $oSession = $request->getSession();

        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGame = $repo->findOneBy(array(
            'id' => $idGame,
            'status' => Game::STATUS_STARTED
        ));

        // condition de sortie 1
        if (!$oGame instanceof Game) {
            return new \Symfony\Component\HttpFoundation\JsonResponse();
        }

        // condition de sortie 2
        if (!$oSession->get('oUser') instanceof User) {
            return new \Symfony\Component\HttpFoundation\JsonResponse();
        }

        $x1 = $request->get('x1');
        $y1 = $request->get('y1');
        $x2 = $request->get('x2', null);
        $y2 = $request->get('y2', null);

        $oBoard = unserialize($oGame->getData());
        $aData = $oBoard->doAction($x1, $y1, $x2, $y2, $oSession->get('oUser')->getId());
        $oGame->setData(serialize($oBoard));

        // Sauvegarder la partie
        $this->getDoctrine()->getManager()->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse($aData);
    }

}

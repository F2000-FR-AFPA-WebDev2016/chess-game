<?php

namespace Afpa\ChessGameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Afpa\ChessGameBundle\Entity\Game;
use Afpa\ChessGameBundle\Entity\User;
use Afpa\ChessGameBundle\Model\Chessboard;

class GameOnlineController extends Controller {

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
     * @Route("/game/create", name="game_create")
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
     * @Route("/game/join/{idGame}", name="game_join")
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
     * @Route("/game/refresh/{idGame}")
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

        //Onrecupere le nom du jeur
        $repos = $this->getDoctrine()->getRepository('AfpaChessGameBundle:User');
        $oUser = $repos->find($oBoard->getPlayerId());

        return $this->render('AfpaChessGameBundle:Game:refreshGame.html.twig', array(
                    'idGame' => $idGame,
                    'form' => $oForm->createView(),
                    'theme' => $sTheme,
                    'board' => $oBoard->getBoard(),
                    'player' => $oBoard->getPlayer(),
                    'should_refresh' => $bShouldRefresh,
                    'name' => $oUser->getNickname()
        ));
    }

    /**
     * @Route("/game/action/{idGame}")
     * @Template()
     */
    public function doGameAction(Request $request, $idGame) {
        $oSession = $request->getSession();

        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGame = $repo->findOneBy(array(
            'id' => $idGame,
            'status' => Game::STATUS_STARTED
        ));

        // condition de sortie 1
        if (!$oGame instanceof Game) {
            return new JsonResponse();
        }

        // condition de sortie 2
        if (!$oSession->get('oUser') instanceof User) {
            return new JsonResponse();
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

        return new JsonResponse($aData);
    }

}

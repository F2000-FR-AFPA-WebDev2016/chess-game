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
                        'sexy' => 'Sexy'
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
            'idGame' => $idGame,
            'form' => $oForm->createView(),
            'theme' => $sTheme,
            'board' => $oBoard->getBoard(),
            'player' => $oBoard->getPlayer(),
        );
    }

    /**
     * @Route("/game/action/{idGame}")
     * @Template()
     */
    public function doGameAction(Request $request, $idGame) {
        $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:Game');
        $oGame = $repo->findOneBy(array(
            'id' => $idGame,
            'status' => Game::STATUS_STARTED
        ));

        // condition de sortie
        if (!$oGame instanceof Game) {
            return $this->redirect($this->generateUrl('game_list'));
        }

        // TODO : Récupérer la partie
        //
        // TODO : Effectuer l'action
        //
        // TODO : Sauvegarder la partie


        return new \Symfony\Component\HttpFoundation\JsonResponse();
    }

}

<?php

namespace Afpa\ChessGameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GameController extends Controller {

    protected $theme = 'default';

    /**
     * @Route("/home")
     * @Template()
     */
    public function homeAction() {
        $aPlateau = array();
        return $this->render('AfpaChessGameBundle:Game:home.html.twig', array(
                    'theme' => $this->theme,
                    'board' => $aPlateau
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

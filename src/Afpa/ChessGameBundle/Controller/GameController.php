<?php

namespace Afpa\ChessGameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GameController extends Controller
{
    /**
     * @Route("/home")
     * @Template()
     */
    public function homeAction()
    {
    }

    /**
     * @Route("/credits")
     * @Template()
     */
    public function creditsAction()
    {
    }

    /**
     * @Route("/rules")
     * @Template()
     */
    public function rulesAction()
    {
    }

    /**
     * @Route("/end")
     * @Template()
     */
    public function endAction()
    {
    }

}

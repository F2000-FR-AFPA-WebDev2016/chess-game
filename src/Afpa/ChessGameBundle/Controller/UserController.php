<?php

namespace Afpa\ChessGameBundle\Controller;

use Afpa\ChessGameBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller {

    /**
     * @Route("/login",name="login")
     * @Template()
     */
    public function loginAction(Request $request) {
        $oUserForm = new User();
        $oForm = $this->createFormBuilder($oUserForm)
                ->add('nickname', 'text')
                ->add('password', 'password')
                ->getForm();
        if ($request->isMethod('POST')) {
            $oForm->bind($request);
            if ($oForm->isValid()) {
                $repo = $this->getDoctrine()->getRepository('AfpaChessGameBundle:User');
                $oUserTmpBdd = $repo->findOneByNickname($oUserForm->getNickname());
                //moins bien en literal : $oUserTmpBdd->getPassword() == $oUserForm->getPassword() :
                if ($oUserTmpBdd && $oUserTmpBdd->verifAuth($oUserForm->getPassword())) {
                    $oSession = $request->getSession();
                    $oSession->set('oUser', $oUserTmpBdd); //clé oUser et valeur $oUserTmp
                    //$_SESSION['ouser']=$oUserTmp;
                    return $this->redirect($this->generateUrl('home'));
                }
            }
        }
        return array('form' => $oForm->createView());
    }

    /**
     * @Route("/register",name="register")
     * @Template()
     */
    public function registerAction(Request $request) {
        $oUser = new User();
        $oForm = $this->createFormBuilder($oUser)
                ->add('nickname', 'text')
                ->add('email', 'email')
                ->add('password', 'password')
                ->getForm();
        if ($request->isMethod('POST')) {
            $oForm->bind($request);
            if ($oForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($oUser);
                $em->flush();
            }
        }
        return array('form' => $oForm->createView());
    }

    /**
     * @Route("/logout",name="logout")
     * @Template()
     */
    public function logoutAction(Request $request) {
        $request->getSession()->clear();
        return $this->redirect($this->generateUrl('home'));
    }

}

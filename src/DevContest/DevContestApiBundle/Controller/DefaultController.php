<?php

namespace DevContest\DevContestApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DevContestApiBundle:Default:index.html.twig', array('name' => $name));
    }
}

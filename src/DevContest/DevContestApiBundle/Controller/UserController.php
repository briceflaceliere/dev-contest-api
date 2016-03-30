<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 19:13
 */

namespace DevContest\DevContestApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   resourceDescription="Operations on users.",
     *   description="Retrieving users",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   output  = {
     *     "class" = "DevContest\DevContestApiBundle\Entity\User",
     *     "parsers" = {"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *   }
     * )
     *
     * @Rest\View
     */
    public function getUsersAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $users = $this->getDoctrine()
            ->getRepository('DevContestApiBundle:User')
            ->findAll();

        $data = ['users' => $users];

        return $data;
    }
} 
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
     *   output  = "Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination"
     * )
     *
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page of the result")
     * @Rest\QueryParam(name="limit", requirements="([0-9]{1,2}|100)", default="25", description="Limit of the result")
     *
     * @Rest\View
     */
    public function getUsersAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $users = $this->getDoctrine()
            ->getRepository('DevContestApiBundle:User')
            ->qFindAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $page,
            $limit
        );

        return $pagination;
    }
} 
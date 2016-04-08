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
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class UserController
 * @package DevContest\DevContestApiBundle\Controller
 *
 *
 *
 */
class UserController extends AbstractController
{
    /**
     * Get users
     *
     * @param Request               $request
     * @param ParamFetcherInterface $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     *
     * @ApiDoc(
     *   resource = "Users",
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
        return parent::getObjects('DevContestApiBundle:User', $request, $paramFetcher);
    }

    /**
     * Get user
     *
     * @param integer $id Id of the user
     * @return \DevContest\DevContestApiBundle\Entity\User
     *
     * @ApiDoc(
     *   resource = "Users",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights",
     *     404 = "User not found"
     *   },
     *   output  = "DevContest\DevContestApiBundle\Entity\User"
     * )
     *
     * @Rest\View()
     * @Rest\Route(requirements={"id"="[0-9]+"})
     */
    public function getUserAction($id)
    {
        return parent::getObject('DevContestApiBundle:User', $id);
    }

    /**
     * Create user
     *
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *   resource = "Users",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\UserType"
     * )
     *
     * @Rest\View()
     */
    public function postUsersAction(Request $request)
    {
        return parent::postObjects('DevContestApiBundle:User', $request);
    }

    /**
     * Update user
     *
     * @param Request $request
     * @param integer $id      Id of the user
     * @return array
     *
     * @ApiDoc(
     *   resource = "Users",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\UserType"
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     */
    public function putUsersAction(Request $request, $id)
    {
        return parent::putObjects('DevContestApiBundle:User', $request, $id);
    }

    /**
     * Delete user
     *
     * @param Request $request
     * @param integer $id      Id of the user
     * @return array
     *
     * @ApiDoc(
     *   resource = "Users",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   }
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     */
    public function deleteUsersAction(Request $request, $id)
    {
        return parent::deleteObjects('DevContestApiBundle:User', $request, $id);
    }
}

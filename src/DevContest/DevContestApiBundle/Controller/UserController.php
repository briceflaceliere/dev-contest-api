<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 19:13
 */

namespace DevContest\DevContestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class UserController
 * @package DevContest\DevContestApiBundle\Controller
 */
class UserController extends AbstractController
{
    /**
     * Get users
     *
     * @param Request               $request
     * @param ParamFetcher          $paramFetcher
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
     * @Rest\View(serializerGroups={"all", "list"})
     */
    public function getUsersAction(Request $request, ParamFetcher $paramFetcher)
    {
        return parent::getObjects('DevContestApiBundle:User', $request, $paramFetcher);
    }

    /**
     * Get user
     *
     * @param integer $id Id of the user
     * @param Request $request
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
     * @Rest\View(serializerGroups={"all", "detail"})
     * @Rest\Route(requirements={"id"="[0-9]+"})
     *
     */
    public function getUserAction(int $id, Request $request)
    {
        return parent::getObject('DevContestApiBundle:User', $request);
    }

    /**
     * Get me user
     * (Scope: User)
     *
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
     * @Rest\View(serializerGroups={"all", "detail", "private"})
     * @Security("has_role('ROLE_USER')")
     */
    public function getMeAction()
    {
        return $this->getUserPrivateAction($this->getUser()->getId());
    }

    /**
     * Get private user detail
     * (Scope: User)
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
     * @Rest\View(serializerGroups={"all", "detail", "private"})
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Security("has_role('ROLE_USER')")
     */
    public function getUserPrivateAction(int $id)
    {
        try {
            $entity = $this->getDoctrine()
                           ->getRepository('DevContestApiBundle:User')
                           ->find($id);
        } catch (NoResultException $e){
            throw new ResourceNotFoundException("User not found");
        }

        if (!$this->isGranted('ROLE_OWNER', $entity)) {
            throw $this->createAccessDeniedException('Insufficient access rights');
        }

        return $entity;
    }

    /**
     * Delete user
     * (Scope: User)
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
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteUsersAction(int $id, Request $request)
    {
        return parent::deleteObjects('DevContestApiBundle:User', $request, 'ROLE_OWNER');
    }
}

<?php

namespace DevContest\DevContestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class TestController
 * @package DevContest\DevContestApiBundle\Controller
 */
class TestController extends AbstractController
{
    /**
     * Get tests
     *
     * @param Request               $request
     * @param ParamFetcherInterface $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     *
     * @ApiDoc(
     *   resource = "Tests",
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
    public function getTestsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return parent::getObjects('DevContestApiBundle:Test', $request, $paramFetcher);
    }

    /**
     * Get test
     *
     * @param integer $id Id of the test
     * @return \DevContest\DevContestApiBundle\Entity\Test
     *
     * @ApiDoc(
     *   resource = "Tests",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights",
     *     404 = "Test not found"
     *   },
     *   output  = "DevContest\DevContestApiBundle\Entity\Test"
     * )
     *
     * @Rest\View(serializerGroups={"all", "detail"})
     * @Rest\Route(requirements={"id"="[0-9]+"})
     */
    public function getTestAction($id)
    {
        return parent::getObject('DevContestApiBundle:Test', $id);
    }

    /**
     * Create Test
     * (Scope: Admin)
     *
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *   resource = "Tests",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\TestType"
     * )
     *
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function postTestsAction(Request $request)
    {
        return parent::postObjects('DevContestApiBundle:Test', $request);
    }

    /**
     * Update Test
     * (Scope: Admin)
     *
     * @param Request $request
     * @param integer $id      Id of the Test
     * @return array
     *
     * @ApiDoc(
     *   resource = "Tests",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\TestType"
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function putTestsAction(Request $request, $id)
    {
        return parent::putObjects('DevContestApiBundle:Test', $request, $id);
    }

    /**
     * Delete Test
     * (Scope: Admin)
     *
     * @param Request $request
     * @param integer $id      Id of the Test
     * @return array
     *
     * @ApiDoc(
     *   resource = "Tests",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   }
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteTestsAction(Request $request, $id)
    {
        return parent::deleteObjects('DevContestApiBundle:Test', $request, $id);
    }
}

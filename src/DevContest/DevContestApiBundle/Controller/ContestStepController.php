<?php

namespace DevContest\DevContestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ContestStepController
 * @package DevContest\DevContestApiBundle\Controller
 */
class ContestStepController extends AbstractController
{
    /**
     * Get ContestSteps
     *
     * @param integer               $contestId
     * @param Request               $request
     * @param ParamFetcherInterface $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
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
     * @Rest\Route(requirements={"contestId"="[0-9]+"})
     */
    public function getStepsAction($contestId, Request $request, ParamFetcherInterface $paramFetcher)
    {
        $entities = $this->getDoctrine()
            ->getRepository('DevContestApiBundle:ContestStep')
            ->qFindByContestId($contestId);

        return parent::getObjects('DevContestApiBundle:ContestStep', $request, $paramFetcher, $entities);
    }

    /**
     * Get ContestStep
     *
     * @param integer $contestId
     * @param integer $stepId
     * @return \DevContest\DevContestApiBundle\Entity\ContestStep
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights",
     *     404 = "ContestStep not found"
     *   },
     *   output  = "DevContest\DevContestApiBundle\Entity\ContestStep"
     * )
     *
     * @Rest\View(serializerGroups={"all", "detail"})
     * @Rest\Route(requirements={"stepId"="[0-9]+"})
     * @Rest\Route(requirements={"contestId"="[0-9]+"})
     */
    public function getStepAction($contestId, $stepId)
    {
        return parent::getObject('DevContestApiBundle:ContestStep', $stepId);
    }

    /**
     * Create ContestStep
     *
     * @param Request $request
     * @param integer $contestId
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\ContestStepType"
     * )
     *
     * @Rest\View()
     * @Rest\Route(requirements={"contestId"="[0-9]+"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function postStepsAction($contestId, Request $request)
    {
        return parent::postObjects('DevContestApiBundle:ContestStep', $request);
    }

    /**
     * Update ContestStep
     *
     * @param Request $request
     * @param integer $contestId
     * @param integer $stepId
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\ContestStepType"
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Route(requirements={"stepId"="[0-9]+"})
     * @Rest\Route(requirements={"contestId"="[0-9]+"})
     */
    public function putStepsAction($contestId, $stepId, Request $request)
    {
        return parent::putObjects('DevContestApiBundle:ContestStep', $request, $stepId);
    }

    /**
     * Delete ContestStep
     *
     * @param Request $request
     * @param integer $contestId
     * @param integer $stepId
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   }
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     *
     * @Rest\Route(requirements={"stepId"="[0-9]+"})
     * @Rest\Route(requirements={"contestId"="[0-9]+"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteStepsAction($contestId, $stepId, Request $request)
    {
        return parent::deleteObjects('DevContestApiBundle:ContestStep', $request, $stepId);
    }
}

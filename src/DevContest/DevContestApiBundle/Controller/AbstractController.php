<?php

namespace DevContest\DevContestApiBundle\Controller;

use Doctrine\ORM\NoResultException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class AbstractController
 * @package DevContest\DevContestApiBundle\Controller
 */
abstract class AbstractController extends FOSRestController
{
    /**
     * Get [objects]
     *
     * @param String                $repositoryName
     * @param Request               $request
     * @param ParamFetcher          $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     */
    public function getObjects($repositoryName, Request $request, ParamFetcher $paramFetcher)
    {
        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $params = $this->filterRouteParams($request);
        $entities = $this->getDoctrine()
            ->getRepository($repositoryName)
            ->qFindBy($params);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $page,
            $limit
        );

        return $pagination;
    }

    /**
     * Get [object]
     *
     * @param string         $repositoryName
     * @param Request        $request
     * @param string|null    $role
     * @return \DevContest\DevContestApiBundle\Entity\[Object]
     */
    public function getObject($repositoryName, $request, $role = null)
    {
        try {
            $entity = $this->findOneByRequest($repositoryName, $request);
        } catch (NoResultException $e){
            throw new ResourceNotFoundException($this->getEntityName($repositoryName)." not found");
        }

        if ($role && !$this->isGranted($role, $entity)) {
            throw $this->createAccessDeniedException('Insufficient access rights');
        }

        return $entity;
    }

    /**
     * Create [object]
     *     *
     * @param String  $repositoryName
     * @param Request $request
     * @return array
     */
    public function postObjects($repositoryName, Request $request)
    {
        $entityFormType = $this->getEntityFormType($repositoryName);
        $entityName     = $this->getEntityFullName($repositoryName);

        $entity = new $entityName();
        $form = $this->createForm(new $entityFormType(), $entity);

        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'get_'.$this->getEntityRoute($repositoryName),
                    ['id' => $entity->getId()]
                ),
                Codes::HTTP_CREATED
            );
        }

        return [
            'form' => $form,
        ];
    }

    /**
     * Update [object]
     *
     * @param String         $repositoryName
     * @param Request        $request
     * @param string|null    $role
     * @return array
     */
    public function putObjects($repositoryName, Request $request, $role = null)
    {
        try {
            $entity = $this->findOneByRequest($repositoryName, $request);
        } catch (NoResultException $e){
            throw new ResourceNotFoundException($this->getEntityName($repositoryName)." not found");
        }

        if ($role && !$this->isGranted($role, $entity)) {
            throw $this->createAccessDeniedException('Insufficient access rights');
        }

        $entityFormType = $this->getEntityFormType($repositoryName);
        $form = $this->createForm(new $entityFormType(), $entity);

        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->view(
                null,
                Codes::HTTP_NO_CONTENT
            );
        }

        return [
            'form' => $form,
        ];
    }

    /**
     * Delete [object]
     *
     * @param String         $repositoryName
     * @param Request        $request
     * @param string|null    $role
     * @return array
     */
    public function deleteObjects($repositoryName, Request $request, $role = null)
    {
        try {
            $entity = $this->findOneByRequest($repositoryName, $request);
        } catch (NoResultException $e){
            throw new ResourceNotFoundException($this->getEntityName($repositoryName)." not found");
        }

        if ($role && !$this->isGranted($role, $entity)) {
            throw $this->createAccessDeniedException('Insufficient access rights');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }

    /**
     * Filter route params for find
     * @param Request $request
     * @return array
     */
    protected function filterRouteParams(Request $request) {
        return array_filter($request->get('_route_params'), function($param) {
            return substr($param, 0, 1) != '_';
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Find one by Request
     *
     * @param String $repositoryName
     * @param Request $request
     * @return object
     */
    protected function findOneByRequest($repositoryName, Request $request)
    {
        $params = $this->filterRouteParams($request);
        return $this->getDoctrine()
            ->getRepository($repositoryName)
            ->qFindBy($params)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Get Entity full name from repository
     *
     * @param  string $repositoryName
     * @return string
     */
    protected function getEntityFullName($repositoryName)
    {
        return $this->getDoctrine()->getManager()->getClassMetadata($repositoryName)->getName();
    }

    /**
     * Get Entity name from repository
     *
     * @param  string $repositoryName
     * @return string
     */
    protected function getEntityName($repositoryName)
    {
        return end(explode('\\', $this->getEntityFullName($repositoryName)));
    }

    /**
     * Get Form type name from repository
     *
     * @param  string $repository
     * @return string
     */
    protected function getEntityFormType($repositoryName)
    {
        return str_replace('\\Entity\\', '\\Form\\Type\\', $this->getEntityFullName($repositoryName)).'Type';
    }

    /**
     * Get route name from repository
     *
     * @param  string $repositoryName
     * @return string
     */
    protected function getEntityRoute($repositoryName)
    {
        return strtolower($this->getEntityName($repositoryName));
    }
}

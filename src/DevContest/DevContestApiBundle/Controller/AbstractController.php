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

/**
 * Class AbstractController
 * @package DevContest\DevContestApiBundle\Controller
 *
 *
 *
 */
abstract class AbstractController extends FOSRestController
{
    /**
     * Get [objects]
     *
     * @param String                $repository
     * @param Request               $request
     * @param ParamFetcherInterface $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     */
    public function getObjects($repository, Request $request, ParamFetcherInterface $paramFetcher)
    {
        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $entities = $this->getDoctrine()
            ->getRepository($repository)
            ->qFindAll();

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
     * @param string         $repository
     * @param integer        $id         Id of the object
     * @param string|null    $role
     * @return \DevContest\DevContestApiBundle\Entity\[Object]
     */
    public function getObject($repository, $id, $role = null)
    {
        $object = $this->getDoctrine()
            ->getRepository($repository)
            ->find($id);

        if (!$object) {
            throw new ResourceNotFoundException($this->getEntityName($repository)." not found");
        }

        if ($role && !$this->isGranted($role, $object)) {
            throw $this->createAccessDeniedException('Insufficient access rights');
        }

        return $object;
    }

    /**
     * Create [object]
     *     *
     * @param String  $repository
     * @param Request $request
     * @return array
     */
    public function postObjects($repository, Request $request)
    {
        $entityFormType = $this->getEntityFormType($repository);
        $entityName     = $this->getEntityFullName($repository);

        $entity = new $entityName();
        $form = $this->createForm(new $entityFormType(), $entity);


        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'get_'.$this->getEntityRoute($repository),
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
     * @param String         $repository
     * @param Request        $request
     * @param integer        $id         Id of the object
     * @param string|null    $role
     * @return array
     */
    public function putObjects($repository, Request $request, $id, $role = null)
    {
        $entity = $this->getDoctrine()
            ->getRepository($repository)
            ->find($id);

        if (!$entity) {
            throw new ResourceNotFoundException($this->getEntityName($repository)." not found");
        }

        if ($role && !$this->isGranted($role, $entity)) {
            throw $this->createAccessDeniedException('Insufficient access rights');
        }

        $entityFormType = $this->getEntityFormType($repository);
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
     * @param String         $repository
     * @param Request        $request
     * @param integer        $id         Id of the [object]
     * @param string|null    $role
     * @return array
     */
    public function deleteObjects($repository, Request $request, $id, $role = null)
    {
        $entity = $this->getDoctrine()
            ->getRepository($repository)
            ->find($id);

        if (!$entity) {
            throw new ResourceNotFoundException($this->getEntityName($repository)." not found");
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
     * Get Entity full name from repository
     *
     * @param  string $repository
     * @return string
     */
    protected function getEntityFullName($repository)
    {
        return $this->getDoctrine()->getManager()->getClassMetadata($repository)->getName();
    }

    /**
     * Get Entity name from repository
     *
     * @param  string $repository
     * @return string
     */
    protected function getEntityName($repository)
    {
        return end(explode('\\', $this->getEntityFullName($repository)));
    }

    /**
     * Get Form type name from repository
     *
     * @param  string $repository
     * @return string
     */
    protected function getEntityFormType($repository)
    {
        return str_replace('\\Entity\\', '\\Form\\Type\\', $this->getEntityFullName($repository)).'Type';
    }

    /**
     * Get route name from repository
     *
     * @param  string $repository
     * @return string
     */
    protected function getEntityRoute($repository)
    {
        return strtolower($this->getEntityName($repository));
    }
}

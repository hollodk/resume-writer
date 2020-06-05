<?php

namespace App\Controller;

use App\Entity\Employment;
use App\Entity\Resume;
use App\Form\EmploymentType;
use App\Repository\EmploymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employment")
 */
class EmploymentController extends AbstractController
{
    /**
     * @Route("/", name="employment_index", methods={"GET"})
     */
    public function index(EmploymentRepository $employmentRepository): Response
    {
        return $this->render('employment/index.html.twig', [
            'employments' => $employmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{resume}/new", name="employment_new", methods={"GET","POST"})
     */
    public function new(Request $request, Resume $resume): Response
    {
        $employment = new Employment();
        $employment->setResume($resume);

        $form = $this->createForm(EmploymentType::class, $employment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employment);
            $entityManager->flush();

            return $this->redirectToRoute('resume_edit', [
                'id' => $employment->getResume()->getId(),
            ]);
        }

        return $this->render('employment/new.html.twig', [
            'employment' => $employment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employment_show", methods={"GET"})
     */
    public function show(Employment $employment): Response
    {
        return $this->render('employment/show.html.twig', [
            'employment' => $employment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Employment $employment): Response
    {
        $form = $this->createForm(EmploymentType::class, $employment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resume_edit', [
                'id' => $employment->getResume()->getId(),
            ]);
        }

        return $this->render('employment/edit.html.twig', [
            'employment' => $employment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Employment $employment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employment_index');
    }
}

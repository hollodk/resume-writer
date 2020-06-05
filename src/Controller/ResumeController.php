<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Education;
use App\Entity\Employment;
use App\Entity\Language;
use App\Entity\Link;
use App\Entity\Reference;
use App\Entity\Resume;
use App\Entity\Skill;
use App\Form\CourseType;
use App\Form\EducationType;
use App\Form\EmploymentType;
use App\Form\LanguageType;
use App\Form\LinkType;
use App\Form\ReferenceType;
use App\Form\ResumeType;
use App\Form\SkillType;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resume")
 */
class ResumeController extends AbstractController
{
    /**
     * @Route("/", name="resume_index", methods={"GET"})
     */
    public function index(ResumeRepository $resumeRepository): Response
    {
        return $this->render('resume/index.html.twig', [
            'resumes' => $resumeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="resume_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resume = new Resume();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($resume);
        $entityManager->flush();

        return $this->redirectToRoute('resume_edit', [
            'id' => $resume->getId(),
        ]);
    }

    /**
     * @Route("/{id}", name="resume_show", methods={"GET"})
     */
    public function show(Resume $resume): Response
    {
        $parsedown = new \Parsedown();

        return $this->render('resume/show.html.twig', [
            'resume' => $resume,
            'parsedown' => $parsedown,
        ]);
    }

    /**
     * @Route("/{id}/imageremove", name="resume_imageremove", methods={"GET","POST"})
     */
    public function imageremove(Request $request, Resume $resume): Response
    {
        $resume->setProfileImage(null);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('resume_edit', [
            'id' => $resume->getId(),
        ]);
    }

    /**
     * @Route("/{id}/image", name="resume_image", methods={"GET","POST"})
     */
    public function image(Request $request, Resume $resume): Response
    {
        $response = new Response(base64_decode($resume->getProfileImage()));
        $response->headers->set('Content-Type', 'image/jpg');

        return $response;
    }

    /**
     * @Route("/{id}/edit", name="resume_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resume $resume): Response
    {
        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resume_edit', [
                'id' => $resume->getId(),
            ]);
        }

        $imageForm = $this->createFormBuilder()
            ->add('profileImage', FileType::class)
            ->getForm()
            ;

        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $data = $imageForm->getData();

            $content = base64_encode(file_get_contents($data['profileImage']->getPathName()));
            $resume->setProfileImage($content);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resume_edit', [
                'id' => $resume->getId(),
            ]);
        }

        $course = new Course();
        $courseForm = $this->createForm(CourseType::class, $course, [
            'action' => $this->generateUrl('course_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        $education = new Education();
        $educationForm = $this->createForm(EducationType::class, $education, [
            'action' => $this->generateUrl('education_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        $employment = new Employment();
        $employmentForm = $this->createForm(EmploymentType::class, $employment, [
            'action' => $this->generateUrl('employment_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        $language = new Language();
        $languageForm = $this->createForm(LanguageType::class, $language, [
            'action' => $this->generateUrl('language_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        $link = new Link();
        $linkForm = $this->createForm(LinkType::class, $link, [
            'action' => $this->generateUrl('link_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        $reference = new Reference();
        $referenceForm = $this->createForm(ReferenceType::class, $reference, [
            'action' => $this->generateUrl('reference_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        $skill = new Skill();
        $skillForm = $this->createForm(SkillType::class, $skill, [
            'action' => $this->generateUrl('skill_new', [
                'resume' => $resume->getId(),
            ]),
        ]);

        return $this->render('resume/edit.html.twig', [
            'resume' => $resume,
            'form' => $form->createView(),
            'image_form' => $imageForm->createView(),
            'course_form' => $courseForm->createView(),
            'education_form' => $educationForm->createView(),
            'employment_form' => $employmentForm->createView(),
            'language_form' => $languageForm->createView(),
            'link_form' => $linkForm->createView(),
            'reference_form' => $referenceForm->createView(),
            'skill_form' => $skillForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resume_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resume $resume): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resume->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resume);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resume_index');
    }
}

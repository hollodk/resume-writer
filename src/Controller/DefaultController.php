<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/p")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/{slug}")
     */
    public function resume(Request $request, $slug): Response
    {
        $resume = $this->getDoctrine()->getManager()->getRepository('App:Resume')->findOneBySlug($slug);

        return $this->render('resume/show.html.twig', [
            'resume' => $resume,
        ]);
    }
}

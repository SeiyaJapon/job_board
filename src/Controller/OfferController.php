<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\JobOffer;
use App\Form\ApplicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offer = $entityManager->getRepository(JobOffer::class)
            ->findAll();

        return $this->render('offer/index.html.twig', [
            'offers' => $offer
        ]);
    }

    /**
     * @param JobOffer               $offer
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("offer/{id}/apply", name="offer_apply")
     */
    public function apply(JobOffer $offer, Request $request, EntityManagerInterface $entityManager): Response {
        $applicant = new Applicant();

        $form = $this->createForm(ApplicationType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($applicant);
            $entityManager->flush();

            $this->addFlash('success', 'Your application has been received!');

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/apply.html.twig', [
            'offer' => $offer,
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param int                    $id
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("offer/{id}/apply", name="offer_apply")
     */
    public function apply(int $id, EntityManagerInterface $entityManager)
    {
        $offer = $entityManager->getRepository(JobOffer::class)
            ->find($id);

        return $this->render('offer/apply.html.twig', [
            'offer' => $offer
        ]);
    }
}

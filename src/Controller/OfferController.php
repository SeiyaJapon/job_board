<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager) : Response
    {
        $offer = $entityManager->getRepository(JobOffer::class)
            ->findAll();

        return $this->render('offer/index.html.twig', [
            'offers' => $offer
        ]);
    }

    /**
     * @IsGranted("ROLE_COMPANY_OWNER")
     * @Route("/company/", name="company_offers_index")
     * @return Response
     */
    public function companyOffers() : Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        if (!$company) {
            return $this->redirectToRoute('company_create');
        }

        return $this->render('offer/company_index.html.twig', [
            'offers' => $company->getJobOffers()
        ]);
    }
}

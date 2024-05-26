<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Vehicle;
use App\Form\SearchType;
use App\Entity\Availability;
use App\Form\AvailabilityType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AvailabilityRepository;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvailabilityController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/disponibilite', name: 'availability.index')]
    public function index(AvailabilityRepository $repository): Response
    {
        $availabilities = $repository->findAll();
        return $this->render('availability/index.html.twig', [
            'availabilities' => $availabilities, // IMPORTANT, otherwise twig template doesn't recognize the variable "availabilities"
        ]);
    }

    #[Route('/disponibilite/create', name: 'availability.create')]
    public function create (Request $request, EntityManagerInterface $em ) 
    {
       $availability = new Availability();
       $form = $this->createForm(AvailabilityType::class, $availability);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
        
            // the inputs can be null using the global DateTimeImmutable class
            $availability->setCreatedAt(new DateTimeImmutable()); 
            $availability->setUpdatedAt(new \DateTimeImmutable());

            $em->persist($availability);
            $em->flush();

            $this->addFlash('success', 'La création de disponibilité bien effectuée');
            
            return $this->redirectToRoute('availability.index');
        }

        return $this->render('availability/create.html.twig', [
                'availability' => $availability,
                'form' => $form,
            ]);
    }

    #[Route('/disponibilite/edit/{id}', name: 'availability.edit')]
    public function edit(int $id, AvailabilityRepository $repository, Request $request, EntityManagerInterface $em): Response
    {
        $availability = $repository->find($id);
        if (!$availability) {
            throw $this->createNotFoundException('Pas de disponibilité trouvée pour cet id : '.$id);
        }
        
        $form = $this->createForm(AvailabilityType::class, $availability);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'La modification bien effectuée');
            return $this->redirectToRoute('availability.index');
        }

        return $this->render('availability/edit.html.twig', [
            'availability' => $availability,
            'form' => $form
        ]);
    }

    #[Route('/disponibilite/delete/{id}', name: 'availability.delete')]
    public function delete(EntityManagerInterface $em, Availability $availability) : Response 
    {
        $em->remove($availability);
        $em->flush();

        $this->addFlash(
            'success', 'La suppression de disponibilité bien effectuée');
            
        return $this->redirectToRoute('availability.index');
    }


    #[Route('/disponibilite/recherche/resultat', name: 'availability.result')]
    public function result(AvailabilityRepository $availabilityRepository, Request $request, SessionInterface $session): Response 
    {
        $search = $session->get('search_data', []);
        $filterVehicles = $search['filterVehicles'] ?? [];
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $filterVehicles = $session->get('filterVehicles'); 

        return $this->render('availability/result.html.twig', [
            'filterVehicles' => $filterVehicles
        ]);
    }

    #[Route('/disponibilite/recherche', name: 'availability.search')]
    public function search(AvailabilityRepository $availabilityRepository, 
    Request $request, SessionInterface $session): Response 
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $filterVehicles = [];

        if ($form->isSubmitted() && $form->isValid()) {
        
            $startDateForm = $form->get('start_date')->getData();
            $endDateForm = $form->get('end_date')->getData();
    
            $start_date = DateTimeImmutable::createFromFormat('Y-m-d H:i', $startDateForm->format('Y-m-d H:i'));
            $end_date = DateTimeImmutable::createFromFormat('Y-m-d H:i', $endDateForm->format('Y-m-d H:i'));
    
            $qb = $availabilityRepository->findVehicleByDate($start_date, $end_date);
            $availabilities = $qb;
        
            if (!$session->isStarted()) {
                $session->start();
            }

            $priceVehicles = [];

            foreach ($availabilities as $availability) 
            {
                $dailyPrice = $availability->getPricePerDay();
                $availableVehicle = $availability->getVehicle()->getId();

                $priceVehicles[$availableVehicle] = $dailyPrice;
            }

       
            foreach ($availabilities as $availability) 
            {
                $filterVehicles[] = $availability->getVehicle();
            }

            foreach ($filterVehicles as $vehicle) 
            {
                $availableVehicle = $vehicle->getId();
                if (isset($priceVehicles[$availableVehicle])) {
                $vehicle->setPrice($priceVehicles[$availableVehicle]);
                }
            }

            $session = $this->requestStack->getCurrentRequest()->getSession();
            $session->set('search', [
                'filterVehicles' => $filterVehicles,

            ]);
           
            return $this->redirectToRoute('availability.result');
        }

        return $this->render('availability/search.html.twig', [
            'form' => $form,
        ]);
    }

}


    

<?php

namespace App\Controller;

use App\Service\VehicleAvailabilityService;
use App\Entity\Vehicle;
use App\Form\SearchType;
use App\Form\VehicleType;
use Monolog\DateTimeImmutable;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehicleController extends AbstractController
{
    #[Route('/vehicule', name: 'vehicle.index')]
    public function index(Request $request, VehicleRepository $repository ): Response
    {
        $vehicles = $repository -> findAll();
        
        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicles
        ]);
    }

    // new vehicle creation 
    #[Route('/vehicule/create', name: 'vehicle.create')]
    public function create (Request $request, EntityManagerInterface $em ) 
    {
        $qb = $em->createQueryBuilder();
        $qb->select('v')
           ->from('App\Entity\Vehicle', 'v');

        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
        
            // the inputs can be null using the global DateTimeImmutable class
            $vehicle->setCreatedAt(new \DateTimeImmutable()); 
            $vehicle->setUpdatedAt(new \DateTimeImmutable());

            $em->persist($vehicle);
            $em->flush();

            $this->addFlash('success', 'La création bien effectuée');
        
            return $this->redirectToRoute('vehicle.index');
        }

        return $this->render('vehicle/create.html.twig', [
            'vehicle' => $vehicle,
             'form' => $form,
        ]);
    }
   
}

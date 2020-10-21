<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LatestPhotosController extends AbstractController
{
    /**
     * @Route("/latest", name="latest_photos")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $latestPhotosPublic = $em->getRepository(Photo::class)->findAllPublic();

        return $this->render('latest_photos/index.html.twig',[
            'latestPhotosPublic' => $latestPhotosPublic
        ]);
    }
}
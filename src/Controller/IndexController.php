<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(UploadPhotoType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            if($this->getUser()){
                /** @var UploadedFile $pictureFileName */
                $pictureFileName = $form->get('filename')->getData();
                if($pictureFileName){
                    try{
                        $originalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                        $newFileName = $safeFileName.'-'.uniqid().'.'.$pictureFileName->guessExtension();
                        $pictureFileName->move('images/hosting', $newFileName);
                    
                        $entityPhotos = new Photo();
                        $entityPhotos->setFilename($newFileName);
                        $entityPhotos->setIsPublic($form->get('is_public')->getData());
                        $entityPhotos->setUploadedAt(new \DateTime());
                        $entityPhotos->setUser($this->getUser());
    
                        $em->persist($entityPhotos);
                        $em->flush();
    
                        $this->addFlash('success', 'Dodano zdjęcie!');
                    }catch(\Exception $e){
                        $this->addFlash('error', 'Zdjęcie nie zostało dodane!');
                    }

                }
            }
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

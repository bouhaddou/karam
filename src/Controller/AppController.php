<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Compteur;
use App\Repository\PostRepository;
use App\Repository\CompteurRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index(PostRepository $repo,CompteurRepository $repo2)
    {
       
        $cpt = $repo2->findOneBy(['id' => 1 ]);
        $zz = $this->getDoctrine()->getManager();
         if(($cpt == null) )
         {
        $com = new Compteur();
         $com->setCpt(1);
         $zz->persist($com);
         $zz->flush();
        }else{
            $cpt->setCpt($cpt->getCpt() + 1);
        }
        $zz->persist($cpt);
            $zz->flush();

        return $this->render('pages/index.html.twig', [
          'posts' => $repo->findSomePost(12),
         'compteur' => $cpt
        ]);
    }
}

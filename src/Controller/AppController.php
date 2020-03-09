<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Compteur;
use App\Repository\PostRepository;
use App\Repository\ProjetsRepository;
use App\Repository\CompteurRepository;
use App\Repository\OrphelinRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index(PostRepository $repoPost,ProjetsRepository $repoProjet,CompteurRepository $repoCompteur,OrphelinRepository $repoOrphelin)
    {
       
        $cpt = $repoCompteur->findOneBy(['id' => 5 ]);
        $zz = $this->getDoctrine()->getManager();
        $orphelin = $zz->createQuery(" SELECT count(c) FROM App\Entity\Orphelin c ")->getSingleScalarResult();
        $familly = $zz->createQuery(" SELECT count(f) FROM App\Entity\Familly f ")->getSingleScalarResult();
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
          'posts' => $repoPost->findSomePost(4),
          'projets' => $repoProjet->findSomeProjets(3),
          'orphelins' => $repoOrphelin->findAll(4),
          'compteur' => $cpt,
          'stats'  => compact('orphelin','familly'),
        ]);
    }
}

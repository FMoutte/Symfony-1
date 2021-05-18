<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\All;

class FilmsController extends AbstractController
{
    /**
     * @Route("/films", name="films")
     */
    public function index(): Response
    {
        $films = $this->getDoctrine()
            ->getRepository(Film::class)
            ->findAll();

        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'films'           => $films
        ]);
    }

    /**
     * @Route("/films/creer", name="films_create")
     */
    public function create(Request $request): Response
    {   

        if($request->isMethod("POST")){
            
            $titre = $request->request->get("titre");
            $resume = $request->request->get("resume");
            $annee_sortie = $request->request->get("annee_sortie");

            $genre_id = $request->request->get("genre");
            $genre = $this->getDoctrine()
                ->getRepository(Genre::class)
                ->find($genre_id);

            
            $acteur_id = $request->request->get("acteur");
            $acteur = $this->getDoctrine()
                ->getRepository(Acteur::class)
                ->find($acteur_id);
    

            $films = new Film;
            $films->setTitre($titre);
            $films->setResume($resume);
            $films->setAnneeSortie($annee_sortie);
            $films->setGenre($genre);
            $films->addActeur($acteur);
            
            
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($films);
            $em->flush();
        
            return $this->redirectToRoute('films');
        
        }

       
            $acteurs = $this->getDoctrine()
            ->getRepository(Acteur::class)
            ->findAll();

            


            $genres = $this->getDoctrine()
                ->getRepository(Genre::class)
                ->findAll();


            return $this->render('films/create.html.twig', [
                'controller_name' => 'FilmsController',
                'genres' => $genres ,
                'acteurs' => $acteurs
           ]);
            

            }  

            
             /**
     * @Route("/films/{id}/edition", name="films_edit")
     */
    public function edit($id, Request $request ): Response
    {   


        $film = $this->getDoctrine()
            ->getRepository(Film::class)
            ->find($id);


        if($request->isMethod("POST")){
            $titre = $request->request->get("titre");
            $film->setTitre($titre);
            
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        
            return $this->redirectToRoute('films');
        
        } 
            return $this->render('films/edit.html.twig', [
                'controller_name' => 'ActeursController',
                'film' => $film,
           ]);
        
        
         


            
            

            } 
             /**
            * @Route("/films/{id}/supression", name="films_delete")
            */
            
           public function delete($id,Request $request): Response
           {  
               
                   $film = $this->getDoctrine()
                       ->getRepository(Film::class)
                       ->find($id);
       
       
                   $em = $this->getDoctrine()->getManager();
                   $em->remove($film);
                   $em->flush();
               
                   return $this->redirectToRoute('films');
               
               
       
           }

        

}



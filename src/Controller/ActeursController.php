<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Acteur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActeursController extends AbstractController
{
    /**
     * @Route("/acteurs", name="acteurs")
     */
    public function index(): Response
    {   
        $acteurs = $this->getDoctrine()
            ->getRepository(Acteur::class)
            ->findAll();

        return $this->render('acteurs/index.html.twig', [
            'controller_name' => 'ActeursController',
            'acteurs' => $acteurs
        ]);
    }

    /**
     * @Route("/acteurs/creer", name="acteurs_create")
     */
    public function create(Request $request): Response
    {   
        if($request->isMethod("POST")){
            $nom = $request->request->get("nom");
            $prenom = $request->request->get("prenom");
            $dateNaissance = $request->request->get("date_naissance");
            $dateMort = $request->request->get("date_mort");
        
            $films = $request->request->get("film");

            $dateNaissance = new \DateTime($dateNaissance);

            if($dateMort!= "" ){
                $dateMort = new \DateTime($dateMort);
            }
            else{
                $dateMort = null;
            }
    
            $acteur = new Acteur;
            $acteur->setNom($nom);
            $acteur->setPrenom($prenom);
            $acteur->setDateNaissance($dateNaissance);
            $acteur->setDateMort($dateMort);
            
            
            foreach($films as $filmsid){
                $film = $this->getDoctrine()
                ->getRepository(Film::class)
                ->find($filmsid);
                $acteur->addFilm($film);
            }

            

            $em = $this->getDoctrine()->getManager();
            $em->persist($acteur);
            $em->flush();
        
            return $this->redirectToRoute('acteurs');


        
        }

            
            $films = $this->getDoctrine()
                ->getRepository(Film::class)
                ->findAll();
            
        

            return $this->render('acteurs/create.html.twig', [
                'controller_name' => 'ActeursController',
                'films' => $films ,
                
                
           ]);
            

            }  

             /**
     * @Route("/acteurs/{id}/edition", name="acteurs_edit" )
     */
    public function edit($id,Request $request ): Response
    {   


        $acteur = $this->getDoctrine()
            ->getRepository(Acteur::class)
            ->find($id);

            


        if($request->isMethod("POST")){
            $nom = $request->request->get("nom");
            $acteur->setNom($nom);
            
            
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        
            return $this->redirectToRoute('acteurs');
        
        }
            return $this->render('acteurs/edit.html.twig', [
                'controller_name' => 'ActeursController',
                'acteur' => $acteur,
                
           ]);
            

            }  /**
            * @Route("/acteurs/{id}/supression", name="acteurs_delete")
            */
           public function delete($id,Request $request): Response
           {  
               
                   $acteur = $this->getDoctrine()
                       ->getRepository(Acteur::class)
                       ->find($id);
       
       
                   $em = $this->getDoctrine()->getManager();
                   $em->remove($acteur);
                   $em->flush();
               
                   return $this->redirectToRoute('acteur');
               
               
       
           }

            
        
}

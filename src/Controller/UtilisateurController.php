<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request){
        $pdo = $this->getDoctrine()->getManager();

        $utilisateur = new Utilisateur();
        $utilisateur->setDateInscription(new \DateTime('now'));

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo->persist($utilisateur);    
            $pdo->flush();              
        }
        $utilisateurs = $pdo->getRepository(Utilisateur::class)->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
            'form_ajout' => $form->createView(),
        ]);
    }

    /**
    * @Route("/utilisateur/{id}", name="un_utilisateur")
    */
    public function categorie(Utilisateur $utilisateur=null, Request $request){
        if($utilisateur != null){

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
               //Analyse la raquette HTTP
               $form->handleRequest($request);
               if($form->isSubmitted() && $form->isValid()){
                   $pdo = $this->getDoctrine()->getManager();
                   $pdo->persist($utilisateur);    //prepare
                   $pdo->flush();              //execute
               }

        return $this->render('utilisateur/utilisateur.html.twig',[
            'utilisateur' => $utilisateur,
            'form_edit' => $form->createView(),
        ]);
        }
        else{
            // Produit n'existe pas, on redirige l'internaute
            return $this->redirectToRoute('accueil');
        }
    }
}

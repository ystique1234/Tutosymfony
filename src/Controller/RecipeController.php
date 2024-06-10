<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    // #[Route(path: '/recette/{slug}-{id}', name: 'app_recipe_show', requirements : ['id'=> '\d+', 'slug'=> '[a-z0-9-]+'])]
    // public function show(Request $request, string $slug, int $id): Response
    // {
    //     dd($slug, $id);
    //     // dd($request->attributes->get('slug'),$request->attributes->getInt('id'));
    //     // return new Response("Bienvenue dans la page des recettes");
    //     return new Response("Bienvenue sur ma page ".$request->query->get('recette','des recettes'));
    // }


    #[Route(path: '/recette', name: 'app_recipe_index')]
    // public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // return new Response("Bienvenue dans la page des recettes!!!");
        // Recuperation des recettes en bd
        // ca nous cree une liste de rectte qu'il recupere en bd
        // $recipes = $repository->findAll();(avec la premiere version)
        // la 2 eme version
        $recipes = $em->getRepository(Recipe::class)->findAll();
        // permet de recuperer toutes les recettes en dessous d'une durée en BD
        // $recipes =$repository->findRecipeDurationLowerThan(60);
        // dd($recipes);
        // $recipe = new Recipe;
        // $recipe->setTitle('Omelette ');
        // $recipe->setSlug('omelette');
        // $recipe->setContent('Prenez des oeufs, cassez les et ensuite battez les en rajoutant du sel.');
        // $recipe->setDuration(6);
        // $recipe->setCreatedAt( new DateTimeImmutable());
        // $recipe->setUpdatedAt(new DateTimeImmutable());
        // $em ->persist($recipe);
        // $recipe = new Recipe;
        // $recipe->setTitle('Poisson grillée');
        // $recipe->setSlug('poisson-grillee');
        // $recipe->setContent('Prendre du poisson mettre de ail pile,le citron,le gigimbre et le mettre au four.');
        // $recipe->setDuration(15);
        // $recipe->setCreatedAt( new DateTimeImmutable());
        // $recipe->setUpdatedAt(new DateTimeImmutable());
        // $em ->persist($recipe);
        // $em->flush();
        
        // $recipe = new Recipe;
        // $recipe->setTitle('Viande de boeuf');
        // $recipe->setSlug('viande-de-boeuf');
        // $recipe->setContent('Quel que soit le mode de cuisson envisagé, il convient toujours de sortir la viande du réfrigérateur un peu en avance, afin d’éviter le choc thermique dû à la chaleur, qui abîme les fibres. Il est aussi essentiel de laisser reposer la viande après cuisson, sous une feuille d’aluminium pour conserver la chaleur, ce qui permet aux fibres de se détendre et à la chaleur de se répartir. On conseille un temps de repos équivalent au temps de cuisson.Concernant l’assaisonnement, mieux vaut saler la viande après cuisson, pour préserver sa jutosité.
        // Les différentes techniques de découpe sont également essentielles pour profiter d’une viande savoureuse de qualité.');
        // $recipe->setDuration(40);
        // $recipe->setCreatedAt( new DateTimeImmutable());
        // $recipe->setUpdatedAt(new DateTimeImmutable());
        // $em ->persist($recipe);
        // $em->flush();
        

        // version avec l'utilisation du fluent setter
        // $recipe = new Recipe;
        // $recipe->setTitle('Omelette au fromage')
        //    ->setSlug('omelette-au-fromage')
        //    ->setContent('Prenez des oeufs, cassez les et ensuite battez les en rajoutant du sel.')
        //    ->setDuration(6)
        //    ->setCreatedAt( new DateTimeImmutable())
        //    ->setUpdatedAt(new DateTimeImmutable());

        //    $em ->persist($recipe);
        //    Modification
        // je modifie le nom de la 2 eme recette
        // $recipes[1]->setTitle('Saka Madesu');
        // $recipes[6]->setTitle('Viande de boeuf saignant')
                    // ->setSlug('viande-de-boeuf-siagnant')
                    // ->setContent('Quel que soit le mode de cuisson envisagé, il convient toujours de sortir la viande du réfrigérateur un peu en avance, afin d’éviter le choc thermique dû à la chaleur, qui abîme les fibres. Il est aussi essentiel de laisser reposer la viande après cuisson, sous une feuille d’aluminium pour conserver la chaleur, ce qui permet aux fibres de se détendre et à la chaleur de se répartir. On conseille un temps de repos équivalent au temps de cuisson.Concernant l’assaisonnement, mieux vaut saler la viande après cuisson, pour préserver sa jutosité.
                    // Les différentes techniques de découpe sont également essentielles pour profiter d’une viande savoureuse de qualité.');
        // $em->flush();
        // Suppression
        // Vais supprimer la 12,11,10,9,8,7,6 eme recette
        // $em->remove($recipes[11]);
        // $em->remove($recipes[10]);
        // $em->remove($recipes[9]);
        // $em->remove($recipes[8]);
        // $em->remove($recipes[7]);
        // $em->remove($recipes[6]);
        // $em->remove($recipes[5]);
        // $em->flush();
        // $em->remove($recipes[5]);
        // $em->flush();
        return $this->render('recipe/index.html.twig',['recipes'=>$recipes]);
    }

    #[Route(path: '/recette/{slug}-{id}', name: 'app_recipe_show', requirements : ['id'=> '\d+', 'slug'=> '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id,RecipeRepository $repository): Response
    {
        // affichage normal
        // return new Response("Recette numéro ".  $id . " : " .$slug);
        // affichage avec Json version longue en important JsonResponse
        // return new JsonResponse([
        //     'id' => $id,
        //     'slug' => $slug
        // ]);

        //Affiche en Json sans besoin d'import
        // return $this->Json([
        //     'id' => $id,
        //     'slug' => $slug
        // ]);
        // ça nous permet de recuperer une recette à partir du slug donnée en parametre
        // $recipe1 =$repository->findOneBy(['slug'=>$slug]);
        // dd($recipe1);
        // ça nous permet de recuperer une recette correspondant à l'id
        $recipe =$repository->find($id);
        if($recipe->getSlug() !== $slug){
            return $this->redirectToRoute('app_recipe_show',['id' => $recipe->getId(),'slug' => $recipe->getSlug()]);
        }
        return $this->render('recipe/show.html.twig', [
            // 'slug' => $slug,
            // 'id' => $id,
            // 'user' =>[
            //     "Firstname" => "Rose",
            //     "Lastname" => "Mystique",
            'recipe'=>$recipe
            ]);

    } 
 
    #[Route(path: '/recette/{id}/edit', name: 'app_recipe_edit')]
    public function edit(Recipe $recipe,Request $request,EntityManagerInterface $em):Response
    {
        // dd($recipe);
        // cette methode prend en premier parametre le formulaire que l'on souhaite utilkiser
        // en second parametre elle prend les données
        $form= $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        // dd($recipe);
        if ($form->isSubmitted() && $form->isValid()){
            $recipe->setUpdatedAt(new DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'La recette a bien été modifiée');
            // return $this->redirectToRoute('app_recipe_index');
            return $this->redirectToRoute('app_recipe_show',['id' =>
            $recipe->getId(), 'slug' =>
            $recipe->getSlug()]);
        }
        return $this->render('recipe/edit.html.twig',[
            'recipe' => $recipe,
            'monForm' =>$form
        ]);
        //  dd($recipe);

    
    }
    #[Route(path: '/recette/create', name: 'app_recipe_create')]
    public function create(Request $request,EntityManagerInterface $em):Response{
        $recipe = new Recipe;
        $form = $this->createForm(RecipeType::class,$recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $recipe->setCreatedAt(new DateTimeImmutable());
            $recipe->setUpdatedAt(new DateTimeImmutable());
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success','*La recette'.$recipe->getTitle() . 'a bien été crééé');
            return $this->redirectToRoute('app_recipe_index');
        }
        return $this->render('recipe/create.html.twig', [
            'form' =>$form
        ]);

}
#[Route(path: '/recette/{id}/delete', name: 'app_recipe_delete')]
    public function delete(Recipe $recipe,EntityManagerInterface $em):Response{
        $titre = $recipe->getTitle();
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('info', 'La recette' .$titre. 'a bien été supprimée');
        return $this->redirectToRoute('app_recipe_index');

}
}

<?php

namespace App\Controller;

use App\Form\CommentType;
use App\Form\TrickType;
use App\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tricks;
use App\Entity\Images;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks")
     */
    public function index(): Response
    {
        $tricks = $this->getDoctrine()->getRepository(Tricks::class)->findBy([],['created_at' => 'desc']);

        return $this->render('tricks/tricks.html.twig', [
            'tricks' => $tricks,
            'title' => 'Figures',
        ]);
    }

    /**
     * @Route("/add_tricks", name="add_tricks")
     */
    public function addTrick(Request $request) {
        $trick = new Tricks();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hydrate notre commentaire avec l'article
            $trick->setAuthor($this->getUser());

            // Hydrate notre commentaire avec la date et l'heure courants
            $trick->setCreatedAt(new \DateTime('now'));

            $trick->setModifiedAt(new \DateTime('now'));

            $trick->setSlug('t1');

            $images = $form->get('images')->getData();
            if ($images) {
                foreach ($images as $image) {
                    $file = md5(uniqid()) . '.' . $image->guessExtension();

                    $image->move(
                        $this->getParameter('images_directory'),
                        $file
                    );

                    $img = new Images();
                    $img->setUrl($file);
                    $trick->addImage($img);
                }
            }

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($trick);
            $doctrine->flush();

            return $this->redirectToRoute('tricks');
        }

        return $this->render('tricks/add_trick.html.twig', [
            'title' => 'Figures',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete_trick/{id}", name="delete_trick")
     */
    public function deleteTrick(Tricks $trick) {
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($trick);
        $doctrine->flush();

        return $this->redirectToRoute('tricks');
    }

    /**
     * @Route("/update_trick/{id}", name="update_trick")
     */
    public function updateTrick(Tricks $trick, Request $request) {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setModifiedAt(new \DateTime('now'));

            $doctrine = $this->getDoctrine()->getManager();

            // On hydrate notre instance $commentaire
            $doctrine->persist($trick);

            // On écrit en base de données
            $doctrine->flush();

            // On redirige l'utilisateur
            return $this->redirectToRoute('tricks');
        }

        return $this->render('tricks/update_trick.html.twig', [
            'title' => 'Figures',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{id}", name="trick")
     */
    public function trick($id, Request $request) {
        $trick = $this->getDoctrine()->getRepository(Tricks::class)->findOneBy(['id' => $id]);

        $comments = $this->getDoctrine()->getRepository(Comments::class)->findBy([
            'trick_parent' => $trick,
        ],['created_at' => 'desc']);

        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setTrickParent($trick);
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setAuthor($this->getUser());


            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($comment);
            $doctrine->flush();

            // On redirige l'utilisateur
            return $this->redirectToRoute('trick', ['id' => $id]);
        }

        return $this->render('tricks/trick.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick,
            'comments' => $comments,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Videos;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Entity\Comments;
use Knp\Component\Pager\PaginatorInterface;
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
            $this->addFlash('success', 'Votre figure a bien été ajoutée !');
            // Hydrate notre commentaire avec l'article
            $trick->setAuthor($this->getUser());

            // Hydrate notre commentaire avec la date et l'heure courants
            $trick->setCreatedAt(new \DateTime('now'));

            $trick->setModifiedAt(new \DateTime('now'));

            $trick->setSlug($form->get('nom')->getData());

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

            foreach ($trick->getVideos() as $video) {
                $video->setTrickParent($trick);
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
            $this->addFlash('success', 'Votre figure a bien été modifiée !');
            $trick->setModifiedAt(new \DateTime('now'));

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

            foreach ($trick->getVideos() as $video) {
                $video->setTrickParent($trick);
            }

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($trick);
            $doctrine->flush();

            return $this->redirectToRoute('tricks');
        }

        return $this->render('tricks/update_trick.html.twig', [
            'title' => 'Figures',
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick")
     */
    public function trick($slug, Request $request, PaginatorInterface $paginator) {
        $trick = $this->getDoctrine()->getRepository(Tricks::class)->findOneBy(['slug' => $slug]);

        $donnees = $this->getDoctrine()->getRepository(Comments::class)->findBy([
            'trick_parent' => $trick,
        ],['created_at' => 'desc']);

        $comments = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            10
        );

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
            return $this->redirectToRoute('trick', ['slug' => $slug]);
        }

        return $this->render('tricks/trick.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/delete_image/{id}", name="delete_image")
     */
    public function delete_photo($id) {
        $img = $this->getDoctrine()->getRepository(Images::class)->findOneBy(['id' => $id]);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($img);
        $doctrine->flush();
        return $this->redirectToRoute('update_trick', ['id' => $img->getTrick()->getId()]);
    }

    /**
     * @Route("/delete_video/{id}", name="delete_video")
     */
    public function delete_video($id) {
        $video = $this->getDoctrine()->getRepository(Videos::class)->findOneBy(['id' => $id]);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($video);
        $doctrine->flush();
        return $this->redirectToRoute('update_trick', ['id' => $video->getTrickParent()->getId()]);
    }
}

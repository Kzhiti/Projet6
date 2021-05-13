<?php
namespace App\Controller;

use App\Entity\Tricks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController {

    /**
     * @Route("/")
     */
    public function index() {
        $tricks = $this->getDoctrine()->getRepository(Tricks::class)->findBy([],['created_at' => 'desc']);

        return $this->render('tricks/tricks.html.twig', [
            'tricks' => $tricks,
            'title' => 'Figures',
        ]);
    }
}
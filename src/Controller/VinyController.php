<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Symfony\Component\String\u;

class VinyController extends AbstractController
{
    /**
    * @Route("/")
    */
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        return $this->render('vinyl/homepage.html.twig',[
            'title' => 'Pb & James',
            'tracks' => $tracks,
        ]);
    }

    /**
     * @Route("/browse/{slug}")
     */
    public function browse(string $slug = null): Response
    {

        if ($slug) {
            $titleSinGuion = str_replace('-', ' ', $slug);
            $title = 'Genre:'.u($titleSinGuion)->title(true);
        }else {
            $title = "all Genres";
        }

        return new Response($title);
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/MainController.php',
        // ]);

        //return new Response('<h1>Welcome home</h1>');

        return $this->render('home/index.html.twig');
    }

    /** 
     * @Route("/custom/{name?}/{page?}", name="custom", requirements={"page" = "\d+"}, defaults={"page": 1, "name": "Mohamed"})
     */

    public function custom(Request $request): Response {
        $name = $request->get('name');
        $page = $request->get('page');
        //dump($name);
        //return new Response('<h1>My custom page '. $name .'</h1>');

        return $this->render('home/custom.html.twig', [
            'name' => $name,
            'page' => $page
        ]); 
    }

    /**
     * @Route("/custom/{name?}/{page}", name="custom_page_not_valid")
     */

    public function custom2(Request $request): Response {
        $name = $request->get('name');
        $page = "NOT VALID";
        //dump($name);
        //return new Response('<h1>My custom page '. $name .'</h1>');

        return $this->render('home/custom.html.twig', [
            'name' => $name,
            'page' => $page
        ]);
    }


}

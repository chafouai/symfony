<?php

namespace App\Controller;

use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Post;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post.index")
     */
    public function index(): Response {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }


    /**
     * @Route("post/all", name="post.all")
     * @param PostRepository $postRepository
     * @return Response
     */

    public function all(PostRepository $postRepository): Response {
        $posts = $postRepository->findAll();

        dump($posts);

        return $this->render('post/all.html.twig', [
        	'posts' => $posts
        ]);

    }

    /**
    * @Route("post/show/{id} ", name="post.show")
    */

 	//public function show(Post $post) {
    public function show($id, PostRepository $postRepository): Response  {
    	$post = $postRepository->find($id);
    	//dump($post); die();

    	return $this->render('post/show.html.twig', [
    		'post' => $post
    	]);
    }

    /**
 	* @Route("post/create", name="post.create")
 	*/
    public function create(Request $request): Response {
    	// Create a new post
    	$post = new Post();

    	//$post->setTitle("This is the title");
    	$form = $this->createForm(PostType::class, $post);

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){

            /** @var  UploadedFile $file */
            $file = $request->files->get('post')['image'];
    	    if($file){
    	        $filename = md5(uniqid()). '.'. $file->guessClientExtension();
    	        $file->move($this->getParameter('uploads_dir'), $filename);
    	        $post->setImage($filename);
            }

            // entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Post was created');
            return $this->redirect($this->generateUrl('post.all'));
        }


        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
 	* @Route("post/delete/{id}", name="post.delete")
 	*/
 	//public function remove(Post $post) : Response {
 	public function remove($id, PostRepository $postRepository): Response  {
 		$post = $postRepository->find($id);

 		$em = $this->getDoctrine()->getManager();
 		$em->remove($post);
 		$em->flush();

 		$this->addFlash('success', 'Post was removed');

 		return $this->redirect($this->generateUrl('post.all'));
 	}

    /**
     *
     */
    public function display(){

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: sdumasy
 * Date: 19-03-17
 * Time: 12:03
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentController extends Controller
{
    /**
     * @Route("/comments/{articleId}", name="show_comments")
     * This method querues the comments by article id and renders a twig template, passing two variables
     */
    public function showComment($articleId) {
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findBy([
            'articleId' => $articleId
        ]);

        return $this->render('comments/show.html.twig', [
            'comments' => $comments,
            'articleId' => $articleId
        ]);
    }

    /**
     * @Route("/createComment/{articleId}", name="comment_create")
     * This method creates a form to initialize comment variables and when submit updates the database
     */
    public function createComment($articleId, Request $request) {
        $comment = new Comment;
        $form = $this->createFormBuilder($comment)->add('username', TextType::class, array('attr' => array('style' => 'margin-bottom:15px')))
            ->add('message', TextareaType::class, array('attr' => array('style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=> 'Create comment'))
            ->GetForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $username = $form['username']->getData();
            $message = $form['message']->getData();

            $comment->setUsername($username);
            $comment->setMessage($message);
            $comment->setArticleId($articleId);

            $doc = $this->getDoctrine()->getManager();

            $doc->persist($comment);
            $doc->flush();

            $this->addFlash('notice', 'Comment added');

            return $this->redirectToRoute('show_comments', [
                'articleId'=> $articleId
            ]);

        }

        return $this->render('comments/create.html.twig', array(
            'form' => $form->createView()
        ));

    }
}
<?php

namespace FoodBundle\Controller;

use FoodBundle\Entity\Post;
use FoodBundle\Entity\Transaction;
use FoodBundle\Entity\User;
use MongoDB\BSON\Timestamp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Post controller.
 *
 * @Route("post")
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $order = $request->query->get('order');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if ($order && $direction) {
            $posts = $em->getRepository('FoodBundle:Post')->findAllFilteredOrdered($order, $direction);
        } else {
            $posts = $em->getRepository('FoodBundle:Post')->findAllFilteredOrdered('creationDate', 'ASC');
        }
        return $this->render('post/index.html.twig', array(
            'posts' => $posts,
            'order' => $order,
            'direction' => $direction,
            'user' => $this->getUser(),
        ));
    }


    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {


        $post = new Post();
        $post->setExpiration(new \DateTime());
        $form = $this->createForm('FoodBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Post $post */
            $post = $form->getData();
            $post->setCreationDate();
            $post->setUser($this->getUser());
            if ($post->getPhoto()) {
                $file = $post->getPhoto();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('photo_directory'), $fileName
                );
                $post->setPhoto($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        return $this->render('post/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ));
    }

    /**
     * Search form.
     *
     * @Route("/search/", name="search_form")
     *
     */
    public function searchFormAction(Request $request)
    {
        $posts = null;
        $post = new Post();
        $post->setExpiration(new \DateTime());
        $form = $this->createForm('FoodBundle\Form\SearchType', $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $session = new Session();
            $session->set('post', $post);
            return $this->redirectToRoute('result_form', array());
        }
        return $this->render('post/search.html.twig', array(
            'form' => $form->createView(),
            'user' => $this->getUser(),

        ));
    }

    /**
     * Results.
     *
     * @Route("/result/", name="result_form")
     *
     */
    public function resultFormAction(Request $request)
    {
        $order = $request->query->get('order');
        $direction = $request->query->get('direction');
        $session = new Session();
        $post = $session->get('post');
        $em = $this->getDoctrine()->getManager();
        if ($order && $direction) {
            $posts = $em->getRepository('FoodBundle:Post')->findSearchedOrdered($order, $direction, $post);
        } else {
            $posts = $em->getRepository('FoodBundle:Post')->findSearchedOrdered('creationDate', 'asc', $post);
            $order = 'creationDate';
            $direction = 'asc';
        }
        return $this->render('post/result.html.twig', array(
            'posts' => $posts,
            'order' => $order,
            'direction' => $direction,
            'user' => $this->getUser(),
        ));
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method({"GET","POST"})
     */
    public
    function showAction(Request $request, Post $post)
    {
        $errorMessage = null;
        $message=null;
        if ($request->request->get('action') === "reserve") {
            if ($post->getPortions() > 0) {

                $user = $this->getUser();
                $userUsername = $user->getUsername();
                $userPhoneNumber = $user->getPhoneNumber();
                $userEmail = $user->getEmail();
                $postUser = $post->getUser();
                $postUserUsername = $post->getUser()->getUsername();
                $postUserEmail = $post->getUser()->getEmail();
                $postTitle = $post->getTitle();
                $postUserPhoneNumber = $postUser->getPhoneNumber();
                $postUserAddress = $postUser->getAddress();

                if ($postUser != $user) {
                    $reservationQty = $request->request -> get('reservationQty');
                    $message = "Zarezerwowałeś następną ilość porcji: $reservationQty";
                    $post->setPortions($post->getPortions() - $reservationQty);
                    $transaction = new Transaction();
                    $transaction->setUser($user);
                    $transaction->setPosts([$post]);
                    $transaction->setPortions(1);
                    $transaction->setOrderDate();
                    $transaction->setRating(0);
                    $transaction->setPortions($reservationQty);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($post);
                    $em->persist($transaction);
                    $em->flush();
                    $emailToPostUser = \Swift_Message::newInstance()
                        ->setSubject('Wiadomość od aplikacji FoodSharer')
                        ->setFrom('sowietyszyn@tlen.pl')
                        ->setTo($postUserEmail)
                        ->setBody("
                        <html>
                        <body>
                        <h2>Witaj $postUserUsername,</h2>
                        <br>
                        Użytkownik: <b>$userUsername</b>, właśnie zarezerwował jedna porcję Twojej potrawy o nazwie<b> $postTitle.</b><br>
                                              <br>
                                              Jeśli chcesz się z nim skontaktować to jego numer telefonu: <b>$userPhoneNumber</b>
                                              <br>
                                              <br>
                                              Pozdrawiamy,<br>
                                              Ekipa FoodSharer<br>
                      
                            
                            
                            </body>
                            </html>
                            ", 'text/html');
                    $emailToUser = \Swift_Message::newInstance()
                        ->setSubject('Wiadomość od aplikacji FoodSharer')
                        ->setFrom('sowietyszyn@tlen.pl')
                        ->setTo($userEmail)
                        ->setBody("
                        <html>
                        <body>
                        <h2>Witaj $userUsername,</h2>
                        <br>
                        Właśnie zarezerwowałeś jedna porcję potrawy użytkownika <b>$postUserUsername</b> o nazwie<b> $postTitle.</b><br>
                                              <br>
                                              Jeśli chcesz się z nim skontaktować: <br>
                                              Numer telefonu: <b>$postUserPhoneNumber</b><br>
                                              Adres: <b>$postUserAddress</b>
                                              <br>
                                              <br>
                                              Pozdrawiamy,<br>
                                              Ekipa FoodSharer<br>
                      
                            
                            
                            </body>
                            </html>
                            ", 'text/html');

                    $this->get('mailer')->send($emailToPostUser);
                    $this->get('mailer')->send($emailToUser);
                } else {
                    $errorMessage = 'Nie możesz rezerwować własnych posiłków';
                }
            }
        }
        $deleteForm = $this->createDeleteForm($post);

        return $this->render('post/show.html.twig', array(
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'errorMessage' => $errorMessage,
            'message' =>$message
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="post_edit")
     * @Method({"GET", "POST"})
     */
    public
    function editAction(Request $request, Post $post)
    {
        if ($this->getUser() !== $post->getUser()) {
            throw $this->createAccessDeniedException('Brak dostępu');
        }


        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('FoodBundle\Form\EditPostType', $post);
        $temporaryPhoto = $post->getPhoto();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if ($post->getPhoto()) {
                $file = $post->getPhoto();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('photo_directory'), $fileName
                );
                $post->setPhoto($fileName);
            } else {
                $post->setPhoto($temporaryPhoto);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', array('id' => $post->getId()));
        }

        return $this->render('post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public
    function deleteAction(Request $request, Post $post)
    {
        if ($this->getUser() !== $post->getUser()) {
            throw $this->createAccessDeniedException('Brak dostępu');
        }
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private
    function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Show one user posts.
     *
     * @Route("/{userId}/all/", name="show_user_posts")
     * @Method("GET")
     *
     */
    public
    function showUserPostsAction(Request $request, $userId)
    {
        $order = $request->query->get('order');
        $direction = $request->query->get('direction');

        $em = $this->getDoctrine()->getManager();
        if ($order && $direction) {
            $posts = $em->getRepository('FoodBundle:Post')->findBy(['user' => $userId], [$order => $direction]);
        } else {
            $posts = $em->getRepository('FoodBundle:Post')->findBy(['user' => $userId], ['creationDate' => 'DESC']);
        }
        return $this->render('post/showUserPost.html.twig', array(
            'posts' => $posts,
            'order' => $order,
            'direction' => $direction,
            'user' => $this->getUser(),

        ));
    }


}

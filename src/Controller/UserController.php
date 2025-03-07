<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Form\UserType;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use App\Controller\SecurityController;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * @param UserRepository $repository
     * @return Response
     * @route("/AfficherUsers", name="AfficherUsers")
     */
    public function AfficherUsers(UserRepository $repository){

        if($this->getUser()->isAdmin())
        {
            $users=$repository->findAll();
            return $this->render('user/afficher.html.twig',
                ['users'=>$users, 'user' => $this->getUser()->getUsername() ]);
        }

        return $this->redirectToRoute('app_login');

    }

    /**
     * @param UserRepository $repository
     * @return Response
     * @route("/ProfilBack/{id}", name="ProfilBack")
     */
    public function ProfilBack($id, UserRepository $repository){

        if($this->getUser()->isAdmin())
        {
            $profil=$repository->find($id);
            return $this->render('user/profilBack.html.twig',
                ['profil'=>$profil, 'user' => $this->getUser()->getUsername() ]);
        }

        return $this->redirectToRoute('app_login');

    }

    /**
     * @route("/SupprimerUser/{id}",name="SupprimerUser")
     */
    function SupprimerUser($id,UserRepository $repository){

        if($this->getUser()->isAdmin())
        {
            $user=$repository->find($id);
            $em=$this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('AfficherUsers');
        }

        return $this->redirectToRoute('app_login');

    }

    /**
     * @param Request $request
     * @return Response
     * @route("/AjouterUser", name="AjouterUser")
     */
    function AjouterUser(Request $request, UserPasswordEncoderInterface $encoder){

        if($this->getUser()->isAdmin())
        {
            $user = new User();
            $form=$this->createForm(UserType::class,$user);
            $form->add('Ajouter',SubmitType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setToken(null);
                $user->setEnabled(true);
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return  $this->redirectToRoute('AfficherUsers');
            }
            return $this->render('user/ajouter.html.twig',[
                'form'=>$form->createView(), 'user' => $this->getUser()->getUsername()
            ]);

        }

        return $this->redirectToRoute('app_login');


    }

    /**
     * @route ("ModifierUser/{id}",name="ModifierUser")
     */
    function ModifierUser(UserRepository  $repository, $id, Request $request, UserPasswordEncoderInterface $encoder){

        if($this->getUser()->isAdmin())
        {
            $user=$repository->find($id);
            $form=$this->createForm(UserType::class, $user);
            $form->add('Modifier',SubmitType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $em=$this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirectToRoute("AfficherUsers");
            }
            return $this->render('user/modifier.html.twig',[
                'form'=>$form->createView(), 'user' => $this->getUser()->getUsername()
            ]);
        }

        return $this->redirectToRoute('app_login');

    }

    /**
     * @Route("/DownloadUsersData", name="DownloadUsersData")
     */
    public function DownloadUsersData(UserRepository $repository)
    {
        $users=$repository->findAll();

        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('user/download.html.twig',
            ['users'=>$users ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'Tableau des Utilisateurs.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }



    //---------------------------------------------------------------------------------------------------

    /**
     * @param Request $request
     * @return Response
     * @route("/inscrire", name="inscrire")
     */
    function Inscrire(Request $request, UserPasswordEncoderInterface $encoder){

        $user = new User();
        $form=$this->createForm(UserRegisterType::class,$user);
        $form->add("inscrire",SubmitType::class, [
            'attr'=>[
                'class'=>'btn btn-red'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setToken($this->generateToken());
            $user->setRoles(['ROLE_USER']);
            $user->setEnabled(false);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->mailer->sendEmail($user->getEmail(), $user->getToken());
            $this->addFlash("success", "Inscription réussie! Merci de confirmer votre compte");
            return  $this->redirectToRoute('app_login');
        }
        return $this->render('user/inscrire.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * @Route("/ConfirmerCompte/{token}", name="ConfirmerCompte")
     */
    public function confirmerCompte(string $token, UserRepository $repository)
    {
        $user = $repository->findOneBy(["token" => $token]);

        if($user) {
            $user->setToken(null);
            $user->setEnabled(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Compte actif!");
            return $this->redirectToRoute("app_login");
        }

        return $this->redirectToRoute('inscrire');

    }

    /**
     * @param UserRepository $repository
     * @return Response
     * @route("/Profil", name="Profil")
     */
    public function Profil(UserRepository $repository){
        $profil=$repository->find($this->getUser()->getId());
        return $this->render('user/profilFront.html.twig',[
            'profil'=>$profil
        ]);
    }

    /**
     * @route ("ModifierProfil/{id}",name="ModifierProfil")
     */
    function ModifierProfil(UserRepository  $repository, $id, Request $request, UserPasswordEncoderInterface $encoder){

        $user=$repository->find($id);
        $form=$this->createForm(UserRegisterType::class, $user);
        $form->add("modifier",SubmitType::class, [
            'attr'=>[
                'class'=>'btn btn-red'
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherUsers");
        }
        return $this->render('user/modifierProfil.html.twig',[
            'form'=>$form->createView(), 'user' => $this->getUser()->getUsername()
        ]);
    }




}

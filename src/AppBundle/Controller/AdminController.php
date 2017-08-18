<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Groups;
use AppBundle\Entity\User;
use AppBundle\Form\GroupForm;
use AppBundle\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function addUserAction(Request $request){
        $form = $this->createForm(UserForm::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();


            $this->addFlash('success','Page Added!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('addUser.html.twig',[
            'user' => $form->createView()
        ]);
    }

    public function listUserAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')
            ->findAll();

        return $this->render('listUser.html.twig',[
            'users' => $users
        ]);
    }

    public function deleteUserAction($id){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')
            ->findOneBy(['id'=>$id]);

        $em->remove($users);
        $em->flush();

        return $this->redirectToRoute('listUser');
    }

    public function addGroupAction(Request $request){
        $form = $this->createForm(GroupForm::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();


            $this->addFlash('success','Page Added!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('addGroup.html.twig',[
            'group' => $form->createView()
        ]);
    }

    public function listGroupAction(){
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:Groups')
            ->findAll();

        return $this->render('listGroup.html.twig',[
            'groups' => $groups,
        ]);
    }

    public function deleteGroupAction($id){
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:Groups')
            ->findOneBy(['id'=>$id]);

        $em->remove($groups);
        $em->flush();

        return $this->render('listGroup.html.twig',[
            'groups' => $groups,
        ]);
    }

    public function editGroupAction(Request $request, Groups $groups){

        $form = $this->createForm(GroupForm::class, $groups);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Page Added!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('addGroup.html.twig',[
            'group' => $form->createView()
        ]);
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Groups;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    public function listUserApiAction(){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')
            ->findAll();

        if($users!=null){
            foreach ($users as $user){
                $usersList[] = [
                    ['id' => $user->getId(), 'name'=> $user->getName()]
                ];
            }

            $data = [
                'notes' => $usersList
            ];

            return new JsonResponse($data);
        }
        return new JsonResponse('No users found!');
    }

    public function listGroupApiAction(){
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:Groups')
            ->findAll();

        if($groups!=null){
            foreach ($groups as $group){
                $groupsList[] = [
                    ['id' => $group->getId(), 'name' => $group->getGroupName()]
                ];
            }

            $data = [
                'notes' => $groupsList
            ];

            return new JsonResponse($data);
        }
        return new JsonResponse('No groups found!');
    }

    public function AddUserApiAction(){
          $user = new User();
          $name = $_GET['name'];
          $em = $this->getDoctrine()->getManager();
          $user->setName($name);
          $em->persist($user);
          $em->flush();
          return $this->redirectToRoute('listUserapi');
    }

    public function DeleteUserApiAction(){
        $id =  $_GET['id'];
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')
            ->findOneBy(['id'=>$id]);
        $em->remove($users);
        $em->flush();
        return $this->redirectToRoute('listUserapi');
    }

    public function AddGroupApiAction(){
        $group = new Groups();
        $name = $_GET['name'];
        $em = $this->getDoctrine()->getManager();
        $group->setGroupName($name);
        $em->persist($group);
        $em->flush();
        return $this->redirectToRoute('listGroupapi');
    }

    public function DeleteGroupApiAction(){
        $id =  $_GET['id'];
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Groups')
            ->findOneBy(['id'=>$id]);
        $em->remove($group);
        $em->flush();
        return $this->redirectToRoute('listGroupapi');
    }
}
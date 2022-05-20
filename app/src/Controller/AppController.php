<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(EntityManagerInterface  $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();
        $roles = $em->getRepository(Role::class)->findAll();

        return $this->render('app/index.html.twig', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * @Route("/user", name="get_user_info")
     */
    public function getUserInfo(Request $request, EntityManagerInterface  $em, SerializerInterface $serializer): Response
    {
        $userId = $request->get('id');
        $user = $em->getRepository(User::class)->find($userId);
        $roles = array_map(function ($r){
            return $r->getLibelle();
        }, $user->getRoles()->toArray());
        $rolesId = array_map(function ($r){
            return $r->getId();
        }, $user->getRoles()->toArray());
        $rolesConcat = join(', ', $roles);
        
        $response = new Response($serializer->serialize([
            'username' => $user->getFirstName() . ' ' . $user->getLastName(),
            'job' => $user->getJob(),
            'rolesConcat' => $rolesConcat,
            'selectedRolesId' => $rolesId,
        ], 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/save", name="save_user_roles")
     */
    public function saveUserRoles(Request $request, EntityManagerInterface  $em, SerializerInterface $serializer): Response
    {
        $userId = $request->get('id');
        $user = $em->getRepository(User::class)->find($userId);
        
        $newRolesIds = $request->get('roles');

        foreach ($user->getRoles() as $userRole) {
            $user->removeRole($userRole);
        }

        if($newRolesIds != null && !empty($newRolesIds))
        {
            foreach ($newRolesIds as $newRoleId) {
                $newRole = $em->getRepository(Role::class)->find($newRoleId);
                $user->addRole($newRole);
            }      
        }

        $em->flush();
      
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

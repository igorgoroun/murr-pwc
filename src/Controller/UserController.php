<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FilterUserType;
use App\Form\UserProfileType;
use App\Form\UserRegistrationType;
use App\Form\UserType;
use Curl\Curl;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function profile(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = $profile = $this->getUser();

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($form->getData()->getPlainPassword() != null) {
                $user->setPassword($encoder->encodePassword($user, $form->getData()->getPlainPassword()));
            }
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "Profile updated.");
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/modify/{id}", name="user_modify", requirements={"id"="\d+"})
     */
    public function modify(User $user, Request $request, UserPasswordEncoderInterface $encoder) {
        if (!$user) {
            return $this->redirectToRoute('user_list');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($form->getData()->getPlainPassword() != null) {
                $user->setPassword($encoder->encodePassword($user, $form->getData()->getPlainPassword()));
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/modify.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/list", name="user_list")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listUsers(Request $request, PaginatorInterface $paginator) {
        $rep = $this->getDoctrine()->getRepository('App:User');
        $form = $this->createForm(FilterUserType::class);
        $form->handleRequest($request);

        $role = false;
        $excluded = 0;
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('showGuests')->isClicked()) {
                $role = 'ROLE_GUEST';
            } elseif ($form->get('showMembers')->isClicked()) {
                $role = 'ROLE_USER';
            } elseif ($form->get('showOfficers')->isClicked()) {
                $role = 'ROLE_CAPTAIN';
            } elseif ($form->get('showExcluded')->isClicked()) {
                $role = 'ROLE_GUEST';
                $excluded = 1;
            }
        }

        $users = $rep->findPaginated($role, $excluded);

        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('user/list.html.twig', [
            'users' => $users,
            'filter' => $form->createView(),
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/signup", name="user_signup")
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid() && $this->checkReCaptcha($request)) {
                $em = $this->getDoctrine()->getManager();
                $group = $em->getRepository('App:UserGroup')->findOneBy(['role'=>'ROLE_GUEST']);
                $user->setUserRole($group);
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
                try {
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success', 'Аккаунт зарегистрирован. Используйте свои данные для входа на сайт.');
                    return $this->redirectToRoute('app_login');
                } catch (UniqueConstraintViolationException $e) {
                    $this->addFlash('danger', "Данный e-mail уже был зарегистрирован ранее!");
                    return $this->redirectToRoute('user_signup');
                }
            }
        }

        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function checkReCaptcha(Request $request) {
        try {
            $curl = new Curl();
            $curl->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->getParameter('recaptcha_secret_key'),
                'response' => $request->request->get('g-recaptcha-response')
            ]);
            if ($curl->error) throw new \Exception("Curl error!");
            if ($curl->response) {
                $response = json_decode($curl->response);
                if ($response->success) {
                    return true;
                } else throw new \Exception("Captcha was not verified!");
            }
        } catch (\Exception $e) {
            $this->addFlash("danger", "Invalid security check: ".$e->getMessage());
            return false;
        }
    }

}

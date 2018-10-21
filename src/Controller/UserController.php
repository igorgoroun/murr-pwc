<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use Curl\Curl;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/signup", name="user_signup")
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid() /*&& $this->checkReCaptcha($request)*/) {
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


    /**
     * @Route("/profile", name="user_profile")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
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

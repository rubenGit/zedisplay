<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\Security\UserRegistrationFormType;
use App\Services\Security\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Controller used to manage the application security.
 * See https://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends AbstractController
{
    use TargetPathTrait;

    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, Security $security, AuthenticationUtils $helper, SecurityService $securityService): Response
    {

        // this statement solves an edge-case: if you change the locale in the login
        // page, after a successful login you are redirected to a page in the previous
        // locale. This code regenerates the referrer URL whenever the login page is
        // browsed, to ensure that its locale is always the current one.
        $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('dashboard'));

        return $this->render('security/login.html.twig', [
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
    /**
     * @Route("/register", name="security_register")
     */
    public function register(Request $request, SecurityService $securityService)
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        $existCredentialsInDb = false;

        if ($form->isSubmitted() && $form->isValid()) {

            $existCredentialsInDb = $securityService->ifNotExistPersist(
                $form->getData()['nameClient'],
                $form->getData()['companyName'],
                $form->getData()['address'],
                $form->getData()['city'],
                $form->getData()['postalCode'],
                $form->getData()['contactPersonPhone'],
                $form->getData()['email'],
                $form->getData()['username'],
                $form->getData()['plainPassword']
            );


            if (!$existCredentialsInDb) {
                return $this->redirectToRoute('security_login');
            } else if ($existCredentialsInDb == true) {
                $existCredentialsInDb = "This user already exists try another username and email";
            }

        }


        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'error' => ($existCredentialsInDb) ? $existCredentialsInDb : false
        ]);
    }

}

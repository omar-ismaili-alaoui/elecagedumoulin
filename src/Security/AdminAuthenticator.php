<?php
/**
 * Created by PhpStorm.
 * User: ramani_t
 * Date: 20/03/2018
 * Time: 14:32
 */

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class AdminAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;
    private $router;
    private $flashBag;
    private $entityManager;

    public function __construct(UserRepository $userRepository, RouterInterface $router, FlashBagInterface $flashBag, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->entityManager = $entityManager;
    }

    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate("admin_login");
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        $isLoginSubmit = $request->request->has("is_login_action") && $request->isMethod('POST');
        if (!$isLoginSubmit) {
            // skip authentication
            return false;
        }
        return true;
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     * @throws \UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
        return [
            'username' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $email = $credentials["email"];

        $user = $this->userRepository->findOneBy(["email" => $email]);

        if ($user == null) {
            $this->flashBag->set("danger", "Mauvais combo Email/Mot de passe");
        }
        return $user;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $nonCryptedPassword = $credentials["password"];
        if (password_verify($nonCryptedPassword, $user->getPassword())) {
            if ($user->getUserActive() == 2) {
                $this->flashBag->set("danger", "Veuillez cliquer sur le lien de confirmation pour activer votre compte");
                return false;
            }
            elseif ($user->getUserActive() == 1) {
                return true;
            }
            else {
                $this->flashBag->set("danger", "Votre compte a été désactivé par un modérateur");
                return false;
            }
        }
        else {
            //if old legacy  PDM account
            $simpleMd5PasswordToCheck = md5($nonCryptedPassword);
            if ($user->getUserPass() == $simpleMd5PasswordToCheck) {
                $user->setUserPass(password_hash($nonCryptedPassword, PASSWORD_DEFAULT));
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                if ($user->getUserActive() == 2) {
                    $this->flashBag->set("danger", "Veuillez cliquer sur le lien de confirmation pour activer votre compte");
                    return false;
                }
                elseif ($user->getUserActive() == 1) {
                    return true;
                }
                else {
                    $this->flashBag->set("danger", "Votre compte a été désactivé par un modérateur");
                    return false;
                }
            }
            else {
                //if old legacy ADM account
                //we try the legacy authantication and then update the password with the new method then return true if it succeeds
                $passwordToCheck = md5(addslashes("Cq38R31VLjoPMyPId3giOJicWfAMR0O93wWuyc3Nzk98HW8atwSsqDOH").$nonCryptedPassword);
                if ($passwordToCheck === $user->getUserPass()) {
                    $user->setUserPass(password_hash($nonCryptedPassword, PASSWORD_DEFAULT));
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    if ($user->getUserActive() == 2) {
                        $this->flashBag->set("danger", "Veuillez cliquer sur le lien de confirmation pour activer votre compte");
                        return false;
                    }
                    elseif ($user->getUserActive() == 1) {
                        return true;
                    }
                    else {
                        $this->flashBag->set("danger", "Votre compte a été désactivé par un modérateur");
                        return false;
                    }
                }
            }
        }
        $this->flashBag->set("danger", "Mauvais combo Email/Mot de passe");
        return false;
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
/*        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if (!$targetPath) {
            $targetPath = $this->router->generate('homepage');
        }*/
        return new RedirectResponse($this->router->generate('pdm_admin_homepage'));
    }
}
<?php declare(strict_types=1);
namespace App\Security;

use App\Controller\ProfileController;
use App\Entity\User;
use App\Repository\LogintokenRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class LogintokenAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly UrlGeneratorInterface $router,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly LogintokenRepository  $logintokenRepository,
    ) { }

    /** Called on every request to decide if this authenticator should be used for the request. Returning `false` will cause this authenticator to be skipped. */
    public function supports(Request $request): ?bool
    {
        return 'token' === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): Passport
    {
        /** @var string $token */
        $token = $request->attributes->get('token');

        /* Switch between:
        http://test.symfony-test-env-issue.localhost/t/foo@example.com
             http://symfony-test-env-issue.localhost/t/foo@example.com
        AND
        http://test.symfony-test-env-issue.localhost/t/123
             http://symfony-test-env-issue.localhost/t/123
        */
        if (str_contains($token, '@')) {
            $userBadge = new UserBadge($token);
        } else {
            $userBadge = new UserBadge($token, function(string $token): ?User {
                return $this->logintokenRepository->findUserFromLogintoken($token);
            });
        }

        return new SelfValidatingPassport($userBadge, []);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?RedirectResponse
    {
        return new RedirectResponse($this->router->generate(ProfileController::class), Response::HTTP_SEE_OTHER);
    }

    /**
     * @return RedirectResponse (Statuscode 303)
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        dd('onAuthenticationFailure');
    }
}

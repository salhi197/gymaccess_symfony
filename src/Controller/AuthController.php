<?php
// src/Controller/AuthController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get any login error if there are any
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/register", name="app_register", methods={"GET", "POST"})
     */
// In AuthController's register method
public function register(Request $request): Response
{
    if ($request->isMethod('POST')) {
        $email = $request->request->get('email');
        $passwordText = $request->request->get('password');
        $grade = (int) $request->request->get('grade');
        $photo = $request->files->get('photo');  // Handle file upload if needed

        // Validation (simple example)
        if (empty($email) || empty($passwordText)) {
            $this->addFlash('error', 'Email and password are required.');
            return $this->redirectToRoute('app_register');
        }

        // Check if the user already exists
        $userRepository = $this->entityManager->getRepository(User::class);
        if ($userRepository->findOneBy(['email' => $email])) {
            $this->addFlash('error', 'Email already in use.');
            return $this->redirectToRoute('app_register');
        }

        // Create and save the user
        $user = new User();
        $user->setEmail($email);
        $user->setPasswordText($passwordText);  // Store the plaintext password temporarily
        $hashedPassword = $this->passwordHasher->hashPassword($user, $passwordText);
        $user->setPassword($hashedPassword);
        $user->setGrade($grade);

        // Handle photo upload (store file, return file path)
        if ($photo) {
            $photoPath = $photo->move(
                $this->getParameter('photos_directory'), // Define in services.yaml
                uniqid().'.'.$photo->guessExtension()
            );
            $user->setPhoto($photoPath->getPathname());
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'Registration successful. Please log in.');
        return $this->redirectToRoute('app_login');
    }

    return $this->render('auth/register.html.twig');
}

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

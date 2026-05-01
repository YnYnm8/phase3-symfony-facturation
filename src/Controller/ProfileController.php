<?php
namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser(); // ← ログイン中のUserを取得 ✅

        $form = $this->createForm(ProfileType::class, $user); // ← ProfileTypeを使う ✅
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // ← persistは不要（既存Userの更新なので）✅
            $this->addFlash('success', 'Profil mis à jour !');
            return $this->redirectToRoute('app_profile'); // ← typo修正 ✅
        }

        return $this->render('profile/index.html.twig', [
            'profileForm' => $form, // ← フォームを渡す ✅
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Form\GiftType;
use App\Repository\GiftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Entity\Wish;
/**
 * @Route("/gift")
 */
class GiftController extends AbstractController
{
    /**
     * @Route("/wish/{wish}", name="gift_index", methods={"GET"})
     */
    public function index(GiftRepository $giftRepository, Wish $wish): Response
    {
        $this->wishAcl($wish);
        return $this->render('gift/index.html.twig', [
            'gifts' => $giftRepository->findBy(['wish' => $wish]),
            'wish' => $wish,
        ]);
    }

    /**
     * @Route("/new/wish/{wish}", name="gift_new", methods={"GET","POST"})
     */
    public function new(Request $request, Wish $wish): Response
    {
        $this->wishAcl($wish);
        $gift = new Gift();
        $form = $this->createForm(GiftType::class, $gift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gift);
            $entityManager->flush();

            return $this->redirectToRoute('gift_index');
        }

        return $this->render('gift/new.html.twig', [
            'gift' => $gift,
            'wish' => $wish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gift_show", methods={"GET"})
     */
    public function show(Gift $gift): Response
    {
        $this->acl($gift);
        return $this->render('gift/show.html.twig', [
            'gift' => $gift,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gift_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Gift $gift): Response
    {
        $this->acl($gift);
        $form = $this->createForm(GiftType::class, $gift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gift_index');
        }

        return $this->render('gift/edit.html.twig', [
            'gift' => $gift,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gift_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gift $gift): Response
    {
        $this->acl($gift);
        if ($this->isCsrfTokenValid('delete'.$gift->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gift);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gift_index');
    }

    /**
     * verify that gift is to authenticated user
     *
     * @param Wish $wish
     * @throws AccessDeniedHttpException
     */
    protected function acl(Gift $gift)
    {
        if($gift->getWish()->getUser() != $this->getUser()) {
            throw new AccessDeniedHttpException('this gift is not your gift!');
        }
    }

    /**
     * verify that wish is to authenticated user
     *
     * @param Wish $wish
     * @throws AccessDeniedHttpException
     */
    protected function wishAcl(Wish $wish)
    {
        if($wish->getUser() != $this->getUser()) {
            throw new AccessDeniedHttpException('this wish is not your wish!');
        }
    }
}

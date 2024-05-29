<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use App\Dice\Dice;
use App\Dice\DiceGraphic;
use App\Dice\DiceHand;
use App\Dice\DiceGame;

/**
 * Controller for the game Pig.
 */
class DiceGameController extends AbstractController
{
    /**
     * Route for the home page of the game.
     * @return Response Going to the home page of the game.
     */
    #[Route("/game/pig", name: "pig_start")]
    public function home(): Response
    {
        return $this->render('pig/home.html.twig');
    }

    /**
     * Route for the test page of the game.
     * @return Response Going to the test page of the game.
     */
    #[Route("/game/pig/test/roll", name: "test_roll_dice")]
    public function testRollDice(): Response
    {
        $die = new DiceGraphic();

        $data = [
            "dice" => $die->roll(),
            "diceString" => $die->getAsString(),
        ];

        return $this->render('pig/test/roll.html.twig', $data);
    }

    /**
     * Route for the test page of the game.
     * @param int $num The number of dices to roll.
     * @return Response Going to the test page of the game.
     */
    #[Route("/game/pig/test/roll/{num<\d+>}", name: "test_roll_num_dices")]
    public function testRollDices(int $num): Response
    {
        if ($num > 99) {
            throw new Exception("Can not roll more than 99 dices!");
        }
        $game = new DiceGame();
        $hand = $game->createHand($num);
        $hand->roll();
        $diceRoll = $hand->getString();

        $data = [
            "num_dices" => count($diceRoll),
            "diceRoll" => $diceRoll,
        ];

        return $this->render('pig/test/roll_many.html.twig', $data);
    }

    /**
     * Route for the test page of the game.
     * @param int $num The number of dices to roll.
     * @return Response Going to the test page of the game.
     */
    #[Route("/game/pig/test/dicehand/{num<\d+>}", name: "test_dicehand")]
    public function testDiceHand(int $num): Response
    {
        if ($num > 99) {
            throw new Exception("Can not roll more than 99 dices!");
        }

        $game = new DiceGame();
        $hand = $game->createHandTest($num);
        $hand->roll();

        $data = [
            "num_dices" => $hand->getNumberDices(),
            "diceRoll" => $hand->getString(),
        ];

        return $this->render('pig/test/dicehand.html.twig', $data);
    }

    /**
     * Route to init the game.
     * @return Response Going to the init page of the game.
     */
    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }
    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $numDice = $request->request->get('num_dices');
        $game = new DiceGame();
        $game->sessionInit($session, (int)$numDice);

        return $this->redirectToRoute('pig_play');
    }

    /**
     * Route to play the game.
     * @param SessionInterface $session The session to setup the game.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {
        $dicehand = $session->get("pig_dicehand");
        if (!$dicehand instanceof DiceHand) {
            return $this->redirectToRoute('pig_init_get');
        }
        $data = [
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString()
        ];

        return $this->render('pig/play.html.twig', $data);
    }

    /**
     * Route to roll the dice in the hand.
     * @param SessionInterface $session The session to play the game.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response {
        $hand = $session->get("pig_dicehand");
        if (!$hand instanceof DiceHand) {
            return $this->redirectToRoute('pig_init_get');
        }

        $hand->roll();

        $roundTotal = $session->get("pig_round");
        $game = new DiceGame();
        $round = $game->calculateRoundScore($hand, $roundTotal);

        $session->set("pig_round", $roundTotal + $round);

        return $this->redirectToRoute('pig_play');
    }

    /**
     * Route to save the round points to the total points.
     * @param SessionInterface $session The session to play the game.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        $session->set("pig_round", 0);
        $session->set("pig_total", $roundTotal + $gameTotal);


        return $this->redirectToRoute('pig_play');
    }
}

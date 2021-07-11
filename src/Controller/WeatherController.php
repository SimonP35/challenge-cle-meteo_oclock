<?php 

namespace App\Controller;

use App\Model\WeatherModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController 
{
    /**
     * Fonction permettant l'affichage de la page "home"
     * @Route("/", name="home")
     * @return void
     */
    public function home(): Response
    {
        // On récupère nos météos
        $weathersModel = new WeatherModel();
        $weathers = $weathersModel->getWeatherData();
        dump($weathers);

        return $this->render('weather/home.html.twig', [
            'weathers' => $weathers,
        ]);
    }
}
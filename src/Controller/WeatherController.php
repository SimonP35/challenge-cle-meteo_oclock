<?php 

namespace App\Controller;

use App\Model\WeatherModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController 
{
    /**
     * Fonction permettant l'affichage de la page "home"
     * 
     * @Route("/", name="home")
     * @param SessionInterface $session
     * @return Response
     */
    public function home(SessionInterface $session): Response
    {
        // On récupère nos météos
        $weathers = WeatherModel::getWeatherData();
        // dump($weathers);

        $widget = $session->get('widget');
        // dd($widget);

        // $widget != null ? $weatherInWidget = WeatherModel::getWeatherByCityIndex($widget['id']) : $weatherInWidget = $widget;

        $widget === null ? : $weatherInWidget = WeatherModel::getWeatherByCityIndex($widget['id']);
        $widget != null ? : $weatherInWidget = $widget;
        $weatherInWidget != null ? : $this->addFlash('primary', 'Astuce : Vous pouvez séléctionner une météo favorite en cliquant sur le nom d\'une ville dans la liste sur la page d\'accueil :) !');
        
        return $this->render('weather/home.html.twig', [
            'weathers' => $weathers,
            'weatherInWidget' => $weatherInWidget,
        ]);
    }

    /**
     * Fonction permettant l'affichage de la page "moutain"
     * 
     * @Route("/mountain", name="mountain")
     * @param SessionInterface $session
     * @return Response
     */
    public function mountain(SessionInterface $session): Response
    {
        $widget = $session->get('widget');
        // dump($widget);

        // $widget != null ? $weatherInWidget = WeatherModel::getWeatherByCityIndex($widget['id']) : $weatherInWidget = $widget;

        $widget === null ? : $weatherInWidget = WeatherModel::getWeatherByCityIndex($widget['id']);
        $widget != null ? : $weatherInWidget = $widget;
        $weatherInWidget != null ? : $this->addFlash('primary', 'Astuce : Vous pouvez séléctionner une météo favorite en cliquant sur le nom d\'une ville dans la liste sur la page d\'accueil :) !');
       
        return $this->render('weather/mountain.html.twig', [
            'weatherInWidget' => $weatherInWidget,
        ]);
    }

    /**
     * Fonction permettant l'affichage de la page "beaches"
     * 
     * @Route("/beaches", name="beaches")
     * @param SessionInterface $session
     * @return Response
     */
    public function beaches(SessionInterface $session): Response
    {
        $widget = $session->get('widget');
        // dump($widget);

        // $widget != null ? $weatherInWidget = WeatherModel::getWeatherByCityIndex($widget['id']) : $weatherInWidget = $widget;

        $widget === null ? : $weatherInWidget = WeatherModel::getWeatherByCityIndex($widget['id']);
        $widget != null ? : $weatherInWidget = $widget;
        $weatherInWidget != null ? : $this->addFlash('primary', 'Astuce : Vous pouvez séléctionner une météo favorite en cliquant sur le nom d\'une ville dans la liste sur la page d\'accueil :) !');

        return $this->render('weather/beaches.html.twig', [
            'weatherInWidget' => $weatherInWidget,
        ]);
    }

}
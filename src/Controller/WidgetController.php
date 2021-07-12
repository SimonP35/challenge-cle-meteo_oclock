<?php 

namespace App\Controller;

use App\Model\WeatherModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WidgetController extends AbstractController 
{
    /**
     * Fonction permettant de sélectionner une météo à mettre dans le widget
     * // @Route("/widget", name="widget", methods="POST") //? Méthode POST
     * @Route("/widget/{id}", name="widget", methods="GET") //? Méthode GET
     * @param SessionInterface $session
     * @param Request $Request
     * @return Response
     */
    public function widget(int $id, SessionInterface $session, Request $request): Response
    {
        //? Méthode POST
        // On récupère notre id se dans $_POST['id']
        // $id = $request->request->get('id');

        //? Méthode GET
        // On récupère la météo concernée
        $weather = WeatherModel::getWeatherByCityIndex($id);

        // Erreur 404
        if ($weather === null) {
            throw $this->createNotFoundException('La météo demandée n\'existe pas !');
        }

        $widget = $session->get('widget', []); // $widget = $_SESSION['widget'];

        if ( !array_key_exists($id, $widget) ) {

            $weatherInWidget = [
                'weather' => $weather, 
                'id' => $id,
            ];

            // On ajoute la weather et son id dans le widget
            $widget = $weatherInWidget;
        }
        else {
            $widget = $widget;
        }

        // On remet le nouveau widget dans la session
        $session->set('widget', $widget);
        // On ajoute un Flash Message
        $this->addFlash('success', '🌣🌣🌣 Votre nouvelle météo favorite est celle de '.$widget['weather']['city'].' ! 🌣🌣🌣');
     
        // On redirige
        return $this->redirectToRoute('home');
    }

    /**
     * Fonction permettant l'effacement de la session en cours
     *
     * @Route("/logout", name="logout")
     * @param SessionInterface $session
     * @param Request $Request
     * @return Response
     */
    public function logout(Request $request, SessionInterface $session): Response
    {
        $widget = $session->get('widget', []);

        empty($widget) ?
        $this->addFlash('danger', '🌣🌣🌣 Il n\'y a aucune session en cours ! 🌣🌣🌣') : 
        $session->remove('widget') && 
        $this->addFlash('danger', '🌣🌣🌣 Vous avez fermé la session, vous n\'avez plus de météo favorite ! 🌣🌣🌣');

        return $this->redirect($request->headers->get('referer'));

    }
}
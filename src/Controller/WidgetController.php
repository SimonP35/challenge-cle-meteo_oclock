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
     * Undocumented function
     *
     * @Route("/widget", name="widget", methods="POST")
     * @param Type $var
     * @return Response
     */
    public function widget(Request $request, SessionInterface $session)
    {
        // On récupère notre id se dans $_POST['id']
        $id = $request->request->get('id');
        // dd($id);

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

        // On remet le nouveau panier dans la session
        $session->set('widget', $widget);
        // On ajoute un Flash Message
        $this->addFlash('success', 'Votre nouvelle météo favorite est celle de '.$widget['weather']['city'].' !');

        //? Test condition (fonctionne mais semble inutile ^')
        //? !empty($widget) ? $this->addFlash('success', 'Votre nouvelle météo favorite est celle de '.$widget['weather']['city'].' !') : $this->addFlash('primary', 'Vous pouvez séléctionner une météo favorite dans la liste ci-dessous :) !') ; 
        
        // On redirige
        return $this->redirectToRoute('home');
    }
}
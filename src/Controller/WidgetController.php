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

        // On stock notre "id" en session
        // Le widget (tableau) existant OU un widget vide
        $widget = $session->get('widget', []); // $widget = $_SESSION['widget'];

        // On va stocker l'id de la weather à la clé du tableau widget
        if ( !array_key_exists($id, $widget) ) {
            // On va ajouter 1 fois l'oiseau dans le panier

            // Via un tableau associatif qui va structurer le contenu du panier
            $weatherInWidget = [
                'weather' => $weather, // $bird = toutes les infos de l'oiseau (via le Model)
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
        $this->addFlash('success', 'Nouvelle météo sélectionnée !');

        // On redirige
        return $this->redirectToRoute('home');
    }
}
<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class WebSocketTestController extends AbstractController
{
    #[Route('/ws/test', name: 'app_web_socket_test')]
    public function index(): Response
    {
        // Endpoint of your WebSocket server
        $webSocketServerUrl = 'ws://localhost:8080/ws';

        // Message to send to the WebSocket server
        $messageToSend = 'Hello from Symfony!';

        // Initialize HTTP client
        $client = HttpClient::create();

        try {
            // Connect to the WebSocket server
            $response = $client->request('GET', $webSocketServerUrl,[
                'body' => $messageToSend,
            ]);
            
            dd($response);

            // Wait for the server's response
            $receivedMessage = $response->getContent();

            return $this->json(['received_message' => $receivedMessage]);
        } catch (TransportExceptionInterface $e) {
            // Handle connection errors
            return $this->json(['error' => 'Unable to connect to the WebSocket server']);
        }
    }

    #[Route('/js/ws', name:'websocket_js')]
    public function testws(): Response
    {
        return $this->render('websocket/index.html.twig',[
            'bienvenue'=> 'Bonjour',
        ]);
    }
}

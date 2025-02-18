<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ChatServer implements MessageComponentInterface {

    // Called when a new connection is established
    public function onOpen(ConnectionInterface $conn) {
        echo "New connection! ({$conn->resourceId})\n";
    }

    // Called when a message is received
    public function onMessage(ConnectionInterface $from, $msg) {
        // Broadcast the message to all other connected clients
        foreach ($from->httpRequest->getHeader('Origin') as $header) {
            $from->send($msg); // Send the message to the sender
        }
        $data = json_decode($msg, true);
        // Send the message to all other connected clients
        foreach ($from->getConnections() as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    // Called when a connection is closed
    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    // Called when an error occurs
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Create a WebSocket server on port 8080
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080
);

echo "WebSocket server started on port 8080...\n";
$server->run();

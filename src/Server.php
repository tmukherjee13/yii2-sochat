<?php
namespace Sochat;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

/**
 *  Sochat Server
 */
class Server
{
    public function serveForever()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );

        print("Starting chat server...");
        echo PHP_EOL;
        print("Chat server running on port 8080");
        echo PHP_EOL;
        $server->run();
    }
}

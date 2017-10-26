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
    public $port;

    public function __construct($port = 8080)
    {
        $this->port = $port;
    }
    public function serveForever()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            $this->port
        );

        print("Starting chat server...");
        echo PHP_EOL;
        print("Chat server running on port ".$this->port);
        echo PHP_EOL;
        $server->run();
    }
}

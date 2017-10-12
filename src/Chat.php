<?php
namespace Sochat;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{
    use \Sochat\Chatter;
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {

        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo $conn->resourceId;
        // echo PHP_EOL;
        // $guid = $this->guid(false);
        // $conn->send('{"channel_id":"' . $guid . '","context":"new"}');
        // echo PHP_EOL;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $data    = (array) json_decode($msg);
        // $msgData = $this->insertMessage($data);

        // if (isset($msgData['id'])) {

        //     $return = [
        //         "id"        => $msgData['id'],
        //         "from_user" => $msgData['from_user'],
        //         "to_user"   => $msgData['to_user'],
        //         "message"   => $msgData['message'],
        //         "username"  => $msgData['username'],
        //         "sent"      => strtotime($msgData['created_at']),
        //     ];

            foreach ($this->clients as $client) {
                // if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send(json_encode($data));
                // }
            }
        // }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function guid($opt = true)
    {
        //  Set to true/false as your default way to do this.

        if (function_exists('com_create_guid')) {
            if ($opt) {return com_create_guid();} else {return trim(com_create_guid(), '{}');}
        } else {
            mt_srand((double) microtime() * 10000); // optional for php 4.2.0 and up.
            $charid      = strtoupper(md5(uniqid(rand(), true)));
            $hyphen      = chr(45); // "-"
            $left_curly  = $opt ? chr(123) : ""; //  "{"
            $right_curly = $opt ? chr(125) : ""; //  "}"
            $uuid        = $left_curly
            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12)
                . $right_curly;
            return $uuid;
        }
    }
}

<?php
include "components/core.php";
$host = '127.0.0.1';   
$port = 8080;          

$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($server, $host, $port);
socket_listen($server);

$clients = [$server];

echo "WebSocket сервер запущен на ws://$host:$port\n";

function sendChatHistory($client, $link, $user_id) {
    $stmt = $link->prepare("
        SELECT * FROM messages 
        WHERE sender_id = ? OR receiver_id = ? 
        ORDER BY created_at ASC
    ");
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $message = mask(json_encode([
            'from' => $row['sender_id'],
            'to' => $row['receiver_id'],
            'text' => $row['message'],
            'time' => $row['created_at']
        ]));
        socket_write($client, $message, strlen($message));
    }
    $stmt->close();
}

while (true) {
    $read = $clients;
    $write = $except = null;

    socket_select($read, $write, $except, null);

    foreach ($read as $sock) {
        if ($sock === $server) {
            $newClient = socket_accept($server);
            $clients[] = $newClient;
            $header = socket_read($newClient, 1024);
            perform_handshake($header, $newClient);

            if (preg_match("/GET\s(\/\?[^\s]+)\sHTTP/", $header, $matches)) {
                $url = $matches[1]; 
                $query = parse_url($url, PHP_URL_QUERY);
                parse_str($query, $params);
                $user_id = $params['user_id'] ?? 0;
            } else {
                $user_id = 0;
            }
            echo "Подключился пользователь: $user_id\n";

            sendChatHistory($newClient, $link, $user_id);
        } else {
            $data = socket_read($sock, 1024);
            if ($data === false) {
                $key = array_search($sock, $clients);
                unset($clients[$key]);
                socket_close($sock);
                continue;
            }

            $message = json_decode(unmask($data), true);
            
            if ($message) {
                $sender_id = $message['sender_id'];
                $receiver_id = $message['receiver_id'];
                $text = $message['text'];

                echo "Сообщение от $sender_id для $receiver_id: $text\n";

                $stmt = $link->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $sender_id, $receiver_id, $text);
                $stmt->execute();
                $stmt->close();

                foreach ($clients as $client) {
                    if ($client !== $server) {
                        $response = mask(json_encode([
                            'from' => $sender_id,
                            'to' => $receiver_id,
                            'text' => $text,
                            'time' => date("Y-m-d H:i:s")
                        ]));
                        socket_write($client, $response, strlen($response));
                    }
                }
            }
        }
    }
}

function perform_handshake($header, $client) {
    $key = '';
    if (preg_match('/Sec-WebSocket-Key: (.*)\r\n/', $header, $matches)) {
        $key = trim($matches[1]);
    }

    $acceptKey = base64_encode(pack('H*', sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));

    $upgradeHeader = "HTTP/1.1 101 Switching Protocols\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "Sec-WebSocket-Accept: $acceptKey\r\n\r\n";

    socket_write($client, $upgradeHeader, strlen($upgradeHeader));
}

function unmask($text) {
    $length = ord($text[1]) & 127;

    if ($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    } else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }

    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }

    return $text;
}

function mask($text) {
    $b1 = 0x81;
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length <= 65535) {
        $header = pack('CCn', $b1, 126, $length);
    } else {
        $header = pack('CCNN', $b1, 127, 0, $length);
    }

    return $header . $text;
}
?>
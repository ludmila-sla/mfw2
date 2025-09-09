<?php

namespace App\Session;

use SessionHandlerInterface;
use MongoDB\Client;
use MongoDB\Collection;

class MongoSessionHandler implements SessionHandlerInterface
{
    private Collection $collection;

    public function __construct(string $uri = 'mongodb://127.0.0.1:27017', string $db = 'mfw', string $collection = 'sessions')
    {
        $client = new Client($uri);
        $this->collection = $client->$db->$collection;
    }

    public function open(string $savePath, string $sessionName): bool
    {
        // Não precisa fazer nada específico, mas retorna true
        return true;
    }

    public function close(): bool
    {
        // Não precisa fechar nada explicitamente
        return true;
    }

    public function read(string $sessionId): string
    {
        $session = $this->collection->findOne(['_id' => $sessionId]);
        return $session['data'] ?? '';
    }

    public function write(string $sessionId, string $data): bool
    {
        $now = new \MongoDB\BSON\UTCDateTime();
        $this->collection->updateOne(
            ['_id' => $sessionId],
            ['$set' => ['data' => $data, 'updated_at' => $now]],
            ['upsert' => true]
        );
        return true;
    }

    public function destroy(string $sessionId): bool
    {
        $this->collection->deleteOne(['_id' => $sessionId]);
        return true;
    }

    public function gc(int $maxLifetime): bool
    {
        $threshold = new \MongoDB\BSON\UTCDateTime((time() - $maxLifetime) * 1000);
        $this->collection->deleteMany(['updated_at' => ['$lt' => $threshold]]);
        return true;
    }
}

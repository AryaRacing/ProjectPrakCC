<?php

require 'vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$datastore = new DatastoreClient();
$app = new \Slim\App;

$app->post('/gudang', function ($request, $response, $args) use ($datastore) {
    $data = $request->getParsedBody();
    $key = $datastore->key('gudang');
    $entity = $datastore->entity($key, $data);
    $datastore->insert($entity);
    return $response->withJson($entity->get(), 201);
});

$app->get('/gudang', function ($request, $response, $args) use ($datastore) {
    $query = $datastore->query()->kind('gudang');
    $items = $datastore->runQuery($query);
    $result = [];
    foreach ($items as $item) {
        $result[] = $item->get();
    }
    return $response->withJson($result);
});

$app->get('/gudang/{id}', function ($request, $response, $args) use ($datastore) {
    $key = $datastore->key('gudang', (int)$args['id']);
    $item = $datastore->lookup($key);
    if ($item) {
        return $response->withJson($item->get());
    }
    return $response->withStatus(404);
});

$app->put('/gudang/{id}', function ($request, $response, $args) use ($datastore) {
    $data = $request->getParsedBody();
    $key = $datastore->key('gudang', (int)$args['id']);
    $entity = $datastore->lookup($key);
    if ($entity) {
        $entity->set($data);
        $datastore->update($entity);
        return $response->withJson($entity->get());
    }
    return $response->withStatus(404);
});

$app->delete('/gudang/{id}', function ($request, $response, $args) use ($datastore) {
    $key = $datastore->key('gudang', (int)$args['id']);
    $datastore->delete($key);
    return $response->withStatus(204);
});

$app->run();

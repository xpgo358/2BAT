<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/conexion.php';

$entityMap = [
    'pistas' => [
        'table' => 'pistas',
        'pk' => ['codPista'],
        'fields' => ['codPista', 'nombre', 'direccion', 'fecha_mantenimiento'],
        'order' => 'codPista',
    ],
    'clientes' => [
        'table' => 'clientes',
        'pk' => ['dni'],
        'fields' => ['dni', 'nombre', 'ap1', 'ap2', 'foto', 'telefono', 'email', 'direccion', 'fecha_renovacion'],
        'order' => 'dni',
    ],
    'tarifas' => [
        'table' => 'tarifas',
        'pk' => ['tarifa'],
        'fields' => ['tarifa', 'precio'],
        'order' => 'tarifa',
    ],
    'karts' => [
        'table' => 'karts',
        'pk' => ['num_kart'],
        'fields' => ['num_kart', 'fecha_mantenimiento'],
        'order' => 'num_kart',
    ],
    'reservas' => [
        'table' => 'reservas',
        'pk' => ['num_reserva'],
        'fields' => ['num_reserva', 'dni', 'codPista', 'fecha', 'hora_inicio', 'duracion', 'personas', 'tarifa', 'descuento'],
        'order' => 'num_reserva DESC',
    ],
    'carreras' => [
        'table' => 'carreras',
        'pk' => ['num_carrera'],
        'fields' => ['num_carrera', 'codPista', 'num_reserva', 'terminada'],
        'order' => 'num_carrera DESC',
    ],
    'corredores' => [
        'table' => 'corredores',
        'pk' => ['num_carrera', 'dni'],
        'fields' => ['num_carrera', 'dni', 'num_kart', 'posicion'],
        'order' => 'num_carrera DESC, posicion ASC',
    ],
    'vueltas' => [
        'table' => 'vueltas',
        'pk' => ['num_carrera', 'num_kart', 'num_vuelta'],
        'fields' => ['num_carrera', 'num_kart', 'num_vuelta', 'tiempo'],
        'order' => 'num_carrera DESC, num_kart ASC, num_vuelta ASC',
    ],
];

function fail(string $message, int $code = 400): void
{
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$entity = $_GET['entity'] ?? $_POST['entity'] ?? '';

if (!isset($entityMap[$entity])) {
    fail('Entidad inválida.');
}

$cfg = $entityMap[$entity];
$pdo = db();

function cleanValue(mixed $v): mixed
{
    if ($v === '' || $v === null) {
        return null;
    }
    return $v;
}

function saveClientePhotoIfAny(array &$payload): void
{
    if (empty($payload['dni'])) {
        return;
    }

    $fotoData = $payload['foto_data'] ?? null;
    if (!$fotoData || !is_string($fotoData)) {
        return;
    }

    if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $fotoData)) {
        return;
    }

    $raw = preg_replace('/^data:image\/[a-zA-Z]+;base64,/', '', $fotoData);
    if (!is_string($raw)) {
        return;
    }

    $binary = base64_decode($raw, true);
    if ($binary === false) {
        return;
    }

    $dni = preg_replace('/[^A-Za-z0-9]/', '', (string)$payload['dni']);
    if (!$dni) {
        return;
    }

    $folder = __DIR__ . '/fotos';
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $filePath = $folder . '/' . $dni . '.jpg';
    file_put_contents($filePath, $binary);
    $payload['foto'] = 'fotos/' . $dni . '.jpg';
}

try {
    if ($action === 'list') {
        $sql = 'SELECT * FROM ' . $cfg['table'] . ' ORDER BY ' . $cfg['order'] . ' LIMIT 300';
        $rows = $pdo->query($sql)->fetchAll();
        echo json_encode(['ok' => true, 'rows' => $rows], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'create') {
        $payload = $_POST;
        if ($entity === 'clientes') {
            saveClientePhotoIfAny($payload);
        }

        $data = [];
        foreach ($cfg['fields'] as $f) {
            if ($f === 'foto' && $entity === 'clientes') {
                $data[$f] = cleanValue($payload[$f] ?? null);
                continue;
            }
            if (array_key_exists($f, $payload)) {
                $data[$f] = cleanValue($payload[$f]);
            }
        }

        if ($entity === 'reservas') {
            unset($data['num_reserva']);
        }
        if ($entity === 'carreras') {
            unset($data['num_carrera']);
        }

        $fields = array_keys($data);
        $ph = array_map(fn($f) => ':' . $f, $fields);
        $sql = 'INSERT INTO ' . $cfg['table'] . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $ph) . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'update') {
        $payload = $_POST;
        if ($entity === 'clientes') {
            saveClientePhotoIfAny($payload);
        }

        $set = [];
        $params = [];

        foreach ($cfg['fields'] as $f) {
            if (in_array($f, $cfg['pk'], true)) {
                continue;
            }
            if (array_key_exists($f, $payload)) {
                $set[] = $f . ' = :' . $f;
                $params[$f] = cleanValue($payload[$f]);
            }
        }

        if (!$set) {
            fail('No hay campos para actualizar.');
        }

        $where = [];
        foreach ($cfg['pk'] as $pk) {
            if (!array_key_exists($pk, $payload)) {
                fail('Falta clave primaria: ' . $pk);
            }
            $where[] = $pk . ' = :pk_' . $pk;
            $params['pk_' . $pk] = cleanValue($payload[$pk]);
        }

        $sql = 'UPDATE ' . $cfg['table'] . ' SET ' . implode(', ', $set) . ' WHERE ' . implode(' AND ', $where);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($action === 'delete') {
        $payload = $_POST;
        $where = [];
        $params = [];
        foreach ($cfg['pk'] as $pk) {
            if (!array_key_exists($pk, $payload)) {
                fail('Falta clave primaria: ' . $pk);
            }
            $where[] = $pk . ' = :' . $pk;
            $params[$pk] = cleanValue($payload[$pk]);
        }

        $sql = 'DELETE FROM ' . $cfg['table'] . ' WHERE ' . implode(' AND ', $where);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
        exit;
    }

    fail('Acción inválida.');
} catch (Throwable $e) {
    fail('Error: ' . $e->getMessage(), 500);
}

<?php
// procesar.php - Backend: valida, formatea, guarda la foto y muestra el resultado

// ---------- Funciones auxiliares ----------
// Saneamiento: quita etiquetas, espacios sobrantes y escapa caracteres especiales (anti-XSS)
function limpiar(string $valor): string
{
    return htmlspecialchars(trim(strip_tags($valor)), ENT_QUOTES, 'UTF-8');
}

// Formato tipo título con soporte UTF-8 (sofía -> Sofía)
function formatoTitulo(string $texto): string
{
    return mb_convert_case(mb_strtolower($texto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
}

$errores   = [];
$resultado = null;

// ---------- 1. Solo aceptamos peticiones POST ----------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ---------- 2. Recibir y sanear los datos ----------
$nombre         = limpiar($_POST['nombre'] ?? '');
$apellido       = limpiar($_POST['apellido'] ?? '');
$identificacion = limpiar($_POST['identificacion'] ?? '');
$fechaNac       = trim($_POST['fecha_nacimiento'] ?? '');
$sexo           = trim($_POST['sexo'] ?? '');

// ---------- 3. Validar que los campos no estén vacíos ----------
if ($nombre === '')         { $errores[] = 'El nombre es requerido.'; }
if ($apellido === '')       { $errores[] = 'El apellido es requerido.'; }
if ($identificacion === '') { $errores[] = 'La identificación es requerida.'; }
if ($fechaNac === '')       { $errores[] = 'La fecha de nacimiento es requerida.'; }
if (!in_array($sexo, ['Hombre', 'Mujer'], true)) {
    $errores[] = 'Debe seleccionar un sexo válido.';
}

// ---------- 4. Estandarizar los textos ----------
$nombre         = formatoTitulo($nombre);
$apellido       = formatoTitulo($apellido);
$identificacion = mb_strtoupper($identificacion, 'UTF-8');

// ---------- 5. Calcular la edad y validar el rango 18 - 70 ----------
$edad = null;
if ($fechaNac !== '') {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaNac);
    $valida = $fecha && $fecha->format('Y-m-d') === $fechaNac;

    if (!$valida) {
        $errores[] = 'La fecha de nacimiento no es válida.';
    } else {
        $hoy = new DateTime('today');
        if ($fecha > $hoy) {
            $errores[] = 'La fecha de nacimiento no puede ser futura.';
        } else {
            $edad = $fecha->diff($hoy)->y;
            if ($edad < 18 || $edad > 70) {
                $errores[] = "La edad calculada es de $edad años. Debe estar entre 18 y 70 años.";
            }
        }
    }
}

// ---------- 6. Validar y guardar la foto ----------
$nombreFoto  = null;
$fotoBase64  = null;
$extPermitidas  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$mimePermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$tamanoMaximo   = 2 * 1024 * 1024; // 2 MB

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
    $errores[] = 'Debe adjuntar la fotografía del aspirante.';
} elseif ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    $errores[] = 'Ocurrió un error al subir la fotografía (código ' . (int)$_FILES['foto']['error'] . ').';
} else {
    $tmp        = $_FILES['foto']['tmp_name'];
    $extension  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $extPermitidas, true)) {
        $errores[] = 'Extensión no permitida. Use: ' . implode(', ', $extPermitidas) . '.';
    }
    if ($_FILES['foto']['size'] > $tamanoMaximo) {
        $errores[] = 'La fotografía supera el tamaño máximo de 2 MB.';
    }
    // Verificamos el contenido real del archivo (no solo la extensión)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (!in_array($finfo->file($tmp), $mimePermitidos, true) || @getimagesize($tmp) === false) {
        $errores[] = 'El archivo seleccionado no es una imagen válida.';
    }

    // Si todo está correcto, guardamos la foto con un nombre aleatorio y seguro
    if (empty($errores)) {
        $carpeta = __DIR__ . '/uploaded_files/';
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }
        $nombreFoto = bin2hex(random_bytes(12)) . '.' . $extension;

        if (move_uploaded_file($tmp, $carpeta . $nombreFoto)) {
            // La carpeta está protegida (.htaccess), así que mostramos la foto incrustada en base64
            $mime = $finfo->file($carpeta . $nombreFoto);
            $fotoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($carpeta . $nombreFoto));
        } else {
            $errores[] = 'No se pudo guardar la fotografía en el servidor.';
        }
    }
}

include 'includes/header.php';
?>

    <main class="container flex-grow-1 py-4">
        <section>
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger mx-auto" style="max-width: 520px;" role="alert">
                    <h2 class="h5">No se pudo registrar al aspirante</h2>
                    <ul class="mb-0">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="text-center">
                    <a href="index.php" class="btn btn-utp">Volver al formulario</a>
                </div>
            <?php else: ?>
                <div class="card card-utp mx-auto" style="max-width: 520px;">
                    <div class="card-header card-header-ok">
                        <h2 class="h5 mb-0">Aspirante registrado correctamente</h2>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?php echo $fotoBase64; ?>" alt="Fotografía del aspirante"
                             class="foto-aspirante mb-3">
                        <ul class="list-group list-group-flush text-start">
                            <li class="list-group-item"><strong>Nombre:</strong> <?php echo $nombre; ?></li>
                            <li class="list-group-item"><strong>Apellido:</strong> <?php echo $apellido; ?></li>
                            <li class="list-group-item"><strong>Identificación:</strong> <?php echo $identificacion; ?></li>
                            <li class="list-group-item"><strong>Fecha de nacimiento:</strong> <?php echo htmlspecialchars($fechaNac); ?></li>
                            <li class="list-group-item"><strong>Edad:</strong> <?php echo $edad; ?> años</li>
                            <li class="list-group-item"><strong>Sexo:</strong> <?php echo htmlspecialchars($sexo); ?></li>
                            <li class="list-group-item"><strong>Foto guardada como:</strong> <?php echo $nombreFoto; ?></li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php" class="btn btn-utp-verde">Registrar otro aspirante</a>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>

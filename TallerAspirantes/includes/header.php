<?php
// includes/header.php - Metadatos, estilos, navegación y breadcrumb dinámico (modular)
// Detectamos el nombre del archivo actual (ej: index.php o procesar.php)
$paginaActual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Admisión de la UTP</title>
    <meta name="description" content="Sistema de admisión de datos para aspirantes">
    <meta name="author" content="Universidad Tecnológica de Panamá / Estudiante">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#4F1250">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Paleta tomada del logo de la UTP */
        :root {
            --utp-purple:      #6F1D6F;
            --utp-purple-dark: #4F1250;
            --utp-purple-soft: #F4ECF4;
            --utp-green:       #0B4A1E;
            --utp-green-dark:  #073313;
            --utp-bg:          #F8F5F8;
        }

        body { background-color: var(--utp-bg); color: #2b2230; }

        /* Navbar */
        .navbar-utp {
            background: linear-gradient(90deg, var(--utp-purple-dark), var(--utp-purple));
            border-bottom: 4px solid var(--utp-green);
        }
        .navbar-utp .logo-wrap {
            background: #fff; border-radius: 50%;
            width: 46px; height: 46px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-right: .65rem; overflow: hidden;
        }
        .navbar-utp .logo-wrap img { width: 40px; height: 40px; object-fit: contain; }
        .navbar-utp .navbar-text-sub { font-size: .75rem; opacity: .85; display: block; line-height: 1; font-weight: 400; }

        /* Breadcrumb */
        .breadcrumb a { color: var(--utp-purple); font-weight: 500; }
        .breadcrumb a:hover { color: var(--utp-purple-dark); text-decoration: underline !important; }
        .breadcrumb-item.active { color: var(--utp-green); font-weight: 600; }

        /* Títulos */
        .titulo-seccion { color: var(--utp-purple-dark); font-weight: 700; }
        .titulo-seccion::after {
            content: ""; display: block; width: 70px; height: 4px; margin: .6rem auto 0;
            background: var(--utp-green); border-radius: 2px;
        }

        /* Tarjetas */
        .card-utp {
            border: 0; border-top: 5px solid var(--utp-purple);
            border-radius: .85rem; box-shadow: 0 .5rem 1.5rem rgba(79, 18, 80, .12);
        }

        /* Formulario */
        .form-label { color: var(--utp-purple-dark); }
        .form-control:focus {
            border-color: var(--utp-purple);
            box-shadow: 0 0 0 .25rem rgba(111, 29, 111, .18);
        }
        .btn-check:checked + .btn-sexo,
        .btn-sexo:hover {
            background-color: var(--utp-purple); border-color: var(--utp-purple); color: #fff;
        }
        .btn-sexo { color: var(--utp-purple); border-color: var(--utp-purple); }
        .btn-check:focus-visible + .btn-sexo { box-shadow: 0 0 0 .25rem rgba(111, 29, 111, .25); }

        /* Botones */
        .btn-utp {
            background-color: var(--utp-purple); border-color: var(--utp-purple);
            color: #fff; font-weight: 600; padding: .65rem 1rem;
        }
        .btn-utp:hover, .btn-utp:focus {
            background-color: var(--utp-purple-dark); border-color: var(--utp-purple-dark); color: #fff;
        }
        .btn-utp-verde {
            background-color: var(--utp-green); border-color: var(--utp-green); color: #fff; font-weight: 600;
        }
        .btn-utp-verde:hover { background-color: var(--utp-green-dark); border-color: var(--utp-green-dark); color: #fff; }

        /* Resultado */
        .card-header-ok { background: var(--utp-green); color: #fff; }
        .foto-aspirante {
            width: 160px; height: 160px; object-fit: cover; border-radius: 50%;
            border: 5px solid var(--utp-purple-soft); box-shadow: 0 0 0 3px var(--utp-purple);
        }
        .list-group-item strong { color: var(--utp-purple-dark); }

        /* Footer */
        .footer-utp { background: var(--utp-green-dark); border-top: 4px solid var(--utp-purple); }
        .footer-utp a:hover { text-decoration: underline !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-utp shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                    <span class="logo-wrap"><img src="img/logo-utp.png" alt="Logo de la Universidad Tecnológica de Panamá"></span>
                    <span>PortalU
                        <span class="navbar-text-sub text-white">Universidad Tecnológica de Panamá</span>
                    </span>
                </a>
            </div>
        </nav>

        <!-- Breadcrumb dinámico -->
        <div class="bg-white border-bottom py-2">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Inicio</a></li>
                        <?php if ($paginaActual == 'procesar.php'): ?>
                            <!-- Estamos en el procesador: mostramos el paso intermedio y activamos el enlace para regresar -->
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Registro</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Procesando Datos</li>
                        <?php else: ?>
                            <!-- Estamos en el inicio -->
                            <li class="breadcrumb-item active" aria-current="page">Registro de Aspirante</li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
        </div>
    </header>

# Taller Aspirantes – Laboratorio #3

Registro de aspirantes con **HTML5, Bootstrap 5.3.8 y PHP** (sin base de datos).

## Estructura

```
Taller-Aspirantes/
├── includes/
│   ├── header.php       # Metadatos, navbar y breadcrumb dinámico
│   ├── footer.php       # Footer con enlaces y año dinámico
│   └── formulario.php   # Formulario de registro
├── img/
│   └── logo-utp.png     # Logo institucional (navbar)
├── uploaded_files/      # Fotos subidas (protegida con .htaccess)
│   └── .gitkeep
├── index.php            # Página principal (incluye el formulario)
└── procesar.php         # Backend: valida, formatea y guarda
```

## Requisitos técnicos cumplidos
- Etiquetas semánticas `<header>`, `<main>`, `<section>`, `<footer>` con Bootstrap.
- Formulario dentro de `<main><section>`; menú, migas de pan, footer y formulario modularizados con `include`.
- Validación de edad entre 18 y 70 años.
- Nombre y apellido en formato título (`sofía` → `Sofía`); identificación en mayúsculas.
- Saneamiento con `strip_tags()`, `trim()` y `htmlspecialchars()`.
- Foto validada (extensión, tamaño y tipo MIME real), renombrada con nombre aleatorio y guardada en `uploaded_files/`.
- `uploaded_files/.htaccess` bloquea el acceso desde el navegador.

## Diseño
Paleta tomada del logo de la UTP: morado `#6F1D6F` y verde oscuro `#0B4A1E`, con fondo lavanda suave. Los estilos están en el `<style>` de `includes/header.php`.

## Instalación
1. Copiar la carpeta en `C:\wamp64\www\` (o `htdocs`).
2. Iniciar Apache y abrir `http://localhost/Taller-Aspirantes/` (o la ruta de subcarpeta donde la hayas puesto).

## Autor
Nombre del estudiante – Universidad Tecnológica de Panamá

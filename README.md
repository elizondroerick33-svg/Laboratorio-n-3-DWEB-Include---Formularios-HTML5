
# Universidad Tecnológica de Panamá

## Facultad de Ingeniería de Sistemas Computacionales

## Laboratorio #3 - Registro de Aspirantes

- **Fecha de ejecución:** 1 de octubre de 2026.

## Objetivos

- Maquetar una interfaz responsiva con HTML5 semántico y Bootstrap 5.3.8.
- Modularizar la aplicación con `include` de PHP.
- Procesar un formulario con `POST`, incluyendo la subida de una foto.
- Validar y sanear los datos en el servidor.
- Guardar archivos de forma segura sin usar base de datos.

## Introducción

- Sistema de registro de aspirantes donde el usuario ingresa nombre, apellido, identificación, fecha de nacimiento, sexo y fotografía.
- El servidor valida los datos, estandariza los textos, calcula la edad (debe estar entre 18 y 70 años) y guarda la foto en una carpeta protegida.
- No utiliza base de datos.

## Requisitos previos

- **PHP:** 8.0 o superior.
- **Servidor:** Apache (WampServer).
- **Internet:** necesario, porque Bootstrap se carga desde CDN.
- **Sistema operativo:** Windows 10 / 11.

## Instalación

- Descargar el repositorio y copiar la carpeta `TallerAspirantes` dentro de `C:\wamp64\www`
- Iniciar WampServer y esperar a que el ícono esté en verde.
- Abrir en el navegador: `http://localhost/TallerAspirantes/`
- La URL **no lleva** `www`, porque esa es la carpeta raíz del servidor.

## Estructura del proyecto

Todo el código está dentro de la carpeta `TallerAspirantes/`:

- `includes/header.php`: metadatos, estilos, navbar y breadcrumb dinámico.
- `includes/footer.php`: footer con enlaces y año dinámico.
- `includes/formulario.php`: formulario de registro.
- `uploaded_files/`: carpeta donde se guardan las fotos, protegida con `.htaccess`.
- `img/`: logo institucional.
- `images/`: capturas de este README.
- `index.php`: página principal.
- `procesar.php`: backend que valida, procesa y muestra el resultado.

## Funcionamiento

- Se usan las etiquetas `<header>`, `<main>`, `<section>` y `<footer>`, con el formulario dentro de `<main>` y `<section>`.
- El menú, el breadcrumb, el formulario y el footer se incluyen con `include`.
- El breadcrumb detecta la página actual con `basename()`.
- **Metadatos:** `charset`, `viewport`, `description`, `author`, `robots` y `theme-color`.
- **Saneamiento de datos:** `strip_tags()`, `trim()` y `htmlspecialchars()`.
- **Nombre y apellido** en formato título (`sofía` pasa a `Sofía`) con funciones `mb_`.
- **Identificación** en mayúsculas.
- **Edad** calculada con `DateTime` y validada entre 18 y 70 años.
- **Foto** validada por extensión (`jpg`, `jpeg`, `png`, `gif`, `webp`), tamaño máximo de 2 MB y tipo real del archivo.
- La foto se guarda con un nombre aleatorio en `uploaded_files/`.
- El archivo `.htaccess` impide acceder a las fotos desde el navegador.
<img width="1366" height="687" alt="image" src="https://github.com/user-attachments/assets/ce945372-d126-4444-9633-5bba578033f7" />



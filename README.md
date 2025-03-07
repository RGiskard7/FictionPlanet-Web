# FictionPlanet-Web

## Descripción del Proyecto

Esta página web es solo para fines didácticos, no está siendo utilizada para ningún objetivo comercial, y de momento surge únicamente como proyecto personal y como ejemplo de las capacidades adquiridas. Tanto el nombre como el logo son cosas provisionales, así como algunos ejemplos para rellenar texto o diversas imágenes.

## Aspectos Técnicos

- El área lógica de esta página web está desarrollada íntegramente en PHP, siguiendo, en la medida de lo posible, el patrón de arquitectura MVC (Modelo-Vista-Controlador) para poder separar la lógica de negocio y su visualización. La persistencia de datos está a cargo de una base de datos implementada en MySQL. Para separar la lógica de negocio de la lógica de acceso a datos, se ha utilizado también el patrón DAO (Data Access Object).

- En lo que compete al diseño, se hace uso de la biblioteca Bootstrap para HTML y CSS, así como del lenguaje JavaScript junto con la librería JQuery para la interacción dinámica.

## Funcionalidades

A grandes rasgos, la página web Fiction Planet intenta imitar lo que sería una pequeña red social en la que se puede:

- Crear y personalizar un perfil de usuario.
- Crear publicaciones con texto, imágenes y archivos adjuntos.
- Subir y gestionar fotos en galerías personales.
- Agregar y gestionar una lista de amigos o contactos.
- Comunicarse con otros usuarios a través de un chat en vivo.
- Buscar y seguir a otros usuarios.

## Capturas de Pantalla

A continuación se muestran algunas capturas de pantalla de la página web:

### Página de Inicio
<p align="center">
  <img src="doc/images/imagen_1.png" alt="Página de Inicio">
</p>

### Perfil de Usuario
<p align="center">
  <img src="doc/images/imagen_3.png" alt="Perfil de Usuario">
  <img src="doc/images/imagen_6.png" alt="Perfil de Usuario">
</p>

### Publicaciones
<p align="center">
  <img src="doc/images/imagen_2.png" alt="Publicaciones">
  <img src="doc/images/imagen_4.png" alt="Publicaciones">
  <img src="doc/images/imagen_7.png" alt="Publicaciones">
</p>

### Chat en Vivo
<p align="center">
  <img src="doc/images/imagen_5.png" alt="Chat en Vivo">
</p>

## Instalación

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/RGiskard7/FictionPlanet-Web.git
    ```

2. Configurar la base de datos MySQL y actualizar los parámetros de conexión en el archivo de configuración.

3. Iniciar el servidor web (por ejemplo, utilizando XAMPP).

4. Acceder a la página web desde el navegador.
# Centro de Estudiantes

Sistema web para la gestión de publicaciones, mensajes y administración de un Centro de Estudiantes.

## Características

- Gestión de publicaciones y categorías.
- Respuesta a mensajes de contacto con envío de email.
- Panel de administración con login seguro.
- Uso de variables de entorno para credenciales sensibles.
- Estilos institucionales y diseño responsive.

## Requisitos

- PHP 7.4 o superior
- Composer
- XAMPP o similar (MySQL, Apache)
- Cuenta de correo para envío de emails (Gmail recomendado)

## Instalación

1. **Clona el repositorio**

   ```sh
   git clone https://github.com/sergioserbluk/centro.git
   cd centro
   ```

2. **Instala las dependencias de Composer**

   ```sh
   composer install
   ```

3. **Configura las variables de entorno**

   - Copia el archivo `.env.example` y renómbralo a `.env`:

     ```sh
     cp .env.example .env
     ```

   - Edita el archivo `.env` y coloca tu usuario y contraseña de correo:

     ```
     MAIL_USERNAME=tu_correo@gmail.com
     MAIL_PASSWORD=tu_clave_de_aplicacion
     ```

     > Si usas Gmail, genera una [clave de aplicación](https://myaccount.google.com/apppasswords).

4. **Configura la base de datos**

   - Crea una base de datos en MySQL.
   - Importa el archivo SQL correspondiente (si existe, por ejemplo `database.sql`).
   - Edita el archivo `conexion.php` para poner tus datos de conexión.

5. **Configura XAMPP**

   - Coloca la carpeta del proyecto en `htdocs` de XAMPP.
   - Inicia Apache y MySQL desde el panel de XAMPP.

6. **Accede a la aplicación**

   - Abre tu navegador y entra a:  
     ```
     http://localhost/centro/
     ```

## Estructura del proyecto

```
centro/
├── assets/              # Imágenes y recursos
├── estilos/             # Hojas de estilo CSS
├── scripts/             # Archivos PHP principales
├── vendor/              # Dependencias Composer (no modificar)
├── .env.example         # Ejemplo de variables de entorno
├── composer.json
├── index.php
└── ...
```

## Seguridad

- **No subas tu archivo `.env`** al repositorio. Está en `.gitignore` por seguridad.
- Usa siempre claves de aplicación para el correo.

## Créditos

Desarrollado por [sergioserbluk](https://github.com/sergioserbluk).

---

¿Tienes dudas o sugerencias? ¡Abre un issue en el repositorio!
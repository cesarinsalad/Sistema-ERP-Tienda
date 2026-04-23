# 🚀 Guía del Sistema ERP - Sistema-ERP-Tienda

¡Bienvenido! Este documento está diseñado para ayudarte a entender cómo está organizado este proyecto, qué hace cada carpeta y cómo funciona el código, incluso si no tienes mucha experiencia técnica.

---

## 🏗️ ¿Cómo funciona todo? (El patrón MVC)

Este proyecto utiliza una forma de organizar el código llamada **MVC** (Modelo-Vista-Controlador). Imagina que el sistema es un restaurante:

1.  **Vista (View):** Es el **menú** y el **plato servido**. Es lo que el usuario ve en su pantalla (tablas, botones, formularios).
2.  **Controlador (Controller):** Es el **mesero**. Recibe el pedido del usuario, va a la cocina a pedir la comida y luego te la trae. Decide qué hacer cuando haces clic en un botón.
3.  **Modelo (Model):** Es la **cocina/despensa**. Es donde están los datos (productos, clientes, ventas). El modelo sabe cómo buscar, guardar o borrar información de la base de datos.

---

## 📁 Estructura de Carpetas Principal

Aquí tienes un desglose de las carpetas más importantes:

### 1. `app/` (El cerebro)
Aquí vive la lógica principal del sistema.
*   **`app/Http/Controllers/`**: Aquí están los "meseros". Por ejemplo, `ProductController.php` decide qué pasa cuando buscas un producto o agregas uno nuevo.
*   **`app/*.php` (Raíz de app)**: Aquí están los "Modelos". Archivos como `Product.php`, `Client.php` o `Order.php` definen qué datos tiene cada cosa (un producto tiene nombre, precio, stock, etc.).

### 2. `resources/views/` (Lo visual)
Aquí están las "Vistas". Son archivos `.blade.php` que contienen el HTML (la estructura de la página) y el diseño.
*   **`product/`**, **`clientes/`**, **`brand/`**: Carpetas que contienen las pantallas específicas para cada sección.
*   **`layouts/`**: Contiene la estructura base (cabecera, menú lateral, pie de página) para no tener que repetirla en cada página.

### 3. `routes/` (El mapa)
Aquí se definen las direcciones (URLs).
*   **`web.php`**: Es el archivo más importante aquí. Si entras a `/productos`, este archivo le dice al sistema: "Oye, ve al `ProductController` y dile que muestre la lista".

### 4. `database/` (Los cimientos)
*   **`migrations/`**: Son como planos de construcción. Dicen cómo debe ser la base de datos (qué tablas tiene y qué columnas).
*   **`seeds/`**: Datos de prueba para llenar el sistema rápidamente al empezar.

### 5. `public/` (La puerta de entrada)
Es la única carpeta a la que el navegador web tiene acceso directo. Aquí están los archivos de estilo (CSS), imágenes y scripts de JavaScript que hacen que la página se vea "Premium".

### 6. `config/` (Ajustes)
Archivos de configuración del sistema (nombre de la app, zona horaria, conexión a la base de datos).

---

## 🔑 Archivos Especiales en la Raíz

*   **`.env`**: Es el archivo de "secretos". Aquí se configura la contraseña de la base de datos y otros ajustes sensibles. **¡Nunca compartas este archivo!**
*   **`composer.json`**: Una lista de todas las herramientas externas que el proyecto necesita para funcionar (como el motor para generar PDFs).
*   **`artisan`**: Es una herramienta de línea de comandos que nos ayuda a crear archivos, limpiar la memoria o actualizar la base de datos.

---

## 🔄 El camino de un clic

¿Qué pasa cuando haces clic en "Ver Productos"?

1.  **Ruta**: El sistema ve que pediste `/products` en `routes/web.php`.
2.  **Controlador**: El `web.php` llama al `ProductController`.
3.  **Modelo**: El controlador le pide al modelo `Product.php`: "Dame todos los productos de la base de datos".
4.  **Vista**: El controlador toma esos productos y se los pasa a `resources/views/product/index.blade.php`.
5.  **Resultado**: ¡Ves la tabla de productos en tu pantalla!

---

## ✨ Diseño

Este proyecto ha sido personalizado con una estética moderna:
-   **Colores**: Tonos morados profundos, negros elegantes y grises suaves.
-   **Interacción**: Botones con efectos visuales, tablas legibles y un panel de administración limpio.
-   **Adaptabilidad**: El diseño intenta verse bien tanto en computadoras como en tablets.

---

> [!TIP]
> Si alguna vez el sistema se siente lento o algo no carga, asegúrate de que el archivo `.env` esté configurado correctamente para tu computadora.

# 🚀 Sistema SIG- GIGI FASHION IMPORT

Este es un sistema de Planificación de Recursos Empresariales (ERP) diseñado para la gestión integral de tiendas y negocios. El sistema ofrece una interfaz moderna, robusta y optimizada para la eficiencia operativa.

---

## ✨ Características Principales

- **📦 Gestión de Inventario:** Control total de productos, categorías y stock en tiempo real.
- **💰 Módulo de Ventas:** Panel interactivo para procesar ventas, generar comprobantes y rastrear ingresos.
- **👥 Administración de Clientes:** Base de datos centralizada para fidelización y seguimiento.
- **🔐 Control de Acceso (RBAC):** Sistema de roles y permisos detallado (Admin, Empleado, etc.) usando Spatie.
- **📊 Reportes Avanzados:** Generación de métricas de negocio y reportes en PDF con estética profesional.
- **🎨 Interfaz Premium:** Diseño basado en AdminLTE con una paleta de colores "Premium Purple" (morados profundos, negros elegantes y transiciones suaves).

---

## 🛠️ Tecnologías Utilizadas

- **Framework:** Laravel 7.4
- **Base de Datos:** MySQL 8.0
- **Frontend:** HTML5, CSS3 (Vanilla), JavaScript, Bootstrap 4
- **Dashboard:** AdminLTE 3
- **Entorno:** Docker + WSL2

---

## 🏗️ Guía de Instalación (WSL + Docker)

Sigue estos pasos para configurar el entorno de desarrollo en tu máquina local.

### 1. Requisitos Previos
- Windows 10/11 con **WSL2** instalado (Ubuntu recomendado).
- **Docker Desktop** con la integración de WSL2 activada.
- **PHP 7.4+** y **Composer** instalados dentro de tu distro de WSL.

### 2. Clonar y Configurar Variables de Entorno
Clona el repositorio y crea tu archivo de configuración:
```bash
cp .env.example .env
```
Asegúrate de que las credenciales de la base de datos en `.env` coincidan con tu configuración de Docker:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_erp
DB_USERNAME=root
DB_PASSWORD=root
```

### 3. Levantar la Base de Datos con Docker
Si no tienes un contenedor de MySQL listo, puedes levantarlo rápidamente:
```bash
docker run --name erp-mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=sistema_erp -p 3306:3306-d mysql:8.0
```

### 4. Instalar Dependencias
Dentro de la carpeta del proyecto en tu terminal de WSL:
```bash
composer install
npm install && npm run dev
```

### 5. Preparar la Base de Datos
Existen dos formas de preparar la base de datos, dependiendo de si quieres datos de prueba o una instalación completamente limpia:

**Opción A: Instalación Completa (Con datos de prueba)**
Esta opción generará cientos de registros ficticios (clientes, productos, órdenes) ideales para desarrollo y pruebas.
```bash
php artisan key:generate
php artisan migrate --seed
```

**Opción B: Instalación Limpia (Solo administrador y configuraciones)**
Esta opción es ideal para producción o para iniciar un negocio real. Solo creará el usuario Administrador y configuraciones básicas (monedas, métodos de pago).
```bash
php artisan key:generate
php artisan migrate --seed --class=BaseSeeder
```

### 6. Ejecutar el Programa
Inicia el servidor de desarrollo de Laravel:
```bash
php artisan serve
```
El sistema estará disponible en: [http://localhost:8000](http://localhost:8000)

> **Nota para usuarios de Docker Compose:** Si estás usando Docker Compose (recomendado), reemplaza los comandos `php artisan` por `docker-compose exec app php artisan`.

---

## 🔍 Visualización de la Base de Datos

Para gestionar y visualizar los datos gráficamente, puedes usar **phpMyAdmin** a través de Docker:

1. **Levantar phpMyAdmin:**
   ```bash
   docker run --name phpmyadmin-erp -d -p 8080:80 -e PMA_HOST=host.docker.internal phpmyadmin
   ```
2. **Acceder:** Ve a [http://localhost:8080](http://localhost:8080) en tu navegador.
3. **Credenciales:** Usuario `root` / Contraseña `root`.

---

## 📁 Estructura del Proyecto

- `app/Http/Controllers`: Lógica de negocio (los "meseros" del sistema).
- `app/Models`: Definición de datos y relaciones.
- `resources/views`: Plantillas de la interfaz (Blade).
- `routes/web.php`: Mapa de navegación y URLs.
- `public/`: Archivos estáticos (CSS, imágenes, JS).

---

## 💡 Notas de Uso
- El sistema utiliza **Spatie Permissions**. Si necesitas crear un nuevo rol, puedes hacerlo desde el panel administrativo o vía `php artisan tinker`.
- Los reportes PDF se generan dinámicamente y están optimizados para impresión en formato A4.

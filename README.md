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

## 🏗️ Guía de Instalación (Docker Compose)

Sigue estos sencillos pasos para configurar el entorno de desarrollo usando Docker, que ya contiene todo lo necesario (Nginx, PHP-FPM, MySQL 8.0).

### 1. Requisitos Previos
- **Docker** y **Docker Compose** instalados en tu sistema.

### 2. Clonar y Configurar Variables de Entorno
Clona el repositorio y crea tu archivo de configuración:
```bash
cp .env.example .env
```
Asegúrate de que las credenciales de la base de datos en tu archivo `.env` coincidan con lo que se creará en Docker:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=sistema_erp
DB_USERNAME=root
DB_PASSWORD=root
```

### 3. Levantar Contenedores e Instalar Dependencias
Levanta los contenedores en segundo plano (Nginx, PHP, MySQL) y asegúrate de que se construyan correctamente:
```bash
docker-compose up -d --build
```
Una vez que estén corriendo, instala las dependencias de Composer a través del contenedor `app`:
```bash
docker-compose exec app composer install
```
Instala las dependencias de Frontend (solo si vas a modificar recursos, es opcional si solo usarás el proyecto finalizado):
```bash
npm install && npm run dev
```

### 4. Preparar la Base de Datos
Existen dos formas de preparar la base de datos, dependiendo de si quieres datos de prueba o una instalación completamente limpia:

**Opción A: Instalación Completa (Con datos de prueba)**
Esta opción generará cientos de registros ficticios (clientes, productos, órdenes) ideales para desarrollo y pruebas.
```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed
```

**Opción B: Instalación Limpia (Solo administrador y configuraciones)**
Esta opción es ideal para producción o para iniciar un negocio real. Solo creará el usuario Administrador y configuraciones básicas (monedas, métodos de pago).
```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed --class=BaseSeeder
```

### 5. Ejecutar el Programa
¡Todo listo! No necesitas correr comandos adicionales. El servidor web Nginx configurado por Docker ya está sirviendo el sistema.
Simplemente abre en tu navegador:
[http://localhost:8000](http://localhost:8000)

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

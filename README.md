# Helpdesk CYC

Proyecto Helpdesk en **Laravel 12 + TailwindCSS**, creado para gestión de tickets internos en Consultores CYC.  
Incluye sistema de autenticación, roles (usuario/admin), CRUD de tickets y comentarios.

---

## 🚀 Requisitos

Asegúrate de tener instalado en tu PC:

- PHP 8.2+
- Composer
- Node.js 18+ y npm
- MySQL / MariaDB
- Git

---

## ⚙️ Instalación

1. **Clonar el repositorio**

```bash
git clone https://github.com/JayalaPerez/helpdesk-cyc.git
cd helpdesk-cyc
Instalar dependencias de PHP (Laravel)

bash
Copiar código
composer install
Instalar dependencias de Node (Tailwind, Vite)

bash
Copiar código
npm install
Configurar el archivo .env

Copia el archivo de ejemplo y edítalo con tus credenciales de base de datos:

bash
Copiar código
cp .env.example .env
En .env ajusta estas líneas según tu configuración de MySQL:

makefile
Copiar código
DB_DATABASE=helpdesk_cyc
DB_USERNAME=root
DB_PASSWORD=
Generar la clave de la aplicación

bash
Copiar código
php artisan key:generate
Migrar y sembrar la base de datos

bash
Copiar código
php artisan migrate --seed
Esto creará las tablas y un usuario administrador por defecto.

🔑 Credenciales de prueba
Admin:
Email: admin@cyc.cl
Password: password

Usuario normal: (puede registrarse desde la página de registro)

▶️ Levantar el servidor
En una terminal (Laravel backend):

bash
Copiar código
php artisan serve
En otra terminal (Tailwind + Vite):

bash
Copiar código
npm run dev
Luego abre en el navegador:
👉 http://127.0.0.1:8000

👥 Colaboración
Si trabajas en equipo:

Crea tu rama antes de hacer cambios:

bash
Copiar código
git checkout -b mi-rama
Haz commit y push:

bash
Copiar código
git add .
git commit -m "Descripción de mis cambios"
git push origin mi-rama
Abre un Pull Request en GitHub para fusionar tu rama en main.


🖥️ Tecnologías usadas
Laravel 12 (PHP)

TailwindCSS + Vite

MySQL

Breeze (auth, login, registro)

yaml
Copiar código


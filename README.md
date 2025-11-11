# Citas Médicas

Aplicación web para gestionar citas médicas: pacientes, médicos, especialidades y reservas de citas. Esta implementación utiliza Laravel y Tailwind y está pensada como una base para clínicas o consultorios que necesiten administración de citas médicas.

## Características

- Gestión de usuarios y roles (administrador, médico, paciente).
- Gestión de médicos y especialidades.
- Gestión de pacientes.
- Reservas y revición de citas.
- Migraciones y seeders para datos iniciales.

## Stack tecnológico

- PHP ^8.2
- Laravel ^12
- Vite, TailwindCSS (frontend)
- Composer y npm

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js (v16+ recomendado) y npm
- Servidor de base de datos (MySQL, MariaDB, PostgreSQL) o SQLite para desarrollo

## Instalación (desarrollo)

1. Clona el repositorio:

```powershell
git clone https://github.com/C4rlosDcJ/Citas-Medicas.git
cd Citas-Medicas
```

2. Instala dependencias de PHP y Node:

```powershell
composer install
npm install
```

3. Crea el archivo de entorno y genera la llave de aplicación:

```powershell
copy .env.example .env
php artisan key:generate
```

4. Configura las variables de entorno en `.env` (conexión a la BD ).

5. Ejecuta migraciones y seeders:

```powershell
php artisan migrate
php artisan db:seed  # opcional, si hay seeders
```

6. Levanta el entorno de desarrollo de frontend y backend:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

También existe un script Composer útil en `composer.json` llamado `setup` que intenta automatizar los pasos básicos:

```powershell
composer run setup
```

Nota: en Windows PowerShell usar `copy` para copiar `.env.example`; en otros shells use `cp`.

## Scripts útiles

- `composer run setup` — instala dependencias, crea .env si no existe, genera key, ejecuta migraciones y construye assets.
- `php artisan test` — ejecuta la suite de tests.

## Ejecutar pruebas

```powershell
php artisan test
```

## Estructura importante del proyecto

- `app/Models` — modelos principales (Cita, Especialidad, Medico, Paciente, Role, User).
- `app/Http/Controllers` — controladores.
- `database/migrations` — migraciones.
- `database/seeders` — seeders para poblar datos iniciales en la db.
- `resources/views` — vistas Blade del frontend.
- `routes/web.php` — rutas web.


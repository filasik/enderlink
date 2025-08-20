# Copilot Instructions for EnderLink

## Project Overview
EnderLink is a Laravel + Vue 3 + Inertia.js web application for managing Minecraft servers. It supports both self-hosted and cloud-hosted multitenant deployments. The backend is PHP (Laravel), the frontend is Vue 3 (TypeScript), and asset compilation uses Vite.

## Architecture & Key Components
- **Backend:**
  - Located in `app/` (Controllers, Models, Policies, Providers)
  - Multitenancy logic in `app/Models/Tenant.php` and `app/Providers/TenancyServiceProvider.php`
  - HTTP routes in `routes/` (`web.php`, `auth.php`, `settings.php`, etc.)
  - Database migrations in `database/migrations/`, seeders in `database/seeders/`, factories in `database/factories/`
- **Frontend:**
  - Vue components in `resources/js/components/`
  - Pages in `resources/js/pages/`
  - Composables and types in `resources/js/composables/` and `resources/js/types/`
  - Styles in `resources/css/app.css`
  - Blade templates in `resources/views/`
- **Public assets:**
  - Images and icons in `public/images/`

## Developer Workflows
- **Install dependencies:**
  - PHP: `composer install`
  - JS: `npm install`
- **Environment setup:**
  - Copy `.env.example` to `.env`
  - Generate app key: `php artisan key:generate`
- **Database:**
  - Migrate: `php artisan migrate`
  - Default: SQLite (`database/database.sqlite`)
- **Run servers:**
  - Backend: `php artisan serve`
  - Frontend: `npm run dev`
- **Testing:**
  - PHPUnit tests in `tests/`
  - Run: `php artisan test` or `vendor/bin/phpunit`
- **Build assets:**
  - Production: `npm run build`

## Conventions & Patterns
- **Multitenancy:**
  - Tenants are modeled in `app/Models/Tenant.php` and managed via service providers.
- **Routing:**
  - Route files are split by domain (`web.php`, `auth.php`, etc.).
- **Frontend:**
  - Vue 3 + TypeScript, organized by feature in `resources/js/`
  - Inertia.js bridges Laravel and Vue; see `app/Http/Controllers` for Inertia responses.
- **Authorization:**
  - Policies in `app/Policies/` (e.g., `SettingsPolicy.php`)
- **Config:**
  - App configuration in `config/` (e.g., `tenancy.php`, `auth.php`)

## Integration Points
- **Minecraft server:**
  - RCON and plugin integration planned (see roadmap in README)
- **External APIs:**
  - Discord, AuthMe, Microsoft authentication planned
- **Asset pipeline:**
  - Vite for JS/CSS bundling

## Examples
- To add a new model: place in `app/Models/`, create migration in `database/migrations/`, update relevant controller in `app/Http/Controllers/`
- To add a new Vue page: create in `resources/js/pages/`, add route in `routes/web.php`, update controller for Inertia response

## References
- See `README.md` for setup, features, and roadmap
- See `phpunit.xml` for test configuration
- See `vite.config.ts` and `tsconfig.json` for frontend build settings

---
**If any conventions or workflows are unclear, ask the user for clarification or examples.**

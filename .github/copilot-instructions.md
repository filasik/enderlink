# EnderLink AI Coding Instructions

## Project Overview
EnderLink is a modern companion web application for Minecraft server management built with Laravel 11, Vue 3, Inertia.js, and multi-tenancy support. It provides both self-hosted and cloud-hosted multitenant solutions for server administrators.

## Architecture & Multi-Tenancy

### Core Multi-Tenancy Pattern
- Uses `stancl/tenancy` package for path-based tenant isolation (`/{tenant}/...`)
- Central app routes in `routes/web.php` (Welcome page)
- Tenant-specific routes wrapped in `InitializeTenancyByPath` middleware
- Models use `BelongsToTenant` trait (see `app/Models/Settings.php`)
- Tenant data isolated in separate database contexts

### Route Structure
```php
// Central routes (no tenant context)
Route::get('/', WelcomeController) // Landing page

// Tenant routes (/{tenant}/...)
Route::middleware([InitializeTenancyByPath::class])
    ->prefix('/{tenant}')
    ->group(function () {
        Route::get('/', HomeController); // Tenant home
        Route::get('/dashboard', DashboardController); // Auth required
    });
```

## Development Workflow

### Essential Commands
```bash
# Development setup
composer install && npm install
php artisan key:generate && php artisan migrate
php artisan serve & npm run dev

# Build for production
npm run build:ssr  # Includes SSR build
composer install --optimize-autoloader --no-dev

# Code quality
npm run format     # Prettier formatting
npm run lint       # ESLint fixing
```

### Testing
- Feature tests in `tests/Feature/` follow tenant-aware patterns
- Use `RefreshDatabase` trait for tenant database isolation
- Test both central and tenant routes separately

## Frontend Architecture

### Vue + Inertia Stack
- Entry point: `resources/js/app.ts` with Inertia setup
- Pages in `resources/js/pages/` (auto-resolved by Inertia)
- Composables in `resources/js/composables/` (e.g., `useAppearance.ts`)
- Theme management with system/light/dark support built-in

### Component Patterns
- Uses Reka UI component library with Tailwind CSS v4
- Vue 3 Composition API throughout
- TypeScript strict mode enabled

### Asset Building
- Vite configuration includes SSR support
- Tailwind CSS v4 via `@tailwindcss/vite` plugin
- Path alias `@` maps to `resources/js/`

## Database & Models

### Tenant-Aware Models
```php
class Settings extends Model {
    use BelongsToTenant;  // Critical for tenant isolation
    protected $primaryKey = 'key';
    public $incrementing = false;
}
```

### Migration Patterns
- Central migrations: `0001_00_*` prefix (tenants table)
- Tenant migrations: Standard Laravel naming
- Settings table uses composite unique key: `['tenant_id', 'key']`

## Key Conventions

### Route Naming
- Central routes: `home`, `register`, `login`
- Tenant routes: `tenant.home`, `tenant.dashboard`, `tenant.setup.index`

### File Organization
- Controllers: Standard Laravel structure with tenant-aware logic
- Policies: `SettingsPolicy`, `SetupPolicy` for tenant-scoped authorization
- Providers: `TenancyServiceProvider` configures tenant lifecycle events

### Environment & Config
- Multi-database setup in `config/tenancy.php`
- Central domains configured for development: `127.0.0.1`, `localhost`
- Database bootstrapper commented out (uses single SQLite file)

## Deployment
- GitHub Actions workflow deploys to VPS on main branch push
- Includes Discord notifications via webhook
- Production build includes `npm rebuild` step for native dependencies

## Common Patterns

When adding new features:
1. Check if feature is tenant-scoped (most are) → use `BelongsToTenant` trait
2. Add routes under tenant middleware group with `tenant.*` naming
3. Create Vue pages in appropriate subdirectories
4. Use Inertia for navigation between tenant contexts
5. Test both authenticated and guest access patterns
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

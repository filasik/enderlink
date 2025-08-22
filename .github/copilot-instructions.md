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

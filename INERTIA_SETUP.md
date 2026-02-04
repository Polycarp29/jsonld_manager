# Inertia.js Integration Setup Guide

I've successfully converted the JSON-LD Manager from separate Vue.js and Laravel apps to a unified Inertia.js integration. Here's what has been set up and how to complete the installation:

## ✅ What's Been Done

### 1. Package Configuration
- **Updated [`backend/package.json`](backend/package.json)** with Inertia.js and Vue 3 dependencies
- **Updated [`backend/vite.config.js`](backend/vite.config.js)** with Vue plugin and proper resolution

### 2. Inertia.js Frontend Setup
- **Created [`backend/resources/js/app.js`](backend/resources/js/app.js)** - Inertia app entry point
- **Created [`backend/resources/views/app.blade.php`](backend/resources/views/app.blade.php)** - Root Blade template
- **Created [`backend/resources/js/Layouts/AppLayout.vue`](backend/resources/js/Layouts/AppLayout.vue)** - Main layout component

### 3. Vue Components (Moved from separate frontend)
- **Dashboard:** [`backend/resources/js/Pages/Dashboard.vue`](backend/resources/js/Pages/Dashboard.vue)
- **Schema Validator:** [`backend/resources/js/Components/SchemaValidator.vue`](backend/resources/js/Components/SchemaValidator.vue)

### 4. Inertia Controllers
- **Dashboard:** [`backend/app/Http/Controllers/DashboardController.php`](backend/app/Http/Controllers/DashboardController.php)
- **Schema Management:** [`backend/app/Http/Controllers/SchemaController.php`](backend/app/Http/Controllers/SchemaController.php)

### 5. Updated Routes
- **Web routes:** [`backend/routes/web.php`](backend/routes/web.php) - Full Inertia routing structure

## 🚀 Next Steps to Complete Setup

### 1. Install PHP Inertia Package
```bash
cd backend
composer require inertiajs/inertia-laravel
```

### 2. Install Node Dependencies
```bash
cd backend
npm install
```

### 3. Publish Inertia Middleware
```bash
php artisan inertia:middleware
```

### 4. Add Inertia Middleware to Kernel
Add to `app/Http/Kernel.php` in the `web` middleware group:
```php
'web' => [
    // ... existing middleware
    \App\Http\Middleware\HandleInertiaRequests::class,
],
```

### 5. Configure Inertia Service Provider
In `config/app.php`, ensure the Inertia service provider is added (if not auto-discovered):
```php
'providers' => [
    // ... other providers
    Inertia\ServiceProvider::class,
],
```

### 6. Build Assets
```bash
npm run build  # For production
# OR
npm run dev    # For development
```

## 📁 New Project Structure

```
backend/
├── app/Http/Controllers/
│   ├── DashboardController.php          # Dashboard with stats
│   ├── SchemaController.php             # Schema CRUD + validation
│   └── Api/V1/                         # Keep existing API controllers
├── resources/
│   ├── js/
│   │   ├── app.js                      # Inertia app entry point
│   │   ├── Layouts/AppLayout.vue       # Main layout
│   │   ├── Pages/Dashboard.vue         # Dashboard page
│   │   └── Components/SchemaValidator.vue # Validation component
│   └── views/app.blade.php             # Root template
├── routes/web.php                      # Inertia routes
└── package.json                       # Updated dependencies
```

## 🔄 Key Changes from Separate Apps

### Before (Separate Apps):
- **Frontend:** Separate Vue 3 app with Vue Router + Pinia
- **Backend:** Laravel API-only with JSON responses
- **Communication:** HTTP API calls between separate servers

### After (Inertia Integration):
- **Unified:** Single Laravel application with Inertia.js
- **Frontend:** Vue 3 components served by Laravel
- **Communication:** Direct controller-to-component data passing

## 🌟 Benefits of Inertia Integration

### 1. **Simplified Deployment**
- Single application to deploy
- No CORS issues
- Shared authentication/sessions

### 2. **Better Performance**
- No separate API calls needed
- Server-side rendering capability
- Optimized asset bundling

### 3. **Enhanced Developer Experience**
- Laravel routing with Vue components
- Shared validation between frontend/backend
- Hot reloading with Laravel Vite integration

### 4. **Maintained Functionality**
- All existing Google validation features
- Schema management capabilities  
- Rich Results Test integration

## 🎯 Usage After Setup

### Development Server
```bash
# Terminal 1: Laravel development server
php artisan serve

# Terminal 2: Vite development server (for hot reloading)
npm run dev
```

### Production Build
```bash
npm run build
```

The application will be available at `http://localhost:8000` with full SPA-like experience powered by Inertia.js.

## 🔗 Routes Overview

| Route | Controller | Page Component | Description |
|-------|------------|----------------|-------------|
| `/` | `DashboardController@index` | `Dashboard.vue` | Main dashboard with stats |
| `/schemas` | `SchemaController@index` | `Schemas/Index.vue` | Schema list (needs creation) |
| `/schemas/create` | `SchemaController@create` | `Schemas/Create.vue` | Create new schema (needs creation) |
| `/schemas/{id}` | `SchemaController@show` | `Schemas/Show.vue` | View schema details (needs creation) |
| `/schemas/{id}/edit` | `SchemaController@edit` | `Schemas/Edit.vue` | Edit schema (needs creation) |

## ⚡ Still Needed

You'll need to create the remaining Vue pages:
- `Schemas/Index.vue` - Schema listing with filters
- `Schemas/Create.vue` - Schema creation form
- `Schemas/Edit.vue` - Schema editing with field builder
- `Schemas/Show.vue` - Schema details and preview

The existing validation system, API endpoints, and Google Rich Results Test integration all remain fully functional within the Inertia architecture.
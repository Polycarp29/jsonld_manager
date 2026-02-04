#!/bin/bash

echo "🚀 Setting up Inertia.js for JSON-LD Manager..."

# Navigate to backend directory
cd backend

echo "📦 Installing Inertia.js PHP package..."
composer require inertiajs/inertia-laravel

echo "🔧 Publishing Inertia middleware..."
php artisan inertia:middleware

echo "📦 Installing Node.js dependencies..."
npm install

echo "🔨 Building assets..."
npm run build

echo "✏️  Updating controllers to use Inertia..."

# Update SchemaController to use proper Inertia imports
sed -i 's|// use Inertia\\Inertia;|use Inertia\\Inertia;|g' app/Http/Controllers/SchemaController.php
sed -i 's|// TODO: Replace with Inertia::render after installation|// Inertia response|g' app/Http/Controllers/SchemaController.php
sed -i 's|return response()->json(\[|return Inertia::render(|g' app/Http/Controllers/SchemaController.php

# Update specific Inertia render calls
sed -i 's|return Inertia::render(\[|return Inertia::render("Schemas/Index", [|g' app/Http/Controllers/SchemaController.php

# Update DashboardController
sed -i 's|// use Inertia\\Inertia;|use Inertia\\Inertia;|g' app/Http/Controllers/DashboardController.php
sed -i 's|// TODO: Replace with Inertia::render after installation|// Inertia response|g' app/Http/Controllers/DashboardController.php
sed -i 's|return response()->json(\[|return Inertia::render("Dashboard", [|g' app/Http/Controllers/DashboardController.php

echo "⚙️  Add the Inertia middleware to app/Http/Kernel.php manually:"
echo "Add this line to the 'web' middleware group:"
echo "    \\App\\Http\\Middleware\\HandleInertiaRequests::class,"

echo ""
echo "🎉 Inertia.js setup complete!"
echo ""
echo "Next steps:"
echo "1. Add Inertia middleware to app/Http/Kernel.php (see instructions above)"
echo "2. Run: php artisan serve"
echo "3. Run: npm run dev (in another terminal)"
echo "4. Visit: http://localhost:8000"
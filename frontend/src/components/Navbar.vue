<template>
  <nav class="bg-white shadow-lg border-b border-gray-200">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center h-16">
        <!-- Brand/Logo -->
        <div class="flex items-center">
          <router-link to="/" class="text-xl font-bold text-blue-600 hover:text-blue-700">
            JSON-LD Manager
          </router-link>
        </div>

        <!-- Navigation Links -->
        <div class="flex space-x-8">
          <router-link
            to="/"
            class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-blue-600 font-semibold': $route.name === 'Home' }"
          >
            Dashboard
          </router-link>
          
          <router-link
            to="/schemas"
            class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-blue-600 font-semibold': $route.name?.includes('Schema') }"
          >
            Schemas
          </router-link>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-4">
          <router-link
            to="/schemas/create"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
          >
            + New Schema
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
// No additional setup needed for this component
</script>
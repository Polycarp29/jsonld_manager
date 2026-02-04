<template>
  <div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
      <h1 class="text-4xl font-bold text-gray-900 mb-4">JSON-LD Schema Manager</h1>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Manage and generate Schema.org JSON-LD structured data for your website pages
      </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-lg shadow p-6 border">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Schemas</h3>
        <p class="text-3xl font-bold text-blue-600">{{ schemaStore.schemas.length }}</p>
        <p class="text-sm text-gray-500 mt-1">Active schema configurations</p>
      </div>

      <div class="bg-white rounded-lg shadow p-6 border">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Schema Types</h3>
        <p class="text-3xl font-bold text-green-600">{{ schemaStore.schemaTypes.length }}</p>
        <p class="text-sm text-gray-500 mt-1">Available schema types</p>
      </div>

      <div class="bg-white rounded-lg shadow p-6 border">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Active Schemas</h3>
        <p class="text-3xl font-bold text-purple-600">{{ activeSchemas }}</p>
        <p class="text-sm text-gray-500 mt-1">Currently published</p>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-8 border">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <router-link
          to="/schemas/create"
          class="flex items-center p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors group"
        >
          <div class="text-center w-full">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Create New Schema</h3>
            <p class="text-sm text-gray-600">Build a new JSON-LD schema from scratch</p>
          </div>
        </router-link>

        <router-link
          to="/schemas"
          class="flex items-center p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-400 hover:bg-green-50 transition-colors group"
        >
          <div class="text-center w-full">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Manage Schemas</h3>
            <p class="text-sm text-gray-600">View and edit existing configurations</p>
          </div>
        </router-link>

        <div class="flex items-center p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-400 hover:bg-purple-50 transition-colors group cursor-pointer">
          <div class="text-center w-full">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">View Analytics</h3>
            <p class="text-sm text-gray-600">Monitor schema performance and usage</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Schemas -->
    <div class="bg-white rounded-lg shadow border" v-if="recentSchemas.length > 0">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Recent Schemas</h2>
      </div>
      
      <div class="p-6">
        <div class="space-y-4">
          <div
            v-for="schema in recentSchemas"
            :key="schema.id"
            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50"
          >
            <div class="flex items-center space-x-4">
              <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <span class="text-blue-600 font-semibold">{{ schema.schema_type.name.charAt(0) }}</span>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">{{ schema.name }}</h3>
                <p class="text-sm text-gray-600">{{ schema.schema_type.name }}</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-2">
              <span :class="schema.is_active ? 'text-green-600' : 'text-gray-400'" class="text-sm">
                {{ schema.is_active ? 'Active' : 'Inactive' }}
              </span>
              
              <router-link
                :to="`/schemas/${schema.id}/edit`"
                class="text-blue-600 hover:text-blue-700 text-sm font-medium"
              >
                Edit
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useSchemaStore } from '../stores/schemaStore'

const schemaStore = useSchemaStore()

const activeSchemas = computed(() => {
  return schemaStore.schemas.filter(schema => schema.is_active).length
})

const recentSchemas = computed(() => {
  return schemaStore.schemas
    .filter(schema => schema.schema_type) // Ensure schema_type is loaded
    .slice(0, 5) // Show only first 5
})

onMounted(async () => {
  try {
    await Promise.all([
      schemaStore.fetchSchemas(),
      schemaStore.fetchSchemaTypes()
    ])
  } catch (error) {
    console.error('Failed to load data:', error)
  }
})
</script>
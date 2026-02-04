import { defineStore } from 'pinia'
import axios from 'axios'

const API_BASE_URL = 'http://localhost:8000/api/v1'

export const useSchemaStore = defineStore('schema', {
  state: () => ({
    schemas: [],
    schemaTypes: [],
    currentSchema: null,
    isLoading: false,
    error: null
  }),

  getters: {
    getSchemaById: (state) => (id) => {
      return state.schemas.find(schema => schema.id === id)
    }
  },

  actions: {
    async fetchSchemas() {
      this.isLoading = true
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schemas`)
        this.schemas = response.data.data || response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to fetch schemas'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async fetchSchemaTypes() {
      this.isLoading = true
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schema-types`)
        this.schemaTypes = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to fetch schema types'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async fetchSchemaById(id) {
      this.isLoading = true
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schemas/${id}`)
        this.currentSchema = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to fetch schema'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async createSchema(schemaData) {
      this.isLoading = true
      this.error = null
      
      try {
        const response = await axios.post(`${API_BASE_URL}/schemas`, schemaData)
        this.schemas.push(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to create schema'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async updateSchema(id, schemaData) {
      this.isLoading = true
      this.error = null
      
      try {
        const response = await axios.put(`${API_BASE_URL}/schemas/${id}`, schemaData)
        const index = this.schemas.findIndex(schema => schema.id === id)
        if (index !== -1) {
          this.schemas[index] = response.data
        }
        this.currentSchema = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to update schema'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async deleteSchema(id) {
      this.isLoading = true
      this.error = null
      
      try {
        await axios.delete(`${API_BASE_URL}/schemas/${id}`)
        this.schemas = this.schemas.filter(schema => schema.id !== id)
        if (this.currentSchema?.id === id) {
          this.currentSchema = null
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to delete schema'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async bulkUpdateFields(schemaId, fields) {
      this.isLoading = true
      this.error = null
      
      try {
        const response = await axios.post(`${API_BASE_URL}/schemas/${schemaId}/fields/bulk`, {
          fields
        })
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to update schema fields'
        throw error
      } finally {
        this.isLoading = false
      }
    },

    async previewSchema(schemaId) {
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schemas/${schemaId}/preview`)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to preview schema'
        throw error
      }
    },

    async exportSchema(schemaId) {
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schemas/${schemaId}/export`, {
          responseType: 'blob'
        })
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to export schema'
        throw error
      }
    },

    async validateSchema(schemaId) {
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schemas/${schemaId}/validate`)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to validate schema'
        throw error
      }
    },

    async testSchemaWithGoogle(schemaId) {
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schemas/${schemaId}/test-google`)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to test schema with Google'
        throw error
      }
    },

    async getRequiredFields(schemaTypeId) {
      this.error = null
      
      try {
        const response = await axios.get(`${API_BASE_URL}/schema-types/${schemaTypeId}/required-fields`)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Failed to get required fields'
        throw error
      }
    }
  }
})
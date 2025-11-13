import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/api/axios'

export const useCategoryStore = defineStore('category', () => {
  const categories = ref([])
  const loading = ref(false)

  const fetchCategories = async () => {
    loading.value = true
    try {
      const response = await api.get('/categories')
      categories.value = response.data
    } catch (err) {
      console.error('Error al cargar categorías:', err)
    } finally {
      loading.value = false
    }
  }

  return {
    categories,
    loading,
    fetchCategories
  }
})
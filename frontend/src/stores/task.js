import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/api/axios'

export const useTaskStore = defineStore('task', () => {
  const tasks = ref([])
  const stats = ref(null)
  const loading = ref(false)
  const error = ref(null)

  const fetchTasks = async (filters = {}) => {
    loading.value = true
    error.value = null
    try {
      // Filter out empty values to avoid sending empty parameters
      const filteredFilters = Object.fromEntries(
        Object.entries(filters).filter(([key, value]) => value !== '' && value !== null && value !== undefined)
      )
      const params = new URLSearchParams(filteredFilters).toString()
      const url = params ? `/tasks?${params}` : '/tasks'
      const response = await api.get(url)
      tasks.value = response.data.data
      return response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al cargar tareas'
      return null
    } finally {
      loading.value = false
    }
  }

  const fetchStats = async () => {
    try {
      const response = await api.get('/tasks-stats')
      stats.value = response.data
    } catch (err) {
      console.error('Error al cargar estadísticas:', err)
    }
  }

  const createTask = async (taskData) => {
    loading.value = true
    error.value = null
    try {
      const response = await api.post('/tasks', taskData)
      tasks.value.unshift(response.data.task)
      await fetchStats()
      return response.data.task
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al crear tarea'
      return null
    } finally {
      loading.value = false
    }
  }

  const updateTask = async (taskId, taskData) => {
    loading.value = true
    error.value = null
    try {
      const response = await api.put(`/tasks/${taskId}`, taskData)
      const index = tasks.value.findIndex(t => t.id === taskId)
      if (index !== -1) {
        tasks.value[index] = response.data.task
      }
      await fetchStats()
      return response.data.task
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al actualizar tarea'
      return null
    } finally {
      loading.value = false
    }
  }

  const deleteTask = async (taskId) => {
    loading.value = true
    error.value = null
    try {
      await api.delete(`/tasks/${taskId}`)
      tasks.value = tasks.value.filter(t => t.id !== taskId)
      await fetchStats()
      return true
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al eliminar tarea'
      return false
    } finally {
      loading.value = false
    }
  }

  const completeTask = async (taskId) => {
    try {
      const response = await api.patch(`/tasks/${taskId}/complete`)
      const index = tasks.value.findIndex(t => t.id === taskId)
      if (index !== -1) {
        tasks.value[index] = response.data.task
      }
      await fetchStats()
      return response.data.task
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al completar tarea'
      return null
    }
  }

  const reopenTask = async (taskId) => {
    try {
      const response = await api.patch(`/tasks/${taskId}/reopen`)
      const index = tasks.value.findIndex(t => t.id === taskId)
      if (index !== -1) {
        tasks.value[index] = response.data.task
      }
      await fetchStats()
      return response.data.task
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al reabrir tarea'
      return null
    }
  }

  return {
    tasks,
    stats,
    loading,
    error,
    fetchTasks,
    fetchStats,
    createTask,
    updateTask,
    deleteTask,
    completeTask,
    reopenTask
  }
})
import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/api/axios'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('token') || null)
  const loading = ref(false)
  const error = ref(null)

  const isAuthenticated = () => !!token.value

  const login = async (credentials) => {
    loading.value = true
    error.value = null
    try {
      const response = await api.post('/login', credentials)
      token.value = response.data.access_token
      user.value = response.data.user
      localStorage.setItem('token', token.value)
      localStorage.setItem('user', JSON.stringify(user.value))
      return true
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al iniciar sesión'
      return false
    } finally {
      loading.value = false
    }
  }

  const register = async (userData) => {
    loading.value = true
    error.value = null
    try {
      const response = await api.post('/register', userData)
      token.value = response.data.access_token
      user.value = response.data.user
      localStorage.setItem('token', token.value)
      localStorage.setItem('user', JSON.stringify(user.value))
      return true
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al registrarse'
      return false
    } finally {
      loading.value = false
    }
  }

  const logout = async () => {
    try {
      await api.post('/logout')
    } catch (err) {
      console.error('Error al cerrar sesión:', err)
    } finally {
      token.value = null
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  const fetchUser = async () => {
    try {
      const response = await api.get('/me')
      user.value = response.data
      localStorage.setItem('user', JSON.stringify(user.value))
    } catch (err) {
      console.error('Error al obtener usuario:', err)
    }
  }

  // Cargar usuario del localStorage al iniciar
  const storedUser = localStorage.getItem('user')
  if (storedUser) {
    user.value = JSON.parse(storedUser)
  }

  return {
    user,
    token,
    loading,
    error,
    isAuthenticated,
    login,
    register,
    logout,
    fetchUser
  }
})
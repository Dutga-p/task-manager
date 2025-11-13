<template>
  <nav class="bg-gray-900 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex-shrink-0 flex items-center">
            <h1 class="text-2xl font-bold text-white">Task Manager</h1>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <router-link
              to="/"
              class="border-transparent text-gray-300 hover:border-gray-400 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              active-class="border-white text-white"
            >
              Dashboard
            </router-link>
            <router-link
              to="/tasks"
              class="border-transparent text-gray-300 hover:border-gray-400 hover:text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              active-class="border-white text-white"
            >
              Tareas
            </router-link>
          </div>
        </div>
        <div class="flex items-center">
          <div class="ml-3 relative">
            <div class="flex items-center space-x-4">
              <span class="text-sm text-gray-300">{{ authStore.user?.name }}</span>
              <button
                @click="handleLogout"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium transition cursor-pointer"
              >
                Cerrar Sesión
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const handleLogout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white p-8 rounded-lg shadow-2xl border border-gray-200 w-full max-w-md">
      <h1 class="text-3xl font-bold text-center mb-6 text-gray-900">Task Manager</h1>
      <h2 class="text-xl text-center mb-6 text-gray-600">Iniciar Sesión</h2>

      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input
            v-model="form.email"
            type="email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            placeholder="tu@email.com"
          />
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
          <input
            v-model="form.password"
            type="password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            placeholder="••••••••"
          />
        </div>

        <div v-if="authStore.error" class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded text-sm">
          {{ authStore.error }}
        </div>

        <button
          type="submit"
          :disabled="authStore.loading"
          class="w-full bg-slate-700 text-white py-2 rounded hover:bg-slate-800 transition disabled:opacity-50 font-medium"
        >
          {{ authStore.loading ? 'Cargando...' : 'Iniciar Sesión' }}
        </button>
      </form>

      <p class="text-center mt-6 text-gray-600">
        ¿No tienes cuenta?
        <router-link to="/register" class="text-blue-600 hover:text-blue-800 hover:underline">Regístrate</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const form = ref({
  email: '',
  password: ''
})

const handleLogin = async () => {
  const success = await authStore.login(form.value)
  if (success) {
    router.push('/')
  }
}
</script>
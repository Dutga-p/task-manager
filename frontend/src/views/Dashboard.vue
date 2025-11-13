<template>
  <div>
    <Navbar />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

      <TaskStats :stats="taskStore.stats" />

      <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-900">Resumen de Prioridades</h2>
        <div class="grid grid-cols-3 gap-4">
          <div class="text-center">
            <p class="text-3xl font-bold text-red-600">{{ taskStore.stats?.high_priority || 0 }}</p>
            <p class="text-sm text-gray-600">Alta</p>
          </div>
          <div class="text-center">
            <p class="text-3xl font-bold text-orange-600">{{ taskStore.stats?.medium_priority || 0 }}</p>
            <p class="text-sm text-gray-600">Media</p>
          </div>
          <div class="text-center">
            <p class="text-3xl font-bold text-slate-600">{{ taskStore.stats?.low_priority || 0 }}</p>
            <p class="text-sm text-gray-600">Baja</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
          <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Esta Semana
          </h2>
          <p class="text-4xl font-bold text-slate-700">{{ taskStore.stats?.this_week || 0 }}</p>
          <p class="text-gray-600">tareas programadas</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
          <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            Vencidas
          </h2>
          <p class="text-4xl font-bold text-red-600">{{ taskStore.stats?.overdue || 0 }}</p>
          <p class="text-gray-600">tareas atrasadas</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Navbar from '@/components/Navbar.vue'
import TaskStats from '@/components/TaskStats.vue'
import { useTaskStore } from '@/stores/task'

const taskStore = useTaskStore()

onMounted(() => {
  taskStore.fetchStats()
})
</script>
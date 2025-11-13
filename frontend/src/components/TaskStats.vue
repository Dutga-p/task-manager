<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-slate-600 rounded-md p-3">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <div class="ml-5">
          <p class="text-gray-500 text-sm">Total</p>
          <p class="text-2xl font-semibold text-gray-900">{{ stats?.total || 0 }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-amber-600 rounded-md p-3">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5">
          <p class="text-gray-500 text-sm">Pendientes</p>
          <p class="text-2xl font-semibold text-gray-900">{{ stats?.pending || 0 }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-indigo-600 rounded-md p-3">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
          </svg>
        </div>
        <div class="ml-5">
          <p class="text-gray-500 text-sm">En Progreso</p>
          <p class="text-2xl font-semibold text-gray-900">{{ stats?.in_progress || 0 }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-emerald-600 rounded-md p-3">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-5">
          <p class="text-gray-500 text-sm">Completadas</p>
          <p class="text-2xl font-semibold text-gray-900">{{ stats?.completed || 0 }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  stats: Object
})
</script>

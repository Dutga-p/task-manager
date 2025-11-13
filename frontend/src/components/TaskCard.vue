<template>
  <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 hover:shadow-xl transition">
    <div class="flex justify-between items-start mb-3">
      <h3 class="text-lg font-semibold text-gray-900">{{ task.title }}</h3>
      <div class="flex space-x-2">
        <button
          @click="$emit('edit', task)"
          class="text-gray-600 hover:text-gray-800 p-1 cursor-pointer"
          title="Editar"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
          </svg>
        </button>
        <button
          @click="$emit('delete', task)"
          class="text-red-600 hover:text-red-800 p-1 cursor-pointer"
          title="Eliminar"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
        </button>
      </div>
    </div>

    <p v-if="task.description" class="text-gray-600 text-sm mb-3">
      {{ task.description }}
    </p>

    <div class="flex flex-wrap gap-2 mb-3">
      <span
        :class="{
          'bg-amber-100 text-amber-800 border border-amber-200': task.status === 'pending',
          'bg-indigo-100 text-indigo-800 border border-indigo-200': task.status === 'in_progress',
          'bg-emerald-100 text-emerald-800 border border-emerald-200': task.status === 'completed'
        }"
        class="px-2 py-1 rounded text-xs font-medium"
      >
        {{ statusLabel(task.status) }}
      </span>

      <span
        :class="{
          'bg-red-100 text-red-800 border border-red-200': task.priority === 'high',
          'bg-orange-100 text-orange-800 border border-orange-200': task.priority === 'medium',
          'bg-slate-100 text-slate-800 border border-slate-200': task.priority === 'low'
        }"
        class="px-2 py-1 rounded text-xs font-medium"
      >
        {{ priorityLabel(task.priority) }}
      </span>

      <span
        v-if="task.category"
        :style="{ backgroundColor: task.category.color + '20', color: task.category.color, borderColor: task.category.color + '40' }"
        class="px-2 py-1 rounded text-xs font-medium border"
      >
        {{ task.category.icon }} {{ task.category.name }}
      </span>
    </div>

    <div class="flex justify-between items-center">
      <span v-if="task.due_date" class="text-xs text-gray-500 flex items-center">
        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        {{ formatDate(task.due_date) }}
      </span>
      <button
        v-if="task.status !== 'completed'"
        @click="$emit('complete', task.id)"
        class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-xs font-medium cursor-pointer"
      >
        Completar
      </button>
      <button
        v-else
        @click="$emit('reopen', task.id)"
        class="bg-slate-600 hover:bg-slate-700 text-white px-3 py-1 rounded text-xs font-medium cursor-pointer"
      >
        Reabrir
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  task: Object
})

defineEmits(['edit', 'delete', 'complete', 'reopen'])

const statusLabel = (status) => {
  const labels = {
    pending: 'Pendiente',
    in_progress: 'En Progreso',
    completed: 'Completada'
  }
  return labels[status] || status
}

const priorityLabel = (priority) => {
  const labels = {
    low: 'Baja',
    medium: 'Media',
    high: 'Alta'
  }
  return labels[priority] || priority
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}
</script>

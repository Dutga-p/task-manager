<template>
  <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50" @click.self="$emit('close')">
    <div class="bg-white rounded-lg shadow-2xl border border-gray-200 p-6 w-full max-w-md">
      <h2 class="text-2xl font-bold mb-4 text-gray-900">{{ isEdit ? 'Editar Tarea' : 'Nueva Tarea' }}</h2>

      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
          <input
            v-model="form.title"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
          <textarea
            v-model="form.description"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
          ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select
              v-model="form.status"
              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            >
              <option value="pending">Pendiente</option>
              <option value="in_progress">En Progreso</option>
              <option value="completed">Completada</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
            <select
              v-model="form.priority"
              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            >
              <option value="low">Baja</option>
              <option value="medium">Media</option>
              <option value="high">Alta</option>
            </select>
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
          <select
            v-model="form.category_id"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
          >
            <option :value="null">Sin categoría</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
              {{ cat.icon }} {{ cat.name }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de vencimiento</label>
          <input
            v-model="form.due_date"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
          />
        </div>

        <div class="flex justify-end space-x-3">
          <button
            type="button"
            @click="$emit('close')"
            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 font-medium cursor-pointer"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="px-4 py-2 text-white bg-slate-700 rounded hover:bg-slate-800 font-medium cursor-pointer"
          >
            {{ isEdit ? 'Actualizar' : 'Crear' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  task: Object,
  categories: Array
})

const emit = defineEmits(['close', 'submit'])

const isEdit = ref(!!props.task)

const form = ref({
  title: '',
  description: '',
  status: 'pending',
  priority: 'medium',
  category_id: null,
  due_date: ''
})

watch(() => props.task, (newTask) => {
  if (newTask) {
    form.value = { ...newTask, category_id: newTask.category?.id || null }
  }
}, { immediate: true })

const handleSubmit = () => {
  emit('submit', form.value)
}
</script>
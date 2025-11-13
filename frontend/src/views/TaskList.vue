<template>
  <div>
    <Navbar />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Mis Tareas</h1>
        <button
          @click="showModal = true"
          class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-2 rounded font-medium flex items-center cursor-pointer"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Nueva Tarea
        </button>
      </div>

      <TaskStats :stats="taskStore.stats" />

      <!-- Filtros -->
      <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Buscar tareas..."
              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select
              v-model="filters.status"
              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            >
              <option value="">Todos</option>
              <option value="pending">Pendiente</option>
              <option value="in_progress">En Progreso</option>
              <option value="completed">Completada</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
            <select
              v-model="filters.priority"
              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            >
              <option value="">Todas</option>
              <option value="high">Alta</option>
              <option value="medium">Media</option>
              <option value="low">Baja</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
            <select
              v-model="filters.category_id"
              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
            >
              <option value="">Todas</option>
              <option v-for="cat in categoryStore.categories" :key="cat.id" :value="cat.id">
                {{ cat.icon }} {{ cat.name }}
              </option>
            </select>
          </div>
        </div>

        <div class="mt-4 flex justify-end">
          <button
            @click="resetFilters"
            class="text-sm text-slate-600 hover:text-slate-800 font-medium cursor-pointer"
          >
            Limpiar filtros
          </button>
        </div>
      </div>

      <!-- Lista de Tareas -->
      <div v-if="taskStore.loading" class="text-center py-12">
        <p class="text-gray-500">Cargando tareas...</p>
      </div>

      <div v-else-if="taskStore.tasks.length === 0" class="text-center py-12 bg-white rounded-lg shadow-lg border border-gray-200">
        <p class="text-gray-500 text-lg">No hay tareas para mostrar</p>
        <button
          @click="showModal = true"
          class="mt-4 text-slate-600 hover:text-slate-800 font-medium cursor-pointer"
        >
          Crear tu primera tarea
        </button>
      </div>

      <!-- Kanban Board -->
      <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pending Column -->
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <div class="w-3 h-3 bg-amber-500 rounded-full mr-2"></div>
            Pendientes ({{ pendingTasks.length }})
          </h3>
          <VueDraggableNext 
            :list="pendingTasks"
            group="tasks"
            @change="(event) => onDragChange(event, 'pending')"
            class="space-y-3 min-h-[200px]"
          >
            <TaskCard
              v-for="task in pendingTasks"
              :key="task.id"
              :task="task"
              @edit="editTask"
              @delete="deleteTask"
              @complete="completeTask"
              @reopen="reopenTask"
            />
          </VueDraggableNext >
        </div>

        <!-- In Progress Column -->
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <div class="w-3 h-3 bg-indigo-500 rounded-full mr-2"></div>
            En Progreso ({{ inProgressTasks.length }})
          </h3>
          <VueDraggableNext 
            :list="inProgressTasks"
            group="tasks"
            @change="(event) => onDragChange(event, 'in_progress')"
            class="space-y-3 min-h-[200px]"
          >
            <TaskCard
              v-for="task in inProgressTasks"
              :key="task.id"
              :task="task"
              @edit="editTask"
              @delete="deleteTask"
              @complete="completeTask"
              @reopen="reopenTask"
            />
          </VueDraggableNext >
        </div>

        <!-- Completed Column -->
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <div class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></div>
            Completadas ({{ completedTasks.length }})
          </h3>
          <VueDraggableNext 
            :list="completedTasks"
            group="tasks"
            @change="(event) => onDragChange(event, 'completed')"
            class="space-y-3 min-h-[200px]"
          >
            <TaskCard
              v-for="task in completedTasks"
              :key="task.id"
              :task="task"
              @edit="editTask"
              @delete="deleteTask"
              @complete="completeTask"
              @reopen="reopenTask"
            />
          </VueDraggableNext >
        </div>
      </div>

      <!-- Modal -->
      <TaskForm
        v-if="showModal"
        :task="selectedTask"
        :categories="categoryStore.categories"
        @close="closeModal"
        @submit="handleSubmit"
      />

      <!-- Delete Confirmation Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50" @click.self="closeDeleteModal">
        <div class="bg-white rounded-lg shadow-2xl border border-gray-200 p-6 w-full max-w-md">
          <h2 class="text-2xl font-bold mb-4 text-gray-900">Eliminar Tarea</h2>
          <p class="text-gray-600 mb-6">
            ¿Estás seguro de que deseas eliminar la tarea "<strong>{{ taskToDelete.title }}</strong>"? Esta acción no se puede deshacer.
          </p>
          <div class="flex justify-end space-x-3">
            <button
              @click="closeDeleteModal"
              class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 font-medium cursor-pointer"
            >
              Cancelar
            </button>
            <button
              @click="confirmDelete"
              class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 font-medium cursor-pointer"
            >
              Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useTaskStore } from '@/stores/task'
import { useCategoryStore } from '@/stores/category'
import Navbar from '@/components/Navbar.vue'
import TaskStats from '@/components/TaskStats.vue'
import TaskCard from '@/components/TaskCard.vue'
import TaskForm from '@/components/TaskForm.vue'
import { VueDraggableNext } from 'vue-draggable-next'

const taskStore = useTaskStore()
const categoryStore = useCategoryStore()

const showModal = ref(false)
const selectedTask = ref(null)
const showDeleteModal = ref(false)
const taskToDelete = ref(null)

const filters = ref({
  search: '',
  status: '',
  priority: '',
  category_id: ''
})

onMounted(() => {
  loadData()
})

watch(filters, () => {
  loadData()
}, { deep: true })

const loadData = async () => {
  await taskStore.fetchTasks(filters.value)
  await taskStore.fetchStats()
  await categoryStore.fetchCategories()
}

const resetFilters = () => {
  filters.value = {
    search: '',
    status: '',
    priority: '',
    category_id: ''
  }
}

const editTask = (task) => {
  selectedTask.value = task
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedTask.value = null
}

const handleSubmit = async (formData) => {
  if (selectedTask.value) {
    await taskStore.updateTask(selectedTask.value.id, formData)
  } else {
    await taskStore.createTask(formData)
  }
  closeModal()
  loadData()
}

const deleteTask = async (task) => {
  showDeleteModal.value = true
  taskToDelete.value = task
}

const completeTask = async (taskId) => {
  await taskStore.completeTask(taskId)
}

const reopenTask = async (taskId) => {
  await taskStore.reopenTask(taskId)
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  taskToDelete.value = null
}

const confirmDelete = async () => {
  if (taskToDelete.value) {
    await taskStore.deleteTask(taskToDelete.value.id)
    closeDeleteModal()
    loadData()
  }
}

// Computed properties for filtered tasks
const pendingTasks = computed(() => taskStore.tasks.filter(task => task.status === 'pending'))
const inProgressTasks = computed(() => taskStore.tasks.filter(task => task.status === 'in_progress'))
const completedTasks = computed(() => taskStore.tasks.filter(task => task.status === 'completed'))

// Handle drag and drop changes
const onDragChange = async (event, targetColumn) => {
  if (event.added || event.moved) {
    const task = event.added ? event.added.element : event.moved.element

    if (task.status !== targetColumn) {
      try {
        await taskStore.updateTask(task.id, { status: targetColumn })
        await taskStore.fetchStats()
      } catch (error) {
        console.error('Error updating task status:', error)
        // Reload data to revert changes on error
        loadData()
      }
    }
  }
}
</script>

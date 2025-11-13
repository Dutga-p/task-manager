<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Listar todas las tareas con filtros
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Task::with(['user', 'category', 'assignedUser']);

        // Filtro: Solo tareas del usuario autenticado
        $query->where('user_id', Auth::id());

        // Filtro: Por estado
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtro: Por prioridad
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filtro: Por categoría
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtro: Por usuario asignado
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro: Fecha de vencimiento
        if ($request->has('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        // Filtro: Tareas vencidas
        if ($request->has('overdue') && $request->overdue == 'true') {
            $query->where('due_date', '<', now())
                ->where('status', '!=', 'completed');
        }

        // Ordenar
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 15);
        $tasks = $query->paginate($perPage);

        return response()->json($tasks);
    }

    /**
     * Crear nueva tarea
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'priority' => 'nullable|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date|after_or_equal:today',
        ], [
            'title.required' => 'El título es obligatorio',
            'title.max' => 'El título no puede exceder 255 caracteres',
            'status.in' => 'El estado debe ser: pending, in_progress o completed',
            'priority.in' => 'La prioridad debe ser: low, medium o high',
            'category_id.exists' => 'La categoría seleccionada no existe',
            'assigned_to.exists' => 'El usuario asignado no existe',
            'due_date.date' => 'La fecha de vencimiento debe ser válida',
            'due_date.after_or_equal' => 'La fecha de vencimiento no puede ser en el pasado',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'priority' => $request->priority ?? 'medium',
            'category_id' => $request->category_id,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Tarea creada exitosamente',
            'task' => $task->load(['user', 'category', 'assignedUser'])
        ], 201);
    }

    /**
     * Mostrar una tarea específica
     * 
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        // Verificar que la tarea pertenece al usuario
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para ver esta tarea'
            ], 403);
        }

        return response()->json($task->load(['user', 'category', 'assignedUser']));
    }

    /**
     * Actualizar una tarea
     * 
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task)
    {
        // Verificar que la tarea pertenece al usuario
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para editar esta tarea'
            ], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'priority' => 'sometimes|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ], [
            'title.max' => 'El título no puede exceder 255 caracteres',
            'status.in' => 'El estado debe ser: pending, in_progress o completed',
            'priority.in' => 'La prioridad debe ser: low, medium o high',
            'category_id.exists' => 'La categoría seleccionada no existe',
            'assigned_to.exists' => 'El usuario asignado no existe',
            'due_date.date' => 'La fecha de vencimiento debe ser válida',
        ]);

        // Si cambia a completada, registrar fecha
        if ($request->has('status') && $request->status === 'completed' && $task->status !== 'completed') {
            $task->completed_at = now();
        } elseif ($request->has('status') && $request->status !== 'completed') {
            $task->completed_at = null;
        }

        $task->update($request->only([
            'title',
            'description',
            'status',
            'priority',
            'category_id',
            'assigned_to',
            'due_date',
        ]));

        return response()->json([
            'message' => 'Tarea actualizada exitosamente',
            'task' => $task->load(['user', 'category', 'assignedUser'])
        ]);
    }

    /**
     * Eliminar una tarea
     * 
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        // Verificar que la tarea pertenece al usuario
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar esta tarea'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Tarea eliminada correctamente',
        ]);
    }

    /**
     * Obtener estadísticas de tareas del usuario
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        $userId = Auth::id();

        $stats = [
            'total' => Task::where('user_id', $userId)->count(),
            'pending' => Task::where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
            'in_progress' => Task::where('user_id', $userId)
                ->where('status', 'in_progress')
                ->count(),
            'completed' => Task::where('user_id', $userId)
                ->where('status', 'completed')
                ->count(),
            'high_priority' => Task::where('user_id', $userId)
                ->where('priority', 'high')
                ->count(),
            'medium_priority' => Task::where('user_id', $userId)
                ->where('priority', 'medium')
                ->count(),
            'low_priority' => Task::where('user_id', $userId)
                ->where('priority', 'low')
                ->count(),
            'overdue' => Task::where('user_id', $userId)
                ->where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
            'today' => Task::where('user_id', $userId)
                ->whereDate('due_date', now())
                ->count(),
            'this_week' => Task::where('user_id', $userId)
                ->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Marcar tarea como completada
     * 
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para completar esta tarea'
            ], 403);
        }

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Tarea marcada como completada',
            'task' => $task->load(['user', 'category', 'assignedUser'])
        ]);
    }

    /**
     * Reabrir tarea completada
     * 
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function reopen(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para reabrir esta tarea'
            ], 403);
        }

        $task->update([
            'status' => 'pending',
            'completed_at' => null,
        ]);

        return response()->json([
            'message' => 'Tarea reabierta',
            'task' => $task->load(['user', 'category', 'assignedUser'])
        ]);
    }
}

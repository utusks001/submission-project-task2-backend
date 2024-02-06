<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService {
	private TaskRepository $taskRepository;

	public function __construct() {
		$this->taskRepository = new TaskRepository();
	}

	/**
	 * NOTE: untuk mengambil semua tasks di collection task
	 */
	public function getTasks()
	{
		$tasks = $this->taskRepository->getAll();
		return $tasks;
	}

	/**
	 * NOTE: menambahkan task
	 */
	public function addTask(array $data)
	{
		$taskId = $this->taskRepository->create($data);
		return $taskId;
	}

	/**
	 * NOTE: UNTUK mengambil data task
	 */
	public function getById(string $taskId)
	{
		$task = $this->taskRepository->getById($taskId);
		return $task;
	}

	/**
	 * NOTE: untuk update task
	 */
	public function updateTask(array $editTask, array $formData)
	{
		if(isset($formData['title']))
		{
			$editTask['title'] = $formData['title'];
		}

		if(isset($formData['description']))
		{
			$editTask['description'] = $formData['description'];
		}

		$id = $this->taskRepository->save( $editTask);
		return $id;
	}

	public function deleteTask(string $taskId)
	{
		$this->taskRepository->delete($taskId);
	}

	public function assignTask(array $editTask, string $assigned = null)
	{
		$editTask['assigned'] = $assigned;

		$id = $this->taskRepository->save( $editTask);
		return $id;
	}

	public function createSubtask(array $editTask, array $subtask)
	{
		if(isset($subtask))
		{
			$editTask['subtasks'][] = $subtask;
		}

		$id = $this->taskRepository->save( $editTask);
		return $id;
	}

	public function deleteSubtask(array $editTask, string $subtaskId)
	{
		if(isset($subtaskId))
		{
			$editTask['subtasks'] = array_filter($editTask['subtasks'], function($subtask) use($subtaskId) {
				if($subtask['_id'] == $subtaskId)
				{
					return false;
				} else {
					return true;
				}
			});
		}

		$id = $this->taskRepository->save( $editTask);
		return $id;
	}
}

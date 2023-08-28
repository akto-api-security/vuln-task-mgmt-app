<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Task;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class TaskProcedure extends Procedure
{
    /**
     * The name of the procedure that is used for referencing.
     *
     * @var string
     */
    public static string $name = 'task';

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function list(Request $request)
    {
        return Task::all();
    }

    public function create(Request $request)
    {
        return Task::create($request->all());
    }

    public function update(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->update($request->all());
        return $task;
    }

    public function delete(Request $request)
    {
        $task = Task::findOrFail($request->id);
        return $task->delete();
    }

    public function get(Request $request)
    {
        return Task::findOrFail($request->id);
    }

}

<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Tasks;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateTask',
        'description' => 'A mutation for updating a task'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'done' => [
                'name' => 'done',
                'type' => Type::nonNull(Type::boolean()),
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $task = \App\Models\Task::findOrFail($args['id']);
        $task->update($args);
        return $task;
    }
}

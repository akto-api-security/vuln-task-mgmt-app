<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Tasks;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeleteTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteTask',
        'description' => 'A mutation for deleting a Task'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the Task' 
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $task = \App\Models\Task::findOrFail($args['id']);
        return $task->delete();
    }
}

<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Task; 
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Task',
        'description' => 'A to-do item on the to-do list.',
        'model' => Task::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The auto-incremented id of the task'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of task'
            ],
            'done' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'The status of task'
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The date the task was created'
            ],
        ];
    }
}

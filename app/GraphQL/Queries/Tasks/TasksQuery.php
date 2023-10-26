<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Tasks;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TasksQuery extends Query
{
    protected $attributes = [
        'name' => 'tasks',
        'description' => 'A query to fetch all tasks'
    ];

    public function type(): Type
    {
        // return tasks not paginated
        return Type::listOf(GraphQL::type('Task'));
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'name'=> [
                'name' => 'name',
                'type' => Type::string(),
            ]

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $tasks = \App\Models\Task::with($with)->select($select)->paginate(1000, ['*'], 'page', 1);

        return $tasks;

    }
}

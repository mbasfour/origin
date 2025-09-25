<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::TODO->value => __('To Do'),
            self::IN_PROGRESS->value => __('In Progress'),
            self::DONE->value => __('Done'),
        ];
    }

    public static function label(string $value): string
    {
        return self::labels()[$value] ?? $value;
    }
}
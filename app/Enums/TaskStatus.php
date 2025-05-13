<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskStatus: string implements HasColor, HasLabel
{
    case TODO = 'To Do';
    case IN_PROGRESS = 'In Progress';
    case IN_REVIEW = 'In Review';
    case COMPLETED = 'Completed';
    
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::TODO => 'blue',
            self::IN_PROGRESS => 'yellow',
            self::IN_REVIEW => 'orange',
            self::COMPLETED => 'green',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TODO => __('To Do'),
            self::IN_PROGRESS => __('In Progress'),
            self::IN_REVIEW => __('In Review'),
            self::COMPLETED => __('Completed'),
        };
    }

    public static function getColumns(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->getLabel()])
            ->all();
    }

    public static function getColumnColors(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->getColor()])
            ->all();
    }
}

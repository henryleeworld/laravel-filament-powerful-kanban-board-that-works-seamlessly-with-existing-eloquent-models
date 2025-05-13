<?php

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\Flowforge\Filament\Pages\KanbanBoardPage;

class TasksBoardBoardPage extends KanbanBoardPage
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationLabel = 'Task Board';
    protected static ?string $title = 'Task Board';

    public function getHeading(): string
    {
        return __('Task Board');
    }

    public static function getNavigationLabel(): string
    {
        return __('Task Board');
    }

    public function getSubject(): Builder
    {
        return Task::query();
    }

    public function mount(): void
    {
        $this
            ->titleField('title')
            ->orderField('sort_order')
            ->columnField('status')
            ->columns(TaskStatus::getColumns())
            ->columnColors(TaskStatus::getColumnColors())
            ->pluralCardLabel(__('tasks'))
            ->cardAttributes([
                'due_date' => __('Due date'),
            ])
            ->cardAttributeColors([
                 'due_date' => 'red',
            ])
            ->cardAttributeIcons([
                 'due_date' => 'heroicon-o-calendar',
            ]);
    }

    public function createAction(Action $action): Action
    {
        return $action
            ->iconButton()
            ->icon('heroicon-o-plus')
            ->modalHeading(__('Create Task'))
            ->modalWidth('xl')
            ->form(function (Forms\Form $form) {
                return $form->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('Title'))
                        ->placeholder(__('Enter task title'))
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label(__('Description'))
                        ->columnSpanFull(),
                    Forms\Components\DatePicker::make('due_date')
                        ->label(__('Due date')),
                ]);
            });
    }

    public function editAction(Action $action): Action
    {
        return $action
            ->modalHeading(__('Edit Task'))
            ->modalWidth('xl')
            ->form(function (Forms\Form $form) {
                return $form->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('Title'))
                        ->placeholder(__('Enter task title'))
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label(__('Description'))
                        ->columnSpanFull(),
                    Forms\Components\Select::make('status')
                        ->label(__('Status'))
                        ->options(TaskStatus::getColumns())
                        ->required(),
                    Forms\Components\DatePicker::make('due_date')
                        ->label(__('Due date')),
                ]);
            });
    }
}

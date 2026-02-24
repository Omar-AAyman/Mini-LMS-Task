<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\LessonProgress;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;

class EnrolledUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Enrolled Students';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Enrolled')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress_percent')
                    ->label('Progress')
                    ->suffix('%')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 100 => 'success',
                        $state >= 50  => 'warning',
                        default       => 'gray',
                    })
                    ->getStateUsing(function ($record): int {
                        $course = $this->getOwnerRecord();
                        $total  = $course->lessons()->count();
                        if ($total === 0) return 0;

                        $completed = LessonProgress::where('user_id', $record->user_id)
                            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
                            ->whereNotNull('completed_at')
                            ->count();

                        return (int) round(($completed / $total) * 100);
                    }),
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}

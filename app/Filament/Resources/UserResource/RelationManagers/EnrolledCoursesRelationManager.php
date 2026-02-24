<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\LessonProgress;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;

class EnrolledCoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Enrolled Courses';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.level.name')
                    ->label('Level')
                    ->badge(),
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
                        $course = $record->course;
                        $total  = $course->lessons()->count();
                        if ($total === 0) return 0;

                        $user = $this->getOwnerRecord();

                        $completed = LessonProgress::where('user_id', $user->id)
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

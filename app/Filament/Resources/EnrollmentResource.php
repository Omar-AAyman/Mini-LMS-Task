<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Learning';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
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
                        $state >= 50 => 'warning',
                        default => 'gray',
                    })
                    ->getStateUsing(function (Enrollment $record): int {
                        $total = $record->course->lessons()->count();
                        if ($total === 0) {
                            return 0;
                        }

                        $completed = LessonProgress::where('user_id', $record->user_id)
                            ->whereIn('lesson_id', $record->course->lessons()->pluck('id'))
                            ->whereNotNull('completed_at')
                            ->count();

                        return (int) round(($completed / $total) * 100);
                    }),
            ])
            ->defaultSort('enrolled_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('course', 'title'),
                Tables\Filters\Filter::make('enrolled_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('enrolled_from'),
                        \Filament\Forms\Components\DatePicker::make('enrolled_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['enrolled_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('enrolled_at', '>=', $date),
                            )
                            ->when(
                                $data['enrolled_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('enrolled_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

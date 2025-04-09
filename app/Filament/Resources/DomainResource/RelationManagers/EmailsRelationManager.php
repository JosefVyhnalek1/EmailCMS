<?php

namespace App\Filament\Resources\DomainResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Rawilk\FilamentPasswordInput\Password;

use App\Models\Domain;
use App\Models\Email;


class EmailsRelationManager extends RelationManager
{


    protected static string $relationship = 'emails';



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('forwarding_email')
                    ->label('Forwarding Email')
                    ->maxLength(255),


                Password::make('password')
                    ->label('Password')
                ->regeneratePassword(),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('forwardings.destination')
                ->label('Forwarding email')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (\App\Models\Email $record, array $data) {
                        if (!empty($data['forwarding_email'])) {
                            \App\Models\Forwarding::create([
                                'source' => $record->email,
                                'destination' => $data['forwarding_email'],
                                'domain_id' => $record->domain_id,
                            ]);
                        }
                    }),
            ])
            ->actions([
            ])
            ->bulkActions([

            ]);
    }
}

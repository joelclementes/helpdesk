<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(125),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(125),
                Forms\Components\Select::make('area_id')
                    ->label('Área de informática')
                    ->relationship('area', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('roles')
                    ->label('Rol')
                    ->relationship('roles', 'name') // usa la relación del trait HasRoles
                    ->multiple()        // necesario para belongsToMany
                    ->minItems(1)
                    ->maxItems(1)       // fuerza un solo rol
                    ->preload()
                    ->searchable()
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->revealable()
                    // Requerida solo al crear:
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                    // ✅ Reglas correctas: usar ->rules([...]) y separar reglas
                    ->rules(fn($livewire) => $livewire instanceof Pages\CreateUser
                        ? ['required', 'min:8', 'confirmed']
                        : ['nullable', 'min:8', 'confirmed'])
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrateStateUsing(fn($state) => $state)
                    ->validationMessages([
                        'min'        => 'La contraseña debe tener al menos :min caracteres.',
                        'confirmed'  => 'Las contraseñas no coinciden.',
                        'required'   => 'La contraseña es obligatoria.',
                        'same'       => 'Las contraseñas deben coincidir.',
                    ]),


                // Confirmación (sólo en crear; en editar es opcional)
                Forms\Components\TextInput::make('password_confirmation')
                    ->label('Confirmar contraseña')
                    ->password()
                    ->revealable()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                    ->same('password')
                    ->dehydrated(false), // nunca guardar este campo
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()          // muestra como badge
                    ->separator(', ')  // por si hubiera más de uno
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('area.name')   // ← relación.nombre
                    ->label('Área de informática')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

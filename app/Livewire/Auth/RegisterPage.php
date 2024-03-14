<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Testing\Fluent\Concerns\Interaction;
use Filament\Notifications\Notification;
use Livewire\Component;
use Filament\Forms\Components\DatePicker;
use Illuminate\Validation\Rules\Password;

class RegisterPage extends Component implements HasForms
{
    use InteractsWithForms;

    public $name = '';
    public $email = '';
    public $password = '';
    public $no_telepon = '';
    public $image = '';


    public function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->required(),
            TextInput::make('password')
                ->password()
                ->dehydrated(fn ($state) => filled($state))
                ->maxLength(255)
                ->required(),
            TextInput::make('no_telepon')
                ->required()
                ->numeric()
                ->maxLength(255),
            FileUpload::make('image')
                ->directory('users')

        ]);
    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function save():void
    {
        dd($this->form->getState());
    }
}

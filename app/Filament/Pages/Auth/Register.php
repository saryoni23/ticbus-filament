<?php

namespace App\Filament\Pages\Auth;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getno_teleponComponent(),
                        // $this->getRoleFormComponent(),
                        // $this->getimageComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    // protected function getRoleFormComponent(): Component
    // {
    //     // return Select::make('role')
    //     //     ->options([
    //     //         'buyer' => 'Buyer',
    //     //         'seller' => 'Seller',
    //     //     ])
    //     //     ->default('buyer')
    //     //     ->required();
    // }
    protected function getno_teleponComponent(): Component
    {
        return TextInput::make('no_telepon')
            ->numeric()
            ->required();
    }
    // protected function getimageComponent(): Component
    // {
    //     return FileUpload::make('image')
    //         ->directory('users')
    //         ->columnSpanFull();
    // }
}

<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasUser;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProfileInformationComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use HasSort;
    use HasUser;


    public ?array $data = [];

    public $userClass;


    protected static int $sort = 0;

    public function mount(): void
    {
        $this->user      = $this->getUser();
        $this->userClass = get_class($this->user);
        $this->form->fill($this->user->only('avatar_url', 'name', 'email', 'dob', 'gender' , 'certificates'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('filament-edit-profile::default.profile_information'))
                       ->aside()
                       ->description(__('filament-edit-profile::default.profile_information_description'))
                       ->schema([
                           FileUpload::make('avatar_url')
                                     ->label(__('filament-edit-profile::default.avatar'))
                                     ->avatar()
                                     ->imageEditor()
                                     ->directory(filament('filament-edit-profile')->getAvatarDirectory())
                                     ->rules(filament('filament-edit-profile')->getAvatarRules())
                                     ->hidden(!filament('filament-edit-profile')->getShouldShowAvatarForm()),
                           TextInput::make('name')
                                    ->label(__('filament-edit-profile::default.name'))
                                    ->required(),
                           TextInput::make('email')
                                    ->label(__('filament-edit-profile::default.email'))
                                    ->email()
                                    ->required()
                                    ->unique($this->userClass, ignorable: $this->user),
                       ]),
            ])
            ->statePath('data');
    }

    public function updateProfile(): void
    {
        try {
            $data = $this->form->getState();

            $this->user->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
                    ->success()
                    ->title(__('filament-edit-profile::default.saved_successfully'))
                    ->send();
    }

    public function save(): void
    {
        $data = $this->form->getState();
    }

    public function render(): View
    {
        return view('livewire.additional-profile-information-component');
    }
}

<?php

namespace App\Providers\Filament;


use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Livewire\ProfileInformationComponent;
use App\Models\User;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class MainPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('leave')
            ->path('/')
            ->login()
            ->registration()
            ->darkMode(false)
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Teal,
            ])
            ->resources([
                UserResource::class,
                RoleResource::class,
                PermissionResource::class,
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentDeveloperLoginsPlugin::make()
                                             ->users([
                                                 'Demo User'  => !app()->runningInConsole() ? User::where('id', '!=', 1)->first()?->email : null,
                                                 'Demo Admin' => 'admin@admin.com',
                                             ])
                                             ->switchable(false)
                                             ->enabled(app()->environment('local')),
                FilamentEditProfilePlugin::make()
                                         ->setTitle('My Profile')
                                         ->setNavigationLabel('My Profile')
                                         ->setIcon('heroicon-o-user')
                                         ->shouldShowEditProfileForm(false)
                                         ->customProfileComponents([
                                             ProfileInformationComponent::class,
                                         ]),
                FilamentFullCalendarPlugin::make()
                                          ->selectable(),
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                                     ->label(fn() => auth()->user()->name)
                                     ->url(fn(): string => EditProfilePage::getUrl())
                                     ->icon('heroicon-m-user-circle')
                                     ->visible(function (): bool {
                                         return auth()->check();
                                     }),
            ]);
    }
}

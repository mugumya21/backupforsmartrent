<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\File;
use ReflectionClass;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bootstrapInterfaces( 'Accounts');
        $this->bootstrapInterfaces( 'CRM');
        $this->bootstrapInterfaces( 'HR');
        $this->bootstrapInterfaces( 'Admin');
        $this->bootstrapInterfaces( 'Rent');
        $this->bootstrapInterfaces( 'Main');
        $this->bootstrapInterfaces( 'Reports');

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public function bootstrapInterfaces( $folderName)
    {
        foreach (File::files(app_path("Services/{$folderName}")) as $file) {
            $fileName = $file->getBasename('.php');
            $oReflectionClass = new ReflectionClass('App\Services\\'. $folderName .'\\' . $fileName);
            if (!$oReflectionClass->isInterface()) {
                $interfaceName = $oReflectionClass->getInterfaceNames()[0];

                $this->app->bind(
                    "{$interfaceName}",
                    "{$oReflectionClass->name}"
                );
            }
        }
    }
}

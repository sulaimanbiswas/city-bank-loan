<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure the public/storage symlink exists (needed to serve files from the "public" disk)
        try {
            $publicStoragePath = public_path('storage');
            if (!is_link($publicStoragePath) && !file_exists($publicStoragePath)) {
                // Attempt to create the storage symlink
                Artisan::call('storage:link');
            }
        } catch (\Throwable $e) {
            // Don't break the app if it fails on certain environments (e.g., Windows without permissions)
            Log::warning('Failed to ensure storage symlink: ' . $e->getMessage());
        }

        // Ensure organized upload directories directly under public/
        try {
            $disk = Storage::disk('public_root');
            foreach (
                [
                    'uploads',
                    'uploads/gateways',
                    'uploads/loan-docs',
                    'uploads/loan-deposits',
                ] as $dir
            ) {
                if (!$disk->exists($dir)) {
                    $disk->makeDirectory($dir);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to ensure uploads directories: ' . $e->getMessage());
        }
    }
}

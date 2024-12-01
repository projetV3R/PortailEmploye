<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Finance;
use App\Observers\FinanceObserver;
use App\Models\FicheFournisseur;
use App\Observers\FicheFournisseurObserver;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;


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
        Blade::directive('role', function ($role) {
            $roles = explode(',', $role);
            $roles = array_map('trim', $roles);
        return "<?php if(auth()->check() && in_array(auth()->user()->role, [". implode(',' , $roles) . "])) : ?>";  
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });          
        Finance::observe(FinanceObserver::class);
        FicheFournisseur::observe(FicheFournisseurObserver::class);
        Storage::extend('azure', function ($app, $config) {
            $connectionString = config('filesystems.disks.azure.connection_string');
            $container = config('filesystems.disks.azure.container');
    
            $client = BlobRestProxy::createBlobService($connectionString);
    
            $adapter = new AzureBlobStorageAdapter($client, $container);
    
            $filesystem = new Filesystem($adapter);
    
            return new FilesystemAdapter($filesystem, $adapter);
        });
}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrochureCarte extends Model
{
    use HasFactory;
    protected $table = 'brochures_cartes';
    protected $fillable = [
        'nom',
        'type_de_fichier',
        'chemin',
        'taille',
        'fiche_fournisseur_id'
    ];
    public function ficheFournisseur()
    {
        return $this->belongsTo(FicheFournisseur::class, 'fiche_fournisseur_id');
    }

    public function getDownloadUrlAttribute()
    {
        $accountName   = config('filesystems.disks.azure.name');
        $accountKey    = config('filesystems.disks.azure.key');
        $containerName = config('filesystems.disks.azure.container');
        $blobName      = $this->chemin; 
    

        $signedPermissions = 'r'; 
        $signedStart       = '';  
        $signedExpiry      = gmdate('Y-m-d\TH:i:s\Z', time() + 3600); 
        $signedIdentifier  = '';
        $signedIP          = '';
        $signedProtocol    = 'https';
        $signedVersion     = '2020-02-10'; 
        $signedResource    = 'b'; 
        $signedSnapshot    = '';
        $cacheControl      = '';
        
     
        $contentDisposition = 'attachment; filename="' . $this->nom . '"';
        
        $contentEncoding   = '';
        $contentLanguage   = '';
        $contentType       = '';
    
    
        $canonicalizedResource = '/blob/' . $accountName . '/' . $containerName . '/' . $blobName;
    
    
        $stringToSign =
            $signedPermissions . "\n" .
            $signedStart . "\n" .
            $signedExpiry . "\n" .
            $canonicalizedResource . "\n" .
            $signedIdentifier . "\n" .
            $signedIP . "\n" .
            $signedProtocol . "\n" .
            $signedVersion . "\n" .
            $signedResource . "\n" .
            $signedSnapshot . "\n" .
            $cacheControl . "\n" .
            $contentDisposition . "\n" .
            $contentEncoding . "\n" .
            $contentLanguage . "\n" .
            $contentType;
    
       
        $decodedAccountKey = base64_decode($accountKey);
    
       
        $signature = base64_encode(
            hash_hmac('sha256', $stringToSign, $decodedAccountKey, true)
        );
    
      
        $sasToken = http_build_query([
            'sv'   => $signedVersion,
            'sr'   => $signedResource,
            'sig'  => $signature,
            'se'   => $signedExpiry,
            'sp'   => $signedPermissions,
            'spr'  => $signedProtocol,
            'rscd' => $contentDisposition,

        ]);
    
     
        $url = sprintf(
            'https://%s.blob.core.windows.net/%s/%s?%s',
            $accountName,
            $containerName,
            rawurlencode($blobName),
            $sasToken
        );
    
        return $url;
    }
}

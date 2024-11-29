<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FicheFournisseur;
use App\Models\ParametreSysteme;
use App\Models\Coordonnee;
use App\Models\Municipalites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Telephone;
use App\Models\CoordonneeTelephone;
use App\Models\Contact;
use App\Models\Licence;
use App\Models\SousCategorieLicence;
use App\Models\BrochureCarte;
use App\Models\ProduitService;
use App\Models\ProduitServiceFicheFournisseur;
use App\Notifications\WelcomeEmail;
use App\Http\Requests\IdentificationRequest;
use App\Http\Requests\ProduitServiceRequest;
use App\Http\Requests\CoordonneeRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LicenceRequest;
use App\Http\Requests\FinanceRequest;
use App\Http\Requests\ContactRequest;
use App\Models\Historique;
use App\Models\ProduitsServices;
use App\Models\SousCategorie;
use App\Notifications\NotificationModification;
use App\Notifications\FournisseurApproveNotification;
use App\Notifications\FournisseurRefusNotification;
     class FicheFournisseurController extends Controller
    {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $page = $request->input('page', 1);
        $regions = $request->input('regions', []);
        $villes = $request->input('villes', []);
        $licences = $request->input('licences', []);
        $etats = $request->input('etats', []);
        $searchQuery = $request->input('search', ''); 
        $query = FicheFournisseur::with(['coordonnees', 'licence.sousCategories', 'contacts']);
    
       
        if (!empty($regions)) {
            $query->whereHas('coordonnees', function ($q) use ($regions) {
                $q->whereIn('region_administrative', $regions);
            });
        }
    
        if (!empty($villes)) {
            $query->whereHas('coordonnees', function ($q) use ($villes) {
                $q->whereIn('ville', $villes);
            });
        }
        if ($request->has('produits') && !empty($request->produits)) {
            $produits = $request->input('produits');
            $query->whereHas('produitsServices', function($q) use ($produits) {
                $q->whereIn('produits_services.id', $produits);
            });
        }

        if (!empty($licences)) {
            $query->whereHas('licence.sousCategories', function ($q) use ($licences) {
                $q->whereIn('sous_categorie_id', $licences); 
            });
        }   

        if (!empty($etats)) {
        $query->whereIn('etat', $etats);
    }

    if (!empty($searchQuery)) {
        $query->where(function ($q) use ($searchQuery) {
        $q->where('nom_entreprise', 'LIKE', "%$searchQuery%")
        ->orWhere('adresse_courriel', 'LIKE', "%$searchQuery%")
        ->orWhereHas('contacts', function ($subQuery) use ($searchQuery) {
         $subQuery->where('nom', 'LIKE', "%$searchQuery%")
         ->orWhere('prenom', 'LIKE', "%$searchQuery%");
                });
        });
    }
    
       
        $query->where('etat', '!=', 'désactivé');
    
        $fiches = $query->paginate($perPage, ['*'], 'page', $page);
    
        if ($request->ajax()) {
            return response()->json($fiches);
        }
    
        $selectedCompanies = session('selectedCompanies', []);
        return view('Fournisseur.liste_fournisseur', compact('fiches', 'selectedCompanies'));
    }
    


     public function profil($id)
    {
    
        
        $fournisseur = FicheFournisseur::find($id);
        $licence = $fournisseur->licence()->with('sousCategories.categorie')->first();
        $maxFileSize = ParametreSysteme::where('cle', 'taille_fichier')->value('valeur_numerique');

        return view('Fournisseur/profil_fournisseur', compact('maxFileSize', 'fournisseur', 'licence'));
    }

    public function updateSelection(Request $request)
    {
        $selectedCompanies = $request->input('selectedCompanies', []);
        session(['selectedCompanies' => $selectedCompanies]);

        return response()->json(['message' => 'Sélection mise à jour']);
    }

        //Brochure carte d'affaires update

        public function editDoc($id)
        { 
            
                $fournisseur = FicheFournisseur::find($id);
                $maxFileSize = ParametreSysteme::where('cle', 'taille_fichier')->value('valeur_numerique');
                return view("modificationCompte/docModif" , compact('fournisseur','maxFileSize'));
        }

        public function getDocuments($id)
    {
   
        $fournisseur = FicheFournisseur::find($id);
        $brochures = $fournisseur->brochuresCarte->map(function($brochure) {
            return [
                'nom' => $brochure->nom,
                'taille' => $brochure->taille,
                'id' => $brochure->id
            ];
        });
        $maxFileSize = ParametreSysteme::where('cle', 'taille_fichier')->value('valeur_numerique');
        return response()->json([
            'brochures' => $brochures,
            'maxFileSize' => $maxFileSize 
        ]);
    }

    public function updateDoc(Request $request,$id)
    {
        $usager = Auth::user();
        $fournisseur = FicheFournisseur::find($id);
    
        $maxFileSize = ParametreSysteme::where('cle', 'taille_fichier')->value('valeur_numerique');
        $totalSize = 0;
    
      
        $validator = Validator::make($request->all(), [
            'fichiers.*' => 'mimes:doc,docx,pdf,jpg,jpeg,xls,xlsx'
        ], [
            'fichiers.*.mimes' => 'Chaque fichier doit être de type : doc, docx, pdf, jpg, jpeg, xls ou xlsx.'
        ]);
    
        if ($validator->fails()) {
            // Stocker les erreurs de validation dans la session 
            session()->put('errorsFichiers', $validator->errors());
          return  redirect()->back();
           
        }
    
      
        $existingFiles = $fournisseur->brochuresCarte;
        $fileIdsToDelete = $request->input('fichiers_a_supprimer', []);
    
        foreach ($existingFiles as $file) {
            
            if (!in_array($file->id, $fileIdsToDelete)) {
                $totalSize += $file->taille / (1024 * 1024); // Convertir la taille en Mo
            }
        }
    
    
        if ($request->hasFile('fichiers')) {
            foreach ($request->file('fichiers') as $file) {
                $totalSize += $file->getSize() / (1024 * 1024); // Convertir la taille en Mo
            }
        }
    
   
        if ($totalSize > $maxFileSize) {
            // Stocker le message d'erreur dans la session
            session()->put('errorsFichiers',"La taille totale des fichiers, incluant les fichiers existants, dépasse la limite de {$maxFileSize} Mo.");
            return  redirect()->back();
        }

        $existingFiles = $fournisseur->brochuresCarte;
        $fileIdsToDelete = $request->input('fichiers_a_supprimer', []);
    
        $historiqueRemove = []; 
        $historiqueAdd = [];   
    
     
        foreach ($fileIdsToDelete as $fileId) {
            $fileToDelete = $existingFiles->find($fileId);
            if ($fileToDelete) {
            
                if (Storage::disk('public')->exists($fileToDelete->chemin)) {
                    Storage::disk('public')->delete($fileToDelete->chemin);
                }
              
                $historiqueRemove[] = "-{$fileToDelete->nom}";
             
                $fileToDelete->delete();
            }
        }
    
       
        if ($request->hasFile('fichiers')) {
            foreach ($request->file('fichiers') as $file) {
                $path = $file->store('brochures', 'public');
                $brochure = $fournisseur->brochuresCarte()->create([
                    'nom' => $file->getClientOriginalName(),
                    'chemin' => $path,
                    'taille' => $file->getSize(),
                    'type_de_fichier' => $file->getClientOriginalExtension(),
                ]);
    
                
                $historiqueAdd[] = "+{$brochure->nom}";
            }
        }
    
    
        if (!empty($historiqueAdd) || !empty($historiqueRemove)) {
            $oldValues = !empty($historiqueRemove) ? implode(", ", $historiqueRemove) : null;
            $newValues = !empty($historiqueAdd) ? implode(", ", $historiqueAdd) : null;
    
            Historique::create([
                'table_name' => 'BrochuresCarte',
                'author' =>  $usager->email,
                'action' => 'Modifier',
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'fiche_fournisseur_id' => $fournisseur->id,
            ]);
            $sectionModifiee = 'Brochures et carte d\affaires';
            $data = [
                'sectionModifiee' => $sectionModifiee,
                'nomEntreprise' => $fournisseur->nom_entreprise,
                'emailEntreprise' => $fournisseur->adresse_courriel,
                'dateModification' => now()->format('d-m-Y H:i:s'),
            ];
            $fournisseur->notify(new NotificationModification($data));
        }
    
        return redirect()->back()->with('success', 'Vos brochures & cartes d\'affaires ont été mises à jour avec succès.');
    }


        //Modifier contact

        public function editContact($id)
        {
           
            $fournisseur = FicheFournisseur::find($id);
        return view("modificationCompte/contactModif" , compact('fournisseur'));
        }

        public function getContacts($id)
        {
         
            $fournisseur = FicheFournisseur::find($id);
            
            $contacts = $fournisseur->contacts()->with('telephone:id,numero_telephone,poste,type')->get();
            
            return response()->json($contacts);
        }
        
        public function updateContact(ContactRequest $request,$id)
    {
        $usager = Auth::user();
        $fournisseur = FicheFournisseur::find($id);

        $existingContactIds = $fournisseur->contacts()->pluck('id')->toArray();
        $submittedContactIds = array_filter(array_column($request->input('contacts', []), 'id'));

        $contactsToDelete = array_diff($existingContactIds, $submittedContactIds);

        $oldValues = [];
        $newValues = [];

        
        foreach ($contactsToDelete as $contactId) {
            $contact = Contact::find($contactId);
            if ($contact) {
                $telephone = $contact->telephone;

                $oldValues[] = "-Contact: {$contact->prenom} {$contact->nom}, Fonction: {$contact->fonction}, Email: {$contact->adresse_courriel}, Téléphone: {$telephone->numero_telephone}, Poste: {$telephone->poste}, Type: {$telephone->type}";

            
                $contact->delete();
                if ($telephone) {
                    $telephone->delete();
                }
            }
        }

    
        foreach ($request->input('contacts') as $contactData) {
            $numeroNettoye = str_replace('-', '', $contactData['numeroTelephone']);

        
            if (!empty($contactData['telephone_id'])) {
                $telephone = Telephone::findOrFail($contactData['telephone_id']);
            } else {
                $telephone = new Telephone();
            }

        
            $originalTelephoneAttributes = $telephone->getOriginal();

        
            $telephone->numero_telephone = $numeroNettoye;
            $telephone->poste = $contactData['poste'];
            $telephone->type = $contactData['type'];

    
            $telephoneChanged = $telephone->isDirty();

    
            if ($telephoneChanged) {
                $telephone->save();
            }

    
            if (!empty($contactData['id'])) {
                $contact = Contact::findOrFail($contactData['id']);
            } else {
                $contact = new Contact();
            }

    
            $originalContactAttributes = $contact->getOriginal();

    
            $contact->prenom = $contactData['prenom'];
            $contact->nom = $contactData['nom'];
            $contact->fonction = $contactData['fonction'];
            $contact->adresse_courriel = $contactData['email'];
            $contact->fiche_fournisseur_id = $fournisseur->id;
            $contact->telephone_id = $telephone->id;

    
            $contactChanged = $contact->isDirty();

    
            if ($contactChanged || !$contact->exists) {
                $contact->save();
            }

        
            if ($contact->wasRecentlyCreated) {
            
                $newValues[] = "+Contact: {$contact->prenom} {$contact->nom}, Fonction: {$contact->fonction}, Email: {$contact->adresse_courriel}, Téléphone: {$telephone->numero_telephone}, Poste: {$telephone->poste}, Type: {$telephone->type}";
            } elseif ($contactChanged || $telephoneChanged) {
        
                $oldContactInfo = "-Contact: {$originalContactAttributes['prenom']} {$originalContactAttributes['nom']}, Fonction: {$originalContactAttributes['fonction']}, Email: {$originalContactAttributes['adresse_courriel']}, Téléphone: {$originalTelephoneAttributes['numero_telephone']}, Poste: {$originalTelephoneAttributes['poste']}, Type: {$originalTelephoneAttributes['type']}";

                $newContactInfo = "+Contact: {$contact->prenom} {$contact->nom}, Fonction: {$contact->fonction}, Email: {$contact->adresse_courriel}, Téléphone: {$telephone->numero_telephone}, Poste: {$telephone->poste}, Type: {$telephone->type}";

                $oldValues[] = $oldContactInfo;
                $newValues[] = $newContactInfo;
            }
        
        }

        if (!empty($oldValues) || !empty($newValues)) {
            Historique::create([
                'table_name' => 'Contacts',
                'author' => $usager->email ,
                'action' => 'Modifier',
                'old_values' => !empty($oldValues) ? implode("; ", $oldValues) : null,
                'new_values' => !empty($newValues) ? implode("; ", $newValues) : null,
                'fiche_fournisseur_id' => $fournisseur->id,
            ]);

    
            $sectionModifiee = 'Contacts';
            $data = [
                'sectionModifiee' => $sectionModifiee,
                'nomEntreprise' => $fournisseur->nom_entreprise,
                'emailEntreprise' => $fournisseur->adresse_courriel,
                'dateModification' => now()->format('d-m-Y H:i:s'),
            ];
            $fournisseur->notify(new NotificationModification($data));
        }
        return redirect()->back()->with('success', 'Vos Informations de contact mises à jour avec succès.');
    }

        //Modifier coordonnée

        public function editCord($id)
        {
            $fournisseur = FicheFournisseur::find($id);
            $coordonnee = $fournisseur->coordonnee()->with('telephones')->first();
            return view('modificationCompte.coordonneeModif', compact('fournisseur', 'coordonnee'));
        }

        public function getCoordonneeData($id)
    {
        $fournisseur = FicheFournisseur::find( $id );
    

        $coordonnee = $fournisseur->coordonnee()->with('telephones')->first();

        $coordonneeData = [
            'numeroCivique' => $coordonnee->numero_civique,
            'bureau' => $coordonnee->bureau,
            'rue' => $coordonnee->rue,
            'codePostale' => $coordonnee->code_postal,
            'province' => $coordonnee->province,
            'regionAdministrative' => $coordonnee->region_administrative,
            'siteWeb' => $coordonnee->site_internet,
            'municipalite' => $coordonnee->ville,
            'municipaliteInput' => $coordonnee->ville,
            'ligne' => []
        ];

        $telephones = $coordonnee->telephones;

        foreach ($telephones as $index => $telephone) {
            $coordonneeData['ligne'][$index] = [
                'id' => $telephone->id, 
                'type' => $telephone->type,
                'numeroTelephone' => $telephone->numero_telephone,
                'poste' => $telephone->poste,
            ];
        }
        

        return response()->json(['coordonnee' => $coordonneeData]);
    }

    public function updateCoordonnee(CoordonneeRequest $request,$id)
    {
        $usager = Auth::user();
        $fournisseur = FicheFournisseur::find($id);

        $coordonnee = $fournisseur->coordonnee;

        $oldCoordonneeAttributes = $coordonnee->getOriginal();

        $existingTelephoneIds = $coordonnee->telephones()->pluck('telephones.id')->toArray();

        $submittedTelephoneIds = [];
        $updatedTelephones = [];
        $deletedTelephones = [];


        $coordonnee->numero_civique = $request->input('numeroCivique');
        $coordonnee->rue = $request->input('rue');
        $coordonnee->bureau = $request->input('bureau');
        $coordonnee->code_postal = $request->input('codePostale');
        $coordonnee->province = $request->input('province');
        $coordonnee->region_administrative = $request->input('regionAdministrative');
        $coordonnee->site_internet = $request->input('siteWeb');
        $coordonnee->ville = $request->input('municipalite') ?? $request->input('municipaliteInput');
        $coordonnee->save();

        $lignes = $request->input('ligne', []);
        foreach ($lignes as $ligne) {
            $numeroNettoye = str_replace('-', '', $ligne['numeroTelephone']);

            if (isset($ligne['id']) && !empty($ligne['id'])) {
    
                $telephone = Telephone::findOrFail($ligne['id']);
                $oldTelephoneAttributes = $telephone->getOriginal();

                $telephone->numero_telephone = $numeroNettoye;
                $telephone->poste = $ligne['poste'] ?? null;
                $telephone->type = $ligne['type'] ?? 'Bureau';
                $telephone->save();

                $submittedTelephoneIds[] = $telephone->id;

    
                if ($oldTelephoneAttributes['numero_telephone'] != $telephone->numero_telephone ||
                    $oldTelephoneAttributes['poste'] != $telephone->poste ||
                    $oldTelephoneAttributes['type'] != $telephone->type) {
                    $updatedTelephones[] = [
                        'old' => $oldTelephoneAttributes,
                        'new' => $telephone->toArray(),
                    ];
                }
            } else {
            
                $telephone = Telephone::create([
                    'numero_telephone' => $numeroNettoye,
                    'poste' => $ligne['poste'] ?? null,
                    'type' => $ligne['type'] ?? 'Bureau',
                ]);
                $coordonnee->telephones()->attach($telephone->id);
                $submittedTelephoneIds[] = $telephone->id;

                $updatedTelephones[] = [
                    'old' => null,
                    'new' => $telephone->toArray(),
                ];
            }
        }

        $telephonesToDetach = array_diff($existingTelephoneIds, $submittedTelephoneIds);

        if (!empty($telephonesToDetach)) {
            $deletedTelephones = Telephone::whereIn('id', $telephonesToDetach)->get()->toArray();

            $coordonnee->telephones()->detach($telephonesToDetach);
            Telephone::whereIn('id', $telephonesToDetach)->delete();
        }

        $oldValues = [];
        $newValues = [];

        $attributesToCheck = [
            'numero_civique',
            'rue',
            'bureau',
            'code_postal',
            'province',
            'region_administrative',
            'site_internet',
            'ville'
        ];

        foreach ($attributesToCheck as $attribute) {
            $oldValue = $oldCoordonneeAttributes[$attribute] ?? null;
            $newValue = $coordonnee->$attribute;

            if ($oldValue != $newValue) {
                $oldValues[] = "-{$attribute}: {$oldValue}";
                $newValues[] = "+{$attribute}: {$newValue}";
            }
        }

    
        foreach ($updatedTelephones as $updatedTelephone) {
            $oldTel = $updatedTelephone['old'];
            $newTel = $updatedTelephone['new'];

            if ($oldTel === null) {
        
                $newValues[] = "+telephone: {$newTel['numero_telephone']}, poste: {$newTel['poste']}, type: {$newTel['type']}";
            } else {
                $changes = [];

                if ($oldTel['numero_telephone'] != $newTel['numero_telephone']) {
                    $changes[] = "numero telephone de {$oldTel['numero_telephone']} à {$newTel['numero_telephone']}";
                }
                if ($oldTel['poste'] != $newTel['poste']) {
                    $changes[] = "poste de {$oldTel['poste']} à {$newTel['poste']}";
                }
                if ($oldTel['type'] != $newTel['type']) {
                    $changes[] = "type de {$oldTel['type']} à {$newTel['type']}";
                }

                if (!empty($changes)) {
                
                    $newValues[] = "+Modif telephone: " . implode(", ", $changes);
                }
            }
        }

        foreach ($deletedTelephones as $deletedTelephone) {
            $oldValues[] = "-telephone: {$deletedTelephone['numero_telephone']}, poste: {$deletedTelephone['poste']}, type: {$deletedTelephone['type']}";
        }

        if (!empty($oldValues) || !empty($newValues)) {
            Historique::create([
                'table_name' => 'Coordonnee', 
                'author' => $usager->email,
                'action' => 'Modifier',
                'old_values' => !empty($oldValues) ? implode("; ", $oldValues) : null,
                'new_values' => !empty($newValues) ? implode("; ", $newValues) : null,
                'fiche_fournisseur_id' => $fournisseur->id,
            ]);
            $sectionModifiee = 'Coordonnées';
            $data = [
                'sectionModifiee' => $sectionModifiee,
                'nomEntreprise' => $fournisseur->nom_entreprise,
                'emailEntreprise' => $fournisseur->adresse_courriel,
                'dateModification' => now()->format('d-m-Y H:i:s'),
            ];
            $fournisseur->notify(new NotificationModification($data));
        }

        return redirect()->back()->with('success', 'Vos coordonnées ont été mises à jour avec succès.');
    }

    //Modifier identification 

    public function editIdentif($id)
    {
    
        $fournisseur = FicheFournisseur::find($id);
        return view("modificationCompte/identificationModif", compact('fournisseur'));
    }

    public function updateProfile(IdentificationRequest $request,$id)
{
    $fournisseur = FicheFournisseur::find($id);

  
    $fournisseur->adresse_courriel = $request->input('email');
    $fournisseur->neq = $request->input('numeroEntreprise');

    if ($request->filled('password')) {
        $fournisseur->password = bcrypt(($request->input('password')));
    }

    $fournisseur->nom_entreprise = $request->input('nomEntreprise');

    $fournisseur->save();

    // Rediriger avec un message de succès
    return redirect()->back()
        ->with('success', 'Votre profil a été mis à jour avec succès.');
}

//Modifier Finance

    public function editFinance($id)
        {
        
            $fournisseur = FicheFournisseur::find($id);
             return view("modificationCompte/financeModif" , compact('fournisseur'));

        }

        public function updateFinance(FinanceRequest $request,$id)
        {
     
            $fournisseur = FicheFournisseur::find($id);
        
            
            if ( $fournisseur->etat === 'accepter') {
                $fournisseur->finance()->updateOrCreate(
                    ['fiche_fournisseur_id' => $id], // Condition pour vérifier l'existence
                    [
                        'numero_tps' => $request->input('numeroTPS'),
                        'numero_tvq' => $request->input('numeroTVQ'),
                        'condition_paiement' => $request->input('conditionDePaiement'),
                        'devise' => $request->input('devise'),
                        'mode_communication' => $request->input('modeCommunication'),
                    ]
                );
                return redirect()->back()
                ->with('success', 'Informations financières mises à jour avec succès.');

            }
        
            return redirect()->back()->withErrors('Erreur lors de la mise à jour des informations financières.');
        }

        //Modif Licence

        public function editLicence($id)
        {
    
         
            $fournisseur = FicheFournisseur::find($id);
            return view("modificationCompte/licenceModif", compact('fournisseur'));
        }
        public function getSousCategories($type)
        {
            if (auth()->check() || session()->has('produitsServices')) {
    
                $sousCategories = \DB::table('sous_categories')
                    ->where('categorie', 'LIKE', "%$type%")
                    ->select('id', 'code_sous_categorie', 'travaux_permis', 'type')
                    ->get()
                    ->groupBy('type');
    
                return response()->json($sousCategories);
            }
            return redirect()->back();
        }

        public function getSousCategoriesMultiple(Request $request)
    {
        if (auth()->check() || session()->has('produitsServices')) {
            $ids = $request->query('ids', []);

            if (!is_array($ids) || empty($ids)) {
                return response()->json([], 200);
            }


            $validatedIds = array_filter($ids, function ($id) {
                return filter_var($id, FILTER_VALIDATE_INT) !== false;
            });


            $sousCategories = SousCategorie::whereIn('id', $validatedIds)->get();

            return response()->json($sousCategories);
        }
        return redirect()->back();
    }

    public function getLicenceData($id)
    {
    
        $fournisseur = FicheFournisseur::find($id);
        $licence = $fournisseur->licence()->with('sousCategories.categorie')->first();

        return response()->json([
            'licence' => $licence,
            'selectedSousCategories' => $licence ? $licence->sousCategories->pluck('sous_categorie_id')->toArray() : [],
        ]);
    }

    public function deleteLicence($id)
    {
        $usager = Auth::user();
        $fournisseur = FicheFournisseur::find($id);
        $licence = $fournisseur->licence()->first();
    
        if ($licence) {
        
            $licence->sousCategoriess()->detach();
    
          
            $licence->delete();
    
            Historique::create([
                'table_name' => 'Licence',
                'author' => $usager->email,
                'action' => 'Modifier',
                'old_values' => "-Licence: {$licence->numero_licence_rbq}, Statut: {$licence->statut}, Type: {$licence->type_licence}",
                'new_values' => "+Licence: supprimer",
                'fiche_fournisseur_id' => $fournisseur->id,
            ]);
            $sectionModifiee = 'Licence et sous-catégories';
            $data = [
                'sectionModifiee' => $sectionModifiee,
                'nomEntreprise' => $fournisseur->nom_entreprise,
                'emailEntreprise' => $fournisseur->adresse_courriel,
                'dateModification' => now()->format('d-m-Y H:i:s'),
            ];
            $fournisseur->notify(new NotificationModification($data));
    
            return response()->json(['success' => true, 'message' => 'La licence et ses sous-catégories ont été supprimées avec succès.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Aucune licence à supprimer.'], 404);
    }

    public function updateLicence(LicenceRequest $request,$id)
{
    $usager = Auth::user();
    $fournisseur = FicheFournisseur::find($id);

   
    $licence = $fournisseur->licence()->firstOrNew();


    $oldLicenceAttributes = $licence->exists ? $licence->getOriginal() : [];

 
    $oldSousCategorieIds = $licence->sousCategoriess()->pluck('sous_categorie_id')->toArray();

 
    $numeroNettoyeRbq = str_replace('-', '', $request->input('numeroLicence'));
    $licence->numero_licence_rbq = $numeroNettoyeRbq;
    $licence->statut = $request->input('statut');
    $licence->type_licence = $request->input('typeLicence');
    $licence->fiche_fournisseur_id = $fournisseur->id; 


    $licence->save();


    $newSousCategorieIds = $request->input('sousCategorie', []);


    $licence->sousCategoriess()->sync($newSousCategorieIds);


    $addedSousCategorieIds = array_diff($newSousCategorieIds, $oldSousCategorieIds);
    $removedSousCategorieIds = array_diff($oldSousCategorieIds, $newSousCategorieIds);


    $oldValues = [];
    $newValues = [];

    $attributesToCheck = ['numero_licence_rbq', 'statut', 'type_licence'];

    foreach ($attributesToCheck as $attribute) {
        $oldValue = $oldLicenceAttributes[$attribute] ?? null;
        $newValue = $licence->$attribute;

        if ($oldValue != $newValue) {
            $oldValues[] = "-{$attribute}: {$oldValue}";
            $newValues[] = "+{$attribute}: {$newValue}";
        }
    }

    if (!empty($addedSousCategorieIds)) {
        $addedSousCategories = SousCategorie::whereIn('id', $addedSousCategorieIds)->get();
        foreach ($addedSousCategories as $sousCategorie) {
            $newValues[] = "+{$sousCategorie->code_sous_categorie}";
        }
    }


    if (!empty($removedSousCategorieIds)) {
        $removedSousCategories = SousCategorie::whereIn('id', $removedSousCategorieIds)->get();
        foreach ($removedSousCategories as $sousCategorie) {
            $oldValues[] = "-{$sousCategorie->code_sous_categorie}";
        }
    }


    if (!empty($oldValues) || !empty($newValues)) {
        Historique::create([
            'table_name' => 'Licence',
            'author' =>  $usager->email,
            'action' => 'Modifier',
            'old_values' => !empty($oldValues) ? implode(", ", $oldValues) : null,
            'new_values' => !empty($newValues) ? implode(", ", $newValues) : null,
            'fiche_fournisseur_id' => $fournisseur->id,
        ]);
        $sectionModifiee = 'Licence et sous-catégories';
        $data = [
            'sectionModifiee' => $sectionModifiee,
            'nomEntreprise' => $fournisseur->nom_entreprise,
            'emailEntreprise' => $fournisseur->adresse_courriel,
            'dateModification' => now()->format('d-m-Y H:i:s'),
        ];
        $fournisseur->notify(new NotificationModification($data));
    }

    return redirect()->back()->with('success', 'La licence a été mise à jour avec succès.');
}

//Produits et services

public function search(Request $request)
{
   if (auth()->check() || session()->has('identification')){
    $query = trim($request->get('recherche'));
    $categorie = $request->get('categorie');

    $produits = ProduitsServices::when($query, function($queryBuilder) use ($query) {
            $queryBuilder->where('nature', 'LIKE', '%' . $query . '%')
                         ->orWhere('code_categorie', 'LIKE', '%' . $query . '%')
                         ->orWhere('code_unspsc', 'LIKE', '%' . $query . '%')
                         ->orWhere('description', 'LIKE', '%' . $query . '%');
        })
        ->when($categorie, function ($queryBuilder) use ($categorie) {
            $queryBuilder->where('code_categorie', $categorie);
        })
        ->paginate(10);

    return response()->json($produits);
   }
   return redirect()->back();
}


public function getCategories()
{
   if (auth()->check() || session()->has('identification')){
$categories = ProduitsServices::select('code_categorie')
   ->distinct()
   ->orderBy('code_categorie', 'asc')
   ->pluck('code_categorie');

return response()->json($categories);
   }
   return redirect()->back();
}

public function getMultiple(Request $request,$id)
{
    // Vérifier si l'utilisateur est connecté
    if (auth()->check()) {
        $fournisseur = FicheFournisseur::find($id);
        
        // Récupérer les produits et services associés à l'utilisateur connecté
        $produits = $fournisseur->produitsServices;
        
        return response()->json($produits);
    }

    // Rediriger si aucune condition n'est remplie
    return redirect()->back();
}




public function editProduit($id)
{

    $fournisseur = FicheFournisseur::find($id);
    $produitsServices = $fournisseur->produitsServices; 
    return view("modificationCompte/produitModif", compact('fournisseur', 'produitsServices'));
}


public function updateProduit(ProduitServiceRequest $request,$id)
{

    $usager = Auth::user();
    $fournisseur = FicheFournisseur::find($id);

 
    $oldDetailsSpecifications = $fournisseur->details_specifications;


    $newDetailsSpecifications = $request->input('details_specifications');

  
    $fournisseur->details_specifications = $newDetailsSpecifications;
    $fournisseur->save();

  
    $oldProductIds = $fournisseur->produitsServices()->pluck('produits_services.id')->toArray();

   
    $newProductIds = $request->input('produits_services', []);


    $fournisseur->produitsServices()->sync($newProductIds);


    $addedProductIds = array_diff($newProductIds, $oldProductIds);
    $removedProductIds = array_diff($oldProductIds, $newProductIds);

    $historiqueRemove = []; 
    $historiqueDetails = []; 

    if ($oldDetailsSpecifications !== $newDetailsSpecifications) {
        if (!empty($oldDetailsSpecifications)) {
            $historiqueRemove[] = "-details et specifications: {$oldDetailsSpecifications}";
        }
        if (!empty($newDetailsSpecifications)) {
            $historiqueDetails[] = "+details et specifications: {$newDetailsSpecifications}";
        }
    }

   
    if (!empty($removedProductIds)) {
        $removedProducts = ProduitsServices::whereIn('id', $removedProductIds)->get();
        foreach ($removedProducts as $product) {
            $historiqueRemove[] = "-{$product->code_unspsc} {$product->description}";
        }
    }

 
    if (!empty($addedProductIds)) {
        $addedProducts = ProduitsServices::whereIn('id', $addedProductIds)->get();
        foreach ($addedProducts as $product) {
            $historiqueDetails[] = "+{$product->code_unspsc} {$product->description}";
        }
    }

 
    if (!empty($historiqueDetails) || !empty($historiqueRemove)) {
        Historique::create([
            'table_name' => 'Produits&Services',
            'author' => $usager->email,
            'action' => 'Modifier',
            'old_values' => !empty($historiqueRemove) ? implode(", ", $historiqueRemove) : null,
            'new_values' => !empty($historiqueDetails) ? implode(", ", $historiqueDetails) : null,
            'fiche_fournisseur_id' => $fournisseur->id,
        ]);
        $sectionModifiee = 'Produits et services';
        $data = [
            'sectionModifiee' => $sectionModifiee,
            'nomEntreprise' => $fournisseur->nom_entreprise,
            'emailEntreprise' => $fournisseur->adresse_courriel,
            'dateModification' => now()->format('d-m-Y H:i:s'),
        ];
        $fournisseur->notify(new NotificationModification($data));
    }

    return redirect()->back()->with('success', 'Vos produits et services ont été mis à jour avec succès.');
}



public function desactivationFiche($id)
{
    $fournisseur = FicheFournisseur::find($id);
    $usager = Auth::user();

    if ($fournisseur->etat == 'accepter') {
        $historiqueRemove = [];
    

        
        $fournisseur->etat = 'desactiver';
        $fournisseur->save();

     
        $brochures = $fournisseur->brochuresCarte;
        foreach ($brochures as $file) {
            if ($file && Storage::disk('public')->exists($file->chemin)) {
                Storage::disk('public')->delete($file->chemin);
            }
            $historiqueRemove[] = "-{$file->nom}";
            $file->delete();
        }

    
        $historiqueRemove = implode(', ', $historiqueRemove);

     
        Historique::create([
            'table_name' => 'Identification et statut',
            'author' => $usager->email,
            'action' => 'Désactivée',
            'old_values' => "-état : Accepter, {$historiqueRemove}",
            'new_values' => '+état : Desactiver',
            'fiche_fournisseur_id' => $fournisseur->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Votre fiche fournisseur a été désactivée avec succès.']);
    }

}


    
    public function reactivationFiche($id)
    {

        $fournisseur = FicheFournisseur::find($id);
        $usager = Auth::user();
        if ($fournisseur->etat=='desactiver'){
            

            $fournisseur->etat='accepter'; 
            $fournisseur->save();
      
            Historique::create([
                'table_name' => 'Identification et statut',
                'author' =>  $usager->email,
                'action' => 'Acceptée',
                'old_values' => "-état : Desactiver ",
                'new_values' => '+état : Accepter',
                'fiche_fournisseur_id' => $fournisseur->id,
            ]);
            return response()->json(['success' => true, 'message' => 'Votre fiche fournisseur a été réactivée avec succès.']);
        }

    }

    public function reject(Request $request, $id)
    {
        $fournisseur = FicheFournisseur::findOrFail($id);
        $changes = $fournisseur->getChanges(); 
        $original = $fournisseur->getOriginal(); 
    
        $usager = Auth::user();
    
        $fournisseur->etat = 'refuser';
        $fournisseur->date_changement_etat = now();
    
        $reason = $request->input('reason', null);
        $hashedReason = $reason ? bcrypt($reason) : null;
        $fournisseur->raison_refus = $hashedReason;
    
        $fournisseur->save();
    
        Historique::create([
            'table_name' => 'Identification et statut',
            'author' => $usager->email,
            'action' => 'Refuser',
            'old_values' => "-état : " . $original['etat'],
            'new_values' => '+état : ' . $fournisseur->etat,
            'fiche_fournisseur_id' => $fournisseur->id,
        ]);
    
        $includeReason = $request->input('includeReason', false);
        $fournisseur->notify(new FournisseurRefusNotification($fournisseur, $reason, $includeReason));
    
        return response()->json(['message' => 'Demande refusée avec succès.']);
    }
    
    
    public function approve($id)
    {
        $fournisseur = FicheFournisseur::findOrFail($id);
        $changes = $fournisseur->getChanges(); 
        $original = $fournisseur->getOriginal();
        $usager = Auth::user();

        $fournisseur->etat = 'accepter';
        $fournisseur->date_changement_etat = now();
        $fournisseur->save();
        Historique::create([
            'table_name' => 'Identification et statut',
            'author' => $usager->email,
            'action' => 'Accepter',
            'old_values' => "-état : " . $original['etat'],
            'new_values' => '+état : ' . $fournisseur->etat,
            'fiche_fournisseur_id' => $fournisseur->id,
        ]);
        $fournisseur->notify(new FournisseurApproveNotification($fournisseur));

        return response()->json(['message' => 'Demande approuvée avec succès.']);
    }

}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Modele;

class FournisseurRefusNotification extends Notification
{
    use Queueable;

    public $fournisseur;
    public $reason;
    public $includeReason;

    /**
     * Create a new notification instance.
     */
    public function __construct($fournisseur, $reason = null, $includeReason = false)
    {
        $this->fournisseur = $fournisseur;
        $this->reason = $reason;
        $this->includeReason = $includeReason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $modele = Modele::where('type', 'Votre demande a été refusée')
                        ->where('actif', 1)
                        ->first();

        // Définir un contenu par défaut si le modèle n'existe pas
        if (!$modele) {
            return $this->defaultMail();
        }

        // Remplacer les variables dans le corps du modèle
        $body = $this->replaceVariables($modele->body);

        // Créer le message email
        $mailMessage = (new MailMessage)
            ->subject($modele->objet)
            ->line($body)
            ->salutation('Service approvisionnement V3R');

        return $mailMessage;
    }

    /**
     * Remplacer les variables dynamiques dans le modèle par les valeurs réelles.
     */
    private function replaceVariables($body)
    {
        // Remplacer les encodages HTML par leurs caractères équivalents
        $body = str_replace('&gt;', '>', $body);

        // Liste des variables et leurs valeurs associées
        $variables = [
            '{fiche_fournisseurs->raison_refus}' => $this->reason ?? 'Non spécifiée',
            '{fiche_fournisseurs->nom_entreprise}' => $this->fournisseur->nom_entreprise,
            // Ajouter d'autres variables ici si nécessaire
        ];

        // Remplacer chaque clé dans le body par sa valeur
        foreach ($variables as $key => $value) {
            $body = str_replace($key, $value, $body);
        }

        return $body;
    }

    /**
     * Mail de refus par défaut (si aucun modèle n'est trouvé).
     */
    private function defaultMail()
    {
        $mailMessage = (new MailMessage)
            ->subject('Notification de Refus')
            ->greeting('Bonjour ' . $this->fournisseur->nom_entreprise . ',')
            ->line('Nous vous informons que votre demande a été refusée.');

        if ($this->includeReason && $this->reason) {
            $mailMessage->line('Raison du refus : ' . $this->reason);
        }

        $mailMessage->salutation('Service approvisionnement V3R');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}

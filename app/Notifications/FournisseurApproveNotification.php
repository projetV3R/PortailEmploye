<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Modele;
use Illuminate\Support\Facades\Mail;


class FournisseurApproveNotification extends Notification
{
    use Queueable;

    public $fournisseur;

    /**
     * Create a new notification instance.
     */
    public function __construct($fournisseur)
    {
        $this->fournisseur = $fournisseur;
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
        $modele = Modele::where('type', 'Approbation Fournisseur')
                        ->where('actif', 1)
                        ->first();
        if ($modele) {
            // Utilisation du markdown avec un template personnalisé
            return (new MailMessage)
                ->subject($modele->objet)
                ->markdown('vendor.mail.html.message', ['slot' => $modele->body]);
        } else {
            // Utilisation d'un contenu par défaut
            return (new MailMessage)
                ->subject('Notification d\'Approbation')
                ->greeting('Bonjour ' . $this->fournisseur->nom_entreprise . ',')
                ->line('Nous vous informons que votre demande a été acceptée avec succès.')
                ->line('Nous sommes ravis de vous accueillir comme fournisseur partenaire.')
                ->salutation('Service approvisionnement V3R');
        }
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

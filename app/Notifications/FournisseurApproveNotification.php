<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Modele;


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
        $modele = Modele::where('type', 'Votre demande a été acceptée')
                        ->where('actif', 1)
                        ->first();

        if (!$modele) {
            return $this->defaultMail();
        }
            $body = $this->replaceVariables($modele->body);
            return (new MailMessage)
                ->subject($modele->objet)
                ->markdown('vendor.mail.html.message', ['slot' => $body]);
            
        
    }
    private function replaceVariables($body)
    {
        $body = str_replace('&gt;', '>', $body);

        $variables = [
            '{fiche_fournisseurs->nom_entreprise}' => $this->fournisseur->nom_entreprise,
        ];

        foreach ($variables as $key => $value) {
            $body = str_replace($key, $value, $body);
        }

        return $body;
    }

    private function defaultMail()
    {
        $mailMessage = (new MailMessage)
            ->subject('Notification d\'Approbation')
            ->greeting('Bonjour ' . $this->fournisseur->nom_entreprise . ',')
            ->line('Nous vous informons que votre demande a été acceptée avec succès.')
            ->line('Nous sommes ravis de vous accueillir comme fournisseur partenaire.')
            ->salutation('Service approvisionnement V3R');

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

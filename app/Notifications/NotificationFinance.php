<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ParametreSysteme;
use App\Models\Modele;
class NotificationFinance extends Notification
{
    use Queueable;

    public $fournisseur;
    public $reason;
    public $includeReason;

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
    $modele = Modele::where('type', 'Courriel du service des finances')
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


    /**
     * Remplacer les variables dynamiques dans le modèle par les valeurs réelles.
     */
    private function replaceVariables($body)
    {
        $body = str_replace('&gt;', '>', $body);

        $variables = [
            '{fiche_fournisseurs->nom_entreprise}' => $this->fournisseur->nom_entreprise ?? 'N/A',
            '{fiche_fournisseurs->neq}' => $this->fournisseur->neq ?? 'N/A',
            '{fiche_fournisseurs->etat}' => $this->fournisseur->etat ?? 'N/A',
            '{fiche_fournisseurs->finance->numero_tps}' => $this->fournisseur->finance->numero_tps ?? 'N/A',
            '{fiche_fournisseurs->finance->numero_tvq}' => $this->fournisseur->finance->numero_tvq ?? 'N/A',
            '{fiche_fournisseurs->finance->condition_paiement}' => $this->fournisseur->finance->condition_paiement ?? 'N/A',
            '{fiche_fournisseurs->finance->devise}' => $this->fournisseur->finance->devise ?? 'N/A',
            '{fiche_fournisseurs->finance->mode_communication}' => $this->fournisseur->finance->mode_communication ?? 'N/A',
        ];

        foreach ($variables as $key => $value) {
            $body = str_replace($key, $value, $body);
        }

        return $body;
    }

    /**
     */
    private function defaultMail()
    {
        $mailMessage = (new MailMessage)
            ->subject('Notification des finances')
            ->greeting('Bonjour,')
            ->line('Nous vous informons que le modele de mail est pas disponible.');

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
        return [
            //
        ];
    }
}

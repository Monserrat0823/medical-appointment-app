<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $instanceId;
    protected $apiToken;

    public function __construct()
    {
        $this->instanceId = env('WHATSAPP_INSTANCE_ID');
        $this->apiToken = env('WHATSAPP_TOKEN');
    }

    /**
     * Envía un mensaje de WhatsApp usando UltraMsg.
     *
     * @param string $phone Número de teléfono con código de país (ej. +521...).
     * @param string $message Mensaje a enviar.
     * @return bool
     */
    public function sendMessage($phone, $message)
    {
        if (empty($this->apiToken) || empty($this->instanceId)) {
            Log::info("SIMULACIÓN WHATSAPP a {$phone}: {$message}");
            return true;
        }

        // Limpiar el número (quitar espacios, guiones, paréntesis, etc)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Si el número tiene 10 dígitos (típico en México), le agregamos el 52
        if (strlen($cleanPhone) == 10) {
            $cleanPhone = '52' . $cleanPhone;
        }
        
        // A veces UltraMsg requiere el + al inicio, aunque la mayoría de las veces no.
        // Lo mandaremos como cadena con el código de país.

        $apiUrl = "https://api.ultramsg.com/{$this->instanceId}/messages/chat";

        try {
            $response = Http::post($apiUrl, [
                'token' => $this->apiToken,
                'to' => '+' . $cleanPhone, // Agregamos el + por si acaso
                'body' => $message,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Error enviando WhatsApp (UltraMsg): " . $e->getMessage());
            return false;
        }
    }
}

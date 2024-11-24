<?php

namespace NetworkHelperJS;

class NetworkHelper
{
    /**
     * Analiza el código de respuesta HTTP de una URL.
     *
     * @param string $url La URL a verificar.
     * @return string Mensaje que describe el estado del servidor.
     */
    public static function analyzeHttpStatus(string $url): string
    {
        try {
            // Inicializa una sesión cURL
            $ch = curl_init($url);

            if ($ch === false) {
                throw new Exception('No se pudo inicializar cURL.');
            }

            // Configuración de cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true); // Solo obtener el encabezado
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Tiempo de espera en segundos

            // Ejecuta la solicitud
            curl_exec($ch);

            // Obtiene el código de respuesta HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Cierra la sesión cURL
            curl_close($ch);

            // Evalúa el código de respuesta y devuelve el mensaje correspondiente
            return match ($httpCode) {
                200 => "Sin problemas: El servidor respondió correctamente (200).",
                301, 302 => "Redirección: El recurso se ha movido (código {$httpCode}).",
                400 => "Error del cliente: Solicitud incorrecta (400).",
                401 => "Error del cliente: No autorizado (401).",
                403 => "Error del cliente: Acceso prohibido (403).",
                404 => "Error del cliente: Recurso no encontrado (404).",
                500 => "Error del servidor: Error interno (500).",
                502 => "Error del servidor: Gateway incorrecto (502).",
                503 => "Error del servidor: Servicio no disponible (503).",
                504 => "Error del servidor: Tiempo de espera agotado (504).",
                default => "Código desconocido o no manejado: {$httpCode}."
            };
        } catch (Exception $e) {
            // Manejo de excepciones o errores en la red
            return "Error: No se pudo analizar el estado del servidor. Detalles: " . $e->getMessage();
        }
    }
}
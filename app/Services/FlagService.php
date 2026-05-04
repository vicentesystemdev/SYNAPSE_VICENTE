<?php

namespace App\Services;

class FlagService
{
    /**
     * Extrae el MD5 de una flag con formato synapse{md5}
     * 
     * @param string $submitted Flag enviada por el usuario
     * @return string|null MD5 extraído o null si el formato es inválido
     */
    public static function extractMd5(string $submitted): ?string
    {
        $trimmed = trim($submitted);
        
        // Validar formato original: synapse{md5}
        if (preg_match('/^synapse\{([a-f0-9]{32})\}$/i', $trimmed, $matches)) {
            return strtolower($matches[1]);
        }
        
        // Para respuestas matemáticas o texto plano, generamos el MD5 de la respuesta enviada
        return md5($trimmed);
    }

    /**
     * Valida una flag comparando con el MD5 esperado
     * 
     * @param string $submitted Flag enviada por el usuario
     * @param string $expectedMd5 MD5 esperado almacenado en la base de datos
     * @return bool true si la flag es válida, false en caso contrario
     */
    public static function validate(string $submitted, string $expectedMd5): bool
    {
        $extractedMd5 = self::extractMd5($submitted);
        
        if ($extractedMd5 === null) {
            return false;
        }
        
        // Usar hash_equals para comparación segura (timing-safe)
        return hash_equals(strtolower($expectedMd5), $extractedMd5);
    }

    /**
     * Valida formato de flag sin comparar con BD
     * Útil para validaciones en formularios
     * 
     * @param string $submitted Flag enviada por el usuario
     * @return bool true si el formato es válido
     */
    public static function isValidFormat(string $submitted): bool
    {
        return self::extractMd5($submitted) !== null;
    }
}


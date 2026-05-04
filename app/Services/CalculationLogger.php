<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * Servicio para logging de cálculos del motor inteligente en tiempo real.
 * Muestra en consola los cálculos mientras se procesan flags/intentos.
 */
class CalculationLogger
{
    private bool $enabled;

    public function __construct()
    {
        $this->enabled = config('app.calculation_logging', true);
    }

    /**
     * Verifica si el logging está habilitado
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Imprime un mensaje en consola
     */
    public function log(string $message, string $level = 'info'): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $timestamp = now()->format('H:i:s.v');
        $formatted = "[{$timestamp}] {$message}";
        
        // Usar error_log para que aparezca en la consola de Laravel
        error_log($formatted);
    }

    /**
     * Imprime una sección con separador visual
     */
    public function section(string $title): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $separator = str_repeat('=', 80);
        error_log("\n" . $separator);
        error_log("  " . strtoupper($title));
        error_log($separator);
    }

    /**
     * Imprime una subsección
     */
    public function subsection(string $title): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        error_log("\n--- " . $title . " ---");
    }

    /**
     * Imprime datos en formato clave-valor
     */
    public function data(string $label, mixed $value, int $indent = 0): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $indentation = str_repeat('  ', $indent);
        
        if (is_array($value)) {
            error_log("{$indentation}{$label}:");
            foreach ($value as $key => $val) {
                if (is_array($val)) {
                    $this->data($key, $val, $indent + 1);
                } else {
                    $formatted = $this->formatValue($val);
                    error_log("{$indentation}  {$key}: {$formatted}");
                }
            }
        } else {
            $formatted = $this->formatValue($value);
            error_log("{$indentation}{$label}: {$formatted}");
        }
    }

    /**
     * Imprime una tabla de iteraciones
     */
    public function iteration(int $iter, array $values): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $parts = ["Iteración {$iter}:"];
        foreach ($values as $key => $value) {
            $formatted = $this->formatValue($value);
            $parts[] = "{$key}={$formatted}";
        }
        
        error_log("  " . implode(", ", $parts));
    }

    /**
     * Imprime resultado final con énfasis
     */
    public function result(string $label, mixed $value): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $formatted = $this->formatValue($value);
        error_log("\n✓ {$label}: {$formatted}");
    }

    /**
     * Imprime un warning
     */
    public function warning(string $message): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        error_log("⚠ WARNING: {$message}");
    }

    /**
     * Formatea un valor para impresión
     */
    private function formatValue(mixed $value): string
    {
        if (is_null($value)) {
            return 'null';
        }
        
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        if (is_float($value)) {
            return number_format($value, 6, '.', '');
        }
        
        if (is_array($value)) {
            return json_encode($value);
        }
        
        return (string) $value;
    }

    /**
     * Imprime una línea en blanco
     */
    public function blank(): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        error_log("");
    }
}

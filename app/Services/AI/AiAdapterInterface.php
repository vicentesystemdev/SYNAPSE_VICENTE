<?php
namespace App\Services\AI;

interface AiAdapterInterface {
  public function suggestNext(array $context): array;
  public function estimateAbility(int $studentId): array;
  public function explain(array $context): array;
}

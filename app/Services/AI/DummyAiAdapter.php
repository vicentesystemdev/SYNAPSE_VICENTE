<?php
namespace App\Services\AI;

class DummyAiAdapter implements AiAdapterInterface {
  public function suggestNext(array $context): array {
    return ['type'=>'rule','next'=>'WEB-101','reason'=>'Regla simple por categoría reciente'];
  }
  public function estimateAbility(int $studentId): array {
    return ['theta'=>0.00,'se'=>0.25,'updated_at'=>now()->toDateTimeString()];
  }
  public function explain(array $context): array {
    return ['explain'=>'Stub IA sin cálculo real'];
  }
}

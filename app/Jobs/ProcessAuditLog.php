<?php

namespace App\Jobs;

use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessAuditLog implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly array $entries
    ) {}

    public function handle(): void
    {
        $encoded = array_map(fn (array $entry): array => [
            'admin_id' => $entry['admin_id'],
            'action' => $entry['action'],
            'model_type' => $entry['model_type'],
            'model_id' => $entry['model_id'],
            'changes' => json_encode($entry['changes']),
            'ip_address' => $entry['ip_address'],
            'user_agent' => $entry['user_agent'],
            'created_at' => $entry['created_at'],
        ], $this->entries);

        AuditLog::insert($encoded);
    }
}

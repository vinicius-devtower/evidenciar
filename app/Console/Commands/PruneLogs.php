<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\EmailLog;
use App\Models\ErrorLog;
use App\Models\WebhookLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

/**
 * Remove logs antigos (> N dias) das quatro tabelas de log.
 * Executado diariamente via Console\Kernel.
 */
class PruneLogs extends Command
{
    protected $signature = 'logs:prune
        {--days=90 : Retenção em dias}
        {--dry : Apenas mostra o que seria apagado}';

    protected $description = 'Remove logs com mais de N dias (error_logs, email_logs, webhook_logs, activity_logs).';

    public function handle(): int
    {
        $days    = (int) $this->option('days');
        $dry     = (bool) $this->option('dry');
        $cutoff  = now()->subDays($days);

        $targets = [
            // [label, model, coluna-data]
            ['error_logs',    ErrorLog::class,    'occurred_at'],
            ['email_logs',    EmailLog::class,    'created_at'],
            ['webhook_logs',  WebhookLog::class,  'received_at'],
            ['activity_logs', ActivityLog::class, 'created_at'],
        ];

        $this->info("Retenção: {$days} dias — corte em {$cutoff->toDateTimeString()}" . ($dry ? ' [DRY RUN]' : ''));

        $totalPurged = 0;

        foreach ($targets as [$table, $class, $col]) {
            if (!Schema::hasTable($table)) {
                $this->warn("• {$table}: tabela não existe, pulando");
                continue;
            }

            $q = $class::where($col, '<', $cutoff);
            $count = $q->count();

            if ($count === 0) {
                $this->line("• {$table}: nada a apagar");
                continue;
            }

            if ($dry) {
                $this->line("• {$table}: {$count} registros seriam apagados");
            } else {
                $deleted = $q->delete();
                $this->info("• {$table}: {$deleted} apagados");
                $totalPurged += $deleted;
            }
        }

        if (!$dry) {
            $this->info("Total removido: {$totalPurged}");
        }

        return self::SUCCESS;
    }
}

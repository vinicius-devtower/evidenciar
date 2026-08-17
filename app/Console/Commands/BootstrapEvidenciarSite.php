<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Domain;
use App\Models\Site;
use App\Models\Template;
use App\Models\TemplateVersion;
use App\Models\User;
use App\Services\SiteBuilderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Bootstrap único: transforma a própria landing page da Evidenciar
 * (evidenciar.com.br) em um Site real do catálogo, rodando o template
 * "evidenciar/v1" — dogfooding completo, editável pelo painel do cliente.
 *
 * Idempotente: pode rodar mais de uma vez sem duplicar registros.
 */
class BootstrapEvidenciarSite extends Command
{
    protected $signature = 'evidenciar:bootstrap-site
        {--owner-email=vinicius@devtower.com.br : E-mail do usuário que vai gerenciar o site pelo painel do cliente}';

    protected $description = 'Cria/atualiza o Template, Client, Site e Domain que fazem evidenciar.com.br rodar como um Site do próprio catálogo';

    public function handle(SiteBuilderService $builder): int
    {
        $template = Template::firstOrCreate(
            ['slug' => 'evidenciar-institucional'],
            [
                'name'        => 'Evidenciar Institucional',
                'description' => 'A própria landing pública da Evidenciar, editável pelo painel do cliente.',
                'status'      => 'active',
            ]
        );
        $this->info("Template: {$template->name} (#{$template->id})");

        $version = TemplateVersion::firstOrCreate(
            ['template_id' => $template->id, 'version' => 'v1'],
            ['path' => 'evidenciar/v1', 'is_active' => true]
        );
        if (!$version->is_active) {
            $version->update(['is_active' => true]);
        }
        $this->info("TemplateVersion: v1 (#{$version->id}), path={$version->path}");

        $client = Client::firstOrCreate(
            ['name' => 'Evidenciar'],
            ['document' => null, 'status' => 'active']
        );
        $this->info("Client: {$client->name} (#{$client->id})");

        $ownerEmail = $this->option('owner-email');
        $owner = User::where('email', $ownerEmail)->first();
        if ($owner && !$owner->client_id) {
            $owner->update(['client_id' => $client->id]);
            $this->info("Usuário {$ownerEmail} vinculado ao Client Evidenciar.");
        } elseif ($owner) {
            $this->info("Usuário {$ownerEmail} já tinha client_id definido, não sobrescrevi.");
        } else {
            $this->warn("Usuário {$ownerEmail} não encontrado — pulei o vínculo.");
        }

        $site = Site::withTrashed()->where('client_id', $client->id)->where('slug', 'evidenciar-home')->first();

        $defaultContent = [
            'hero' => [
                'headline'    => 'Sua marca pessoal no topo. O palco digital que ancora sua autoridade.',
                'subheadline' => 'Reúna suas palestras, mentorias e contatos em um site que reflete o seu verdadeiro valor. Feito para quem vende conhecimento.',
                'tags'        => 'Palestrantes, Mentores, Coaches, Professores',
                'image_url'   => '',
            ],
            'about' => [
                'title_1'     => 'Cobrar caro exige parecer premium.',
                'text_1'      => 'Sua expertise vale caro, mas o seu site (ou a falta dele) está entregando isso pro seu público? Um perfil de rede social bagunçado, sem organização, dilui sua autoridade e faz o cliente questionar seu preço antes mesmo de te conhecer.',
                'image_1_url' => '',
                'title_2'     => 'Ancoragem de Preço Imediata',
                'image_2_url' => '',
            ],
            'howitworks' => [
                'title'    => 'Do zero ao seu palco digital em 3 passos (Zero Código)',
                'subtitle' => 'O maior medo de quem nunca teve site não é o preço, é achar que não vai saber usar. Na Evidenciar você mesmo cria o seu hoje — se sabe mandar um e-mail, sabe editar seu site.',
            ],
            'templates_section' => [
                'title'    => 'Modelos desenhados para colocar você em evidência',
                'subtitle' => 'Esqueça a tela em branco e o design amador. Nossos templates foram estruturados dentro do que cada profissão exige — sério, sóbrio e pensado pra gerar autoridade pra você.',
            ],
            'professionals' => [
                'title'    => 'A escolha de Profissionais que crescem',
                'subtitle' => 'Profissionais de alto nível não perdem tempo com ferramentas amadoras. Veja o impacto imediato que uma vitrine digital séria trouxe para a credibilidade e para os honorários de quem já usa a Evidenciar.',
            ],
            'pricing_header' => [
                'title'    => 'Menos que a venda de um único ingresso ou sessão.',
                'subtitle' => 'Escolha o plano ideal para o momento da sua carreira.',
            ],
        ];

        if (!$site) {
            $site = Site::create([
                'client_id'           => $client->id,
                'template_version_id' => $version->id,
                'name'                => 'Evidenciar — Home institucional',
                'slug'                => 'evidenciar-home',
                'status'              => 'draft',
                'content'             => $defaultContent,
            ]);
            $this->info("Site criado (#{$site->id}).");
        } else {
            if ($site->trashed()) {
                $site->restore();
            }
            $site->template_version_id = $version->id;
            if (empty($site->content)) {
                $site->content = $defaultContent;
            }
            $site->save();
            $this->info("Site já existia (#{$site->id}), atualizado.");
        }

        $html = $builder->build($site);
        // 'compiled_html' não está no $fillable do model Site — update()
        // descartaria o valor silenciosamente (sem erro nenhum). Setando
        // o atributo direto e salvando pra garantir persistência real.
        $site->status = 'published';
        $site->compiled_html = $html;
        $site->save();
        $this->info('compiled_html gerado (' . strlen($html) . ' bytes) e site publicado.');

        foreach (['evidenciar.com.br', 'www.evidenciar.com.br'] as $hostname) {
            $domain = Domain::withTrashed()->where('domain', $hostname)->first();
            if (!$domain) {
                $domain = new Domain(['domain' => $hostname, 'site_id' => $site->id, 'status' => 'active']);
                $domain->client_id = $client->id;
                $domain->save();
            } else {
                if ($domain->trashed()) {
                    $domain->restore();
                }
                $domain->site_id = $site->id;
                $domain->status = 'active';
                $domain->client_id = $client->id;
                $domain->save();
            }
            $this->info("Domain {$hostname} -> Site #{$site->id}");
        }

        $this->newLine();
        $this->info('Bootstrap concluído. evidenciar.com.br e www.evidenciar.com.br agora servem este Site via PublicSiteController::showByDomain.');

        return self::SUCCESS;
    }
}

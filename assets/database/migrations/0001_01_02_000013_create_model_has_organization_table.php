<?php

use Hanafalah\ModuleOrganization\Models\ModelHasOrganization;
use Hanafalah\ModuleOrganization\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.ModelHasOrganization', ModelHasOrganization::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->string("organization_type", 50);
                $table->string("organization_id", 36);
                $table->string("reference_type", 50);
                $table->string("reference_id", 36);
                $table->unsignedTinyInteger('current')->default(1);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['organization_type', 'organization_id'], 'mho_org_org');
                $table->index(['reference_type', 'reference_id'], 'mho_org_ref');
                $table->index('reference_type', 'type_org');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};

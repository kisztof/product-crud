<?php

declare(strict_types=1);

use App\Models\Tax;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->longText('description');
            $table->bigInteger('price');
            $table->char('tax_id', 1)->references('id')->on('taxes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

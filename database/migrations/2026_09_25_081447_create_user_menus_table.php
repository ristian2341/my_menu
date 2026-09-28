<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_menus', function (Blueprint $table) {
            $table->id();
            $table->string('code_menu', 50)->unique()->comment('Kode unik menu, contoh: MNU001');
            $table->string('nama', 150)->comment('Nama tampilan menu');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('ID parent menu (null = root)');
            $table->boolean('is_header')->default(false)->comment('Tampil sebagai header/divider grup');
            $table->string('url', 255)->nullable()->comment('URL / route name tujuan menu');
            $table->boolean('can_create')->default(false)->comment('Hak akses tambah data');
            $table->boolean('can_update')->default(false)->comment('Hak akses ubah data');
            $table->boolean('can_delete')->default(false)->comment('Hak akses hapus data');
            $table->boolean('can_view')->default(true)->comment('Hak akses lihat data');
            $table->boolean('is_active')->default(true)->comment('Status aktif / non-aktif');
            $table->integer('sort_order')->default(0)->comment('Urutan tampil menu');
            $table->string('icon', 100)->nullable()->comment('Icon class atau emoji');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('user_menus')
                  ->onDelete('cascade');

            $table->index(['parent_id', 'sort_order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_menus');
    }
};

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
        Schema::create('book_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("book_id");
            $table->unsignedBigInteger("quantity")->defaults(1);
            $table->foreign("order_id")->references("id")->on("orders");
            $table->foreign("book_id")->references("id")->on("books");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_order');
        Schema::table("book_order", function(Blueprint $table) {
            $table->dropForeign(["order_id"]);
            $table->dropForeign(["book_id"]);
        });
    }
};

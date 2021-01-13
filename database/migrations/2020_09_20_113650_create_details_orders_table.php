<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_orders', function (Blueprint $table) {

            $table->bigInteger('order_id')->unsigned()->required();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->bigInteger('product_id')->unsigned()->required();
            $table->foreign('product_id')->references('id')->on('products');

            $table->smallInteger('quantity');
            $table->double('price', 11, 2);
            $table->timestamps();

            $table->unique(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details_orders');
    }
}

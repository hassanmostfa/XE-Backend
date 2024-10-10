<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->foreignId('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('payment_status', ['paid', 'pending' , 'failed' , 'cancelled']);
            $table->enum('payment_gate', ['stripe', 'paypal' , 'mada' , 'cash']);
            $table->enum('booking_status', ['pending', 'approved', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};

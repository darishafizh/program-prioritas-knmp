<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create konstruksi_knmp table
        Schema::create('konstruksi_knmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knmp_id')->constrained('knmp')->onDelete('cascade');
            $table->foreignId('jasa_konstruksi_id')->nullable()->constrained('penyedia_jasa_konstruksi')->onDelete('set null');
            $table->date('tanggal_mulai')->nullable();
            $table->timestamps();
        });

        // 2. Add knmp_konstruksi_id to tahap_konstruksi
        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            $table->unsignedBigInteger('knmp_konstruksi_id')->nullable()->after('id');
        });

        // 3. Migrate existing data from tahap_konstruksi to konstruksi_knmp
        // We select distinct combinations of knmp_id, jasa_konstruksi_id, and tanggal_mulai
        $uniqueConstructions = DB::table('tahap_konstruksi')
            ->select('knmp_id', 'jasa_konstruksi_id', 'tanggal_mulai')
            ->distinct()
            ->get();

        foreach ($uniqueConstructions as $item) {
            // Insert into the new table
            $newId = DB::table('konstruksi_knmp')->insertGetId([
                'knmp_id' => $item->knmp_id,
                'jasa_konstruksi_id' => $item->jasa_konstruksi_id,
                'tanggal_mulai' => $item->tanggal_mulai,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update tahap_konstruksi records to point to the new ID
            DB::table('tahap_konstruksi')
                ->where('knmp_id', $item->knmp_id)
                ->where(function($q) use ($item) {
                    if ($item->jasa_konstruksi_id) {
                        $q->where('jasa_konstruksi_id', $item->jasa_konstruksi_id);
                    } else {
                        $q->whereNull('jasa_konstruksi_id');
                    }
                })
                ->where(function($q) use ($item) {
                    if ($item->tanggal_mulai) {
                        $q->where('tanggal_mulai', $item->tanggal_mulai);
                    } else {
                        $q->whereNull('tanggal_mulai');
                    }
                })
                ->update(['knmp_konstruksi_id' => $newId]);
        }

        // 4. Drop old columns from tahap_konstruksi and finalize schema
        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            // Drop foreign keys using their exact names from the DB structure
            $table->dropForeign('timeline_pengerjaan_knmp_id_foreign');
            $table->dropForeign('tahap_konstruksi_jasa_konstruksi_id_foreign');
            
            // Drop columns
            $table->dropColumn(['knmp_id', 'jasa_konstruksi_id', 'tanggal_mulai']);
            
            // Add foreign key for the new column
            $table->foreign('knmp_konstruksi_id')->references('id')->on('konstruksi_knmp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            $table->dropForeign(['knmp_konstruksi_id']);
            
            $table->unsignedBigInteger('knmp_id')->nullable()->after('knmp_konstruksi_id');
            $table->unsignedBigInteger('jasa_konstruksi_id')->nullable()->after('knmp_id');
            $table->date('tanggal_mulai')->nullable()->after('jasa_konstruksi_id');
        });

        // Restore data from konstruksi_knmp back to tahap_konstruksi
        $constructions = DB::table('konstruksi_knmp')->get();
        foreach ($constructions as $c) {
            DB::table('tahap_konstruksi')
                ->where('knmp_konstruksi_id', $c->id)
                ->update([
                    'knmp_id' => $c->knmp_id,
                    'jasa_konstruksi_id' => $c->jasa_konstruksi_id,
                    'tanggal_mulai' => $c->tanggal_mulai,
                ]);
        }

        Schema::table('tahap_konstruksi', function (Blueprint $table) {
            $table->dropColumn('knmp_konstruksi_id');
            
            $table->foreign('knmp_id', 'timeline_pengerjaan_knmp_id_foreign')
                ->references('id')
                ->on('knmp')
                ->onDelete('cascade');
                
            $table->foreign('jasa_konstruksi_id', 'tahap_konstruksi_jasa_konstruksi_id_foreign')
                ->references('id')
                ->on('penyedia_jasa_konstruksi')
                ->onDelete('set null');
        });

        Schema::dropIfExists('konstruksi_knmp');
    }
};

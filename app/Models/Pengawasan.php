<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengawasan extends Model
{
    use HasFactory;

    protected $table = 'pengawasans';

    protected $fillable = [
        'tipe',
        'jenis',
        'wilayah',
        'pemeriksa',
        'status_LHP',
        'id_penugasan',
        'tglkeluar',
        'alasan_verifikasi',
        'tgl_verifikasi'
    ];

    protected $dates = [
        'tglkeluar',
        'tgl_verifikasi'
    ];

    /**
     * Get the data dukung for the pengawasan
     */
    public function dataDukung()
    {
        return $this->hasMany(DataDukung::class, 'id_pengawasan');
    }

    /**
     * Get jenis temuan (rekomendasi) for the pengawasan
     */
    public function jenisTemuan()
    {
        return $this->hasMany(Jenis_temuan::class, 'id_pengawasan');
    }

    /**
     * Get detailed penugasan data via API
     */
    public function getPenugasanDataAttribute()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get("http://127.0.0.1:8000/api/penugasan-edit/{$this->id_penugasan}", [
                'query' => ['token' => session('ctoken')]
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                return $data['data'] ?? null;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching penugasan data: ' . $e->getMessage());
        }

        return null;
    }
}

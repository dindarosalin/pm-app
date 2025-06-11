<?php

namespace App\Exports;

use App\Models\Approval\rab;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RabExport implements FromCollection, WithHeadings
{
    protected $rabId;

    public function __construct($rabId)
    {
        $this->rabId = $rabId;
    }

    /**
     * Mengambil koleksi data berdasarkan rabId
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Asumsikan getRabWithDetails mengembalikan collection data yang ingin di-export
        return rab::getRabWithDetails($this->rabId);
    }

    /**
     * Mendefinisikan header kolom Excel
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID RAB',
            'Nama',
            'No Telepon',
            'Email',
            'Jabatan',
            'Atasan',
            'Jenis RAB',
            'Kebutuhan',
            'Deskripsi',
            'UOM',
            'Kuantitas',
            'Harga Satuan',
            'Total Per Item',
            'Tanggal Dibuat',
        ];
    }
}


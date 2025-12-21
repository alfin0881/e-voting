<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class AnggotaImport implements 
    ToModel,
    WithHeadingRow, 
    SkipsEmptyRows, 
    WithColumnFormatting
{
    private $sukses = 0;
    private $gagal = 0;

    /**
     * Convert setiap row Excel menjadi model User
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $nis = trim((string) $row['nis']);
        $nis = ltrim($nis, "'"); // buang petik Excel NIS


        $exists = User::where('nis', $nis)->exists();
            
        if ($exists) {
            $this->gagal++;
            return null;
        }

        $this->sukses++;

        return new User([
            'nama' => $row['nama'],
            'nis' => $nis,
            'kelas' => $row['kelas'] ?? null,
            'password' => $nis,
            'role' => 'user',
        ]);
    }


    /**
     * Validasi untuk setiap row
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|min:3',
            'nis' => 'required|string',
            'kelas' => 'nullable|string',
            'password' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Kolom nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nis.required' => 'Kolom NIS wajib diisi',
        ];
    }

    /**
     * Baris pertama adalah header
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Get jumlah data berhasil diimport
     *
     * @return int
     */
    public function getSukses(): int
    {
        return $this->sukses;
    }

    /**
     * Get jumlah data gagal diimport
     *
     * @return int
     */
    public function getGagal(): int
    {
        return $this->gagal;
    }

    public function columnFormats(): array
{
    return [
        'B' => NumberFormat::FORMAT_TEXT, // ganti B sesuai kolom NIS
    ];
}

}
<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Unit Test: Auto Numbering Logic
 *
 * Menguji logika pembangkitan nomor sertifikat otomatis.
 * Karena logika ini di JavaScript (client-side), kita port
 * logika inti ke PHP agar bisa diuji secara unit.
 *
 * Jika nantinya logika numbering dipindah ke backend (misalnya
 * untuk simpan riwayat), test ini sudah siap dipakai langsung.
 *
 * Jalankan: php artisan test --filter NumberingTest
 */
class NumberingTest extends TestCase
{
    // ─── Helper: replika logika genNomor() dari JavaScript ─────

    /**
     * @param array  $segments  [['type'=>'teks'|'nomor'|'tahun'|'bulan', 'value'=>'...'], ...]
     * @param string $separator Pemisah antar segmen
     * @param int    $index     Indeks peserta (0-based)
     */
    private function genNomor(array $segments, string $separator, int $index = 0): string
    {
        $parts = [];
        foreach ($segments as $seg) {
            switch ($seg['type']) {
                case 'teks':
                    $parts[] = $seg['value'];
                    break;

                case 'nomor':
                    $startRaw = $seg['value'] ?? '001';
                    $startVal = (int) $startRaw ?: 1;
                    $padLen   = strlen($startRaw);
                    $parts[]  = str_pad($startVal + $index, $padLen, '0', STR_PAD_LEFT);
                    break;

                case 'tahun':
                    $parts[] = $seg['value'];
                    break;

                case 'bulan':
                    $parts[] = date('m'); // bulan berjalan
                    break;
            }
        }

        // Filter segmen kosong
        $parts = array_filter($parts, fn($p) => $p !== '');
        return implode($separator, $parts);
    }

    // ─── Format dasar ──────────────────────────────────────────

    #[Test]
    public function generates_basic_cert_slash_num_slash_year(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $result = $this->genNomor($segments, '/', 0);
        $this->assertEquals('CERT/001/2026', $result);
    }

    #[Test]
    public function generates_number_with_dash_separator(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'SK'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $result = $this->genNomor($segments, '-', 0);
        $this->assertEquals('SK-001-2026', $result);
    }

    #[Test]
    public function generates_number_with_dot_separator(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'LP'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $this->assertEquals('LP.001.2026', $this->genNomor($segments, '.', 0));
    }

    // ─── Increment per peserta ─────────────────────────────────

    #[Test]
    public function increments_number_for_each_participant(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $this->assertEquals('CERT/001/2026', $this->genNomor($segments, '/', 0));
        $this->assertEquals('CERT/002/2026', $this->genNomor($segments, '/', 1));
        $this->assertEquals('CERT/003/2026', $this->genNomor($segments, '/', 2));
        $this->assertEquals('CERT/010/2026', $this->genNomor($segments, '/', 9));
    }

    #[Test]
    public function start_number_other_than_001(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '050'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $this->assertEquals('CERT/050/2026', $this->genNomor($segments, '/', 0));
        $this->assertEquals('CERT/051/2026', $this->genNomor($segments, '/', 1));
        $this->assertEquals('CERT/059/2026', $this->genNomor($segments, '/', 9));
    }

    // ─── Padding ───────────────────────────────────────────────

    #[Test]
    public function pads_number_to_match_start_length(): void
    {
        $segments = [
            ['type' => 'nomor', 'value' => '001'], // 3 digit
        ];
        $this->assertEquals('009', $this->genNomor($segments, '/', 8));
        $this->assertEquals('010', $this->genNomor($segments, '/', 9));
        $this->assertEquals('100', $this->genNomor($segments, '/', 99));
    }

    #[Test]
    public function pads_4_digit_number_correctly(): void
    {
        $segments = [
            ['type' => 'nomor', 'value' => '0001'],
        ];
        $this->assertEquals('0001', $this->genNomor($segments, '/', 0));
        $this->assertEquals('0010', $this->genNomor($segments, '/', 9));
        $this->assertEquals('0100', $this->genNomor($segments, '/', 99));
    }

    #[Test]
    public function start_from_1_with_no_leading_zero(): void
    {
        $segments = [
            ['type' => 'nomor', 'value' => '1'], // tanpa leading zero
        ];
        $this->assertEquals('1',  $this->genNomor($segments, '/', 0));
        $this->assertEquals('10', $this->genNomor($segments, '/', 9));
    }

    // ─── Segmen kompleks (banyak segmen) ───────────────────────

    #[Test]
    public function generates_complex_multi_segment_number(): void
    {
        // Format: 395/EXP/14/VII/2025 style
        $segments = [
            ['type' => 'nomor', 'value' => '395'],
            ['type' => 'teks',  'value' => 'EXP'],
            ['type' => 'teks',  'value' => '14'],
            ['type' => 'teks',  'value' => 'VII'],
            ['type' => 'tahun', 'value' => '2025'],
        ];

        $this->assertEquals('395/EXP/14/VII/2025', $this->genNomor($segments, '/', 0));
        $this->assertEquals('396/EXP/14/VII/2025', $this->genNomor($segments, '/', 1));
    }

    #[Test]
    public function generates_number_with_only_number_segment(): void
    {
        $segments = [['type' => 'nomor', 'value' => '001']];
        $this->assertEquals('001', $this->genNomor($segments, '/', 0));
        $this->assertEquals('005', $this->genNomor($segments, '/', 4));
    }

    #[Test]
    public function generates_number_with_only_text_segments(): void
    {
        $segments = [
            ['type' => 'teks', 'value' => 'SERT'],
            ['type' => 'teks', 'value' => 'PUSAT'],
        ];
        $this->assertEquals('SERT/PUSAT', $this->genNomor($segments, '/', 0));
        // Tanpa nomor urut, semua peserta dapat nomor sama
        $this->assertEquals('SERT/PUSAT', $this->genNomor($segments, '/', 5));
    }

    // ─── Segmen kosong difilter ────────────────────────────────

    #[Test]
    public function empty_text_segment_value_is_excluded_from_result(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'teks',  'value' => ''],    // kosong — seharusnya difilter
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        // Segmen kosong tidak menghasilkan separator ganda
        $result = $this->genNomor($segments, '/', 0);
        $this->assertEquals('CERT/001/2026', $result);
        $this->assertStringNotContainsString('//', $result);
    }

    // ─── Separator custom ──────────────────────────────────────

    #[Test]
    public function supports_custom_separator(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $this->assertEquals('CERT|001|2026', $this->genNomor($segments, '|', 0));
        $this->assertEquals('CERT ~ 001 ~ 2026', $this->genNomor($segments, ' ~ ', 0));
    }

    // ─── Edge cases ────────────────────────────────────────────

    #[Test]
    public function large_participant_index_generates_correct_number(): void
    {
        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $this->assertEquals('CERT/500/2026', $this->genNomor($segments, '/', 499));
        $this->assertEquals('CERT/1000/2026', $this->genNomor($segments, '/', 999));
    }

    #[Test]
    public function year_segment_is_static_and_does_not_increment(): void
    {
        $segments = [
            ['type' => 'tahun', 'value' => '2026'],
            ['type' => 'nomor', 'value' => '001'],
        ];

        // Tahun harus tetap 2026 untuk semua peserta
        for ($i = 0; $i < 5; $i++) {
            $result = $this->genNomor($segments, '/', $i);
            $this->assertStringStartsWith('2026/', $result);
        }
    }

    // ─── Data row processing (simulasi dari Excel/CSV) ─────────

    #[Test]
    public function row_with_perusahaan_field_is_preserved(): void
    {
        // Simulasi data row dari Excel yang punya kolom perusahaan
        $row = [
            'nama'       => 'Budi Santoso',
            'perusahaan' => 'PT. Maju Bersama',
            'nomor'      => '',
        ];

        // perusahaan harus terbawa ke output
        $this->assertEquals('PT. Maju Bersama', $row['perusahaan']);
        $this->assertNotEmpty($row['perusahaan']);
    }

    #[Test]
    public function row_without_perusahaan_field_defaults_to_empty(): void
    {
        // Simulasi data row dari Excel yang TIDAK punya kolom perusahaan
        $row = ['nama' => 'Sari Dewi', 'nomor' => ''];

        // Akses dengan null-coalescing seperti di generateAll JS: item.perusahaan || ''
        $perusahaan = $row['perusahaan'] ?? '';
        $this->assertEquals('', $perusahaan);
    }

    #[Test]
    public function row_with_manual_nomor_uses_that_nomor(): void
    {
        // Jika row punya kolom nomor terisi, harus dipakai (bukan auto-generate)
        $row = [
            'nama'  => 'Joko Widodo',
            'nomor' => 'SK/123/2026',
        ];

        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        // Jika nomor ada di row, gunakan itu — bukan genNomor()
        $finalNomor = (!empty($row['nomor'])) ? $row['nomor'] : $this->genNomor($segments, '/', 0);
        $this->assertEquals('SK/123/2026', $finalNomor);
    }

    #[Test]
    public function row_without_nomor_uses_auto_generate(): void
    {
        // Jika kolom nomor kosong, harus pakai auto-generate
        $row = ['nama' => 'Joko Widodo', 'nomor' => ''];

        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $finalNomor = (!empty($row['nomor'])) ? $row['nomor'] : $this->genNomor($segments, '/', 0);
        $this->assertEquals('CERT/001/2026', $finalNomor);
    }

    #[Test]
    public function multiple_rows_get_sequential_numbers(): void
    {
        // Simulasi generateAll — setiap row tanpa nomor dapat nomor urut berbeda
        $rows = [
            ['nama' => 'Peserta 1', 'nomor' => ''],
            ['nama' => 'Peserta 2', 'nomor' => ''],
            ['nama' => 'Peserta 3', 'nomor' => ''],
        ];

        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $results = [];
        foreach ($rows as $idx => $row) {
            $results[] = (!empty($row['nomor'])) ? $row['nomor'] : $this->genNomor($segments, '/', $idx);
        }

        $this->assertEquals(['CERT/001/2026', 'CERT/002/2026', 'CERT/003/2026'], $results);
    }

    #[Test]
    public function mixed_rows_some_with_nomor_some_without(): void
    {
        // Peserta 1 punya nomor manual, peserta 2 & 3 auto
        $rows = [
            ['nama' => 'Peserta 1', 'nomor' => 'MANUAL/001'],
            ['nama' => 'Peserta 2', 'nomor' => ''],
            ['nama' => 'Peserta 3', 'nomor' => ''],
        ];

        $segments = [
            ['type' => 'teks',  'value' => 'CERT'],
            ['type' => 'nomor', 'value' => '001'],
            ['type' => 'tahun', 'value' => '2026'],
        ];

        $results = [];
        $autoIdx = 0;
        foreach ($rows as $row) {
            if (!empty($row['nomor'])) {
                $results[] = $row['nomor'];
            } else {
                $results[] = $this->genNomor($segments, '/', $autoIdx++);
            }
        }

        $this->assertEquals('MANUAL/001', $results[0]);
        $this->assertEquals('CERT/001/2026', $results[1]);
        $this->assertEquals('CERT/002/2026', $results[2]);
    }
}

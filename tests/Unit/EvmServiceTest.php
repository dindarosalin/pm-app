<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\EvmService;

class EvmServiceTest extends TestCase
{

    // private function mockProject($task, $bac, $pv, $ev, $ac): object
    // {
    //     return (object) [
    //         'project_id' => 1,
    //         'project_title' => 'Test Project',
    //         'total_task' => $task,
    //         'bac' => $bac,
    //         'planned_done_task' => $pv,
    //         'actual_done_task' => $ev,
    //         'ac' => $ac
    //     ];
    // }


    /**
     * TC-001: CPI > 1 (Efisien biaya)
     */
    public function testCpiEfisien()
    {
        $project = (object)[
            'project_id' => 1,
            'project_title' => 'Test Project',
            'total_task' => 120, // actual_done_task = 12, planned_done_task = 10
            'planned_done_task' => 100, // PV = 100
            'actual_done_task' => 120,  // EV = 120
            'bac' => 120,              // BAC digunakan sebagai PV dasar
            'ac' => 100
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.2, round($result['cpi'], 2));
    }

    /**
     * TC-002: CPI < 1 (Tidak efisien)
     */
    public function testCpiTidakEfisien()
    {
        $project = (object)[
            'project_id' => 2,
            'project_title' => 'Test Project',
            'total_task' => 200,
            'planned_done_task' => 200, // PV = 200
            'actual_done_task' => 150,  // EV = 150
            'bac' => 200,
            'ac' => 180
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(0.83, round($result['cpi'], 2));
    }

    /**
     * TC-003: CPI = 1 (Seimbang)
     */
    public function testCpiSeimbang()
    {
        $project = (object)[
            'project_id' => 3,
            'project_title' => 'Test Project',
            'total_task' => 150,
            'planned_done_task' => 150,
            'actual_done_task' => 150,
            'bac' => 150,
            'ac' => 150
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.0, $result['cpi']);
    }

    /**
     * TC-004: SPI > 1 (Cepat jadwal)
     */
    public function testSpiCepatJadwal()
    {
        $project = (object)[
            'project_id' => 4,
            'project_title' => 'Test Project',
            'total_task' => 120, // actual_done_task = 120, planned_done_task = 100
            'planned_done_task' => 100, // PV = 100
            'actual_done_task' => 120,  // EV = 120
            'bac' => 100,
            'ac' => 110
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.2, $result['spi']);
    }

    /**
     * TC-005: SPI < 1 (Terlambat jadwal)
     */
    public function testSpiTerlambat()
    {
        $project = (object)[
            'project_id' => 5,
            'project_title' => 'Test Project',
            'total_task' => 200,
            'planned_done_task' => 200, // PV = 200
            'actual_done_task' => 150,  // EV = 150
            'bac' => 200,
            'ac' => 150
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(0.75, round($result['spi'], 2));
    }

    /**
     * TC-006: SPI Seimbang (=1)
     */
    public function testSpiSeimbang()
    {
        $project = (object)[
            'project_id' => 6,
            'project_title' => 'Test Project',
            'total_task' => 150,
            'planned_done_task' => 150, // PV = 150
            'actual_done_task' => 150,  // EV = 150
            'bac' => 150,
            'ac' => 160
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.0, $result['spi']);
    }

    /**
     * TC-007: PV Nol
     */
    public function testPvNol()
    {
        $project = (object)[
            'project_id' => 7,
            'project_title' => 'Test Project',
            'total_task' => 0,
            'planned_done_task' => 0, // PV = 0
            'actual_done_task' => 150,  // EV = 150
            'bac' => 150,
            'ac' => 150
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(0, $result['planned_value']);
        $this->assertEquals(0, $result['spi']); // Aturan sekarang: SPI = 0 jika PV = 0
    }

    /**
     * TC-008: AC Nol
     */
    public function testAcNol()
    {
        $project = (object)[
            'project_id' => 8,
            'project_title' => 'Test Project',
            'total_task' => 10,
            'planned_done_task' => 10, // PV = 100
            'actual_done_task' => 10,  // EV = 100
            'bac' => 100,
            'ac' => 0
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(0, $result['actual_cost']);
        $this->assertEquals(0, $result['cpi']); // Aturan sekarang: CPI = 0 jika AC = 0
    }

    /**
     * TC-009: EV Nol (Proyek Belum Dimulai)
     */
    public function testEvNol()
    {
        $project = (object)[
            'project_id' => 9,
            'project_title' => 'Test Project',
            'total_task' => 10,
            'planned_done_task' => 10, // PV = 100
            'actual_done_task' => 0,  // EV = 0
            'bac' => 100,
            'ac' => 50
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(100, $result['planned_value']);
        $this->assertEquals(0, $result['earned_value']);
        $this->assertEquals(50, $result['actual_cost']);
        $this->assertEquals(0, $result['cpi']); // Aturan sekarang: CPI = 0 jika EV = 0
        $this->assertEquals(0, $result['spi']); // Aturan sekarang: SPI = 0 jika EV = 0
    }

    /**
     * TC-010: AC Lebih Besar dari EV
     */
    public function testAcLebihBesarDariEv()
    {
        $project = (object)[
            'project_id' => 10,
            'project_title' => 'Test Project',
            'total_task' => 200,
            'planned_done_task' => 200, // PV = 200
            'actual_done_task' => 150,  // EV = 150
            'bac' => 200,
            'ac' => 250
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(0.6, round($result['cpi'], 2));
    }

    /**
     * TC-011: EV Lebih Besar dari PV
     */
    public function testEvLebihBesarDariPv()
    {
        $project = (object)[
            'project_id' => 11,
            'project_title' => 'Test Project',
            'total_task' => 100,
            'planned_done_task' => 100, // PV = 100
            'actual_done_task' => 120,  // EV = 120
            'bac' => 100,
            'ac' => 100
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.2, $result['spi']);
    }

    /**
     * TC-012: PV = EV = AC
     */
    public function testPvEvAcSama()
    {
        $project = (object)[
            'project_id' => 12,
            'project_title' => 'Test Project',
            'total_task' => 200,
            'planned_done_task' => 200, // PV = 200
            'actual_done_task' => 200,  // EV = 200
            'bac' => 200,
            'ac' => 200
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.0, $result['cpi']);
        $this->assertEquals(1.0, $result['spi']);
    }

    /**
     * TC-013: EV > PV dan AC > EV
     */
    public function testEvLebihBesarDariPvDanAcLebihBesarDariEv()
    {
        $project = (object)[
            'project_id' => 13,
            'project_title' => 'Test Project',
            'total_task' => 100,
            'planned_done_task' => 100, // PV = 100
            'actual_done_task' => 120,  // EV = 120
            'bac' => 100,
            'ac' => 150
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(1.2, $result['spi']);
        $this->assertEquals(0.8, round($result['cpi'], 2));
    }

    /**
     * TC-014: Semua Input Nol
     */
    public function testSemuaInputNol()
    {
        $project = (object)[
            'project_id' => 14,
            'project_title' => 'Test Project',
            'total_task' => 0,
            'planned_done_task' => 0, // PV = 0
            'actual_done_task' => 0,  // EV = 0
            'bac' => 0,
            'ac' => 0
        ];
        $result = EvmService::calculateEVM($project);
        $this->assertEquals(0, $result['planned_value']);
        $this->assertEquals(0, $result['earned_value']);
        $this->assertEquals(0, $result['actual_cost']);
        $this->assertEquals(0, $result['spi']);
        $this->assertEquals(0, $result['cpi']);
    }

    /**
     * TC-015: Data Negatif (Error Handling)
     */
    public function testDataNegatif()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Nilai tidak boleh negatif');
        $project = (object)[
            'project_id' => 15,
            'project_title' => 'Test Project',
            'total_task' => 10,
            'planned_done_task' => -100, // PV = -100
            'actual_done_task' => -50,  // EV = -50
            'bac' => -30,
            'ac' => -30
        ];
        EvmService::calculateEVM($project);
    }
}

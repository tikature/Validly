<?php

namespace Tests\Feature\Certificate;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Feature Test: Certificate Generator Page
 *
 * Menguji akses, proteksi route, dan konten halaman generator sertifikat.
 * Setelah refactoring, halaman ini dipecah jadi partials:
 *   - certificate/index.blade.php          (layout utama)
 *   - certificate/partials/_settings.blade.php
 *   - certificate/partials/_signature.blade.php
 *   - certificate/partials/_numbering.blade.php
 *   - certificate/partials/_participants.blade.php
 * JS ada di: public/js/certificate/generator.js
 *
 * Jalankan: php artisan test --filter CertificatePageTest
 */
class CertificatePageTest extends TestCase
{
    use RefreshDatabase;

    private Institution $institution;
    private User        $admin;
    private User        $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->institution = Institution::factory()->create(['name' => 'Lembaga Test']);
        $this->admin       = User::factory()->adminOf($this->institution)->create();
        $this->superAdmin  = User::factory()->superAdmin()->create();
    }

    // ── Akses halaman ──────────────────────────────────────────────

    #[Test]
    public function admin_can_access_certificate_page(): void
    {
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertStatus(200)
            ->assertSee('Generator Sertifikat');
    }

    #[Test]
    public function guest_cannot_access_certificate_page(): void
    {
        $this->get(route('certificate.index'))
            ->assertRedirect(route('login'));
    }

    #[Test]
    public function super_admin_cannot_access_certificate_page(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(route('certificate.index'))
            ->assertForbidden();
    }

    #[Test]
    public function inactive_admin_cannot_access_certificate_page(): void
    {
        $inactiveAdmin = User::factory()->adminOf($this->institution)->inactive()->create();

        $this->actingAs($inactiveAdmin)
            ->get(route('certificate.index'))
            ->assertRedirect(route('login'));
    }

    // ── Konten dari partial views ──────────────────────────────────

    #[Test]
    public function page_shows_institution_name(): void
    {
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Lembaga Test');
    }

    #[Test]
    public function page_shows_settings_panel(): void
    {
        // _settings.blade.php
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Pengaturan Sertifikat')
            ->assertSee('Nama Acara')
            ->assertSee('Tempat Pelaksanaan');
    }

    #[Test]
    public function page_shows_language_toggle(): void
    {
        // _settings.blade.php — toggle ID/EN
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Indonesia')
            ->assertSee('English');
    }

    #[Test]
    public function page_shows_signature_panel(): void
    {
        // _signature.blade.php
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Tanda Tangan')
            ->assertSee('Cap / Stempel')
            ->assertSee('Logo Institusi');
    }

    #[Test]
    public function page_shows_numbering_panel(): void
    {
        // _numbering.blade.php
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Auto Numbering')
            ->assertSee('Segmen Nomor');
    }

    #[Test]
    public function page_shows_participants_panel(): void
    {
        // _participants.blade.php
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Data Peserta')
            ->assertSee('Input Manual')
            ->assertSee('Upload Excel/CSV');
    }

    #[Test]
    public function page_shows_asal_perusahaan_field_in_manual_tab(): void
    {
        // _participants.blade.php — field perusahaan opsional
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('Asal Perusahaan');
    }

    #[Test]
    public function page_shows_perusahaan_column_hint_in_upload_tab(): void
    {
        // _participants.blade.php — hint kolom perusahaan di drop zone
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee('perusahaan');
    }

    #[Test]
    public function page_shows_current_year_in_numbering(): void
    {
        $this->actingAs($this->admin)
            ->get(route('certificate.index'))
            ->assertSee(date('Y'));
    }

    // ── Landing page ───────────────────────────────────────────────

    #[Test]
    public function landing_page_is_publicly_accessible(): void
    {
        $this->get(route('landing'))
            ->assertStatus(200)
            ->assertSee('Validly');
    }

    #[Test]
    public function landing_page_shows_masuk_button(): void
    {
        $this->get(route('landing'))
            ->assertSee('Masuk');
    }

    #[Test]
    public function landing_page_shows_key_features(): void
    {
        $this->get(route('landing'))
            ->assertSee('Generator Massal')
            ->assertSee('Auto Numbering');
    }

    // ── Route protection summary ───────────────────────────────────

    #[Test]
    public function dashboard_route_requires_authentication(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    #[Test]
    public function superadmin_route_requires_authentication(): void
    {
        $this->get('/superadmin')->assertRedirect('/login');
    }
}

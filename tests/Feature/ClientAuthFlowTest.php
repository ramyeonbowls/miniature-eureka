<?php

namespace Tests\Feature;

use App\Http\Middleware\ActivatedUser;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ClientAuthFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'app.client_id' => 'gia',
            'app.db_platform' => 'platform',
            'session.driver' => 'array',
        ]);
        DB::purge('sqlite');
        app()->setLocale('id');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('client_id');
            $table->string('flag_approve');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('tparameter', function (Blueprint $table) {
            $table->string('client_id');
            $table->string('name');
            $table->string('value');
        });
        Schema::create('tattr_member', function (Blueprint $table) {
            $table->integer('id');
            $table->string('client_id');
            $table->string('nik')->nullable();
            $table->string('phone');
            $table->date('birthday');
            $table->string('gender');
            $table->timestamps();
        });
        Schema::create('tclient', function (Blueprint $table) {
            $table->string('client_id')->primary();
            $table->string('application_name')->nullable();
        });
        DB::table('tclient')->insert(['client_id' => 'gia', 'application_name' => 'Perpustakaan GIA']);
        DB::table('tparameter')->insert([
            ['client_id' => 'gia', 'name' => 'reg_member', 'value' => '1'],
            ['client_id' => 'gia', 'name' => 'app_reg_member', 'value' => '0'],
        ]);
    }

    private function registration(): array
    {
        return [
            'name' => 'Anggota', 'email' => 'member@example.test',
            'password' => 'password123', 'password_confirmation' => 'password123',
            'phone' => '08123456789', 'birthday' => '2000-01-02', 'gender' => 'L',
        ];
    }

    public function test_registration_sends_one_verification_and_prevents_unverified_access(): void
    {
        Notification::fake();
        $this->postJson('/mregist', $this->registration())->assertCreated()->assertSee('verifikasi email');
        $user = User::where('email', 'member@example.test')->firstOrFail();
        Notification::assertSentToTimes($user, VerifyEmail::class, 1);
        $this->assertGuest();

        $this->postJson('/login', ['email' => $user->email, 'password' => 'password123', 'from' => 'member'])
            ->assertOk()->assertJsonPath('redirect', route('verification.notice'));
        $this->get('/email/verify')->assertOk()->assertSee('Verifikasi Alamat Email Anda');
        $this->get('/getProfile')->assertRedirect(route('verification.notice'));
        $this->get('/')->assertRedirect(route('verification.notice'));
        $this->get('/mlogin')->assertRedirect(route('verification.notice'));
        $this->post('/email/resend')->assertRedirect()->assertSessionHas('resent');
        Notification::assertSentToTimes($user, VerifyEmail::class, 2);

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(30), [
            'id' => $user->id, 'hash' => sha1($user->email),
        ]);
        $this->get($url)->assertRedirect('/');
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_registration_errors_are_indonesian_and_role_cannot_be_supplied(): void
    {
        Notification::fake();
        $this->postJson('/mregist', array_merge($this->registration(), ['email' => 'invalid', 'gender' => 'X']))
            ->assertUnprocessable()->assertJsonPath('errors.email.0', 'Format Email tidak valid.')
            ->assertJsonPath('errors.gender.0', 'Pilihan Jenis kelamin tidak valid.');
        $this->postJson('/mregist', array_merge($this->registration(), ['role' => 'admin']))->assertCreated();
        $this->assertSame('member', User::firstOrFail()->role);
        $this->postJson('/mregist', $this->registration())->assertUnprocessable()
            ->assertJsonPath('errors.email.0', 'Email sudah terdaftar.');
    }

    public function test_password_reset_verifies_email_without_logging_in_and_uses_role_login(): void
    {
        Notification::fake();
        foreach (['member' => '/mlogin', 'admin' => '/login'] as $role => $login) {
            $user = User::create([
                'name' => $role, 'email' => $role.'@example.test', 'password' => 'old-password',
                'role' => $role, 'client_id' => 'gia', 'flag_approve' => 'Y',
            ]);
            $this->post('/password/email', ['email' => $user->email])->assertSessionHas('status');
            Notification::assertSentTo($user, ResetPassword::class);
            $token = Password::broker()->createToken($user);
            $this->post('/password/reset', [
                'email' => $user->email, 'token' => $token,
                'password' => 'new-password', 'password_confirmation' => 'new-password',
            ])->assertRedirect(route('password.success'))->assertSessionHas('password_reset_login', $login);
            $this->assertGuest();
            $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
            $this->assertNotNull($user->fresh()->email_verified_at);
            $this->get('/password/success')->assertOk()->assertSee(url($login));
        }
        $this->get('/password/success')->assertRedirect('/mlogin');
    }

    public function test_invalid_reset_token_and_verified_role_login(): void
    {
        $user = User::create([
            'name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'password123',
            'role' => 'admin', 'client_id' => 'gia', 'flag_approve' => 'Y', 'email_verified_at' => now(),
        ]);
        $this->from('/password/reset/invalid')->post('/password/reset', [
            'email' => $user->email, 'token' => 'invalid',
            'password' => 'new-password', 'password_confirmation' => 'new-password',
        ])->assertSessionHasErrors(['email' => 'Tautan pengaturan ulang kata sandi tidak valid atau telah kedaluwarsa.']);
        $this->assertTrue(Hash::check('password123', $user->fresh()->password));
        $this->postJson('/login', ['email' => $user->email, 'password' => 'password123'])
            ->assertOk()->assertJsonPath('redirect', '/admin');
    }

    public function test_unapproved_member_can_request_verification_but_cannot_use_account(): void
    {
        Notification::fake();
        $user = User::create([
            'name' => 'Anggota', 'email' => 'pending@example.test', 'password' => 'password123',
            'role' => 'member', 'client_id' => 'gia', 'flag_approve' => 'N',
        ]);
        $this->postJson('/login', ['email' => $user->email, 'password' => 'password123'])
            ->assertOk()->assertJsonPath('redirect', route('verification.notice'));
        $this->post('/email/resend')->assertSessionHas('resent');
        Notification::assertSentTo($user, VerifyEmail::class);
        $this->get('/')->assertRedirect(route('verification.notice'));
        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(30), [
            'id' => $user->id, 'hash' => sha1($user->email),
        ]);
        $this->get($url)->assertRedirect('/');
        $this->assertGuest();
        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->postJson('/login', ['email' => $user->email, 'password' => 'password123'])->assertForbidden();
        $this->assertGuest();
    }

    public function test_notification_templates_use_client_branding_and_fallback_link(): void
    {
        $user = User::create([
            'name' => 'Anggota', 'email' => 'member@example.test', 'password' => 'password123',
            'role' => 'member', 'client_id' => 'gia', 'flag_approve' => 'Y',
        ]);
        foreach ([new VerifyEmail, new ResetPassword('token')] as $notification) {
            $mail = $notification->toMail($user);
            $html = view($mail->view, $mail->viewData)->render();
            $this->assertStringContainsString('Perpustakaan GIA', $html);
            $this->assertStringContainsString('Jika tombol tidak berfungsi', $html);
            $this->assertStringContainsString('storage/images/logo/logo.png', $html);
        }
    }

    public function test_profile_request_updates_only_current_client_pending_record(): void
    {
        $this->withoutMiddleware(ActivatedUser::class);
        DB::statement("ATTACH DATABASE ':memory:' AS platform");
        $columns = [
            'instansi_name', 'address', 'country_id', 'provinsi_id', 'kabupaten_id',
            'kecamatan_id', 'kelurahan_id', 'kodepos', 'npwp', 'pers_responsible',
            'pos_pers_responsible', 'mou_sign_name', 'pos_sign_name', 'administrator_name',
            'administrator_phone', 'email', 'logo', 'logo_small', 'company_id', 'web_add',
            'agreement', 'client_category', 'client_level', 'flag_appr',
        ];
        Schema::table('tclient', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                $table->string($column)->nullable();
            }
            $table->timestamps();
        });
        Schema::create('platform.tclient_temp', function (Blueprint $table) use ($columns) {
            $table->id();
            $table->string('client_id');
            $table->string('application_name')->nullable();
            foreach ($columns as $column) {
                $table->string($column)->nullable();
            }
            $table->timestamps();
        });
        $admin = User::create([
            'name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'password123',
            'role' => 'admin', 'client_id' => 'gia', 'flag_approve' => 'Y', 'email_verified_at' => now(),
        ]);
        DB::table('platform.tclient_temp')->insert(['client_id' => 'other', 'flag_appr' => 'N']);
        $this->actingAs($admin)->withHeader('X-Requested-With', 'XMLHttpRequest');
        $this->getJson('/setting/profile/1?param=change-request')->assertJsonPath('change_request', 'N');

        $profile = [
            'application_name' => 'GIA', 'address' => 'Alamat', 'provinsi_id' => '1',
            'kabupaten_id' => '1', 'kecamatan_id' => '1', 'kelurahan_id' => '1',
            'pers_responsible' => 'Nama', 'pos_pers_responsible' => 'Jabatan',
            'mou_sign_name' => 'Nama', 'pos_sign_name' => 'Jabatan',
            'administrator_name' => 'Admin', 'administrator_phone' => '08123',
            'email' => 'invalid',
        ];
        $this->postJson('/setting/profile', $profile)->assertUnprocessable()
            ->assertJsonPath('errors.email.0', 'Format Email tidak valid.');
        $profile['email'] = 'client@example.test';
        $this->postJson('/setting/profile', $profile)->assertCreated();
        $profile['email'] = 'null';
        $this->postJson('/setting/profile', $profile)->assertCreated();
        $this->assertSame(1, DB::table('platform.tclient_temp')->where('client_id', 'gia')->where('flag_appr', 'N')->count());
        $this->assertNull(DB::table('platform.tclient_temp')->where('client_id', 'gia')->value('email'));
        $this->getJson('/setting/profile/1?param=change-request')->assertJsonPath('change_request', 'Y');

        DB::table('platform.tclient_temp')->where('client_id', 'gia')->update(['flag_appr' => 'Y']);
        $profile['email'] = 'new@example.test';
        $this->postJson('/setting/profile', $profile)->assertCreated();
        $this->assertSame(2, DB::table('platform.tclient_temp')->where('client_id', 'gia')->count());
        $this->assertSame('new@example.test', DB::table('platform.tclient_temp')->where('client_id', 'gia')->where('flag_appr', 'N')->value('email'));
        DB::table('platform.tclient_temp')->where('client_id', 'gia')->where('flag_appr', 'N')->update(['flag_appr' => 'R']);
        $this->postJson('/setting/profile', $profile)->assertCreated();
        $this->assertSame(3, DB::table('platform.tclient_temp')->where('client_id', 'gia')->count());
    }
}

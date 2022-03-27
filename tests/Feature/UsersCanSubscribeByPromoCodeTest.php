<?php

namespace Tests\Feature;

use App\Actions\Charter\SubscribeByPromoCode;
use App\Http\Livewire\EnterPromoCodeForm;
use App\Http\Livewire\UpdatePromoCodeForm;
use App\Http\Livewire\UpdateUserTypeForm;
use App\Models\User;
use App\Models\UserType;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UsersCanSubscribeByPromoCodeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_subscribe_by_promo_code()
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create());

        $this->withoutExceptionHandling();

        $component = Livewire::test(EnterPromoCodeForm::class)->set('state.promo_code', config('charter.promo_codes')[0])->call('subscribeByPromoCode');

        $this->assertDatabaseHas('users', [
            'trial_ends_at' => now()->addDays(config('charter.trial_days')),
        ]);
    }
}

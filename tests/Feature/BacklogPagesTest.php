<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class BacklogPagesTest extends TestCase
{
    public function test_public_article_and_authentication_pages_render(): void
    {
        $this->get('/')->assertOk();
        $this->get('/articles')->assertOk();
        $this->get('/articles?q=tecnologia')->assertOk();
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
    }

    public function test_guest_is_sent_to_login_before_protected_writer_and_team_pages(): void
    {
        $this->get('/articles/create')->assertRedirect(route('login'));
        $this->get('/team/join')->assertRedirect(route('login'));
    }

    public function test_team_request_route_rejects_unknown_decisions(): void
    {
        $this->patch('/team/requests/1/invalid')->assertNotFound();
    }

    public function test_article_policy_is_discovered_by_laravel(): void
    {
        self::assertInstanceOf(ArticlePolicy::class, Gate::getPolicyFor(Article::class));
    }

    public function test_role_specific_pages_follow_the_backlog_permissions(): void
    {
        $writer = $this->userWithRole('Writer');
        $this->actingAs($writer)->get(route('articles.create'))->assertOk();
        $this->get(route('writer.dashboard'))->assertOk();

        $member = new User;
        $member->setAttribute('id', 900002);
        $member->setRelation('role', null);
        $this->actingAs($member)->get(route('team.create'))->assertOk();
        $this->get(route('articles.create'))->assertForbidden();

        $this->actingAs($this->userWithRole('Revisor'))->get(route('review.index'))->assertOk();

        $admin = $this->userWithRole('Admin');
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->get(route('categories.index'))->assertOk();
        $this->get(route('tags.index'))->assertOk();
    }

    public function test_login_rejects_password_as_array(): void
    {
        $user = User::factory()->create();

        $this->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => ['valore-non-valido'],
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    private function userWithRole(string $roleName): User
    {
        $user = new User;
        $user->setAttribute('id', 900001);
        $user->setRelation('role', new Role(['name' => $roleName]));

        return $user;
    }
}

<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use App\Policies\ArticlePolicy;
use PHPUnit\Framework\TestCase;

class ArticlePolicyTest extends TestCase
{
    public function test_published_articles_are_public_but_pending_articles_are_not(): void
    {
        $policy = new ArticlePolicy;

        self::assertTrue($policy->view(null, $this->article('pubblicato', 10)));
        self::assertFalse($policy->view(null, $this->article('in_revisione', 10)));
        self::assertTrue($policy->view($this->user(10, 'Writer'), $this->article('in_revisione', 10)));
        self::assertFalse($policy->view($this->user(20, 'Writer'), $this->article('in_revisione', 10)));
        self::assertTrue($policy->view($this->user(20, 'Revisor'), $this->article('in_revisione', 10)));
        self::assertTrue($policy->view($this->user(30, 'Admin'), $this->article('in_revisione', 10)));
    }

    public function test_only_writer_can_create_and_manage_their_own_articles(): void
    {
        $policy = new ArticlePolicy;
        $writer = $this->user(10, 'Writer');
        $otherWriter = $this->user(11, 'Writer');
        $article = $this->article('pubblicato', 10);

        self::assertTrue($policy->create($writer));
        self::assertFalse($policy->create($this->user(20, 'Revisor')));
        self::assertTrue($policy->update($writer, $article));
        self::assertTrue($policy->delete($writer, $article));
        self::assertFalse($policy->update($otherWriter, $article));
        self::assertFalse($policy->delete($otherWriter, $article));
        self::assertFalse($policy->update($this->user(30, 'Admin'), $article));
    }

    private function user(int $id, string $roleName): User
    {
        $user = new User;
        $user->setAttribute('id', $id);
        $user->setRelation('role', new Role(['name' => $roleName]));

        return $user;
    }

    private function article(string $status, int $userId): Article
    {
        $article = new Article;
        $article->setAttribute('status', $status);
        $article->setAttribute('user_id', $userId);

        return $article;
    }
}
<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class RoleFilterTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testAdminCanAccessAdminOnlyRoute()
    {
        // Arrange - Login sebagai admin
        $_SESSION['user_id'] = 1;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['is_logged_in'] = true;

        // Act - Akses route yang memerlukan role admin
        $result = $this->get('/articles');

        // Assert - Admin bisa akses
        $result->assertOK();
    }

    public function testEditorCanAccessEditorRoute()
    {
        // Arrange - Login sebagai editor
        $_SESSION['user_id'] = 2;
        $_SESSION['user_role'] = 'editor';
        $_SESSION['is_logged_in'] = true;

        // Act - Akses route yang memerlukan role admin atau editor
        $result = $this->get('/articles');

        // Assert - Editor bisa akses
        $result->assertOK();
    }

    public function testWriterCannotAccessEditorRoute()
    {
        // Arrange - Login sebagai writer
        $result = $this->withSession([
            'user_id' => 3,
            'user_role' => 'writer',
            'is_logged_in' => true,
        ])->get('/articles');

        // Assert - Writer tidak bisa akses, redirect ke dashboard
        $result->assertRedirect();
        $result->assertSessionHas('error', 'Access Denied');
    }

    public function testAdminCanApproveArticle()
    {
        // Arrange - Login sebagai admin
        $_SESSION['user_id'] = 1;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['is_logged_in'] = true;

        // Act - Akses action yang memerlukan role admin/editor
        $result = $this->post('/articles/approve/1');

        // Assert - Admin bisa akses
        $result->assertOK();
    }

    public function testWriterCannotApproveArticle()
    {
        // Arrange - Login sebagai writer
        $_SESSION['user_id'] = 1;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['is_logged_in'] = true;

        // Act
        $result = $this->post('/articles/approve/1');

        // Assert
        $result->assertRedirectTo('/dashboard');
        $result->assertSessionHas('error', 'Access Denied');
    }
}

<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Model\DB;

final class AdminController extends BaseController
{
    public function dashboard(): void
    {
        $this->requireAdmin();
        $conn = DB::conn();
        $stats = [
            'templates' => (int)$conn->query('SELECT COUNT(*) FROM templates')->fetchColumn(),
            'stories' => (int)$conn->query('SELECT COUNT(*) FROM stories')->fetchColumn(),
            'flags' => (int)$conn->query('SELECT COUNT(*) FROM flags')->fetchColumn(),
        ];
        $recent = $conn->query('SELECT content FROM stories ORDER BY created_at DESC LIMIT 10')->fetchAll();
        $this->view('admin/dashboard', compact('stats', 'recent'));
    }
}

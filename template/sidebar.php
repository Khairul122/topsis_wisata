<?php
$navItems = [
    [
        'url' => 'dashboard.php',
        'icon' => 'mdi-grid-large',
        'title' => 'Dashboard'
    ],
    [
        'url' => 'kriteria.php',
        'icon' => 'mdi-grid-large',
        'title' => 'Kriteria'
    ],
    [
        'url' => 'alternatif.php',
        'icon' => 'mdi-grid-large',
        'title' => 'Alternatif'
    ],
    [
        'url' => 'kuesioner.php',
        'icon' => 'mdi-grid-large',
        'title' => 'Kuesioner'
    ],
    [
        'url' => 'riwayat-rekoemendasi.php',
        'icon' => 'mdi-grid-large',
        'title' => 'Riwayat Rekomendasi'
    ]
];

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <?php foreach ($navItems as $item): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == $item['url']) ? 'active' : ''; ?>" href="<?php echo $item['url']; ?>">
                    <i class="mdi <?php echo $item['icon']; ?> menu-icon"></i>
                    <span class="menu-title"><?php echo $item['title']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
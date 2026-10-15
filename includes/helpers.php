<?php
// Membungkus output data yang berasal dari input pengguna sebelum
// dicetak ke HTML, untuk mencegah XSS (Cross-Site Scripting).
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// ===== Role pengguna (admin / petugas) =====
function is_admin()
{
    return ($_SESSION['role'] ?? '') === 'admin';
}

function role_label()
{
    return ($_SESSION['role'] ?? '') === 'admin' ? 'Admin' : 'Petugas';
}
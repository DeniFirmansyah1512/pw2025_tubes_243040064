<?php
// Script untuk mengecek keberadaan file dan struktur folder
// Simpan file ini di folder adminpanel sebagai check-files.php

echo "<h2>File and Directory Checker</h2>";

// Informasi dasar
echo "<h3>Current Directory Info:</h3>";
echo "<p><strong>Current PHP file location:</strong> " . __FILE__ . "</p>";
echo "<p><strong>Current working directory:</strong> " . getcwd() . "</p>";
echo "<p><strong>Document root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

// Cek struktur folder
echo "<h3>Directory Structure Check:</h3>";

$directories_to_check = [
    '../image',
    '../image/',
    '../../image',
    $_SERVER['DOCUMENT_ROOT'] . '/pw2025_tubes_243040063/image'
];

foreach ($directories_to_check as $dir) {
    if (is_dir($dir)) {
        echo "<p style='color: green;'>✓ Directory exists: <strong>$dir</strong></p>";

        // List files in directory
        $files = scandir($dir);
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filesize = filesize($dir . '/' . $file);
                echo "<li>$file (" . number_format($filesize) . " bytes)</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>✗ Directory NOT found: <strong>$dir</strong></p>";
    }
}

// Cek file spesifik dari database
echo "<h3>Database Files Check:</h3>";

require "../koneksi.php";
$query = mysqli_query($con, "SELECT id, judulfilm, foto FROM movies WHERE foto IS NOT NULL AND foto != ''");

if (mysqli_num_rows($query) > 0) {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Judul Film</th><th>Nama File</th><th>File Status</th><th>Possible Locations</th></tr>";

    while ($data = mysqli_fetch_array($query)) {
        echo "<tr>";
        echo "<td>" . $data['id'] . "</td>";
        echo "<td>" . $data['judulfilm'] . "</td>";
        echo "<td>" . $data['foto'] . "</td>";

        // Cek keberadaan file di berbagai lokasi
        $possible_paths = [
            "../image/" . $data['foto'],
            "../../image/" . $data['foto'],
            $_SERVER['DOCUMENT_ROOT'] . "/pw2025_tubes_243040063/image/" . $data['foto']
        ];

        $file_found = false;
        $found_location = "";

        foreach ($possible_paths as $path) {
            if (file_exists($path)) {
                $file_found = true;
                $found_location = $path;
                break;
            }
        }

        if ($file_found) {
            echo "<td style='color: green;'>✓ FOUND</td>";
            echo "<td style='color: green;'>" . $found_location . "</td>";
        } else {
            echo "<td style='color: red;'>✗ NOT FOUND</td>";
            echo "<td style='color: red;'>File missing in all locations</td>";
        }

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No movies with photos found in database.</p>";
}

// Cek permission folder image
echo "<h3>Folder Permissions:</h3>";
$image_dir = "../image";
if (is_dir($image_dir)) {
    $perms = fileperms($image_dir);
    echo "<p><strong>Image folder permissions:</strong> " . substr(sprintf('%o', $perms), -4) . "</p>";
    echo "<p><strong>Is readable:</strong> " . (is_readable($image_dir) ? 'YES' : 'NO') . "</p>";
    echo "<p><strong>Is writable:</strong> " . (is_writable($image_dir) ? 'YES' : 'NO') . "</p>";
}
?>

<h3>Quick Fixes:</h3>
<div style="background-color: #f8f9fa; padding: 15px; border: 1px solid #dee2e6; border-radius: 5px;">
    <h4>1. Jika folder image tidak ada:</h4>
    <p>Buat folder 'image' di root project (sejajar dengan folder adminpanel)</p>

    <h4>2. Jika file tidak ada:</h4>
    <p>Upload ulang file gambar yang hilang ke folder image</p>

    <h4>3. Jika permission bermasalah:</h4>
    <p>Set permission folder image ke 755 dan file gambar ke 644</p>
</div>
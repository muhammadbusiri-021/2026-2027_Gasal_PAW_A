<?php

const HOST = 'localhost';
const USER = 'root';
const PASS = '';
const DBNAME = 'penjualan';
const DSN = "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=utf8mb4";

const OPTIONS = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $DBH = new PDO(DSN, USER, PASS, OPTIONS);
} catch (PDOException $err) {
  die("Koneksi Gagal: " . $err->getMessage());
}

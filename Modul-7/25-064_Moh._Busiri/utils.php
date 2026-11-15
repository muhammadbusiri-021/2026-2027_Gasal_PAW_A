<?php

function sanitazion($input)
{
  return htmlspecialchars(trim((string) $input), ENT_QUOTES, 'UTF-8');
}

// Validasi format tanggal Y-m-d, kembalikan null jika tidak valid
function parseDate($value)
{
  if (empty($value)) {
    return null;
  }
  $date = DateTime::createFromFormat("Y-m-d", (string) $value);
  return ($date && $date->format("Y-m-d") === $value) ? $value : null;
}

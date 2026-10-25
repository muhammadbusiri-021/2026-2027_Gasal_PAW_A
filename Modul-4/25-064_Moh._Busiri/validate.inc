<?php
// validate.inc

// 1. Validasi Surname (dari langkah 4)
function validateName(&$errors, $field_list, $field_name) {
    $pattern = "/^[a-zA-Z'-]+$/"; // format nama alfabet
    
    if (!isset($field_list[$field_name]) || empty(trim($field_list[$field_name]))) {
        $errors[$field_name] = 'required';
    } else if (!preg_match($pattern, trim($field_list[$field_name]))) {
        $errors[$field_name] = 'invalid';
    }
}

// 2. Validasi Email (Langkah 9)
function validateEmail(&$errors, $field_list, $field_name) {
    if (!isset($field_list[$field_name]) || empty(trim($field_list[$field_name]))) {
        $errors[$field_name] = 'required';
    } else if (!filter_var(trim($field_list[$field_name]), FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid email format';
    }
}

// 3. Validasi Password (Langkah 9)
function validatePassword(&$errors, $field_list, $field_name) {
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
        $errors[$field_name] = 'required';
    } else if (strlen($field_list[$field_name]) < 6) {
        $errors[$field_name] = 'minimal 6 karakter';
    }
}

// 4. Validasi Street Address (Langkah 9)
function validateAddress(&$errors, $field_list, $field_name) {
    if (!isset($field_list[$field_name]) || empty(trim($field_list[$field_name]))) {
        $errors[$field_name] = 'required';
    }
}

// 5. Validasi State (Langkah 9)
function validateState(&$errors, $field_list, $field_name) {
    if (!isset($field_list[$field_name]) || $field_list[$field_name] == '-1') {
        $errors[$field_name] = 'state harus dipilih';
    }
}

// 6. Validasi Gender (Langkah 9)
function validateGender(&$errors, $field_list, $field_name) {
    if (!isset($field_list[$field_name])) {
        $errors[$field_name] = 'gender harus dipilih';
    }
}
?>

<?php

define('ERR_MISSING_INPUTS', -1);
define('ERR_INVALID_INPUTS', -2);

header('Content-Type: application/json');

// Define all validators.

$validatorInputLastName = function($inValue) {
    return preg_match('/^\w{3,20}$/', $inValue);
};

$validatorInputFirstName = function($inValue) {
    return preg_match('/^\w{3,20}$/', $inValue);
};

$validatorInputAddress = function($inValue) {
    return preg_match('/^[\w ,\-]{10,100}$/', $inValue);
};

$validatorInputCity = function($inValue) {
    $allowed = ['Paris', 'Marseille', 'Toulouse'];
    return in_array($inValue, $allowed);
};

$validatorInputZip = function($inValue) {
    $allowed = ['75001', '75002', '75003'];
    return in_array($inValue, $allowed);
};

$validatorInputPhone = function($inValue) {
    return preg_match('/^\d{10}$/', $inValue);
};

$validatorInputEmail = function($inValue) {
    return preg_match('/^[^@]+@[^@]+$/', $inValue);
};

$validatorInputEmailConfirmation = function($inValue, $inConformationValue) {
    return $inValue == $inConformationValue;
};

$validatorInputPassword = function($inValue) {
    return preg_match(' /^[a-z0-9\-_#]{6,20}$/i', $inValue);
};

$validatorInputPasswordConfirmation = function($inValue, $inConformationValue) {
    return $inValue == $inConformationValue;
};

$validatorInputRef = function($inValue) {
    $allowed = ['google', 'yahoo', 'other'];
    return in_array($inValue, $allowed);
};

$inputs = [
    'inputLastName' => $validatorInputLastName,
    'inputFirstName' => $validatorInputFirstName,
    'inputAddress' => $validatorInputAddress,
    'inputCity' => $validatorInputCity,
    'inputZip' => $validatorInputZip,
    'inputPhone' => $validatorInputPhone,
    'inputEmail' => $validatorInputEmail,
    'inputEmailConfirmation' => $validatorInputEmailConfirmation,
    'inputPassword' => $validatorInputPassword,
    'inputPasswordConfirmation' => $validatorInputPasswordConfirmation,
    'inputRef' => $validatorInputRef
];

// ---------------------------------------------------------------------------------------------------------------------
// Since the validators are identical, an error means that someone is hacking us.
// ---------------------------------------------------------------------------------------------------------------------

// Validate that all inputs are present.

$errors = [];
foreach ($inputs as $_name => $_validator) {
    if (! array_key_exists($_name, $_POST)) {
        $errors[] = $_name;
    }
}

if (count($errors) > 0) {
    echo json_encode([ 'status' => 'error', 'code' => ERR_MISSING_INPUTS, 'data' => $errors], true);
    exit(0);
}

// Validate that all inputs are OK.

$errors = [];
foreach ($inputs as $_name => $_validator) {
    $valid = false;

    if ($_name == 'inputEmailConfirmation') {
        $valid = $_validator($_POST[$_name], $_POST['inputEmail']);
    } elseif ($_name == 'inputPasswordConfirmation') {
        $valid = $_validator($_POST[$_name], $_POST['inputPassword']);
    } else {
        $valid = $_validator($_POST[$_name]);
    }

    if (! $valid) {
        $errors[] = $_name;
    }
}

if (count($errors) > 0) {
    // This case should never happen !!!!!
    echo json_encode(['status' => 'error', 'code' => ERR_INVALID_INPUTS, 'data' => $errors], true);
    exit(0);
}


// ---------------------------------------------------------------------------------------------------------------------
// OK, all inputs look good. Insert into the database...
// ---------------------------------------------------------------------------------------------------------------------


// bla, bla, bla...




echo json_encode(['status' => 'sucess', 'data' => []]);








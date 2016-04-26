<?php

define('ERR_MISSING_INPUTS', -1);
define('ERR_INVALID_INPUTS', -2);
define('ERR_SERVER_ERROR',   -3);
define('ERR_EMAIL_DUP',      -4);

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

$post2db = [
    'inputLastName'     => ['name' => '`utilisateur`.`nom`'],
    'inputFirstName'    => ['name' => '`utilisateur`.`prenon`'],
    'inputAddress'      => ['name' => '`utilisateur`.`adresse`'],
    'inputCity'         => ['name' => '`utilisateur`.`ville`'],
    'inputZip'          => ['name' => '`utilisateur`.`code_postal`'],
    'inputPhone'        => ['name' => '`utilisateur`.`tel`'],
    'inputEmail'        => ['name' => '`utilisateur`.`email`'],
    'inputPassword'     => ['name' => '`utilisateur`.`mdp`'],
    'inputRef'          => ['name' => '`connu_par`.`intitule`']
];

// bla, bla, bla...

$dsn      = 'mysql:dbname=mydatabase;host=127.0.0.1';
$user     = 'dbuser';
$password = 'dbpass';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'code' => ERR_SERVER_ERROR, 'data' => []], true);
    exit(0);
}

// Quote all data.

foreach ($post2db as $_name => $_spec) {
    $value = $_POST[$_name];
    $post2db[$_name]['value'] = $dbh->quote($value);
}

// Insert the user.

$record = [];
$inputs = ['inputLastName', 'inputFirstName', 'inputAddress', 'inputCity', 'inputZip', 'inputPhone', 'inputEmail', 'inputPassword'];
foreach ($inputs as $_inputName) {
    $record[] = $post2db[$_inputName]['name'] . '=' . $post2db[$_inputName]['value'];
}
$sql = "INSERT INTO `utilisateur` SET " . join(', ', $record);

$userId = null;
try {
    $dbh->exec($sql);
    $userId = $dbh->lastInsertId();
} catch (Exception $e) {
    // We should test if we have duplicated keys.
    // But we do not have the entire schema...
    // So we assume that there is no constraint.

    $error = $dbh->errorInfo();
    $error = $error[0];

    // You must use the constant instead of numeric value.
    if ($errors == 1022) {
        // Duplicated email.
        echo json_encode(['status' => 'error', 'code' => ERR_EMAIL_DUP, 'data' => []], true);
        exit(0);
    }

    echo json_encode(['status' => 'error', 'code' => ERR_SERVER_ERROR, 'data' => []], true);
    exit(0);
}

$intituleId = null;
$sql = "SELECT `id` FROM `connu_par` WHERE " . $post2db['inputRef']['name'] . " = " . $post2db['inputRef']['value'];
$result = $dbh->query($sql, PDO::FETCH_ASSOC);
$result = $result->fetchAll();

if (count($result) == 0) {
    echo json_encode(['status' => 'error', 'code' => ERR_SERVER_ERROR, 'data' => []], true);
    exit(0);
}

$intituleId = $result[0]['id'];

// Insert the the mapping.

$sql = "INSERT INTO `utilisateur_connu_par` SET `id_utilisateur` = $userId, `id_connu_par` = $intituleId";
try {
    $dbh->exec($sql);
} catch (Exception $e) {
    // We should test if we have duplicated keys.
    // But we do not have the entire schema...
    // So we assume that there is no constraint.
    echo json_encode(['status' => 'error', 'code' => ERR_SERVER_ERROR, 'data' => []], true);
    exit(0);
}


echo json_encode(['status' => 'sucess', 'data' => []]);








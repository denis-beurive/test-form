<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test de recrutement</title>

    <!-- Bootstrap's CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/common.css" rel="stylesheet">

    <!-- The Less compiler -->
    <script src="../bower_components/less/dist/less.js" type="text/javascript"></script>
</head>

<body>


    <div class="container">


        <h2>Créer un compte:</h2>
        <hr/>

        <form class="form-horizontal">

            <div class="form-group">
                <label for="inputLastName" class="col-sm-2 control-label">Nom</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputLastName">
                </div>

                <label for="inputFirstName" class="col-sm-2 control-label">Prénom</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputFirstName">
                </div>
            </div>

            <div class="form-group">
                <label for="inputAddress" class="col-sm-2 control-label">Adresse</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputAddress">
                </div>

                <label for="inputCity" class="col-sm-2 control-label">Ville</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputCity">
                </div>
            </div>

            <div class="form-group">
                <label for="inputZip" class="col-sm-2 control-label">Code postal</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputZip">
                </div>

                <label for="inputPhone" class="col-sm-2 control-label">Téléphone</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputPhone">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputEmail">
                </div>

                <label for="inputEmailConfirmation" class="col-sm-2 control-label">Confirmation</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputEmailConfirmation">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Choisissez votre mot de passe</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputPassword">
                </div>

                <label for="inputPasswordConfirmation" class="col-sm-2 control-label">Confirmation</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputPasswordConfirmation">
                </div>
            </div>

            <div class="form-group">
                <label for="inputRef" class="col-sm-2 control-label">Comment nous avez-vous connu?</label>
                <div class="col-sm-4">
                    <select class="form-control" id="inputRef">
                        <option value="-">-</option>
                        <option value="google">Google</option>
                        <option value="yahoo">Yahoo</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" style="text-align: center">
                    <button type="button" id="inputSubmit" class="btn btn-primary">Créer un compte</button>
                </div>
            </div>

        </form>

    </div>






    <!-- --------------------------------------------------------------------------------------------------------------- -->
    <!-- JavaScript                                                                                                      -->
    <!-- --------------------------------------------------------------------------------------------------------------- -->

    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {

            var test = function() {
                $('#inputLastName').val("Denis");
                $('#inputFirstName').val("Beurive");
                $('#inputAddress').val("12 avenue Anatole France");
                $('#inputCity').val("Paris");
                $('#inputZip').val('75001');
                $('#inputPhone').val('0147360612');
                $('#inputEmail').val("toto@toto.com");
                $('#inputEmailConfirmation').val("toto@toto.com");
                $('#inputPassword').val("azertyu");
                $('#inputPasswordConfirmation').val("azertyu");
                $('#inputRef').val("google");
            };

            test();

            // -----------------------------------------------------------------
            // Define inputs' validators.
            // -----------------------------------------------------------------

            var validateFirstName = function(inValue) {
                var re = /^\w{3,20}$/;
                return !(null === inValue.match(re));
            };

            var validateLastName = function(inValue) {
                var re = /^\w{3,20}$/;
                return !(null === inValue.match(re));
            };

            var validateAddress = function(inValue) {
                // Put some code that validates the address.
                // Address validation can be really complex.
                var re = /^[\w ,\-]{10,100}$/;
                return !(null === inValue.match(re));
            };

            var validateCity = function(inValue) {
                // Some very basic validation... it is just a example.
                var cities = ['Paris', 'Marseille', 'Toulouse'];
                return -1 != cities.indexOf(inValue);
            };

            var validateZip = function(inValue) {
                // Some very basic validation... it is just a example.
                var zips = ['75001', '75002', '75003'];
                return -1 != zips.indexOf(inValue);
            };

            var validatePhone = function(inValue) {
                // Some very basic validation... it is just a example.
                var re = /^\d{10}$/;
                return inValue.match(re);
            };

            var validateEmail = function(inValue) {
                // A very basic REGEXP... client side serious email validation is tricky.
                var re = /^[^@]+@[^@]+$/;
                return inValue.match(re);
            };

            var validateEmailConfirmation = function(inValue, inReferenceValue) {
                return inValue == inReferenceValue;
            };

            var validatePassword = function(inValue) {
                var re = /^[a-z0-9\-_#]{6,20}$/i;
                return inValue.match(re);
            };

            var validatePasswordConfirmation = function(inValue, inReferenceValue) {
                return inValue == inReferenceValue;
            };

            var validateRef = function (inValue) {
                // It is not specified whether this field is mandatory or nor...
                // I assume it is.
                return '-' != inValue;
            };

            // -----------------------------------------------------------------
            // Define inputs' handlers.
            // -----------------------------------------------------------------

            var handlerSetSuccess = function(inHandler, inOtherHandler) {
                inHandler.removeClass('has-error');
                if ('undefined' !== typeof inOtherHandler) {
                    inOtherHandler.removeClass('has-error');
                }
            };

            var handlerSetError = function(inHandler, inOtherHandler) {
                inHandler.addClass('has-error');
                if ('undefined' !== typeof inOtherHandler) {
                    inOtherHandler.addClass('has-error');
                }
            };

            // -----------------------------------------------------------------
            // Map inputs with validators and handlers.
            // -----------------------------------------------------------------

            var inputs = [
                { name: 'inputLastName', validator:validateLastName, handler:$('#inputLastName') },
                { name: 'inputFirstName', validator: validateFirstName, handler:$('#inputFirstName')  },
                { name: 'inputAddress', validator: validateAddress, handler:$('#inputAddress')  },
                { name: 'inputCity', validator: validateCity, handler:$('#inputCity')  },
                { name: 'inputZip', validator: validateZip, handler:$('#inputZip') },
                { name: 'inputPhone', validator: validatePhone, handler:$('#inputPhone')  },
                { name: 'inputEmail', validator: validateEmail, handler:$('#inputEmail')  },
                { name: 'inputEmailConfirmation', validator: validateEmailConfirmation, handler:$('#inputEmailConfirmation') },
                { name: 'inputPassword', validator: validatePassword, handler:$('#inputPassword') },
                { name: 'inputPasswordConfirmation', validator: validatePasswordConfirmation, handler:$('#inputPasswordConfirmation') },
                { name: 'inputRef', validator: validateRef, handler:$('#inputRef') }
            ];

            // -----------------------------------------------------------------
            // Process form's submission.
            // -----------------------------------------------------------------

            $('#inputSubmit').on('click', function() {

                errors = {};
                foundErrors = false;
                values = {};

                // Validate all inputs.
                (function() {
                    for (var i = 0; i < inputs.length; i++) {

                        var name = inputs[i]['name'];
                        var validator = inputs[i]['validator'];
                        var handler = inputs[i]['handler'];
                        var value = handler.val();

                        var valid = false;

                        if ('inputEmailConfirmation' == name) {
                            valid = validator(value, $('#inputEmail').val());
                        } else if ('inputPasswordConfirmation' == name) {
                            valid = validator(value, $('#inputPassword').val());
                        } else {
                            valid = validator(value);
                        }

                        if (!valid) {
                            foundErrors = true;
                            errors[name] = true;
                            continue;
                        }

                        values[name] = value;
                    }
                }());

                // Is there errors ?
                if (foundErrors) {

                    // Special cases.

                    if (errors.hasOwnProperty('inputEmail') || errors.hasOwnProperty('inputEmailConfirmation')) {
                        handlerSetError($('#inputEmail'), $('#inputEmailConfirmation'));
                    } else {
                        handlerSetSuccess($('#inputEmail'), $('#inputEmailConfirmation'));
                    }

                    if (errors.hasOwnProperty('inputPassword') || errors.hasOwnProperty('inputPasswordConfirmation')) {
                        handlerSetError($('#inputPassword'), $('#inputPasswordConfirmation'));
                    } else {
                        handlerSetSuccess($('#inputPassword'), $('#inputPasswordConfirmation'));
                    }

                    // Standard cases.

                    (function () {

                        var specials = {inputEmailConfirmation: true, inputEmail: true, inputPasswordConfirmation: true, inputPassword: true};

                        for (var i = 0; i < inputs.length; i++) {

                            var name = inputs[i]['name'];              // The input's name
                            var handler = inputs[i]['handler'];        // The input's handler
                            var isError = errors.hasOwnProperty(name); // Is the input in error ?

                            if (specials.hasOwnProperty(name)) continue;

                            if (isError) {
                                handlerSetError(handler);
                            } else {
                                handlerSetSuccess(handler);
                            }
                        }
                    }());

                    return false; // Stop processing the form.
                }
                
                // All inputs are valid. Let's send the data to the server.
                // Please note that all couples (name, value) are in the object "values".

                $.ajax('/controllers/register.php', {
                    method: 'POST',
                    data: values
                }).done(function(data, textStatus, jqXHR) {
                    console.log(data);

                    if ('undefined' === typeof data['status']) {
                        alert("Unexpected server response!");
                        return false;
                    }

                    if ('undefined' === typeof data['data']) {
                        alert("Unexpected server response!");
                        return false;
                    }

                    if ('error' === data['status']) {

                        if ('undefined' === typeof data['code']) {
                            alert("Unexpected server response!");
                            return false;
                        }

                        // Here, you must treat each error code.
                        // But, for this example, we just print a generic error message.
                        alert("Unexpected error: " + data['code']);
                    }

                    // OK, is done !
                    alert("It's OK!");

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Unexpected server response!");
                    return false;
                }).always(function() {
                    // Use this section to do some cleanup.
                });
            });


        });

    </script>

</body>
</html>

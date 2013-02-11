PHP Validator
========================

The validator class is used to setup validation rules for expected values on the server concerning data coming from the user. Validating data is crucial before working with it.

Usage
-----

Create an instance of the Validator class with an associative array as first and only parameter.
	
	// Using the $_POST global
	$Validator = new Validator($_POST);

	// or some other array:
	$Validator = new Validator([
		"email" 	=> $email,
		"password" 	=> $password
	]);

Then you simply specify what values you expect by setting some rules.
	
	//$Validator->Expect(var, rule);
	$Validator->Expect("email", "required, email");
	$Validator->Expect("password", "required");

To check if the values passed the validation you simply call: Validate() which returns a boolean.

	if ($Validator->Validate()) {
		// Validation ok
	} else {
		// Validation failed
	}

Rules
-----------

The available rules are:

* req/required	- specify that a variable must be set.
* num/numeric	- validate using is_numeric()
* min/minimum	- minimum value for an numeric value.
* max/maximum 	- maximum value for an numeric value.
* min_length	- minimum length for a string
* max_length	- maximum length for a string
* email		- validate using filter_var($var, FILTER_VALIDATE_EMAIL)

To set values for the min/max rules use the format "rule=value" like "min=5, max=15". A comma is used to separate each value.

Licensing
-----------

Feel free to use, change and distribute as wanted.

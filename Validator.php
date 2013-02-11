<?php
/**
* Validator - simple server-side variable validation.
*
* @author 		Stig Rune Grønnestad
* @copyright	Stig Rune Grønnestad @ 2013
* @version		1.0
*
*/

	class Validator {
		public $Vars;
		public $Rules;

		/**
		 * Constructor
		 * @param array $vars Array to validate, normally $_GET or $_POST
		 */
		public function __construct(array $vars) {
			$this->Vars = $vars;
		}

		/**
		 * Define what keys to expect and what rules the values should follow.
		 * @param [type] $key
		 * @param [type] $rule rule for the value, for example numeric, string, min, max and so forth
		 */
		public function Expect($key, $rule) {
			$this->Rules[$key] = $rule;
		}

		/**
		 * Run the validation based on the current var array and expected keys/rules.
		 * @return bool false if ANY of the rules failed validation, true otherwise
		 */
		public function Validate() {
			foreach ($this->Rules as $key => $rule) {
				$rules = explode(",", $rule);

				foreach ($rules as $rule) {
					if (strstr($rule, "=")) {
						$words = explode("=", $rule);
						$rule = $words[0];
						$rule_value = $words[1];
					}

					switch (strtoupper(trim($rule))) {

						case "REQ" :
						case "REQUIRED" : {
							if (! isset(trim($this->Vars[$key]))) return false;
							break;
						}

						case "NUM" :
						case "NUMERIC" : {
							if (isset($this->Vars[$key])) {
								if (! is_numeric($this->Vars[$key])) return false;
							}
							break;
						}

						case "MIN" :
						case "MINIMUM" : {
							if (isset($this->Vars[$key])) {
								if (! is_numeric($this->Vars[$key])) return false;
								if ($this->Vars[$key] < $rule_value) return false;
							}
							break;
						}

						case "MAX" :
						case "MAXIMUM" : {
							if (isset($this->Vars[$key])) {
								if (! is_numeric($this->Vars[$key])) return false;
								if ($this->Vars[$key] > $rule_value) return false;
							}
							break;
						}

						case "MIN_LEN" :
						case "MIN_LENGTH" : {
							if (isset($this->Vars[$key])) {
								if (strlen($this->Vars[$key]) < $rule_value) return false;
							}
							break;
						}

						case "MAX_LEN" :
						case "MAX_LENGTH" : {
							if (isset($this->Vars[$key])) {
								if (strlen($this->Vars[$key]) > $rule_value) return false;
							}
							break;
						}

						case "EMAIL" :
						case "E-MAIL" : {
							if (isset($this->Vars[$key])) {
								if (! filter_var($this->Vars[$key], FILTER_VALIDATE_EMAIL)) return false;
							}
							break;
						}
					}
				}
			}

			return true;
		}

		/**
		 * Override the get magic method to work with the array inserted at construct.
		 * @param  [type] $var the variable to lookup
		 * @return [type] the var if it's found else NULL
		 */
		public function __get($var) {
			if (isset($this->$var)) {
				return $this->$var;
			} else {
				if (isset($this->Vars[$var])) {
					return $this->Vars[$var];
				}
			}

			return NULL;
		}
	}
?>
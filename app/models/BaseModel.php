<?php

class BaseModel extends Eloquent {
    public $errors;

	public static function validate($input)
    {
        return Validator::make($input, static::$rules, (isset(static::$messages)) ? static::$messages : []);
    }
}

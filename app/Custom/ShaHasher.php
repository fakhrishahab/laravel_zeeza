<?php namespace App\Custom;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class ShaHasher implements HasherContract {

	public function make($value, array $options = array()) {
		$value = env('SALT', '').$value;
		return sha1($value);
	}

	public function check($value, $hashedValue, array $options = array()) {
		return $this->make($value) === $hashedValue;
	}

	public function needsRehash($hashedValue, array $options = array()) {
		return false;
	}

}
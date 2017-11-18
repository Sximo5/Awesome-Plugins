<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Sximo  {
	
	protected $table = 'contacts';
	protected $primaryKey = 'ContactID';

	public function __construct() {
		parent::__construct();
		
	}

}

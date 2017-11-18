<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Client extends Sximo  {
	
	protected $table = 'clients';
	protected $primaryKey = 'ClientID';

	public function __construct() {
		parent::__construct();
		
	}

}

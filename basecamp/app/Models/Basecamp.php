<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Basecamp extends Sximo  {
	
	protected $table = 'basecamp';
	protected $primaryKey = 'camp_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function todo_sets( $id , $uid='' ) {
		$additional = '';
		if($uid != '') 
			$additional = " WHERE FIND_IN_SET(".$uid.", basecamp.teams ) ";

		$output = \DB::select("
				SELECT * FROM basecamp_sets 
				LEFT JOIN basecamp ON basecamp.camp_id = basecamp_sets.basecamp_id
				$additional				
			");

		//$output = \DB::table('basecamp_sets')->where('basecamp_id',$id)->get();
		$data = array();
		foreach($output as $row)
		{			
			$todo = \DB::table('basecamp_todo')->where('set_id',$row->set_id)->get();
			$todos=[];
			foreach($todo as $td)
			{
				$todos[] = (array) $td;
			}
			$data[] = ['row'=> (array) $row , 'todos'=>$todos ] ;
		}
		return $data;

	}
	public static function todo_set( $id ) {

		$output = \DB::table('basecamp_sets')
					->leftJoin('basecamp','basecamp.camp_id','basecamp_sets.basecamp_id')->where('set_id',$id)->get();
		return $output[0];

	}
	public static function bcamp( $id ) {

		$output = \DB::table('basecamp')->where('camp_id',$id)->get();
		return $output;
		

	}	
	public static function todos( $id ) {

		$output = \DB::table('basecamp_todo')->where('set_id',$id)->get();
		return $output;

	}
	public static function todo( $id ) {

		$output = \DB::table('basecamp_todo')
					->leftJoin('basecamp_sets','basecamp_sets.set_id','basecamp_todo.set_id')->where('todo_id',$id)->get();
		return $output;

	}	
	public static function comments( $key ,  $id ) {

		$output = \DB::table('basecamp_comments')
					->leftJoin('tb_users','tb_users.id','basecamp_comments.user_id')
					->where($key ,$id)->get();
		return $output;

	}
}


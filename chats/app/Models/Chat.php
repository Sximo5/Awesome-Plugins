<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Chat extends Sximo  {
	
	protected $table = 'chats';
	protected $primaryKey = 'chat_id';

	public function __construct() {
		parent::__construct();
		
	}

	public function chat_active( $id ){

		$result = \DB::select(" 
				SELECT * FROM chats  WHERE FIND_IN_SET( $id , participants)
			");
		$data = array();
		foreach($result as $row)
		{
			
			$participants = explode(',',$row->participants);
			$users = [];
			foreach ($participants as  $value) {
				if($value != $id)
					$users[] = $value;
			}
			$users = self::participants($users) ;
			

			$rows = (array) $row ;
			$rows = array_merge($rows , array('users'=> $users));
			$data[] = $rows ;

		}
		return $data;
	}
	public function participants( $ids ){

		$result = \DB::table('tb_users')->whereIn('id',$ids)->get();
		$data = array();
		foreach($result as $row)
		{
			$data[] = [
				'id'		=> $row->id ,
				'name'		=> $row->first_name.' '.$row->last_name ,
				'avatar'	=> $row->avatar
			];
		}
		return $data;
	}
	public function conversation( $id ){

		/* Delete Conversation older than 30 days */
		\DB::select("
			DELETE FROM chat_messages WHERE posted < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10080 MINUTE))
		");
		$result = \DB::table('chat_messages')
					->leftJoin('tb_users','tb_users.id','chat_messages.user_id')
					->where('chat_id',$id)->orderBy('posted','ASC')->get();
		return $result ;
	}

	public function chat_detail( $id ){

		$result = \DB::table('chats')->where('chat_id',$id)->get();
		$data = [];
		foreach($result as $row)
		{
			$users = self::participants(explode(",",$row->participants));
			$data[] = array_merge( (array) $row , ['users'=> $users]);
			
		}
		return $data;

	}
}

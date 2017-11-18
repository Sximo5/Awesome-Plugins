<?php namespace App\Http\Controllers;

use App\Models\Basecamp;

use App\Library\CrudEngine;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class BasecampController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'basecamp';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->model = new Basecamp();
		$this->crudengine = new CrudEngine();			
	}

	public function index( Request $request )
	{
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');


		// Intercept for anyprocess post
		if(!is_null($request->input('action_task')))
			return $this->save($request);

		$config = $this->model->connector( $this->module,'id');
		$access = $this->model->getAccess( $config['id'] , session('gid') );
		if(!in_array('list',$access))
			return redirect('dashboard')->with('status', 'error')->with('message','You dont Have access to the page !');
			
		$table 	= $this->crudengine->table( $config['table'])->builder( $config )->button( implode(',',$access) );
		if(!is_null($request->input('task'))){
			$table = $table->append_data(['todo_sets' => $this->model->todo_sets($request->input('id')) ]);
		}

		$table = $table->theme('default')->render();
		$this->data = array(
			'module'	=> $this->module ,
			'title'		=> $config['title'],
			'note'		=> $config['note'],
			'table'		=> $table
		);	
		return view('basecamp.index',$this->data);
	}	

	public function show( Request $request ,  $task) 
	{
		$config = $this->model->connector( $this->module,'id');
		$permission = $this->model->getAccess( $config['id'] , session('gid') );
		$access = [];
		foreach($permission as $key)
			$access[$key] = true;
		$this->data['access'] = $access ;
		

		switch($task)
		{
			case 'todo':
				$id = $request->input('id');
				$todo_id = $request->input('todo_id');
				if($todo_id !='')
				{
					$todo = $this->model->todo( $todo_id );
					if(count($todo)<=0)
						return redirect('basecamp/todo?id='.$id)->with(['status'=>'error','message'=>' No Record Found !']);
					$this->data['todo'] = $todo[0];
					return view('basecamp.task',$this->data);

				}
				$this->data['todo_set'] = $this->model->todo_set( $id);
				$this->data['todos'] = $this->model->todos( $id);				
				return view('basecamp.todo',$this->data);
				break;

			case 'todosets':
				$id = $request->input('id');
				$filter = (isset($access['view']) ? '' : session('uid'));
				$todo_sets =  $this->model->todo_sets($request->input('id') ,$filter);
				$bcamp =  $this->model->bcamp( $request->input('id'));
				if(count($bcamp))
				{
					$this->data['todo_sets'] = $todo_sets;
					$bcamp =  $this->model->bcamp( $request->input('id'));
					
					if(count($bcamp))
					{	$row = $bcamp[0];						
						$this->data['bcamp'] =$row;
						$this->data['bcamp']->teams = $this->teamAvatar(  $this->data['bcamp']->teams );						
					} else {
						//return redirect('basecamp')->with(['status'=>'error','message'=>' No Record Found !']);
					}									
					return view('basecamp.todo_sets',$this->data);
				} else {
					return redirect('basecamp')->with(['status'=>'error','message'=>' No Record Found !']);
				}
				break;		

			case 'update_list':
				$this->data['camp_id'] = $request->input('id');	
				$this->data['row'] = $this->crudengine->table('basecamp_sets')->wild_row($request->input('set_id'));			
				return view('basecamp.form_lists',$this->data);
				break;	
			case 'update_todo':
				$this->data['set_id'] = $request->input('id');
				$lists =  $this->model->todo_set($request->input('id'));
				//dd($lists);	
				$this->data['users'] = $this->teamAvatar($lists->teams ,true);
				$this->data['row'] = $this->crudengine->table('basecamp_todo')->wild_row($request->input('todo_id'));			
				return view('basecamp.form_todo',$this->data);
				break;	
			case 'delete_todo':
			//	$this->data['camp_id'] = $request->input('id');	
				$this->crudengine->table('basecamp_todo')->wild_delete($request->input('todo_id'));			
				return redirect('basecamp/todo?id='.$request->input('id'))->with(['status'=>'success','message'=>'To Do has been deleted']);
				break;	

			case 'delete_list':
				$this->crudengine->table('basecamp_sets')->wild_delete($request->input('set_id'));	
				$this->crudengine->table('basecamp_todo')->wild_delete($request->input('set_id'), 'set_id');	
				$this->crudengine->table('basecamp_comments')->wild_delete($request->input('set_id'), 'set_id');

				return redirect('basecamp/todosets?id='.$request->input('id'))->with(['status'=>'success','message'=>'To Do List has been deleted']);
				break;	

			case 'delete':
				$rows = \DB::table('basecamp_sets')->where('basecamp_id',$request->input('id'))->get();	
				foreach($rows as $row){
					$this->crudengine->table('basecamp_todo')->wild_delete($row->set_id, 'set_id');	
					$this->crudengine->table('basecamp_comments')->wild_delete($row->set_id, 'set_id');
				}
				$this->crudengine->table('basecamp')->wild_delete($request->input('id'));	
				return redirect('basecamp')->with(['status'=>'success','message'=>'Project Has been completed removed!']);
				break;	

			case 'task':
				$row = $this->crudengine->table('basecamp_todo')->wild_row($request->input('id'));
				$status = ($row['status'] =='open' ? 'open' : 'close');
				$data = array(
					'status'	=> ($status =='open' ? 'close' : 'open'),
				);
				$result = $this->crudengine->table('basecamp_todo')
						->wild_save($request->input('id'), $request->all() ,$data );

				if($status =='open'){
					$msg = ' Has Completed this to-do ';	
				} else {
					$msg = ' Has Re-Open this to-do ';	
				}		
				$activity = array(
					'user_id'	=> session('uid'),
					'todo_id'	=> $row['todo_id'] ,
					'set_id'	=> $row['set_id'],
					'type'		=> 'activity',
					'comment'	=> $msg ,
					'posted'	=> date("Y-m-d H:i:s")
				);	
				$result = $this->crudengine->table('basecamp_comments')
						->wild_save('', $request->all() ,$activity );

				$msg = ($status =='open' ? 'Task Has Been Completed' : ' Task Re-Open Successfull ');
				return response()->json(['status'=>'success','message'=> $msg ]);
				break;	

			case 'comments':
				$id = (!is_null($request->input('id')) ? $request->input('id') : $request->input('todo_id') );
				$key = (!is_null($request->input('id')) ? 'set_id' : 'todo_id');
				$this->data['rows'] = 	Basecamp::comments( $key , $id );
				return view('basecamp.comments',$this->data);
				break;					

		}
	}

	public function save( $request) {

		$action_task = $request->input('action_task');
		switch ($action_task) {

			case 'save_list':
				if($request->input('set_id') =='')
				{
					$data['Created'] = date("Y-m-d H:i:s");
				} else {
					$data['Updated'] = date("Y-m-d H:i:s");	
				}
				$result = $this->crudengine->table('basecamp_sets')
						->wild_save($request->input('set_id'), $request->all() , $data);
				if($result['status']=='success'){
					return redirect('basecamp/todo?id='.$result['id']);
				}		
				break;
			
			case 'save_todo':
				$data = [];
				if(isset($_POST['assigned']))
					$data['assigned'] = implode(',',$_POST['assigned']);

				$result = $this->crudengine->table('basecamp_todo')
						->wild_save($request->input('todo_id'), $request->all() ,$data );
				if($result['status']=='success'){
					return redirect('basecamp/todo?id='.$request->input('set_id'));
				}		
				break;
				break;
		}
	}

	public function teamAvatar( $users , $option = false) {
		$users = explode(',',$users);
		$val ='';
		$val_option = [];
		foreach($users as $user){
			$val .= \SiteHelpers::avatar('40', $user);
		}
		if($option =='true')
		{
			foreach($users as $user){
				$val_option[ $user ] = \SiteHelpers::avatar('40', $user);	
			}	
		}
		if($option ==true)
			return $val_option ;	
		return $val ;
	}
}
<?php namespace App\Http\Controllers;

use App\Models\Contact;
use App\Library\CrudEngine;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class ContactController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'contact';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->model = new Contact();
		$this->crudengine = new CrudEngine();			
	}

	public function index( Request $request )
	{
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');

		$config = $this->model->connector( $this->module,'id');
		$access = $this->model->getAccess( $config['id'] , session('gid') );
		if(!in_array('list',$access))
			return redirect('dashboard')->with('status', 'error')->with('message','You dont Have access to the page !');
			
		//dd($config);	
		$table 	= $this->crudengine->table( $config['table'])->builder( $config )->button( implode(',',$access) )
				->theme('default')
				->call_action('after_save', function( $data) {
					//print_r( $data['ContactID'] );
				})
				->render();
		$this->data = array(
			'module'	=> $this->module ,
			'title'		=> $config['title'],
			'note'		=> $config['note'],
			'table'		=> $table
		);	
		return view('contact.index',$this->data);
	}	
}
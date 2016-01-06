<?php namespace App\Modules\Tests\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Tests::index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function upload() {
		return view("Tests::upload");
	}

	public function process(Request $request)
	{
		$destinationPath = 'file/'.$this->directoryNaming('1');

		if ($request->hasFile('image_file'))
		{
			$file 		= $request->file('image_file');
			$fileName 	= $file->getClientOriginalName();
			$fileExt 	= $file->getClientOriginalExtension();
			$fileRename = $this->fileNaming($fileName) . '.' . $fileExt;
			$result 	= $file->move($destinationPath, $fileRename);
		}

		if ($result) {
			return \Response::json(['success' => true, "path" => $destinationPath."/".$fileRename], 200);
		} else {
			return \Response::json('error', 400);
		}
	}

	public function directoryNaming($name)
	{
		return hash('sha256', $name);
	}

	public function fileNaming($name)
	{
		return hash('sha256', sha1(microtime()) . '.' . gethostname() . '.' . $name);
	}

}

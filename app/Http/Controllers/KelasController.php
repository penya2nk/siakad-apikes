<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ModelKelas;
use Datatables;

class KelasController extends Controller
{
    //
    public function index()
    {
    	return view('kelas.show_kelas');
    }

    public function add()
    {
    	return view('kelas.add_kelas');
    }

    public function store(Request $request)
    {
    	$stat=0;
		$tblkelas = new ModelKelas;
		$validator = $tblkelas->validate($request->all());
			
		if($validator->passes())
		{
			$model = new ModelKelas;
			$model->kode_kelas = $request->kode_kelas;
			$model->nama_kelas = $request->nama_kelas;
			$model->save();
			$stat=1;
			
		}else
		{
			$stat=2;
		}
		
		return response()->json(['return' => $stat]);
    }

    public function edit($id)
    {
    	$kelas = ModelKelas::findOrfail($id);
    	return view('kelas.edit_kelas')
    	->with('kelas',$kelas);
    }

    public function update(Request $request)
    {
    	$stat=0;
		$tblkelas = new ModelKelas;
		$validator = $tblkelas->validate($request->all());
			
		if($validator->passes())
		{
			$model_edit=ModelKelas::where('kode_kelas',$request->kode_kelas)
			->update(['nama_kelas'=>$request->nama_kelas]);
			$stat=1;
			
		}else
		{
			$stat=2;
		}
		
		return response()->json(['return' => $stat]);
    }

    public function destroy(Request $request)
    {
    	$statreturn = 0;
		$term = $request->get('id');
		if(ModelKelas::destroy($term)){
			$statreturn=1;
		}
		return response()->json(['return' => $statreturn]);
    }

    public function autocomplete(Request $request)
    {
    	$statreturn = 0;
		$term = $request->get('term');
		if (ModelKelas::where('kode_kelas', '=',$term)->exists()) {
			$statreturn=1;
		}
		return response()->json(['return' => $statreturn]);
    }

    /**
	 * Displays datatables front end view
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIndex()
	{
		return view('datatableskelas.index');
	}
	public function getData()
	{
		return Datatables::of(ModelKelas::query())->make(true);
	}
	
	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
}

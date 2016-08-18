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
    	$model = new ModelKelas;

    	$arrdosen[""] = "Pilih";
    	$datadosen  = $model->showdosen();
    	foreach ($datadosen as $key => $cdatadosen) {
    		$arrdosen[$cdatadosen->iddosen] = $cdatadosen->nama;
    	}

    	return view('kelas.add_kelas', ['arrdosen' => $arrdosen]);
    }

    public function store(Request $request)
    {
    	$stat=0;
		$tblkelas = new ModelKelas;
		$validator = $tblkelas->validate($request->all());
			
		if($validator->passes())
		{
			$model = new ModelKelas;
			$model->kodekelas = $request->kode_kelas;
			$model->namakelas = $request->nama_kelas;
			//$model->iddosen   = $request->iddosen;
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

    	$model = new ModelKelas;

    	$arrdosen[""] = "Pilih";
    	$datadosen  = $model->showdosen();
    	foreach ($datadosen as $key => $cdatadosen) {
    		$arrdosen[$cdatadosen->iddosen] = $cdatadosen->nama;
    	}

    	return view('kelas.edit_kelas')
    	->with('kelas',$kelas)
    	->with('arrdosen',$arrdosen);
    }

    public function update(Request $request)
    {
    	$stat=0;
		$tblkelas = new ModelKelas;
		$validator = $tblkelas->validate($request->all());
			
		if($validator->passes())
		{
			$model_edit=ModelKelas::where('idkelas',$request->idkelas)
			->update(['namakelas'=>$request->nama_kelas]);
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
		if (ModelKelas::where('kodekelas', '=',$term)->exists()) {
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

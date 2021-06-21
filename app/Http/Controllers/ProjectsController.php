<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Client;
use App\Models\Project;
use App\Models\Progress_item;
use App\Models\Project_cost;
use App\Models\Project_history;
use App\Models\Progress_item_history;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;



class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $projects= Project::with('contract','contract.type')->get();
       return view('projects.v_index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $contracts= Contract::all();
       $project= Project::with('contract','contract.type')->get();
       $clients= Client::all();
       $types = Type::all();
       $typecek = Contract::with('type')->first();
       return view('projects.v_create_project', compact('contracts', 'project', 'clients','types','typecek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract_id = $request->contract_id;
        $dateCek = Contract::where('id', $contract_id)->first();
		if($dateCek){
			$sign_dateOld = $dateCek->start_date;
		}else{
			$sign_dateOld = '2000-01-01';
		}
        $request->merge([
            'sign_dateContract' => $sign_dateOld,
            ]);
       $request->validate([
          'name' => 'required',
          'no_po' => 'nullable|integer|min:1',
          'volume_use' => 'nullable|integer|min:1',
          'po_sign_date' => 'nullable|date|after_or_equal:sign_dateContract',
          'po_start_date' => 'nullable|date|after_or_equal:po_sign_date',
          'po_end_date' => 'nullable|date|after_or_equal:po_start_date',
        //   'created_by' => 'required',
       ]);


       $userid = session()->get('token')['user']['id'];
       $request->merge([
        'created_by' => $userid,
        ]);
       $dataPayment = $request->payment_percentage;
       $dataCost = $request->total_cost;
       $collectPayment = collect($dataPayment);
       $totalPayment = $collectPayment->sum();
       $maxPayment = 100;
       $rules = [];

       if($dataPayment != 0){
              foreach($request->input('payment_percentage') as $key => $value) {
                     $rules["payment_percentage.{$key}"] = 'nullable|integer|min:1';
              }
              $validd = Validator::make($request->all(), $rules);
              if ($validd->fails()) {
                     return back()
                            ->with('statusProgress', 'The minimum amount used must be 1')
                            ->withInput();
              }
       }
       if($dataCost != 0){
              foreach($request->input('total_cost') as $key => $value) {
                     $rules["total_cost.{$key}"] = 'nullable|integer|min:1';
              }
              $validd = Validator::make($request->all(), $rules);
              if ($validd->fails()) {
                     return back()
                            ->with('statusCost', 'The minimum amount used must be 1')
                            ->withInput();
              }
       }
       if($totalPayment != 0){
              if($totalPayment != $maxPayment){
                     return back()->withInput()->with('statusProgress', 'The total of all invoices must be 100%');
              }
       }


       $dataAllVolume=Project::where('contract_id', $contract_id)->get();
       $totalAllVolume= $dataAllVolume->sum('volume_use');
       $volume_use = $request->volume_use ;
       $contracts = Contract::where('id', $contract_id)->get();
       $no_zero = 0;

       foreach ($contracts as $contract) {
              $remainingVolume=$contract->volume - $totalAllVolume;
       }

       if($contract_id != 0){
              if($volume_use != null){
                     if($volume_use != $no_zero){
                            if($volume_use <= $remainingVolume){
                                   $projects = Project::create($request->all());
                            }else{
                                   $this->validate($request, [
                                   'volume_use' => 'nullable|integer|min:1|max:'.$remainingVolume,
                                   ],['volume_use.max' => 'the remaining usable volume is '.$remainingVolume,
                                   ]);
                            }
                     }else{
                            $this->validate($request, [
                            'volume_use' => 'nullable|integer|min:1|max:'.$remainingVolume,
                            ],
                            ['volume_use.max' => 'the remaining usable volume is '.$remainingVolume,
                            ]);
                     }
              }else{
              $projects = Project::create($request->all());
              }
       }else {
       $projects = Project::create(['contract_id' => $request->contract_id,
                     'name' => $request->name,
                     'no_po' => $request->no_po,
                     'po_sign_date' => $request->po_sign_date,
                     'po_start_date' => $request->po_start_date,
                     'po_end_date' => $request->po_end_date,
                     'price' => $request->price,
                     'total_price' => $request->total_price,
                     'created_by' => $request->created_by,
       ]);
       }
       if($request->filled($request->name_progress)){
       }else {
              foreach ($request->name_progress as $key=>$progress_item) {
                     if($request->filled($progress_item)){
                     }else {
                            Progress_item::create([
                            'project_id' => $projects->id,
                            'name_progress' => $progress_item,
                            'payment_percentage' => $request->payment_percentage[$key],
                            ]);
                     }
              }
       }
       if($request->filled($request->name_cost)){
       }else {
              foreach ($request->name_cost as $key=>$project_cost) {
                     if($request->filled($project_cost)){
                     }else {
                            Project_cost::create([
                            'project_id' => $projects->id,
                            'name_cost' => $project_cost,
                            'desc' => $request->desc[$key],
                            'total_cost' => $request->total_cost[$key],
                            ]);
                     }
              }
       }

       return redirect('/projects')->with('status', 'Success add Project!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $projects= Project::with('progress_item', 'project_cost')->get();
        $project_cost =$project->project_cost;
        $progress_item =$project->progress_item;
		$projContract = Project::with('Contract')->get();
        $contracts= Contract::all();
        $clients= Client::all();
		$types = Type::all();
        return view('projects.v_show', compact('project', 'clients', 'contracts', 'progress_item', 'project_cost', 'projContract', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        $projects= Project::with('progress_item', 'project_cost')->get();
        $project_cost =$project->project_cost;
        $progress_item =$project->progress_item;
        $contracts= Contract::all();
        $clients= Client::all();
        return view('projects.v_edit', compact('project', 'contracts', 'clients', 'progress_item', 'project_cost'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Project $project)
    {
       $request->validate([
          'no_po' => 'nullable|integer|min:1',
          'volume_use' => 'nullable|integer|min:1',
       ]);
       $dataPayment = $request->payment_percentage;
       $dataCost = $request->total_cost;
       $rules = [];

       if($dataPayment != 0){
              foreach($request->input('payment_percentage') as $key => $value) {
                     $rules["payment_percentage.{$key}"] = 'nullable|integer|min:1';
        }
              $validd = Validator::make($request->all(), $rules);
              if ($validd->fails()) {
                     return back()
                            ->with('statusProgress', 'The minimum amount used must be 1')
                            ->withInput();
              }
       }

       if($dataCost != 0){
              foreach($request->input('total_cost') as $key => $value) {
                     $rules["total_cost.{$key}"] = 'nullable|integer|min:1';
              }
              $validd = Validator::make($request->all(), $rules);
              if ($validd->fails()) {
                     return back()
                            ->with('statusCost', 'The minimum amount used must be 1')
                            ->withInput();
              }
       }

       $getitem=Progress_item::where('project_id', $project->id)->get();
       $collectPayment = collect($dataPayment);
       $totalPayment = $collectPayment->sum();
       $maxPayment = 100;
       $minPayment = 0;
       $payment_percentage = $getitem->sum('payment_percentage');

       if($totalPayment != 0){
              if($payment_percentage != $maxPayment){
                     if($totalPayment!=$maxPayment){
                            return back()->withInput()->with('statusProgress', 'The total of all invoices must be 100%');
                     }
              }else{
                     return back()->withInput()->with('statusProgress', 'The total of all invoices must be 100%. Delete rows.');
              }
        }

       $dataOlds =Project::all();
       foreach($dataOlds as $dataold){
              if($dataold->id==$project->id){
                     $contract_id= $dataold->contract_id;
                     $name= $dataold->name;
                     $no_po= $dataold->no_po;
                     $po_sign_date= $dataold->po_sign_date;
                     $po_start_date= $dataold->po_start_date;
                     $po_end_date = $dataold->po_end_date;
                     $price = $dataold->price;
                     $volume_use = $dataold->volume_use;
                     $total_price = $dataold->total_price;
                     $created_by= $dataold->created_by;
              }
       }
       $dataAllVolume =Project::where('contract_id', $contract_id)->get();
       $totalAllVolume = $dataAllVolume->sum('volume_use');
       $volume_usereq = $request->volume_use ;
       $contracts = Contract::where('id', $contract_id)->get();

       foreach ($contracts as $contract) {
              $remainingVolume = $contract->volume - $totalAllVolume;
       }

       $contract_idRequest = $request->contract_id;
       $dataAllVolumeReq=Project::where('contract_id', $contract_idRequest)->get();
       $totalAllVolumeReq= $dataAllVolumeReq->sum('volume_use');
       $contractsReqs = Contract::where('id', $contract_idRequest)->get();

       foreach ($contractsReqs as $contractReq) {
              $remainingVolumeReq=$contractReq->volume - $totalAllVolumeReq;
       }

       if($contract_id != null ){
              Project::where('id', $project->id)
              ->update(['contract_id' => $contract_id,]);
       }else{
              Project::where('id', $project->id)
              ->update(['contract_id' => $request->contract_id]);
       }
       if($name != null ){
              Project::where('id', $project->id)
              ->update(['name' => $name,]);
       }else{
              Project::where('id', $project->id)
              ->update(['name' => $request->name]);
       }
       if($no_po != null ){
              Project::where('id', $project->id)
              ->update(['no_po' => $no_po,]);
       }else{
               Project::where('id', $project->id)
              ->update(['no_po' => $request->no_po]);
       }
       if($po_sign_date != null ){
              Project::where('id', $project->id)
              ->update([
              'po_sign_date' => $po_sign_date,
              ]);
       }else{
              Project::where('id', $project->id)
              ->update(['po_sign_date' => $request->po_sign_date]);
       }
       if($price != null ){
              Project::where('id', $project->id)
              ->update(['price' => $price,]);
       }else{
              Project::where('id', $project->id)
              ->update(['price' => $request->price]);
       }
       if($po_start_date != null ){
              Project::where('id', $project->id)
              ->update(['po_start_date' => $po_start_date,]);
       }else{
              Project::where('id', $project->id)
              ->update(['po_start_date' => $request->po_start_date]);
       }
       if($po_end_date != null ){
              Project::where('id', $project->id)
              ->update(['po_end_date' => $po_end_date,]);
       }else{
              Project::where('id', $project->id)
              ->update(['po_end_date' => $request->po_end_date]);
       }
       $no_zero=0;
       if($contract_id != 0){
              if($volume_usereq != $no_zero){
                     if($volume_usereq <= $remainingVolume){
                            if($volume_use != null ){
                                   Project::where('id', $project->id)
                                   ->update(['volume_use' => $volume_use,]);

                            }else{
                                   Project::where('id', $project->id)
                                   ->update(['volume_use' => $request->volume_use]);
                            }
                     }else{
                            $this->validate($request, ['volume_use' => 'nullable|integer|min:1|max:'.$remainingVolume,
                            ],['volume_use.max' => 'the remaining usable volume is '.$remainingVolume]);
                     }
              }else {
                     $this->validate($request, ['volume_use' => 'nullable|integer|min:1|max:'.$remainingVolume,
                     ],['volume_use.max' => 'the remaining usable volume is '.$remainingVolume]);
              }
       }

       if($contract_idRequest != 0){
              if($volume_usereq != $no_zero){
                     if($volume_usereq <= $remainingVolumeReq){
                            if($volume_usereq != null ){
                                   Project::where('id', $project->id)
                                   ->update(['volume_use' => $volume_usereq,]);
                            }else{
                                   Project::where('id', $project->id)
                                   ->update(['volume_use' => $volume_use]);
                            }
                     }else{
                            $this->validate($request, ['volume_use' => 'nullable|integer|min:1|max:'.$remainingVolumeReq,
                            ],['volume_use.max' => 'the remaining usable volume is '.$remainingVolumeReq]);
                     }
              }else {
                     $this->validate($request, ['volume_use' => 'nullable|min:1|max:'.$remainingVolumeReq,
                     ],['volume_use.max' => 'the remaining usable volume is '.$remainingVolumeReq]);
              }
       }

       if($total_price != null ){
              Project::where('id', $project->id)
              ->update(['total_price' => $total_price,]);
       }else{
              Project::where('id', $project->id)
              ->update(['total_price' => $request->total_price]);
       }
       if($created_by != null ){
              Project::where('id', $project->id)
              ->update(['created_by' => $created_by,]);
       }else{
              Project::where('id', $project->id)
              ->update(['created_by' => $request->created_by]);
       }

       if($request->filled($request->name_progress)){
       }else {
              foreach ($request->name_progress as $key=>$progress_item) {
                     if($request->filled($progress_item)){
                     }else {
                            Progress_item::create([
                            'project_id' => $project->id,
                            'name_progress' => $progress_item,
                            'payment_percentage' => $request->payment_percentage[$key],
                            ]);
                     }
              }
       }
       // jika edit payment null dan name ada isinya
       // if($request->filled($request->name_progress)){
       // foreach ($request->payment_percentage as $key=>$payment_percentage) {
       // if ($request->filled($request->progress_id[$key])) {
       // }else {
       //                     Progress_item::where('id', $request->progress_id[$key])
       //                             ->update([ 'payment_percentage' => $payment_percentage,]);
       //               }
       // }
       // }else {
       //        foreach ($request->name_progress as $key=>$progress_item) {
       //               if($request->filled($progress_item)){
       //               }else {
       //                      Progress_item::create([
       //                      'project_id' => $project->id,
       //                      'name_progress' => $progress_item,
       //                      'payment_percentage' => $request->payment_percentage[$key],
       //                      ]);

       //               }
       //        }
       // }
       if($request->filled($request->name_cost)){
       }else {
              foreach ($request->name_cost as $key=>$project_cost) {
                     if($request->filled($project_cost)){
                     }else {
                            Project_cost::create([
                            'project_id' => $project->id,
                            'name_cost' => $project_cost,
                            'desc' => $request->desc[$key],
                            'total_cost' => $request->total_cost[$key],
                            ]);
                     }
              }
       }
       return redirect('/projects')->with('status', 'Success add Project!');
    }

       public function ammend(Project $project)
       {
        $projects= Project::with('progress_item', 'project_cost')->get();
        $project_cost =$project->project_cost;
        $progress_item =$project->progress_item;
        $contracts= Contract::all();
        $clients= Client::all();
        return view('projects.v_ammend', compact('project', 'contracts', 'clients', 'progress_item', 'project_cost'));
       }
       public function upammend(Request $request, Project $project)
       {
        //
        $request->validate([
           'name' => 'required',
           'no_po' => 'nullable|integer|min:1',
           'volume_use' => 'nullable|integer|min:1',
           'edit_by' => 'required',
         ]);

       $getitem=Progress_item::where('project_id', $project->id)->get();
       $dataPayment = $request->payment_percentage;
       $collectPayment = collect($dataPayment);
       $totalPayment = $collectPayment->sum();
       $maxPayment = 100;
       $minPayment = 0;
       $payment_percentage = $getitem->sum('payment_percentage');
       $dataCost = $request->total_cost;
       $totalAllPayment = $totalPayment + $payment_percentage;
       //return $totalAllPayment;
       $rules = [];

       if($dataPayment != 0){
              foreach($request->input('payment_percentage') as $key => $value) {
                     $rules["payment_percentage.{$key}"] = 'nullable|integer|min:1';
        }
              $validd = Validator::make($request->all(), $rules);
              if ($validd->fails()) {
                     return back()
                                   ->with('statusProgress', 'The minimum amount used must be 1')
                                   ->withInput();
              }
       }
       if($totalPayment != 0){
              if($payment_percentage != $maxPayment){
                     if($totalAllPayment!=$maxPayment) {
                            return back()->withInput()->with('statusProgress', 'The total of all invoices must be 100%');
                     }
              }else{
                     return back()->withInput()->with('statusProgress', 'The total of all invoices must be 100%. Delete rows.');
              }
       }

       if($dataCost != 0){
              foreach($request->input('total_cost') as $key => $value) {
                     $rules["total_cost.{$key}"] = 'nullable|integer|min:1';
              }
              $validd = Validator::make($request->all(), $rules);
              if ($validd->fails()) {
                     return back()
                            ->with('statusCost', 'The minimum amount used must be 1')
                            ->withInput();
              }
       }

       $contract_id = $request->contract_id;
       $dataAllVolume=Project::where('contract_id', $contract_id)->get();
       $volume_use= $dataAllVolume->sum('volume_use');
       $input = $request->volume_use ;
       $contracts = Contract::where('id', $contract_id)->get();

       if($contract_id != 0){
              foreach ($contracts as $contract) {
                     $max=$contract->volume - $volume_use;
              }
       }else {
              $max = 0;
       }

       $no_zero=0;
       $thisvolume= Project::where('id', $project->id)->first()->volume_use;
       $sisaupdate= $max + $thisvolume;
       if($contract_id != 0 ){
              if($input != $no_zero){
                     if($thisvolume == 0){
                            if($input <= $max){
                                   Project::where('id', $project->id)
                                   ->update(['volume_use' => $request->volume_use,]);
                            }else{
                                   $this->validate($request, [
                                   'volume_use' => 'nullable|integer|min:1|max:'.$max,
                                   ],
                                   ['volume_use.max' => 'the remaining usable volume is '.$max]);
                            }
                     }else {
                            if($input <= $sisaupdate){
                                   Project::where('id', $project->id)
                                   ->update(['volume_use' => $request->volume_use,]);
                            }else{
                                   $this->validate($request, [
                                   'volume_use' => 'nullable|integer|min:1|max:'.$sisaupdate,
                                   ],
                                   ['volume_use.max' => 'the remaining usable volume is '.$sisaupdate]);
                             }
                     }
               }else{
                     $this->validate($request, ['volume_use' => 'nullable|integer|min:1|max:'.$max,
                     ],['volume_use.max' => 'the remaining usable volume is '.$max]);
              }
       }else {
              Project::where('id', $project->id)
              ->update([
              'contract_id' => $request->contract_id,
              'name' => $request->name,
              'no_po' => $request->no_po,
              'po_sign_date' => $request->po_sign_date,
              'po_start_date' => $request->po_start_date,
              'po_end_date' => $request->po_end_date,
              'price' => $request->price,
              'volume_use' => $request->volume_use,
              'total_price' => $request->total_price,
              'created_by' => $request->edit_by,
              ]);
       }

       $progressOlds =Progress_item::where('project_id', $project->id)->get();
       if($request->filled($request->name_progress)){
       }else {
              if($totalAllPayment != 100){
                     return back()->withInput()->with('statusProgress', 'The total of all invoices must be 100%');
              }else{
                     foreach ($request->name_progress as $key=>$progress_item) {
                            if($request->filled($progress_item)){
                            }else {
                                   Progress_item::create([
                                   'project_id' => $project->id,
                                   'name_progress' => $progress_item,
                                   'payment_percentage' => $request->payment_percentage[$key],
                                   ]);
                            }
                     }
              }

       }

       foreach ($progressOlds as $progressOld) {
              $progress_idOld = $progressOld->id;
              $projectid_Old = $progressOld->project_id;
              $name_progressOld = $progressOld->name_progress;
              $payment_percentageOld = $progressOld->payment_percentage;
              $status_idOld = $progressOld->status_id;
              $created_atOld = $progressOld->created_at;
              $update_atOld = $progressOld->updated_at;
       Progress_item_history::create([
              'progress_item_id' =>$progress_idOld,
              'project_id' =>$projectid_Old,
              'name_progress' =>$name_progressOld,
              'payment_percentage' =>$payment_percentageOld,
              'status_id' =>$status_idOld,
              'created_at'=>$created_atOld,
              'updated_at'=> $update_atOld,
       ]);
       }


       if($request->filled($request->name_cost)){
       }else {
              foreach ($request->name_cost as $key=>$project_cost) {
                     if($request->filled($project_cost)){
                     }else {
                            Project_cost::create([
                            'project_id' => $project->id,
                            'name_cost' => $project_cost,
                            'desc' => $request->desc[$key],
                            'total_cost' => $request->total_cost[$key],
                            ]);
                     }
              }
       }
       Project::where('id', $project->id)
              ->update(['contract_id' => $request->contract_id,
              'name' => $request->name,
              'no_po' => $request->no_po,
              'po_sign_date' => $request->po_sign_date,
              'po_start_date' => $request->po_start_date,
              'po_end_date' => $request->po_end_date,
              'price' => $request->price,
              'volume_use' => $request->volume_use,
              'total_price' => $request->total_price,
              'created_by' => $request->edit_by,
              ]);

       $project->getOriginal();
       Project_history::create([
            'project_id'=>$project->getOriginal('id'),
            'contract_id' => $project->getOriginal('contract_id'),
            'name'=> $project->getOriginal('name'),
            'no_po' => $project->getOriginal('no_po'),
            'po_sign_date' => $project->getOriginal('po_sign_date'),
            'po_start_date' => $project->getOriginal('po_start_date'),
            'po_end_date' => $project->getOriginal('po_end_date'),
            'price' => $project->getOriginal('price'),
            'volume_use' => $project->getOriginal('volume_use'),
            'total_price' => $project->getOriginal('total_price'),
            'created_by'=>$project->getOriginal('created_by'),
            'edit_by'=>$request->edit_by,
            'created_at'=>$project->getOriginal('created_at'),
            'updated_at'=> $project->getOriginal('updated_at'),
       ]);
       return redirect('/projects')->with('status', 'Data Success Change!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        Project::destroy($project->id);
        return redirect('/projects')->with('status', 'Success Deleting Data!');
    }
    public function destroyItem(Progress_item $progress_item)
    {
       Progress_item::destroy($progress_item->id);
    }
    public function destroyCost(Project_cost $project_cost)
    {
       Project_cost::destroy($project_cost->id);
    }
}

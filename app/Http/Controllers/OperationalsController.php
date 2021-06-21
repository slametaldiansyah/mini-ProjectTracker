<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use App\Models\Clients;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Progress_doc;
use App\Models\Progress_item;
use App\Models\Project_cost;
use App\Models\Project_cost_history;
use App\Models\Progress_status;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OperationalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operationals = Project::with(['contract.client'])->get();
        return view('operationals.v_index', compact('operationals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $progress_items= Progress_item::where('project_id', $id)->get();
        $progress_docs = Progress_item::with('doc')->where('project_id', $id)->get();
        $project_cost = Project_cost::where('project_id', $id)->get();
        return view('operationals.v_show', compact('progress_docs', 'id', 'progress_items','project_cost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progress_item  $progress_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress_item $progress_item, $id)
    {
        $progress_items= Progress_item::where('project_id', $id)->get();
        $progress_docs = Progress_item::with('doc')->where('project_id', $id)->get();
        $project_cost = Project_cost::where('project_id', $id)->get();
        return view('operationals.v_edit', compact('progress_docs', 'id','progress_items','project_cost'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Project_cost $project_cost)
    {
        if($request->filled($request->name_cost)){
        }else {
            foreach ($request->name_cost as $key=>$project_cost) {
                $validator = Validator::make($request->all(), [
                'total_cost.*' => 'nullable|integer|min:1',
                ]);
                if ($validator->fails()) {
                return back()
                        ->with('errorUpload', 'The minimum amount used must be 1');
                }
                if($request->filled($project_cost)){
                }else {
                    if($request->cost_id[$key] != null){
                        $originals = Project_cost::where('id', $request->cost_id[$key])->get();
                        foreach ($originals as $original) {
                            $id_ori = $original->id;
                            $project_id_ori = $original->project_id;
                            $name_cost_ori = $original->name_cost;
                            $desc_ori = $original->desc;
                            $total_cost_ori = $original->total_cost;
                            $created_at_ori = $original->created_at;
                            $updated_at_ori = $original->updated_at;
                        }
                        Project_cost_history::create([
                        'project_cost_id' => $id_ori,
                        'project_id' => $project_id_ori,
                        'name_cost' => $name_cost_ori,
                        'desc' => $desc_ori,
                        'total_cost' => $total_cost_ori,
                        'created_at'=>$created_at_ori,
                        'updated_at'=> $updated_at_ori,
                        ]);
                        Project_cost::where('id', $request->cost_id[$key])->update([
                        'name_cost' => $project_cost,
                        'desc' => $request->desc[$key],
                        'total_cost' => $request->total_cost[$key],
                        ]);
                    }
                    if ($request->cost_id[$key] == null && $project_cost != null) {
                        Project_cost::create([
                        'project_id' => $id,
                        'name_cost' => $project_cost,
                        'desc' => $request->desc[$key],
                        'total_cost' => $request->total_cost[$key],
                        ]);
                    }
                }
            }
        }
        return redirect('/operationals')->with('status', 'Update Success!');
    }

    public function uploadProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        ]);
          if ($validator->fails()) {
                     return back()
                            ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
                            ->withInput();
              }
        $files = $request->file('filename');
        if($files){
            foreach ($files as $file) {
                $filename = time().'.'.$file->getClientOriginalName();
                Progress_doc::create([
                'filename' => $filename,
                'progress_item_id' => $request->progress_id,
                ]);
                $file->move(public_path('progress_docs'), $filename);
            }
        }else {
        return back()->with('null', 'No files uploaded');
        }
        return back()->with('status', 'Upload Success');
    }
     public function changeStatus(Request $request)
    {
		$sumAmount = "";
        if ($request->name == "invoice_status")
            {
            $userid = session()->get('token')['user']['id'];
            $getProgress = Progress_item::where('id', $request->id)->first();
            $getAmout = Project::where('id', $getProgress->project_id)->first();
            $sumAmount = ($getProgress->payment_percentage / 100) * $getAmout->total_price ;
            Invoice::create([
                'project_id' => $getProgress->project_id,
                'progress_item_id' => $request->id,
                'user_trigger' => $userid,
                'amount_total' => $sumAmount,
            ]);
            $getstatus = Progress_status::where('status', $request->dataOn)->first();
            $status_id = $getstatus->id;
            Progress_item::where('id', $request->id)->update([
            'invoice_status_id' => $status_id,
            ]);
        } elseif
        ($request->name == "status"){
            $getstatus = Progress_status::where('status', $request->dataOn)->first();
            $status_id = $getstatus->id;
            Progress_item::where('id', $request->id)->update([
            'status_id' => $status_id,
            ]);
        }
        // $status_id = $request->name;
        return response()->json(['success'=>'User status change successfully.'.$sumAmount]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
     public function destroyDoc(Progress_doc $progress_doc)
    {
        $file = Progress_doc::find($progress_doc->id);
        $filename = $progress_doc->filename;
        if(File::exists(public_path('progress_docs/'.$filename))){
           File::delete(public_path('progress_docs/'.$filename));
        }
        Progress_doc::destroy($progress_doc->id);
        return response()->json(['success'=>'Delete successfully.'.$filename]);
    }
}

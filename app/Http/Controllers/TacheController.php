<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:list-task|create-task|update-task|delete-task', ['only' => ['index','show']]);
        $this->middleware('permission:create-task', ['only' => ['create','store']]);
        $this->middleware('permission:update-task', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-task', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $taches = Tache::latest()->paginate(5);
        return view('taches.index',compact('taches'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('taches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        request()->validate([
            'libelle' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        Tache::create($request->all());

        return redirect()->route('taches.index')
            ->with('success','Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Tache $tache)
    {
        return view('taches.show',compact('tache'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Tache $tache)
    {
        return view('taches.edit',compact('tache'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tache $tache)
    {
        request()->validate([
            'libelle' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $tache->update($request->all());

        return redirect()->route('taches.index')
            ->with('success','Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tache $tache)
    {
        $tache->delete();

        return redirect()->route('taches.index')
            ->with('success','Task deleted successfully');
    }
}

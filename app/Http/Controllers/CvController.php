<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;

use App\Cv;

use App\Experience;

use Auth;

use App\Http\Requests\cvRequest;

use Carbon\Carbon;

class CvController extends Controller
{

    public function __construct() {

         $this->middleware('auth');
    }

	//lister les cvs
    public function index() {

        if(Auth::user()->is_admin) {
          $listcv = Cv::all();
        }else{
          $listcv = Auth::user()->cvs;
        }
        
        return view('cv.index', ['cvs' => $listcv]);
    }

    //Affiche le formulaire de creation de cv
    public function create() {
       return view('cv.create');
    }

    //Enregister un cv
    public function store(cvRequest $request) {
       $cv = new Cv();

       $cv->titre = $request->input('titre');
       $cv->presentation = $request->input('presentation');
       $cv->user_id = Auth::user()->id;
        
         $jdate = Carbon::now(); 
        if($request->hasFile('photo'))
       {
        $photo = date('His').$request->file('photo')->getClientOriginalName();
        $path = "annonces\\".$jdate->format('F').$jdate->year;
        $pathh = "annonces\\".$jdate->format('F').$jdate->year."\\".$photo;
        $move = $request->file('photo')->storeAs($path,$photo);
        $cv->photo = $pathh;
        }

       $cv->save();

       session()->flash('success', 'Le cv à été bien enregistré !!');

       return redirect('cvs');
    }

    //permet de récupérer un cv puis de le mettre dans un le formulaire
    public function edit($id) {

       $cv = Cv::find($id);

       $this->authorize('update', $cv);

       return view('cv.edit', ['cv' => $cv]);
    }

    //permet de modifier un cv
    public function update(cvRequest $request, $id) {
        $cv = Cv::find($id);
        $this->authorize('update', $cv);
        $cv->titre = $request->input('titre');
        $cv->presentation = $request->input('presentation');

         $jdate = Carbon::now(); 
      if($request->hasFile('photo'))
       {
        $photo = date('His').$request->file('photo')->getClientOriginalName();
        $path = "annonces\\".$jdate->format('F').$jdate->year;
        $pathh = "annonces\\".$jdate->format('F').$jdate->year."\\".$photo;
        $move = $request->file('photo')->storeAs($path,$photo);
        $cv->photo = $pathh;
        }

        $cv->save();
        return redirect('cvs');
    }


    public function show($id)
    {
       return view('cv.show', ['id' => $id]);
    }

    //permet de supprimer un cv
    public function destroy(Request $request, $id) {

       $cv = Cv::find($id);

       $this->authorize('delete', $cv);

       $cv->delete();

       return redirect('cvs');
    }

    public function getExperience($id){
        $cv=Cv::find($id);
        return $cv->experiences()->orderBy('created_at','desc')->get();
    }

    public function addExperience(Request $request){
      $experience = new Experience;
      $experience->titre = $request->titre;
      $experience->body = $request->body;
      $experience->debut = $request->debut;
      $experience->fin = $request->fin;
      $experience->cv_id = $request->cv_id;

      $experience->save();

      return Response()->json(['etat' => true,'id' => $experience->id]);
    }
    public function updateExperience(Request $request){

      $experience= Experience::find($request->id);
        $experience->titre = $request->titre;
        $experience->body = $request->body;
        $experience->debut = $request->debut;
        $experience->fin = $request->fin;
        $experience->cv_id = $request->cv_id;

      $experience->save();

      return Response()->json(['etat' => true]);
    }
    public function deleteExperience($id){
      $experience=Experience::find($id);
      $experience->delete();

          return Response()->json(['etat' => true]);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use App\Game;
use App\Questionnaire;
use DB;
use Charts;

class HistoryController extends Controller
{
  public $successStatus = 200;

  public function storegame(Request $request) {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|numeric',
      'responsetime' => 'required|string',
      'accuracy' => 'required|string',
      'bef_feel' => 'nullable|string',
      'aft_feel' => 'nullable|string'
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to store result', 'status' => false], 401);
    }
    $user = User::find($request->user_id);
    if ($user != null) {
      $game = new Game([
        'user_id' => $user->id,
        'responsetime' => $request->responsetime,
        'accuracy' => $request->accuracy,
        'bef_feel' => $request->bef_feel,
        'aft_feel' => $request->aft_feel
      ]);
      $game ->save();
      $id = $game -> id;
      return response()->json(['message' => 'Result stored', 'id' => $id, 'status' => true], $this->successStatus);
    }
    else{
      return response()->json(['message' => 'User Not Found', 'status' => false], 402);
    }
  }

  public function storequestionnaire(Request $request) {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|numeric',
      'phqscore' => 'required|string',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to store result', 'status' => false], 401);
    }
    $user = User::find($request->user_id);
    if ($user != null) {
      $score = $request->phqscore;
      if($score < 5)
      {
        $level = 'Minimal or None';
      }
      else if($score < 10)
      {
        $level = 'Mild';
      }
      else if($score < 15)
      {
        $level = 'Moderate';
      }
      else if($score < 20)
      {
        $level = 'Moderately Severe';
      }
      else{
        $level = 'Severe';
      }
      $questionnaire = new Questionnaire([
        'user_id' => $user->id,
        'phqscore' => $request->phqscore,
        'level' => $level
      ]);
      $questionnaire ->save();
      $id = $questionnaire -> id;
      $user->currentlevel = $level;
      $user->save();
      return response()->json(['message' => 'Result stored', 'id' => $id, 'status' => true], $this->successStatus);
    }
    else{
      return response()->json(['message' => 'User Not Found', 'status' => false], 402);
    }
  }

  public function gameslist(Request $request) {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|numeric',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to display result', 'status' => false], 401);
    }
    $user = User::find($request->user_id);
    if ($user != null) {
      $filtergames = Game::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
      if(!$filtergames->isEmpty()){
        return response()->json($filtergames, $this->successStatus);
      }
      else{
        return response()->json(['message' => 'No History', 'status' => false], 403);
      }
    }
    else{
       return response()->json(['message' => 'User Not Found', 'status' => false], 402);
    }
  }

  public function questionnaireslist(Request $request) {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|numeric',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to display result', 'status' => false], 401);
    }
    $user = User::find($request->user_id);
    if ($user != null) {
      $filterquestionnaires = Questionnaire::where('user_id', $user->id) ->orderBy('created_at','DESC')->get();
      if(!$filterquestionnaires->isEmpty()){
        return response()->json($filterquestionnaires, $this->successStatus);
      }
      else{
        return response()->json(['message' => 'No History', 'status' => false], 403);
      }
    }
    else{
       return response()->json(['message' => 'User Not Found', 'status' => false], 402);
    }
  }

  public function previousgameresult(Request $request) {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|numeric',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Failed to get result', 'status' => false], 401);
    }
    $user = User::find($request->user_id);
    if ($user != null) {
      $filtergames = Game::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
      if($filtergames!= null){
        return response()->json($filtergames, $this->successStatus);
      }
      else{
        return response()->json(['message' => 'No result found', 'status' => false], 403);
      }
    }
    else{
       return response()->json(['message' => 'User Not Found', 'status' => false], 402);
    }
  }

  public function games(Request $request) {
    $games = Game::get();
    return response()->json($games, $this->successStatus);
  }

  public function questionnaires(Request $request) {
    $questionnaires = Questionnaire::get();
    return response()->json($questionnaires, $this->successStatus);
  }

  public function updategameresult(Request $request, $id) {
    $game = Game::find($id);
    if ($game != null) {
      $game->bef_feel = $request->bef_feel;
      $game->aft_feel = $request->aft_feel;
      $game->save();
      return response()->json(['message' => 'Game result Updated Successfully', 'status' => true], $this->successStatus);
    }
    else{
      return response()->json(['message' => 'History Not Found', 'status' => false], 402);
    }
  }

 public function webdata(Request $request) {
      $users = User::all();
       $filtergameL1 = DB::table('games')
             ->join('users', 'users.id', '=', 'games.user_id')
             ->select('name','age','gender','height','weight','country','race','illness','responsetime','accuracy','bef_feel','aft_feel','games.created_at')
             ->where('currentlevel','=', 'Minimal or None')
             ->orderBy('name')
             ->get();
       $filtergameL2 = DB::table('games')
             ->join('users', 'users.id', '=', 'games.user_id')
             ->select('name','age','gender','height','weight','country','race','illness','responsetime','accuracy','bef_feel','aft_feel','games.created_at')
             ->where('currentlevel','=', 'Mild')
             ->orderBy('name')
             ->get();
       $filtergameL3 = DB::table('games')
             ->join('users', 'users.id', '=', 'games.user_id')
             ->select('name','age','gender','height','weight','country','race','illness','responsetime','accuracy','bef_feel','aft_feel','games.created_at')
             ->where('currentlevel','=', 'Moderate')
             ->orderBy('name')
             ->get();
       $filtergameL4 = DB::table('games')
             ->join('users', 'users.id', '=', 'games.user_id')
             ->select('name','age','gender','height','weight','country','race','illness','responsetime','accuracy','bef_feel','aft_feel','games.created_at')
             ->where('currentlevel','=', 'Moderately Severe')
             ->orderBy('name')
             ->get();
       $filtergameL5 = DB::table('games')
             ->join('users', 'users.id', '=', 'games.user_id')
             ->select('name','age','gender','height','weight','country','race','illness','responsetime','accuracy','bef_feel','aft_feel','games.created_at')
             ->where('currentlevel','=', 'Severe')
             ->orderBy('name')
             ->get();
       $filtergameUnknown = DB::table('games')
             ->join('users', 'users.id', '=', 'games.user_id')
             ->select('name','age','gender','height','weight','country','race','illness','responsetime','accuracy','bef_feel','aft_feel','games.created_at')
             ->where('currentlevel','=', null)
             ->orderBy('name')
             ->get();
        $filterquestionnaire = DB::table('questionnaires')
              ->join('users', 'users.id', '=', 'questionnaires.user_id')
              ->select('name','age','gender','height','weight','country','race','illness','phqscore','level','questionnaires.created_at')
              ->orderBy('name')
              ->get();
       return view('usersdata')->with('filtergameUnknown',$filtergameUnknown)->with('filtergameL1',$filtergameL1)->with('filtergameL2',$filtergameL2)->with('filtergameL3',$filtergameL3)->with('filtergameL4',$filtergameL4)->with('filtergameL5',$filtergameL5)->with('filterquestionnaire',$filterquestionnaire);
   }

   public function webstatistic(Request $request){
     $users = User::all();

     $chart = Charts::database($users, 'pie', 'highcharts')
                ->title("Gender")
                ->elementLabel("Total Users")
                ->dimensions(800, 400)
                ->responsive(true)
                ->groupBy('gender');

     $ageRange = [];
     $ageRange[0] = DB::table('users')->where('age','<','13')->count();
     $ageRange[1] = DB::table('users')->whereBetween('age',array('13','21'))->count();
     $ageRange[2] = DB::table('users')->whereBetween('age',array('22','30'))->count();
     $ageRange[3] = DB::table('users')->whereBetween('age',array('31','40'))->count();
     $ageRange[4] = DB::table('users')->whereBetween('age',array('41','60'))->count();
     $ageRange[5] = DB::table('users')->where('age','>','60')->count();
     $chartAge = Charts::create('pie', 'highcharts')
                       ->title("Age")
                       ->elementLabel("Total Users")
                       ->dimensions(1000, 500)
                       ->responsive(true)
                       ->labels(['<13', '13-21', '22-30','31-40','41-60','>60'])
                       ->values($ageRange);

     $chartRace = Charts::database($users, 'pie', 'highcharts')
                       ->title("Race")
                       ->elementLabel("Total Users")
                       ->dimensions(800, 400)
                       ->responsive(true)
                       ->groupBy('race');

    $heightRange = [];
    $heightRange[0] = DB::table('users')->where('height','<','131')->count();
    $heightRange[1] = DB::table('users')->whereBetween('height',array('131','140'))->count();
    $heightRange[2] = DB::table('users')->whereBetween('height',array('141','150'))->count();
    $heightRange[3] = DB::table('users')->whereBetween('height',array('151','160'))->count();
    $heightRange[4] = DB::table('users')->whereBetween('height',array('161','170'))->count();
    $heightRange[5] = DB::table('users')->whereBetween('height',array('171','180'))->count();
    $heightRange[6] = DB::table('users')->where('height','>','180')->count();
    $chartHeight = Charts::create('pie', 'highcharts')
                      ->title("Height")
                      ->elementLabel("Total Users")
                      ->dimensions(1000, 500)
                      ->responsive(true)
                      ->labels(['<131', '131-140', '141-150','151-160','161-170','171-180','>180'])
                      ->values($heightRange);

    $weightRange = [];
    $weightRange[0] = DB::table('users')->where('weight','<','30')->count();
    $weightRange[1] = DB::table('users')->whereBetween('weight',array('31','40'))->count();
    $weightRange[2] = DB::table('users')->whereBetween('weight',array('41','50'))->count();
    $weightRange[3] = DB::table('users')->whereBetween('weight',array('51','60'))->count();
    $weightRange[4] = DB::table('users')->whereBetween('weight',array('61','70'))->count();
    $weightRange[5] = DB::table('users')->whereBetween('weight',array('71','80'))->count();
    $weightRange[6] = DB::table('users')->where('weight','>','80')->count();
    $chartWeight = Charts::create('pie', 'highcharts')
                      ->title("Weight")
                      ->elementLabel("Total Users")
                      ->dimensions(1000, 500)
                      ->responsive(true)
                      ->labels(['<31', '31-40', '41-50','51-60','61-70','71-80','>80'])
                      ->values($weightRange);

     $btbefore = [];
     $btbefore[0] = DB::table('games')->where('bef_feel','1')->count();
     $btbefore[1] = DB::table('games')->where('bef_feel','2')->count();
     $btbefore[2] = DB::table('games')->where('bef_feel','3')->count();
     $btbefore[3] = DB::table('games')->where('bef_feel','4')->count();
     $btbefore[4] = DB::table('games')->where('bef_feel','5')->count();
     $btafter = [];
     $btafter[0] = DB::table('games')->where('aft_feel','1')->count();
     $btafter[1] = DB::table('games')->where('aft_feel','2')->count();
     $btafter[2] = DB::table('games')->where('aft_feel','3')->count();
     $btafter[3] = DB::table('games')->where('aft_feel','4')->count();
     $btafter[4] = DB::table('games')->where('aft_feel','5')->count();
     $chartBt = Charts::multi('bar', 'highcharts')
                    ->title("Happiness Changes")
                    ->elementLabel("Total Users")
                    ->dimensions(1000, 500)
                    ->responsive(true)
                    ->labels(['1', '2', '3', '4', '5'])
                    ->dataset('Before', $btbefore)
                    ->dataset('After',  $btafter);

    return view('statistic', compact('chart'), compact('chartBt'))->with('chartAge',$chartAge)->with('chartRace',$chartRace)->with('chartHeight',$chartHeight)->with('chartWeight',$chartWeight);
   }
}

@extends('layouts.app')
<head>
  <title>Users'Records</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
@section('content')
<div class="col-md-12">
        <div class="col-sm-12">
                  @if(Auth::check() && Auth::user()->isAdmin())
                      @if (session('status'))
                        <div class="panel-body">
                          <div class="alert alert-success">
                            {{ session('status') }}
                          </div>
                        </div>
                      @endif
                  @else
                    <center><h4>You have no access rights. This page only available for admin.</h4></center>
                  @endif

               @if (Auth::check() && Auth::user()->isAdmin())
                <ul class="nav nav-tabs">
                  <li class="active"><a href="usersdata">Depression's Records</a></li>
                  <li><a href="statistic">Statistic Records</a></li>
                </ul>

                	<div class="panel panel-default">
                			<!--Display records-->
                      </br>
                      <h4 style="margin:5"><center><b>Questionnaire Results</b></center></h4>
                      </br>
                        <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                  				<thead>
                  					<tr>
                  						<th scope="col">No.</th>
                              <th scope="col">Name</th>
                  						<th scope="col">Age</th>
                              <th scope="col">Gender</th>
                  						<th scope="col" style="width:80;">Country</th>
                  						<th scope="col">Race</th>
                              <th scope="col">Height(cm)</th>
                              <th scope="col">Weight(kg)</th>
                              <th scope="col">Illness</th>
                  						<th scope="col">PHQ9 Score</th>
                              <th scope="col">Level</th>
                  						<th scope="col">Date&Time</th>
                  					</tr>
                  				</thead>
                  				<tbody>
                            <?php $count = 0; foreach ($filterquestionnaire as $result):
                              ?>
                            <tr>
                                <td scope="row"><?= ++$count ?></td>
                                <td>{{$result->name}}</td>
                                <td>{{$result->age}}</td>
                                <td>{{$result->gender}}</td>
                                <td>{{$result->country}}</td>
                                <td>{{$result->race}}</td>
                                <td>{{$result->height}}</td>
                                <td>{{$result->weight}}</td>
                                <td><?= $result->illness != null ? $result->illness : "None" ?></td>
                                <td>{{$result->phqscore}}</td>
                                <td>{{$result->level}}</td>
                                <td>{{$result->created_at}}</td>
                            </tr>
                            <?php endforeach; ?>
                  				</tbody>
                  			</table>
                      </br></br></br></br>
                      <h4 style="margin:5"><center><b>Game Results</b></center></h4>
                      </br>
                      <h4 style="margin:5"><u>Minimal or None</u></h4>
                      <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                        <thead>
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col" style="width:80;">Country</th>
                            <th scope="col">Race</th>
                            <th scope="col">Height(cm)</th>
                            <th scope="col">Weight(kg)</th>
                            <th scope="col">Illness</th>
                            <th scope="col">ResponseTime(ms)</th>
                            <th scope="col">Accuracy(%)</th>
                            <th scope="col">Happiness</th>
                            <th scope="col">Date&Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $count = 0; foreach ($filtergameL1 as $value): ?>
                          <tr>
                              <td scope="row"><?= ++$count ?></td>
                              <td>{{$value->name}}</td>
                              <td>{{$value->age}}</td>
                              <td>{{$value->gender}}</td>
                              <td>{{$value->country}}</td>
                              <td>{{$value->race}}</td>
                              <td>{{$value->height}}</td>
                              <td>{{$value->weight}}</td>
                              <td><?= $value->illness != null ? $value->illness : "None" ?></td>
                              <td>{{$value->responsetime}}</td>
                              <td>{{$value->accuracy}}</td>
                              <td>{{$value->bef_feel}} -> {{$value->aft_feel}}</td>
                              <td>{{$value->created_at}}</td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </br></br>
                    <h4 style="margin:5"><u>Mild</u></h4>
                    <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Name</th>
                          <th scope="col">Age</th>
                          <th scope="col">Gender</th>
                          <th scope="col" style="width:80;">Country</th>
                          <th scope="col">Race</th>
                          <th scope="col">Height(cm)</th>
                          <th scope="col">Weight(kg)</th>
                          <th scope="col">Illness</th>
                          <th scope="col">ResponseTime(ms)</th>
                          <th scope="col">Accuracy(%)</th>
                          <th scope="col">Happiness</th>
                          <th scope="col">Date&Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $count = 0; foreach ($filtergameL2 as $value): ?>
                        <tr>
                            <td scope="row"><?= ++$count ?></td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->age}}</td>
                            <td>{{$value->gender}}</td>
                            <td>{{$value->country}}</td>
                            <td>{{$value->race}}</td>
                            <td>{{$value->height}}</td>
                            <td>{{$value->weight}}</td>
                            <td><?= $value->illness != null ? $value->illness : "None" ?></td>
                            <td>{{$value->responsetime}}</td>
                            <td>{{$value->accuracy}}</td>
                            <td>{{$value->bef_feel}} -> {{$value->aft_feel}}</td>
                            <td>{{$value->created_at}}</td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </br></br>
                  <h4 style="margin:5"><u>Moderate</u></h4>
                  <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col" style="width:80;">Country</th>
                        <th scope="col">Race</th>
                        <th scope="col">Height(cm)</th>
                        <th scope="col">Weight(kg)</th>
                        <th scope="col">Illness</th>
                        <th scope="col">ResponseTime(ms)</th>
                        <th scope="col">Accuracy(%)</th>
                        <th scope="col">Happiness</th>
                        <th scope="col">Date&Time</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $count = 0; foreach ($filtergameL3 as $value): ?>
                      <tr>
                          <td scope="row"><?= ++$count ?></td>
                          <td>{{$value->name}}</td>
                          <td>{{$value->age}}</td>
                          <td>{{$value->gender}}</td>
                          <td>{{$value->country}}</td>
                          <td>{{$value->race}}</td>
                          <td>{{$value->height}}</td>
                          <td>{{$value->weight}}</td>
                          <td><?= $value->illness != null ? $value->illness : "None" ?></td>
                          <td>{{$value->responsetime}}</td>
                          <td>{{$value->accuracy}}</td>
                          <td>{{$value->bef_feel}} -> {{$value->aft_feel}}</td>
                          <td>{{$value->created_at}}</td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                    </br></br>
                    <h4 style="margin:5"><u>Moderately Severe</u></h4>
                    <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Name</th>
                          <th scope="col">Age</th>
                          <th scope="col">Gender</th>
                          <th scope="col" style="width:80;">Country</th>
                          <th scope="col">Race</th>
                          <th scope="col">Height(cm)</th>
                          <th scope="col">Weight(kg)</th>
                          <th scope="col">Illness</th>
                          <th scope="col">ResponseTime(ms)</th>
                          <th scope="col">Accuracy(%)</th>
                          <th scope="col">Happiness</th>
                          <th scope="col">Date&Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $count = 0; foreach ($filtergameL4 as $value): ?>
                        <tr>
                            <td scope="row"><?= ++$count ?></td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->age}}</td>
                            <td>{{$value->gender}}</td>
                            <td>{{$value->country}}</td>
                            <td>{{$value->race}}</td>
                            <td>{{$value->height}}</td>
                            <td>{{$value->weight}}</td>
                            <td><?= $value->illness != null ? $value->illness : "None" ?></td>
                            <td>{{$value->responsetime}}</td>
                            <td>{{$value->accuracy}}</td>
                            <td>{{$value->bef_feel}} -> {{$value->aft_feel}}</td>
                            <td>{{$value->created_at}}</td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </br></br>
                  <h4 style="margin:5"><u>Severe</u></h4>
                  <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col" style="width:80;">Country</th>
                        <th scope="col">Race</th>
                        <th scope="col">Height(cm)</th>
                        <th scope="col">Weight(kg)</th>
                        <th scope="col">Illness</th>
                        <th scope="col">ResponseTime(ms)</th>
                        <th scope="col">Accuracy(%)</th>
                        <th scope="col">Happiness</th>
                        <th scope="col">Date&Time</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $count = 0; foreach ($filtergameL5 as $value): ?>
                      <tr>
                          <td scope="row"><?= ++$count ?></td>
                          <td>{{$value->name}}</td>
                          <td>{{$value->age}}</td>
                          <td>{{$value->gender}}</td>
                          <td>{{$value->country}}</td>
                          <td>{{$value->race}}</td>
                          <td>{{$value->height}}</td>
                          <td>{{$value->weight}}</td>
                          <td><?= $value->illness != null ? $value->illness : "None" ?></td>
                          <td>{{$value->responsetime}}</td>
                          <td>{{$value->accuracy}}</td>
                          <td>{{$value->bef_feel}} -> {{$value->aft_feel}}</td>
                          <td>{{$value->created_at}}</td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </br></br>
                <h4 style="margin:5"><u>Unknown</u></h4>
                <table id="table_data" class="display nowrap table table-striped" style="width: 100%,">
                  <thead>
                    <tr>
                      <th scope="col">No.</th>
                      <th scope="col">Name</th>
                      <th scope="col">Age</th>
                      <th scope="col">Gender</th>
                      <th scope="col" style="width:80;">Country</th>
                      <th scope="col">Race</th>
                      <th scope="col">Height(cm)</th>
                      <th scope="col">Weight(kg)</th>
                      <th scope="col">Illness</th>
                      <th scope="col">ResponseTime(ms)</th>
                      <th scope="col">Accuracy(%)</th>
                      <th scope="col">Happiness</th>
                      <th scope="col">Date&Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $count = 0; foreach ($filtergameUnknown as $value): ?>
                    <tr>
                        <td scope="row"><?= ++$count ?></td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->age}}</td>
                        <td>{{$value->gender}}</td>
                        <td>{{$value->country}}</td>
                        <td>{{$value->race}}</td>
                        <td>{{$value->height}}</td>
                        <td>{{$value->weight}}</td>
                        <td><?= $value->illness != null ? $value->illness : "None" ?></td>
                        <td>{{$value->responsetime}}</td>
                        <td>{{$value->accuracy}}</td>
                        <td>{{$value->bef_feel}} -> {{$value->aft_feel}}</td>
                        <td>{{$value->created_at}}</td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                      </br></br></br></br>
                		</div>
                  @endif
            </div>
          </div>
@endsection

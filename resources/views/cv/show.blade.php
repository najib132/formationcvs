@extends('layouts.app')
@section('content')

<div class="container" id="app">
	<div class="row">
		<div class="col-md-12">

			<h1>@{{ message }}</h1>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10"><h3 class="panel-title">Experience</h3></div>
						<div class="col-md-2 text-right">
							<button class="btn btn-success" @click = "open = true">Ajouter</button>
						</div>
					</div>

				</div>

				<div class="panel-body">

                    <div v-if="open">
                        <div class="form-group">
                            <label>Titre</label>
                            <input type="Text" class="form-control" placeholder="Le titre" v-model="experience.titre">
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <Textarea type="Text" class="form-control" placeholder="Le contenu" v-model="experience.body"></Textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Date Debut</label>
                                <input type="date" class="form-control" placeholder="debut" v-model="experience.debut">
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label>Date Fin</label>
                                   <input type="date" class="form-control" placeholder="fin" v-model="experience.fin">
                                </div>
                            </div>
                        </div>


                        <button v-if="edit" class="button btn btn-danger btn-block" @click="updateExperience(experience)" >Modifier</button>
                        <button v-else class="button btn btn-info btn-block" @click="addExperience" >Ajouter</button>

                    </div>

					<ul class="list-group">
						<li class="list-group-item" v-for="experience in experiences">
							<div class="pull-right">

								<button class="btn btn-warning btn-sm" @click="editExperience(experience)">Editer</button>
                                <button class="btn btn-danger btn-sm" @click="deleteExperience(experience)">Delete</button>


							</div>

							<h3> @{{ experience.titre }} </h3>
							<p>@{{ experience.body }}</p>
							<small>@{{experience.debut}} - @{{experience.fin}}</small>

						</li>

					</ul>

				</div>
			</div>






		</div>
	</div>
</div>

@endsection


@section('javascripts')
 <script>
        window.Laravel = {!! json_encode([
            'csrfToken'    => csrf_token(),
            'idExperience' => $id,
            'url'          => url('/')
        ]) !!};
    </script>

<script src="{{ asset('js/script.js') }}"></script>
@endsection
@extends('layouts.app', ['title' => 'Login'])

@section('content')

     <main id= "conteudos" tabindex="0" class="container-xl main-height px-2 px-xl-0 py-5 d-flex flex-column justify-content-center align-items-center">
        <section class="login-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">


                        <form action="/forgot-password" method="POST" class="modal fade" id="modalPasswordRecover"
                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            {{ csrf_field() }}
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title w-100 font-weight-bold">Recupera a tua
                                            palavra-passe</h4>
                                        <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    </div>
                                    <div class="modal-body mx-3">
                                        <div class="md-form mb-4">
                                            <label type="text" for="form2">
                                                Insere aqui o teu email
                                            </label>
                                            <label class="text-danger">*</label>

                                            <input type="email" name="email" id="form2" class="form-control validate"
                                                placeholder="Email" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer d-flex justify-content-end">
                                        <input type="submit" class="btn btn-success" name="recover" value="Recuperar" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

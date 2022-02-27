@extends('layouts.app', ['title' => 'Login'])

@section('content')

    <main id= "conteudos" tabindex="0" class="container-xl main-height px-2 px-xl-0 py-5 d-flex flex-column justify-content-center align-items-center">
        <section class="login-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{ route('login') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="pb-2 m-b-30">Iniciar Sessão</h3>
                                        </div>
                                    </div>
                                    @if ($errors->has('password') || $errors->has('email'))
                                        <div class="alert alert-danger alert-dismissible">
                                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                            Credenciais incorretas! :(
                                        </div>
                                    @endif
                                    <div class="form-group form-primary">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                            placeholder="Email *" id="email" required autofocus>


                                        <div class="invalid-feedback">Falta preencher este campo.</div>
                                    </div>
                                    <div class="form-primary">
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Palavra-passe *" value="" id="password" required>

                                        <div class="invalid-feedback">Falta preencher este campo.</div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">

                                        <!-- ESQUECESTE-TE DA TUA PALAVRA PASSE  POP UP-->
                                        <p class="text-inverse signP linkSignP" data-toggle="modal"
                                            data-target="#modalPasswordRecover">
                                            Esqueceste-te da tua palavra passe?
                                        </p>
                                    </div>
                                    <div class="row">
                                        <div class="w-100">
                                            <input type="submit" onclick="console.log('teste')"
                                                class="btn btn-success w-100" name="submit" value="Entrar" />
                                        </div>
                                    </div>
                                    <br />
                                    <p class="text-inverse text-center signP">
                                        Ainda não tens uma conta?
                                        <a href="{{ route('register') }}" class="linkSignP">Regista-te aqui</a>
                                    </p>
                                </div>
                            </div>
                        </form>

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

@extends('layouts.app', ['title' => 'Register'])

@section('content')

    <main class="container-xl main-height px-2 px-xl-0 py-5 d-flex flex-column justify-content-center align-items-center">
        <section class="login-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{ route('register') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="pb-2 m-b-30">Regista-te</h3>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if ($errors->has('first_name') || $errors->has('last_name'))
                                            <div class="alert alert-danger alert-dismissible">
                                                <input type="button" class="btn-close" data-dismiss="alert"
                                                    aria-label="Close">
                                                Erro no nome...
                                            </div>
                                        @endif
                                        <div class=" col form-group form-primary">
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name') }}" placeholder="Nome" id="first_name"
                                                required>
                                            <div class="invalid-feedback">Falta preencher este campo.</div>
                                        </div>
                                        <div class="col form-group form-primary">
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ old('last_name') }}" placeholder="Apelido" id="last_name"
                                                required>
                                            <div class="invalid-feedback">Falta preencher este campo.</div>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger alert-dismissible">
                                                <input type="button" class="btn-close" data-dismiss="alert"
                                                    aria-label="Close">
                                                O e-mail está incorreto ou já foi registado!
                                            </div>
                                        @endif

                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                            placeholder="E-mail" id="email" required>
                                        <div class="invalid-feedback">Falta preencher este campo.</div>
                                    </div>
                                    <div class="row">
                                        @if ($errors->has('password'))
                                            <div class="alert alert-danger alert-dismissible">
                                                <input type="button" class="btn-close" data-dismiss="alert"
                                                    aria-label="Close">
                                                As palavras-passe não coincidem... :(
                                            </div>
                                        @endif
                                        <div class="col form-group form-primary">
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Palavra-passe" value="" id="password" required>
                                            <div class="invalid-feedback">Falta preencher este campo.</div>
                                        </div>
                                        <div class="col form-group form-primary">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="Confirmar Palavra-passe" value="" id="password_confirm"
                                                required>
                                            <div class="invalid-feedback">Falta preencher este campo.</div>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="">Pretendo subscrever à
                                            Newsletter
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="" required>Aceito a
                                            política de privacidade
                                            <div class="invalid-feedback">Falta preencher este campo.</div>
                                        </label>
                                    </div>

                                    <div class="row">
                                        <div class="mt-4 text-center">
                                            <input type="submit" class="btn btn-success w-100" name="submit"
                                                value="Registar" />
                                        </div>
                                    </div>
                                    <br />
                                    <p class="text-inverse text-center signP">
                                        Já tens uma conta?
                                        <a href="{{ route('login') }}" class="linkSignP">Login</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

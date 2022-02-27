@extends('layouts.app', ['title' => 'Event'])

@section('content')

    <main id="conteudos" tabindex="0"
        class="container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        <script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 2000);

        </script>

        @if (@isset($_GET['CreateEvent']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Evento criado! :D
            </div>
        @endif

        @if (@isset($_GET['UpdateEvent']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Evento atualizado! :D
            </div>
        @endif
        @if (@isset($_GET['CreateOrder']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Evento comprado com sucesso! :D
            </div>
        @endif

        <a href="/events" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Voltar</a>

        <div id="event-page">
            <section class="event-section">
                <div class="row">
                    <!-- col-sm-6 col-lg-3 col-md-6 col-xs-12 -->
                    <div class="eventImg col-lg-6 col-md-6 col-xs-12">
                        <img src="{{ url('storage/images/' . $event->image_path) }}" alt="{{ $event->image_path }}">
                    </div>
                    <section class="eventInformation col-lg-6 col-md-6 col-xs-12">
                        <h2>{{ $event->name }}</h2>

                        <div class="d-flex flex-row justify-content-start align-items-center gap-2 mb-2">
                            <span
                                class="m-0 fs-8 fw-bold text-secondary">{{ $event->start_date->locale('pt')->timezone('Europe/Lisbon')->isoFormat('D MMMM, YYYY | H:mm') }}</span>

                        </div>

                        <div class="d-flex  flex-row  justify-content-start align-items-center">
                            <p class="m-0 fw-bold">{{ $event->district . ', ' . $event->county }}</p>
                        </div>



                        <p class="mt-2 fs-3 fw-bold">{{ $event->price }}€</p>

                        <p id="event-description">
                            {{ $event->description }}
                        </p>


                        <button type="button" class="btn btn-secondary mt-3" data-toggle="modal"
                            data-target="#buyTicket">Comprar bilhetes</button>


                        <!-- Modal -->
                        <div class="modal fade" id="buyTicket" tabindex="-1" role="dialog" aria-labelledby="buyTicketLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="d-flex flex-column justify-content-start align-items-start">
                                            <h5 class="modal-title" id="buyTicketLabel">{{ $event->name }}</h5>
                                            <p class="m-0 fs-8 fw-bold text-secondary">
                                                {{ $event->start_date->locale('pt')->timezone('Europe/Lisbon')->isoFormat('D MMMM, YYYY | H:mm') }}
                                            </p>
                                        </div>

                                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                                            aria-label="Close">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body row">
                                        <div class="col">
                                            <p class="m-0 fw-bold">Nº Bilhetes<br>{{ $event->price }}€ p/pessoa</p>
                                        </div>
                                        <form id="buyTicketForm" method="post" class="col"
                                            action="{{ '/order/' . $event->event_id }}">
                                            {{ csrf_field() }}

                                            <div class="form-group mb-3 " id="ticketNumber">

                                                <div class="d-flex flex-row justify-content-end align-items-center gap-3">
                                                    <input type="number" id="numberTickets" name="numberTickets" step="1"
                                                        required value="1">
                                                    <input type="submit" class="btn btn-primary" value="Comprar" />

                                                </div>

                                            </div>


                                        </form>

                                    </div>
                                    <div class="modal-footer w-100 d-flex justify-content-between align-items-center">
                                        <<<<<<< HEAD=======>>>>>>> 3552add07d7b00a2c9698a6e99396faee8bb4acc
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
            <section id="products" class="w-75">


                <h3 class="col align-self-center">Como comprar bilhetes:</h3>
                <p>
                    - Seleciona a opção "Comprar bilhetes" (é necessário estar registado);<br>
                    - Escolhe o número de bilhetes que queres comprar; <br>
                    - Seleciona a opção "Comprar";<br>
                    - Posteriormente receberá um email com os bilhetes para o evento/experiência.<br>
                </p>


            </section>
        </div>





    </main>

@endsection

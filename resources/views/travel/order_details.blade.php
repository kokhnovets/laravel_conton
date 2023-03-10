@extends('layouts.base')
@section('title', $order->appellation)

@section('main')
    <div class="order-details">
        <div class="container pt-5 pb-3">
            <div class="order-details__body mb-3">
                <div class="p-3">
                    @if(count($order->images) == 1)
                        @foreach($order->images as $image)
                            <div class="mb-3 mx-auto mw-100 order-details__image">
                                <img src="{{ Storage::url($image->url) }}" class="d-block w-50 mx-auto" alt="{{$image->title}}">
                            </div>
                        @endforeach
                    @else
                        <div id="carouselExampleInterval" class="carousel mb-3 mx-auto mw-100 slide carousel-dark order-details__image" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($order->images as $indexImage => $image)
                                    @if($indexImage == 0)
                                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $indexImage }}" class="active" aria-current="true"></button>
                                    @else
                                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $indexImage }}"></button>
                                    @endif
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach($order->images as $indexImage => $image)
                                    @if($indexImage == 0)
                                        <div class="carousel-item active" data-bs-interval="10000">
                                            <img src="{{ Storage::url($image->url) }}" class="d-block w-50 mx-auto" alt="{{$image->title}}">
                                        </div>
                                    @else
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ Storage::url($image->url) }}" class="d-block w-50 mx-auto" alt="{{$image->title}}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                <span class="carousel-control-next-icon text-black-50" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @endif
                    <div class="order-details__information">
                        <div class="d-inline-flex pe-2 align-items-center">
                            <img class="order__photo_profile_path" src="{{ $order->user->photo_profile_path ? Storage::url($order->user->photo_profile_path) : URL::asset('images/lk/user.png') }}"  alt="{{ $order->user->first_name }} {{ $order->user->last_name }}">
                            <p class="" style="margin-bottom: 0;">{{ $order->user->first_name }} {{ $order->user->last_name }} ??????????????????(??) ?????????? {{ $order->dateAsCarbon->diffForHumans() }}.</p>
                        </div>
                        <h3 class="h3 mb-3 fw-bold">{{ $order->appellation }}</h3>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">????????????????????</p>
                            <p class="fs-6">{{ $order->count }}</p>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">?????? ????????????????????</p>
                            <a class="text-decoration-none fs-6 mb-0" href="{{ $order->product_link }}" target="_blank">{{ explode('/', $order->product_link)[2] }}</a>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">?????????????????? ????</p>
                            <p class="fs-6">{{ $order->delivery_from }}</p>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">?????????????????? ????????</p>
                            <p class="fs-6">{{ $order->where_to_deliver }}</p>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">?????????????????? ????</p>
                            <p class="fs-6">{{ Jenssegers\Date\Date::parse($order->deliver_to)->format('j F Y ??.') }}</p>
                        </div>
                        @if($order['description'])
                            <div class="mb-2">
                                <p class="fs-6 fw-bold">???????????????????? ?? ????????????:</p>
                                <p class="fs-6 w-100 text-break">{{ $order->description }}</p>
                            </div>
                        @endif
                        @if($order['wishes'])
                            <div class="mb-2">
                                <p class="fs-6 fw-bold">?????????????????? ???? ????????????????????:</p>
                                <p class="fs-6 w-100 text-break">{{ $order->wishes }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="border-top border-3">
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">?????????????????? ????????????</p>
                            <p class="fs-6">{{ number_format($order->price, 2, '.', ' ') }} ??????.</p>
                        </div>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">????????????????????????????</p>
                            <p class="fs-4 fw-bold">{{ number_format($order->award, 2, '.', ' ') }} ??????.</p>
                        </div>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">??????????</p>
                            <p class="fs-4 fw-bold">{{ number_format(($order->price * $order->count) + $order->award, 2, '.', ' ') }} ??????.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="orders_offer-for-delivery p-3">
                <div class="order-details__body">
                    @if(\App\Models\OfferForDelivery::where('user_id', auth()->id())->where('order_id', $order->id)->exists())
                        <div class="user-offer">
                            <p class="text-center fs-6 m-0 pb-2">???? ???????????????????? {{ number_format(\App\Models\OfferForDelivery::where('user_id', auth()->id())->where('order_id', $order->id)->value('offer'), 2, '.', ' ') }} ??????. ???? ????????????????.</p>
                            <a href="" class="fs-6 d-block text-decoration-none text-center update-offer">???????????????? ??????????????????????</a>
                        </div>
                        <form method="POST" class="update-offer-form" novalidate>
                            @csrf
                            @method('PATCH')
                            <div class="form-floating mb-3">
                            <textarea maxlength="400" class="form-control message offer_message"
                                      name="message" id="message" rows="5" style="resize: none; min-height: 100px;"
                                      placeholder="?????????????????? ???????????????????? (??????????????????????????)">{{ \App\Models\OfferForDelivery::where('user_id', auth()->id())->where('order_id', $order->id)->value('message') }}</textarea>
                                <label for="message">?????????????????? ???????????????????? (??????????????????????????)</label>
                                <span class="invalid-feedback message_error">
                                <strong></strong>
                            </span>
                                <p class="fs-6 offer_with_message">???????????????? ?????????????????? ????????????, ?? 400 ????????????????.</p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" value="{{ \App\Models\OfferForDelivery::where('user_id', auth()->id())->where('order_id', $order->id)->value('offer') }}" data-mask="currency" name="offer" class="form-control offer" id="offer" placeholder="??????????????, ?????????? ???????????????????????????? ???????????? ???????????????? ???? ????????????????">
                                <label for="offer">??????????????, ?????????? ???????????????????????????? ???????????? ???????????????? ???? ????????????????</label>
                                <span class="invalid-feedback offer_error">
                                <strong></strong>
                            </span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 btn-lg">???????????????? ??????????????????????</button>
                            </div>
                            <p class="w-80 text-center mx-auto terms_policy small">???????????????? ??????????, ?? ????????????????
                                <a href="{{ route('terms') }}" target="_blank">?????????????? ??????????????????????????</a>
                                ?? ??????????????, ?????? ?????? ?????????????????????? ?????????? ???????? ????????????????.
                            </p>
                        </form>
                        <script type="text/javascript">
                            // ???????????????????? ?????????????????? ???????????? ?????????? fetch ?? ?????????????????? ????????:
                            document.querySelector('.update-offer').addEventListener('click', e => {
                                e.preventDefault();
                                document.querySelector('.user-offer').style.display = 'none';
                                document.querySelector('.update-offer-form').style.display = 'block';
                            })

                            document.querySelector('.update-offer-form').addEventListener('submit', function(event) {
                                event.preventDefault();

                                const formData = new FormData(this);

                                fetch("{{ route('order.update.offer', $order->id) }}", {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.errors) {
                                            console.log(data.errors)
                                            Object.entries(data.errors).forEach(([key, value]) => {
                                                document.querySelector(`.${key}_error strong`).textContent = value;
                                                document.querySelector(`.${key}`).classList.add('is-invalid');
                                            });
                                        } else if (data.status) {
                                            location.reload();
                                        }
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            });
                        </script>
                    @else
                        <form method="POST" class="add-offer-form" novalidate>
                            @csrf
                            @method('POST')
                            <div class="form-floating mb-3">
                            <textarea maxlength="400" class="form-control message offer_message"
                                      name="message" id="message" rows="5" style="resize: none; min-height: 100px;"
                                      placeholder="?????????????????? ???????????????????? (??????????????????????????)"></textarea>
                                <label for="message">?????????????????? ???????????????????? (??????????????????????????)</label>
                                <span class="invalid-feedback message_error">
                                <strong></strong>
                            </span>
                                <p class="fs-6 offer_with_message">???????????????? ?????????????????? ????????????, ?? 400 ????????????????.</p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" data-mask="currency" name="offer" value="{{ $order->award }}" class="form-control offer" id="offer" placeholder="??????????????, ?????????? ???????????????????????????? ???????????? ???????????????? ???? ????????????????">
                                <label for="offer">??????????????, ?????????? ???????????????????????????? ???????????? ???????????????? ???? ????????????????</label>
                                <span class="invalid-feedback offer_error">
                                <strong></strong>
                            </span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 btn-lg">???????????????????? ??????????????????????</button>
                            </div>
                            <p class="w-80 text-center mx-auto terms_policy small">???????????????? ??????????, ?? ????????????????
                                <a href="{{ route('terms') }}" target="_blank">?????????????? ??????????????????????????</a>
                                ?? ??????????????, ?????? ?????? ?????????????????????? ?????????? ???????? ????????????????.
                            </p>
                        </form>
                        <script type="text/javascript">
                            // ???????????????????? ?????????????????? ???????????? ?????????? fetch ?? ?????????????????? ????????:
                            document.querySelector('.add-offer-form').addEventListener('submit', function(event) {
                                event.preventDefault();

                                const formData = new FormData(this);

                                fetch("{{ route('order.store.offer', $order->id) }}", {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.errors) {
                                            console.log(data.errors)
                                            Object.entries(data.errors).forEach(([key, value]) => {
                                                document.querySelector(`.${key}_error strong`).textContent = value;
                                                document.querySelector(`.${key}`).classList.add('is-invalid');
                                            });
                                        } else if (data.status) {
                                            location.reload();
                                        }
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

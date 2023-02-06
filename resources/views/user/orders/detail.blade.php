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
                        <h3 class="h3 mb-3 fw-bold">{{ $order->appellation }}</h3>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Количество</p>
                            <p class="fs-6">{{ $order->count }}</p>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Где приобрести</p>
                            <a class="text-decoration-none fs-6 mb-0" href="{{ $order->product_link }}" target="_blank">{{ explode('/', $order->product_link)[2] }}</a>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Доставить из</p>
                            <p class="fs-6">{{ $order->delivery_from }}</p>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Доставить куда</p>
                            <p class="fs-6">{{ $order->where_to_deliver }}</p>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Доставить до</p>
                            <p class="fs-6">{{ Jenssegers\Date\Date::parse($order->deliver_to)->format('j F Y г.') }}</p>
                        </div>
                        @if($order['description'])
                            <div class="mb-2">
                                <p class="fs-6 fw-bold">Информация о товаре:</p>
                                <p class="fs-6 w-100 text-break">{{ $order->description }}</p>
                            </div>
                        @endif
                        @if($order['wishes'])
                            <div class="mb-2">
                                <p class="fs-6 fw-bold">Ваши пожелания:</p>
                                <p class="fs-6 w-100 text-break">{{ $order->wishes }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="border-top border-3">
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Стоимость товара</p>
                            <p class="fs-6">{{ number_format($order->price, 2, '.', ' ') }} РУБ.</p>
                        </div>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Комиссия Conton</p>
                            <p class="fs-6">{{ number_format($order->commission, 2, '.', ' ') }} РУБ.</p>
                        </div>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Вознаграждение</p>
                            <p class="fs-4 fw-bold">{{ number_format($order->award, 2, '.', ' ') }} РУБ.</p>
                        </div>
                        <div class="d-flex mt-2 mb-2 justify-content-between">
                            <p class="fs-6 fw-bold">Итого</p>
                            <p class="fs-4 fw-bold">{{ number_format($order->total, 2, '.', ' ') }} РУБ.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="orders_offer p-3">
                <div class="order-details__body">
                    @if($order->order_status == 0)
                        @if(\App\Models\OfferForDelivery::where('order_id', $order->id)->get()->count())
                            <p class="text-center fs-4 pt-3 pb-3">Всего {{ count($order->offers) }} предложени{{ count($order->offers) == 1 ? 'e на ' . \App\Models\OfferForDelivery::where('order_id', $order->id)->get()->min('offer') . ' РУБ:' :
                                    (count($order->offers) >= 2 && count($order->offers) <= 4 ? 'я от ' . \App\Models\OfferForDelivery::where('order_id', $order->id)->get()->min('offer') . ' до ' . \App\Models\OfferForDelivery::where('order_id', $order->id)->get()->max('offer') . ' РУБ:' :
                                     (count($order->offers) > 5 ? 'ий от '  . \App\Models\OfferForDelivery::where('order_id', $order->id)->get()->min('offer') . ' до ' . \App\Models\OfferForDelivery::where('order_id', $order->id)->get()->max('offer') . ' РУБ:' : '')) }}</p>
                            @foreach($order->offers as $offer)
                                <div class="mb-3 p-3">
                                    @if($offer->message)
                                        <div class="d-inline-flex align-items-center">
                                            <img class="order__photo_profile_path object-fit-cover" src="{{ $offer->user->photo_profile_path ? Storage::url($offer->user->photo_profile_path) : URL::asset('images/lk/user.png') }}"  alt="{{ $offer->user->first_name }} {{ $offer->user->last_name }}">
                                            <p class="" style="margin-bottom: 0;">{{ $offer->user->first_name }} {{ $offer->user->last_name }} предложил <span class="fw-bold">{{ number_format($offer->offer, 2, '.', ' ') }} РУБ.</span> за доставку товара c сообщением:</p>
                                        </div>
                                        <div class="alert alert-secondary" role="alert">
                                            {{ $offer->message }}
                                        </div>
                                    @else
                                        <div class="d-inline-flex align-items-center">
                                            <img class="order__photo_profile_path object-fit-cover" src="{{ $offer->user->photo_profile_path ? Storage::url($offer->user->photo_profile_path) : URL::asset('images/lk/user.png') }}"  alt="{{ $offer->user->first_name }} {{ $offer->user->last_name }}">
                                            <p class="" style="margin-bottom: 0;">{{ $offer->user->first_name }} {{ $offer->user->last_name }} предложил <span class="fw-bold">{{ number_format($offer->offer, 2, '.', ' ') }} РУБ.</span> за доставку товара.</p>
                                        </div>
                                    @endif

                                    <form action="{{ route('user.delivery.store', $order->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="user_id" value="{{ $offer->user->id }}">
                                        <input type="hidden" name="offer" value="{{ $offer->offer }}">
                                        <button type="submit" class="btn btn-primary w-100">Принять предложение</button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center fs-6 pt-3 pb-3">Предложений пока что нет</p>
                        @endif
                        <div class="ps-3 pe-3 pb-1">
                            <button type="button" class="btn btn-danger w-100 btn-lg mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                Удалить заказ
                            </button>
                            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel1">Удалить заказ</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="delete-form" action="{{ route('user.orders.delete', $order->id) }}" novalidate method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <p class="w-80 fs-6 text-center text-muted mt-1">
                                                    Вы уверены?
                                                </p>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($order->order_status == 1)
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center mb-3">
                                <img class="order__photo_profile_path object-fit-cover" src="{{ $order->delivery->user->photo_profile_path ? Storage::url($order->delivery->user->photo_profile_path) : URL::asset('images/lk/user.png') }}"  alt="">
                                <p class="" style="margin-bottom: 0;">{{ $order->delivery->user->first_name }} {{ $order->delivery->user->last_name }} доставляет товар.</p>
                            </div>
                            @if($order->delivery->user->phone)
                                <div class="mb-3">
                                    Как связаться: {{ $order->delivery->user->phone }}
                                </div>
                            @endif
                            <p class="fs-4 fw-bold">Статус доставки:</p>
                            <ul class="statuses">
                                <li class="statuses__status">
                                    <div class="time">{{ Jenssegers\Date\Date::parse($order->delivery->created_at)->format('j F Y г., в H:i')}}</div>
                                    <p class="fs-6 sw-bold">Начало</p>
                                </li>
                                @foreach($order->statuses as $status)
                                    <li class="statuses__status">
                                        <div class="time">{{ Jenssegers\Date\Date::parse($status->created_at)->format('j F Y г., в H:i')}}</div>
                                        <p class="fs-6 sw-bold">{{ $status->status }}</p>
                                        @if($status->message)
                                            <p class="fs-6 status__message">{{ $status->message }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn btn-primary w-100 btn-lg mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                Подтвердить заказ
                            </button>
                            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel1">Подтверждение успешной доставки</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="delete-form" action="{{ route('user.delivery.susses', $order->id) }}" novalidate method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <p class="w-80 fs-6 text-center text-muted mt-1">
                                                    Нажимая на кнопку, вы подтверждаете, что заказ доставлен путешественником до вас.
                                                </p>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-success">Подтвердить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!$statuses)
                                <button type="button" class="btn btn-danger w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                    Отменить доставку
                                </button>
                                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Подтверждение отмены доставки.</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="delete-form" action="{{ route('user.delivery.destroy', $order->id) }}" method="POST" novalidate>
                                                    @csrf
                                                    @method('DELETE')
                                                    <p class="w-80 fs-6 text-center text-muted mt-1">
                                                        Нажимая на кнопку, вы подтверждаете, что доставка будет отменена.
                                                    </p>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                        <button type="submit" class="btn btn-danger">Подтвердить</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="p-3">
                            <p class="text-center fs-4">Заказ успешно доставлен.</p>
                            @if($order->delivery->user)
                                <div class="d-inline-flex align-items-center mb-3">
                                    <img class="order__photo_profile_path object-fit-cover" src="{{ $order->delivery->user->photo_profile_path ? Storage::url($order->delivery->user->photo_profile_path) : URL::asset('images/lk/user.png') }}"  alt="">
                                    <p class="" style="margin-bottom: 0;">{{ $order->delivery->user->first_name }} {{ $order->delivery->user->last_name }} доставил ваш товар.</p>
                                </div>
                            @else
                                <div class="d-inline-flex align-items-center mb-3">
                                    <img class="order__photo_profile_path object-fit-cover" src="{{ URL::asset('images/lk/user.png') }}"  alt="">
                                    <p class="" style="margin-bottom: 0;">Удаленный аккаунт</p>
                                </div>
                            @endif
                            <p class="fs-4 fw-bold">Статус заказа:</p>
                            <ul class="statuses">
                                <li class="statuses__status">
                                    <div class="time">{{ Jenssegers\Date\Date::parse($order->delivery->created_at)->format('j F Y г., в H:i')}}</div>
                                    <p class="fs-6 sw-bold">Начало</p>
                                </li>
                                @foreach($order->statuses as $status)
                                    <li class="statuses__status">
                                        <div class="time">{{ Jenssegers\Date\Date::parse($status->created_at)->format('j F Y г., в H:i')}}</div>
                                        <p class="fs-6 sw-bold">{{ $status->status }}</p>
                                        @if($status->message)
                                            <p class="fs-6">{{ $status->message }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

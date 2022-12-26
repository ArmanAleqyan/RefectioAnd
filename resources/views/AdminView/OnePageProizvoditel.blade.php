@extends('AdminView.layouts.default')
@section('title')
    Admin
@endsection

<style>
    input{
        color: white !important;
    }
    .swal2-container.swal2-center>.swal2-popup {
        background: #0f1116 !important;
        border: 1px solid #a5dc86 !important;
        width: 500px;
    }
    .swal2-styled.swal2-confirm{
        display: none !important;
        background-color: #a5dc86 !important;
        border: none !important;
    }
</style>



@section('content')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('succses'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Вы удачно изменили данные',
                showConfirmButton: false,
                timer: 5000,
            });
        </script>
    @endif
@if(session('ok'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Пользователь прошел модерацию',
                showConfirmButton: false,
                timer: 5000,
            });
        </script>
        @endif


    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">

                <div class="col-12 grid-margin stretch-card">

                    <div style="height: auto !important;" class="card">
                        <div class="card-body">
                            <div style="display: flex;
    justify-content: space-between;">
                                <h4 class="card-title">Модерация производителя</h4>
                                @if($get_proizvoditel[0]->active == 1)
                                <a style="    height: 35px;" href="{{route('newProizvoditel')}}" type="button" class="btn btn-outline-warning btn-icon-text">
                                    <i class="mdi mdi-reload btn-icon-prepend"></i> Назад </a>
                                @else
                                    <a style="    height: 35px;" href="{{route('AllProizvoditel')}}" type="button" class="btn btn-outline-warning btn-icon-text">
                                        <i class="mdi mdi-reload btn-icon-prepend"></i> Назад </a>
                                @endif
                            </div>
                            <br>
                            @foreach($get_proizvoditel as $item)
                            <div style="display: flex; justify-content: space-around;">
                                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                    <div class="card-header">Категории</div>
                                    <div class="card-body">
                                        @foreach($get_proizvoditel_category as $items)
                                        <li class="card-text">{{$items->category_name}}</li>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                    <div class="card-header">Процент вознаграждения дизайнера</div>
                                    <div class="card-body">
                                        @foreach($get_pracient_for_designer as $itema)
                                            <li class="card-text">От {{$itema->start_price}} До {{$itema->before_price}} Процент {{$itema->percent}}%</li>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                    <div class="card-header">Города (продажи продукции)</div>
                                    <div class="card-body">
                                        @foreach($get_city_sales as $itemd)
                                            <li class="card-text">{{$itemd->city_name}}</li>
                                        @endforeach
                                    </div>
                                </div>
                                </div>

                                <form action="{{route('UpdateOneProizvoditel')}}" method="post" class="forms-sample" enctype='multipart/form-data' >
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$item['id']}}">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Кол.мешков</label>
                                        <input value="{{$item['meshok']}}" name="meshok" type="text" class="form-control" id="exampleInputName1" placeholder="Кол.мешков" >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Компания</label>
                                        <input value="{{$item['company_name']}}" name="name" type="text" class="form-control" id="exampleInputName1" placeholder="Имя">
                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <label for="exampleInputEmail3">Фамилия</label>--}}
{{--                                        <input value="{{$item['surname']}}" name="surname" type="text" class="form-control" id="exampleInputEmail3" placeholder="Фамилия">--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Ном.телефона</label>
                                        <div>
{{--                                            <input style="max-width: 10%" value="{{$item['phone_code']}}" name="phone_code"  class="form-control" id="exampleInputEmail3" placeholder="Код.телефона" required>--}}
                                            <input  value="{{$item['phone']}}" name="phone"  class="form-control" id="exampleInputEmail3" placeholder="Ном.телефона" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">ИНН</label>
                                        <input value="{{$item['individual_number']}}" name="individual_number" type="text" class="form-control" id="exampleInputEmail3" placeholder="465498746513" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Номер ватсап</label>
                                        <input value="{{$item['watsap_phone']}}" name="watsap_phone" type="text" class="form-control" id="exampleInputEmail3" placeholder="78123154557" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Страна производства</label>
                                        <input value="{{$item['made_in']}}" name="made_in" type="text" class="form-control" id="exampleInputEmail3" placeholder="Russia" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Стоимость метра</label>
                                        <input value="{{$item['price_of_metr']}}" name="price_of_metr" type="text" class="form-control" id="exampleInputEmail3" placeholder="15" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Сайт с ассортиментом компании</label>
                                        <input value="{{$item['saite']}}" name="saite" type="text" class="form-control" id="exampleInputEmail3" placeholder="www.myMebel.ru" >
                                    </div>
                                    <br>
                                    <br>
                                    <div style="display: flex; justify-content: space-between;">
                                        <div>
                                            <img style="max-height: 100px; max-width: 152px; width: 100%;" src="http://80.78.246.59/Refectio/storage/app/uploads/{{$item['logo']}}" alt="image" id="blahas">
                                            <br>
                                            <input accept="image/*" style="display: none" name="logo" id="file-logos" class="btn btn-outline-success" type="file">
                                            <br>
                                            <label style="" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                                изменить логотип
                                            </label>
                                        </div>

                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                                        <script>
                                            $(document).ready(function () {
                                                $(".senddogovor").change(function (event) {

                                                    var path = jQuery(this).val();
                                                    var filename = path.replace(/C:\\fakepath\\/, '');
                                                    $('.rate_item_add_contacts_btn').css('display','none');
                                                    $('.myAddContact').css('display','block');
                                                    $('#MyDogovorspan').text(filename);
                                                    event.preventDefault();
                                                });
                                            });

                                        </script>
                                    </div>
                                    <div>
                                        <br>
                                        <br>
                                        @if($item->extract)
                                        <a download href="http://80.78.246.59/Refectio/storage/app/uploads/{{$item->extract}}" class="btn btn-outline-secondary btn-icon-text"> Скачать выписку <i class="mdi mdi-file-check btn-icon-append"></i>
                                        </a>
                                            @endif

                                    </div>
                                    <div>
                                        <span class="rate_item_info_detail2" style="  font-size: 26px; padding-bottom: 8px;" id="MyDogovorspan"></span>
                                        <input accept = "application/pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                               class="senddogovor" name="vipiska"  id="dogovor" type="file" style="display: none;" >
                                        <br>
                                        <label for="dogovor" class="btn btn-outline-danger btn-icon-text">
                                            <i class="mdi mdi-upload btn-icon-prepend"></i> Добавить выписку </label>
                                    </div>
                                    <br>
                                    <br>

                                    <br>
                                    <br>

                                    <div style="display: flex; justify-content: space-between;">
                                        <button type="submit" class="btn btn-inverse-success btn-fw">Сохранить</button>

                                        @if($item['phone_veryfi_code'] != 1)
                                            <p>Пользователь не прошел верификацию</p>
                                            @else
                                        @if($item['active'] == 1)
                                            <a href="{{route('activnewuser',  $item['id']) }}"  class="btn btn-inverse-success btn-fw">Активировать</a>
                                        @endif
                                        @endif
                                    </div>
                                </form>
                            @endforeach
                            @if(!$get_product->isEmpty())
                            <h1 style="display: flex; justify-content: center;">Продукты Пользователя</h1>
                            <br>
                            <br>

                            <div style="display: flex; flex-wrap: wrap; justify-content: space-evenly; align-items: center">

                            @foreach($get_product as $product)

                                <div class="card" style="width: 18rem;">
                                    <a href="{{route('OnePageProductUser',$product->id)}}" style="  border: 2px solid #665252;"><img src="http://80.78.246.59/Refectio/storage/app/uploads/{{$product->product_image_limit1[0]->image}}" class="card_image card-img-top" alt="..."></a>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$product->name}}</h5>
                                        <li class="card-text">Категория `     {{$product->category_name}}</li>
                                        <li class="card-text">Корпус `     {{$product->frame}}</li>
                                        <li class="card-text">Фасады `     {{$product->facades}}</li>
                                        <li class="card-text">Длина `     {{$product->length}}</li>
                                        <li class="card-text">Высота `     {{$product->height}}</li>
                                        @if($product->tabletop)
                                        <li class="card-text">Столешница `     {{$product->tabletop}}</li>
                                            @endif
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        @endif
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->

        <!-- partial -->
    </div>
@endsection
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

                    <div style="height: 3500px !important;" class="card">
                        <div class="card-body">
                            <div style="display: flex;
    justify-content: space-between;">
                                <h4 class="card-title">Брони</h4>
                                <a style="    height: 35px;" href="{{route('AllBrone')}}" type="button" class="btn btn-outline-warning btn-icon-text">
                                    <i class="mdi mdi-reload btn-icon-prepend"></i> Назад </a>
                            </div>
                            <br>
                            @foreach($get_book as $zakazchik)

                                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                    <h1 style="display: flex; justify-content: center">Заказчик</h1>
                                    <br>
                                    <div class="card-header"> ФИО `&nbsp;&nbsp;  {{$zakazchik->name}}</div>
                                    <div class="card-header">Номер телефона `&nbsp;&nbsp;{{$zakazchik->phone}}</div>
                                    @if($zakazchik->dubl_name)
                                    <div class="card-header">Доп. ФИО `&nbsp;&nbsp;  {{$zakazchik->dubl_name}}</div>
                                    @endif
                                    @if($zakazchik->dubl_phone)
                                    <div class="card-header">Доп. номер телефона  `&nbsp;&nbsp;  {{$zakazchik->dubl_phone}}</div>
                                     @endif
                                    <div class="card-body">
                                    </div>
                                </div>
                            @endforeach
                            <br>
                            @foreach($get_book as $item)
                                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                        <h1 style="display: flex; justify-content: center">Детали брони</h1>
                                        <br>
                                        <div class="card-header">Дизайнер `&nbsp;&nbsp;  {{$item->book_designer->name}}&nbsp;&nbsp; {{$item->book_designer->surname}}</div>
                                        <div class="card-header"> Номер телефона дизайнера `&nbsp;&nbsp;  {{$item->book_designer->phone_code}}&nbsp;&nbsp; {{$item->book_designer->phone}}</div>
                                        <div class="card-header">Категория `&nbsp;&nbsp;  {{$item->category_name}}</div>
                                        <div class="card-header">Город `&nbsp;&nbsp;  {{$item->city}}</div>
                                        <div class="card-body">
                                        </div>
                                    </div>
                            @endforeach



                                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                    <h1 style="display: flex; justify-content: center">Производители</h1>
                                    <br>
                                    @foreach($get_brone as $proizvoditel)

                                    <div class="card-header">Производитель `&nbsp;&nbsp;  {{$proizvoditel->book_proizvoditel_user->company_name}}</div>
                                    <div class="card-header"> Номер телефона Производителя `&nbsp;&nbsp;  {{$proizvoditel->book_proizvoditel_user->phone_code}}{{$proizvoditel->book_proizvoditel_user->phone}}</div>
                                    <div class="card-header">Предлагаемая цена `&nbsp;&nbsp;  {{$proizvoditel->price}}</div>

                                            <?php $asd =  App\Models\user_pracient_for_designer::where('user_id',$proizvoditel->book_proizvoditel_user->id)->where('start_price', '<=',  $proizvoditel->price)->where('before_price', '>=' , $proizvoditel->price)->get('percent') ?>



                                   @if(!$asd->isEmpty())
                                            @foreach($asd as $pracent)
                                            <div class="card-header">Проценты для дизайнера `&nbsp;&nbsp;{{$pracent->percent}}&nbsp;%
                                            @endforeach
                                       @else
                                                    <div class="card-header">Проценты для дизайнера `&nbsp; 11 %
                                       @endif
                                                        <hr align="center" width="100%" size="2" color="#ff0000" />
                                        </div>
                                            <br>


                                    @endforeach
                                </div>


                        </div>



                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->

        <!-- partial -->
    </div>
@endsection
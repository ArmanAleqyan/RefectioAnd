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
    @if(session('deleted'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Изображение удалено',
                showConfirmButton: false,
                timer: 5000,
            });
        </script>
    @endif


    <div class="main-panel">
        <div class="content-wrapper">
            @foreach($get_product as $item)
            <div class="row">

                <div class="col-12 grid-margin stretch-card">

                    <div style="height: 3500px !important;" class="card">
                        <div class="card-body">
                            <div style="display: flex;  justify-content: space-between;">
                                <h4 class="card-title">Модерация продукта</h4>
                                <h4 style="color: #68ffff;">Владелец продукта` {{$item->user_product->company_name}}</h4>
                                <a style="    height: 35px;" href="{{route('onepageDesigner',$item->user_product->id)}}" type="button" class="btn btn-outline-warning btn-icon-text">
                                    <i class="mdi mdi-reload btn-icon-prepend"></i> Назад </a>
                            </div>
                            <br>


                                <form action="{{route('UpdateOneUserProduct')}}" method="post" class="forms-sample" enctype='multipart/form-data' >
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$item['id']}}">
                                    @if($item['name'])
                                    <div class="form-group">
                                        <label for="exampleInputName1">Имя продукции</label>
                                        <input value="{{$item['name']}}" name="name" type="text" class="form-control" id="exampleInputName1" placeholder="Имя продукции" required>
                                    </div>
                                    @endif
                                    @if($item['category_name'])
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Категория</label>
                                        <input value="{{$item['category_name']}}" name="category_name" type="text" class="form-control" id="exampleInputEmail3" placeholder="Категория" required>
                                    </div>
                                    @endif
                                    @if($item['frame'])
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Корпус</label>
                                        <input value="{{$item['frame']}}" name="frame" type="text" class="form-control" id="exampleInputEmail3" placeholder="Корпус" required>
                                    </div>
                                    @endif
                                    @if($item['facades'])
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Фасады</label>
                                        <input value="{{$item['facades']}}" name="facades" type="text" class="form-control" id="exampleInputEmail3" placeholder="Фасады" required>
                                    </div>
                                    @endif
                                    @if($item['length'])
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Длина</label>
                                        <input value="{{$item['length']}}" name="length" type="text" class="form-control" id="exampleInputEmail3" placeholder="Длина" required>
                                    </div>
                                    @endif
                                    @if($item['height'])
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Ширина</label>
                                        <input value="{{$item['height']}}" name="height" type="text" class="form-control" id="exampleInputEmail3" placeholder="Ширина" required>
                                    </div>
                                    @endif
                                    @if($item['tabletop'])
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Столешница</label>
                                        <input value="{{$item['tabletop']}}" name="tabletop" type="text" class="form-control" id="exampleInputEmail3" placeholder="Столешница" required>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Цена</label>
                                        <input value="{{$item['price']}}" name="price" type="text" class="form-control" id="exampleInputEmail3" placeholder="Цена" required>
                                    </div>
                                    <br>
                                    <br>

                                    <div style="display: flex; justify-content: space-between;">
                                        <button type="submit" class="btn btn-inverse-success btn-fw">Сохранить</button>
                                    </div>
                                </form>


                            <br>
                            <br>
                            <div style="display: flex; flex-wrap: wrap; justify-content: space-evenly; align-items: center">


                            @foreach($item->product_image as $image)

                                @if($item->product_image->count() == 1)

                                        <form action="{{route('UpdateOneUserProduct')}}" method="post" enctype='multipart/form-data'>
                                            @csrf
                                            <input type="hidden" name="image_id" value="{{$image->id}}">
                                            <div class="card" style="width: 18rem;">
                                                <img src="http://80.78.246.59/Refectio/storage/app/uploads/{{$image->image}}" class="card-img-top" alt="..."    id="blahas">
                                                <div class="card-body">
                                                    <input accept="image/*" style="display: none" name="logo" id="file-logos" class="chanje btn btn-outline-success" type="file">
                                                </div>
                                                <label style="" for="file-logos"  class="custom-file-upload btn btn-outline-success">
                                                    Изменить изображение
                                                </label>
                                                <button type="submit" style="display: none;" class="opensave btn btn-inverse-success btn-fw">Сохранить</button>
                                            </div>
                                        </form>

                                    @else
                                        <div class="card" style="width: 18rem;">
                                            <img src="http://80.78.246.59/Refectio/storage/app/uploads/{{$image->image}}" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <button style="width: 100%;" type="button" class="deletbutton btn btn-inverse-danger btn-fw" data-id="{{$image->id}}" data-toggle="modal" data-target="#exampleModal">
                                                    Удалить
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Button trigger modal -->


                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Подтвердить удаление</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img  class="modalimg card-img-top" alt="...">
                                                    </div>
                                                    <div class="modal-footer">
                                                                        <a style="display: flex;
                    justify-content: center;" class="atag btn btn-inverse-danger btn-fw">Удалить</a>
                                                        <button type="button" class="btn btn-inverse-light btn-fw" data-dismiss="modal">Закрыть</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif






                            @endforeach
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->

        <!-- partial -->
    </div>
@endsection


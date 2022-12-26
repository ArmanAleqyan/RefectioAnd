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

    }
    /*.swal2-styled.swal2-confirm{*/
    /*    background-color: #a5dc86 !important;*/
    /*    border: none !important;*/
    /*}*/
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

                    <div style="height: 700px !important;" class="card">
                        <div class="card-body">
                            <div style="display: flex;
    justify-content: space-between;">
                            <h4 class="card-title">Модерация дизайнера</h4>
                                @if($get_designer[0]->active == 1)
                                <a style="    height: 35px;" href="{{route('newDesigner')}}" type="button" class="btn btn-outline-warning btn-icon-text">
                                    <i class="mdi mdi-reload btn-icon-prepend"></i> Назад </a>
                                @else
                                    <a style="    height: 35px;" href="{{route('AllDesigner')}}" type="button" class="btn btn-outline-warning btn-icon-text">
                                        <i class="mdi mdi-reload btn-icon-prepend"></i> Назад </a>
                                @endif
                            </div>
                            <br>
                            @foreach($get_designer as $item)
                            <form action="{{route('updateUserColumn')}}" method="post" class="forms-sample" enctype='multipart/form-data' >
                                @csrf
                                <input type="hidden" name="user_id" value="{{$item['id']}}">
                                <div class="form-group">
                                    <label for="exampleInputName1">Имя</label>
                                    <input value="{{$item['name']}}" name="name" type="text" class="form-control" id="exampleInputName1" placeholder="Имя" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Фамилия</label>
                                    <input value="{{$item['surname']}}" name="surname" type="text" class="form-control" id="exampleInputEmail3" placeholder="Фамилия" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3"> Ном.телефона</label>
                                    <div >
{{--                                    <input style="max-width: 10%" value="{{$item['phone_code']}}" name="phone_code"  class="form-control" id="exampleInputEmail3" placeholder="Код.телефона" required>--}}
                                    <input  value="{{$item['phone']}}" name="phone"  class="form-control" id="exampleInputEmail3" placeholder="Ном.телефона" required>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div style="display: flex; justify-content: space-around;">
                                <div>

                                    <img data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer; max-height: 100px; max-width: 142px; width: 100%;" src="http://80.78.246.59/Refectio/storage/app/uploads/{{$item['selfi_photo']}}" alt="image" id="blahas">

                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img  style="cursor: pointer;width: 100%;" src="http://80.78.246.59/Refectio/storage/app/uploads/{{$item['selfi_photo']}}" alt="image" id="blahas">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <input accept="image/*" style="display: none" name="selfi_photo" id="file-logos" class="btn btn-outline-success" type="file">
                                    <br>
                                    <label style="" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                        изменить селфи
                                    </label>
                                </div>
                                    <div>

                                        <img data-toggle="modal" data-target="#exampleModalCenter2"  style="max-height: 100px; max-width: 142px; width: 100%; cursor: pointer" src="http://80.78.246.59/Refectio/storage/app/uploads/{{$item['diplom_photo']}}" alt="image" id="blaha">

                                        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img  style=" width: 100%; cursor: pointer" src="http://80.78.246.59/Refectio/storage/app/uploads/{{$item['diplom_photo']}}" alt="image" id="blaha">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <input accept="image/*" style="display: none" name="diplom_photo" id="file-logo" class="btn btn-outline-success" type="file">
                                        <br>
                                        <label style="" for="file-logo" class="custom-file-upload btn btn-outline-success">
                                            изменит  диплом
                                        </label>
                                    </div>
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
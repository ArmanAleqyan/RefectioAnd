@extends('AdminView.layouts.default')
@section('title')
    Admin
@endsection

<style>
    input{
        color: white !important;
    }

</style>

@section('content')

    <div class="content-wrapper">

        <br>
        <br>


        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 style="color:  #2f5687 !important;" class="card-title">Дизайнеры на модерации</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th> Имя</th>
                                    <th> Фамилия  </th>
                                    <th> Ном.телефона</th>
                                    <th> Роль</th>
                                </tr>
                                </thead>
                                @foreach($get_designer as $item)
                                <tbody>
                                <tr>
                                    <td>
                                     {{$item['name']}}
                                    </td>
                                    <td> {{$item['surname']}} </td>
                                    <td> {{$item['phone_code'].$item['phone']}} </td>
                                    <td> Дизайнер  </td>
                                    <td style="  display: flex;  justify-content: end;">
                                        <a type="button" class="btn btn-inverse-success btn-fw" href="{{route('onepageuser',$item['id'])}}">Просмотреть</a>

                                    </td>
                                </tr>

                                </tbody>
                                    @endforeach


                            </table>
                        </div>
                        <div style="    DISPLAY: flex;
    JUSTIFY-CONTENT: center;">
                            {{$get_designer->links()}}
                        </div>

                        <style>

                            .page-item{
                                padding: 7px;
                            }
                            .page-link{
                                color: #ffffff;
                            }
                            .page-item.active .page-link{
                                z-index: 3;
                                color: #000;
                                background-color: #ffffff;
                                border-color: #007bff;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
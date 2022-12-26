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
                        <h4 style="color:  #2f5687 !important;" class="card-title">Брони</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th> ФИО дизайнера   </th>
                                    <th>Город</th>
                                    <th>Категория</th>
                                    <th> Ном.заказчика</th>

                                </tr>
                                </thead>
                                @foreach($books as $item)
                                    <tbody>
                                    <tr>
                                        <td>
                                            {{$item['designer_name']}} &nbsp;&nbsp;{{$item['designer_surname']}}
                                        </td>
                                        <td>{{$item['city']}}</td>
                                        <td>{{$item['category_name']}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td style="  display: flex;  justify-content: end;">
                                            <a type="button" class="btn btn-inverse-success btn-fw" href="{{route('OnePageBrone',$item['id'])}}">Просмотреть</a>

                                        </td>
                                    </tr>

                                    </tbody>
                                @endforeach
                            </table>
                            <div style="    DISPLAY: flex;
    JUSTIFY-CONTENT: center;">
                            {{$books->links()}}
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

    </div>
@endsection
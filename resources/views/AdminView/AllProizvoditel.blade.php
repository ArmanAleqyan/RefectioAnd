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
                    <div  class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="color:  #2f5687 !important;" class="card-title">Производители </h4>
                            <div style="width: 53%">
                            <form action="{{route('searchProizvoditel')}}" method="post">
                                @csrf
                            <div class="input-group" >

                                <input required name="searchProizvodtel"  type="text" class="form-control" placeholder="Поиск производителей" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-inverse-primary btn-fw">Поиск</button>
                                </div>

                            </div>
                            </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th> Название</th>
                                    <th> Ном.телефона</th>
                                    <th> Страна производства</th>
                                    <th>Роль</th>
                                </tr>
                                </thead>
                                @foreach($get_Proizvoditel as $item)
                                    <tbody>
                                    <tr>
                                        <td>
                                            {{$item['company_name']}}
                                        </td>

                                        <td> {{$item['phone_code'].$item['phone']}} </td>
                                        <td> {{$item['made_in']}} </td>
                                        <td> Производитель  </td>
                                        <td style="  display: flex;  justify-content: end;">
                                            <a type="button" class="btn btn-inverse-success btn-fw" href="{{route('onepageDesigner',$item['id'])}}">Просмотреть</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                @endforeach


                            </table>
                        </div>
                        <div style="    DISPLAY: flex;
    JUSTIFY-CONTENT: center;">
                            {{$get_Proizvoditel->links()}}
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
@extends('Common::admin.layout.page')
@section('page')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            {{-- <th>البريد الإلكترونى </th> --}}
                            <th>رقم الجوال</th>
                            <th>تاريخ التسجيل</th>
                            <th class="actions_td">عرض</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->username }}</td>
                            {{-- <td>{{ $row->email }}</td> --}}
                            <td>{{ $row->mobile }}</td>
                            <th>{{ $row->created_at }}</th>
                            <td class="actions_td">
                                <a class="btn btn-primary mlink" href="{{ route("admin.guests.show" , $row->id) }}"><i
                                        class="fa fa-eye"></i> <span>طلباتى</span></a>
                                <form action="{{ route("admin.guests.destroy" , $row->id) }}" method="post"
                                    class="action_form remove">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-danger removethis"><i class="fa fa-trash"></i>
                                        <span>حذف</span></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $rows->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@stop

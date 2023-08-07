@extends('admin.home')
@section('page_title','Products Management')

@section('main_headeing','Products')
@section('sub_headeing','Product List')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        @can('product-create')
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('products.create') }}"><i class="fa fa-plus"></i> Create New Product </a>
        @endcan
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-lg-12 col-12">

            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->detail }}</td>
                        <td>
                            <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                <a href="{{ route('products.show',$product->id) }}" title="View" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('product-edit')
                                <a href="{{ route('products.edit',$product->id) }}" title="Edit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @csrf
                                @method('DELETE')
                                @can('product-delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $products->links() !!}
        </div>
    </div>
</div>

@endsection
@extends('layouts.master')
@section('title')
قائمـة الفواتيــر

@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
 <!--Internal   Notify -->
 <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفـواتيـر</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمـة الفواتيـر</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">

						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')



@if (session()->has('delete_invoice'))
<script>
    window.onload = function() {
        notif({
            msg: "تم حذف الفاتورة بنجاح",
            type: "success"
        })
    }

</script>
@endif

@if (session()->has('Status_Update'))
<script>
    window.onload = function() {
        notif({
            msg: "تم تحديث حالة الدفع بنجاح",
            type: "success"
        })
    }

</script>
@endif

@if (session()->has('restore_invoice'))
<script>
    window.onload = function() {
        notif({
            msg: "تم استعادة الفاتورة بنجاح",
            type: "success"
        })
    }

</script>
@endif
				<!-- row -->
				<div class="row">


                        <!--div-->
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">


                                    @can('إضافة فاتوة')
                                        <a href="payment/create" class="model-effect btn btn-primary" style="color:white"><i
                                            class="fas fa-plus"></i>&nbsp; إضافة فاتوة</a>
                                            @endcan
                                            @can('تصدير EXCEL')
                                            <a class="modal-effect btn btn-primary" href="{{ url('export_payment') }}"
                                                style="color:white"><i class="fas fa-file-download"></i>&nbsp; تصدير EXCEL</a>
                                                @endcan

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">رقم الفـاتورة</th>
                                                    <th class="border-bottom-0">تـاريخ الفـاتورة</th>
                                                    <th class="border-bottom-0">تـاريخ الإستحـقاق</th>
                                                    <th class="border-bottom-0">المنتـج</th>
                                                    <th class="border-bottom-0">القســم</th>
                                                    <th class="border-bottom-0">الخصــم</th>
                                                    <th class="border-bottom-0">نسبــة الضربية</th>
                                                    <th class="border-bottom-0">قيمة الضربية</th>
                                                    <th class="border-bottom-0"> الإجمــالي</th>
                                                    <th class="border-bottom-0">الحـالـة</th>
                                                    <th class="border-bottom-0">مـلاحظــات</th>
                                                    <th class="border-bottom-0">العمليات</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=0;
                                                @endphp
                                                @foreach ($payment as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item->invoice_number }}</td>
                                                    <td>{{ $item->invoice_Date }}</td>
                                                    <td>{{ $item->Due_Date }}</td>
                                                    <td>{{ $item->product }}</td>
                                                    <td>
                                                        <a href="{{ url('InvoicesDetailes') }}/{{ $item->id }}">{{  $item->section->section_name }}</a>
                                                    </td>
                                                    <td>{{ $item->Discount }}</td>
                                                    <td>{{ $item->Rate_Vat }}</td>
                                                    <td>{{ $item->Value_Vat }}</td>
                                                    <td>{{ $item->total }}</td>
                                                    <td>
                                                        @if ($item->value_status==1)
                                                            <span class="text-success">{{ $item->status }}</span>
                                                        @elseif ($item->value_status==2)
                                                            <span class="text-danger">{{ $item->status }}</span>
                                                        @else
                                                            <span class="text-warning">{{ $item->status }}</span>

                                                        @endif

                                                    </td>

                                                    <td>{{ $item->note }} </td>

                                                    <td>
                                                        <div class="dropdown">
                                                            <button aria-expanded="false" aria-haspopup="true"
                                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                                type="button"> العمليات <i class="fas fa-caret-down ml-1"></i></button>
                                                            <div class="dropdown-menu tx-13">


                                                                @can('تعديل الفاتورة')
                                                                    <a class="dropdown-item"
                                                                        href=" {{ url('edit_invoice') }}/{{ $item->id }}"><i
                                                                        class="text-success fas fa-edit"></i>&nbsp;&nbsp;تعديل الفاتورة</a>
                                                                        @endcan
                                                                        @can('حذف الفاتورة')
                                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $item->id }}"
                                                                            data-toggle="modal" data-target="#delete_invoice"><i
                                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف الفاتورة</a>
                                                                                @endcan
                                                                                @can('تغير حالة الدفع')
                                                                            <a class="dropdown-item" href="{{ URL::route('Status_show', [$item->id]) }}" ><i
                                                                                    class="text-info fas fa-money-bill"></i>&nbsp;&nbsp;تغير حالة الدفع
                                                                                </a>
                                                                                @endcan
                                                                                @can('ارشفة الفاتورة')
                                                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $item->id }}"
                                                                                    data-toggle="modal" data-target="#archive_invoice"><i
                                                                                        class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;
                                                                                        أرشفة الفاتورة</a>
                                                                                        @endcan
                                                                                        @can('طباعةالفاتورة')
                                                                                    <a class="dropdown-item" href="Print_invoice/{{ $item->id }}"><i
                                                                                        class="text-secondary fas fa-print"></i>&nbsp;&nbsp;طباعةالفاتورة
                                                                                </a>
                                                                                @endcan

                                                                        </div>
                                                                    </div>


                                                    </td>
                                                </tr>
                                                @endforeach



                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->

    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="{{ route('payment.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
            </div>
            <div class="modal-body">
                هل انت متاكد من عملية الحذف ؟
                <input type="hidden" name="invoice_id" id="invoice_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="submit" class="btn btn-danger">تاكيد</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- ارشفة الفاتورة -->
<div class="modal fade" id="archive_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">أرشفة الفاتورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="{{ route('payment.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
            </div>
            <div class="modal-body">
                هل انت متاكد من عملية الأرشفة ؟
                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                <input type="hidden" name="id_page" id="id_page" value="2">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="submit" class="btn btn-danger">تاكيد</button>
            </div>
            </form>
        </div>
    </div>
</div>

                    </div>


				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
 <!--Internal  Notify js -->
 <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script>
    $('#delete_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })

</script>

<script>
    $('#archive_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })

</script>


@endsection
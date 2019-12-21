@extends('layouts.admin')
@section('content')
 <script>
     new Vue({
         el: '#vue-wrapper',
         data: {
             items: [],
             hasError: true,
             hasDeleted: true,
             hasAgeError: true,
             showModal: false,
             e_id: '',
             e_name: '',
             e_desc: '',
             newItem: { 'name': '','desc': ''}
         },
         mounted: function mounted() {
             this.getVueItems();
         },
         methods: {
             getVueItems: function getVueItems() {
                 var _this = this;
                 axios.get('/vueitems').then(function (response) {
                     _this.items = response.data;
                 });
             },
             setVal: function setVal(val_id, val_name, val_desc) {
                 this.e_id = val_id;
                 this.e_name = val_name;
                 this.e_desc = val_desc;
             },

             createItem: function createItem() {
                 var _this = this;
                 var input = this.newItem;

                 if (input['name'] == '' || input['desc'] == '' ) {
                     this.hasError = false;
                 } else {
                     this.hasError = true;
                     axios.post('/vueitems', input).then(function (response) {
                         _this.newItem = { 'name': '', 'desc': ''};
                         _this.getVueItems();
                     });
                     this.hasDeleted = true;
                 }
             },
             editItem: function editItem() {
                 var _this2 = this;

                 var i_val_1 = document.getElementById('e_id');
                 var n_val_1 = document.getElementById('e_name');
                 var a_val_1 = document.getElementById('e_desc');

                 axios.post('/editexpense/'  + i_val_1.value, { val_1: n_val_1.value, val_2: a_val_1.value }).then(function (response) {
                     _this2.getVueItems();
                     _this2.showModal = false;
                 });
                 this.hasDeleted = true;
             },
             deleteItem: function deleteItem(item) {
                 var _this = this;
                 axios.post('/vueitems/' + item.id).then(function (response) {
                     _this.getVueItems();
                     _this.hasError = true, _this.hasDeleted = false;
                 });
             },
             beforeCreate: function() {
                 console.log(this.$appName)
             }

         }
     })

 </script>

 <div id="app">
     <div class="content">
         <div class="flex-top position-ref full-height">
             <div id="vue-wrapper" class="">
                <div class="row row-title">
                    <div class="col-lg-6">
                        <span class="row-title-label">{{ trans('cruds.expenseCategory.title_singular') }}</span>
                    </div>
                    <div class="col-lg-6">
                        <div class="align-right">Expense Management > {{ Breadcrumbs::render('expense-category') }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ trans('cruds.expenseCategory.title_singular') }} {{ trans('global.list') }}
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class=" table table-bordered table-striped table-hover datatable datatable-ExpenseCategory">
                                        <thead>
                                            <tr>
                                                <th width="10">

                                                </th>
                                                <th>
                                                    {{ trans('cruds.expenseCategory.fields.id') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.expenseCategory.fields.expense_category_desc') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.expenseCategory.fields.expense_category_display') }}
                                                </th>
                                                <th>
                                                    &nbsp;
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenseCategories as $key => $expenseCategory)
                                                <tr data-entry-id="{{ $expenseCategory->id }}">
                                                    <td>
                                                    </td>
                                                    <td>
                                                        {{ $expenseCategory->id ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $expenseCategory->expense_category_desc ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $expenseCategory->expense_category_display ?? '' }}
                                                    </td>
                                                    <td>
                                                        @can('expense_category_show')
                                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.expense-categories.show', $expenseCategory->id) }}">
                                                                {{ trans('global.view') }}
                                                            </a>
                                                        @endcan

                                                        @can('expense_category_edit')
                                                            <a id="show-modal" @click="showModal=true;setVal( {{ $expenseCategory->id }},{{ $expenseCategory->expense_category_display }},{{$expenseCategory->expense_category_desc }} )" class="btn btn-xs btn-info">
                                                             {{ trans('global.edit') }}
                                                            </a>
                                                        @endcan

                                                        @can('expense_category_delete')
                                                            <form action="{{ route('admin.expense-categories.destroy', $expenseCategory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                            </form>
                                                        @endcan

                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                 @can('expense_category_create')@
                 <div class="row">
                     <div class="col-lg-12 align-right">
                         <a id="show-modal" data-action="create" @click="showModal=true;setVal( '','','')" class="btn btn-info" class="btn btn-xs btn-info">
                         {{ trans('global.edit') }}
                         </a>
                     </div>
                 </div>
                 @endcan

                 <modal id="modal-section" v-if="showModal" @close="showModal=false">
                 <h3 slot="header">Edit Category Description</h3>
                 <div slot="body">
                     <form method="POST" enctype="multipart/form-data">
                         @method('PUT')
                         @csrf
                         <div class="form-group {{ $errors->has('e_name') ? 'has-error' : '' }}">
                             <label class="required" for="e_name">{{ trans('cruds.expense_categories.fields.category_display') }}</label>
                             <input class="form-control" type="text" name="e_name" id="e_name" :value="this.e_name" required>
                             @if($errors->has('e_name'))
                                 <span class="help-block" role="alert">{{ $errors->first('expense_money') }}</span>
                             @endif
                         </div>
                         <div class="form-group {{ $errors->has('expense_date') ? 'has-error' : '' }}">
                             <label class="required" for="e_desc">{{ trans('cruds.expenseCategory.fields.expense_category_description') }}</label>
                             <input class="form-control" type="text" name="e_desc" id="e_desc" :value="this.e_desc">
                             @if($errors->has('e_desc'))
                                 <span class="help-block" role="alert">{{ $errors->first('expense_date') }}</span>
                             @endif
                         </div>
                         <input type="hidden" disabled class="form-control" id="e_id" name="id" required :value="this.e_id">
                     </form>
                 </div>
                 <div slot="footer">
                     <button class="btn btn-default" @click="showModal = false">
                     Cancel
                     </button>

                     <button class="btn btn-info" @click="editItem()">
                     Update
                     </button>
                 </div>
                 </modal>
             </div>
         </div>
    </div>
    @can('expense_category_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12 align-right">
            <a class="btn btn-success" href="{{ route("admin.expense-categories.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.expenseCategory.title_singular') }}
            </a>
        </div>
    </div>
    @endcan

</div>
@endsection
@section('scripts')
@parent
<script>
$(function () {
    @can('expense_category_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.expense-categories.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                return $(entry).data('entry-id')
            });
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: {ids: ids, _method: 'DELETE'}
                })
                        .done(function () {
                            location.reload()
                        })
            }
        }
    }
    @endcan
})
</script>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>

@endsection
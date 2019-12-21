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
            e_category: '',
            e_money: '',
            e_date: '',
            newItem: { 'category': '','money': '','date': '' }
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
            setVal: function setVal(val_id, val_category, val_money, val_date) {
                this.e_id = val_id;
                this.e_category = val_category;
                this.e_money = val_money;
                this.e_date = val_date;
            },

            createItem: function createItem() {
                var _this = this;
                var input = this.newItem;

                if (input['category'] == '' || input['money'] == '' || input['date'] == '') {
                    this.hasError = false;
                } else {
                    this.hasError = true;
                    axios.post('/vueitems', input).then(function (response) {
                        _this.newItem = { 'category': '', 'money': '', 'date': '' };
                        _this.getVueItems();
                    });
                    this.hasDeleted = true;
                }
            },
            editItem: function editItem() {
                var _this2 = this;

                var i_val_1 = document.getElementById('e_id');
                var n_val_1 = document.getElementById('e_category');
                var a_val_1 = document.getElementById('e_money');
                var p_val_1 = document.getElementById('e_date');

                axios.post('/editexpense/'  + i_val_1.value, { val_1: n_val_1.value, val_2: a_val_1.value, val_3: p_val_1.value }).then(function (response) {
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
                        <span class="row-title-label">{{ trans('cruds.expense.title_singular') }}</span>
                    </div>
                    <div class="col-lg-6">
                        <div class="align-right">Expense Management > {{ Breadcrumbs::render('expense') }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ trans('cruds.expense.title_singular') }} {{ trans('global.list') }}
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class=" table table-bordered table-striped table-hover datatable datatable-Expense">
                                        <thead>
                                            <tr>
                                                <th width="10">

                                                </th>
                                                <th>
                                                    {{ trans('cruds.expense.fields.id') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.expense.fields.expense_category') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.expense.fields.expense_money') }}
                                                </th>
                                                <th>
                                                    {{ trans('cruds.expense.fields.expense_date') }}
                                                </th>
                                                <th>
                                                    &nbsp;
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenses as $key => $expense)
                                                <tr data-entry-id="{{ $expense->id }}">
                                                    <td>

                                                    </td>
                                                    <td>
                                                        {{ $expense->id ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $expense->expense_category->expense_category_desc ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $expense->expense_money ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $expense->expense_date ?? '' }}
                                                    </td>
                                                    <td>
                                                        @can('expense_show')
                                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.expenses.show', $expense->id) }}">
                                                                {{ trans('global.view') }}
                                                            </a>
                                                        @endcan

                                                        @can('expense_edit')
                                                            <a id="show-modal" @click="showModal=true;setVal( {{ $expense->id }},{{ $expense->expense_category->id }},{{ $expense->expense_money }},{{ $expense->expense_date }})" class="btn btn-xs btn-info">
                                                              {{ trans('global.edit') }}
                                                            </a>
                                                        @endcan

                                                        @can('expense_delete')
                                                            <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                @can('role_create')
                <div class="row">
                    <div class="col-lg-12 align-right">
                        <a class="btn btn-success" href="{{ route("admin.expenses.create") }}">
                            {{ trans('global.add') }} {{ trans('cruds.expense.title_singular') }}
                        </a>
                        <button type="button" class="btn-create btn btn-success" data-toggle="modal"  data-id="{{ $id  }}" data-post="data-php" data-action="create">Add Expense</button
                    </div>
                </div>
                @endcan
                <modal id="modal-section" v-if="showModal" @close="showModal=false">
                    <h3 slot="header">Edit Expenses</h3>
                    <div slot="body">
                        <form method="POST" action="{{ route("admin.expenses.update", [$expense->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group {{ $errors->has('expense_category') ? 'has-error' : '' }}">
                                <label class="required" for="e_category">{{ trans('cruds.expense.fields.expense_category') }}</label>
                                <select class="form-control select2" name="e_category" id="e_category" value="this.e_category" required>
                                    @foreach($expense_categories as $id => $expense_category)
                                        <option value="{{ $id }}" {{ "this.e_category" == $id ? 'selected' : '' }}>{{ $expense_category }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('expense_category_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('expense_category_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('e_money') ? 'has-error' : '' }}">
                                <label class="required" for="e_money">{{ trans('cruds.expense.fields.expense_money') }}</label>
                                <input class="form-control" type="number" name="e_money" id="e_money" :value="this.e_money" step="0.01" required>
                                @if($errors->has('expense_money'))
                                    <span class="help-block" role="alert">{{ $errors->first('expense_money') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('expense_date') ? 'has-error' : '' }}">
                                <label class="required" for="expense_date">{{ trans('cruds.expense.fields.expense_date') }}</label>
                                <input class="form-control date" type="date" name="e_date" id="e_date" :value="this.e_date" required>
                                @if($errors->has('expense_date'))
                                    <span class="help-block" role="alert">{{ $errors->first('expense_date') }}</span>
                                @endif
                            </div>
                            <input type="hidden" disabled class="form-control" id="e_id" name="id" required :value="this.e_id">
                        </form?
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
</div>

@endsection
@section('scripts')
@parent
<script>
$(function () {
  @can('expense_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.expenses.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
          var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
              return $(entry).data('entry-id')
          });
          if (confirm('{{ trans('global.areYouSure') }}')) {
            $.ajax({
              headers: {'x-csrf-token': _token},
              method: 'POST',
              url: config.url,
              data: { ids: ids, _method: 'DELETE' }})
              .done(function () { location.reload() })
          }
        }
    }
  @endcan

    $('#modal-section').on('show.bs.modal', function (event) {
      event.stopPropagation();
      moment.updateLocale('en', {
          week: {dow: 1} // Monday is the first day of the week
      });
      $('.date').datetimepicker({
          format: 'YYYY-MM-DD',
          locale: 'en'
      });
  });

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
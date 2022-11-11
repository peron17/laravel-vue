@extends('layouts.admin')
@section('header', 'Books')

@section('css')

@endsection
@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" autocomplete="off" placeholder="search">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" @click="addData()">Add New Book</button>
            </div>
        </div>
        <hr>

    </div>
    <section class="content">
        <div class="container-fluid">
            <h5 class="mb-2">Info Box</h5>
            <div class="row">

                <div class="col-md-3 col-sm-6 col-12" v-for="book in filteredList">
                    <div class="info-box" v-on:click="editData(book)">
                        <span class="info-box-icon bg-info">
                            <i class="far fa-envelope"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@{{ book.title }} (@{{ book.qty }}) </span>
                            <span class="info-box-number">Rp.@{{ numberWithSpace(book.price) }},- <small></small></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
                    <div class="modal-header">
                        <h4 class="modal-title">Form Add/Edit Books</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                        <div class="form-group">
                            <label for="exampleInputName">Isbn</label>
                            <input type="text" class="form-control" name="isbn" id="isbn" :value="book.isbn"
                                placeholder="Enter Isbn" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="email" class="form-control" name="title" id="title" :value="book.title"
                                placeholder="Enter Ttile" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhoneNumber">year</label>
                            <input type="text" class="form-control" name="year" id="year" :value="book.year"
                                placeholder="Enter Year" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhoneNumber">Adress</label>
                            <input type="text" class="form-control" name="adress" id="adress" :value="data.adress"
                                placeholder="Enter Adress" required="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="editStatus"
                            v-on:click="deleteData(book.id)">Delete</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- end modal --}}
@endsection

@section('js')
    <script type="text/javascript">
        var actionUrl = '{{ url('books') }}';
        var apiUrl = '{{ url('api/books') }}';

        var app = new Vue({
            el: '#controller',
            data: {
                books: [],
                book: {},
                editStatus: false,

            },
            mounted: function() {
                this.get_books();
                console.log(this.get_books());
            },
            methods: {
                get_books() {
                    const _this = this;
                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        success: function(data) {
                            _this.books = JSON.parse(data);
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                },
                addData() {
                    this.book = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(book) {
                    this.book = book[row];
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(id) {
                    if (confirm("Are you sure")) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.actionUrl + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            alert('data delete');
                        })
                    }
                },
                numberWithSpace() {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                }
            },
            computed: {
                filteredList() {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().include(this.searchtoLowerCase())
                    })
                }
            }

        });
    </script>


@endsection
@extends('layout')
@section('content')
    <div class="container pt-3" id="dashboard">
<div class="row">
    <div class="col-md-12 text-right">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
        @endif
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" >Add Column</button>
        <a class="btn btn-danger" href="{{route('db.dump')}}" >Dump Database</a>

    </div>
</div>

   <div id="app" class="container">
        <div class="row mt-4">
        @foreach($data['column'] as $col)
            <div class="col">
                <div class="title bg-success text-white p-2 d-flex justify-content-between">
                          <span >
                                {{$col->title}}
                            </span>
                    <span data-toggle="modal" data-target="#addCard" @click="e=>addCard(e,{{$col->id}})"><i class="fas fa-2x fa-plus-circle" ></i></span>

                </div>

                        <list-draggable :cards="{{$col->card}}" :colid="{{$col->id}}"></list-draggable>
            </div>
                @endforeach
    </div>
       <!--    Add column Modal-->
       <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="addModalLabel">Add Column</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form action="{{route('column.save')}}" method="post">
                       @csrf
                       <!-- Title form field -->
                           <div class="form-group">
                               <label for="title">Column Title</label>
                               <input type="text" name="title" id="columnTitle" value="" class="form-control">
                           </div>
                           <button class="btn btn-primary">Add Column</button>
                       </form>
                   </div>

               </div>
           </div>
       </div>

       <!--    Add Card Modal-->
       <div class="modal fade" id="addCard" tabindex="-1" role="dialog" aria-labelledby="addCardLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="addModalLabel">Add Card</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form action="{{route('card.save')}}" method="post">
                           @csrf

                           <input type="hidden" name="column_id" v-model="colId">
                           <!-- Title form field -->
                           <div class="form-group">
                               <label for="title">Card Title</label>
                               <input type="text" name="title" id="columnTitle" value="" class="form-control">
                           </div>
                           <!-- description form field -->
                           <div class="form-group">
                               <label for="description">Description</label>
                               <textarea name="description" id="description" class="form-control"></textarea>
                           </div>
                           <button class="btn btn-primary">Add Card</button>
                       </form>
                   </div>

               </div>
           </div>
       </div>
       <!--    Edit Card Modal-->
       <div class="modal fade" id="editCard" tabindex="-1" role="dialog" aria-labelledby="addCardLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="addModalLabel">Edit Card</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form action="{{route('card.update')}}" method="post">
@csrf
                           @method('patch')
                           <input type="hidden" name="id" id="edit_id">
                           <!-- Title form field -->
                           <div class="form-group">
                               <label for="title">Card Title</label>
                               <input type="text" name="title" id="edit_title" value="" class="form-control">
                           </div>
                           <!-- description form field -->
                           <div class="form-group">
                               <label for="description">Description</label>
                               <textarea name="description" id="edit_description" class="form-control"></textarea>
                           </div>
                           <button class="btn btn-primary">Update Column</button>
                       </form>
                   </div>

               </div>
           </div>
       </div>

   </div>
    </div>
@endsection
@section('script')
    <script>
        $('#editCard').on("show.bs.modal", function (e) {
            $("#edit_id").val($(e.relatedTarget).data('id'));
            $("#edit_title").val($(e.relatedTarget).data('title'));
            $("#edit_description").val($(e.relatedTarget).data('description'));
        });
    </script>

    @endsection

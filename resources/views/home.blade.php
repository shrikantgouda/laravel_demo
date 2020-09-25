@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header form-inline">
                    {{ __('Search records using any filed') }}&nbsp;&nbsp;&nbsp;
                    <input type="text" id="searchtable" name="searchtable" class="form-control form-control-sm" style="width: 400px">
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h3>Click Edit to update the data!</h3>
                            <form action="post" class="form">
                                <input type="text" id="edit_id" name="edit_id" class="form-control input-full form-control-sm" required readonly><br>
                                <input type="text" id="edit_fname" name="edit_fname" class="form-control input-full form-control-sm" required><br>
                                <input type="text" id="edit_lname" name="edit_lname" class="form-control input-full form-control-sm" required><br>
                                <input type="text" id="edit_email" name="edit_email" class="form-control input-full form-control-sm" required><br>
                                <input type="text" id="edit_mobile" name="edit_mobile" class="form-control input-full form-control-sm" required><br>
                                <input type="reset" value="Reset" class="btn btn-dark btn-sm">
                                <button id='updatedata' class="btn btn-sm btn-success">Update</button>
                            </form>
                        </div>
                        <div class="col-md">
                            <table class="table table-responsive table-sm" id='datatable'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($demodata as $demo)
                                        <tr id='rowid_{{$demo->id}}'>
                                            <td id='id_{{$demo->id}}'>{{$demo->id}}</td>
                                            <td id='fname_{{$demo->id}}'>{{$demo->fname}}</td>
                                            <td id='lname_{{$demo->id}}'>{{$demo->lname}}</td>
                                            <td id='email_{{$demo->id}}'>{{$demo->email}}</td>
                                            <td id='mobile_{{$demo->id}}'>{{$demo->mobile}}</td>
                                            <td id='buttontdid_{{$demo->id}}'><button class='btn btn-sm btn-primary editdatabtn' id='{{$demo->id}}'>Edit</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$demodata}}
                        </div>
                    </div>
                    
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customjs')

<script>
$( document ).ready(function() {
    $('.editdatabtn').click(function() 
    {
        $('#edit_id').val(this.id);
        $('#edit_fname').val($('#fname_' + this.id).text());
        $('#edit_lname').val($('#lname_' + this.id).text());
        $('#edit_email').val($('#email_' + this.id).text());
        $('#edit_mobile').val($('#mobile_' + this.id).text());
    });

    $('#updatedata').click(function(e) 
    {
        e.preventDefault();

        id = $('#edit_id').val();
        fname = $('#edit_fname').val();
        lname = $('#edit_lname').val();
        email = $('#edit_email').val();
        mobile = $('#edit_mobile').val();

        if(id.length < 1 || fname.length < 1 || lname.length < 1 || email.length < 1 || mobile.length < 1)
        {
            alert('All Fields are mandatory!');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:"PUT",
            url:'/api/demos/' + id,
            dataType: 'json',
            data:{id:id,fname:fname,lname:lname,email:email,mobile:mobile},
            success: function(data){
                alert(data);
                $('#buttontdid_' + id).parent().prependTo("#datatable");
                return;
            },
            error: function(data){
                alert('Unable to update the data! Kindly Refresh the Page and try again!');
            }
        });
    });
    
    // Search all columns
    $('#searchtable').keyup(function(){
        // Search Text
        var search = $(this).val();

        // Hide all table tbody rows
        $('table tbody tr').hide();

        // Count total search result
        var len = $('table tbody tr:not(.notfound) td:contains("'+search+'")').length;

        if(len > 0){
            // Searching text in columns and show match row
            $('table tbody tr:not(.notfound) td:contains("'+search+'")').each(function(){
            $(this).closest('tr').show();
            });
        }else{
            $('.notfound').show();
        }

    });

    // Case-insensitive searching (Note - remove the below script for Case sensitive search )
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });


});

</script>
@endsection
